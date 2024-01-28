<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * 指示是否自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = true;

    public static function getAll()
    {
        return self::where('status', 1)->get();
    }

    public static function getUserById($id)
    {
        return self::find($id);
    }

    public function getUserList($limit, $name)
    {
        $s_name_eq = $name != '' ? 'like' : '!='; 
        $data = self::where('status', 1)
            ->where('name', $s_name_eq, "%" . $name . "%")
            ->paginate($limit);

        return $data;
    }

    /*
     *新增员工
     */
    public function add($name, $email = '', $addrres, $salary_type, $salary)
    {
        $this->name = $name;
        $this->email = $email;
        $this->addrres = $addrres;
        $this->salary_type = $salary_type;
        $this->salary = $salary;
        $this->uid = session('user_id', 1);
        
        $res = $this->save();

        return $res;
    }

    /*
     *删除员工
     */
    public function del($ids)
    {
        $res = self::whereIn('id', $ids)
            ->update([
                'status' => 0, 
                'uid' => session('user_id', 1),
            ]);

        return $res;
    }    

    //根据id获取员工信息
    public function getUserInfo($id)
    {
        $user = self::where('status', 1)
            ->find($id);

        return $user;
    }

    /*
     *修改员工信息
     */
    public function edit($id, $name, $email = '', $addrres, $salary_type, $salary)
    {
        $data = [
            'name' => $name,
            'email' => $email,
            'addrres' => $addrres,
            'salary_type' => $salary_type,
            'salary' => $salary,
            'uid' => session('user_id', 1),
        ];
        $res = self::where('id', $id)
            ->update($data);

        return $res;
    }
}
