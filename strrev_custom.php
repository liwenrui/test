<?php
/**
 * 反转字符串的自定义函数
 */

    $str = 'abcdefg';

    echo diaosStrrev( $str );

    echo '<br>';

    echo quickStrrev( $str );

    function quickStrrev ( $str )
    {
        $len = mb_strlen( $str );

        for( $i = 0; $i < $len / 2; $i++ ) 
        {
            $tmp               = $str{$i};

            $str{$i}           = $str{$len - $i - 1};

            $str{$len - $i -1} = $tmp;
        }

        return $str;
    }

    function diaosStrrev ( $str )
    {
        $len    = mb_strlen( $str );

        $newStr = '';

        for( $i = $len - 1; $i >= 0; $i--)
        {
            $newStr .= $str{$i};
        }

        return $newStr;
    }
