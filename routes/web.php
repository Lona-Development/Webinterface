<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Livewire\Tables;
use App\Livewire\Table;
use App\Livewire\Users;
use App\Livewire\User;
use App\Livewire\Login;

require(__DIR__ . "/../LonaDB/Client.php");

Route::get('/login', Login::class)->name("login");

Route::post('/logout', function (Request $request) {
    if ($request->hasSession()) {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    return redirect()->to('/login');
})->name("logout");

Route::get('/', Tables::class)->name("tables");

Route::get('/table/{table}', Table::class)->name('table');

Route::get('/users', Users::class)->name("users");

Route::get('/user/{user}', User::class)->name("user");