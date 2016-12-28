<?php
//解决$topic->consume(0, 1000);取不到对象时报notice警告
error_reporting(0);

/**
 * 解决%4|1482909441.581|PROTOERR|rdkafka#consumer-1| localhost:9092/0: Protocol parse failure at rd_kafka_fetch_reply_handle:3888 (incorrect broker.version.fallback?)错误
 * https://github.com/edenhill/librdkafka/wiki/Broker-version-compatibility
 * https://arnaud-lb.github.io/php-rdkafka/phpdoc/rdkafka.examples-high-level-consumer.html
 */
$conf = new RdKafka\Conf();
$conf->set('broker.version.fallback','0.8.2.2');

$rk = new RdKafka\Consumer($conf);
//$rk->setLogLevel(LOG_DEBUG);
$rk->addBrokers("127.0.0.1");
$topic = $rk->newTopic("test");
$topic->consumeStart(0, RD_KAFKA_OFFSET_BEGINNING);


while (true) {
    // The first argument is the partition (again).
    // The second argument is the timeout.
    $msg = $topic->consume(0, 1000);
    if ($msg->err) {
        echo $msg->errstr(), "\n";
//        break;
    } else {
        echo $msg->payload, "\n";
    }
}
