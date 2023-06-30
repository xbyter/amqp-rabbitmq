<?php
namespace Xbyter\Amqp\Examples;

use Xbyter\Amqp\Consumer;

class ConsumerServer
{

    private Consumer $consumer;

    /** @var int 最大内存(MB), 超过后, 待任务完成后会自动重启队列 */
    private int $maxMemory = 512;

    /** @var int 当没有任务执行时的睡眠时间 */
    private int $sleep = 3;

    /** @var bool 是否需要退出, 如果用kill杀死的则等当前任务执行完后再平滑退出 */
    private bool $shouldQuit = false;


    public function __construct(Consumer $consumer)
    {
        $this->consumer = $consumer;
    }

    public function run(array $consumerMessageClasses)
    {
        //监听进程是否被kill掉, 如果用kill杀死的则等当前任务执行完后再平滑退出
        if (extension_loaded('pcntl')) {
            $this->listenForSignals();
        }

        //需要休眠的任务, 无数据的任务会休眠或等待一段时间再跑
        $sleepTasks = [];
        while (true) {
            $hasData = false;
            foreach ($consumerMessageClasses as $consumerMessageClass) {
                /** @var \Xbyter\Amqp\Interfaces\ConsumerMessageInterface $consumerMessage */
                $consumerMessage = new $consumerMessageClass();
                $queueName = $consumerMessage->getQueue();

                //无数据的任务会休眠或等待一段时间再跑
                if (isset($sleepTasks[$queueName]) && time() - $sleepTasks[$queueName] < $this->sleep) {
                    continue;
                }

                $channel = $this->consumer->buildConsumeChannel($consumerMessage);
                if ($channel->is_consuming()) {
                    $channel->wait(null, true);

                    if ($channel->hasMessage()) {
                        $hasData = true;
                        $sleepTasks[$queueName] = null;
                    } else {
                        //任务跑完的话, 等一段时间再跑
                        $sleepTasks[$queueName] = time();
                    }
                }

                //退出队列如果符合条件的话, 内存超出/手动停止/进程杀死
                $this->exitQueueIfNecessary($queueName);
            }

            //全都没有可执行的任务的话则休眠$sleep秒
            if (!$hasData) {
                sleep($this->sleep);
            }
        }
    }


    /**
     * 监听进程信号量, 如果用kill杀死的则等当前任务执行完后再平滑退出
     */
    protected function listenForSignals()
    {
        pcntl_async_signals(true);

        //kill进程会进入
        pcntl_signal(SIGTERM, function () {
            $this->shouldQuit = true;
        });

        //ctrl + c 中断进程会进入
        pcntl_signal(SIGINT, function () {
            $this->shouldQuit = true;
        });
    }


    /**
     * //退出队列如果符合条件的话, 内存超出/手动停止/进程杀死
     *
     * @param string $queueName
     */
    protected function exitQueueIfNecessary(string $queueName): void
    {
        //如果用kill杀死的则等当前任务执行完后再平滑退出
        if ($this->shouldQuit) {
            $this->logInfo("Amqp process terminated: {$queueName}");
            exit(0);
        }

        //当前使用内存大于指定内存后重启
        $memory = round(memory_get_usage(true) / 1024 / 1024, 2);
        if ($memory >= $this->maxMemory) {
            $this->logInfo("Amqp {$queueName} current memory: {$memory} MB exceeds {$this->maxMemory}MB terminated");
            exit(0);
        }
    }


    protected function logInfo(string $content): void
    {

    }
}
