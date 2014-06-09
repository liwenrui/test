<?php
/**
 * 反转字符串的自定义函数
 */

    $str = 'abcdefg';

    echo diaosStrrev( $str );

    echo '<br>';

    echo quickStrrev( $str );

    echo '<br>';

    echo recurrentStrrev( $str );
    /**
     * 二分法
     *
     */
    function quickStrrev( $str )
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

    /**
     * 循环法(效率比二分法低)
     *
     */
    function diaosStrrev( $str )
    {
        $len    = mb_strlen( $str );

        $newStr = '';

        for( $i = $len - 1; $i >= 0; $i--)
        {
            $newStr .= $str{$i};
        }

        return $newStr;
    }

    /**
     * 递归法(效率低)
     *
     */
    function recurrentStrrev( $str )
    {

        //static 只会初始化一次
        static $result = '';

        if( strlen( $str ) > 0 )
        {
            recurrentStrrev( substr( $str , 1 ) );

            $result .= substr( $str , 0 , 1 );
        }

        return $result;
    }

