<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Integrations\VoIp;

class VoIpController extends Controller
{
    public function sms_mms() {
        return view('sms-and-mms');
    }

    public function getMessages(Request $request) {
        $messages = Message::where(['did' => $request->input('did')])->get();
        return response()->json([
            'data' => $messages,
        ]);
    }

    public function send(Request $request) {
        $attached = [];
        if ($request->file('attached')) {
            collect($request->file('attached'))->each(function($attach) use (&$attached) {
                $attached[] = $attach->store('public/attached');
            });
        }

        $from = '4328472999';
        $to = $request->input('did');
        $message = $request->input('message');

        // dd($from, $to, $message);

        $vOiP = new VoIp("admin@southerntrailerstx.com", "Topline1207!");
        // $resopnse = $vOiP->sendSMS($from, $to, $message);
        $response = $vOiP->getDIDsInfo();
        
        dd($response);

        Message::create([
            'did' => $request->input('did'),
            'message' => $request->input('message'),
            'attached' => $attached,
        ]);

        return response()->json([
            'message' => 'Successfuly send'
        ]);
    }
}
