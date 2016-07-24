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
use MichaelSchrenk\WebbotBundle\Library\Parse;
use MichaelSchrenk\WebbotBundle\Library\Http;
use ScottLin\PriceCrawlerBundle\Library\WeekDiscount;

class BookController extends Controller
{
    /**
     * @Route("/book")
     */
    public function bookMenuAction(Request $request)
    {

    }

    /**
     * Get weekly discount book infomation and save it to redis.
     *
     * @Route(
     *      "/book/discount/week/{source}",
     *      name="discount_week_update",
     *      requirements={"source" : "bookscom|taaze|sanmin|kingstone|iread"})
     *
     * @Method("PUT")
     */
    public function weeklyDiscountUpdateAction(Request $request, $source)
    {
        $parse = new Parse;

        $ref = "www.google.com.tw";
        $link = [
            "bookscom" => "http://www.books.com.tw/activity/gold66_day/",
            "taaze" => "http://www.taaze.tw/act66.html",
            "sanmin" => "http://activity.sanmin.com.tw/Today66",
            "iread" => "https://www.iread.com.tw/alldiscount.aspx"
        ];

        // Here are defination of target data tags.
        $tagArray = [
                "bookscom" => [
                    "begin" => "<div id =\"left\">",
                    "end" => "<div id=\"left_end\">",
                    "name_begin" => "<h1><a href=\"http://www.books.com.tw/products",
                    "name_end" => "</a></h1>",
                    "label_price_begin" => "<h2>定價：",
                    "label_price_end" => "元</h2>",
                    "price_begin" => "<b class=\"price\">",
                    "price_end" => "</b>元",
                    "discount_begin" => "元</h2><h2>",
                    "discount_end" => "折",
                    "book_link_begin" => "<a href=\"http://www.books.com.tw/products",
                    "book_link_end" => "\">",
                    "img_begin" => "img src=\"",
                    "img_end" => "/>",
                    "date_begin" => "class=\"day\">",
                    "date_end" => "</div>",
                ],
                "taaze" => [
                    "begin" => "<!-- 循環當週55折預告start -->",
                    "end" => "<!-- 循環當週66折預告end -->",
                    "name_begin" => "class=\"text\"><span class=\"txt-b\">",
                    "name_end" => "</span></TD>",
                    "price_begin" => "折<span class=\"66-pink-s\">",
                    "price_end" => "</span>元",
                    "label_price_begin" => "class=\"text\">定價：",
                    "label_price_end" => "元</TD>",
                    "discount_begin" => "優惠價：<span class=\"66-pink-s\">",
                    "discount_end" => "</span>折",
                    "book_link_begin" => "\"#CCCCCC\"><a href=\"",
                    "book_link_end" => "\" target",
                    "img_begin" => "blank\"><img src=\"",
                    "img_end" => "\" width=\"90\"",
                    "date_begin" => "<span class=\"date\">",
                    "date_end" => "</span></td>",
                ],
                "sanmin" => [
                    "begin" => "<div class=\"ActivityBody\" style=\"\">",
                    "end" => "<!--end left-->",
                    "name_begin" => "<tr><td><a href=\"http://www.m.sanmin.com.tw/Product/Index",
                    "name_end" => "</a></td>",
                    "price_begin" => "66折優惠價：<span>",
                    "price_end" => "</span> 元",
                    "label_price_begin" => "",
                    "label_price_end" => "",
                    "discount_begin" => "class=\"gray\" >",
                    "discount_end" => "折優惠價：",
                    "book_link_begin" => "<tr><td><a href=\"",
                    "book_link_end" => "\">",
                    "img_begin" => "original=\"",
                    "img_end" => "\" alt",
                    "date_begin" => "font-weight:bold\">",
                    "date_end" => " </td></tr>",
                ],
                "iread" => [
                    "begin" => "<div id=\"Weekly_bargain\">",
                    "end" => "</div><!--Weekly_bargain-->",
                    "name_begin" => "<li class=\"BookTitle\">",
                    "name_end" => "</a>",
                    "price_begin" => "折<span class=\"redword\">",
                    "price_end" => "</span>元",
                    "label_price_begin" => "",
                    "label_price_end" => "",
                    "discount_begin" => "優惠價：<span class=\"redword\">",
                    "discount_end" => "</span>折",
                    "book_link_begin" => "ProdNameLink\" href=\"",
                    "book_link_end" => "\">",
                    "img_begin" => "<img src=\"ProductFile",
                    "img_end" => "\" border=\"0\"",
                    "date_begin" => "<li class=\"Date\">",
                    "date_end" => " <span",
                ]
        ];

        $splitArray = [
            "bookscom" => [
                "name_begin" => "\">",
                "name_end" => "</",
                "link_begin" => "href=\"",
                "link_end" => "\">",
                "img_pre" => "getImage?image=",
                "img_post" => "&v=",
            ],
            "taaze" => [
                "date1" => "</span>",
                "date2" => "<br>",
                "date3" => "<br/>",
                "date4" => "<spanclass=\"date\">",
            ],
            "sanmin" => [
                "name" => "\">",
            ],
            "iread" => [
                "name" => "\">",
                "domain" => "https://www.iread.com.tw/",
                "img" => "https://www.iread.com.tw/ProductFile"
            ]
        ];

        try {

            Autoloader::register();
            $redis = new Client();

            $page = new WeekDiscount($link[$source], $ref, "GET", "", $source);
            $parsingResult = $page->targetPageParsing();

            if ($parsingResult['FILE'] === FALSE) {
                throw new \Exception($parsingResult['ERROR']);
            }

            $page->setDataTag($tagArray[$source]);
            $page->setSplitTag($splitArray[$source]);

            // Books.com.tw uses Big5, add this to transfer to UTF-8
            if ($source == 'bookscom') {
                $parsingResult['FILE'] = iconv("big5", "UTF-8", $parsingResult['FILE']);
            }

            $page->returnBookInfo($parsingResult['FILE'], $source);
            $finalPage = urlencode(serialize($page->getBookInfo()));
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
     *      requirements={"source" : "bookscom|taaze|sanmin|kingstone|iread"})
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
