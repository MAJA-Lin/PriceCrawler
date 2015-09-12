<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Price Crawler</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Love, Peace and Discount Price!" />
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
	<!-- 中間標語 -->
	<section class="callaction">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="big-cta">
					<div class="cta-text">
						<h2><span>PriceCrawler</span> &nbsp;&nbsp;To Buy or not to buy</h2>
					</div>
				</div>
			</div>
		</div>
	</div>
	</section>
	<!-- End of Slogan -->

	<section id="content">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-3">
						<div class="box">
							<div class="box-blue aligncenter">
								<h4>Weekly discount</h4>
								<div class="icon">
									<i class="fa fa-dollar fa-3x"></i>
								</div>
								<p>
								 Show weekly discount information of books in 4 online bookstores (e.g. Taaze, Sanmin...).
								</p>
							</div>
							<div class="box-bottom">
								<a href="discount_view_img.php">Check Here</a>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="box">
							<div class="box-yellow aligncenter">
								<h4>Lowest price</h4>
								<div class="icon">
									<i class="fa fa-search fa-3x"></i>
								</div>
								<p>
								 Search the lowest price of the book you want on online bookstores. (not available now)
								</p>
							</div>
							<div class="box-bottom">
								<a href="discount_book_print.php">Search now</a>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="box">
							<div class="box-pink aligncenter">
								<h4>Price follower</h4>
								<div class="icon">
									<i class="fa fa-tags fa-3x"></i>
								</div>
								<p>
								 Want to be noticed when the book meets the lowest price? We will email you! (not available now)
								</p>
							</div>
							<div class="box-bottom">
								<a href="404.html">Learn more</a>
							</div>
						</div>
					</div>
					<div class="col-lg-3">
						<div class="box">
							<div class="box-orange aligncenter">
								<h4>Contact</h4>
								<div class="icon">
									<i class="fa fa-envelope fa-3x"></i>
								</div>
								<p>
								 If you got any question, please leave us messages. We will reply soon.
								</p>
							</div>
							<div class="box-bottom">
								<a href="#">Contact us</a>
							</div>
						</div>
					</div>
				</div>
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
		<!-- Photo and links here -->
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">Bookstore</h4>
				<div class="row">
					<section id="projects">
					<ul id="thumbs" class="portfolio">
						<!-- Item Project and Filter Name -->
						<li class="col-lg-3 design" data-id="id-0" data-type="web">
						<div class="item-thumbs">
						<!-- Fancybox - Gallery Enabled - Title - Full Image -->
						<a class="hover-wrap fancybox" data-fancybox-group="gallery" title="books.com.tw : 博客來" href="src/img/bookstw_logo.png">
						<span class="overlay-img"></span>
						<span class="overlay-img-thumb font-icon-plus"></span>
						</a>
						<!-- Thumb Image and Description -->
						<img src="src/img/bookstw_logo.png" alt="books.com.tw : 博客來">
						</div>
						</li>
						<!-- End Item Project -->
						<!-- Item Project and Filter Name -->
						<li class="item-thumbs col-lg-3 design" data-id="id-1" data-type="icon">
						<!-- Fancybox - Gallery Enabled - Title - Full Image -->
						<a class="hover-wrap fancybox" data-fancybox-group="gallery" title="Taaze.com.tw : 讀冊" href="src/img/taaze_logo.jpg">
						<span class="overlay-img"></span>
						<span class="overlay-img-thumb font-icon-plus"></span>
						</a>
						<!-- Thumb Image and Description -->
						<img src="src/img/taaze_logo.jpg" alt="Taaze.com.tw : 讀冊">
						</li>
						<!-- End Item Project -->
						<!-- Item Project and Filter Name -->
						<li class="item-thumbs col-lg-3 photography" data-id="id-2" data-type="illustrator">
						<!-- Fancybox - Gallery Enabled - Title - Full Image -->
						<a class="hover-wrap fancybox" data-fancybox-group="gallery" title="www.sanmin.com.tw : 三民網路書店" href="src/img/sanmin_logo.jpg">
						<span class="overlay-img"></span>
						<span class="overlay-img-thumb font-icon-plus"></span>
						</a>
						<!-- Thumb Image and Description -->
						<img src="src/img/sanmin_logo.jpg" alt="www.sanmin.com.tw : 三民網路書店">
						</li>
						<!-- End Item Project -->
						<!-- Item Project and Filter Name -->
						<li class="item-thumbs col-lg-3 photography" data-id="id-2" data-type="illustrator">
						<!-- Fancybox - Gallery Enabled - Title - Full Image -->
						<a class="hover-wrap fancybox" data-fancybox-group="gallery" title="www.iread.com.tw : 灰熊愛閱讀" href="src/img/iread_logo.jpg">
						<span class="overlay-img"></span>
						<span class="overlay-img-thumb font-icon-plus"></span>
						</a>
						<!-- Thumb Image and Description -->
						<img src="src/img/iread_logo.jpg" alt="www.iread.com.tw : 灰熊愛閱讀">
						</li>
						<!-- End Item Project -->
					</ul>
					</section>
				</div>
			</div>
		</div>
	</div>
	</section>
		<!-- End of photo -->

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
						<li><a href="#">Weekly discount</a></li>
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