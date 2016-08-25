PriceCrawler
====

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

每周特價

        @GET your_server/book/discount/week/{source}

Get the weekly discount book info (每日66折資訊) from redis.

This service now support *博客來, 讀冊, 三民 & 灰熊 iread*

{source} should be:

    1. bookscom
    2. taaze
    3. sanmin
    4. iread

每周特價 (for checking data is correct)

        @GET your_server/book/discount/week/raw/{source}

Get the weekly discount book info (每日66折資訊) from redis.

This is raw data, you can check if the data in redis is right or not without decoding the data.

This service now support *博客來, 讀冊, 三民 & 灰熊 iread*

{source} should be:

    1. bookscom
    2. taaze
    3. sanmin
    4. iread



####   PUT ###
        @PUT your_server/book/discount/week/{source}

Fetch the latest discount info (每日66折資訊) and save it into redis.




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
