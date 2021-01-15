<?php
header('Content-Type: application/json');
class trueWallet
{
    private $phone;
    public function __construct($phone)
    {
        if (strlen($phone) != 10 || $phone == '') return $this->formatJson(400, "error", "mobile number error.", null);
        $this->phone = $phone;
    }
    private function Curl($method, $url, $header, $data, $cookie)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.120 Safari/537.36');
        //curl_setopt($ch, CURLOPT_USERAGENT, 'okhttp/3.8.0');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        if ($cookie) {
            curl_setopt($ch, CURLOPT_COOKIESESSION, true);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
        }
        return curl_exec($ch);
    }
    private function formatJson($code, $message, $error, $data)
    {
        http_response_code($code);
        $json = [
            "statusCode" => $code,
            "message" => $message,
            "error" => $error,
            "data" => $data
        ];
        return json_encode($json);
    }
    public function toPup($url)
    {
        if ($url == null || $url == '') return $this->formatJson(400, "error", "link url is null.", null);
        try {
            preg_match("/([^?&=#]+)=([^&#]*)/", $url, $code);
            //print_r($code);
            $code = $code[2];
            if ($code == '') return $this->formatJson(400, "error", "link url is wrong.", null);
            $header = [
                "content-type:application/json"
            ];
            $data = '{"mobile":"0969590967","voucher_hash":"' . $code . '"}';
            $res = $this->Curl("POST", 'https://gift.truemoney.com/campaign/vouchers/' . $code . '/redeem', $header, $data, null);
            $json = json_decode($res, true);
            if ($json['status']['message'] != 'success') return $this->formatJson(400, "error", $json['status']['message'], null);
            return $this->formatJson(200, "success", null, $json['data']['tickets']);
        } catch (Exception $e) {
            return $this->formatJson(400, "error", $e->getMessage(), null);
        }
    }
}

