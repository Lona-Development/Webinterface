<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Route;

use LonaDB\Client;

class Login extends Component
{
    public string $title;
    public ?string $route;

    public string $loginName = "";
    public string $loginPassword = "";

    public string $warning = "";
    public string $success = "";
    
    public function render()
    {
        $this->route = "login";
        $this->title = "Login | LonaDB";

        if((session("loginName") && session("loginPassword"))) {
            redirect()->to("/");
        }

        return view('livewire.login')->layoutData([
            "title" => $this->title,
            "route" => $this->route,
            "warning" => $this->warning,
            "success" => $this->success,
            "users" => false,
            "tables" => false
        ]);
    }

    public function login(){
        if($this->loginName === "" || $this->loginPassword === ""){
            $this->warning = "Please check the username and password";
            $this->dispatch('$refresh');
        }else{
            $file = file_get_contents("../config.json");
            $json = json_decode($file, true);
            $LonaDB = new Client($json['LonaDB']['host'], $json['LonaDB']['port'], $json['LonaDB']['username'], $json['LonaDB']['password']);
            $login = $LonaDB->checkPassword($this->loginName, $this->loginPassword);

            if(!$login['passCheck']){
                $this->warning = "Username or password is not right";

                $this->loginName = "";
                $this->loginPassword = "";
                
                $this->dispatch('$refresh');
            }else{
                session()->put("loginName", $this->loginName);
                session()->put("loginPassword", $this->loginPassword);
                redirect()->to("/");
            }
        }
    }
}
