<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
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

    public function getSalaryList($limit, $user_id)
    {
        $s_eq = $user_id != 0 ? '=' : '!='; 
        $data = self::where('status', 1)
            ->where('user_id', $s_eq, $user_id)
            ->paginate($limit);

        return $data;
    }

    /*
     *新增薪水
     */
    public function add($user_id, $amount, $cny_to_usd_rate, $usd_salary, $start_date, $end_date)
    {
        $this->user_id = $user_id;
        $this->amount = $amount;
        $this->cny_to_usd_rate = $cny_to_usd_rate;
        $this->usd_salary = $usd_salary;
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        
        $res = $this->save();

        return $res;
    }

    /*
     *删除薪水发放
     */
    public function del($ids)
    {
        $res = self::whereIn('id', $ids)
            ->update([
                'status' => 0, 
            ]);

        return $res;
    }    

    //根据id获取薪水发放信息
    public function getSalaryInfo($id)
    {
        $user = self::where('status', 1)
            ->find($id);

        return $user;
    }

    /*
     *修改薪水发放信息
     */
    public function edit($id, $amount, $cny_to_usd_rate, $usd_salary, $start_date, $end_date)
    {
        $data = [
            'amount' => $amount,
            'cny_to_usd_rate' => $cny_to_usd_rate,
            'usd_salary' => $usd_salary,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
        $res = self::where('id', $id)
            ->update($data);

        return $res;
    }
}
