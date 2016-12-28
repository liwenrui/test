
启动zookeeper
zk-server start

启动kafka
./bin/kafka-server-start.sh config/server.properties &

kafka终端测试
	生产者:sh bin/kafka-console-producer.sh --broker-list localhost:9092 --topic test
	消费者:sh bin/kafka-console-consumer.sh --zookeeper localhost:2181 --topic test --from-beginning

php-kafka测试
    php kafka_consume.php
    php kafka_produce.php

    或者
    php kafka_consume.php
    sh bin/kafka-console-producer.sh --broker-list localhost:9092 --topic test


