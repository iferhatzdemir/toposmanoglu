<?php
if(!empty($_SESSION["sepet"]))
{
	// Handle cart update
	if($_POST)
	{
		if(!empty($_POST["adet"]))
		{
			$toplamNesneAdeti=count($_POST["adet"]);
			$adetsayaci=0;
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
									$adetpost=$VT->filter($_POST["adet"][$adetsayaci]);
									if($stokTablo[0]["stok"]>=$adetpost)
									{
										$_SESSION["sepetVaryasyon"][$urunbilgisi[0]["ID"]][$stokTablo[0]["ID"]]["adet"]=$adetpost;
									}
								}
								$adetsayaci++;
							}
						}
					}
					else
					{
						$adetpost=$VT->filter($_POST["adet"][$adetsayaci]);
						if($urunbilgisi[0]["stok"]>=$adetpost)
						{
							$_SESSION["sepet"][$urunbilgisi[0]["ID"]]["adet"]=$adetpost;
						}
						$adetsayaci++;
					}
				}
			}
			$updateSuccess = true;
		}
	}
?>

<!--==============================
Breadcumb
============================== -->
<div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/breadcumb/breadcumb-img-1.jpg">
	<div class="container">
		<div class="breadcumb-content text-center">
			<h1 class="breadcumb-title">Alışveriş Sepetim</h1>
			<ul class="breadcumb-menu-style1 mx-auto">
				<li><a href="<?=SITE?>">Anasayfa</a></li>
				<li class="active">Sepet</li>
			</ul>
		</div>
	</div>
</div>

<!--==============================
	Shopping Cart
==============================-->
<section class="space-top space-md-bottom">
	<div class="container">
		<?php if(!empty($updateSuccess)) { ?>
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			<i class="far fa-check-circle me-2"></i>Sepetiniz başarıyla güncellendi.
			<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
		</div>
		<?php } ?>

		<div class="row">
			<!-- Cart Items -->
			<div class="col-lg-8 mb-4">
				<div class="cart-items-wrapper">
					<div class="cart-header d-flex justify-content-between align-items-center mb-4">
						<h4 class="mb-0">
							<i class="far fa-shopping-cart me-2"></i>Sepet Ürünleri
						</h4>
						<a href="<?=SITE?>sepet-sil/clear" class="btn-clear-cart" onclick="return confirm('Sepeti temizlemek istediğinize emin misiniz?')">
							<i class="far fa-trash-alt me-1"></i>Sepeti Temizle
						</a>
					</div>

					<form action="#" method="post" id="cartForm">
						<?php
						$sepetkdvharictutar=0;
						$sepetkdvtutar18=0;
						$sepetkdvtutar8=0;
						$sepetkdvtutar6=0;
						$sepetkdvtutar1=0;
						$sepetTutar=0;

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

												if(strpos($varyasyonID,"@")!=false)
												{
													$varyasyondizi=explode("@", $varyasyonID);
													$secenekdizi=explode("@", $secimID);
													for($i=0;$i<count($varyasyondizi);$i++)
													{
														$varyasyonBilgisi=$VT->VeriGetir("urunvaryasyonlari","WHERE ID=?",array($varyasyondizi[$i]),"ORDER BY ID ASC",1);
														$secenekBilgisi=$VT->VeriGetir("urunvaryasyonsecenekleri","WHERE ID=?",array($secenekdizi[$i]),  "ORDER BY ID ASC",1);
														if($varyasyonBilgisi!=false && $secenekBilgisi!=false)
														{
															$varyasyonOzellikleri.=stripslashes($secenekBilgisi[0]["baslik"])." ".$varyasyonBilgisi[0]["baslik"]." ";
														}
													}
												}
												else
												{
													$varyasyonBilgisi=$VT->VeriGetir("urunvaryasyonlari","WHERE ID=?",array($varyasyonID),"ORDER BY ID ASC",1);
													$secenekBilgisi=$VT->VeriGetir("urunvaryasyonsecenekleri","WHERE ID=?",array($secimID),"ORDER BY ID ASC",1);
													if($varyasyonBilgisi!=false && $secenekBilgisi!=false)
													{
														$varyasyonOzellikleri=stripslashes($secenekBilgisi[0]["baslik"])." ".$varyasyonBilgisi[0]["baslik"];
													}
												}

												// Price calculation
												if(!empty($urunbilgisi[0]["indirimlifiyat"]))
												{
													$fiyat=$urunbilgisi[0]["indirimlifiyat"].".".$urunbilgisi[0]["indirimlikurus"];
												}
												else
												{
													$fiyat=$urunbilgisi[0]["fiyat"].".".$urunbilgisi[0]["kurus"];
												}

												if($urunbilgisi[0]["kdvdurum"]==1)
												{
													$oran=$urunbilgisi[0]["kdvoran"]>9 ? "1.".$urunbilgisi[0]["kdvoran"] : "1.0".$urunbilgisi[0]["kdvoran"];
													$kdvsizBirimfiyat=($fiyat/$oran);
												}
												else
												{
													$kdvsizBirimfiyat=$fiyat;
												}

												$toplamtutar=($fiyat*$secenekAdet["adet"]);
												$kdvsizToplamTutar=($kdvsizBirimfiyat*$secenekAdet["adet"]);

												// KDV calculations
												if($urunbilgisi[0]["kdvdurum"]==1)
												{
													$oran=$urunbilgisi[0]["kdvoran"]>9 ? "1.".$urunbilgisi[0]["kdvoran"] : "1.0".$urunbilgisi[0]["kdvoran"];
													$kdvlifiyat=$toplamtutar;
													$kdvsizfiyat=($toplamtutar/$oran);
													$kdvtutari=($toplamtutar-$kdvsizfiyat);
													if($urunbilgisi[0]["kdvoran"]==18){$sepetkdvtutar18+=$kdvtutari;}
													if($urunbilgisi[0]["kdvoran"]==8){$sepetkdvtutar8+=$kdvtutari;}
													if($urunbilgisi[0]["kdvoran"]==6){$sepetkdvtutar6+=$kdvtutari;}
													if($urunbilgisi[0]["kdvoran"]==1){$sepetkdvtutar1+=$kdvtutari;}
													$sepetkdvharictutar+=$kdvsizfiyat;
													$sepetTutar+=$kdvlifiyat;
												}
												else
												{
													$oran=$urunbilgisi[0]["kdvoran"];
													$kdvsizfiyat=$toplamtutar;
													$kdvtutari=(($kdvsizfiyat*$oran)/100);
													$kdvlifiyat=($kdvsizfiyat+$kdvtutari);
													if($urunbilgisi[0]["kdvoran"]==18){$sepetkdvtutar18+=$kdvtutari;}
													if($urunbilgisi[0]["kdvoran"]==8){$sepetkdvtutar8+=$kdvtutari;}
													if($urunbilgisi[0]["kdvoran"]==6){$sepetkdvtutar6+=$kdvtutari;}
													if($urunbilgisi[0]["kdvoran"]==1){$sepetkdvtutar1+=$kdvtutari;}
													$sepetkdvharictutar+=$kdvsizfiyat;
													$sepetTutar+=$kdvlifiyat;
												}

												$urunResim = !empty($urunbilgisi[0]["resim"]) ? $urunbilgisi[0]["resim"] : "varsayilan.png";
												?>
												<!-- Cart Item Card -->
												<div class="cart-item-card mb-3">
													<div class="row align-items-center">
														<div class="col-md-2 col-3">
															<div class="cart-item-image">
																<img src="<?=SITE?>images/urunler/<?=$urunResim?>" alt="<?=stripslashes($urunbilgisi[0]["baslik"])?>" class="img-fluid">
															</div>
														</div>
														<div class="col-md-4 col-9">
															<div class="cart-item-info">
																<h6 class="cart-item-title">
																	<a href="<?=SITE?>urun/<?=$urunbilgisi[0]["seflink"]?>"><?=stripslashes($urunbilgisi[0]["baslik"])?></a>
																</h6>
																<?php if(!empty($varyasyonOzellikleri)) { ?>
																<p class="cart-item-variant">
																	<i class="far fa-tag me-1"></i><?=$varyasyonOzellikleri?>
																</p>
																<?php } ?>
																<p class="cart-item-price-mobile d-md-none">
																	<?=number_format($kdvsizBirimfiyat,2,",",".")?> TL
																</p>
															</div>
														</div>
														<div class="col-md-2 col-4 d-none d-md-block">
															<div class="cart-item-price">
																<?=number_format($kdvsizBirimfiyat,2,",",".")?> TL
															</div>
														</div>
														<div class="col-md-2 col-4">
															<div class="cart-item-quantity">
																<div class="quantity-controls">
																	<button type="button" class="qty-btn qty-minus">
																		<i class="far fa-minus"></i>
																	</button>
																	<input type="number" name="adet[]" value="<?=$secenekAdet["adet"]?>" min="1" max="<?=$stokTablo[0]["stok"]?>" class="qty-input">
																	<button type="button" class="qty-btn qty-plus">
																		<i class="far fa-plus"></i>
																	</button>
																</div>
															</div>
														</div>
														<div class="col-md-1 col-3">
															<div class="cart-item-total">
																<?=number_format($kdvsizToplamTutar,2,",",".")?> TL
															</div>
														</div>
														<div class="col-md-1 col-1">
															<a href="<?=SITE?>sepet-sil/<?=$urunbilgisi[0]["ID"]?>/<?=$secenekID?>" class="cart-item-remove" onclick="return confirm('Bu ürünü sepetten kaldırmak istediğinize emin misiniz?')">
																<i class="far fa-times"></i>
															</a>
														</div>
													</div>
												</div>
												<?php
											}
										}
									}
								}
								else
								{
									// Non-variation product (same structure as above)
									if(!empty($urunbilgisi[0]["indirimlifiyat"]))
									{
										$fiyat=$urunbilgisi[0]["indirimlifiyat"].".".$urunbilgisi[0]["indirimlikurus"];
									}
									else
									{
										$fiyat=$urunbilgisi[0]["fiyat"].".".$urunbilgisi[0]["kurus"];
									}

									if($urunbilgisi[0]["kdvdurum"]==1)
									{
										$oran=$urunbilgisi[0]["kdvoran"]>9 ? "1.".$urunbilgisi[0]["kdvoran"] : "1.0".$urunbilgisi[0]["kdvoran"];
										$kdvsizBirimfiyat=($fiyat/$oran);
									}
									else
									{
										$kdvsizBirimfiyat=$fiyat;
									}

									$toplamtutar=($fiyat*$bilgi["adet"]);
									$kdvsizToplamTutar=($kdvsizBirimfiyat*$bilgi["adet"]);

									if($urunbilgisi[0]["kdvdurum"]==1)
									{
										$oran=$urunbilgisi[0]["kdvoran"]>9 ? "1.".$urunbilgisi[0]["kdvoran"] : "1.0".$urunbilgisi[0]["kdvoran"];
										$kdvlifiyat=$toplamtutar;
										$kdvsizfiyat=($toplamtutar/$oran);
										$kdvtutari=($toplamtutar-$kdvsizfiyat);
										if($urunbilgisi[0]["kdvoran"]==18){$sepetkdvtutar18+=$kdvtutari;}
										if($urunbilgisi[0]["kdvoran"]==8){$sepetkdvtutar8+=$kdvtutari;}
										if($urunbilgisi[0]["kdvoran"]==6){$sepetkdvtutar6+=$kdvtutari;}
										if($urunbilgisi[0]["kdvoran"]==1){$sepetkdvtutar1+=$kdvtutari;}
										$sepetkdvharictutar+=$kdvsizfiyat;
										$sepetTutar+=$kdvlifiyat;
									}
									else
									{
										$oran=$urunbilgisi[0]["kdvoran"];
										$kdvsizfiyat=$toplamtutar;
										$kdvtutari=(($kdvsizfiyat*$oran)/100);
										$kdvlifiyat=($kdvsizfiyat+$kdvtutari);
										if($urunbilgisi[0]["kdvoran"]==18){$sepetkdvtutar18+=$kdvtutari;}
										if($urunbilgisi[0]["kdvoran"]==8){$sepetkdvtutar8+=$kdvtutari;}
										if($urunbilgisi[0]["kdvoran"]==6){$sepetkdvtutar6+=$kdvtutari;}
										if($urunbilgisi[0]["kdvoran"]==1){$sepetkdvtutar1+=$kdvtutari;}
										$sepetkdvharictutar+=$kdvsizfiyat;
										$sepetTutar+=$kdvlifiyat;
									}

									$urunResim = !empty($urunbilgisi[0]["resim"]) ? $urunbilgisi[0]["resim"] : "varsayilan.png";
									?>
									<!-- Cart Item Card (Non-variation) -->
									<div class="cart-item-card mb-3">
										<div class="row align-items-center">
											<div class="col-md-2 col-3">
												<div class="cart-item-image">
													<img src="<?=SITE?>images/urunler/<?=$urunResim?>" alt="<?=stripslashes($urunbilgisi[0]["baslik"])?>" class="img-fluid">
												</div>
											</div>
											<div class="col-md-4 col-9">
												<div class="cart-item-info">
													<h6 class="cart-item-title">
														<a href="<?=SITE?>urun/<?=$urunbilgisi[0]["seflink"]?>"><?=stripslashes($urunbilgisi[0]["baslik"])?></a>
													</h6>
													<p class="cart-item-price-mobile d-md-none">
														<?=number_format($kdvsizBirimfiyat,2,",",".")?> TL
													</p>
												</div>
											</div>
											<div class="col-md-2 col-4 d-none d-md-block">
												<div class="cart-item-price">
													<?=number_format($kdvsizBirimfiyat,2,",",".")?> TL
												</div>
											</div>
											<div class="col-md-2 col-4">
												<div class="cart-item-quantity">
													<div class="quantity-controls">
														<button type="button" class="qty-btn qty-minus">
															<i class="far fa-minus"></i>
														</button>
														<input type="number" name="adet[]" value="<?=$bilgi["adet"]?>" min="1" max="<?=$urunbilgisi[0]["stok"]?>" class="qty-input">
														<button type="button" class="qty-btn qty-plus">
															<i class="far fa-plus"></i>
														</button>
													</div>
												</div>
											</div>
											<div class="col-md-1 col-3">
												<div class="cart-item-total">
													<?=number_format($kdvsizToplamTutar,2,",",".")?> TL
												</div>
											</div>
											<div class="col-md-1 col-1">
												<a href="<?=SITE?>sepet-sil/<?=$urunbilgisi[0]["ID"]?>" class="cart-item-remove" onclick="return confirm('Bu ürünü sepetten kaldırmak istediğinize emin misiniz?')">
													<i class="far fa-times"></i>
												</a>
											</div>
										</div>
									</div>
									<?php
								}
							}
						}
						?>

						<div class="cart-actions mt-4">
							<button type="submit" class="vs-btn style4">
								<i class="far fa-sync me-2"></i>Sepeti Güncelle
							</button>
							<a href="<?=SITE?>" class="vs-btn style7">
								<i class="far fa-shopping-bag me-2"></i>Alışverişe Devam
							</a>
						</div>
					</form>
				</div>
			</div>

			<!-- Cart Summary -->
			<div class="col-lg-4">
				<div class="cart-summary-sticky">
					<div class="cart-summary-card bg-white shadow-sm rounded p-4">
						<h4 class="summary-title mb-4">
							<i class="far fa-calculator me-2"></i>Sipariş Özeti
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
								<span class="item-label">Ödenecek Tutar:</span>
								<span class="item-value"><?=number_format($sepetTutar,2,",",".")?> TL</span>
							</div>
						</div>

						<?php
						if(!empty($_SESSION["uyeID"]))
						{
							$uyeID=$VT->filter($_SESSION["uyeID"]);
							$uyebilgisi=$VT->VeriGetir("uyeler","WHERE ID=? AND durum=?",array($uyeID,1),"ORDER BY ID ASC",1);
							if($uyebilgisi!=false)
							{
								?>
								<a href="<?=SITE?>odeme-tipi" class="vs-btn style4 w-100 mt-4">
									<i class="far fa-lock me-2"></i>Güvenli Ödemeye Geç
								</a>
								<?php
							}
							else
							{
								?>
								<a href="<?=SITE?>uyelik" class="vs-btn style4 w-100 mt-4">
									<i class="far fa-user me-2"></i>Giriş Yap / Üye Ol
								</a>
								<?php
							}
						}
						else
						{
							?>
							<a href="<?=SITE?>uyelik" class="vs-btn style4 w-100 mt-4">
								<i class="far fa-user me-2"></i>Giriş Yap / Üye Ol
							</a>
							<?php
						}
						?>

						<div class="summary-features mt-4">
							<div class="feature-item">
								<i class="far fa-truck text-success me-2"></i>
								<span class="small">Ücretsiz Kargo (500 TL üzeri)</span>
							</div>
							<div class="feature-item">
								<i class="far fa-undo text-success me-2"></i>
								<span class="small">14 Gün İçerisinde İade</span>
							</div>
							<div class="feature-item">
								<i class="far fa-shield-check text-success me-2"></i>
								<span class="small">Güvenli Alışveriş Garantisi</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<style>
	/* Modern Cart Styling - Enhanced Version */

	/* Cart Header */
	.cart-header {
		background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
		padding: 25px;
		border-radius: 15px;
		margin-bottom: 25px;
		box-shadow: 0 2px 10px rgba(0,0,0,0.05);
	}
	.cart-header h4 {
		font-size: 24px;
		font-weight: 700;
		color: #2c3e50;
		margin: 0;
	}
	.btn-clear-cart {
		color: #dc3545;
		text-decoration: none;
		font-size: 14px;
		font-weight: 600;
		transition: all 0.3s ease;
		padding: 8px 16px;
		border-radius: 8px;
		background: rgba(220, 53, 69, 0.1);
	}
	.btn-clear-cart:hover {
		background: #dc3545;
		color: #fff;
		transform: translateY(-2px);
		box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
	}

	/* Cart Item Card - Premium Design */
	.cart-item-card {
		background: #fff;
		padding: 25px;
		border-radius: 15px;
		border: 2px solid transparent;
		background-image: linear-gradient(white, white),
		                  linear-gradient(135deg, #e8e8e8, #f0f0f0);
		background-origin: border-box;
		background-clip: padding-box, border-box;
		transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
		position: relative;
		overflow: hidden;
	}
	.cart-item-card::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		width: 4px;
		height: 100%;
		background: linear-gradient(180deg, #76a713 0%, #5a8010 100%);
		opacity: 0;
		transition: opacity 0.3s ease;
	}
	.cart-item-card:hover {
		border-color: #76a713;
		box-shadow: 0 10px 30px rgba(118, 167, 19, 0.15);
		transform: translateY(-3px);
	}
	.cart-item-card:hover::before {
		opacity: 1;
	}

	.cart-item-image {
		border-radius: 12px;
		overflow: hidden;
		border: 2px solid #f5f5f5;
		position: relative;
		transition: all 0.3s ease;
		box-shadow: 0 2px 8px rgba(0,0,0,0.08);
	}
	.cart-item-image:hover {
		transform: scale(1.05);
		box-shadow: 0 4px 15px rgba(0,0,0,0.12);
	}
	.cart-item-image img {
		width: 100%;
		height: auto;
		transition: transform 0.3s ease;
	}
	.cart-item-card:hover .cart-item-image img {
		transform: scale(1.1);
	}

	.cart-item-title {
		font-size: 17px;
		font-weight: 600;
		margin-bottom: 10px;
		line-height: 1.4;
	}
	.cart-item-title a {
		color: #2c3e50;
		text-decoration: none;
		transition: color 0.3s ease;
	}
	.cart-item-title a:hover {
		color: #76a713;
	}

	.cart-item-variant {
		font-size: 13px;
		color: #fff;
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		padding: 4px 12px;
		border-radius: 6px;
		display: inline-block;
		margin: 5px 0;
		font-weight: 500;
	}

	.cart-item-price,
	.cart-item-total {
		font-size: 18px;
		font-weight: 700;
		color: #2c3e50;
		background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
		padding: 8px 12px;
		border-radius: 8px;
		display: inline-block;
	}
	.cart-item-total {
		color: #76a713;
		font-size: 20px;
	}

	/* Quantity Controls - Modern Design */
	.quantity-controls {
		display: flex;
		align-items: center;
		border: 2px solid #e8e8e8;
		border-radius: 10px;
		overflow: hidden;
		background: #fff;
		box-shadow: 0 2px 8px rgba(0,0,0,0.05);
		transition: all 0.3s ease;
	}
	.quantity-controls:hover {
		border-color: #76a713;
		box-shadow: 0 4px 12px rgba(118, 167, 19, 0.15);
	}
	.qty-btn {
		width: 38px;
		height: 42px;
		background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
		border: none;
		color: #333;
		cursor: pointer;
		transition: all 0.3s ease;
		font-size: 14px;
		font-weight: 600;
		position: relative;
	}
	.qty-btn:hover {
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		color: #fff;
		transform: scale(1.1);
	}
	.qty-btn:active {
		transform: scale(0.95);
	}
	.qty-input {
		width: 55px;
		height: 42px;
		border: none;
		text-align: center;
		font-weight: 700;
		font-size: 16px;
		color: #2c3e50;
		background: transparent;
	}
	.qty-input:focus {
		outline: none;
		background: #f8f9fa;
	}
	.qty-input::-webkit-outer-spin-button,
	.qty-input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}

	/* Remove Button - Enhanced */
	.cart-item-remove {
		width: 38px;
		height: 38px;
		display: flex;
		align-items: center;
		justify-content: center;
		background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
		border-radius: 50%;
		color: #dc3545;
		text-decoration: none;
		transition: all 0.3s ease;
		font-size: 16px;
		box-shadow: 0 2px 8px rgba(220, 53, 69, 0.15);
	}
	.cart-item-remove:hover {
		background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
		color: #fff;
		transform: rotate(90deg) scale(1.1);
		box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
	}

	/* Cart Actions - Enhanced */
	.cart-actions {
		display: flex;
		gap: 15px;
		padding: 20px;
		background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
		border-radius: 12px;
		box-shadow: 0 2px 10px rgba(0,0,0,0.05);
	}
	.cart-actions .vs-btn {
		flex: 1;
		transition: all 0.3s ease;
	}
	.cart-actions .vs-btn:hover {
		transform: translateY(-2px);
		box-shadow: 0 5px 15px rgba(118, 167, 19, 0.25);
	}

	/* Cart Summary - Premium Design */
	.cart-summary-sticky {
		position: sticky;
		top: 20px;
	}
	.cart-summary-card {
		border: 2px solid #e8e8e8;
		border-radius: 15px;
		overflow: hidden;
		box-shadow: 0 5px 20px rgba(0,0,0,0.08);
		transition: all 0.3s ease;
	}
	.cart-summary-card:hover {
		box-shadow: 0 8px 30px rgba(0,0,0,0.12);
		transform: translateY(-2px);
	}

	.summary-title {
		font-size: 22px;
		font-weight: 700;
		color: #fff;
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		padding: 20px;
		margin: -1rem -1rem 1rem -1rem;
		border-bottom: none;
	}

	.summary-item {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 14px 0;
		border-bottom: 1px solid #f0f0f0;
		transition: all 0.2s ease;
	}
	.summary-item:hover {
		background: #f8f9fa;
		padding-left: 10px;
		padding-right: 10px;
		margin-left: -10px;
		margin-right: -10px;
		border-radius: 8px;
	}

	.item-label {
		font-size: 15px;
		color: #666;
		font-weight: 500;
	}
	.item-value {
		font-size: 15px;
		color: #2c3e50;
		font-weight: 700;
	}

	.summary-divider {
		height: 3px;
		background: linear-gradient(90deg, transparent, #76a713, transparent);
		margin: 20px 0;
		border-radius: 2px;
	}

	.summary-item.total {
		padding: 25px 0;
		background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
		margin: 15px -1rem;
		padding-left: 1rem;
		padding-right: 1rem;
		border-radius: 10px;
		border: none;
	}
	.summary-item.total:hover {
		background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
	}
	.summary-item.total .item-label {
		font-size: 19px;
		font-weight: 700;
		color: #2c3e50;
	}
	.summary-item.total .item-value {
		font-size: 26px;
		font-weight: 800;
		color: #76a713;
		text-shadow: 0 2px 4px rgba(118, 167, 19, 0.2);
	}

	.summary-features {
		padding-top: 20px;
		border-top: 2px dashed #e0e0e0;
		margin-top: 20px;
	}
	.feature-item {
		display: flex;
		align-items: center;
		margin-bottom: 14px;
		padding: 10px;
		background: #f8f9fa;
		border-radius: 8px;
		transition: all 0.3s ease;
	}
	.feature-item:hover {
		background: #e9ecef;
		transform: translateX(5px);
	}
	.feature-item i {
		font-size: 18px;
		margin-right: 10px;
	}
	.feature-item .small {
		font-size: 13px;
		font-weight: 500;
		color: #495057;
	}

	/* Alert Enhancement */
	.alert-success {
		background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
		border: 2px solid #28a745;
		border-radius: 12px;
		box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
	}

	/* Empty Cart Enhancement */
	.empty-cart-wrapper {
		background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
		border-radius: 20px;
		padding: 60px 40px !important;
		box-shadow: 0 10px 40px rgba(0,0,0,0.08);
	}
	.empty-cart-icon {
		animation: bounce 2s infinite;
	}
	@keyframes bounce {
		0%, 100% { transform: translateY(0); }
		50% { transform: translateY(-20px); }
	}
	.empty-cart-icon i {
		font-size: 120px;
		color: #dee2e6;
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		-webkit-background-clip: text;
		-webkit-text-fill-color: transparent;
		background-clip: text;
	}
	.empty-cart-wrapper h3 {
		font-size: 32px;
		font-weight: 700;
		color: #2c3e50;
	}

	/* Responsive Enhancements */
	@media (max-width: 991px) {
		.cart-summary-sticky {
			position: static;
			margin-top: 30px;
		}
	}
	@media (max-width: 768px) {
		.cart-actions {
			flex-direction: column;
		}
		.cart-item-card {
			padding: 18px;
		}
		.qty-btn {
			width: 32px;
			height: 38px;
		}
		.qty-input {
			width: 48px;
			height: 38px;
		}
		.cart-header {
			padding: 20px;
		}
		.cart-header h4 {
			font-size: 20px;
		}
		.summary-title {
			font-size: 20px;
			padding: 18px;
		}
	}

	/* Smooth Animations */
	@keyframes slideIn {
		from {
			opacity: 0;
			transform: translateY(20px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}
	.cart-item-card {
		animation: slideIn 0.4s ease-out;
	}
	.cart-item-card:nth-child(2) { animation-delay: 0.1s; }
	.cart-item-card:nth-child(3) { animation-delay: 0.2s; }
	.cart-item-card:nth-child(4) { animation-delay: 0.3s; }
</style>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Quantity controls
		const minusBtns = document.querySelectorAll('.qty-minus');
		const plusBtns = document.querySelectorAll('.qty-plus');

		minusBtns.forEach(btn => {
			btn.addEventListener('click', function() {
				const input = this.parentElement.querySelector('.qty-input');
				let value = parseInt(input.value);
				if(value > 1) {
					input.value = value - 1;
				}
			});
		});

		plusBtns.forEach(btn => {
			btn.addEventListener('click', function() {
				const input = this.parentElement.querySelector('.qty-input');
				let value = parseInt(input.value);
				let max = parseInt(input.getAttribute('max'));
				if(value < max) {
					input.value = value + 1;
				}
			});
		});
	});
</script>

<?php
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
			<h1 class="breadcumb-title">Alışveriş Sepetim</h1>
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
					<div class="empty-cart-icon mb-4">
						<i class="far fa-shopping-cart"></i>
					</div>
					<h3 class="mb-3">Sepetiniz Boş</h3>
					<p class="mb-4 text-muted">Sepetinizde henüz ürün bulunmuyor.</p>
					<a href="<?=SITE?>" class="vs-btn style4">
						<i class="far fa-shopping-bag me-2"></i>Alışverişe Başla
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

<style>
	.empty-cart-icon i {
		font-size: 100px;
		color: #ddd;
	}
	.empty-cart-wrapper h3 {
		font-size: 28px;
		font-weight: 700;
		color: #333;
	}
</style>

<?php
}
?>
