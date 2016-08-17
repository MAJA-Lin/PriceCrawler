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
