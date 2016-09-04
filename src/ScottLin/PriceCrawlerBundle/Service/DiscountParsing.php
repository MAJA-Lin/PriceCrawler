<?php

namespace ScottLin\PriceCrawlerBundle\Service;

use ScottLin\PriceCrawlerBundle\Library\WeekDiscount;

class DiscountParsing
{

    protected $source;

    /**
     * Set the bookstore.
     * 設定來源 (要抓取資料的書店)
     *
     * @param string $source
     * @return DiscountParsing
     */
    public function setSource($source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Get the bookstore source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Parse the discount data,
     *      and return it as an array that contains all books data and today's special.
     *      Encode them with urlencode/serialize, and return both data as an array.
     * 抓取資料, 並另外找出本日特價, 再作urlencode/serialize回傳.
     *
     *
     * @return array
     */
    public function bookParsing()
    {
        $source = $this->getSource();

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
                    "book_link_begin" => "<h1><a href=\"http://www.books.com.tw/products",
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

        $page = new WeekDiscount($link[$source], $ref, "GET", "", $source);
        $parsingResult = $page->targetPageParsing();

        if ($parsingResult['FILE'] === FALSE) {
            throw new \Exception($parsingResult['ERROR']);
        }

        $page->setDataTag($tagArray[$source]);
        $page->setSplitTag($splitArray[$source]);

        // Books.com.tw uses Big5, add this to transfer to UTF-8
        if ($source == 'bookscom') {
            $parsingResult['FILE'] = iconv("big5", "UTF-8//TRANSLIT//IGNORE", $parsingResult['FILE']);
        }

        $page->returnBookInfo($parsingResult['FILE'], $source);
        $finalPage = $page->getBookInfo();
        $weekBook = urlencode(serialize($finalPage));

        //Today's discount
        $today = date('m\/d');
        foreach ($finalPage as $key => $value) {
            if ($value['date'] == $today) {
                $todaySpecial = urlencode(serialize($value));
            }
        }

        if (empty($todaySpecial) || is_null($todaySpecial)) {
            $todaySpecial = 'empty';
        }

        $bookResult = [
            'weekBook' => $weekBook,
            'today' => $todaySpecial
        ];

        return $bookResult;
    }
}
