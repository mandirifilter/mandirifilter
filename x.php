	// baru
	$selSto =mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$kode'");
	$sto    =mysqli_fetch_array($selSto);
	$stok    =$sto['stok'];

	$sisa    =$stok-$jumlah;

	if ($stok < $jumlah) {
		?>
		<script language="JavaScript">
			alert('Oops! Jumlah pengeluaran lebih besar dari stok ...');
			document.location='./';
		</script>
		<?php
	}else{
		$insert =mysqli_query($conn, "INSERT INTO detailorder (orderid, id_produk, qty) VALUES ('$orderidd', '$kode', '$jumlah')");
		if($insert){
                //update stok
			$upstok= mysqli_query($conn, "UPDATE produk SET stok='$sisa' WHERE idproduk='$kode'");
			?>
			<script language="JavaScript">
				alert('Good! Input transaksi pengeluaran barang berhasil ...');
				document.location='./';
			</script>
			<?php
		}
		else {
			echo "<div><b>Oops!</b> 404 Error Server.</div>";
		}
	}
	// baru