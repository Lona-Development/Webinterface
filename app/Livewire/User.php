<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use LonaDB\Client;

class User extends Component
{
    public string $title;
    public ?string $route;

    public string $loginName = "";
    public string $loginPassword = "";

    public string $warning = "";
    public string $success = "";

    public bool $users = false;
    public ?string $user = null;
    public string $userRole = "";

    public string $permission = "";
    public bool $value = false;
    
    public function render(Request $request)
    {
        $file = file_get_contents("../config.json");
        $json = json_decode($file, true);
        $LonaDB = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], $json['LonaDB']['username'], $json['LonaDB']['password']);

        $tempUser = $this->get_string_between($request, "GET /user/", " HTTP");
        if($tempUser) $this->user = $tempUser;

        $this->route = "user";
        $this->title = $this->user . " | LonaDB";
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

                $permissions = $LonaDB->getPermissionsRaw($this->user);
                $permissionsOwn = $LonaDB->getPermissionsRaw(session('loginName'));

                $this->permissionList = $permissions['list'];
                $this->userRole = $permissions['role'];

                $this->roles = false;
                if($permissionsOwn['role'] === 'Superuser') $this->roles = true;
        
                $this->users = false;
                if($deleteUser['result'] || $createUser['result']) $this->users = true;
        
                $this->tables = false;
                if($createTable['result']) $this->tables = true;
            }
        }

        return view('livewire.user')->layoutData([
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

    public function promoDemo(){
        $this->warning = "";
        $this->success = "";

        $file = file_get_contents("../config.json");
        $json = json_decode($file, true);
        $LonaDB = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], session("loginName"), session("loginPassword"));
        $LonaDBSU = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], $json['LonaDB']['username'], $json['LonaDB']['password']);

        if($this->userRole === 'Administrator'){
            $newRole = "User";
            $status = "demoted";
        }else{
            $newRole = "Administrator";
            $status = "promoted";
        }

        $role = $LonaDB->eval("\$LonaDB->UserManager->SetRole('" . $this->user . "', '" . $newRole . "'); return 'ok';");

        if(!$role['success']){
            switch($role['err']){
                case "no_permission":
                    $this->warning = "You are not allowed to manage roles";
                    break;
                default:
                    $this->warning = "An error has occured";
                    break;
            }

            $this->dispatch("refresh");
        }else{
            $this->success = "User '" . $this->user . "' has been " . $status;

            $this->permissionList = $LonaDBSU->getPermissionsRaw($this->user);
            $this->userRole = $this->permissionList['role'];
            $this->permissionList = $this->permissionList['list'];

            $this->dispatch("refresh");
        }
    }

    public function addPermissionModal(){
        $this->permission = "";
        $this->dispatch('showCreate');
    }

    public function addPermission(){
        $this->dispatch('hideCreate');

        $this->warning = "";
        $this->success = "";

        if($this->permission === "") {
            $this->warning = "No permission was provided to the function";
            $this->dispatch("refresh");
        }else{
            $file = file_get_contents("../config.json");
            $json = json_decode($file, true);
            $LonaDB = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], session("loginName"), session("loginPassword"));
            $LonaDBSU = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], $json['LonaDB']['username'], $json['LonaDB']['password']);
            $permission = $LonaDB->addPermission($this->user, $this->permission);

            if(!$permission['success']){
                switch($permission['err']){
                    case "no_permission":
                        $this->warning = "You are not allowed to manage permissions";
                        break;
                    default:
                        $this->warning = "An error has occured";
                        break;
                }
    
                $this->dispatch("refresh");
            }else{
                $this->success = "Permission '" . $this->permission . "' has been removed";

                $this->permissionList = $LonaDBSU->getPermissionsRaw($this->user);
                $this->permissionList = $this->permissionList['list'];
    
                $this->dispatch("refresh");
            }
        }
    }

    public function removePermissionModal(string $permission){
        $this->permission = $permission;
        $this->dispatch('showDelete');
    }

    public function removePermission(){
        $this->dispatch('hideDelete');

        $this->warning = "";
        $this->success = "";

        if($this->permission === "") {
            $this->warning = "No permission was provided to the function";
            $this->dispatch("refresh");
        }else{
            $file = file_get_contents("../config.json");
            $json = json_decode($file, true);
            $LonaDB = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], session("loginName"), session("loginPassword"));
            $LonaDBSU = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], $json['LonaDB']['username'], $json['LonaDB']['password']);
            $permission = $LonaDB->removePermission($this->user, $this->permission);

            if(!$permission['success']){
                switch($permission['err']){
                    case "no_permission":
                        $this->warning = "You are not allowed to manage permissions";
                        break;
                    default:
                        $this->warning = "An error has occured";
                        break;
                }
    
                $this->dispatch("refresh");
            }else{
                $this->success = "Permission '" . $this->permission . "' has been removed";

                $this->permissionList = $LonaDBSU->getPermissionsRaw($this->user);
                $this->permissionList = $this->permissionList['list'];
    
                $this->dispatch("refresh");
            }
        }
    }
}
