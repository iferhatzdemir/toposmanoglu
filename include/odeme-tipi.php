<?php
if(!empty($_SESSION["sepet"]))
{
	if(!empty($_SESSION["uyeID"]))
	{
		$uyeID=$VT->filter($_SESSION["uyeID"]);
		$uyebilgisi=$VT->VeriGetir("uyeler","WHERE ID=? AND durum=?",array($uyeID,1),"ORDER BY ID ASC",1);
		if($uyebilgisi!=false)
		{
			// Calculate cart totals
			$sepetkdvharictutar=0;
			$sepetkdvtutar18=0;
			$sepetkdvtutar8=0;
			$sepetkdvtutar6=0;
			$sepetkdvtutar1=0;
			$sepetTutar=0;

			// Process cart items
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
									if(!empty($urunbilgisi[0]["indirimlifiyat"]))
									{
										$fiyat=$urunbilgisi[0]["indirimlifiyat"].".".$urunbilgisi[0]["indirimlikurus"];
									}
									else
									{
										$fiyat=$urunbilgisi[0]["fiyat"].".".$urunbilgisi[0]["kurus"];
									}

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
						}
						else
						{
							$fiyat=$urunbilgisi[0]["fiyat"].".".$urunbilgisi[0]["kurus"];
						}

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

			// Handle payment type selection
			if($_POST)
			{
				if(!empty($_POST["odemetipi"]) && $_POST["odemetipi"]>0 && $_POST["odemetipi"]<4)
				{
					$odemetipi=$VT->filter($_POST["odemetipi"]);
					$_SESSION["odemetipi"]=$odemetipi;
					?>
					<meta http-equiv="refresh" content="0;url=<?=SITE?>odeme-yap">
					<?php
					exit();
				}
			}
?>

<!--==============================
Breadcumb
============================== -->
<div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/breadcumb/breadcumb-img-1.jpg">
	<div class="container">
		<div class="breadcumb-content text-center">
			<h1 class="breadcumb-title">Odeme Tipi Secimi</h1>
			<ul class="breadcumb-menu-style1 mx-auto">
				<li><a href="<?=SITE?>">Anasayfa</a></li>
				<li><a href="<?=SITE?>sepet">Sepet</a></li>
				<li class="active">Odeme Tipi</li>
			</ul>
		</div>
	</div>
</div>

<!--==============================
	Payment Type Selection
==============================-->
<section class="space-top space-md-bottom">
	<div class="container">
		<div class="row">
			<!-- Payment Options -->
			<div class="col-lg-8 mb-4">
				<div class="payment-options-wrapper">
					<h3 class="section-title mb-4">
						<i class="far fa-credit-card me-2"></i>Odeme Yontemi Secin
					</h3>

					<form action="#" method="post" id="paymentForm">
						<div class="payment-methods">
							<!-- Credit Card Payment -->
							<div class="payment-method-card">
								<input type="radio" name="odemetipi" id="payment1" value="1" checked>
								<label for="payment1" class="payment-label">
									<div class="payment-icon">
										<i class="far fa-credit-card"></i>
									</div>
									<div class="payment-info">
										<h5 class="payment-title">Kredi Karti ile Odeme</h5>
										<p class="payment-desc">Guvenli SSL baglantisi ile aninda odeme</p>
										<div class="payment-badges">
											<img src="<?=SITE?>assets/img/payment/visa.png" alt="Visa" style="height: 25px;">
											<img src="<?=SITE?>assets/img/payment/mastercard.png" alt="Mastercard" style="height: 25px;">
											<img src="<?=SITE?>assets/img/payment/amex.png" alt="Amex" style="height: 25px;">
										</div>
									</div>
									<div class="payment-check">
										<i class="far fa-check-circle"></i>
									</div>
								</label>
							</div>

							<!-- Bank Transfer Payment -->
							<div class="payment-method-card">
								<input type="radio" name="odemetipi" id="payment2" value="2">
								<label for="payment2" class="payment-label">
									<div class="payment-icon">
										<i class="far fa-university"></i>
									</div>
									<div class="payment-info">
										<h5 class="payment-title">Havale / EFT ile Odeme</h5>
										<p class="payment-desc">Banka hesabimiza havale yaparak odeme</p>
										<div class="payment-note">
											<i class="far fa-info-circle me-1"></i>
											<small>Havale dekontunu e-posta ile gonderiniz</small>
										</div>
									</div>
									<div class="payment-check">
										<i class="far fa-check-circle"></i>
									</div>
								</label>
							</div>

							<!-- Cash on Delivery -->
							<div class="payment-method-card">
								<input type="radio" name="odemetipi" id="payment3" value="3">
								<label for="payment3" class="payment-label">
									<div class="payment-icon">
										<i class="far fa-hand-holding-usd"></i>
									</div>
									<div class="payment-info">
										<h5 class="payment-title">Kapida Odeme</h5>
										<p class="payment-desc">Urun teslim alindiginda nakit odeme</p>
										<div class="payment-note warning">
											<i class="far fa-exclamation-triangle me-1"></i>
											<small>Ekstra 10 TL kargo ucreti eklenecektir</small>
										</div>
									</div>
									<div class="payment-check">
										<i class="far fa-check-circle"></i>
									</div>
								</label>
							</div>
						</div>

						<!-- Security Info -->
						<div class="security-info-box mt-4">
							<div class="d-flex align-items-center">
								<i class="far fa-shield-check text-success me-3" style="font-size: 40px;"></i>
								<div>
									<h6 class="mb-1">Guvenli Odeme</h6>
									<p class="mb-0 small text-muted">Tum odeme islemleriniz SSL sertifikasi ile sifrelenmektedir.</p>
								</div>
							</div>
						</div>

						<button type="submit" class="vs-btn style4 w-100 mt-4">
							<i class="far fa-lock me-2"></i>Guvenli Odemeye Gec
						</button>
					</form>
				</div>
			</div>

			<!-- Order Summary -->
			<div class="col-lg-4">
				<div class="order-summary-sticky">
					<div class="order-summary-card bg-white shadow-sm rounded p-4">
						<h4 class="summary-title mb-4">
							<i class="far fa-shopping-cart me-2"></i>Siparis Ozeti
						</h4>

						<div class="summary-list">
							<div class="summary-item">
								<span class="item-label">Ara Toplam:</span>
								<span class="item-value"><?=number_format($sepetkdvharictutar,2,",",".")?> TL</span>
							</div>

							<?php if($sepetkdvtutar1>0) { ?>
							<div class="summary-item">
								<span class="item-label">KDV (%1):</span>
								<span class="item-value"><?=number_format($sepetkdvtutar1,2,",",".")?> TL</span>
							</div>
							<?php } ?>

							<?php if($sepetkdvtutar6>0) { ?>
							<div class="summary-item">
								<span class="item-label">KDV (%6):</span>
								<span class="item-value"><?=number_format($sepetkdvtutar6,2,",",".")?> TL</span>
							</div>
							<?php } ?>

							<?php if($sepetkdvtutar8>0) { ?>
							<div class="summary-item">
								<span class="item-label">KDV (%8):</span>
								<span class="item-value"><?=number_format($sepetkdvtutar8,2,",",".")?> TL</span>
							</div>
							<?php } ?>

							<?php if($sepetkdvtutar18>0) { ?>
							<div class="summary-item">
								<span class="item-label">KDV (%18):</span>
								<span class="item-value"><?=number_format($sepetkdvtutar18,2,",",".")?> TL</span>
							</div>
							<?php } ?>

							<div class="summary-divider"></div>

							<div class="summary-item total">
								<span class="item-label">Odenecek Tutar:</span>
								<span class="item-value"><?=number_format($sepetTutar,2,",",".")?> TL</span>
							</div>
						</div>

						<div class="summary-info mt-4">
							<div class="info-item">
								<i class="far fa-truck text-success me-2"></i>
								<span class="small">Ucretsiz Kargo (500 TL uzeri)</span>
							</div>
							<div class="info-item">
								<i class="far fa-undo text-success me-2"></i>
								<span class="small">14 Gun Icerisinde Iade</span>
							</div>
							<div class="info-item">
								<i class="far fa-shield-check text-success me-2"></i>
								<span class="small">Guvenli Alisveris Garantisi</span>
							</div>
						</div>
					</div>

					<!-- Back to Cart -->
					<a href="<?=SITE?>sepet" class="vs-btn style7 w-100 mt-3">
						<i class="far fa-arrow-left me-2"></i>Sepete Don
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

<style>
	/* Section Title */
	.section-title {
		font-size: 24px;
		font-weight: 700;
		color: #333;
		border-bottom: 3px solid #76a713;
		padding-bottom: 15px;
	}

	/* Payment Methods */
	.payment-methods {
		display: flex;
		flex-direction: column;
		gap: 20px;
	}
	.payment-method-card {
		position: relative;
	}
	.payment-method-card input[type="radio"] {
		position: absolute;
		opacity: 0;
		width: 0;
		height: 0;
	}
	.payment-label {
		display: flex;
		align-items: center;
		padding: 25px;
		background: #fff;
		border: 3px solid #e8e8e8;
		border-radius: 12px;
		cursor: pointer;
		transition: all 0.3s;
		position: relative;
	}
	.payment-label:hover {
		border-color: #76a713;
		box-shadow: 0 5px 20px rgba(118, 167, 19, 0.1);
		transform: translateY(-2px);
	}
	.payment-method-card input[type="radio"]:checked + .payment-label {
		border-color: #76a713;
		background: #f9fdf4;
		box-shadow: 0 5px 20px rgba(118, 167, 19, 0.15);
	}
	.payment-icon {
		width: 70px;
		height: 70px;
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		border-radius: 12px;
		display: flex;
		align-items: center;
		justify-content: center;
		margin-right: 20px;
		flex-shrink: 0;
		transition: all 0.3s;
	}
	.payment-method-card input[type="radio"]:checked + .payment-label .payment-icon {
		transform: scale(1.1);
	}
	.payment-icon i {
		font-size: 32px;
		color: #fff;
	}
	.payment-info {
		flex: 1;
	}
	.payment-title {
		font-size: 18px;
		font-weight: 700;
		color: #333;
		margin-bottom: 5px;
	}
	.payment-desc {
		font-size: 14px;
		color: #666;
		margin-bottom: 10px;
	}
	.payment-badges {
		display: flex;
		gap: 10px;
		align-items: center;
	}
	.payment-badges img {
		opacity: 0.7;
		transition: all 0.3s;
	}
	.payment-method-card input[type="radio"]:checked + .payment-label .payment-badges img {
		opacity: 1;
	}
	.payment-note {
		display: inline-flex;
		align-items: center;
		padding: 5px 12px;
		background: #e3f2fd;
		color: #1976d2;
		border-radius: 6px;
		font-size: 13px;
	}
	.payment-note.warning {
		background: #fff3cd;
		color: #856404;
	}
	.payment-check {
		width: 40px;
		height: 40px;
		border-radius: 50%;
		background: #e8e8e8;
		display: flex;
		align-items: center;
		justify-content: center;
		margin-left: 15px;
		transition: all 0.3s;
	}
	.payment-check i {
		font-size: 20px;
		color: #999;
	}
	.payment-method-card input[type="radio"]:checked + .payment-label .payment-check {
		background: #76a713;
	}
	.payment-method-card input[type="radio"]:checked + .payment-label .payment-check i {
		color: #fff;
	}

	/* Security Info */
	.security-info-box {
		background: #f8f9fa;
		padding: 20px;
		border-radius: 10px;
		border-left: 4px solid #4caf50;
	}
	.security-info-box h6 {
		font-weight: 700;
		color: #333;
	}

	/* Order Summary */
	.order-summary-sticky {
		position: sticky;
		top: 20px;
	}
	.order-summary-card {
		border: 2px solid #e8e8e8;
	}
	.summary-title {
		font-size: 20px;
		font-weight: 700;
		color: #333;
		border-bottom: 2px solid #76a713;
		padding-bottom: 15px;
	}
	.summary-list {
		margin-bottom: 0;
	}
	.summary-item {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 12px 0;
		border-bottom: 1px solid #f0f0f0;
	}
	.summary-item:last-child {
		border-bottom: none;
	}
	.item-label {
		font-size: 14px;
		color: #666;
	}
	.item-value {
		font-size: 14px;
		color: #333;
		font-weight: 600;
	}
	.summary-divider {
		height: 2px;
		background: linear-gradient(90deg, transparent, #76a713, transparent);
		margin: 15px 0;
	}
	.summary-item.total {
		padding: 20px 0;
	}
	.summary-item.total .item-label {
		font-size: 18px;
		font-weight: 700;
		color: #333;
	}
	.summary-item.total .item-value {
		font-size: 24px;
		font-weight: 700;
		color: #76a713;
	}
	.summary-info {
		padding-top: 20px;
		border-top: 2px solid #f0f0f0;
	}
	.info-item {
		display: flex;
		align-items: center;
		margin-bottom: 12px;
	}
	.info-item:last-child {
		margin-bottom: 0;
	}

	/* Responsive */
	@media (max-width: 991px) {
		.order-summary-sticky {
			position: static;
		}
	}
	@media (max-width: 768px) {
		.section-title {
			font-size: 20px;
		}
		.payment-label {
			flex-direction: column;
			text-align: center;
			padding: 20px;
		}
		.payment-icon {
			margin-right: 0;
			margin-bottom: 15px;
			width: 60px;
			height: 60px;
		}
		.payment-icon i {
			font-size: 28px;
		}
		.payment-check {
			position: absolute;
			top: 15px;
			right: 15px;
			margin-left: 0;
		}
		.payment-badges {
			justify-content: center;
		}
		.summary-item.total .item-label {
			font-size: 16px;
		}
		.summary-item.total .item-value {
			font-size: 20px;
		}
	}
</style>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Payment method selection animation
		const paymentRadios = document.querySelectorAll('input[name="odemetipi"]');
		paymentRadios.forEach(radio => {
			radio.addEventListener('change', function() {
				// Remove all active states
				document.querySelectorAll('.payment-label').forEach(label => {
					label.style.transform = 'scale(1)';
				});
				// Add animation to selected
				if(this.checked) {
					const label = this.nextElementSibling;
					label.style.transform = 'scale(1.02)';
					setTimeout(() => {
						label.style.transform = 'scale(1)';
					}, 200);
				}
			});
		});

		// Form validation
		const form = document.getElementById('paymentForm');
		if(form) {
			form.addEventListener('submit', function(e) {
				const selected = document.querySelector('input[name="odemetipi"]:checked');
				if(!selected) {
					e.preventDefault();
					alert('Lutfen bir odeme yontemi seciniz.');
					return false;
				}
			});
		}
	});
</script>

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
	<!--==============================
	Breadcumb
	============================== -->
	<div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/breadcumb/breadcumb-img-1.jpg">
		<div class="container">
			<div class="breadcumb-content text-center">
				<h1 class="breadcumb-title">Sepetim</h1>
				<ul class="breadcumb-menu-style1 mx-auto">
					<li><a href="<?=SITE?>">Anasayfa</a></li>
					<li class="active">Sepet</li>
				</ul>
			</div>
		</div>
	</div>

	<section class="space-top space-md-bottom">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-6 text-center">
					<div class="empty-cart-wrapper py-5">
						<i class="far fa-shopping-cart" style="font-size: 80px; color: #ddd; margin-bottom: 20px;"></i>
						<h3 class="mb-3">Sepetiniz Bos</h3>
						<p class="mb-4 text-muted">Sepetinizde henuz urun bulunmuyor.</p>
						<a href="<?=SITE?>" class="vs-btn style4">
							<i class="far fa-shopping-bag me-2"></i>Alisverise Basla
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
}
?>
