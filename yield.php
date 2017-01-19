<?php

/**
 * php 迭代器处理从mysql取出的数据
 * 参考资料:
 * http://www.laruence.com/2012/08/30/2738.html
 * http://www.laruence.com/2015/05/28/3038.html
 * http://php.net/manual/zh/function.mysql-unbuffered-query.php
 *
 */
/**
 * 测试数据
CREATE TABLE `test` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `trade_id` varchar(24) NOT NULL COMMENT '订单号',
  `supplier_id` int(11) unsigned NOT NULL COMMENT '供应商id',
  `company_id` int(11) unsigned NOT NULL COMMENT '分公司id',
  `shop_id` int(11) unsigned NOT NULL COMMENT '实体店id',
  `pay_id` varchar(24) NOT NULL COMMENT '支付单号',
  `user_name` varchar(20) NOT NULL COMMENT '客户姓名',
  `user_tel` char(11) NOT NULL COMMENT '客户手机号',
  `total_price` decimal(12,2) NOT NULL COMMENT '消费总额',
  `really_price` decimal(12,2) NOT NULL COMMENT '实收金额',
  `sale_type` tinyint(3) NOT NULL COMMENT '优惠策略类型',
  `sale_rule` varchar(255) NOT NULL COMMENT '优惠策略',
  `platform_rate` decimal(12,2) unsigned NOT NULL COMMENT '平台扣点比率',
  `platform_price` decimal(12,2) unsigned NOT NULL COMMENT '平台结算金额',
  `supplier_price` decimal(12,2) unsigned NOT NULL COMMENT '供应商结算金额',
  `pay_type` tinyint(3) unsigned NOT NULL COMMENT '支付渠道',
  `pay_time` int(11) unsigned NOT NULL COMMENT '交易时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='实体店订单表'

先插入一条数据:INSERT INTO `test`.`test` (`trade_id`, `supplier_id`, `company_id`, `shop_id`, `pay_id`, `user_name`, `user_tel`, `total_price`, `really_price`, `sale_type`, `sale_rule`, `platform_rate`, `platform_price`, `supplier_price`, `pay_type`, `pay_time`) VALUES ( 'liwenrui1234567891234567', '1', '2', '3', 'liwenrui1234567891234567', 'liwenrui', '15810304184', '10.02', '11.02', '1', 'sdfasdfasdfasdfsadfsdfasdfasdfasdfsadfsdfasdfasdfasdfsadfsdfasdfasdfasdfsadfsdfasdfasdfasdfsadf', '11.3', '15.6', '17.8', '1', '12312312312312');
一次复制一倍的数据insert into test(`trade_id`,`supplier_id`,`company_id`,`shop_id`,`pay_id`,`user_name`,`user_tel`,`total_price`,`really_price`,`sale_type`,`sale_rule`,`platform_rate`,`platform_price`,`supplier_price`,`pay_type`,`pay_time`) (SELECT `trade_id`,`supplier_id`,`company_id`,`shop_id`,`pay_id`,`user_name`,`user_tel`,`total_price`,`really_price`,`sale_type`,`sale_rule`,`platform_rate`,`platform_price`,`supplier_price`,`pay_type`,`pay_time` from test)
 */

// -------------------------------------------------------------
/**
占据大内存,mysql_unbuffered_query方式处理
这种只能解决从mysql中获取数据消耗很大的内存问题.
 */
// var_dump(round(memory_get_usage()/1024/1024, 2));
// $link=mysql_connect("localhost","root","root");
// MySQL_query("SET NAMES 'utf8'");
// mysql_select_db("test", $link);
// $sql = "select * from test";

// $result = mysql_query($sql, $link); // 执行查询语句
// $rh     = mysql_unbuffered_query( $sql, $link );//不加这种方式光读取数据库20w条数据就占据超过128M内存
// $array = array();
// while( $row = mysql_fetch_array($rh,MYSQL_ASSOC) ){
//     $array[] =$row;//这种大数组都占很大内存
// }

// var_dump(count($array));

// var_dump(round(memory_get_peak_usage()/1024/1024, 2));

// -------------------------------------------------------------

var_dump(round(memory_get_usage()/1024/1024, 2));

function getMysql(){
$link=mysql_connect("localhost","root","root");
MySQL_query("SET NAMES 'utf8'");
mysql_select_db("test", $link);
$sql = "select * from test";

$result = mysql_query($sql, $link); // 执行查询语句
$rh     = mysql_unbuffered_query( $sql, $link );//不加这种方式光读取数据库20w条数据就占据超过128M内存
    while( $row = mysql_fetch_array($rh,MYSQL_ASSOC) ){
        //迭代器
        yield $row;
    }
}

//getMysql()只会执行一次
foreach (getMysql() as $v) {
    var_dump($v['id']);
    //代码.可以写一些统计计算输出什么的
    //一直不要$array[] = $v; 这样php开辟大数组就会很占内存,这种没法优化

}

var_dump(round(memory_get_peak_usage()/1024/1024, 2));
