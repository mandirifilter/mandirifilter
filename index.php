<?php
session_start();
include 'dbconnect.php';

if(!isset($_SESSION['log'])){
	header('location:login.php');
} else {
	
};

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
	<title>Mandiri Filter</title>
	<!-- for-mobile-apps -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Falenda Flora, Ruben Agung Santoso" />
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
</head>

<body>
	<div class="">
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
						<li class="active"><a  style="color: black !important;" href="#about" class="act">About</a></li>
						<li class="active"><a  style="color: black !important;" href="#product" class="act">Product</a></li>
						<li class="active"><a  style="color: black !important;" href="#contact" class="act">Contact</a></li>
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


	<section class="jumbotron" style=" background-image: url(images/background.jpg); padding: 8.2em">
		<div class="row text-center">
			<h1 style="color: white; text-shadow: 0 0 3px #FF0000;">Pilihan Terbaik Untuk Berbelanja</h1>
		</div>
	</section>

	<div class="top-brands" style="padding-bottom: 0; background: white;">
		<div class="container">
			<h2>Service</h2>
			<div class="grid_3 grid_5">
				<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
					<div id="myTabContent" class="tab-content">
						<div class="row">
							<div class="col-md-3">
								<div class="text-center">
									<div class="mt-2"><img src="images/1.jpg" width="40" height="40" /></div>
									<h5 class="mt-3">Delivery</h5>
								</div>
							</div>
							<div class="col-md-3">
								<div class="text-center">
									<div class="mt-2"><img src="images/2.jpg" width="40" height="40" /></div>
									<h5 class="mt-3">Pemasangan</h5>
								</div>
							</div>
							<div class="col-md-3">
								<div class="text-center">
									<div class="mt-2"><img src="images/3.jpg" width="40" height="40" /></div>
									<h5 class="mt-3">Eceran dan Grosir</h5>
								</div>
							</div>
							<div class="col-md-3">
								<div class="text-center">
									<div class="mt-2"><img src="images/4.jpg" width="40" height="40" /></div>
									<h5 class="mt-3">Ambil Sendiri</h5>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="about" class="top-brands"  style="background: white;">
		<div class="container">
			<h2>About Us</h2>
		</div>
	</div>
	<div class="container">
		<div class="row" style="display: flex; justify-content: center;">
			<div class="col-lg-5">
				<img src="images/mf.jpg" class="img-fluid" style="max-width: 100%" alt="usaha" />
			</div>
			<div class="col-lg-4" style="display: flex; align-items: center; text-align: center;">
				<p>
					Menerima Pembelian Secara Eceran/Grosir. <br />Lokasi di Ruko Grand Kenanga No 07, Sungailiat Bangka Belitung. <br />
					Senin - Sabtu 07.30-17.00 Wib. <br />Minggu dan Hari Libur 07.30-12.00 Wib
				</p>
			</div>
		</div>
	</div>

	<div id="product" class="top-brands"  style="padding-bottom: 0; background: white;">
		<div class="container">
			<h2>Product</h2>
			<div class="">
				<div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
					<div id="myTabContent" class="tab-content">
						<div role="tabpanel" class="tab-pane fade in active" id="expeditions" aria-labelledby="expeditions-tab">
							<div class="agile_top_brands_grids">

								<?php 
								$brgs=mysqli_query($conn,"SELECT * from produk order by idproduk ASC");
								$no=1;
								while($p=mysqli_fetch_array($brgs)){

									?>
									<div class="col-md-4 top_brand_left" style="margin-bottom: 20px;">
										<div class="hover14 column">
											<div class="agile_top_brand_left_grid">
												<div class="agile_top_brand_left_grid_pos">
													<img src="images/offer.png" alt=" " class="img-responsive" />
												</div>
												<div class="agile_top_brand_left_grid1">
													<figure>
														<div class="snipcart-item block" >
															<div class="snipcart-thumb">
																<a href="product.php?idproduk=<?php echo $p['idproduk'] ?>"><img title=" " alt=" " src="<?php echo $p['gambar']?>" width="200px" height="200px" /></a>		
																<p><?php echo $p['namaproduk'] ?></p>
																<p>Stok: <?php echo $p['stok'] ?></p>
																<div class="stars">
																	<?php
																	$bintang = '<i class="fa fa-star blue-star" aria-hidden="true"></i>';
																	$rate = $p['rate'];

																	for($n=1;$n<=$rate;$n++){
																		echo '<i class="fa fa-star blue-star" aria-hidden="true"></i>';
																	};
																	?>
																</div>
																<h4>Rp <?php echo number_format($p['hargabefore']) ?></span></h4>
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
																		<a href="product.php?idproduk=<?php echo $p['idproduk'] ?>">
																			<input type="submit" class="button" value="Lihat Produk" />
																		</a>
																		
																		<?php
																	}
																	?>
																	<!-- <a href="product.php?idproduk=<?php echo $p['idproduk'] ?>">
																		<input type="submit" class="button" value="Lihat Produk" />
																	</a> -->
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
								?>								
								<div class="clearfix"> </div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div id="contact" class="top-brands"  style="padding-top: 0; background: white;">
		<div class="container">
			<h2>Contact Us</h2>
		</div>
	</div>
	<div class="container">
		<div class="row" style="margin-bottom: 100px;">
			<div class="col-lg-12">
				<div id="map-container-section" class="z-depth-1-half map-container-section mb-4" style="height: 400px">
					<iframe
					src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.6067168695513!2d106.11248111375016!3d-1.9078084371555484!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e22f3af07a45215%3A0x4c8c9f02d540bfa7!2sMandiri%20Filter!5e0!3m2!1sen!2sid!4v1668700599116!5m2!1sen!2sid"
					width="100%"
					height="450"
					style="border: 0"
					allowfullscreen=""
					loading="lazy"
					referrerpolicy="no-referrer-when-downgrade"
					frameborder="0"
					style="border: 0" allowfullscreen></iframe>
				</div>
			</div>
		</div>		
	</div>
	<div class="container">
		<div class="row text-center" style="margin-bottom: 50px;">
			<div class="col-md-4">
				<a class="btn-floating blue accent-1">
					<i class="fas fa-map-marker-alt"></i>
				</a>
				<p>Sungailiat, Bangka Belitung</p>
			</div>
			<div class="col-md-4">
				<a class="btn-floating blue accent-1"> </a>
				<p>klik</p>
				<a href="https://api.whatsapp.com/send?phone=6281373800766&text=Hallo%20Saya%20Mau%20Pesan"><img src="images/wa.jpg" width="25"></a>
			</div>
			<div class="col-md-4">
				<a class="btn-floating blue accent-1"> </a>
				<p class="mb-0">Mon - Sat, 07:30-17:00</p>
				<p class="mb-0">Sun, 07:30-12:00</p>
			</div>
		</div>		
	</div>

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
</body>
</html>