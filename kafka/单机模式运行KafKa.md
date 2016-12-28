kafka的安装:
1. 安装配置JDK

首先我们应该要安装配置JDK,应为zookeeper和KafKa都依赖与java环境

tar -zxvf jdk-7u79-linux-x64.tar.gz
mv jdk1.7/ /usr/local/

设定JAVA_HOME环境变量,编辑vim /etc/profile 加入如下内容

export JAVA_HOME=/usr/local/jdk1.7
export JRE_HOME=/usr/local/jdk1.7/jre
export CLASSPATH=.:$JAVA_HOME/lib/dt.jar:$JAVA_HOME/lib/tools.jar:$JRE_HOME/lib:
export PATH=$JAVA_HOME/bin:$PATH

更改后，执行命令使其生效

source /etc/profile

执行 java -version 会看到如下版本信息证明已经安装成功

java version "1.7.0_79"
Java(TM) SE Runtime Environment (build 1.7.0_79-b15)
    Java HotSpot(TM) 64-Bit Server VM (build 24.79-b02, mixed mode)

    2. 安装zookeeper

    KafKa依赖zookeeper的配置,调度,偏移,总之就是鱼儿离不开水这个道理,KafKa没有zookeeper也没办法玩起来,所以我们的第一步就是安装zookeeper,KafKa在内部带有一套zookeeper但是还是简单单独安装配置(zookeeper需要集群分布式来保证n-1的高可用)

    zookeeper这里使用的时3.4.5版本可在上方百度网盘进行下载

    安装配置zookeeper单机模式 :

    cd /app/install
    tar zxvf zookeeper-3.4.5-cdh4.3.0.tar.gz
    mv zookeeper-3.4.5-cdh4.3.0 /tmp/zookeeper
    cd /tmp/zookeeper/
    mv conf/zoo_sample.cfg conf/zoo.cfg
    mkdir data
    echo 1 > data/myid #将本节点id设定到data/myid文件中

    修改bin/zkEnv.sh脚本：

    将ZOO_LOG_DIR="."修改为

    ZOO_LOG_DIR="/tmp/zookeeper/data"

    将ZOO_LOG4J_PROP=”INFO,CONSOLE”修改为

    ZOO_LOG4J_PROP="INFO,ROLLINGFILE"

    修改bin/zkServer.sh脚本：

    将ZOOBIN="${BASH_SOURCE-$0}"修改为

    ZOOBIN=`readlink -f "${BASH_SOURCE-$0}"`

    修改bin/zkCli.sh脚本：

    将ZOOBIN="${BASH_SOURCE-$0}"修改为

    ZOOBIN=`readlink -f "${BASH_SOURCE-$0}"`

    建立软连接到PATH：

    ln -s /tmp/zookeeper/bin/zkServer.sh /usr/local/bin/zk-server
    ln -s /tmp/zookeeper/bin/zkCli.sh /usr/local/bin/zk-cli

    使用如下命令即可启动zookeeper

    zk-server start
#以下输出为运行成功
    JMX enabled by default
    Using config: /tmp/zookeeper/bin/../conf/zoo.cfg
    Starting zookeeper ... STARTED

    在后续博文中喵咪会对zookeeper单独开一个系列进行说明
    3. 安装KafKa0.8.2.2

    第二步就是安装KafKa了,KafKa目前最新的版本是0.10.0.1,但是此版本基本只有亲儿子语言能够很好地使用,这里采用一个比较稳定大部分kafka拓展能够支持的0.8.2.2

    KafKa的安装包同样可以在上方百度网盘中下载到或到http://kafka.apache.org/downloads.html下载相应的版本

    tar -zxvf kafka_2.9.1-0.8.2.2.tgz
    mv kafka_2.9.1-0.8.2.2 /usr/local/

    到这里KafKa就已经安装完成(心里暗念太简单了),我们进入大KafKa得更目录/usr/local/kafka_2.9.1-0.8.2.2来运行起来,这里是需要制定KafKa连接的zookeeper才能启动成功默认是localhost:2181,可以自行修改config/server.properties

    // 运行KafKa
    sh bin/kafka-server-start.sh config/server.properties &

    这个时候会看到很多INFO语句如之中没有包含的ERROR的报错并且停留到如下输出证明你的KafKa已经启动成功了

    INFO [Kafka Server 0], started (kafka.server.KafkaServer)

    4. 使用命令行测试KafKa

    最后就是对KafKa进行一下简单的测试,创建一个生产者和一个消费者之间互相通讯消息

    运行生产者producer

    sh bin/kafka-console-producer.sh --broker-list localhost:9092 --topic test

    运行消费者consumer

    sh bin/kafka-console-consumer.sh --zookeeper localhost:2181 --topic test --from-beginning

    此时在生产者输入内容,消费者这里也能显示出来

    注意:当有跨机的producer或consumer连接时需要配置config/server.properties的host.name

    https://my.oschina.net/wenzhenxi/blog/745649
