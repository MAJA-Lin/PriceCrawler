<?php
	include_once "search_handler.php";
	//Turn off error display
	ini_set( "display_errors", 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Price Crawler | Search Result</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Display the 1st search, user can decide to read further infomation, which means confirm the search result" />
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
                                <li><a href="discount_view_img.php">Discount (Image)</a></li>
                                <li><a href="discount_view_form.php">Discount (Form)</a></li>
								<li><a href="search.html">Search</a></li>
                            </ul>
                        </li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
	</header>
	<!-- end header -->
	<!-- Headline -->
	<section id="inner-headline">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<ul class="breadcrumb">
					<li><a href="index.php"><i class="fa fa-home"></i></a><i class="icon-angle-right"></i></li>
					<li><a href="search.html">Search</a><i class="icon-angle-right"></i></li>
					<li class="active">Check the book</li>
				</ul>
			</div>
		</div>
	</div>
	</section>
	<!-- End of headline -->
	<!-- Start of search part-->
	<section class="content">
		<div class="container">
		<!-- divider -->
		<div class="row">
			<div class="col-lg-12">
				<div class="solidline">
				</div>
			</div>
		</div>
		<!-- end divider -->
		<div>
			<div class="widget">
					<form class="form-search" action="search_result.php" method="GET">
						<input class="form-control" type="text" name="keyword" placeholder="Search...">
					</form>
			</div>
		</div>
		<!-- divider -->
		<div class="row">
			<div class="col-lg-12">
				<div class="solidline">
				</div>
			</div>
		</div>
	<!-- end divider -->
	<!-- Display the 1st search result here, and let users choose the book they are looking for-->
		<div class="row">
			<div class="col-lg-8">
				<h2>Check your book</h2>
					<article>
						<div class="post-image">
							<div class="post-heading">
								<h3><a href="#">This is an example of standard post format</a></h3>
							</div>
							<img src="img/dummies/blog/img1.jpg" alt="" />
						</div>
						<p>
							 Qui ut ceteros comprehensam. Cu eos sale sanctus eligendi, id ius elitr saperet, ocurreret pertinacia pri an. No mei nibh consectetuer, semper laoreet perfecto ad qui, est rebum nulla argumentum ei. Fierent adipisci iracundia est ei, usu timeam persius ea. Usu ea justo malis, pri quando everti electram ei, ex homero omittam salutatus sed.
						</p>
						<div class="bottom-article">
							<ul class="meta-post">
								<li><i class="icon-calendar"></i><a href="#"> Mar 23, 2013</a></li>
								<li><i class="icon-user"></i><a href="#"> Admin</a></li>
								<li><i class="icon-folder-open"></i><a href="#"> Blog</a></li>
								<li><i class="icon-comments"></i><a href="#">4 Comments</a></li>
							</ul>
							<a href="#" class="pull-right">Continue reading <i class="icon-angle-right"></i></a>
						</div>
					</article>
					<?php
						printResult($bookstw_search);
					?>
			</div>
		</div>

	<!-- End of 1st search result-->
	</section>
	<!-- End of search part-->

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
						<li><a href="discount_view_img.php">Weekly discount (images)</a></li>
						<li><a href="discount_view_form.php">Weekly discount (form)</a></li>
						<li><a href="#">Bookstore</a></li>
						<li><a href="#">Privacy policy</a></li>
						<li><a href="#">Career center</a></li>
						<li><a href="contact.html">Contact us</a></li>
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