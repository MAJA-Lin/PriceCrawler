<?php
	include_once "src/LIB_http.php";
	include_once "src/LIB_parse.php";
	//include_once "discount_class.php";
	include_once "book_class.php";
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
		/*
		$target = "http://www.books.com.tw/";
		//$target = "http://fcu-ma.github.io/m/lessons.html";
		$ref = "www.google.com";
		$page_array = http_get($target, $ref);

		//var_dump($page_array);
		//printf("<h1>This is difference!!</h1><br><br>");

		$page_array2 = http_header($target, $ref);
		//var_dump($page_array2);

		$output = split_string($page_array['FILE'], "優惠價", AFTER, INCL);
		$output_incl = return_between($page_array['FILE'], "<form action", "</form>", INCL);
		$output_excl = return_between($page_array['FILE'], "<title>", "</title>", EXCL);
		*/

		//echo "<h3>HEY = </h3>".$output;
		/*
		echo "INCL = ".$output_incl;
		echo "<br>";
		echo "EXCL = ".$output_excl;
		*/
		//echo "<xmp>".$output_incl."</xmp>";

		/*
		$tag_output = parse_array($page_array['FILE'], "<img", ">");

		for($i=0; $i<count($tag_output); $i++)
		{
			$name = get_attribute($tag_output[$i], $attribute="src");
			//echo $tag_output[$i]."<br>";
			echo $name."<br>";
		}

		$action = "http://search.books.com.tw/exep/prod_search.php";
		$method = "GET";
		$data_array['key'] = "Snoopy";
		$data_array['cat'] = "BKA";
		$reponse = http($action, $ref, $method, $data_array, EXCL_HEAD);
		print_r($reponse);
		*/


		/*
		$data_QQ['key'] = "哆啦A夢";
		$data_QQ['cat'] = "all";
		*/
		/*
		$search = new discount_page("http://search.books.com.tw/exep/prod_search.php", "", "GET", $data_QQ);
		$result2 = $search->pageParsing();
		print_r($result2);
		*/

		#Test for taaze discount page
		/*
		echo "<h1>END</h1>";

		$taaze = new discount_book_page("http://www.taaze.tw/act66.html", "", "GET", "");
		$result3 = $taaze->pageParsing();
		$new_result = xmpTag($result3['FILE']);
		print_r($result3['FILE']);
		*/

		//$bookscom = new discount_book_page("http://www.books.com.tw/activity/gold66_day/", "", "GET", "");
		class books_com extends book_info
		{

			function setAllValue($data, $tag_array) {
				$this->book_name = splitColumn($data, $tag_array['name_b'], $tag_array['name_e']);
				$this->book_price = splitColumn($data, $tag_array['price_b'], $tag_array['price_e']);
				$this->book_label = splitColumn($data, $tag_array['label_b'], $tag_array['label_e']);
				$this->book_discount = splitColumn($data, $tag_array['discount_b'], $tag_array['discount_e']);

				$this->book_img = splitColumn($data, $tag_array['img_b'], $tag_array['img_e']);
				$this->book_date = splitColumn($data, $tag_array['date_b'], $tag_array['date_e']);

				//$this->book_link = splitColumn($this->book_name, $tag_array['link_b'], $tag_array['link_e']);

				/*
				*	Clean the data, only save the necessary data.
				*/
				for ($i=0; $i<count($this->book_name); $i++){
					$this->book_link[$i] = dataCatcher($this->book_name[$i], "href=\"", "\">");
					$this->book_name[$i] = dataCatcher($this->book_name[$i], "\">", "</");
					$this->book_price[$i] = dataCatcher($this->book_price[$i], $tag_array['price_b'], $tag_array['price_e']);
					$this->book_label[$i] = dataCatcher($this->book_label[$i], $tag_array['label_b'], $tag_array['label_e']);
					$this->book_discount[$i] = dataCatcher($this->book_discount[$i], $tag_array['discount_b'], $tag_array['discount_e']);
					$this->book_img[$i] = dataCatcher($this->book_img[$i], $tag_array['img_b'], $tag_array['img_e']);
					$this->book_date[$i] = dataCatcher($this->book_date[$i], $tag_array['date_b'], $tag_array['date_e']);
				}

			}
		}

		/*
		$bookscom = new books_com("http://www.books.com.tw/activity/gold66_day/", "", "GET", "");
		$bookscom->setArray();

		$tag1 = "<div id =\"left\">";
		$tag2 = "<div id=\"left_end\">";

		$tag_array = [
			"name_b" => "<h1><a href=\"http://www.books.com.tw/products",
			"name_e" => "</a></h1>",
			"label_b" => "<h2>定價：",
			"label_e" => "元</h2>",
			"price_b" => "<b class=\"price\">",
			"price_e" => "</b>元",
			"discount_b" => "元</h2><h2>",
			"discount_e" => "折",
			"link_b" => "<a href=\"http://www.books.com.tw/products",
			"link_e" => "\">",
			"img_b" => "img src=\"",
			"img_e" => "/>",
			"date_b" => "class=\"day\">",
			"date_e" => "</div>",
		];

		$bookscom_result = $bookscom->pageParsing();
		$temp = dataCatcher($bookscom_result['FILE'], $tag1, $tag2);
		//var_dump($bookscom);


		#博客來網站採用big5....damn it!
		$temp = iconv("Big5", "utf-8", $temp);
		$temp = xmpTag($temp);
		//print_r($temp);

		$bookscom->setAllValue($temp, $tag_array);
		//echo $bookscom->book_name;
		//var_dump($bookscom);
		*/

		//$bookscom2 = new book_info;

		$test = "<br>I'm A <br> Doctor <br> U know<br>?";
		$test = remove($test, "<b", "r>");
		$test = xmpTag($test);
		echo $test;


		/*The tags of weekly discount items of Books.com.tw
		*
		<div id ="left">
		<div id="left_end"></div>
		*
		*/
?>