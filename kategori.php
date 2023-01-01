<?php
session_start();
include 'dbconnect.php';

if(!isset($_SESSION['log'])){
	header('location:login.php');
} else {
	
};

$idk = $_GET['idkategori'];

$uid = $_SESSION['id'];
$caricart = mysqli_query($conn,"select * from cart where userid='$uid' and status='Cart'");
$fetc = mysqli_fetch_array($caricart);
$orderidd = $fetc['orderid'];
$itungtrans = mysqli_query($conn,"select count(detailid) as jumlahtrans from detailorder where orderid='$orderidd'");
$itungtrans2 = mysqli_fetch_assoc($itungtrans);
$itungtrans3 = $itungtrans2['jumlahtrans'];

?>
<!DOCTYPE html>
<html>
<head>
	<title>Mandiri Filter - Kategori</title>
	<!-- for-mobile-apps -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Tokopekita, Richard's Lab" />
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //for-mobile-apps -->
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
<!-- font-awesome icons -->
<link href="css/font-awesome.css" rel="stylesheet"> 
<!-- //font-awesome icons -->
<!-- js -->
<script src="js/jquery-1.11.1.min.js"></script>
<!-- //js -->
<link href='//fonts.googleapis.com/css?family=Raleway:400,100,100italic,200,200italic,300,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="js/move-top.js"></script>
<script type="text/javascript" src="js/easing.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$(".scroll").click(function(event){		
			event.preventDefault();
			$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
		});
	});
</script>
<!-- start-smoth-scrolling -->
</head>

<body>
	<!-- header -->
	<div class="" style="background-color: #f8f9fa!important;">
		<div class="container">
			<nav class="navbar navbar-default fixed-top">
				<div class="navbar-header nav_2">
					<a class="navbar-brand" href="#">Mandiri Filter</a>
					<button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div> 
				<div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
					<ul class="nav navbar-nav">
						<li class="active"><a  style="color: black !important;" href="index.php" class="act">Home</a></li>	
						<li class="active"><a  style="color: black !important;" href="index.php" class="act">About</a></li>
						<li class="active"><a  style="color: black !important;" href="index.php" class="act">Product</a></li>
						<li class="active"><a  style="color: black !important;" href="index.php" class="act">Contact</a></li>
						<li class="dropdown">
							<a href="#" class="" data-toggle="dropdown" style="color: black !important;">Kategori Produk<b class="caret"></b></a>
							<ul class="dropdown-menu multi-column columns-3">
								<div class="row">
									<div class="multi-gd-img">
										<ul class="multi-column-dropdown" style="color: black !important;">
											<?php 
											$kat=mysqli_query($conn,"SELECT * from kategori order by idkategori ASC");
											while($p=mysqli_fetch_array($kat)){

												?>
												<li><a style="color: black !important;" href="kategori.php?idkategori=<?php echo $p['idkategori'] ?>"><?php echo $p['namakategori'] ?></a></li>

												<?php
											}
											?>
										</ul>
									</div>	

								</div>
							</ul>
						</li>
						<!-- <li><a style="color: black !important;" href="cart.php">Keranjang Saya</a></li> -->
						<li><a style="color: black !important;" href="daftarorder.php">Riwayat</a></li>
						<?php
						if(!isset($_SESSION['log'])){
							echo '
							<li><a style="color: black !important;" href="registered.php"> Daftar</a></li>
							<li><a style="color: black !important;" href="login.php">Masuk</a></li>
							';
						} else {

							if($_SESSION['role']=='Member'){
								echo '
								<li><a style="color:black !important;" href="logout.php">Dashboard</a></li>
								';
							} else {
								echo '
								<li style="color:black !important;">Halo, '.$_SESSION["name"].'
								<li><a href="admin" style="color:black !important;">Admin Panel</a></li>
								<li><a href="logout.php" style="color:black !important;">Keluar?</a></li>
								';
							};

						}
						?>
						<li><a style="color: black !important;" href="cart.php">Cart(<?php echo $itungtrans3 ?>)</a></li>
					</ul>
				</div>
			</nav>
		</div>
	</div>
	<!-- //header -->

	<!--- beverages --->
	<div class="products">
		<div class="container">
			<div class="col-md-4 products-left">
				<div class="categories">
					<h2>Categories</h2>
					<ul class="cate">
						
						
						<?php 
						$kat=mysqli_query($conn,"SELECT * from kategori order by idkategori ASC");
						while($p=mysqli_fetch_array($kat)){

							?>
							<li><a href="kategori.php?idkategori=<?php echo $p['idkategori'] ?>"><i class="fa fa-arrow-right" aria-hidden="true"></i><?php echo $p['namakategori'] ?></a></li>

							<?php
						}
						?>

					</ul>
				</div>																																												
			</div>
			<div class="col-md-8 products-right">
				<div class="row">


					<?php 
					$brgs=mysqli_query($conn,"SELECT * from produk where idkategori='$idk' order by idproduk ASC");
					$x = mysqli_num_rows($brgs);
					
					if($x>0){
						while($p=mysqli_fetch_array($brgs)){
							?>

							<div class="col-md-4" style="margin-bottom: 30px !important;">
								<div class="hover14 column">
									<div class="agile_top_brand_left_grid">
										<div class="agile_top_brand_left_grid_pos">
											<img src="images/offer.png" alt=" " class="img-responsive" />
										</div>
										<div class="agile_top_brand_left_grid1">
											<figure>
												<div class="snipcart-item block">
													<div class="snipcart-thumb">
														<a href="product.php?idproduk=<?php echo $p['idproduk'] ?>"><img src="<?php echo $p['gambar']?>" width="200px" height="200px"></a>		
														<p><?php echo $p['namaproduk'] ?></p>
														<p>Stok Tersedia : <?php echo $p['stok'] ?></p>
														<div class="rating1" style="text-align: center !important;">
															<span class="starRating">
																<?php
																$bintang = '<i class="fa fa-star blue-star" aria-hidden="true"></i>';
																$rate = $p['rate'];

																for($n=1;$n<=$rate;$n++){
																	echo '<i class="fa fa-star blue-star" aria-hidden="true"></i>';
																};
																?>
															</span>
														</div>
														<h4>Rp<?php echo number_format($p['hargabefore']) ?></h4>
													</div>
													<div class="snipcart-details top_brand_home_details">
														<fieldset>															
															<?php 

															if($p['stok'] < 1) {
																?> 
																<label style="background-color: red; color: white; padding: 10px;">Stok Habis</label>
																<?php
															} else{
																?> 
																<a href="product.php?idproduk=<?php echo $p['idproduk'] ?>"><input type="submit" class="button" value="Lihat Produk" /></a>
																<?php
															}
															?>
														</fieldset>
													</div>
												</div>
											</figure>
										</div>
									</div>
								</div>
							</div>
							<?php
						}
					} else {
						echo "Data tidak ditemukan";
					}
					?>
					
					<div class="clearfix"> </div>
				</div>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
	<!--- beverages --->

	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.min.js"></script>

	<!-- top-header and slider -->
	<!-- here stars scrolling icon -->
	<script type="text/javascript">
		$(document).ready(function() {
			
			var defaults = {
				containerID: 'toTop', // fading element id
				containerHoverID: 'toTopHover', // fading element hover id
				scrollSpeed: 4000,
				easingType: 'linear' 
			};
			

			$().UItoTop({ easingType: 'easeOutQuart' });

		});
	</script>
	<!-- //here ends scrolling icon -->

	<!-- main slider-banner -->
	<script src="js/skdslider.min.js"></script>
	<link href="css/skdslider.css" rel="stylesheet">
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#demo1').skdslider({'delay':5000, 'animationSpeed': 2000,'showNextPrev':true,'showPlayButton':true,'autoSlide':true,'animationType':'fading'});

			jQuery('#responsive').change(function(){
				$('#responsive_wrapper').width(jQuery(this).val());
			});
			
		});
	</script>	
	<!-- //main slider-banner --> 
</body>
</html>