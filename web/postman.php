<?php

require './api/EurasiaAPI.php';


$url = 'insurance/crm/send-policy-request';


$dir = __DIR__ . '/leads';

$files = array_diff(scandir($dir), ['..', '.', '.htaccess']);

//echo '<pre>';
//print_r($files);
//echo '</pre>';

foreach($files as $file) {

    $file = "$dir/$file";

    $extension = pathinfo($file, PATHINFO_EXTENSION);

    $timePassed = (time() - filemtime($file)) / 60;

    // json и изменен 5 минут назад
    if($extension == 'json' && $timePassed > 5) {

//        echo "$file<br/>";

        $data = file_get_contents($file);

        // отправляем данные в ЦРМ
        $request = EurasiaAPI::request($url, $data);

        // Удалем файл
        unlink($file);

//        echo '<pre>';
//        var_dump($request);
//        echo '</pre>';


    }

}