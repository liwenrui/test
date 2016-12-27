<?php
sleep(10);
$file = '/home/liwenrui/code/test/_test.log';
$content = json_encode($_GET,JSON_UNESCAPED_UNICODE);

//FILE_APPEND 这个参数可以追加
file_put_contents($file, $content.PHP_EOL,FILE_APPEND);

exit;