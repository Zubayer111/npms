<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrescritionsController extends Controller
{
    public function newPrescritionsPage(){
        return view("backend.pages.prescriptions.new-prescriptions-page");
    }
}
