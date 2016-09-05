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
            ->addArgument('range', InputArgument::OPTIONAL, 'Which data you want to flush?')
            ->setDescription('Clear the data in redis.')
            ->setHelp("This command allows you to clear data on redis");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $source = ["bookscom", "taaze", "sanmin", "iread"];
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

            $range = $input->getArgument('range');
            if (is_null($range) || ($range != 'all' && $range != 'books' && $range != 'update')) {
                $range = 'books';
            }

            $time = date('Y-m-d, H:i:s');

            if ($range == 'all') {
                $redis->flushall();
                $log = $time . " [Code:001] Redis - flushall." . PHP_EOL;
            }

            if ($range == 'books') {
                foreach ($source as $key => $value) {
                    $redis->del($value);
                    $bookLog = " [Code:002] Redis - delete books data. (source: " . $value . " )";
                    if ($key == 0) {
                        $log = $time . $bookLog . PHP_EOL;
                    }
                    if ($key > 0) {
                        $log = $log . $time . $bookLog . PHP_EOL;
                    }
                }
            }

            if ($range == 'update') {
                $redis->del('update');
                $log = $time . " [Code:003] Redis - delete counter that record when books update." . PHP_EOL;
            }

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
