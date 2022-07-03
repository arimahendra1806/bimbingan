<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WhatsappApiController extends Controller
{
    public function whatsappNotif($number, $message) {

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_PORT => "8000",
        CURLOPT_URL => "http://127.0.0.1:8000/send-message",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "number=" . $number . "&message=" . $message,
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        }
    }
}
