<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view('admin.index');
    }
    public function write(){
        return view('admin.write');
    }
    public function article(){
        return view('admin.article_manage');
    }

}
