<?php

namespace App\Lib\Extension;

class WxService {
	
    const SENDER = 'qqnews_qa';
    
    public function sendToGroup($msg, $receivers, $isPic=false) {
        $url = "http://dr.webdev.com/proxy/api/message?do=send-wxgroup";

        $postData = array(
            'receivers'=> $receivers,
            'body'     => $msg
        );

        if ($isPic) {
            $postData['type'] = 2;
        }

        $re = $this->_post($url, $postData);

        $result = json_decode($re, true);
        return $result;
    }

    private function _post($url, $postData) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

         curl_setopt($curl, CURLOPT_POST, 1);

         curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);

         curl_exec($curl);
         curl_close($curl);
    }
}
