<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use LonaDB\Client;

class Tables extends Component
{
    public string $title;
    public ?string $route;

    public string $loginName = "";
    public string $loginPassword = "";

    public string $warning = "";
    public string $success = "";

    public bool $tables = false;
    public bool $users = false;
    public array $tableList = [];
    public string $deleteTableName = "";

    public string $tableName = "";
    
    public function render()
    {
        $file = file_get_contents("../config.json");
        $json = json_decode($file, true);
        $LonaDB = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], $json['LonaDB']['username'], $json['LonaDB']['password']);

        $this->route = "index";
        $this->title = "Home | LonaDB";
        $users = [];

        if((!session("loginName") || !session("loginPassword")) && $this->route !== "login") {
            redirect()->to("/login");
        }else{
            $login = $LonaDB->checkPassword(session("loginName"), session("loginPassword"));

            if(!$login['passCheck']) {
                redirect()->to("/logout");
            }else{
                $createTable = $LonaDB->checkPermission(session('loginName'), "table_create");
                $createUser = $LonaDB->checkPermission(session('loginName'), "user_create");
                $deleteUser = $LonaDB->checkPermission(session('loginName'), "user_delete");
        
                $this->users = false;
                if($deleteUser['result'] || $createUser['result']) $this->users = true;
        
                $this->tables = false;
                if($createTable['result']) $this->tables = true;
        
                $this->tableList = $LonaDB->getTables(session('loginName'));
                $this->tableList = $this->tableList['tables'];
            }
        }

        return view('livewire.index')->layoutData([
            "title" => $this->title,
            "route" => $this->route,
            "username" => session('loginName'),
            "users" => $this->users,
            "tables" => $this->tables
        ]);
    }

    public function newTable(){
        $this->tableName = "";
        $this->dispatch('showCreate');
    }

    public function deleteTableModal(string $name = ""){
        $this->deleteTableName = $name;
        $this->dispatch('showDelete');
    }

    public function deleteTable(){
        $this->dispatch('hideDelete');

        $name = $this->deleteTableName;
        $this->warning = "";
        $this->success = "";

        if($name === "") {
            $this->warning = "No table name was provided to the function";
            $this->dispatch("refresh");
        }else{
            $file = file_get_contents("../config.json");
            $json = json_decode($file, true);
            $LonaDB = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], session("loginName"), session("loginPassword"));
            $LonaDBSU = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], $json['LonaDB']['username'], $json['LonaDB']['password']);
            $table = $LonaDB->deleteTable($name);

            if(!$table['success']){
                switch($table['err']){
                    case "no_permission":
                        $this->warning = "You are not allowed to delete tables";
                        break;
                    case "not_root":
                        $this->warning = "Only the Root user is allowed to delete System tables";
                        break;
                    case "table_missing":
                        $this->warning = "Table not found";
                        break;
                    case "not_table_owner":
                        $this->warning = "You are not the table owner";
                        break;
                    default:
                        $this->warning = "An error has occured";
                        break;
                }
    
                $this->dispatch("refresh");
            }else{
                $this->success = "Table '" . $name . "' has been deleted";
    
                $this->tableList = $LonaDBSU->getTables(session('loginName'));
                $this->tableList = $this->tableList['tables'];
    
                $this->dispatch("refresh");
            }
        }
    }

    public function viewTable(string $table){
        redirect()->to('/table/' . $table);
    }

    public function createTable(){
        $this->dispatch('hideCreate');

        $this->warning = "";
        $this->success = "";

        $file = file_get_contents("../config.json");
        $json = json_decode($file, true);
        $LonaDB = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], session("loginName"), session("loginPassword"));
        $LonaDBSU = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], $json['LonaDB']['username'], $json['LonaDB']['password']);
        $table = $LonaDB->createTable($this->tableName);

        if(!$table['success']){
            switch($table['err']){
                case "no_permission":
                    $this->warning = "You are not allowed to create tables";
                    break;
                case "not_root":
                    $this->warning = "Only the Root user is allowed to create System tables";
                    break;
                case "table_exists":
                    $this->warning = "A table with that name already exists. Maybe another user created it";
                    break;
                default:
                    $this->warning = "An error has occured";
                    break;
            }

            $this->dispatch("refresh");
        }else{
            $this->success = "Table '" . $this->tableName . "' has been created";

            $this->tableList = $LonaDBSU->getTables(session('loginName'));
            $this->tableList = $this->tableList['tables'];

            $this->dispatch("refresh");
        }
    }
}
