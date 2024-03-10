<?php
/*
 *后台用户管理
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Base;
use App\Http\Enums\admin\AdminEnum;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Cache;

class UserController extends Base
{
    public function index()
    {
    	return view('user/index', $this->data);
    }

    public function list()
    {
    	$limit = input('limit');
    	$name = input('name', '');
    	$userModel = new User(); 
    	$data = $userModel->getUserList($limit, $name);
    	$data = $data->toArray();
    	$count = $data['total'] ? $data['total'] : 0;
    	$data = $data['data'] ? $data['data'] : [];
        $data = array_map(function($val){
            $cny_to_usd_rate = Cache::get('cny_to_usd_rate', '');
            if ($cny_to_usd_rate == '')
            {
                $msg = '';
                $cny_to_usd_rate = nowapiRequest($msg);
                $cny_to_usd_rate = round($cny_to_usd_rate['rate'], 2);
                if ($msg == '')
                {
                    Cache::set('cny_to_usd_rate', $cny_to_usd_rate, 600);
                }
            }
            $val['cny_to_usd_rate'] = $cny_to_usd_rate;
            $val['usd_salary'] = round($val['salary'] / $cny_to_usd_rate, 2);
            $val['salary_type_text'] = AdminEnum::$GAlARY_TYPE_OPTIONS[$val['salary_type']] ?? '';

            return $val;
        }, $data);
    	$return = [];
    	$return['count'] = $count;
    	$return['data'] = $data;
    	$return['msg'] = '';
    	$return['code'] = 0;

    	return $return;
    }

    public function add()
    {
    	return view('user/add', $this->data);
    }

    public function addPost()
    {
    	$name = input('name', '');
        if (empty($name))
        {
        	return $this->error('用户名不能为空');
        }
      
        $userModel = new User;
        if ($userModel->where('name', $name)->where('status', 1)->exists())
        {
            return $this->error("员工名重复");
        }
        $email = input('email', '');
        $addrres = input('addrres', '');
        if (empty($addrres))
        {
            return $this->error("请填写充币地址");
        }
        $salary_type = input('salary_type', 0);
        if (!key_exists($salary_type, AdminEnum::$GAlARY_TYPE_OPTIONS))
        {
            return $this->error("记薪方式错误");
        }
        $salary = input('salary', 0);
        if ($salary < 0)
        {
            return $this->error("请填写大于0的薪水");
        }
        $res = $userModel->add($name, $email, $addrres, $salary_type, $salary);
        if (!$res)
        {
        	return $this->error(AdminEnum::ADD_ERROR);
        }

        return $this->success(AdminEnum::ADD_SUCCESS);
    }

    public function edit($id)
    {
    	$userModel = new user;
        $user = $userModel->getUserInfo($id);
        if (!$user)
        {
        	return $this->error("无效的id");
        }
        //用户的角色
        $this->data['user'] = $user;

        return view('user/edit', $this->data);
    }

    public function editPost($id)
    {
    	$name = input('name', '');
        if (empty($name))
        {
        	return $this->error('用户名不能为空');
        }
      
        $userModel = new User;
        if ($userModel->where('name', $name)->where('status', 1)->where('id', '!=', $id)->exists())
        {
            return $this->error("员工名重复");
        }
        $email = input('email', '');
        $addrres = input('addrres', '');
        if (empty($addrres))
        {
            return $this->error("请填写充币地址");
        }
        $salary_type = input('salary_type', 0);
        if (!key_exists($salary_type, AdminEnum::$GAlARY_TYPE_OPTIONS))
        {
            return $this->error("记薪方式错误");
        }
        $salary = input('salary', 0);
        if ($salary < 0)
        {
            return $this->error("请填写大于0的薪水");
        }
        $res = $userModel->edit($id,  $name, $email, $addrres, $salary_type, $salary);
        if (!$res)
        {
            return $this->error(AdminEnum::EDIT_ERROR);
        }

        return $this->success(AdminEnum::EDIT_SUCCESS);
    }

    public function del($ids)
    {
    	$ids = explode('|', $ids);
    	$userModel = new user;
        $res = $userModel->del($ids);
        if (!$res)
        {
            return $this->error(AdminEnum::DELETE_ERROR);
        }

        return $this->success(AdminEnum::DELETE_SUCCESS);	
    }
}
