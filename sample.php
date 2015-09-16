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

		/*
		$action = "http://search.books.com.tw/exep/prod_search.php";
		$method = "GET";
		$ref = "www.google.com";
		$data_array['key'] = "無敵 林肯";
		$data_array['cat'] = "BKA";
		$reponse = http($action, $ref, $method, $data_array, EXCL_HEAD);
		print_r($reponse);
		*/

	class A {
	    function example() {
	        echo "I am A::example() and provide basic functionality.<br />\n";
	    }
	}

	class B extends A {
	    function example() {
	        echo "I am B::example() and provide additional functionality.<br />\n";
	        parent::example();
	    }
	}

	$b = new B;

	// This will call B::example(), which will in turn call A::example().
	$b->example();



		/*
		$data_QQ['key'] = "哆啦A夢";
		$data_QQ['cat'] = "all";
		*/
		/*
		$search = new discount_page("http://search.books.com.tw/exep/prod_search.php", "", "GET", $data_QQ);
		$result2 = $search->pageParsing();
		print_r($result2);
		*/

		class C {
		    public $v = 1;
		}

		function change($obj) {
		    $obj->v = 2;
		}

		function makezero($obj) {
		    $obj = 0;
		}

		$a = new C();

		var_dump($a);

		change($a);

		var_dump($a); 

		/* 
		output:

		object(A)#1 (1) {
		  ["v"]=>
		  int(2)
		}

		*/

		makezero($a);

		var_dump($a);

		/* 
		output (same as before):

		object(A)#1 (1) {
		  ["v"]=>
		  int(2)
		}

		*/


		$test = "<br>I'm A <br> Doctor <br> U know<br>?";
		$test = remove($test, "<b", "r>");
		$test = xmpTag($test);
		echo $test;

		echo "<a href=\"test.php\" method=\"GET\" value=\"$test\">Here</a>";
		//echo "<form action=\"test.php\" method=\"GET\">
		//	<input type=\"hiden\" name=\"firstname\" value=\"$test\">Here</form>";

?>
