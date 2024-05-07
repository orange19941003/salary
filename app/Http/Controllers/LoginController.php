<?php

namespace App\Http\Controllers;

use App\Http\Enums\admin\AdminEnum;
use App\Models\Admin;

class LoginController extends Base
{
    public function get()
    {
    	return view('login/index', $this->data);
    }

    public function post()
    {
    	$name = input('name');
    	$password = input('pwd');
    	$o_admin = Admin::where('name', $name)
    		->where('status', 1)
    		->first();
    	if (!$o_admin)
    	{
    		return $this->error(AdminEnum::LOGIN_NAME_ERROR);
    	}
    	$error_pwd = session('error_pwd', 0);
    	if ($o_admin->pwd != md5($password . config('app.pwd_salt')))
    	{
    		session(['error_pwd' => $error_pwd + 1]);

    		// return $this->error(AdminEnum::LOGIN_PWD_ERROR);
    	}
    	if ($error_pwd >= 5)
		{
			$o_admin->locktime = date("Y-m-d H:i:s", time() + 10*60);
			$o_admin->save();

			return $this->error(AdminEnum::LOGIN_PWD_FIVE_ERROR . $o_admin->locktime);
		}
        $id = $o_admin->id;
    	session(['admin_id' => $id, 'error_pwd' => 0, 'admin_name' => $o_admin->name]);

    	return $this->success(AdminEnum::LOGIN_SUCCESS);
    }


    //退出系统
    public function out()
    {
    	session(['admin_id' => null]);

    	return redirect('login');
    }
}
