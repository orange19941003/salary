<?php

namespace App\Http\Enums\admin;

//admin 用的一些返回信息,枚举值
class AdminEnum
{
	const LOGIN_CODE_ERROR = '验证码错误';

    const LOGIN_NAME_ERROR = '用户名错误';

    const LOGIN_PWD_ERROR = '用户密码错误';

    const LOGIN_PWD_FIVE_ERROR = '密码错误5次，封禁至';

    const LOGIN_OTHER = '账号已登录或者在其他设备已登录';

    const LOGIN_SUCCESS = "登录成功";

    const ADD_ERROR = "新增失败";

    const ADD_SUCCESS = "新增成功";

	const DELETE_ERROR = "删除失败";

    const DELETE_SUCCESS = "删除成功";

	const EDIT_ERROR = "修改失败";

    const EDIT_SUCCESS = "修改成功";

    const GAlARY_TYPE_WEEK = 1;
    const GAlARY_TYPE_HOUR = 2;
    const GAlARY_TYPE_MONTH = 3;

    public static $GAlARY_TYPE_OPTIONS = [
        self::GAlARY_TYPE_WEEK    => '周薪',
        self::GAlARY_TYPE_HOUR    => '时薪',
        self::GAlARY_TYPE_MONTH    => '月薪',

    ];

}
