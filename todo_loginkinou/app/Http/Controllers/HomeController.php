<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $registerLink = route('users.create'); // users.create ルートの URL を生成
        return view('welcome', ['registerLink' => $registerLink]);
    }
}