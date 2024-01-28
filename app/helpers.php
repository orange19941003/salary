<?php 
	function input($key='', $val='')
	{
		$get = $_GET;
		$post = $_POST;
		$input = array_merge($get, $post);
		if ($key == '')
		{
			return $input;
		}

		return array_key_exists($key, $input) ? $input[$key] : $val;
	}

	//判断是否整数
	function checkInt($num, $type=0) : bool
	{
		if ($type == 0)
		{
			//是否整数
			if(floor($num)==$num)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			//是否正整数
			if(preg_match("/^[1-9][0-9]*$/" ,$num))
			{
				return true;
			}
		}

		return false;
	}

	//统一返回函数
	function json_response(array $data, string $msg, int $code) : string
	{
		$response = [];
		$response['code'] = $code;
		$response['msg'] = $msg;
		$response['data'] = $data;

		return json_encode($response);
	}

	//检查邮箱
	function checkEmail(string $email) : bool
	{
		$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
	
	    return preg_match($pattern, $email);
	}

	function nowapiRequest(&$errMsg='')
	{
		$postData['app'] = 'finance.rate';
		$postData['scur'] = 'USD';
		$postData['tcur'] = 'CNY';
		$postData['appkey'] = '71973';//替换成自己的appkey
		$postData['sign'] = '1a829ade21136143f711e2b16626c3d8';//替换成自己的sign
		$postData['format'] = 'json';
		$apiUrl     = 'https://sapi.k780.com/';
		$useContext = stream_context_create(array(
			'http' => array(
				'method'  => 'POST',
				'header'  => 'Content-type:application/x-www-form-urlencoded',
				'content' => http_build_query($postData)
			)
		));
		if(!$resData=file_get_contents($apiUrl,false,$useContext)){
			$errMsg = 'ERR_CONNECT';
			return false;
		}
		if(!$arrData=json_decode($resData,true)){
			$errMsg = 'ERR_DECODE';
			return false;
		}
		if($arrData['success']!=1){
			$errMsg = $arrData['msgid'].' '.$arrData['msg'];
			return false;
		}

		return $arrData['result'];
	}
?>