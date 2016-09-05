<?php

namespace ScottLin\PriceCrawlerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Predis\Autoloader;
use Predis\Client;

date_default_timezone_set("Asia/Taipei");

class RedisUpdateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('redis:update')
            ->setDescription('Update the weekly discount info into redis.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $today = 'today';
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
            $source = ["bookscom", "taaze", "sanmin", "iread"];

            $discountParsing = $this->getContainer()->get('scottlin_pricecrawler.discountparsing');

            $time = date('Y-m-d, H:i:s');
            $redis->flushall();
            $log = $time . " [Code:001] Redis - flushall." . PHP_EOL;
            $handle = fopen($logFile, "a+");
            fwrite($handle, $log);
            fclose($handle);

            foreach ($source as $key) {
                $discountParsing->setSource($key);
                $bookResult = $discountParsing->bookParsing();
                $redis->set($key, json_encode($bookResult['weekBook']));
                $redis->hmset($today, [
                    $key => json_encode($bookResult['today'])
                ]);

                $time = date('Y-m-d, H:i:s');
                $log = $time . " [Code:011] (Source: " . $key;
                $log = $log . ") Data successfully parsed and saved into redis." . PHP_EOL;

                $handle = fopen($logFile, "a+");
                fwrite($handle, $log);
                fclose($handle);
            }

        } catch (Exception $e) {
            $time = date('Y-m-d, H:i:s');
            $error = $time . " [Error] " . $e->getMessage() . PHP_EOL;

            $handle = fopen($errlogFile, "a+");
            fwrite($handle, $error);
            fclose($handle);
        }

    }
}
