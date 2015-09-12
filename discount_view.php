<?php
	include_once "discount_book.php";
	$i = 0;
	$tag_books = "bookscom";
	$tag_taaze = "taaze";
	$tag_sanmin = "sanmin";
	$tag_iread = "iread";
	/*
	var_dump($bookscom);
	var_dump($taazecom);
	var_dump($sanmincom);
	*/
	//Due to the picture display problem, use taaze logo instead of their own books img on taaze.com.tw
	$taazecom->setImage();
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Weekly discount</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Shows weekly discount books" />
	<meta name="author" content="Scott Lin / typhoon31815@gmail.com" />
	<!-- css -->
	<link href="src/moderna/css/bootstrap.min.css" rel="stylesheet" />
	<link href="src/moderna/css/fancybox/jquery.fancybox.css" rel="stylesheet">
	<link href="src/moderna/css/jcarousel.css" rel="stylesheet" />
	<link href="src/moderna/css/flexslider.css" rel="stylesheet" />
	<link href="src/moderna/css/style.css" rel="stylesheet" />
	<!-- Theme skin -->
	<link href="src/moderna/skins/default.css" rel="stylesheet" />
</head>
<body>
	<div id="wrapper">
	<!-- start header -->
	<header>
        <div class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><span>P</span>rice<span>C</span>rawler</a>
                </div>
                <div class="navbar-collapse collapse ">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">Home</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle " data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false">
                            	Features <b class=" icon-angle-down"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Weekly-discount</a></li>
                                <li><a href="#">Media</a></li>
								<li><a href="#">GitHub Page</a></li>
                            </ul>
                        </li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
	</header>
	<!-- end header -->

	<!-- Start of inner headline -->
	<section id="inner-headline">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<ul class="breadcrumb">
					<li><a href="#"><i class="fa fa-home"></i></a><i class="icon-angle-right"></i></li>
					<li class="active">Weekly</li>
				</ul>
			</div>
		</div>
	</div>
	</section>
	<!-- End of inner headline -->
	<!-- Start of content-->
	<section id="content">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<ul class="portfolio-categ filter">
					<li class="all active"><a href="#">All</a></li>
					<li class="bookscom"><a href="#" title="博客來">博客來</a></li>
					<li class="taaze"><a href="#" title="讀冊">讀冊</a></li>
					<li class="sanmin"><a href="#" title="三民">三民</a></li>
					<li class="iread"><a href="#" title="灰熊">灰熊</a></li>
				</ul>
				<div class="clearfix">
				</div>
				<div class="row">
					<section id="projects">
					<ul id="thumbs" class="portfolio">
						<?php
							$taazecom->printHtml($i, $tag_taaze);
							$bookscom->printHtml($i, $tag_books);
							$sanmincom->printHtml($i, $tag_sanmin);
							$ireadcom->printHtml($i, $tag_iread);
						?>
					</ul>
					</section>
				</div>
			</div>
		</div>
	</div>
	</section>


		<!-- Start of footer -->
	<footer>
	<div class="container">
		<div class="row">
			<div class="col-lg-3">
				<div class="widget">
					<h5 class="widgetheading">Get in touch with us</h5>
					<address>
					<strong>Scott Lin</strong><br>
					 typhoon31815@gmail.com<br>
					 Taiwan </address>
					<p>
						<a href="https://github.com/MAJA-Lin/PriceCrawler">GitHub: MAJA-Lin/PriceCrawler</a>  <br>
					</p>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="widget">
					<h5 class="widgetheading">Pages</h5>
					<ul class="link-list">
						<li><a href="discount_book_print.php">Weekly discount</a></li>
						<li><a href="#">Bookstore</a></li>
						<li><a href="#">Privacy policy</a></li>
						<li><a href="#">Career center</a></li>
						<li><a href="#">Contact us</a></li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="widget">
					<h5 class="widgetheading">Latest update</h5>
					<ul class="link-list">
						<li><a href="#">New bookstore website available</a></li>
						<li><a href="#">Maybe add game / music support</a></li>
						<li><a href="#">Trying to think some other uses</a></li>
					</ul>
				</div>
			</div>

		</div>
	</div>
	<div id="sub-footer">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="copyright">
						<p>
							<span>&copy; MAJA 2015 All right reserved. By </span><a href="http://bootstraptaste.com" target="_blank">Bootstraptaste</a>
						</p>
					</div>
				</div>
				<div class="col-lg-6">
					<ul class="social-network">
						<li><a href="#" data-placement="top" title="Facebook"><i class="fa fa-facebook"></i></a></li>
						<li><a href="#" data-placement="top" title="Twitter"><i class="fa fa-twitter"></i></a></li>
						<li><a href="#" data-placement="top" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
						<li><a href="#" data-placement="top" title="Pinterest"><i class="fa fa-pinterest"></i></a></li>
						<li><a href="#" data-placement="top" title="Google plus"><i class="fa fa-google-plus"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	</footer>
	<!--End of footer-->

	</div>
	<a href="#" class="scrollup"><i class="fa fa-angle-up active"></i></a>

	<!-- javascript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="src/moderna/js/jquery.js"></script>
	<script src="src/moderna/js/jquery.easing.1.3.js"></script>
	<script src="src/moderna/js/bootstrap.min.js"></script>
	<script src="src/moderna/js/jquery.fancybox.pack.js"></script>
	<script src="src/moderna/js/jquery.fancybox-media.js"></script>
	<script src="src/moderna/js/google-code-prettify/prettify.js"></script>
	<script src="src/moderna/js/portfolio/jquery.quicksand.js"></script>
	<script src="src/moderna/js/portfolio/setting.js"></script>
	<script src="src/moderna/js/jquery.flexslider.js"></script>
	<script src="src/moderna/js/animate.js"></script>
	<script src="src/moderna/js/custom.js"></script>
</body>
</html>