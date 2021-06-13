<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZohoAuth;

class ZohoAuthController extends Controller
{
	public function auth(){
		if(ZohoAuth::auth())
			return redirect('deal');
	}
	public function logout(){
		ZohoAuth::logout();
		return redirect('auth');
	}
}
