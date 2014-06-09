<?php
    $str = 'abcdefg';

    $len = mb_strlen($str);

    for ($i = 0; $i < $len / 2; $i++) {

       $v = $str{$i};

       $str{$i} = $str{$len - $i- 1};
       $str{$len- $i - 1} = $v;
    }

    $array = array(0,2,3,4,5);

    echo json_encode($array);

    echo "\n";

