<?php
$ip_list = array(
'192.168.1.1',
'192.168.1.2',
'192.168.1.3',
'192.168.1.4',
'192.168.1.5',
'192.168.1.6',
'192.168.1.7',
'192.168.1.8',
'192.168.1.9',
'192.168.1.10',
'192.168.1.11',
'192.168.1.12',
'192.168.1.13',
'192.168.1.14',
'192.168.1.15',
'192.168.1.16',
'192.168.1.17',
'192.168.1.18',
'192.168.1.19',
'192.168.1.20',
'192.168.1.21',
'192.168.1.22',
    );

//起的进程数是根据php-fpm.conf里的pm.max_children决定的
$mh = curl_multi_init();

foreach($ip_list as $ip)
{
        $url = "http://liwenrui.test.localhost/curl_multi_init_post.php?ip=".$ip;

        $conn[$ip] = curl_init();
        curl_setopt ( $conn[$ip] , CURLOPT_URL, $url);
        curl_setopt ( $conn[$ip] , CURLOPT_HEADER , 0 ) ;
        // curl_setopt ( $conn[$ip], CURLOPT_CONNECTTIMEOUT,1);//在发起连接前等待的时间，如果设置为0，则无限等待
        // curl_setopt ( $conn[$ip], CURLOPT_CONNECTTIMEOUT_MS,10);这里不如CURLOPT_TIMEOUT_MS好使

        //在cURL 7.16.2中被加入。从PHP 5.2.3起可使用
        curl_setopt($conn[$ip], CURLOPT_TIMEOUT_MS, 1);//这是毫秒级别,但是这个函数有个bug，如果时间小于1000毫秒也就是1秒的话，会立马报错.增加 curl_setopt($ch, CURLOPT_NOSIGNAL, 1)就可以了
        curl_setopt($conn[$ip], CURLOPT_NOSIGNAL, 1);
        curl_setopt ( $conn[$ip], CURLOPT_RETURNTRANSFER,true);
        curl_multi_add_handle ($mh, $conn[$ip]);
}

do {
        curl_multi_exec($mh,$active);
} while ($active);

foreach($ip_list as $ip)
{
        curl_multi_remove_handle($mh,$conn[$ip]);
        curl_close($conn[$ip]);
}

curl_multi_close($mh);