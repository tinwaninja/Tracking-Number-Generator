<?php
error_reporting(0);
function cek($keyword){
    // Github : https://github.com/tinwaninja/
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://www.tnt.com/api/v3/shipment?ref='.strtoupper(trim($keyword)).'&locale=in_ID&searchType=REF&channel=OPENTRACK');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt( $ch, CURLOPT_COOKIEJAR,  'cookie.txt');
    curl_setopt( $ch, CURLOPT_COOKIEFILE, 'cookie.txt' );
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    $headers = array();
    $headers[] = 'Authority: t.svtrd.com';
    $headers[] = 'Sec-Ch-Ua: \"Google Chrome\";v=\"89\", \"Chromium\";v=\"89\", \";Not A Brand\";v=\"99\"';
    $headers[] = 'Sec-Ch-Ua-Mobile: ?0';
    $headers[] = 'Upgrade-Insecure-Requests: 1';
    $headers[] = 'Dnt: 1';
    $headers[] = 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36';
    $headers[] = 'Accept: image/avif,image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8';
    $headers[] = 'Sec-Fetch-Site: cross-site';
    $headers[] = 'Sec-Fetch-Mode: no-cors';
    $headers[] = 'Sec-Fetch-User: ?1';
    $headers[] = 'Sec-Fetch-Dest: image';
    $headers[] = 'Referer: ';
    $headers[] = 'Accept-Language: id,en-US;q=0.9,en;q=0.8';
    $headers[] = 'Origin: https://www.tnt.com';
    $headers[] = 'X-Requested-With: XMLHttpRequest';
    $headers[] = 'Connection: keep-alive';
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'X-Client-Data: CIe2yQEIorbJAQipncoBCPjHygEI+M/KAQixmssBCOOcywEIqJ3LAQ==';
    $headers[] = 'Access-Control-Request-Method: POST';
    $headers[] = 'Access-Control-Request-Headers: content-type';

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    $data = json_decode($result,true);
    $keluaran = array();
    foreach($data["tracker.output"]["consignment"] as $value){
        if(array_key_exists("analytics",$value)){
            $status = $value["analytics"]["destinationDateSources"]["usedDate"];
            if($status == "delivered"){
                $keluaran[$value["analytics"]["destinationDateSources"]["delivered"]] = $value["consignmentNumber"];
            }
        }
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
    echo "Penggunaan: php cek.php 123".PHP_EOL;
}

?>