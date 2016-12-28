<?php

error_reporting(0);
$conf = new RdKafka\Conf();
$conf->set('broker.version.fallback','0.8.2.2');
$rk = new RdKafka\Producer($conf);
//$rk->setLogLevel(LOG_DEBUG);
$rk->addBrokers("127.0.0.1");
$topic = $rk->newTopic("test");


$topic->produce(RD_KAFKA_PARTITION_UA, 0, "Message payload");
