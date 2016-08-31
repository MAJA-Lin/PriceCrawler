<?php

namespace ScottLin\PriceCrawlerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Predis\Autoloader;
use Predis\Client;

date_default_timezone_set("Asia/Taipei");

class RedisClearCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('redis:clear')
            ->setDescription('Clear all the data in redis.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = __DIR__ . "/../Logs/";
        $errLogFile = $dir . date('Y-m-d') . "_error.log";
        $logFile = $dir . date('Y-m-d') . ".log";
        if (!file_exists($dir)) {
            $oldmask = umask(0);
            mkdir($dir, 0744);
        }

        try {
            Autoloader::register();
            $redis = new Client(getenv('REDIS_URL'));

            $time = date('Y-m-d, H:i:s');
            $redis->flushall();
            $log = $time . " [Code:001] Redis - flushall." . PHP_EOL;
            $handle = fopen($logFile, "a+");
            fwrite($handle, $log);
            fclose($handle);

        } catch (Exception $e) {
            $time = date('Y-m-d, H:i:s');
            $error = $time . " [Error] " . $e->getMessage() . PHP_EOL;

            $handle = fopen($errlogFile, "a+");
            fwrite($handle, $error);
            fclose($handle);
        }

    }
}
