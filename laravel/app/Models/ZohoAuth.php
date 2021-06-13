<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZohoAuth
{
	static $auth_token, $client_id, $client_secret, $refresh_token, $error = "";

	static function logout(){
		session()->flush();
		setcookie("acctok", "", time()-3600);
	}

	static function auth(){
		self::$auth_token = $_POST['auth_token'];
		self::$client_id = $_POST['client_id'];
		self::$client_secret = $_POST['client_secret'];

		self::setRefreshToken();
		self::setAccessToken();

		if(empty(self::$error)){
			return 'ok';
		}else{
			return self::$error;
		}
	}
	private static function setRefreshToken(){
		$data = [
			"client_id" 	=> self::$client_id,
			"client_secret" => self::$client_secret,
			"code" 			=> self::$auth_token,
			"grant_type" 	=> "authorization_code"
		];
		$response = self::getFromCurl($data);
		$std = json_decode($response);

		if(isset($std->error)){
			self::$error.= 'refresh token error :'.$std->error;
			return;
		}
		self::$refresh_token = $std->refresh_token;
		session(['refresh_token' =>  $std->refresh_token])	;
	}
	static function setAccessToken(){
		session(['client_id' => self::$client_id ?? session('client_id')]);
		session(['client_secret' => self::$client_secret ?? session('client_secret')]);
		session(['refresh_token' => self::$refresh_token ?? session('refresh_token')]);

		$data = [
			'client_id'		=> session('client_id'),
			'client_secret'	=> session('client_secret'),
			'refresh_token' => session('refresh_token'),
			'grant_type'	=> 'refresh_token'
		];
		$response = self::getFromCurl($data);
		$std = json_decode($response);

		if(isset($std->error)){
			self::$error = "<br>access token error :".$std->error;
			return;
		}
		setcookie('acctok', $std->access_token, time()+3600);
	}
	private static function getFromCurl($data){
		if($curl=curl_init()){
    		curl_setopt($curl,CURLOPT_URL,'https://accounts.zoho.com/oauth/v2/token');
		    curl_setopt($curl,CURLOPT_POST,true);
		    curl_setopt($curl,CURLOPT_POSTFIELDS, http_build_query($data));
		    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 0);
		    curl_setopt($curl,CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
		    curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
		    $out = curl_exec($curl);
		    return $out;
		}
	}
}
