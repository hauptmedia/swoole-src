--TEST--
swoole_redis_coro: redis subscribe 2
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';

go(function () {
    $redis = new Co\Redis;
    $redis->connect(REDIS_SERVER_HOST, REDIS_SERVER_PORT);

    $redis2 = new Co\Redis;
    $redis2->connect(REDIS_SERVER_HOST, REDIS_SERVER_PORT);

    for ($i = 0; $i < MAX_REQUESTS; $i++) {
        $channel = 'channel' . $i;
        $val = $redis->subscribe([$channel]);
        Assert::assert($val);

        $val = $redis->recv();
        Assert::assert($val[0] == 'subscribe' && $val[1] == $channel);

        go(function () use ($channel, $redis2) {
            $ret = $redis2->publish($channel, 'test' . $channel);
            Assert::assert($ret);
        });

        $val = $redis->recv();
        Assert::same($val[0] ?? '', 'message');
        Assert::same($val[1] ?? '', $channel);
        Assert::same($val[2] ?? '', 'test' . $channel);
    }

    $redis->close();
    $redis2->close();
});

?>
--EXPECT--
