<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Base extends Controller
{
	public $data;
    protected $admin_id;
  	
  	public function __construct(Request $request)
  	{
        $this->data = [];
        $this->middleware(function ($request, $next) {
            $this->admin_id = $request->session()->get('admin_id', []);

            return $next($request);
        });
        
  	}

  	/*
  	 *统一失败函数
  	 */
  	protected function error(string $msg) : array
  	{
  		$arr = [];
  		$arr['code'] = 401;
  		$arr['msg'] = $msg;

  		return $arr; 
  	}

  	/*
  	 *统一成功函数
  	 */
  	protected function success(string $msg) : array
  	{
  		$arr = [];
  		$arr['code'] = 200;
  		$arr['msg'] = $msg;

  		return $arr; 
  	}
}
