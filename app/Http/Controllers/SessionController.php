<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    //

    public function getSession(Requests $request){

    	if($request->session()->has('session_name')){
        return [
            $request->session()->get('session_name')
        ];
    	}else{
        return [
            'no data'
        ];
    	}
//https://www.youtube.com/watch?v=Av7IHpH-EbU
    }

    public function putSession(Request $request){
      $request->session()->put('session_name','www.hc-kr.com');
      return [
          'a data has been added to the session'
      ];
    }

    public function forgetSession(Request $request){
      $request->session()->forgetSession('session_name');
      return [
          'a data has been removed to the session'
      ];
    }



}
