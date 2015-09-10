<?php
	include_once "src/LIB_http.php";
	include_once "src/LIB_parse.php";


	/**
	*	這個Class已經移到basic_class.php作整合了，所以注意不要再引用此檔案
	*
	*/

	class discount_book_page
	{
		public $target;
		public $ref;
		public $method;
		public $data_array;
		//public $result;

		function __construct($new_target, $new_ref, $new_method, $new_data_array)
		{
			$this->target = $new_target;
			$this->ref = $new_ref;
			$this->method = $new_method;
			$this->data_array = $new_data_array;
		}

		function setValue($new_target, $new_ref, $new_method, $new_data_array)
		{
			$this->target = $new_target;
			$this->ref = $new_ref;
			$this->method = $new_method;
			$this->data_array = $new_data_array;
		}



		/*
		*	Parsing the target web page
		*	抓取目標網頁
		*/
		function pageParsing()
		{
			//$result = http($new_target, $new_ref, $new_method, $data_array, EXCL_HEAD);
			$result = http($this->target, $this->ref, $this->method, $this->data_array, EXCL_HEAD);
			return $result;
		}


		/*
		*	First stage: split the data from the whole web page
		*	第一階段分離: 把資料從整組網頁上分開
		*/
		function dataCatcher($data, $begin, $end)
		{
			$data_processed = return_between($data, $begin, $end, EXCL);
			return $data_processed;
		}


	}
?>