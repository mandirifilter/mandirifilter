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

if(isset($_POST["update"])){
	$kode = $_POST['idproduknya'];
	$jumlah = $_POST['jumlah'];

	$d = mysqli_query($conn, "select * from produk where idproduk='$kode'") or die (mysqli_error());
	$cekstok=mysqli_fetch_array($d);
	$tersedia = $cekstok["stok"];
	$kurangi = $tersedia-$jumlah;

	$q2 = mysqli_query($conn, "update produk set stok='$kurangi' where idproduk='$kode'");
	$q1 = mysqli_query($conn, "update detailorder set qty='$jumlah' where idproduk='$kode' and orderid='$orderidd'");
	if($q1 && $q2){
		echo "Berhasil Update Cart
		<meta http-equiv='refresh' content='1; url= cart.php'/>";
	} else {
		echo "Gagal update cart
		<meta http-equiv='refresh' content='1; url= cart.php'/>";
	}
} else if(isset($_POST["hapus"])){
	$kode = $_POST['idproduknya'];
	$q2 = mysqli_query($conn, "delete from detailorder where idproduk='$kode' and orderid='$orderidd'");
	if($q2){
		echo "Berhasil Hapus";
	} else {
		echo "Gagal Hapus";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Mandiri Filter - Cart</title>
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
	
	<div class="checkout">
		<div class="container">
			<div class="checkout-right">
				<table class="timetable_sub">
					<thead>
						<tr>
							<th>No.</th>	
							<th>Produk</th>
							<th>Nama Produk</th>
							<th>Jumlah</th>
							
							
							<th>Harga Satuan</th>
							<th>Hapus</th>
						</tr>
					</thead>
					
					<?php 
					$brg=mysqli_query($conn,"SELECT * from detailorder d, produk p where orderid='$orderidd' and d.idproduk=p.idproduk order by d.idproduk ASC");
					$no=1;
					while($b=mysqli_fetch_array($brg)){

						?>
						<tr class="rem1">
							<form method="post">
							<td class="invert"><?php echo $no++ ?></td>
							<td class="invert"><a href="product.php?idproduk=<?php echo $b['idproduk'] ?>"><img src="<?php echo $b['gambar'] ?>" width="100px" height="100px" /></a></td>
							<td class="invert"><?php echo $b['namaproduk'] ?></td>
							<td class="invert">
								<div class="quantity"> 
									<div class="quantity-select">                     
										<input type="number" name="jumlah" class="form-control" height="100px" value="<?php echo $b['qty'] ?>" \>
									</div>
								</div>
							</td>
							
							<td class="invert">Rp<?php echo number_format($b['hargabefore']) ?></td>
							<td class="invert">
								<div class="rem">
									
									<input type="submit" name="update" class="form-control" value="Update" \>
									<input type="hidden" name="idproduknya" value="<?php echo $b['idproduk'] ?>" \>
									<input type="submit" name="hapus" class="form-control" value="Hapus" \>
								</form>
							</div>
							<script>$(document).ready(function(c) {
								$('.close1').on('click', function(c){
									$('.rem1').fadeOut('slow', function(c){
										$('.rem1').remove();
									});
								});	  
							});
						</script>
					</td>
				</tr>
				<?php
			}
			?>
			
			<!--quantity-->
			<script>
				$('.value-plus').on('click', function(){
					var divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.text(), 10)+1;
					divUpd.text(newVal);
				});

				$('.value-minus').on('click', function(){
					var divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.text(), 10)-1;
					if(newVal>=1) divUpd.text(newVal);
				});
			</script>
			<!--quantity-->
		</table>
	</div>
	<div class="checkout-left">	
		<div class="checkout-left-basket">
			<h4>Total Harga</h4>
			<ul>
				<?php 
				$brg=mysqli_query($conn,"SELECT * from detailorder d, produk p where orderid='$orderidd' and d.idproduk=p.idproduk order by d.idproduk ASC");
				$no=1;
				$subtotal = 10000;
				while($b=mysqli_fetch_array($brg)){
					$hrg = $b['hargabefore'];
					$qtyy = $b['qty'];
					$totalharga = $hrg * $qtyy;
					$subtotal += $totalharga
					?>
					<li><?php echo $b['namaproduk']?><i> - </i> <span>Rp<?php echo number_format($totalharga) ?> </span></li>
					<?php
				}
				?>


				<?php 
				if($itungtrans3 > 1) {
					$potongan=(($subtotal*10)/100);
					$totbayar=($subtotal-$potongan);
					?>
					<li>Total (inc. 10k Ongkir + diskon 10%)<i> - </i></li>
					<li>Rp<?php echo number_format($totbayar) ?></li>
					<?php
				} else {
					?>
					<li>Total (inc. 10k Ongkir)<i> - </i> <span>Rp<?php echo number_format($subtotal) ?></span></li>
					<?php
				}
				?>






				<!-- <li>Total (inc. 10k Ongkir)<i> - </i> <span>Rp<?php echo number_format($subtotal) ?></span></li> -->


			</ul>
		</div>
		<div class="checkout-right-basket">
			<a href="index.php"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Continue Shopping</a>
			<a href="checkout.php"><span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>Checkout</a>
		</div>
		<div class="clearfix"> </div>
	</div>
</div>
</div>
<!-- //checkout -->

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