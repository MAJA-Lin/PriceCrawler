<?php
	include_once "src/LIB_http.php";
	include_once "src/LIB_parse.php";
	include_once "search_class.php";

	$target = "http://search.books.com.tw/exep/prod_search.php";
	$method = "GET";
	$ref = "www.google.com";
	//$data_array['key'] = "無敵 林肯";
	$data_array['key'] = $_GET['keyword'];
	$data_array['cat'] = "BKA";
	$reponse = http($target, $ref, $method, $data_array, EXCL_HEAD);
	print_r($reponse);























?>