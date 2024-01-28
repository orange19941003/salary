<?php
/*
 *后台用户管理
 */

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Enums\admin\AdminEnum;
use App\Http\Controllers\Base;

class AdminController extends Base
{
    public function index()
    {
    	return view('admin/index', $this->data);
    }

    public function list()
    {
    	$limit = input('limit');
    	$name = input('name', '');
    	$adminModel = new Admin; 
    	$data = $adminModel->getAdminList($limit, $name);
    	$data = $data->toArray();
    	$count = $data['total'] ? $data['total'] : 0;
    	$data = $data['data'] ? $data['data'] : [];
    	$return = [];
    	$return['count'] = $count;
    	$return['data'] = $data;
    	$return['msg'] = '';
    	$return['code'] = 0;

    	return $return;
    }

    public function add()
    {
    	return view('admin/add', $this->data);
    }

    public function addPost()
    {
    	$name = input('name', '');
        if (empty($name))
        {
        	return $this->error('用户名不能为空');
        }
        $pwd = input('pwd');
        if (!preg_match('/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,16}/', $pwd) && $pwd != '')
        {
            return $this->error('密码必须同时含有数字、大小写字母，且长度要在8-16位之间');
        }
        $adminModel = new Admin;
        if ($adminModel->where('name', $name)->where('status', 1)->exists())
        {
            return $this->error("用户名重复");
        }
        $res = $adminModel->add($name, $pwd);
        if (!$res)
        {
        	return $this->error(AdminEnum::ADD_ERROR);
        }

        return $this->success(AdminEnum::ADD_SUCCESS);
    }

    public function edit($id)
    {
    	$adminModel = new Admin;
        $admin = $adminModel->getAdminInfo($id);
        if (!$admin)
        {
        	return $this->error("无效的id");
        }
        //用户的角色
        $this->data['admin'] = $admin;

        return view('admin/edit', $this->data);
    }

    public function editPost($id)
    {
    	$name = input('name', '');
        if (empty($name))
        {
        	return $this->error('用户名不能为空');
        }
        $pwd = input('pwd', '');
        if (!preg_match('/(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{8,16}/', $pwd) && $pwd != '')
        {
            return $this->error('密码必须同时含有数字、大小写字母，且长度要在8-16位之间');
        }
        $adminModel = new Admin;
        if ($adminModel->where('name', $name)->where('id', '!=', $id)->where('status', 1)->exists())
        {
            return $this->error("用户名重复");
        }
        $res = $adminModel->edit($id, $name, $pwd);
        if (!$res)
        {
            return $this->error(AdminEnum::EDIT_ERROR);
        }

        return $this->success(AdminEnum::EDIT_SUCCESS);
    }

    public function del($ids)
    {
    	$ids = explode('|', $ids);
    	$adminModel = new Admin;
        $res = $adminModel->del($ids);
        if (!$res)
        {
            return $this->error(AdminEnum::DELETE_ERROR);
        }

        return $this->success(AdminEnum::DELETE_SUCCESS);	
    }
}
