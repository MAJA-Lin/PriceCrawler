# PriceCrawler

A restful app that parse book discount information from bookstore in Taiwan.

This project is based on Symfony 3.0.


[DEMO](http://maja-lin.github.io/PriceCrawler/WeeklyDiscount.html)

## Prerequisite
+   php >= 5.5

+   Composer

+   Redis  (If you're using windows, you can try [Redis on Windows](https://github.com/MSOpenTech/redis) )


## Install

        composer install

## Run

        php bin/console server:run

Then symfony server will run at 127.0.0.1:8000.

You can check [here](http://symfony.com/doc/current/book/installation.html#running-the-symfony-application) for more information.


## RESTful API

####   GET ###
        @GET your_server/book/discount/week/{source}

Get the weekly discount book info (每日66折資訊) from redis.

This service now support *博客來, 讀冊, 三民 & 灰熊 iread*

{source} should be:

    1. bookscom
    2. taaze
    3. sanmin
    4. iread


And the response will be like:

    {
    "status": "successful",
    "data": "a%3A9%3A%7Bi%3A0%3Ba%3A7%3A%7Bs%3A8%3A%22bookName%22%3Bs%3A102%3A%22%E5%BE%B9%E5%BA%95%E7%9C%8B%E6%87%82%E8%87%AA%E8%A1%8C%E8%BB%8A%E5%8A%9F%E7%8E%87%E8%A8%93%E7%B7%B4%E6%95%B8%E6%93%9A%EF%BC%9A%E9%80%8F%E9%81%8E%E5%8A%9F%E7%8E%87%E8%A8%88%E8%88%87WKO%E7%9A%84%E7%9B%A3%E6%8E%A7%E5%92%8C%E5%88%86%E6%9E%90%EF%BC%8C%E6%8F%90%E5%8D%87%E9%A8%8E%E4%B9%98%E5%AF%A6%E5%8A%9B%22%3Bs%3A5%3A%22price%22%3Bs%3A3%3A%22200%22%3Bs%3A5%3A%22label%22%3Bs%3A3%3A%22399%22%3Bs%3A8%3A%22discount%22%3Bs%3A1%3A%225%22%3Bs%3A4%3A%22link%22%3Bs%3A45%3A%22http%3A%2F%2Fwww.taaze.tw%2Fsing.html%3Fpid%3D14100018666%22%3Bs%3A3%3A%22img%22%3Bs%3A56%3A%22http%3A%2F%2Fmedia.taaze.tw%2FshowLargeImage.html%3Fsc%3D14100018666%22%3Bs%3A4%3A%22date%22%3Bs%3A13%3A%2208%2F22+-+08%2F25%22%3B%7Di%3A1%3Ba%3A7%3A%7Bs%3A8%3A%22bookName%22%3Bs%3A36%3A%22%E6%97%A9%E5%AE%89%E5%81%A5%E5%BA%B7+7-8%E6%9C%88%E8%99%9F%2F2016+%E7%AC%AC19%E6%9C%9F%22%3Bs%3A5%3A%22price%22%3Bs%3A2%3A%2250%22%3Bs%3A5%3A%22label%22%3Bs%3A2%3A%2299%22%3Bs%3A8%3A%22discount%22%3Bs%3A1%3A%225%22%3Bs%3A4%3A%22link%22%3Bs%3A45%3A%22http%3A%2F%2Fwww.taaze.tw%2Fsing.html%3Fpid%3D25100004372%22%3Bs%3A3%3A%22img%22%3Bs%3A56%3A%22http%3A%2F%2Fmedia.taaze.tw%2FshowLargeImage.html%3Fsc%3D25100004372%22%3Bs%3A4%3A%22date%22%3Bs%3A13%3A%2208%2F26+-+08%2F28%22%3B%7Di%3A2%3Ba%3A7%3A%7Bs%3A8%3A%22bookName%22%3Bs%3A15%3A%22%E5%B7%B4%E6%8B%BF%E9%A6%AC%E6%96%87%E4%BB%B6%22%3Bs%3A5%3A%22price%22%3Bs%3A3%3A%22264%22%3Bs%3A5%3A%22label%22%3Bs%3A3%3A%22400%22%3Bs%3A8%3A%22discount%22%3Bs%3A2%3A%2266%22%3Bs%3A4%3A%22link%22%3Bs%3A45%3A%22http%3A%2F%2Fwww.taaze.tw%2Fsing.html%3Fpid%3D11100782682%22%3Bs%3A3%3A%22img%22%3Bs%3A56%3A%22http%3A%2F%2Fmedia.taaze.tw%2FshowLargeImage.html%3Fsc%3D11100782682%22%3Bs%3A4%3A%22date%22%3Bs%3A5%3A%2208%2F22%22%3B%7Di%3A3%3Ba%3A7%3A%7Bs%3A8%3A%22bookName%22%3Bs%3A27%3A%22%E6%94%B9%E8%AE%8A%E8%A1%97%E5%8D%80%E7%9A%84%E7%8D%A8%E7%AB%8B%E5%B0%8F%E5%BA%97%22%3Bs%3A5%3A%22price%22%3Bs%3A3%3A%22185%22%3Bs%3A5%3A%22label%22%3Bs%3A3%3A%22280%22%3Bs%3A8%3A%22discount%22%3Bs%3A2%3A%2266%22%3Bs%3A4%3A%22link%22%3Bs%3A45%3A%22http%3A%2F%2Fwww.taaze.tw%2Fsing.html%3Fpid%3D11100768934%22%3Bs%3A3%3A%22img%22%3Bs%3A56%3A%22http%3A%2F%2Fmedia.taaze.tw%2FshowLargeImage.html%3Fsc%3D11100768934%22%3Bs%3A4%3A%22date%22%3Bs%3A5%3A%2208%2F23%22%3B%7Di%3A4%3Ba%3A7%3A%7Bs%3A8%3A%22bookName%22%3Bs%3A27%3A%22%E9%82%A3%E5%B9%B4%E6%98%A5%E5%A4%A9%EF%BC%8C%E5%9C%A8%E8%BB%8A%E8%AB%BE%E6%AF%94%22%3Bs%3A5%3A%22price%22%3Bs%3A3%3A%22383%22%3Bs%3A5%3A%22label%22%3Bs%3A3%3A%22580%22%3Bs%3A8%3A%22discount%22%3Bs%3A2%3A%2266%22%3Bs%3A4%3A%22link%22%3Bs%3A45%3A%22http%3A%2F%2Fwww.taaze.tw%2Fsing.html%3Fpid%3D11100778348%22%3Bs%3A3%3A%22img%22%3Bs%3A56%3A%22http%3A%2F%2Fmedia.taaze.tw%2FshowLargeImage.html%3Fsc%3D11100778348%22%3Bs%3A4%3A%22date%22%3Bs%3A5%3A%2208%2F24%22%3B%7Di%3A5%3Ba%3A7%3A%7Bs%3A8%3A%22bookName%22%3Bs%3A48%3A%22%E6%84%9B%E7%9A%84%E8%83%BD%E9%87%8F%EF%BC%9A%E6%B4%BB%E5%8C%96%E8%A6%AA%E5%AF%86%E9%97%9C%E4%BF%82%E7%9A%84%E8%83%BD%E9%87%8F%E7%99%82%E6%B3%95%22%3Bs%3A5%3A%22price%22%3Bs%3A3%3A%22422%22%3Bs%3A5%3A%22label%22%3Bs%3A3%3A%22640%22%3Bs%3A8%3A%22discount%22%3Bs%3A2%3A%2266%22%3Bs%3A4%3A%22link%22%3Bs%3A45%3A%22http%3A%2F%2Fwww.taaze.tw%2Fsing.html%3Fpid%3D11100761543%22%3Bs%3A3%3A%22img%22%3Bs%3A56%3A%22http%3A%2F%2Fmedia.taaze.tw%2FshowLargeImage.html%3Fsc%3D11100761543%22%3Bs%3A4%3A%22date%22%3Bs%3A5%3A%2208%2F25%22%3B%7Di%3A6%3Ba%3A7%3A%7Bs%3A8%3A%22bookName%22%3Bs%3A39%3A%22%E4%B8%8A%E7%8F%AD%E4%B8%8D%E5%9B%A7%EF%BC%9A%E8%81%B7%E5%A0%B4%E5%BF%85%E5%82%99%E6%B3%95%E5%BE%8B%E5%B8%B8%E8%AD%98%22%3Bs%3A5%3A%22price%22%3Bs%3A3%3A%22238%22%3Bs%3A5%3A%22label%22%3Bs%3A3%3A%22360%22%3Bs%3A8%3A%22discount%22%3Bs%3A2%3A%2266%22%3Bs%3A4%3A%22link%22%3Bs%3A45%3A%22http%3A%2F%2Fwww.taaze.tw%2Fsing.html%3Fpid%3D11100779394%22%3Bs%3A3%3A%22img%22%3Bs%3A56%3A%22http%3A%2F%2Fmedia.taaze.tw%2FshowLargeImage.html%3Fsc%3D11100779394%22%3Bs%3A4%3A%22date%22%3Bs%3A5%3A%2208%2F26%22%3B%7Di%3A7%3Ba%3A7%3A%7Bs%3A8%3A%22bookName%22%3Bs%3A33%3A%22%E6%96%B0%E8%AD%AF%E2%80%A7%E5%8F%A4%E6%96%87%E8%A7%80%E6%AD%A2%EF%BD%9B%E6%96%B0%E7%89%88%EF%BD%9D%22%3Bs%3A5%3A%22price%22%3Bs%3A3%3A%22164%22%3Bs%3A5%3A%22label%22%3Bs%3A3%3A%22249%22%3Bs%3A8%3A%22discount%22%3Bs%3A2%3A%2266%22%3Bs%3A4%3A%22link%22%3Bs%3A45%3A%22http%3A%2F%2Fwww.taaze.tw%2Fsing.html%3Fpid%3D11100777353%22%3Bs%3A3%3A%22img%22%3Bs%3A56%3A%22http%3A%2F%2Fmedia.taaze.tw%2FshowLargeImage.html%3Fsc%3D11100777353%22%3Bs%3A4%3A%22date%22%3Bs%3A5%3A%2208%2F27%22%3B%7Di%3A8%3Ba%3A7%3A%7Bs%3A8%3A%22bookName%22%3Bs%3A48%3A%22%E6%A8%82%E9%81%8A%E9%97%9C%E8%A5%BF%EF%BC%9A%E5%A4%A7%E9%98%AA%EF%BC%8E%E4%BA%AC%E9%83%BD%EF%BC%8E%E7%A5%9E%E6%88%B6%EF%BC%8E%E5%A5%88%E8%89%AF%22%3Bs%3A5%3A%22price%22%3Bs%3A3%3A%22231%22%3Bs%3A5%3A%22label%22%3Bs%3A3%3A%22350%22%3Bs%3A8%3A%22discount%22%3Bs%3A2%3A%2266%22%3Bs%3A4%3A%22link%22%3Bs%3A45%3A%22http%3A%2F%2Fwww.taaze.tw%2Fsing.html%3Fpid%3D11100725757%22%3Bs%3A3%3A%22img%22%3Bs%3A56%3A%22http%3A%2F%2Fmedia.taaze.tw%2FshowLargeImage.html%3Fsc%3D11100725757%22%3Bs%3A4%3A%22date%22%3Bs%3A5%3A%2208%2F28%22%3B%7D%7D"
    }

Because *data* contains utf-8 character, I use **urlencode** and **serialize** to encode the data.

The original data before encoding process is like:

    {
      "status": "successful",
      "data": [
        {
          "bookName": "sample book name 1",
          "price": "200",
          "label": "399",
          "discount": "5",
          "link": "sample.link",
          "img": "sample.img.link",
          "date": "08/22 - 08/25"
        },
        {
          "bookName": "sample book name 3",
          "price": "264",
          "label": "400",
          "discount": "66",
          "link": "sample.link",
          "img": "sample.img.link",
          "date": "08/22"
        },
        ...
      ]
    }



####   PUT ###
        @PUT your_server/book/discount/week/{source}

Fetch the latest discount info (每日66折資訊) and save it into redis.

This is not accessible by users and it will be automatically executed by server while there is no data on redis.



***

PriceCrawler是一個專門爬取台灣網路書店每周特價資訊的服務.

你可以直接點擊 [DEMO](http://maja-lin.github.io/PriceCrawler/WeeklyDiscount.html) 觀看本周的66折特賣書籍, 或是使用API服務直接取得資料.

後端架設在heroku上面, 而前端則是採用了Github的gh-pages服務, 達成前後端分離.

如果DEMO頁出現錯誤時, 你也可以直接存取

        @GET https://safe-shelf-6136.herokuapp.com/book/discount/week/raw/{source}

來取得特價資訊.

目前支援的書店有:


    1. bookscom
    2. taaze
    3. sanmin
    4. iread

依序是博客來、讀冊、三民以及灰熊.

另外, 後端heroku伺服器設定每一個小時就會刷新資料, 如果有特價資訊不正確的地方請等待伺服器資料更新, 或是使用github的issue功能通知我.
