<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use LonaDB\Client;

class Table extends Component
{    
    public string $title;
    public ?string $route;

    public string $loginName = "";
    public string $loginPassword = "";

    public string $warning = "";
    public string $success = "";

    public bool $users = false;
    public ?string $table = null;

    public string $key = "";
    public string $value = "";

    public function render(Request $request)
    {
        $file = file_get_contents("../config.json");
        $json = json_decode($file, true);
        $LonaDB = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], $json['LonaDB']['username'], $json['LonaDB']['password']);
    
        $tempTable = $this->get_string_between($request, "GET /table/", " HTTP");
        if($tempTable) $this->table = $tempTable;

        $this->route = "table";
        $this->title =  $this->table . " | LonaDB";
        $users = [];
    
        if ((!session("loginName") || !session("loginPassword")) && $this->route !== "login") {
            return redirect()->to("/login"); // Use return to properly return redirect
        } else {
            $login = $LonaDB->checkPassword(session("loginName"), session("loginPassword"));
    
            if (!$login['passCheck']) {
                return redirect()->to("/logout"); // Use return to properly return redirect
            } else {
                $createTable = $LonaDB->checkPermission(session('loginName'), "table_create");
                $createUser = $LonaDB->checkPermission(session('loginName'), "user_create");
                $deleteUser = $LonaDB->checkPermission(session('loginName'), "user_delete");
    
                $this->users = false;
                if ($deleteUser['result'] || $createUser['result']) {
                    $this->users = true;
                }
    
                $this->tables = false;
                if ($createTable['result']) {
                    $this->tables = true;
                }
    
                if($this->table){
                    $this->tableData = $LonaDB->getTableData($this->table);
                    if(!$this->tableData['success']) redirect()->to('/');
                    else{
                        $this->tableData = $this->tableData['data'];
                    }
                }
            }
        }
    
        return view('livewire.table')->layoutData([ // Change view to 'livewire.table'
            "title" => $this->title,
            "route" => $this->route,
            "username" => session('loginName'),
            "users" => $this->users,
            "tables" => $this->tables
        ]);
    }

    public function get_string_between($string, $start, $end){
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
    
    public function checkjson(string $value){
        return json_validate($value);
    }

    public function checkbool (string $value){
        switch(strtolower($value)){
            case "false":
                return false;
                break;
            case "true":
                return true;
                break;
            default:
                return "not a bool";
                break;
        }
    }
        
    public function getVariable(string $value){
        $bool = $this->checkbool($value);
        $float = is_float($value);
        $json = $this->checkjson($value);
        
        if($bool !== "not a bool") return $bool;
        if($float) return floatval($value);
        if($json) return json_decode($value, true);
        return $value;
    }

    public function newVariable(){
        $this->key = "";
        $this->value = "";
        $this->dispatch('showCreate');
    }

    public function editKey(string $key){
        $this->key = $key;
        $this->value = "";
        $this->dispatch('showCreate');
    }

    public function deleteKey(string $key){
        $this->key = $key;
        $this->dispatch('showDelete');
    }

    public function deleteVariable(){
        $this->dispatch('hideDelete');

        $this->warning = "";
        $this->success = "";

        if($this->key === "") {
            $this->warning = "No key was provided to the function";
            $this->dispatch("refresh");
        }else{
            $file = file_get_contents("../config.json");
            $json = json_decode($file, true);
            $LonaDB = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], session("loginName"), session("loginPassword"));
            $LonaDBSU = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], $json['LonaDB']['username'], $json['LonaDB']['password']);
            $variable = $LonaDB->delete($this->table, $this->key);

            if(!$variable['success']){
                switch($variable['err']){
                    case "no_permission":
                        $this->warning = "You are not allowed to delete users";
                        break;
                    default:
                        $this->warning = "An error has occured";
                        break;
                }
    
                $this->dispatch("refresh");
            }else{
                $this->success = "Variable '" . $this->key . "' has been deleted";

                $this->tableData = $LonaDBSU->getTableData($this->table);
                $this->tableData = $this->tableData['data'];
    
                $this->dispatch("refresh");
            }
        }
    }

    public function createVariable(){
        $this->dispatch('hideCreate');

        $this->warning = "";
        $this->success = "";

        if($this->key === "" || $this->value === "") {
            $this->warning = "No key or value provided";
            $this->dispatch("refresh");
            return;
        }

        $file = file_get_contents("../config.json");
        $json = json_decode($file, true);
        $LonaDB = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], session("loginName"), session("loginPassword"));
        $LonaDBSU = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], $json['LonaDB']['username'], $json['LonaDB']['password']);
        $variable = $LonaDB->set($this->table, $this->key, $this->getVariable($this->value));

        if(!$variable['success']){
            switch($variable['err']){
                case "missing_permissions":
                    $this->warning = "You are not allowed to do this";
                    break;
                case "user_exist":
                    $this->warning = "A user with that name already exists";
                    break;
                default:
                    $this->warning = "An error has occured: " . $this->getVariable($this->value);
                    break;
            }

            $this->dispatch("refresh");
        }else{
            $this->success = "Variable '" . $this->key . "' has been created";

            $this->tableData = $LonaDBSU->getTableData($this->table);
            $this->tableData = $this->tableData['data'];

            $this->dispatch("refresh");
        }
    }
}
