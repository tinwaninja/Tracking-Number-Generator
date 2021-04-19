<?php
error_reporting(0);
function cek($keyword){
    // Github : https://github.com/tinwaninja/
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://eschenker.dbschenker.com/nges-portal/public/en-US_US/resources/tracking/search/customer?customerReferenceTypeId=1f9d8dea-3885-9cab-e053-1062e00af271&searchText='.trim($keyword));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt( $ch, CURLOPT_COOKIEJAR,  'cookie.txt');
    curl_setopt( $ch, CURLOPT_COOKIEFILE, 'cookie.txt' );

    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

    $headers = array();
    $headers[] = 'Authority: eschenker.dbschenker.com';
    $headers[] = 'Cache-Control: max-age=0';
    $headers[] = 'Sec-Ch-Ua: \"Google Chrome\";v=\"89\", \"Chromium\";v=\"89\", \";Not A Brand\";v=\"99\"';
    $headers[] = 'Sec-Ch-Ua-Mobile: ?0';
    $headers[] = 'Dnt: 1';
    $headers[] = 'Upgrade-Insecure-Requests: 1';
    $headers[] = 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36';
    $headers[] = 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9';
    $headers[] = 'Sec-Fetch-Site: none';
    $headers[] = 'Sec-Fetch-Mode: navigate';
    $headers[] = 'Sec-Fetch-User: ?1';
    $headers[] = 'Sec-Fetch-Dest: document';
    $headers[] = 'Accept-Language: id';
    $headers[] = 'Cookie: SESSION=ODIzZWFkMzEtZTA3NC00YTgwLTliYWQtY2Q2Y2Q5MWFmODk3; INGRESSCOOKIE=1617808099.7.897.269863; trackingId=37b0f5cc-57f4-4814-8163-4ebe6ff7cf47; _pk_ses.2.9400=1; _ga=GA1.2.2112552575.1617808411; _gid=GA1.2.1989344153.1617808411; language_region=en-US_ID; XSRF-TOKEN=CD5BZGJACHGX4OLZ2KPMYKGO6DHCILWNTXL74JTUAOK7PCJJMWNTFV52K5XUTDZFBPNTYX2NH5TNX53R; _pk_id.2.9400=59cc103b82495b30.1617808105.1.1617808863.1617808105.';
    $headers[] = 'Referer: ';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    $data = json_decode(json_encode(simplexml_load_string($result)),true);

    if(array_key_exists("foundShipmentOverviewItems",$data)){
        if(array_key_exists("foundShipmentOverviewItems",$data['foundShipmentOverviewItems'])){
            $datanya = $data['foundShipmentOverviewItems']['foundShipmentOverviewItems'];
            $simpan = array();
            foreach($datanya as $value){
                if(array_key_exists("estimatedTimeOfDelivery",$value)){
                    if(array_key_exists("timestamp",$value["estimatedTimeOfDelivery"])){
                        $simpan[$value["estimatedTimeOfDelivery"]["timestamp"]] = $value["sttNumber"] ."(https://eschenker.dbschenker.com/app/tracking-public/?refNumber=".$value["sttNumber"].")";
                    }else{
                        $simpan[$value["lastEventDate"]["timestamp"]] = $value["sttNumber"] ."(https://eschenker.dbschenker.com/app/tracking-public/?refNumber=".$value["sttNumber"].")";
                    }
                }
            }
            rsort($simpan,"cmp");
            $keluaran = array();
            foreach($simpan as $key => $value){
                $tanggal = date('l, j F Y H:i:s', $key/1000);
                $keluaran[$tanggal] = $value;
            }
            print_r($keluaran);
        }else{
            echo "Kosong";exit();
        }
    }
    
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