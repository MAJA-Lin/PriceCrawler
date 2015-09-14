<?php
	include_once "src/LIB_http.php";
	include_once "src/LIB_parse.php";
	include_once "basic_class.php";
	//ini_set( "display_errors", 0);

	/*
	*
	*	看起來跟basic_class.php裡面的 book_info 有九成像, 不過由於不需要book_date這個attribute, 所以還是先宣告一個直接繼承connection_info
	*		的子類別, 而不是繼承book_info, 變成connection_info的孫類別
	*
	*	#UPDATE: 最後還是直接繼承books_info, 類似的地方太多了
	*
	*	book_author 跟 publishing_house : 作者與出版社兩項是為了更精確判斷四間網路書店搜尋出來的結果是同一本書(商品)
	*	store_name 代表目前這項資料是屬於哪個網站的
	*
	*	#目前實作暫定以博客來為準(使用博客來的出版社資料作為publishing_house, 因為它的出版社名稱是簡短版, 讓其它的資料跟它作比對即可)
	*
	*	仔細想想, book_name, book_author, publishing_house 這幾欄資料基本上會是一樣的
	*		book_img 可能只要存最容易抓圖的博客來就好
	*
	*/

	class search_book_page extends book_info {
		/*
		public $book_name;
		public $book_price;
		public $book_label;
		public $book_discount;
		public $book_img;
		public $book_link;
		*/
		public $book_author;
		public $publishing_house;
		public $store_name;

		function setBookInfo($name, $author, $publisher, $img) {
			$this->book_name = $name;
			$this->book_author = $author;
			$this->publishing_house = $publisher;
			$this->book_img = $img;
		}


		function setArray() {
			//parent::__construct();
			//$this->book_name = array();
			$this->book_price = array();
			$this->book_label = array();
			$this->book_discount = array();
			//$this->book_img = array();
			$this->book_link = array();
			//$this->book_author = array();
			//$this->publishing_house = array();
			$this->store_name = array();
		}

	}

	/*
	*	原則上是抓所有搜尋頁面上的資料, 所以原本像book_name那幾個欄位要弄回array
	*
	*
	*/
	class search_book_result extends search_book_page {



		function setArray() {
			parent::setArray();
			$this->book_name = array();
			$this->book_img = array();
			$this->book_author = array();
			$this->publishing_house = array();
			//$this->store_name = array();
		}

		function setAllValue($data, $tag_array) {

			$this->book_name = splitColumn($data, $tag_array['name_b'], $tag_array['name_e']);
			$this->book_price = splitColumn($data, $tag_array['price_b'], $tag_array['price_e']);
			//$this->book_label = splitColumn($data, $tag_array['label_b'], $tag_array['label_e']);
			//$this->book_discount = splitColumn($data, $tag_array['discount_b'], $tag_array['discount_e']);
			$this->book_link = splitColumn($data, $tag_array['link_b'], $tag_array['link_e']);
			$this->book_img = splitColumn($data, $tag_array['img_b'], $tag_array['img_e']);
			$this->book_date = splitColumn($data, $tag_array['date_b'], $tag_array['date_e']);
			$this->publishing_house = splitColumn($data, $tag_array['publisher_b'], $tag_array['publisher_e']);
			//$this->book_author = splitColumn($data, $tag_array['author_b'], $tag_array['author_e']);

			$this->cleanValue($tag_array);
			$this->redir();


		}

		function cleanValue($tag_array) {

			$publisher_tag = "title=\"";
			$comma = "，";
			$price_b = "<b>";
			$price_e = "</b>";

			for ($i=0; $i<count($this->book_name); $i++) {
				$this->book_name[$i] = dataCatcher($this->book_name[$i], $tag_array['name_b'], $tag_array['name_e']);
				$this->book_link[$i] = dataCatcher($this->book_link[$i],  $tag_array['link_b'], $tag_array['link_e']);
				//$this->book_label[$i] = dataCatcher($this->book_label[$i], $tag_array['label_b'], $tag_array['label_e']);
				//$this->book_discount[$i] = dataCatcher($this->book_discount[$i], $tag_array['discount_b'], $tag_array['discount_e']);
				$this->book_img[$i] = dataCatcher($this->book_img[$i], $tag_array['img_b'], $tag_array['img_e']);
				$this->book_date[$i] = dataCatcher($this->book_date[$i], $tag_array['date_b'], $tag_array['date_e']);
				$this->publishing_house[$i] = dataCatcher($this->publishing_house[$i], $publisher_tag, $tag_array['publisher_e']);

				/*
				*	price會夾大逗號,去掉之後再作處理
				*
				*
				*/
				$this->book_price[$i] = dataCatcher($this->book_price[$i], $tag_array['price_b'], $tag_array['price_e']);
				if (strpos ($this->book_price[$i], $comma)){
				     //True
				     $this->book_price[$i] = split_string($this->book_price[$i], $comma, AFTER, EXCL);
				}
				$this->book_price[$i] = dataCatcher($this->book_price[$i], $price_b, $price_e);
			}

		}

		/*
		*	Sometimes the link of result will be disconnected; so redirection is important
		*
		*
		*/

		function redir() {
			$domain = "http://www.books.com.tw/products/";
			$tag_b = "item=";
			$tag_e = "&amp";

			for ($i=0; $i<count($this->book_link); $i++) {
				$this->book_link[$i] = dataCatcher($this->book_link[$i], $tag_b, $tag_e);
				$this->book_link[$i] = $domain . $this->book_link[$i];
			}
		}

		function printResult() {

			for ($i=0; $i<count($this->book_name); $i++) {

			echo "<article><div class=\"post-image\"><div class=\"post-heading\">";
			echo "<h3><a href=\"".$this->book_link[$i]."\">".$this->book_name[$i]."</a></h3>";

			}
		}
	}

?>