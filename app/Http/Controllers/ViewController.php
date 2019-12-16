<?php

namespace App\Http\Controllers;

class ViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewUsers()
    {
        return view('users.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewSections()
    {
        return view('sections.index');
    }    
}
