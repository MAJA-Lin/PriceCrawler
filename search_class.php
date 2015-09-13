<?php
	include_once "src/LIB_http.php";
	include_once "src/LIB_parse.php";
	include_once "basic_class.php";

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

	class search_book_page extends books_info {
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
			$this->store_name = array();
		}

		function setAllValue($data, $tag_array) {


		}
	}

?>