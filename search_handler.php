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
	$search_tag_array = [
		"name_b" => "img class=\"itemcov\" alt=",
		"name_e" => "\" data-original",
		"price_b" => "優惠價：",
		"price_e" => "元",
		"label_b" => "",
		"label_e" => "",
		"discount_b" => "",
		"discount_e" => "",
		"link_b" => "rel=\"mid_name\" href=\"",
		"link_e" => "\" title",
		"img_b" => "data-original=\"",
		"img_e" => "&w=",
		"date_b" => "出版日期：",
		"date_e" => "<BR>",
		"publisher_b" => "\"mid_publish\"",
		"publisher_e" => "\">",
		"author_b" => "",
		"author_e" => "",
	];

	$bookstw_search = new search_book_result($target, $ref, $method, $data_array);
	$bookstw_search->setArray();

	$bookstw_search_result = $bookstw_search->pageParsing();
	$temp = dataCatcher($bookstw_search_result['FILE'], $tag_b, $tag_e);
	//$temp = iconv("Big5", "utf-8", $temp);
	//print_r($temp);
	$bookstw_search->setAllValue($temp, $search_tag_array);
	//var_dump($bookstw_search);

	/*
	$reponse = http($target, $ref, $method, $data_array, EXCL_HEAD);
	print_r($reponse);
	*/























?>