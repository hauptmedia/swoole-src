--TEST--
swoole_redis_coro: redis unsubscribe
--SKIPIF--
<?php require __DIR__ . '/../include/skipif.inc'; ?>
--FILE--
<?php declare(strict_types = 1);
require __DIR__ . '/../include/bootstrap.php';

go(function () {
    $redis = new Co\Redis();
    $ret = $redis->connect(REDIS_SERVER_HOST, REDIS_SERVER_PORT);
    Assert::assert($ret);

    $ret = $redis->subscribe(['channel1']);
    Assert::assert($ret);

    $ret = $redis->recv();
    Assert::same($ret[0], 'subscribe');
    Assert::same($ret[1], 'channel1');

    $ret = $redis->getDefer();
    Assert::assert(!$ret);

    $ret = $redis->set('a', '1');
    Assert::assert(!$ret);

    $ret = $redis->setDefer(false);
    Assert::assert(!$ret);

    $ret = $redis->unsubscribe(['channel1']);
    Assert::assert($ret);

    $ret = $redis->recv();
    Assert::same($ret[0], 'unsubscribe');
    Assert::same($ret[1], 'channel1');

    $ret = $redis->getDefer();
    Assert::assert(!$ret);

    $ret = $redis->set('a', '1');
    Assert::assert($ret);

    $ret = $redis->setDefer(false);
    Assert::assert($ret);

    $redis->close();
});

?>
--EXPECTF--
Warning: Swoole\Coroutine\Redis::setDefer(): you should not use setDefer after subscribe in %s/tests/swoole_redis_coro/unsubscribe.php on line 22
