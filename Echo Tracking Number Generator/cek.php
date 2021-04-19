<?php
error_reporting(0);
function cek($keyword){
    // Github : https://github.com/tinwaninja/
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://echo.com/ShipmentTracking/Services/TrackShipment.asmx/Track');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, '{"referenceNumber":"'.trim($keyword).'"}');
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt( $ch, CURLOPT_COOKIEJAR,  'cookie.txt');
    curl_setopt( $ch, CURLOPT_COOKIEFILE, 'cookie.txt' );

    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    $headers = array();
    $headers[] = 'Connection: keep-alive';
    $headers[] = 'Sec-Ch-Ua: \"Google Chrome\";v=\"89\", \"Chromium\";v=\"89\", \";Not A Brand\";v=\"99\"';
    $headers[] = 'Accept: application/json, text/javascript, */*; q=0.01';
    $headers[] = 'Dnt: 1';
    $headers[] = 'X-Requested-With: XMLHttpRequest';
    $headers[] = 'Sec-Ch-Ua-Mobile: ?0';
    $headers[] = 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36';
    $headers[] = 'Content-Type: application/json; charset=UTF-8';
    $headers[] = 'Origin: https://echo.com';
    $headers[] = 'Sec-Fetch-Site: same-origin';
    $headers[] = 'Sec-Fetch-Mode: cors';
    $headers[] = 'Sec-Fetch-Dest: empty';
    $headers[] = 'Referer: https://echo.com/ShipmentTracking/Scripts/font-awesome.min.css';
    $headers[] = 'Accept-Language: id,en-US;q=0.9,en;q=0.8';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    $data = json_decode($result,true);
    $datanya = json_decode($data["d"]["Data"],true);
    $keluaran = array();
    foreach($datanya as $value){
        $tanggal = explode("/",$value["DelOpenDateDTO"]);
        if(array_key_exists(2,$tanggal)){
            $tanggalnya = $tanggal[1]."-".$tanggal[0]."-".$tanggal[2];
        }else{
            $tanggalnya = null;
        }
        
        $keluaran[$tanggalnya] = $value["LoadId"];
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