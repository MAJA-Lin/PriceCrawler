<?php

namespace ScottLin\PriceCrawlerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Predis\Autoloader;
use Predis\Client;

class BookController extends Controller
{
    /**
     * @Route("/book")
     *
     * @Method("GET")
     */
    public function bookMenuAction(Request $request)
    {
        $result = [
            'status' => 'successful',
            'data' => 'HELLO',
        ];
        return new JsonResponse($result);
    }

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
            $redis = new Client();

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
        try {
            Autoloader::register();
            $redis = new Client();

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
     * @Route("/book/discount/bookstore", name="discount_beginookstore")
     *
     * @Method("GET")
     */
    public function bookstoreDiscountAction(Request $request)
    {

    }
}
