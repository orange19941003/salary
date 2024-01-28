<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    /**
     * 指示是否自动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    public static function getAll()
    {
        return self::where('status', 1)->get();
    }

    public static function getAdminById($id)
    {
        return self::find($id);
    }

    public function getAdminList($limit, $name)
    {
        $s_name_eq = $name != '' ? 'like' : '!='; 
        $data = self::where('status', 1)
            ->where('name', $s_name_eq, "%" . $name . "%")
            ->paginate($limit);

        return $data;
    }

    /*
     *新增管理员
     */
    public function add($name, $pwd)
    {
        $this->name = $name;
        $this->add_time = date("Y-m-d H:i:s");
        $this->edit_time = date("Y-m-d H:i:s");
        $this->locktime = date("Y-m-d H:i:s");
        $this->uid = session('admin_id', 1);
        $this->pwd = md5($pwd . config('app.pwd_salt'));
        $res = $this->save();

        return $res;
    }

    /*
     *删除管理员
     */
    public function del($id)
    {
        $res = self::whereIn('id', $id)
            ->update([
                'status' => 0, 
                'edit_time' => date("Y-m-d H:i:s"), 
                'uid' => session('admin_id', 1),
            ]);

        return $res;
    }    

    //根据id获取管理员信息
    public function getAdminInfo($id)
    {
        $Admin = self::where('status', 1)
            ->find($id);

        return $Admin;
    }

    /*
     *修改管理员信息
     */
    public function edit($id, $name, $pwd)
    {
        $data = [
            'name' => $name,
            'edit_time' => date("Y-m-d H:i:s"), 
            'uid' => session('admin_id', 1),
        ];

        if ($pwd)
        {
            $data['pwd'] = md5($pwd . config('app.pwd_salt')); 
        }
        $res = self::where('id', $id)
            ->update($data);

        return $res;
    }
}
