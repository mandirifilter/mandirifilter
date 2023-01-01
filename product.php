<?php
session_start();
include 'dbconnect.php';

if(!isset($_SESSION['log'])){
	header('location:login.php');
} else {
	
};

$idproduk = $_GET['idproduk'];

$uid = $_SESSION['id'];
$caricart = mysqli_query($conn,"select * from cart where userid='$uid' and status='Cart'");
$fetc = mysqli_fetch_array($caricart);
$orderidd = $fetc['orderid'];
$itungtrans = mysqli_query($conn,"select count(detailid) as jumlahtrans from detailorder where orderid='$orderidd'");
$itungtrans2 = mysqli_fetch_assoc($itungtrans);
$itungtrans3 = $itungtrans2['jumlahtrans'];

if(isset($_POST['addprod'])){
	if(!isset($_SESSION['log']))
	{	
		header('location:login.php');
	} else {
		$ui = $_SESSION['id'];
		$cek = mysqli_query($conn,"select * from cart where userid='$ui' and status='Cart'");
		$liat = mysqli_num_rows($cek);
		$f = mysqli_fetch_array($cek);
		$orid = $f['orderid'];

		//kalo ternyata udeh ada order id nya
		if($liat>0){
			//cek barang serupa
			$cekbrg = mysqli_query($conn,"select * from detailorder where idproduk='$idproduk' and orderid='$orid'");
			$liatlg = mysqli_num_rows($cekbrg);
			$brpbanyak = mysqli_fetch_array($cekbrg);
			$jmlh = $brpbanyak['qty'];

			//kalo ternyata barangnya udah ada
			if($liatlg>0){
				$i=1;
				$baru = $jmlh + $i;

				$updateaja = mysqli_query($conn,"update detailorder set qty='$baru' where orderid='$orid' and idproduk='$idproduk'");

				if($updateaja){
					echo " <div class='alert alert-success'>
					Barang sudah pernah dimasukkan ke keranjang, jumlah akan ditambahkan
					</div>
					<meta http-equiv='refresh' content='1; url= product.php?idproduk=".$idproduk."'/>";
				} else {
					echo "<div class='alert alert-warning'>
					Gagal menambahkan ke keranjang
					</div>
					<meta http-equiv='refresh' content='1; url= product.php?idproduk=".$idproduk."'/>";
				}

			} else {

				$selSto =mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idproduk'");
				$sto    =mysqli_fetch_array($selSto);
				$stok    =$sto['stok'];

				$sisa    =$stok-1;

				$tambahdata = mysqli_query($conn,"insert into detailorder (orderid,idproduk,qty) values('$orid','$idproduk','1')");
				$uproduk = mysqli_query($conn, "UPDATE produk SET stok='$sisa' WHERE idproduk='$idproduk'");
				if ($tambahdata && $uproduk){
					echo " <div class='alert alert-success'>
					Horee... Berhasil menambahkan ke keranjang
					</div>
					<meta http-equiv='refresh' content='1; url= product.php?idproduk=".$idproduk."'/>  ";
					} else { echo "<div class='alert alert-warning'>
					Gagal menambahkan ke keranjang
					</div>
					<meta http-equiv='refresh' content='1; url= product.php?idproduk=".$idproduk."'/> ";
				}
			};
		} else {

					//kalo belom ada order id nya
			$oi = crypt(rand(22,999),time());

			$bikincart = mysqli_query($conn,"insert into cart (orderid, userid) values('$oi','$ui')");

			if($bikincart){

				$selSto =mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idproduk'");
				$sto    =mysqli_fetch_array($selSto);
				$stok    =$sto['stok'];

				$sisa    =$stok-1;

				$uproduk = mysqli_query($conn, "UPDATE produk SET stok='$sisa' WHERE idproduk='$idproduk'");
				$tambahuser = mysqli_query($conn,"insert into detailorder (orderid,idproduk,qty) values('$oi','$idproduk','1')");
				if ($tambahuser && $uproduk){
					echo " <div class='alert alert-success'>
					Berhasil menambahkan ke keranjang
					</div>
					<meta http-equiv='refresh' content='1; url= product.php?idproduk=".$idproduk."'/>  ";
					} else { echo "<div class='alert alert-warning'>
					Gagal menambahkan ke keranjang
					</div>
					<meta http-equiv='refresh' content='1; url= product.php?idproduk=".$idproduk."'/> ";
				}
			} else {
				echo "gagal bikin cart";
			}
		}
	}
};
?>

<!DOCTYPE html>
<html>
<head>
	<title>Mandiri Filter - Produk</title>
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

	<div class="container" style="margin-top: 50px;">
		<div class="text-center">
			<h1>Detail
				<?php 
				$p = mysqli_fetch_array(mysqli_query($conn,"Select * from produk where idproduk='$idproduk'"));
				echo $p['namaproduk']; ?>
			</h1>
		</div>
	</div>
	<div class="products">
		<div class="container">
			<div class="agileinfo_single">
				
				<div class="col-md-4 agileinfo_single_left">
					<img id="example" src="<?php echo $p['gambar']?>" alt=" " class="img-responsive">
				</div>
				<div class="col-md-8 agileinfo_single_right">
					<h2><?php echo $p['namaproduk'] ?></h2>
					<h4>Stok Tersedia : <?php echo $p['stok'] ?></h4>
					<div class="rating1">
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
					<div class="w3agile_description">
						<h4>Deskripsi :</h4>
						<p><?php echo $p['deskripsi'] ?></p>
					</div>
					<div class="snipcart-item block">
						<div class="snipcart-thumb agileinfo_single_right_snipcart">
							<h4 class="m-sing">Rp <?php echo number_format($p['hargabefore']) ?></span></h4>
						</div>
						<div class="snipcart-details agileinfo_single_right_details">
							<form action="#" method="post">
								<fieldset>
									<?php 

									if($p['stok'] < 1) {
										?> 
										<label style="background-color: red; color: white; padding: 10px;">Stok Habis</label>
										<?php
									} else{
										?> 
										<input type="hidden" name="idprod" value="<?php echo $idproduk ?>">									
										<input type="submit" name="addprod" value="Add to cart" class="button">
										<?php
									}
									?>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
				<div class="clearfix"> </div>
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