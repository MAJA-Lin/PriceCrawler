<?php
	include_once "src/LIB_http.php";
	include_once "src/LIB_parse.php";
	include_once "search_class.php";
	include_once "src/data_managing.php";

	$target = "http://search.books.com.tw/exep/prod_search.php";
	$method = "GET";
	$ref = "www.google.com";
	$data_array['key'] = $_GET['keyword'];
	$data_array['cat'] = "BKA";
	$tag_b = "<!--搜尋結果商品 始-->";
	$tag_e = "<!--搜尋結果商品 止-->";

	$bookstw_search = new search_book_result($target, $ref, $method, $data_array);
	$bookstw_search->setArray();

	$bookstw_search_result = $bookstw_search->pageParsing();
	$temp = dataCatcher($bookstw_search_result['FILE'], $tag_b, $tag_e);
	$temp = iconv("Big5", "utf-8", $temp);
	$bookstw_search->setAllValue($temp, $bookstw_search_result);

	/*
	$reponse = http($target, $ref, $method, $data_array, EXCL_HEAD);
	print_r($reponse);
	*/























?>