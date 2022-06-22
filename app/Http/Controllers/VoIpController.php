<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VoIpController extends Controller
{
    public function sms_mms() {
        return view('sms-and-mms');
    }

    public function getMessages(Request $request) {
        
    }

    public function send(Request $request) {

    }
}
