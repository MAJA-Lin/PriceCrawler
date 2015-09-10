<?php
	include_once "src/LIB_http.php";
	include_once "src/LIB_parse.php";
	include_once "basic_class.php";
	include_once "src/data_managing.php";

	/*
	以下為"每周66折"的網址，目前不包括其他的特價，之後可能會再增加其他特價功能。
		注意：博客來、三民、金石堂等的網址看起來會變動，可能需要額外的步驟去得到最新的網址
	The following variables are the addresses of the discount pages.
	And it seems that the address of books.com.tw, Sanmin and Kingstone could be changed,
		remember to write a page which can reload / get the latest web address of those discount pages.
	以下網址依序為：
	博客來 	www.books.com.tw
	讀冊	www.taaze.tw
	三民 	www.sanmin.com.tw
	金石堂	http://www.kingstone.com.tw/
	灰熊	https://www.iread.com.tw/
	*/

	$dis_bookscom = "http://www.books.com.tw/activity/gold66_day/";
	$dis_taaze = "http://www.taaze.tw/act66.html";
	$dis_sanmin = "http://activity.sanmin.com.tw/Today66";
	//$dis_king = "http://www.kingstone.com.tw/event/0708_aonsale66/onsale66.asp";
	# This is the main discount product page  ↑↑↑
	$dis_king = "http://www.kingstone.com.tw/event/0708_aonsale66/predict66.asp?LID=&pagefocus=predict66";
	$dis_iread = "https://www.iread.com.tw/alldiscount.aspx";

	$ref = "www.google.com.tw";


	/*
	*	Books.com.tw / 博客來
	*	由於book_name會抓到網址，所以需要更改setAllValue的寫法
	*
	*/
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

			$this->cleanValue($tag_array);
		}

		/*
		*	Clean the data, only save the necessary data.
		*/
		function cleanValue($tag_array) {
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
	*	Taaze
	*	The value book_date need to be dealed with escape sequence like <br>, \r and \n.
	*
	*/

	class taaze extends book_info
	{
		function cleanDate($tag_array) {

			$tag = "</span>";
			$tag1 = "<br>";
			$tag2 = "<br/>";

			for ($i=0; $i < count($this->book_date); $i++) {
				if (strlen($this->book_date[$i]) > 15) {
					$this->book_date[$i] = split_string($this->book_date[$i], $tag, BEFORE, EXCL);
				}
				$this->book_date[$i] = str_replace($tag1, "", $this->book_date[$i]);
				$this->book_date[$i] = str_replace($tag2, "", $this->book_date[$i]);
				$this->book_date[$i] = preg_replace('/\s+/', '', $this->book_date[$i]);
			}

		}
	}


	/*
	*	Sanmin 三民書局
	*	There is no label price shown on the discount page, so calculate it and use ceil to round fractions up.
	*	特價網站上沒有定價資訊，所以在各value都設定完了之後，使用book_price 除以 $discount(0.66)並取無條件進位算出大約定價。
	*	#Notice : 由於book_label要在最後作設定，setAllValue 跟 cleanValue要作調整
	*
	*/

	class sanmin extends book_info
	{

		protected $discount = 0.66;
		protected $name_tag = "\">";

		function setAllValue($data, $tag_array) {
			$this->book_name = splitColumn($data, $tag_array['name_b'], $tag_array['name_e']);
			$this->book_price = splitColumn($data, $tag_array['price_b'], $tag_array['price_e']);
			$this->book_discount = splitColumn($data, $tag_array['discount_b'], $tag_array['discount_e']);
			$this->book_link = splitColumn($data, $tag_array['link_b'], $tag_array['link_e']);
			$this->book_img = splitColumn($data, $tag_array['img_b'], $tag_array['img_e']);
			$this->book_date = splitColumn($data, $tag_array['date_b'], $tag_array['date_e']);

			$this->cleanValue($tag_array);
			for ($i=0; $i<count($this->book_name); $i++){
				//Calculate the label price
				$this->book_label[$i] = ceil($this->book_price[$i] / $this->discount);
			}
		}

		function cleanValue($tag_array) {

			for ($i=0; $i<count($this->book_name); $i++) {
				//book_name contains address, clean it.
				$this->book_name[$i] = dataCatcher($this->book_name[$i], $tag_array['name_b'], $tag_array['name_e']);
				$this->book_name[$i] = split_string($this->book_name[$i], $this->name_tag, AFTER, EXCL);
				//Done
				$this->book_link[$i] = dataCatcher($this->book_link[$i],  $tag_array['link_b'], $tag_array['link_e']);
				$this->book_price[$i] = dataCatcher($this->book_price[$i], $tag_array['price_b'], $tag_array['price_e']);
				$this->book_discount[$i] = dataCatcher($this->book_discount[$i], $tag_array['discount_b'], $tag_array['discount_e']);
				$this->book_img[$i] = dataCatcher($this->book_img[$i], $tag_array['img_b'], $tag_array['img_e']);
				$this->book_date[$i] = dataCatcher($this->book_date[$i], $tag_array['date_b'], $tag_array['date_e']);
			}
		}
	}

	/*
	*	Kingstone 金石堂
	*	網頁排版讓66折跟79折的商品混在一起，取出每周66折商品資訊的部分可能要重寫=>將讀取的資料依66折分成6~10份
	*
	*
	*/

	class kingstone extends book_info
	{
		
	}

	/*
	*
	*
	*/

	class iread extends book_info
	{
		protected $discount = 0.66;
		protected $name_tag = "\">";
		protected $domain = "https://www.iread.com.tw/";

		function setAllValue($data, $tag_array) {
			$this->book_name = splitColumn($data, $tag_array['name_b'], $tag_array['name_e']);
			$this->book_price = splitColumn($data, $tag_array['price_b'], $tag_array['price_e']);
			$this->book_discount = splitColumn($data, $tag_array['discount_b'], $tag_array['discount_e']);
			$this->book_link = splitColumn($data, $tag_array['link_b'], $tag_array['link_e']);
			$this->book_img = splitColumn($data, $tag_array['img_b'], $tag_array['img_e']);
			$this->book_date = splitColumn($data, $tag_array['date_b'], $tag_array['date_e']);

			$this->cleanValue($tag_array);
			for ($i=0; $i<count($this->book_name); $i++){
				//Calculate the label price
				$this->book_label[$i] = ceil($this->book_price[$i] / $this->discount);
			}
		}

		function cleanValue($tag_array) {

			for ($i=0; $i<count($this->book_name); $i++) {
				//book_name includes the web address I don't need, so just clean it
				$this->book_name[$i] = dataCatcher($this->book_name[$i], $tag_array['name_b'], $tag_array['name_e']);
				$this->book_name[$i] = split_string($this->book_name[$i], $this->name_tag, AFTER, EXCL);
				//done

				//The address of link and image are lack of domain, so add it here
				$this->book_link[$i] = dataCatcher($this->book_link[$i],  $tag_array['link_b'], $tag_array['link_e']);
				$this->book_link[$i] = $this->domain . $this->book_link[$i];
				$this->book_img[$i] = dataCatcher($this->book_img[$i], $tag_array['img_b'], $tag_array['img_e']);
				$this->book_img[$i] = $this->domain . $this->book_img[$i];
				//done

				$this->book_price[$i] = dataCatcher($this->book_price[$i], $tag_array['price_b'], $tag_array['price_e']);
				$this->book_discount[$i] = dataCatcher($this->book_discount[$i], $tag_array['discount_b'], $tag_array['discount_e']);
				$this->book_date[$i] = dataCatcher($this->book_date[$i], $tag_array['date_b'], $tag_array['date_e']);
			}
		}


	}



	/*
	*	Class defination's over.
	*		Start parsing.
	*
	*
	*
	*
	*/



	/*
	*	Parsing Books.com.tw
	*	爬取/存儲博客來的data
	*	#Warning : the code of books.com.tw is Big5, remember th transfer is to utf-8
	*/

	$bookscom = new books_com($dis_bookscom, "", "GET", "");
	$bookscom->setArray();

	$bookscom_begin = "<div id =\"left\">";
	$bookscom_end = "<div id=\"left_end\">";
	$bookscom_tag_array = [
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
	$temp = dataCatcher($bookscom_result['FILE'], $bookscom_begin, $bookscom_end);
	$temp = iconv("Big5", "utf-8", $temp);
	$bookscom->setAllValue($temp, $bookscom_tag_array);
	var_dump($bookscom);


	/*
	*	Parsing Taaze
	*	讀冊
	*
	*/

	//$taazecom = new book_info($dis_taaze, "", "GET", "");
	$taazecom = new taaze($dis_taaze, "", "GET", "");
	$taazecom->setArray();

	$taazecom_begin = "<!-- 循環當週55折預告start -->";
	$taazecom_end = "<!-- 循環當週66折預告end -->";
	$taazecom_tag_array = [
		"name_b" => "class=\"text\"><span class=\"txt-b\">",
		"name_e" => "</span></TD>",
		"price_b" => "折<span class=\"66-pink-s\">",
		"price_e" => "</span>元",
		"label_b" => "class=\"text\">定價：",
		"label_e" => "元</TD>",
		"discount_b" => "優惠價：<span class=\"66-pink-s\">",
		"discount_e" => "</span>折",
		"link_b" => "\"#CCCCCC\"><a href=\"",
		"link_e" => "\" target",
		"img_b" => "blank\"><img src",
		"img_e" => "width=\"90\"",
		"date_b" => "<span class=\"date\">",
		"date_e" => "</span></td>",
	];

	$taazecom_result = $taazecom->pageParsing();
	$temp = dataCatcher($taazecom_result['FILE'], $taazecom_begin, $taazecom_end);
	$taazecom->setAllValue($temp, $taazecom_tag_array);
	$taazecom->cleanDate($taazecom_tag_array);
	var_dump($taazecom);


	/*
	*	Sanmin
	*	三民書局
	*	#Notice : book_name is like books.com.tw --- conbined with web address
	*		And the img file seems to be missed on the page. Just give it up right now,
	*		maybe add a new function to get the img address later.
	*
	*/

	$sanmincom = new sanmin($dis_sanmin, "", "GET", "");
	$sanmincom->setArray();

	$sanmincom_begin = "<div class=\"ActivityBody\" style=\"\">";
	$sanmincom_end = "<!--end left-->";
	$sanmincom_tag_array = [
		"name_b" => "<tr><td><a href=\"http://www.m.sanmin.com.tw/Product/Index",
		"name_e" => "</a></td>",
		"price_b" => "66折優惠價：<span>",
		"price_e" => "</span> 元",
		"label_b" => "",
		"label_e" => "",
		"discount_b" => "class=\"gray\" >",
		"discount_e" => "折優惠價：",
		"link_b" => "<tr><td><a href=\"",
		"link_e" => "\">",
		"img_b" => "original=\"",
		"img_e" => "\" alt",
		"date_b" => "font-weight:bold\">",
		"date_e" => " </td></tr>",
	];

	$sanmincom_result = $sanmincom->pageParsing();
	$temp = dataCatcher($sanmincom_result['FILE'], $sanmincom_begin, $sanmincom_end);
	$sanmincom->setAllValue($temp, $sanmincom_tag_array);
	var_dump($sanmincom);


	/*
	*	Kingstone
	*	金石堂
	*	#目標網站似乎有防爬? 或是防火牆擋住?
	*		連首頁都不給爬，目前暫時無法解決
	*
	*/

	/*
	$kingstonecom = new kingstone($dis_king, "", "GET", "");
	$kingstonecom->setArray();

	$kingstonecom_begin = "</div><!--header end-->";
	$kingstonecom_end = "</div><!--content_predict66 end-->";
	$kingstonecom_tag_array = [
		"name_b" => "<tr><td><a href=\"http://www.m.sanmin.com.tw/Product/Index",
		"name_e" => "</a></td>",
		"price_b" => "66折優惠價：<span>",
		"price_e" => "</span> 元",
		"label_b" => "",
		"label_e" => "",
		"discount_b" => "class=\"gray\" >",
		"discount_e" => "折優惠價：",
		"link_b" => "<tr><td><a href=\"",
		"link_e" => "\">",
		"img_b" => "original=\"",
		"img_e" => "\" alt",
		"date_b" => "font-weight:bold\">",
		"date_e" => " </td></tr>",
	];

	//$kingstonecom_result = $kingstonecom->pageParsing();
	//var_dump($kingstonecom_result);
	//$temp = dataCatcher($kingstonecom_result['FILE'], $kingstonecom_begin, $kingstonecom_end);
	//var_dump($temp);
	//ingstone->setAllValue($temp, $kingstone_tag_array);
	//var_dump($kingstone);

	*/


	/*
	*	iRead 灰熊
	*
	*
	*
	*/


	$ireadcom = new iread($dis_iread, "", "GET", "");
	$ireadcom->setArray();

	$ireadcom_begin = "<div id=\"Weekly_bargain\">";
	$ireadcom_end = "</div><!--Weekly_bargain-->";
	$ireadcom_tag_array = [
		"name_b" => "<li class=\"BookTitle\">",
		"name_e" => "</a>",
		"price_b" => "折<span class=\"redword\">",
		"price_e" => "</span>元",
		"label_b" => "",
		"label_e" => "",
		"discount_b" => "優惠價：<span class=\"redword\">",
		"discount_e" => "</span>折",
		"link_b" => "ProdNameLink\" href=\"",
		"link_e" => "\">",
		"img_b" => "<img src=\"",
		"img_e" => "\" border=\"0\"",
		"date_b" => "<li class=\"Date\">",
		"date_e" => " <span",
	];

	$ireadcom_result = $ireadcom->pageParsing();
	$temp = dataCatcher($ireadcom_result['FILE'], $ireadcom_begin, $ireadcom_end);
	//print_r(xmpTag($temp));
	$ireadcom->setAllValue($temp, $ireadcom_tag_array);
	var_dump(count($ireadcom));


?>