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
		"name_b" => "img class=\"itemcov\" alt=\"",
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
		"img_e" => "width=",
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

	/*
	*
	*	Taaze的搜尋頁面使用javascript進行輸出, 目前無法抓到JS的輸出內容, 先行pass
	*	三民也是用JS輸出搜尋結果
	*
	*
	*
	*
	*/

	function printResult($obj) {



		for ($i=0; $i<count($obj->book_name); $i++) {

			/*
			*
			*	暫時放上各個商店搜尋連結代替
			*
			*
			*/
			$iread = "https://www.iread.com.tw/search_results.aspx?Condition=0&skeyword=".$obj->book_name[$i];
			$sanmin = "http://www.m.sanmin.com.tw/Search/Index/?ct=K&qu=".$obj->book_name[$i];
			$taaze = "http://www.taaze.tw/searchmain.html?sty=0&skw=".$obj->book_name[$i];


			$match = new search_book_page();
			$match->setArray();
			$match->setBookInfo($obj->book_name[$i], $obj->publishing_house[$i]);
			searchMatch($match);

			//$temp = serialize($this);
			//var_dump($temp);
			echo "<article><div class=\"post-image\"><div class=\"post-heading\">";
			//<h3><a href="#">This is an example of standard post format</a></h3>
			echo "<h3><a href=\"\">";
			echo $obj->book_name[$i]."</a></h3></div>";
			echo "<img src=\"".$obj->book_img[$i]."\" alt=\"\" width=\"200\"/></div>";
			echo "<p>";
			echo "<h4><strong>售價: </strong></h4><br>";
			echo "<h3><a href=\"".$obj->book_link[$i]."\">博客來</a> : ".$obj->book_price[$i]."<br></h3>";
			echo "<h3><a href=\"".$taaze."\">讀冊</a><br></h3>";
			echo "<h3><a href=\"".$iread."\">灰熊</a><br></h3>";
			echo "<h3><a href=\"".$sanmin."\">三民</a><br></h3>";
			echo "</p>";
			echo "<div class=\"bottom-article\"><ul class=\"meta-post\">";
			echo "<li><i class=\"icon-calendar\"></i><a href=\"#\">".$obj->book_date[$i]."</a></li>";
			echo "<li><i class=\"icon-user\"></i><a href=\"#\">".$obj->publishing_house[$i]."</a></li></ul>";
			echo "<a href=\"#\" class=\"pull-right\"> <i class=\"icon-angle-right\"> #</i></a></div></article>";

		}
	}

	function searchMatch($match) {


		//$taaze = "http://www.taaze.tw/searchmain.html?sty=0&skw=".$match->book_name;
		/*
		$taaze_data['keyType'] = "0";
		$taaze_data['keyword'] = $match->book_name;
		$taaze_data['prodKind'] = "1";
		$taaze_data['prodCatId'] = "A";
		//
		$taaze_data['sty'] = "0";
		$taaze_data['skw'] = $match->book_name;

		$data_array = "";
		$taaze_result = $match->pageParsing($taaze, $data_array);

		print_r($taaze_result);
		*/

		$iread = "https://www.iread.com.tw/search_results.aspx?Condition=0&skeyword=".$match->book_name;
		$data_array = "";
		$iread_result = $match->pageParsing($iread, $data_array);

		//print_r($iread_result);


	}



?>

<a href=""></a>