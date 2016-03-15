<?php

	/*
	*	1st function: add <xmp> tag before / after the data which is parsed to improve the readability.
	*		Use to find the pattern of data.
	*	1號副程式: 幫資料加上<xmp> 標籤以便閱讀源碼
	*/

	function xmpTag($data) {
		$new_data = "<xmp>".$data."</xmp>";
		return $new_data;
	}



	/*
	*	Catch the data we need, and the data is going to be split into several columns : book_name, price, discount, link, picture and date
	*	將有用到的資料按照TAG取出。之後記得將資料處理(預計存進array裡面，所需欄位有: 書名, 價格, 折扣(幾折), 網址, 圖片與日期(單一日期?範圍值?))
	*
	******************************************************
	*
	*	Another usage is cleaning the data with unnecessary tag
	*	另一個用途是清除不必要的資訊
	*/

	function dataCatcher($data, $begin, $end) {
		$data_processed = return_between($data, $begin, $end, EXCL);
		return $data_processed;
	}


	/*
	*	Split the data, parse and save them as array. The size of array is usually 7 (a week)
	*	按照各欄位(書名, 定價, 賣價...etc) 將資料分離並存成array, array大小通常為7(一週七天)
	*/

	function splitColumn($data, $begin, $end) {
		$data_processed = parse_array($data, $begin, $end);
		return $data_processed;
	}





?>