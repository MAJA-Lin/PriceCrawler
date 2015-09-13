<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Sample</title>
</head>
<body>
	<script src="//code.jquery.com/jquery-1.4.2.min.js"></script>
	<script src="src/js/jquery.lazyload.min.js"></script>
</body>
</html>
<?php
	include_once "src/LIB_http.php";
	include_once "src/LIB_parse.php";
	//include_once "discount_class.php";
	include_once "basic_class.php";
	include_once "src/data_managing.php";

	/*1.0 ver

	//Download the target file
	$target = "http://www.books.com.tw/";
	$page_array = file($target);

	//Echo contenets of file
	for($i=0; $i < count($page_array); $i++)
		echo $page_array[$i];
	*/


	//2.0 ver


		$action = "http://search.books.com.tw/exep/prod_search.php";
		$method = "GET";
		$ref = "www.google.com";
		$data_array['key'] = "無敵 林肯";
		$data_array['cat'] = "BKA";
		$reponse = http($action, $ref, $method, $data_array, EXCL_HEAD);
		print_r($reponse);



		/*
		$data_QQ['key'] = "哆啦A夢";
		$data_QQ['cat'] = "all";
		*/
		/*
		$search = new discount_page("http://search.books.com.tw/exep/prod_search.php", "", "GET", $data_QQ);
		$result2 = $search->pageParsing();
		print_r($result2);
		*/



		$test = "<br>I'm A <br> Doctor <br> U know<br>?";
		$test = remove($test, "<b", "r>");
		$test = xmpTag($test);
		echo $test;

?>