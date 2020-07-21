<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyController extends Controller
{
    //
    public function index(){
        return view('welcome');
    }

    public function getEmployee($empid, $lastname){
        return 'You have found '.$empid.' '.$lastname;
    }

    public function showView(){
        return view('sample1');
    }

    public function testMatch(){
        return 'this is a matched output';
    }
}
