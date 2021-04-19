<?php
error_reporting(0);
function cek($keyword){
    // Github : https://github.com/tinwaninja/
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'http://expo.expeditors.com/expo/SQGuest?SearchType=pagedShipmentSearch&TrackingNumber='.strtoupper(trim($keyword)).'&offset=0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt( $ch, CURLOPT_COOKIEJAR,  'cookie.txt');
    curl_setopt( $ch, CURLOPT_COOKIEFILE, 'cookie.txt' );
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    $headers = array();
    $headers[] = 'Connection: keep-alive';
    $headers[] = 'Dnt: 1';
    $headers[] = 'Upgrade-Insecure-Requests: 1';
    $headers[] = 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36';
    $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
    $headers[] = 'Accept-Language: id,en-US;q=0.9,en;q=0.8';
    $headers[] = 'Referer: http://expo.expeditors.com/expo/css/header.css';

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    $data = explode("<tbody>",$result);
    $data = explode("</tbody>",$data[1]);
    $datanya = explode("<tr>",$data[0]);
    $keluaran = array();
    foreach($datanya as $value){
        $keluar = explode("<td>",$value);
        if(array_key_exists(6,$keluar)){
            $tanggal = trim(strip_tags($keluar[6]));
        }else{
            $tanggal = null;
        }
        if(array_key_exists(3,$keluar)){
            $val = trim(strip_tags($keluar[3]));
        }else{
            $val = null;
        }
        $keluaran[$tanggal] = $val;
    }
    print_r($keluaran);
}
function cmp($a, $b){
    if ($a[2] == $b[2]) {
        return 0;
    }
    return ($a[2] < $b[2]) ? -1 : 1;
}
if(isset($argv[1])){
    $keyword = $argv[1];
}else{
    $keyword = null;
}

if(isset($keyword)){
    cek(trim($keyword));
}else{
    echo "Penggunaan: php cek.php john".PHP_EOL;
}

?>