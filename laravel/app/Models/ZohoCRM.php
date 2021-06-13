<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZohoCRM extends Model
{
	private static $lastDealId;

	private static function fieldsAreNotCorrect(){
		if(empty($_POST['Deal_Name'])||empty($_POST['Stage'])||empty($_POST['Subject']))
			return true;
		if(is_numeric($_POST['Amount'])||is_numeric($_POST['Probability']))
			return true;
	}

	private static function req($module, $data=null){
		$curl_pointer = curl_init();
        
        $requestBody = json_encode(["data" => $data]);
        
        $headersArray = ["Authorization". ":" . "Zoho-oauthtoken " . $_COOKIE['acctok']];

        $curl_options = [
        	CURLOPT_URL 			=> "https://www.zohoapis.com/crm/v2/$module".'s',
        	CURLOPT_RETURNTRANSFER 	=> true,
        	CURLOPT_HEADER 			=> 1,
        	CURLOPT_CUSTOMREQUEST 	=> 'POST',
        	CURLOPT_HTTPHEADER		=> $headersArray,
        	CURLOPT_POSTFIELDS		=> $requestBody
        ];

        curl_setopt_array($curl_pointer, $curl_options);
        
        $result = curl_exec($curl_pointer);
        $responseInfo = curl_getinfo($curl_pointer);
        curl_close($curl_pointer);
        list ($headers, $content) = explode("\r\n\r\n", $result, 2);
        if(strpos($headers," 100 Continue")!==false){
            list( $headers, $content) = explode( "\r\n\r\n", $content , 2);
        }
        $jsonResponse = json_decode($content, true);

       	return $jsonResponse;
	}
	private static function createTask($data){

        $dealId = self::$lastDealId;
        $data[0]['$se_module'] = 'Deals';
        $data[0]['What_Id'] = $dealId;

		$res = self::req('Task', $data);
		if(isset($res['data'][0]['code'])&&$res['data'][0]['code'] == "SUCCESS")
        	return true;
        else
        	return false;
	}

    private static function createDeal($data){
        
        $res = self::req('Deal', $data);
        if(isset($res['data'][0]['code'])&&$res['data'][0]['code'] == "SUCCESS"){
         	self::$lastDealId = $res['data'][0]['details']['id'];       	
        	return true;
        }else
        	return false;
    }

    static function create(){

    	if(self::fieldsAreNotCorrect())
    		return 'Fill in all required fields';

    	$dataD = [[]];
    	$dataT = [[]];
    	//циклы разделяют данные формы на два массива
    	foreach ($_POST as $key => $value) {
    		if($key=='Subject')
            	break;
            $dataD[0][$key] = $value;
        }
    	foreach ($_POST as $key => $value) {
            $dataT[0][$key] = $value;
        }
    	$msg = "";
    	if(self::createDeal($dataD))
    		$msg.='Deal was created!';
    	else
    		$msg.= 'Error while creating deal!';
    	if(self::createTask($dataT))
    		$msg.="<br>Task was created!";
    	else
    		$msg.="<br>Error while creating task!";
    	return $msg;
    }
}
