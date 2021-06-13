<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ZohoAuth;

class ZohoAuthController extends Controller
{
	public function auth(){
		echo json_encode(['msg' => ZohoAuth::auth()]);
	}
	public function logout(){
		ZohoAuth::logout();
		return redirect('auth');
	}
}
