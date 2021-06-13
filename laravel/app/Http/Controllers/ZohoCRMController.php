<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZohoCRM;
use App\Models\ZohoAuth;

class ZohoCRMController extends Controller
{
    function dealForm(){
    	if(session()->has('client_id')){
			return view('deal');
		}else{
			return redirect('auth');
		}
	}
	function create(){
		if(session()->has('client_id')){
			if(!isset($_COOKIE['acctok']))
				ZohoAuth::setAccessToken();
			echo json_encode(['msg' => ZohoCRM::create()]);
		}else{
			echo json_encode(['msg' => 'unauth']);
		}
	}
}
