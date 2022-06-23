<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Integrations\VoIPms;

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

        $from = $request->input('from');
        $to = $request->input('did');
        $message = $request->input('message');

        $vOiP = new VoIPms("admin@southerntrailerstx.com", "Topline1207!");
        if ( ! count($attached)) {
            $vOiP->sendSMS($from, $to, $message);
        } else {
            $attached = collect($attached)->map(function($attach) {
                return url(str_replace('public/', '/storage/', $attach));
            });

            $attached1 = isset($attached[0]) ? $attached[0] : '';
            $attached2 = isset($attached[1]) ? $attached[1] : '';
            $attached3 = isset($attached[2]) ? $attached[2] : '';

            $vOiP->sendMMS($from, $to, $message, $attached1, $attached2, $attached3);
        }
        
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
