<?php
/*
 *后台用户管理
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Base;
use App\Http\Enums\admin\AdminEnum;
use App\Models\Salary;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class SalaryController extends Base
{
    public function index()
    {
        $users = User::getAll();
        $this->data['users'] = $users;
        $user_id = input('user_id', 0);
        $this->data['user_id'] = $user_id;
    	return view('salary/index', $this->data);
    }

    public function list()
    {
    	$limit = input('limit');
    	$user_id = input('user_id', 0);
    	$salaryModel = new salary(); 
    	$data = $salaryModel->getSalaryList($limit, $user_id);
    	$data = $data->toArray();
    	$count = $data['total'] ? $data['total'] : 0;
    	$data = $data['data'] ? $data['data'] : [];
        $data = array_map(function($val){
            $val['name'] = User::getUserById($val['user_id'])['name'] ?? '';
            $val['addrres'] = User::getUserById($val['user_id'])['addrres'] ?? '';

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
        $users = User::getAll();
        $this->data['users'] = $users;
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
        $this->data['cny_to_usd_rate'] = $cny_to_usd_rate;

    	return view('salary/add', $this->data);
    }

    public function addPost()
    {
    	$user_id = input('user_id', '');
        if (empty($user_id))
        {
        	return $this->error('请选择工资发放员工');
        }
        $amount = input('amount', 0);
        if ($amount < 0)
        {
            return $this->error("请填写工资");
        }
        $salary = input('salary', 0);
        if ($salary < 0)
        {
            return $this->error("请填写大于0的薪水");
        }
        $cny_to_usd_rate = input('cny_to_usd_rate', 0);
        $usd_salary = input('usd_salary', 0);
        $salary_date = input('salary_date', '');
        $start_date = '';
        $end_date = '';
        if ($salary_date !== '') {
            $date_arr   = explode(' - ', $salary_date);
            $start_date = $date_arr[0];
            $end_date = $date_arr[1];
        } else {
            return $this->error("请选择薪水发放周时间");
        }
        $salaryModel = new Salary();
        $res = $salaryModel->add($user_id, $amount, $cny_to_usd_rate, $usd_salary, $start_date, $end_date);
        if (!$res)
        {
        	return $this->error(AdminEnum::ADD_ERROR);
        }

        return $this->success(AdminEnum::ADD_SUCCESS);
    }

    public function edit($id)
    {
        $users = User::getAll();
        $this->data['users'] = $users;
        $user_map = array_column($users->toArray(), 'addrres', 'id');
    	$salaryModel = new salary;
        $salary = $salaryModel->getsalaryInfo($id);
        if (!$salary)
        {
        	return $this->error("无效的id");
        }
        $salary['addrres'] = $user_map[intval($salary['user_id'])] ?? '';
        $salary['salary_date'] = substr($salary['start_date'], 0, 10) . ' - ' . substr($salary['end_date'], 0, 10); 
        //用户的角色
        $this->data['salary'] = $salary;

        return view('salary/edit', $this->data);
    }

    public function editPost($id)
    {
        $salaryModel = new Salary();
        if (empty($id))
        {
            return $this->error("参数错误");
        }
    	$user_id = input('user_id', '');
        if (empty($user_id))
        {
        	return $this->error('请选择工资发放员工');
        }
        $amount = input('amount', 0);
        if ($amount < 0)
        {
            return $this->error("请填写工资");
        }
        $salary = input('salary', 0);
        if ($salary < 0)
        {
            return $this->error("请填写大于0的薪水");
        }
        $cny_to_usd_rate = input('cny_to_usd_rate', 0);
        $usd_salary = input('usd_salary', 0);
        $salary_date = input('salary_date', '');
        $start_date = '';
        $end_date = '';
        if ($salary_date !== '') {
            $date_arr   = explode(' - ', $salary_date);
            $start_date = $date_arr[0];
            $end_date = $date_arr[1];
        } else {
            return $this->error("请选择薪水发放周时间");
        }
        $res = $salaryModel->edit($id, $amount, $cny_to_usd_rate, $usd_salary, $start_date, $end_date);
        if (!$res)
        {
            return $this->error(AdminEnum::EDIT_ERROR);
        }

        return $this->success(AdminEnum::EDIT_SUCCESS);
    }

    public function del($ids)
    {
    	$ids = explode('|', $ids);
    	$salaryModel = new salary;
        $res = $salaryModel->del($ids);
        if (!$res)
        {
            return $this->error(AdminEnum::DELETE_ERROR);
        }

        return $this->success(AdminEnum::DELETE_SUCCESS);	
    }
}
