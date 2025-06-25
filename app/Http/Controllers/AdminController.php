<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Committee;
use App\Models\Province;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view("admin.dashboard");
    }
    public function committee()
    {
        $committees = Committee::with('user')->get();
        return view("admin.committee", compact("committees"));
    }

    public function addCommittee()
    {
        $provinces = Province::where('region_code', 8)->get();
        return view("admin.add_committee", compact("provinces"));
    }

    public function chapter()
    {
        $chapters = Chapter::all();
        return view("admin.chapter", compact("chapters"));
    }


    public function addChapter()
    {
        $committees = Committee::with('user')->get();
        $provinces = Province::where('region_code', 8)->get();
        return view("admin.add_chapter", compact("committees", "provinces"));
    }
}
