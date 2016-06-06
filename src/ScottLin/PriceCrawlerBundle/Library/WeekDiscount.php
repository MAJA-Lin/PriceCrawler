<?php

namespace ScottLin\PriceCrawlerBundle\Library;

use MichaelSchrenk\WebbotBundle\Library\Parse;
use MichaelSchrenk\WebbotBundle\Library\Http;

/**
 *
 */
class WeekDiscount
{
    /**
     * Basic variables to construct connection.
     */
    private $targetLink;
    private $ref;
    private $method;
    private $dataArray;
    private $source;

    /**
     * Book info which has been managed.
     */
    private $bookInfo = [];

    /**
     * Tags of parsing website
     * splitTags is used to clean raw data.
     */
    private $tags = [];
    private $splitTags = [];

    /**
     * Other private variables
     */
    private $http;
    private $parse;

    /**
     * Week discount constructor.
     *
     * @param string $targetLink
     * @param string $ref
     * @param string $method
     * @param string $dataArray
     */
    public function __construct($targetLink, $ref, $method, $dataArray, $source)
    {
        $this->targetLink = $targetLink;
        $this->ref = $ref;
        $this->method = $method;
        $this->dataArray = $dataArray;
        $this->source = $source;
        $this->http = new Http;
        $this->parse = new Parse;
    }

    /**
     * Set data tags.
     *
     * @param array $parsingTagArray
     * @return WeekDiscount
     */
    public function setDataTag($parsingTagArray)
    {
        $this->tags['begin'] = $parsingTagArray['begin'];
        $this->tags['end'] = $parsingTagArray['end'];

        $this->tags['name_begin'] = $parsingTagArray['name_begin'];
        $this->tags['name_end'] = $parsingTagArray['name_end'];

        $this->tags['price_begin'] = $parsingTagArray['price_begin'];
        $this->tags['price_end'] = $parsingTagArray['price_end'];

        $this->tags['label_price_begin'] = $parsingTagArray['label_price_begin'];
        $this->tags['label_price_end'] = $parsingTagArray['label_price_end'];

        $this->tags['discount_begin'] = $parsingTagArray['discount_begin'];
        $this->tags['discount_end'] = $parsingTagArray['discount_end'];

        $this->tags['book_link_begin'] = $parsingTagArray['book_link_begin'];
        $this->tags['book_link_end'] = $parsingTagArray['book_link_end'];

        $this->tags['img_begin'] = $parsingTagArray['img_begin'];
        $this->tags['img_end'] = $parsingTagArray['img_end'];

        $this->tags['date_begin'] = $parsingTagArray['date_begin'];
        $this->tags['date_end'] = $parsingTagArray['date_end'];

        return $this;
    }

    /**
     * Get data tags
     *
     * @return array
     */
    public function getDataTag()
    {
        return $this->tags;
    }

    /**
     * Set split tags
     *
     * @param array
     * @return WeekDiscount
     */
    public function setSplitTag($splitArray)
    {
        $this->splitTags = $splitArray;
        return $this;
    }

    /**
     * Get weekly book discount info.
     *
     * @return array
     */
    public function getBookInfo()
    {
        return $this->bookInfo;
    }

    /**
     * Parse the whole target website
     *
     * @return array
     */
    public function targetPageParsing()
    {
        $result = $this->http->http(
            $this->targetLink, $this->ref, $this->method, $this->dataArray, EXCL_HEAD
        );
        return $result;
    }

    /**
     * Return the weekly discount infomation.
     *
     * @param string $pageFile
     * @param string $source
     * @return WeekDiscount
     */
    public function returnBookInfo($pageFile, $source)
    {
        $rawData = $this->parse->return_between(
            $pageFile, $this->tags['begin'], $this->tags['end'], EXCL
        );

        $result = $this->splitRawData($rawData);
        return $this;
    }

    /**
     * Split raw data with tags.
     *
     * @param string $rawData
     * @return WeekDiscount
     */
    private function splitRawData($rawData)
    {
        $name[] = $this->parse->parse_array(
            $rawData, $this->tags['name_begin'], $this->tags['name_end']
        );
        $price[] = $this->parse->parse_array(
            $rawData, $this->tags['price_begin'], $this->tags['price_end']
        );
        $discount[] = $this->parse->parse_array(
            $rawData, $this->tags['discount_begin'], $this->tags['discount_end']
        );
        $link[] = $this->parse->parse_array(
            $rawData, $this->tags['book_link_begin'], $this->tags['book_link_end']
        );
        $img[] = $this->parse->parse_array(
            $rawData, $this->tags['img_begin'], $this->tags['img_end']
        );
        $date[] = $this->parse->parse_array(
            $rawData, $this->tags['date_begin'], $this->tags['date_end']
        );

        if ($this->source != 'sanmin' && $this->source != 'iread') {
            $label[] = $this->parse->parse_array(
                $rawData, $this->tags['label_price_begin'], $this->tags['label_price_end']
            );
        }

        // There will be no label price in sanmin & iread, so set 0 here.
        if ($this->source == 'sanmin' || $this->source == 'iread') {
            $label = [
                '0' => [
                    '0', '0', '0', '0', '0', '0', '0',
                ]
            ];
        }

        $i = 0;
        foreach ($name[0] as $value) {
            $this->bookInfo[$i] = [
                'bookName' => $value,
                'price' => $price[0][$i],
                'label' => $label[0][$i],
                'discount' => $discount[0][$i],
                'link' => $link[0][$i],
                'img' => $img[0][$i],
                'date' => $date[0][$i]
            ];
            $i++;
        }

        // Clean the unnecessary character, html tags...
        foreach ($this->bookInfo as $key => $value) {
            $this->bookInfo[$key]['price'] = $this->parse->return_between(
                $value['price'], $this->tags['price_begin'], $this->tags['price_end'], EXCL
            );
            $this->bookInfo[$key]['discount'] = $this->parse->return_between(
                $value['discount'], $this->tags['discount_begin'], $this->tags['discount_end'], EXCL
            );
            $this->bookInfo[$key]['img'] = $this->parse->return_between(
                $value['img'], $this->tags['img_begin'], $this->tags['img_end'], EXCL
            );
            $this->bookInfo[$key]['date'] = $this->parse->return_between(
                $value['date'], $this->tags['date_begin'], $this->tags['date_end'], EXCL
            );

            // Raw data of Sanmin doesn't contain label price
            if ($this->source != "sanmin" && $this->source != "iread") {
                $this->bookInfo[$key]['label'] = $this->parse->return_between(
                    $value['label'], $this->tags['label_price_begin'], $this->tags['label_price_end'], EXCL
                );
            }

            // 這部分是抓取博客來的資料(有些欄位有特別字元需要清理)
            // Clean the tag and char in raw data of books.com.tw
            if ($this->source == "bookscom") {
                $this->bookInfo[$key]['bookName'] = $this->parse->return_between(
                    $value['bookName'], $this->splitTags['name_begin'], $this->splitTags['name_end'], EXCL
                );
                $this->bookInfo[$key]['link'] = $this->parse->return_between(
                    $value['link'], $this->splitTags['link_begin'], $this->splitTags['link_end'], EXCL
                );

                // Make image address more readable.
                $this->bookInfo[$key]['img'] = $this->parse->split_string(
                    $this->bookInfo[$key]['img'], $this->splitTags['img_pre'], AFTER, EXCL
                );
                $this->bookInfo[$key]['img'] = $this->parse->split_string(
                    $this->bookInfo[$key]['img'], $this->splitTags['img_post'], BEFORE, EXCL
                );

                // String to date
                $this->bookInfo[$key]['date'] = $this->stringToDate($this->bookInfo[$key]['date']);

            } else { // Clean bookName and link 這部分則是抓取剩下的資料(除博客來以外都可通用)
                $this->bookInfo[$key]['bookName'] = $this->parse->return_between(
                    $value['bookName'], $this->tags['name_begin'], $this->tags['name_end'], EXCL
                );
                $this->bookInfo[$key]['link'] = $this->parse->return_between(
                    $value['link'], $this->tags['book_link_begin'], $this->tags['book_link_end'], EXCL
                );
            }

            // 讓taaze的日期格式化
            // Clean date of taaze
            if ($this->source == 'taaze') {
                // Check if raw date is a period
                if (strlen($value['date']) > 15) {
                    $value['date'] = $this->parse->split_string(
                        $value['date'], $this->splitTags['date1'], BEFORE, EXCL
                    );
                }
                $value['date'] = str_replace(
                    $this->splitTags['date2'], "", $value['date']
                );
                $value['date'] = str_replace(
                    $this->splitTags['date3'], "", $value['date']
                );
                $value['date'] = preg_replace(
                    '/\s+/', '', $value['date']
                );
                $value['date'] = str_replace(
                    $this->splitTags['date4'], "", $value['date']
                );
                $this->bookInfo[$key]['date'] = $this->stringToDate($value['date']);
            }

            // 處理Sanmin的資料
            // Clean the raw data from sanmin. Because there is no label price in raw data,
            //      we have to calculate ourselves.
            if ($this->source == "sanmin") {
                $this->bookInfo[$key]['bookName'] = $this->parse->split_string(
                    $this->bookInfo[$key]['bookName'], $this->splitTags['name'], AFTER, EXCL
                );

                $this->bookInfo[$key]['label'] = ceil(
                    $this->bookInfo[$key]['price'] / ($this->bookInfo[$key]['discount'] / 100)
                );

                $this->bookInfo[$key]['date'] = $this->stringToDateSplitChinese($this->bookInfo[$key]['date']);
            }

            // 灰熊iread
            // Add iRead domain address to [link] and [img]
            if ($this->source == "iread") {
                $this->bookInfo[$key]['bookName'] = $this->parse->split_string(
                    $this->bookInfo[$key]['bookName'], $this->splitTags['name'], AFTER, EXCL
                );

                $this->bookInfo[$key]['label'] = ceil(
                    $this->bookInfo[$key]['price'] / ($this->bookInfo[$key]['discount'] / 100)
                );

                $this->bookInfo[$key]['link'] = $this->splitTags['domain'] . $this->bookInfo[$key]['link'];
                $this->bookInfo[$key]['img'] = $this->splitTags['img'] . $this->bookInfo[$key]['img'];

                $this->bookInfo[$key]['date'] = $this->stringToDateSplitChinese($this->bookInfo[$key]['date']);
            }
        }

        return $this;
    }

    /**
     * Transfer String to the following format =>  date('m/d') => e.g. 12/25
     * This function suits 'books.com.tw' and 'taaze.com.tw'
     *
     * @param string $rawDate
     * @return string
     */
    private function stringToDate($rawDate)
    {
        $week = ["(一)", "(二)", "(三)", "(四)", "(五)", "(六)", "(日)"];
        $blank = "";
        $tilde = "~";
        $bar = " - ";

        for ($i=0; $i < count($week); $i++) {
            $rawDate = str_replace($week[$i], $blank, $rawDate);
        }

        // If Length > 10, then the date is a period. (e.g. 09/07(一)~09/10(四))
        if(strlen($rawDate)>10) {
            $rawDate = str_replace($tilde, $bar, $rawDate);
        }

        return $rawDate;
    }

    /**
     * Transfer string to date, and delete chinese char, e.g. '月', '日'
     *
     * @param string $rawDate
     * @return string
     */
    private function stringToDateSplitChinese($rawDate)
    {
        $month = "月";
        $day = "日";

        $mm = $this->parse->split_string($rawDate, $month, BEFORE, EXCL);
        $temp = $this->parse->split_string($rawDate, $month, AFTER, EXCL);
        $dd = $this->parse->split_string($temp, $day, BEFORE, EXCL);

        // Add zero. e.g. => 4/1 -> 04/01
        if(strlen($mm)<2) {
            $mm = "0" . $mm;
        }

        if(strlen($dd)<2) {
            $dd = "0" . $dd;
        }

        $result = $mm . "/" . $dd;
        return $result;
    }

}
