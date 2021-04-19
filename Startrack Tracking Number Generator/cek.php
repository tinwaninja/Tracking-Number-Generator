<?php
error_reporting(0);
function cek($keyword){
    // Github : https://github.com/tinwaninja/
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://digitalapi.auspost.com.au/consignmentapi/v1/consignments?q='.strtoupper(trim($keyword)));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt( $ch, CURLOPT_COOKIEJAR,  'cookie.txt');
    curl_setopt( $ch, CURLOPT_COOKIEFILE, 'cookie.txt' );
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    $headers = array();
    $headers[] = 'Authority: ssl.o.auspost.com.au';
    $headers[] = 'Sec-Ch-Ua: \"Google Chrome\";v=\"89\", \"Chromium\";v=\"89\", \";Not A Brand\";v=\"99\"';
    $headers[] = 'Dnt: 1';
    $headers[] = 'Sec-Ch-Ua-Mobile: ?0';
    $headers[] = 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36';
    $headers[] = 'Accept: */*';
    $headers[] = 'Sec-Fetch-Site: cross-site';
    $headers[] = 'Sec-Fetch-Mode: no-cors';
    $headers[] = 'Sec-Fetch-Dest: empty';
    $headers[] = 'Referer: https://startrack.com.au/';
    $headers[] = 'Accept-Language: id,en-US;q=0.9,en;q=0.8';
    $headers[] = 'Connection: keep-alive';
    $headers[] = 'X-Datadome-Clientid: .keep';
    $headers[] = 'Api-Key: nzsET4kyTEOBfkEZZ2ew2OGOby8GwNPa';
    $headers[] = 'Origin: https://startrack.com.au';
    $headers[] = 'Content-Length: 0';
    $headers[] = 'Content-Type: text/plain;charset=UTF-8';

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    $data = json_decode($result,true);
    $keluaran = array();
    foreach($data['consignments'] as $value){
        $keluaran[$value["estimatedDeliveryOn"]] = $value["code"];
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