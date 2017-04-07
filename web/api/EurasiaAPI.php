<?php
require_once './.settings.php';


class EurasiaAPI {


    public static function getPersonByIIN($iin) {
        global $PARAM_WSAPI_URL;

        $data = [
            'idNumber' => str_replace(" ", '', $iin)
            ];

        $data = json_encode($data);

        $url = $PARAM_WSAPI_URL . '/order/ws/policy/fetch-driver/';

        return self::request($url, $data);
    }

    /**
     * Запрос к API
     *
     * @param type $url адрес АПИ метода
     * @param type $data данные
     */
    public static function request($url, $data, $method = 'post') {
        global $PARAM_WSAPI_USER;
        global $PARAM_WSAPI_PASSWORD;

        $logPath = __DIR__.'/../logs/';

        $curl = curl_init();

        // WS под паролем
        curl_setopt($curl, CURLOPT_USERPWD, $PARAM_WSAPI_USER . ':' . $PARAM_WSAPI_PASSWORD);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_USERAGENT, 'grafica-API-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $url);

        if($method == 'post') {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            }

        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        //curl_setopt($curl, CURLOPT_COOKIEFILE, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        //curl_setopt($curl, CURLOPT_COOKIEJAR, dirname(__FILE__) . '/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        $out = curl_exec($curl); # Initiate a request to the API and stores the response variable
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // ошибка вызова
        if($code != 200) {

            if(!is_dir($logPath)) {
                mkdir($logPath, 0777, true);
            }

            // запишем ошибку в лог
            file_put_contents($logPath.date('Ymd').'.log', date("y-m-d H:i:s")." Code $code, message $out, URL $url, data $data" . PHP_EOL, FILE_APPEND);

            return json_encode(['error' => true, 'code' => $code, 'message' => $out]);
        } else {
            // всё ок, вернем результат
            return $out;
        }
    }
}