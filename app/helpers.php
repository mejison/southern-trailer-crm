<?php

use App\Integrations\VoIPms;

if (! function_exists('alert_sms')) {
    function alert_sms($from, $to, $message) {
        $vOiP = new VoIPms(env('VOIPMS_LOGIN'), env('VOIPMS_PASSWORD'));
        return $vOiP->sendSMS($from, $to, $message);
    }
}
