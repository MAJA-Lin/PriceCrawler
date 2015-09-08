<?php
	include_once "src/LIB_http.php";
	include_once "src/LIB_parse.php";
	//include_once "discount_class.php";

	class discount_book_page {
		public $target;
		public $ref;
		public $method;
		public $data_array;
		//public $result;

		function __construct($new_target, $new_ref, $new_method, $new_data_array) {
			$this->target = $new_target;
			$this->ref = $new_ref;
			$this->method = $new_method;
			$this->data_array = $new_data_array;
		}

		function setValue($new_target, $new_ref, $new_method, $new_data_array) {
			$this->target = $new_target;
			$this->ref = $new_ref;
			$this->method = $new_method;
			$this->data_array = $new_data_array;
		}



		/*
		*	Parsing the target web page
		*	抓取目標網頁
		*/
		function pageParsing() {
			//$result = http($new_target, $new_ref, $new_method, $data_array, EXCL_HEAD);
			$result = http($this->target, $this->ref, $this->method, $this->data_array, EXCL_HEAD);
			return $result;
		}


		/*
		*	First stage: split the data from the whole web page
		*	第一階段分離: 把資料從整組網頁上分開
		*/
		/*
		function dataCatcher($data, $begin, $end) {
			$data_processed = return_between($data, $begin, $end, EXCL);
			return $data_processed;
		}
		*/


	}



	/*
	*	繼承discount_book_page, 增加了書名, 價格等等資訊;並以array存放之以方便使用
	*/
	class book_info extends discount_book_page {

		public $book_name;
		public $book_price;
		public $book_label;
		public $book_discount;
		public $book_link;
		public $book_img;
		public $book_date;
		//public $tag_array;

		/*
		*	construct the array
		*/
		function setArray() {
			//parent::__construct();
			$this->book_name = array();
			$this->book_price = array();
			$this->book_label = array();
			$this->book_discount = array();
			$this->book_link = array();
			$this->book_img = array();
			$this->book_date = array();
		}


		/*
		*	Function to split the columns from data, and save them as array
		*
		*/
		function setAllValue($data, $tag_array) {
			$this->book_name = splitColumn($data, $tag_array['name_b'], $tag_array['name_e']);
			$this->book_price = splitColumn($data, $tag_array['price_b'], $tag_array['price_e']);
			$this->book_label = splitColumn($data, $tag_array['label_b'], $tag_array['label_e']);
			$this->book_discount = splitColumn($data, $tag_array['discount_b'], $tag_array['discount_e']);
			$this->book_link = splitColumn($data, $tag_array['link_b'], $tag_array['link_e']);
			$this->book_img = splitColumn($data, $tag_array['img_b'], $tag_array['img_e']);
			$this->book_date = splitColumn($data, $tag_array['date_b'], $tag_array['date_e']);

			$this->cleanValue($tag_array);

			/*
			*	Clean the data from unnecessary infomation
			*	清除不必要的資料
			*/

			/*
			for ($i=0; $i<count($this->book_name); $i++) {
				$this->book_name[$i] = dataCatcher($this->book_name[$i], $tag_array['name_b'], $tag_array['name_e']);
				$this->book_link[$i] = dataCatcher($this->book_link[$i],  $tag_array['link_b'], $tag_array['link_e']);
				$this->book_price[$i] = dataCatcher($this->book_price[$i], $tag_array['price_b'], $tag_array['price_e']);
				$this->book_label[$i] = dataCatcher($this->book_label[$i], $tag_array['label_b'], $tag_array['label_e']);
				$this->book_discount[$i] = dataCatcher($this->book_discount[$i], $tag_array['discount_b'], $tag_array['discount_e']);
				$this->book_img[$i] = dataCatcher($this->book_img[$i], $tag_array['img_b'], $tag_array['img_e']);
				$this->book_date[$i] = dataCatcher($this->book_date[$i], $tag_array['date_b'], $tag_array['date_e']);
			}
			*/
		}

		/*
		*	Clean the data from unnecessary infomation
		*	清除不必要的資料
		*/

		function cleanValue($tag_array) {

			for ($i=0; $i<count($this->book_name); $i++) {
				$this->book_name[$i] = dataCatcher($this->book_name[$i], $tag_array['name_b'], $tag_array['name_e']);
				$this->book_link[$i] = dataCatcher($this->book_link[$i],  $tag_array['link_b'], $tag_array['link_e']);
				$this->book_price[$i] = dataCatcher($this->book_price[$i], $tag_array['price_b'], $tag_array['price_e']);
				$this->book_label[$i] = dataCatcher($this->book_label[$i], $tag_array['label_b'], $tag_array['label_e']);
				$this->book_discount[$i] = dataCatcher($this->book_discount[$i], $tag_array['discount_b'], $tag_array['discount_e']);
				$this->book_img[$i] = dataCatcher($this->book_img[$i], $tag_array['img_b'], $tag_array['img_e']);
				$this->book_date[$i] = dataCatcher($this->book_date[$i], $tag_array['date_b'], $tag_array['date_e']);
			}
		}

	}

?>