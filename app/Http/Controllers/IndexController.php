<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base;

class IndexController extends Base
{
    public function index()
    {
    	return view('Index', $this->data);
    }
}
