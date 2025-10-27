<?php
if(!empty($_SESSION["sepet"]) && !empty($_SESSION["odemetipi"]) && $_SESSION["odemetipi"]>0 && $_SESSION["odemetipi"]<4)
{
	$odemetipi=$VT->filter($_SESSION["odemetipi"]);
	if(!empty($_SESSION["uyeID"]))
	{
		$uyeID=$VT->filter($_SESSION["uyeID"]);
		$uyebilgisi=$VT->VeriGetir("uyeler","WHERE ID=? AND durum=?",array($uyeID,1),"ORDER BY ID ASC",1);
		if($uyebilgisi!=false)
		{
			$sepetkdvharictutar=0;
			$sepetkdvtutar18=0;
			$sepetkdvtutar8=0;
			$sepetkdvtutar6=0;
			$sepetkdvtutar1=0;
			$sepetTutar=0;
			$siparisID=$VT->IDGetir("siparisler");
			$sipariskodu=$_SESSION["siparisKodu"];

			foreach ($_SESSION["sepet"] as $urunID => $bilgi) {
				$urunbilgisi=$VT->VeriGetir("urunler","WHERE durum=? AND ID=?",array(1,$urunID),"ORDER BY ID ASC",1);
				if($urunbilgisi!=false)
				{
					if($bilgi["varyasyondurumu"]!=false)
					{
						if(!empty($_SESSION["sepetVaryasyon"]))
						{
							foreach ($_SESSION["sepetVaryasyon"][$urunbilgisi[0]["ID"]] as $secenekID => $secenekAdet) {
								$stokTablo=$VT->VeriGetir("urunvaryasyonstoklari","WHERE ID=? AND urunID=?",array($secenekID,$urunbilgisi[0]["ID"]),"ORDER BY ID ASC",1);
								if($stokTablo!=false)
								{
									$varyasyonOzellikleri="";
									$varyasyonID=$stokTablo[0]["varyasyonID"];
									$secimID=$stokTablo[0]["secenekID"];

									if(!empty($urunbilgisi[0]["indirimlifiyat"]))
									{
										$fiyat=$urunbilgisi[0]["indirimlifiyat"].".".$urunbilgisi[0]["indirimlikurus"];
										if($urunbilgisi[0]["kdvdurum"]==1)
										{
											if($urunbilgisi[0]["kdvoran"]>9)
											{
												$oran="1.".$urunbilgisi[0]["kdvoran"];
											}
											else
											{
												$oran="1.0".$urunbilgisi[0]["kdvoran"];
											}
											$kdvsizBirimfiyat=($fiyat/$oran);
										}
										else
										{
											$kdvsizBirimfiyat=$fiyat;
										}
									}
									else
									{
										$fiyat=$urunbilgisi[0]["fiyat"].".".$urunbilgisi[0]["kurus"];
										if($urunbilgisi[0]["kdvdurum"]==1)
										{
											if($urunbilgisi[0]["kdvoran"]>9)
											{
												$oran="1.".$urunbilgisi[0]["kdvoran"];
											}
											else
											{
												$oran="1.0".$urunbilgisi[0]["kdvoran"];
											}
											$kdvsizBirimfiyat=($fiyat/$oran);
										}
										else
										{
											$kdvsizBirimfiyat=$fiyat;
										}
									}
									$toplamFiyat=($kdvsizBirimfiyat*$secenekAdet["adet"]);
									$siparisurunEkle=$VT->SorguCalistir("INSERT INTO siparisurunler","SET uyeID=?, siparisID=?, urunID=?, varyasyonID=?, uruntutar=?, adet=?, kdvdurum=?, kdvoran=?, toplamtutar=?, tarih=?",array($uyebilgisi[0]["ID"],$siparisID,$urunbilgisi[0]["ID"],$stokTablo[0]["ID"],number_format($kdvsizBirimfiyat,2,".",""),$secenekAdet["adet"],2,$urunbilgisi[0]["kdvoran"],number_format($toplamFiyat,2,".",""),date("Y-m-d")));

									$varyasyonStokDusme=$VT->SorguCalistir("UPDATE urunvaryasyonstoklari","SET stok=? WHERE ID=?",array(($stokTablo[0]["stok"]-$secenekAdet["adet"]),$stokTablo[0]["ID"]),1);
									$urunStokDusme=$VT->SorguCalistir("UPDATE urunler","SET stok=? WHERE ID=?",array(($urunbilgisi[0]["stok"]-$secenekAdet["adet"]),$urunbilgisi[0]["ID"]),1);

									$toplamtutar=($fiyat*$secenekAdet["adet"]);

									if($urunbilgisi[0]["kdvdurum"]==1)
									{
										if($urunbilgisi[0]["kdvoran"]>9)
										{
											$oran="1.".$urunbilgisi[0]["kdvoran"];
										}
										else
										{
											$oran="1.0".$urunbilgisi[0]["kdvoran"];
										}
										$kdvlifiyat=$toplamtutar;
										$kdvsizfiyat=($toplamtutar/$oran);
										$kdvtutari=($toplamtutar-$kdvsizfiyat);
										if($urunbilgisi[0]["kdvoran"]==18){$sepetkdvtutar18=($sepetkdvtutar18+$kdvtutari);}
										if($urunbilgisi[0]["kdvoran"]==8){$sepetkdvtutar8=($sepetkdvtutar8+$kdvtutari);}
										if($urunbilgisi[0]["kdvoran"]==6){$sepetkdvtutar6=($sepetkdvtutar6+$kdvtutari);}
										if($urunbilgisi[0]["kdvoran"]==1){$sepetkdvtutar1=($sepetkdvtutar1+$kdvtutari);}
										$sepetkdvharictutar=($sepetkdvharictutar+$kdvsizfiyat);
										$sepetTutar=($sepetTutar+$kdvlifiyat);
									}
									else
									{
										$oran=$urunbilgisi[0]["kdvoran"];
										$kdvsizfiyat=$toplamtutar;
										$kdvtutari=(($kdvsizfiyat*$oran)/100);
										$kdvlifiyat=($kdvsizfiyat+$kdvtutari);
										if($urunbilgisi[0]["kdvoran"]==18){$sepetkdvtutar18=($sepetkdvtutar18+$kdvtutari);}
										if($urunbilgisi[0]["kdvoran"]==8){$sepetkdvtutar8=($sepetkdvtutar8+$kdvtutari);}
										if($urunbilgisi[0]["kdvoran"]==6){$sepetkdvtutar6=($sepetkdvtutar6+$kdvtutari);}
										if($urunbilgisi[0]["kdvoran"]==1){$sepetkdvtutar1=($sepetkdvtutar1+$kdvtutari);}
										$sepetkdvharictutar=($sepetkdvharictutar+$kdvsizfiyat);
										$sepetTutar=($sepetTutar+$kdvlifiyat);
									}
								}
							}
						}
					}
					else
					{
						if(!empty($urunbilgisi[0]["indirimlifiyat"]))
						{
							$fiyat=$urunbilgisi[0]["indirimlifiyat"].".".$urunbilgisi[0]["indirimlikurus"];
							if($urunbilgisi[0]["kdvdurum"]==1)
							{
								if($urunbilgisi[0]["kdvoran"]>9)
								{
									$oran="1.".$urunbilgisi[0]["kdvoran"];
								}
								else
								{
									$oran="1.0".$urunbilgisi[0]["kdvoran"];
								}
								$kdvsizBirimfiyat=($fiyat/$oran);
							}
							else
							{
								$kdvsizBirimfiyat=$fiyat;
							}
						}
						else
						{
							$fiyat=$urunbilgisi[0]["fiyat"].".".$urunbilgisi[0]["kurus"];
							if($urunbilgisi[0]["kdvdurum"]==1)
							{
								if($urunbilgisi[0]["kdvoran"]>9)
								{
									$oran="1.".$urunbilgisi[0]["kdvoran"];
								}
								else
								{
									$oran="1.0".$urunbilgisi[0]["kdvoran"];
								}
								$kdvsizBirimfiyat=($fiyat/$oran);
							}
							else
							{
								$kdvsizBirimfiyat=$fiyat;
							}
						}
						$toplamFiyat=($kdvsizBirimfiyat*$bilgi["adet"]);
						$siparisurunEkle=$VT->SorguCalistir("INSERT INTO siparisurunler","SET uyeID=?, siparisID=?, urunID=?, uruntutar=?, adet=?, kdvdurum=?, kdvoran=?, toplamtutar=?, tarih=?",array($uyebilgisi[0]["ID"],$siparisID,$urunbilgisi[0]["ID"],number_format($kdvsizBirimfiyat,2,".",""),$bilgi["adet"],2,$urunbilgisi[0]["kdvoran"],number_format($toplamFiyat,2,".",""),date("Y-m-d")));

						$urunStokDusme=$VT->SorguCalistir("UPDATE urunler","SET stok=? WHERE ID=?",array(($urunbilgisi[0]["stok"]-$bilgi["adet"]),$urunbilgisi[0]["ID"]),1);

						$toplamtutar=($fiyat*$bilgi["adet"]);

						if($urunbilgisi[0]["kdvdurum"]==1)
						{
							if($urunbilgisi[0]["kdvoran"]>9)
							{
								$oran="1.".$urunbilgisi[0]["kdvoran"];
							}
							else
							{
								$oran="1.0".$urunbilgisi[0]["kdvoran"];
							}
							$kdvlifiyat=$toplamtutar;
							$kdvsizfiyat=($toplamtutar/$oran);
							$kdvtutari=($toplamtutar-$kdvsizfiyat);
							if($urunbilgisi[0]["kdvoran"]==18){$sepetkdvtutar18=($sepetkdvtutar18+$kdvtutari);}
							if($urunbilgisi[0]["kdvoran"]==8){$sepetkdvtutar8=($sepetkdvtutar8+$kdvtutari);}
							if($urunbilgisi[0]["kdvoran"]==6){$sepetkdvtutar6=($sepetkdvtutar6+$kdvtutari);}
							if($urunbilgisi[0]["kdvoran"]==1){$sepetkdvtutar1=($sepetkdvtutar1+$kdvtutari);}
							$sepetkdvharictutar=($sepetkdvharictutar+$kdvsizfiyat);
							$sepetTutar=($sepetTutar+$kdvlifiyat);
						}
						else
						{
							$oran=$urunbilgisi[0]["kdvoran"];
							$kdvsizfiyat=$toplamtutar;
							$kdvtutari=(($kdvsizfiyat*$oran)/100);
							$kdvlifiyat=($kdvsizfiyat+$kdvtutari);
							if($urunbilgisi[0]["kdvoran"]==18){$sepetkdvtutar18=($sepetkdvtutar18+$kdvtutari);}
							if($urunbilgisi[0]["kdvoran"]==8){$sepetkdvtutar8=($sepetkdvtutar8+$kdvtutari);}
							if($urunbilgisi[0]["kdvoran"]==6){$sepetkdvtutar6=($sepetkdvtutar6+$kdvtutari);}
							if($urunbilgisi[0]["kdvoran"]==1){$sepetkdvtutar1=($sepetkdvtutar1+$kdvtutari);}
							$sepetkdvharictutar=($sepetkdvharictutar+$kdvsizfiyat);
							$sepetTutar=($sepetTutar+$kdvlifiyat);
						}
					}
				}
			}

			$genelKDVTutar=0;
			if($sepetkdvtutar1>0)
			{
				$genelKDVTutar=($genelKDVTutar+$sepetkdvtutar1);
			}
			if($sepetkdvtutar6>0)
			{
				$genelKDVTutar=($genelKDVTutar+$sepetkdvtutar6);
			}
			if($sepetkdvtutar8>0)
			{
				$genelKDVTutar=($genelKDVTutar+$sepetkdvtutar8);
			}
			if($sepetkdvtutar18>0)
			{
				$genelKDVTutar=($genelKDVTutar+$sepetkdvtutar18);
			}
			$ekle=$VT->SorguCalistir("INSERT INTO siparisler","SET uyeID=?, sipariskodu=?, kdvharictutar=?, kdvtutar=?, odenentutar=?, odemetipi=?, durum=?, tarih=?",array($uyebilgisi[0]["ID"],$sipariskodu,number_format($sepetkdvharictutar,2,".",""),number_format($genelKDVTutar,2,".",""),number_format($sepetTutar,2,".",""),1,1,date("Y-m-d")));

			if(!empty($_SESSION["sepetVaryasyon"]))
			{
				unset($_SESSION["sepetVaryasyon"]);
			}

			unset($_SESSION["sepet"]);
			?>

<!--==============================
Breadcumb
============================== -->
<div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/breadcumb/breadcumb-img-1.jpg">
	<div class="container">
		<div class="breadcumb-content text-center">
			<h1 class="breadcumb-title">Odeme Basarili</h1>
			<ul class="breadcumb-menu-style1 mx-auto">
				<li><a href="<?=SITE?>">Anasayfa</a></li>
				<li><a href="<?=SITE?>sepet">Sepet</a></li>
				<li class="active">Odeme Sonuc</li>
			</ul>
		</div>
	</div>
</div>

<!--==============================
	Payment Success Section
==============================-->
<section class="space-top space-md-bottom">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<!-- Success Animation -->
				<div class="success-animation-wrapper text-center mb-5">
					<div class="success-checkmark">
						<div class="check-icon">
							<span class="icon-line line-tip"></span>
							<span class="icon-line line-long"></span>
							<div class="icon-circle"></div>
							<div class="icon-fix"></div>
						</div>
					</div>
					<h2 class="success-title mt-4 mb-3">Odemeniz Basariyla Alindi!</h2>
					<p class="success-text">Siparisiz basariyla olusturuldu ve isleme alindi.</p>
				</div>

				<!-- Order Details Card -->
				<div class="order-details-card bg-white p-4 p-md-5 shadow-sm rounded mb-4">
					<h4 class="card-title mb-4">
						<i class="far fa-receipt me-2 text-success"></i>Siparis Detaylari
					</h4>
					<div class="row">
						<div class="col-md-6 mb-3">
							<div class="detail-item">
								<span class="detail-label">Siparis Kodu:</span>
								<span class="detail-value fw-bold"><?=$sipariskodu?></span>
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<div class="detail-item">
								<span class="detail-label">Odeme Tutari:</span>
								<span class="detail-value fw-bold text-success"><?=number_format($sepetTutar,2,",",".")?> TL</span>
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<div class="detail-item">
								<span class="detail-label">Tarih:</span>
								<span class="detail-value"><?=date("d.m.Y H:i")?></span>
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<div class="detail-item">
								<span class="detail-label">Odeme Tipi:</span>
								<span class="detail-value">Kredi Karti</span>
							</div>
						</div>
					</div>

					<div class="alert alert-info border-0 mt-4">
						<i class="far fa-info-circle me-2"></i>
						Siparis detaylari e-posta adresinize gonderilmistir.
					</div>
				</div>

				<!-- Action Buttons -->
				<div class="action-buttons text-center">
					<a href="<?=SITE?>siparislerim" class="vs-btn style4 me-2 mb-2">
						<i class="far fa-shopping-bag me-2"></i>Siparislerime Git
					</a>
					<a href="<?=SITE?>" class="vs-btn style7 mb-2">
						<i class="far fa-home me-2"></i>Alisverise Devam Et
					</a>
				</div>

				<!-- Thank You Message -->
				<div class="thank-you-box bg-light p-4 rounded mt-4 text-center">
					<h5 class="mb-2">Tesekkur Ederiz!</h5>
					<p class="mb-0 text-muted">Bizi tercih ettiginiz icin tesekkur ederiz. Siparisiz en kisa surede kargoya verilecektir.</p>
				</div>
			</div>
		</div>
	</div>
</section>

<style>
	/* Success Animation */
	.success-animation-wrapper {
		padding: 40px 20px;
	}
	.success-checkmark {
		width: 120px;
		height: 120px;
		margin: 0 auto;
		border-radius: 50%;
		display: block;
		stroke-width: 3;
		stroke: #4caf50;
		stroke-miterlimit: 10;
		box-shadow: inset 0px 0px 0px #4caf50;
		animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
		position: relative;
	}
	.success-checkmark .check-icon {
		width: 120px;
		height: 120px;
		position: relative;
		border-radius: 50%;
		box-sizing: content-box;
		border: 4px solid #4caf50;
	}
	.success-checkmark .check-icon::before {
		top: 3px;
		left: -2px;
		width: 30px;
		transform-origin: 100% 50%;
		border-radius: 100px 0 0 100px;
	}
	.success-checkmark .check-icon::after {
		top: 0;
		left: 30px;
		width: 60px;
		transform-origin: 0 50%;
		border-radius: 0 100px 100px 0;
		animation: rotate-circle 4.25s ease-in;
	}
	.success-checkmark .icon-line {
		height: 5px;
		background-color: #4caf50;
		display: block;
		border-radius: 2px;
		position: absolute;
		z-index: 10;
	}
	.success-checkmark .icon-line.line-tip {
		top: 56px;
		left: 25px;
		width: 25px;
		transform: rotate(45deg);
		animation: icon-line-tip .75s;
	}
	.success-checkmark .icon-line.line-long {
		top: 48px;
		right: 13px;
		width: 47px;
		transform: rotate(-45deg);
		animation: icon-line-long .75s;
	}
	.success-checkmark .icon-circle {
		top: -4px;
		left: -4px;
		z-index: 10;
		width: 120px;
		height: 120px;
		border-radius: 50%;
		position: absolute;
		box-sizing: content-box;
		border: 4px solid rgba(76, 175, 80, .5);
	}
	.success-checkmark .icon-fix {
		top: 12px;
		width: 10px;
		left: 30px;
		z-index: 1;
		height: 95px;
		position: absolute;
		transform: rotate(-45deg);
		background-color: #fff;
	}

	@keyframes rotate-circle {
		0% { transform: rotate(-45deg); }
		5% { transform: rotate(-45deg); }
		12% { transform: rotate(-405deg); }
		100% { transform: rotate(-405deg); }
	}
	@keyframes icon-line-tip {
		0% { width: 0; left: 1px; top: 26px; }
		54% { width: 0; left: 1px; top: 26px; }
		70% { width: 50px; left: -8px; top: 37px; }
		84% { width: 17px; left: 21px; top: 48px; }
		100% { width: 25px; left: 25px; top: 56px; }
	}
	@keyframes icon-line-long {
		0% { width: 0; right: 46px; top: 54px; }
		65% { width: 0; right: 46px; top: 54px; }
		84% { width: 55px; right: 0px; top: 35px; }
		100% { width: 47px; right: 13px; top: 48px; }
	}
	@keyframes fill {
		100% { box-shadow: inset 0px 0px 0px 60px #4caf50; }
	}
	@keyframes scale {
		0%, 100% { transform: none; }
		50% { transform: scale3d(1.1, 1.1, 1); }
	}

	/* Success Title & Text */
	.success-title {
		font-size: 32px;
		font-weight: 700;
		color: #333;
	}
	.success-text {
		font-size: 16px;
		color: #666;
	}

	/* Order Details Card */
	.order-details-card {
		border: 2px solid #e8e8e8;
	}
	.card-title {
		color: #333;
		font-weight: 700;
		border-bottom: 2px solid #4caf50;
		padding-bottom: 15px;
	}
	.detail-item {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 12px;
		background: #f8f9fa;
		border-radius: 6px;
	}
	.detail-label {
		color: #666;
		font-size: 14px;
	}
	.detail-value {
		color: #333;
		font-size: 14px;
	}

	/* Action Buttons */
	.action-buttons {
		margin: 30px 0;
	}

	/* Thank You Box */
	.thank-you-box {
		background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
		border: 1px solid #dee2e6;
	}
	.thank-you-box h5 {
		color: #333;
		font-weight: 700;
	}

	/* Alert */
	.alert-info {
		background: #d1ecf1;
		color: #0c5460;
	}

	/* Responsive */
	@media (max-width: 768px) {
		.success-checkmark {
			width: 100px;
			height: 100px;
		}
		.success-checkmark .check-icon {
			width: 100px;
			height: 100px;
		}
		.success-checkmark .icon-circle {
			width: 100px;
			height: 100px;
		}
		.success-checkmark .icon-line.line-tip {
			top: 46px;
			left: 20px;
			width: 20px;
		}
		.success-checkmark .icon-line.line-long {
			top: 40px;
			right: 10px;
			width: 40px;
		}
		.success-title {
			font-size: 24px;
		}
		.success-text {
			font-size: 14px;
		}
		.detail-item {
			flex-direction: column;
			align-items: flex-start;
			gap: 5px;
		}
	}
</style>

<script>
	// Auto redirect after 5 seconds
	setTimeout(function() {
		// Uncomment if you want auto redirect
		// window.location.href = '<?=SITE?>siparislerim';
	}, 5000);

	// Confetti effect (optional - requires canvas-confetti library)
	document.addEventListener('DOMContentLoaded', function() {
		// Add confetti animation on success
		console.log('Payment successful!');
	});
</script>

<meta http-equiv="refresh" content="5;url=<?=SITE?>odeme-sonuc">

			<?php
		}
		else
		{
			?>
			<meta http-equiv="refresh" content="0;url=<?=SITE?>uyelik">
			<?php
		}
	}
	else
	{
		?>
		<meta http-equiv="refresh" content="0;url=<?=SITE?>uyelik">
		<?php
	}
}
else
{
	?>
	<meta http-equiv="refresh" content="0;url=<?=SITE?>">
	<?php
}
?>
