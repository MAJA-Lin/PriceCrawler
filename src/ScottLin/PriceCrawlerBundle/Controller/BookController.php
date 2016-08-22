<?php

namespace ScottLin\PriceCrawlerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Predis\Autoloader;
use Predis\Client;

class BookController extends Controller
{
    /**
     * Get weekly discount book infomation and save it to redis.
     *
     * @Route(
     *      "/book/discount/week/{source}",
     *      name="discount_week_update",
     *      requirements={"source" : "bookscom|taaze|sanmin|iread"})
     *
     * @Method("PUT")
     */
    public function weeklyDiscountUpdateAction(Request $request, $source)
    {
        try {

            Autoloader::register();
            $redis = new Client(getenv('REDIS_URL'));

            $discountParsing = $this->get('scottlin_pricecrawler.discountparsing');
            $discountParsing->setSource($source);
            $finalPage = $discountParsing->bookParsing();

            $redis->set($source, json_encode($finalPage));

            $result = [
                'status' => 'successful',
                'data' => $finalPage,
            ];

        } catch (\Exception $e) {
            $result = [
                'status' => 'failed',
                "error" => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ]
            ];
        }
        return new JsonResponse($result);
    }

    /**
     * Get weekly discount book infomation from redis.
     *
     * @Route(
     *      "/book/discount/week/{source}",
     *      name="discount_week",
     *      requirements={"source" : "bookscom|taaze|sanmin|iread"})
     *
     * @Method("GET")
     */
    public function weeklyDiscountAction(Request $request, $source)
    {
        header('Access-Control-Allow-Origin: http://maja-lin.github.io');
        header('Access-Control-Allow-Methods: GET, PUT');
        header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept');
        header('Access-Control-Allow-Credentials: true');

        try {
            Autoloader::register();
            $redis = new Client(getenv('REDIS_URL'));

            $page = $redis->get($source);
            if (empty($page) || is_null($page)) {
                throw new \Exception("There is no data.", 100);
            }
            if (strlen($page) <= 200) {
                throw new \Exception("Something wrong with data.", 101);
            }

            $result = [
                'status' => 'successful',
                'data' => json_decode($page),
            ];

        } catch (\Exception $e) {
            if ($e->getCode() == 100 || $e->getCode() == 101) {
                $response = $this->forward(
                    'PriceCrawlerBundle:Book:weeklyDiscountUpdate',
                    ['source' => $source]
                );
                return $response;
            }
            $result = [
                'status' => 'failed',
                "error" => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ]
            ];
        }
        return new JsonResponse($result);
    }

    /**
     * Get raw data from redis.
     *
     * @Route(
     *      "/book/discount/week/raw/{source}",
     *      name="raw_discount_week",
     *      requirements={"source" : "bookscom|taaze|sanmin|iread"})
     *
     * @Method("GET")
     */
    public function rawWeeklyDiscountAction(Request $request, $source)
    {
        try {
            Autoloader::register();
            $redis = new Client(getenv('REDIS_URL'));

            $page = $redis->get($source);
            if (empty($page) || is_null($page)) {
                throw new \Exception("There is no data.", 100);
            }
            if (strlen($page) <= 200) {
                throw new \Exception("Something wrong with data.", 101);
            }

            $raw = json_decode($page);
            $raw = urldecode($raw);
            $raw = unserialize($raw);

            $result = [
                'status' => 'successful',
                'data' => $raw,
            ];

        } catch (\Exception $e) {
            if ($e->getCode() == 100 || $e->getCode() == 101) {
                $response = $this->forward(
                    'PriceCrawlerBundle:Book:weeklyDiscountUpdate',
                    ['source' => $source]
                );
                return $response;
            }
            $result = [
                'status' => 'failed',
                "error" => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ]
            ];
        }
        return new JsonResponse($result);
    }

    /**
     * Clean all data in redis.
     *
     * @Route("/admin/{key}/redis/clean",name="clean_redis")
     *
     * @Method("DELETE")
     */
    public function cleanRedisAction(Request $request, $key)
    {
        header('Access-Control-Allow-Methods: DELETE');

        try {
            $dir = __DIR__ . "/../../../../";
            $keyFile = $dir . "key.json";
            $serverKey = file_get_contents($keyFile);
            $serverKey = json_decode($serverKey);

            if ($serverKey->key !== $key) {
                throw new \Exception("The key is not verified.");
            }

            $kernel = $this->get('kernel');
            $application = new Application($kernel);
            $application->setAutoExit(false);
            $input = new ArrayInput(['command' => 'redis:clean']);
            $output = new NullOutput();
            $time = date('Y-m-d, H:i:s');
            $application->run($input, $output);

            $result = [
                'status' => 'successful',
                'data' => 'Redis has been cleaned at ' . $time
            ];

        } catch (\Exception $e) {
            $result = [
                'status' => 'failed',
                "error" => [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                ]
            ];
        }
        return new JsonResponse($result);
    }
}
