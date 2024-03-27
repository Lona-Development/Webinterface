<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use LonaDB\Client;

class Users extends Component
{
    public string $title;
    public ?string $route;

    public string $loginName = "";
    public string $loginPassword = "";

    public string $warning = "";
    public string $success = "";

    public bool $users = false;
    public array $userList = [];
    public string $deleteUserName = "";

    public string $userName = "";
    public string $userPassword = "";
    
    public function render()
    {
        $file = file_get_contents("../config.json");
        $json = json_decode($file, true);
        $LonaDB = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], $json['LonaDB']['username'], $json['LonaDB']['password']);

        $this->route = "users";
        $this->title = "Users | LonaDB";
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
        
                $this->userList = $LonaDB->getUsers();
                $this->userList = $this->userList['users'];

                if(!$this->users) redirect()->to("/");
            }
        }

        return view('livewire.users')->layoutData([
            "title" => $this->title,
            "route" => $this->route,
            "username" => session('loginName'),
            "users" => $this->users,
            "tables" => $this->tables
        ]);
    }

    public function newUser(){
        $this->userName = "";
        $this->userPassword = "";
        $this->dispatch('showCreate');
    }

    public function deleteUserModal(string $name = ""){
        $this->deleteUserName = $name;
        $this->dispatch('showDelete');
    }

    public function deleteUser(){
        $this->dispatch('hideDelete');

        $name = $this->deleteUserName;
        $this->warning = "";
        $this->success = "";

        if($name === "") {
            $this->warning = "No user name was provided to the function";
            $this->dispatch("refresh");
        }else{
            $file = file_get_contents("../config.json");
            $json = json_decode($file, true);
            $LonaDB = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], session("loginName"), session("loginPassword"));
            $LonaDBSU = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], $json['LonaDB']['username'], $json['LonaDB']['password']);
            $user = $LonaDB->deleteUser($name);

            if(!$user['success']){
                switch($user['err']){
                    case "no_permission":
                        $this->warning = "You are not allowed to delete users";
                        break;
                    case "user_doesnt_exist":
                        $this->warning = "User not found";
                        break;
                    default:
                        $this->warning = "An error has occured";
                        break;
                }
    
                $this->dispatch("refresh");
            }else{
                $this->success = "User '" . $name . "' has been deleted";
    
                $this->userList = $LonaDBSU->getUsers();
                $this->userList = $this->userList['users'];
    
                $this->dispatch("refresh");
            }
        }
    }

    public function viewUser(string $user){
        redirect()->to('/user/' . $user);
    }

    public function createUser(){
        $this->dispatch('hideCreate');

        $this->warning = "";
        $this->success = "";

        if($this->userName === "" || $this->userPassword === "") {
            $this->warning = "No username or password provided";
            $this->dispatch("refresh");
            return;
        }

        $file = file_get_contents("../config.json");
        $json = json_decode($file, true);
        $LonaDB = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], session("loginName"), session("loginPassword"));
        $LonaDBSU = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], $json['LonaDB']['username'], $json['LonaDB']['password']);
        $user = $LonaDB->createUser($this->userName, $this->userPassword);

        if(!$user['success']){
            switch($user['err']){
                case "no_permission":
                    $this->warning = "You are not allowed to create users";
                    break;
                case "user_exist":
                    $this->warning = "A user with that name already exists";
                    break;
                default:
                    $this->warning = "An error has occured";
                    break;
            }

            $this->dispatch("refresh");
        }else{
            $this->success = "User '" . $this->userName . "' has been created";

            $this->userList = $LonaDBSU->getUsers();
            $this->userList = $this->userList['users'];

            $this->dispatch("refresh");
        }
    }
}
