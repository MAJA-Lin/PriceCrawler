<?php
	include_once "src/LIB_http.php";
	include_once "src/LIB_parse.php";
	//include_once "discount_class.php";

	class connection_info {
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
	class book_info extends connection_info {

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


		/*
		*	String to Date
		*	字串 / 文字 轉成date, 格式統一為 mm/dd
		*	format =>  date('m/d') => e.g. 12/25
		*	PS: Taaze頭兩個是期間(數日)而非特定某日,考慮放棄頭兩格的資料輸出
		*		(此function 整理出來的資料暫定只使用在discount_view_form上, 所以只求form上的輸出整齊)
		*	# The first and second date of taaze are period, not specified date. In this case (the output of this function),
		*		maybe ignore those two date will be ok.
		*
		*
		*	作法: 刪除月, 日, 括號, dash, 星期幾等等資訊，只留數字(日期), 並按照格式(mm/dd)補上斜線
		*	博客來:09/14(一)	讀冊:09/07(一)~09/10(四) and 09/07(一)
		*	灰熊:09月13日		三民:9月14日
		*	這個版本通用於books.com.tw & taaze; 三民跟灰熊的另外再寫一個(去"月", "日",還要補0)
		*/

		function stringToDate() {
			//暴力破解XD
			$week = array("(一)","(二)", "(三)", "(四)", "(五)", "(六)", "(日)");
			$blank = "";
			$tilde = "~";
			$bar = " - ";
			for ( $i=0; $i<count($this->book_date); $i++) {
				for ( $j=0; $j<count($week); $j++) {
					$this->book_date[$i] = str_replace($week[$j], $blank, $this->book_date[$i]);
				}
				//Lenth > 10 --- 資料為一區間(e.g. 09/07(一)~09/10(四))時
				if(strlen($this->book_date[$i])>10) {
					$this->book_date[$i] = str_replace($tilde, $bar, $this->book_date[$i]);
				}
				//Finally, give variable to book_date
				//$this->book_date[$i] = $temp;
			}

		}


		/*
		*	Another version of stringToDate(); This ver is dealing with the word "月", "日"
		*
		*
		*/

		function stringToDate2() {

			$month = "月";
			$day = "日";
			for ($i=0; $i<count($this->book_date); $i++) {
				$mm = split_string($this->book_date[$i], $month, BEFORE, EXCL);
				$temp = split_string($this->book_date[$i], $month, AFTER, EXCL);
				$dd = split_string($temp, $day, BEFORE, EXCL);

				if(strlen($mm)<2) {
					$mm = "0" . $mm;
				}

				if(strlen($dd)<2) {
					$dd = "0" . $dd;
				}
				$this->book_date[$i] = $mm."/".$dd;
			}
		}


		/*
		*	print the data to discount_view_img.php
		*	依照discount_view_img 的html格式/欄位輸出資料
		*
		*/
		function printImg($data_id, $data_type) {

			for ($i=0; $i<count($this->book_name); $i++) {
				//data-id should be like id-0, id-5... so add 'id-' here
				$new_data_id = "id-".$data_id;
				$br = "&#9;";

				/*
				*	將特價書籍的所有資訊組合成$text; 另外, 書本網址的部分要用好超連結
				*/
				$text = $this->book_date[$i]."定價: ".$this->book_label[$i]."優惠價: ".$this->book_price[$i];

				//Start echo
				echo "<li class=\"item-thumbs col-lg-3 design\" data-id=\"".$new_data_id."\" data-type=\"".$data_type."\">";
				echo "<a class=\"hover-wrap fancybox\" data-fancybox-group=\"gallery\" title=\"".$this->book_name[$i]."\" href=\"".$this->book_img[$i]."\">";
				echo "<span class=\"overlay-img\">Date: ".$this->book_date[$i]."</span>";
				echo "<span class=\"overlay-img-thumb font-icon-plus\"></span></a>";
				echo "<img src=\"".$this->book_img[$i]."\" height=\"230\" width=\"230\" alt=\"".$text."\"></li>";
				# $data_id should be add at last
				$data_id++;
			}

		}


		/*
		*	Use if and for, and use book_date as key ( lenth($this->book_date) < 某數字 )
		*	過濾讀冊的區間(非特定日)特價
		*
		*
		*/

		function printForm($color) {

			//Initial the array index;
			$temp = 0;
			$taaze_tag = 2;
			$key = count($this->book_date) - 1;

			echo "<div class=\"col-lg-3\">";
			switch ($color) {
				//Taaze
				case 'pink':
					echo "<div class=\"pricing-box-alt pink\">";
					echo "<div class=\"pricing-heading\">";
					echo "<h3>Taaze <strong>讀冊</strong></h3></div>";
					echo "<div class=\"pricing-terms\"><h6>";
					//中間夾日期; e.g. : 09/20 ~ 09/27
					//Taaze 從index 2開始
					echo $this->book_date[$taaze_tag]." ~ ".$this->book_date[$key];
					echo "</h6></div>";
					break;

				case 'green':
					echo "<div class=\"pricing-box-alt green\">";
					echo "<div class=\"pricing-heading\">";
					echo "<h3>博 <strong>客來</strong></h3></div>";
					echo "<div class=\"pricing-terms\"><h6>";
					//中間夾日期; e.g. : 09/20 ~ 09/27
					echo $this->book_date[$temp]." ~ ".$this->book_date[$key];
					echo "</h6></div>";
					break;
				case 'purple':
					echo "<div class=\"pricing-box-alt purple\">";
					echo "<div class=\"pricing-heading\">";
					echo "<h3>三民 <strong>Sanmin</strong></h3></div>";
					echo "<div class=\"pricing-terms\"><h6>";
					//中間夾日期; e.g. : 09/20 ~ 09/27
					echo $this->book_date[$temp]." ~ ".$this->book_date[$key];
					echo "</h6></div>";
					break;
				case 'orange':
					echo "<div class=\"pricing-box-alt orange\">";
					echo "<div class=\"pricing-heading\">";
					echo "<h3>灰熊 <strong>iRead</strong></h3></div>";
					echo "<div class=\"pricing-terms\"><h6>";
					//中間夾日期; e.g. : 09/20 ~ 09/27
					echo $this->book_date[$temp]." ~ ".$this->book_date[$key];
					echo "</h6></div>";
					break;
				default:
					echo "<div class=\"pricing-box-alt \">";
					echo "<div class=\"pricing-heading\">";
					echo "<h3>No <strong>Data</strong></h3></div>";
					echo "<div class=\"pricing-terms\"><h6>";
					//中間夾日期; e.g. : 09/20 ~ 09/27
					echo $this->book_date[$temp]." ~ ".$this->book_date[$key];
					echo "</h6></div>";
					break;
			}

			echo "<div class=\"pricing-content\"><ul>";
			// Display book name here
			for ($i=0; $i<count($this->book_date); $i++) {
				echo "<li><a href=\"".$this->book_link[$i];
				echo "\"><i class=\"icon-ok\"></i> ";
				echo $this->book_name[$i]."</a></li>";
				//<a href=""></a>
			}
			// End of name display
			echo "</ul></div>";
			echo "<div class=\"pricing-action\">";
			echo "<a href=\"".$this->target;
			echo "\" class=\"btn btn-medium btn-theme\"><i class=\"icon-bolt\"></i> Learn more</a></div></div></div>";

		}

		/*
		<div class="col-lg-3">
				<div class="pricing-box-alt pink">
					<div class="pricing-heading">
						<h3>Taaze <strong>讀冊</strong></h3>
					</div>
					<div class="pricing-terms">
						<h6>&#36;15.00 / Month</h6>
					</div>
					<div class="pricing-content">
						<ul>
							<li><i class="icon-ok"></i> 100 applications</li>
							<li><i class="icon-ok"></i> 24x7 support available</li>
							<li><i class="icon-ok"></i> No hidden fees</li>
							<li><i class="icon-ok"></i> Free 30-days trial</li>
							<li><i class="icon-ok"></i> Stop anytime easily</li>
						</ul>
					</div>
					<div class="pricing-action">
						<a href="#" class="btn btn-medium btn-theme"><i class="icon-bolt"></i> Learn more</a>
					</div>
				</div>
			</div>
		*/

	}

?>