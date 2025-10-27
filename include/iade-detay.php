<?php
if(!empty($_SESSION["uyeID"]) && !empty($_GET["iadekodu"]))
{
	$uyeID=$VT->filter($_SESSION["uyeID"]);
	$iadekodu=$VT->filter($_GET["iadekodu"]);
	$uyebilgisi=$VT->VeriGetir("uyeler","WHERE ID=? AND durum=?",array($uyeID,1),"ORDER BY ID ASC",1);
	if($uyebilgisi!=false)
	{
		$iadeler=$VT->VeriGetir("iadeler","WHERE iadekodu=? AND uyeID=?",array($iadekodu,$uyebilgisi[0]["ID"]),"ORDER BY ID ASC",1);
		if($iadeler!=false)
		{
			?>
			<!--==============================
			Breadcumb
			============================== -->
			<div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/breadcumb/breadcumb-img-1.jpg">
				<div class="container">
					<div class="breadcumb-content text-center">
						<h1 class="breadcumb-title">Iade Detay</h1>
						<ul class="breadcumb-menu-style1 mx-auto">
							<li><a href="<?=SITE?>">Anasayfa</a></li>
							<li><a href="<?=SITE?>iadeler">Iadeler</a></li>
							<li class="active">Iade Detay</li>
						</ul>
					</div>
				</div>
			</div>

			<!--==============================
				Account Menu Area
			==============================-->
			<section class="space-top space-md-bottom">
				<div class="container">
					<!-- Account Menu Boxes -->
					<div class="row mb-40">
						<div class="col-lg-2 col-md-4 col-6 mb-3">
							<a href="<?=SITE?>siparislerim" class="account-menu-box text-center">
								<i class="far fa-shopping-bag"></i>
								<h5>Siparislerim</h5>
							</a>
						</div>
						<div class="col-lg-2 col-md-4 col-6 mb-3">
							<a href="<?=SITE?>hesabim" class="account-menu-box text-center">
								<i class="far fa-user"></i>
								<h5>Hesabim</h5>
							</a>
						</div>
						<div class="col-lg-2 col-md-4 col-6 mb-3">
							<a href="<?=SITE?>iadeler" class="account-menu-box text-center active">
								<i class="far fa-undo"></i>
								<h5>Iade Takibi</h5>
							</a>
						</div>
						<div class="col-lg-2 col-md-4 col-6 mb-3">
							<a href="<?=SITE?>siparis-takip" class="account-menu-box text-center">
								<i class="far fa-truck"></i>
								<h5>Siparis Takibi</h5>
							</a>
						</div>
						<div class="col-lg-2 col-md-4 col-6 mb-3">
							<a href="<?=SITE?>sepet" class="account-menu-box text-center">
								<i class="far fa-shopping-cart"></i>
								<h5>Sepetim</h5>
							</a>
						</div>
						<div class="col-lg-2 col-md-4 col-6 mb-3">
							<a href="<?=SITE?>cikis-yap" class="account-menu-box text-center">
								<i class="far fa-sign-out"></i>
								<h5>Cikis</h5>
							</a>
						</div>
					</div>

					<!--==============================
						Return Summary
					==============================-->
					<div class="row">
						<div class="col-12 mb-4">
							<div class="bg-white p-4 p-md-5 shadow-sm rounded">
								<div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
									<h3 class="sec-subtitle mb-0">
										<i class="far fa-clipboard-list me-2"></i>Iade Ozeti
									</h3>
									<div class="return-status">
										<?php
										if($iadeler[0]["durum"]==1)
										{
											?>
											<span class="badge badge-warning">
												<i class="far fa-clock me-1"></i>BEKLIYOR
											</span>
											<?php
										}
										else
										{
											?>
											<span class="badge badge-success">
												<i class="far fa-check-circle me-1"></i>CEVAPLANDI
											</span>
											<?php
										}
										?>
									</div>
								</div>

								<!-- Return Information Grid -->
								<div class="row mb-4">
									<div class="col-md-3 col-6 mb-3">
										<div class="info-card">
											<div class="info-label">
												<i class="far fa-barcode me-2"></i>Iade Kodu
											</div>
											<div class="info-value"><?=$iadeler[0]["iadekodu"]?></div>
										</div>
									</div>
									<div class="col-md-3 col-6 mb-3">
										<div class="info-card">
											<div class="info-label">
												<i class="far fa-calendar me-2"></i>Tarih
											</div>
											<div class="info-value"><?=date("d.m.Y",strtotime($iadeler[0]["tarih"]))?></div>
										</div>
									</div>
									<div class="col-md-3 col-6 mb-3">
										<div class="info-card">
											<div class="info-label">
												<i class="far fa-user me-2"></i>Alici
											</div>
											<div class="info-value">
												<?php
												if($uyebilgisi[0]["tipi"]==1)
												{
													echo stripslashes($uyebilgisi[0]["ad"]." ".$uyebilgisi[0]["soyad"]);
												}
												else
												{
													echo stripslashes($uyebilgisi[0]["firmaadi"]);
												}
												?>
											</div>
										</div>
									</div>
									<div class="col-md-3 col-6 mb-3">
										<div class="info-card">
											<div class="info-label">
												<i class="far fa-map-marker-alt me-2"></i>Adres
											</div>
											<div class="info-value">
												<?php
												$ilBilgi=$VT->VeriGetir("il","WHERE ID=?",array($uyebilgisi[0]["ilID"]),"ORDER BY ID ASC",1);
												echo stripslashes($uyebilgisi[0]["ilce"]);
												if($ilBilgi!=false)
												{
													echo "/".mb_convert_case($ilBilgi[0]["ADI"],MB_CASE_UPPER,"UTF-8");
												}
												?>
											</div>
										</div>
									</div>
								</div>

								<!-- Return Reason -->
								<div class="alert alert-light border mb-4">
									<h6 class="fw-bold mb-2">
										<i class="far fa-comment-alt-lines me-2"></i>Iade Sebebi:
									</h6>
									<p class="mb-0"><?=stripslashes($iadeler[0]["metin"])?></p>
								</div>

								<!-- Return Answer -->
								<?php if(!empty($iadeler[0]["cevap"])) { ?>
								<div class="alert alert-info border-0">
									<h6 class="fw-bold mb-2">
										<i class="far fa-reply me-2"></i>Iade Cevabi:
									</h6>
									<p class="mb-0"><?=stripslashes($iadeler[0]["cevap"])?></p>
								</div>
								<?php } else { ?>
								<div class="alert alert-warning border-0">
									<i class="far fa-hourglass-half me-2"></i>
									Iade talebiniz inceleniyor. En kisa surede size donecegiz.
								</div>
								<?php } ?>
							</div>
						</div>
					</div>

					<!--==============================
						Returned Products
					==============================-->
					<div class="row">
						<div class="col-12">
							<div class="bg-white p-4 p-md-5 shadow-sm rounded">
								<h3 class="sec-subtitle mb-4 pb-3 border-bottom">
									<i class="far fa-box-open me-2"></i>Iade Edilen Urunler
								</h3>

								<div class="table-responsive">
									<table class="table table-hover align-middle">
										<thead class="table-light">
											<tr>
												<th>URUN KODU</th>
												<th>RESIM</th>
												<th>ACIKLAMA</th>
												<th>URUN FIYATI</th>
												<th>ADET</th>
												<th>TOPLAM TUTAR</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$iadeurunler=$VT->VeriGetir("iadeurunler","WHERE uyeID=? AND iadeID=?",array($uyebilgisi[0]["ID"],$iadeler[0]["ID"]));
											if($iadeurunler!=false)
											{
												$toplamTutar = 0;
												for($q=0;$q<count($iadeurunler);$q++)
												{
													$siparisurunler=$VT->VeriGetir("siparisurunler","WHERE ID=?",array($iadeurunler[$q]["siparisurunID"]),"ORDER BY ID ASC",1);
													if($siparisurunler!=false)
													{
														for ($i=0; $i <count($siparisurunler); $i++) {
															$urunler=$VT->VeriGetir("urunler","WHERE ID=?",array($siparisurunler[$i]["urunID"]),"ORDER BY ID ASC",1);
															if($urunler!=false)
															{
																$ozellikler="";
																if(!empty($siparisurunler[$i]["varyasyonID"]))
																{
																	$varyasyonKontrol=$VT->VeriGetir("urunvaryasyonstoklari","WHERE ID=?",array($siparisurunler[$i]["varyasyonID"]),"ORDER BY ID ASC",1);
																	if($varyasyonKontrol!=false)
																	{
																		$varyasyonID=$varyasyonKontrol[0]["varyasyonID"];
																		$secenekID=$varyasyonKontrol[0]["secenekID"];

																		if(strpos($varyasyonID,"@")>0)
																		{
																			$varyasyonDizi=explode("@",$varyasyonID);
																			$secenekDizi=explode("@",$secenekID);
																			for($x=0;$x<count($varyasyonDizi);$x++)
																			{
																				$varyasyonBilgisi=$VT->VeriGetir("urunvaryasyonlari","WHERE ID=?",array($varyasyonDizi[$x]),"ORDER BY ID ASC",1);
																				$secenekBilgisi=$VT->VeriGetir("urunvaryasyonsecenekleri","WHERE ID=?",array($secenekDizi[$x]),"ORDER BY ID ASC",1);

																				if($varyasyonBilgisi!=false && $secenekBilgisi!=false)
																				{
																					$ozellikler=$ozellikler.stripslashes($secenekBilgisi[0]["baslik"])." ".stripslashes($varyasyonBilgisi[0]["baslik"])." ";
																				}
																			}
																		}
																		else
																		{
																			$varyasyonBilgisi=$VT->VeriGetir("urunvaryasyonlari","WHERE ID=?",array($varyasyonID),"ORDER BY ID ASC",1);
																			$secenekBilgisi=$VT->VeriGetir("urunvaryasyonsecenekleri","WHERE ID=?",array($secenekID),"ORDER BY ID ASC",1);

																			if($varyasyonBilgisi!=false && $secenekBilgisi!=false)
																			{
																				$ozellikler=stripslashes($secenekBilgisi[0]["baslik"])." ".stripslashes($varyasyonBilgisi[0]["baslik"]);
																			}
																		}
																	}
																}

																$toplamTutar += $siparisurunler[$i]["toplamtutar"];

																if(!empty($urunler[0]["resim"])) {
																	$urunResim = $urunler[0]["resim"];
																} else {
																	$urunResim = "varsayilan.png";
																}
																?>
																<tr>
																	<td><span class="badge bg-secondary"><?=$urunler[0]["urunkodu"]?></span></td>
																	<td>
																		<img src="<?=SITE?>images/urunler/<?=$urunResim?>" alt="<?=stripslashes($urunler[0]["baslik"])?>" class="product-img">
																	</td>
																	<td>
																		<div class="product-title"><?=stripslashes($urunler[0]["baslik"])?></div>
																		<?php if(!empty($ozellikler)) { ?>
																		<small class="text-muted">
																			<i class="far fa-tag me-1"></i><?=$ozellikler?>
																		</small>
																		<?php } ?>
																	</td>
																	<td><strong><?=number_format($siparisurunler[$i]["uruntutar"],2,",",".")?> TL</strong></td>
																	<td><span class="badge badge-primary"><?=$siparisurunler[$i]["adet"]?> Adet</span></td>
																	<td><strong class="text-success"><?=number_format($siparisurunler[$i]["toplamtutar"],2,",",".")?> TL</strong></td>
																</tr>
																<?php
															}
														}
													}
												}
												?>
												<tr class="table-active">
													<td colspan="5" class="text-end fw-bold">GENEL TOPLAM:</td>
													<td><strong class="text-success fs-5"><?=number_format($toplamTutar,2,",",".")?> TL</strong></td>
												</tr>
												<?php
											}
											else
											{
												?>
												<tr>
													<td colspan="6" class="text-center py-5">
														<i class="far fa-box-open" style="font-size: 60px; color: #ddd; margin-bottom: 15px; display: block;"></i>
														<p class="mb-0">Iade edilen urun bulunmuyor.</p>
													</td>
												</tr>
												<?php
											}
											?>
										</tbody>
									</table>
								</div>

								<div class="text-center mt-4">
									<a href="<?=SITE?>iadeler" class="vs-btn style4">
										<i class="far fa-arrow-left me-2"></i>Iadeler Sayfasina Don
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

			<style>
				.account-menu-box {
					display: block;
					padding: 20px 10px;
					background: #fff;
					border: 2px solid #e8e8e8;
					border-radius: 10px;
					transition: all 0.3s;
					text-decoration: none;
					color: #333;
				}
				.account-menu-box:hover,
				.account-menu-box.active {
					border-color: #76a713;
					transform: translateY(-5px);
					box-shadow: 0 10px 20px rgba(118, 167, 19, 0.1);
				}
				.account-menu-box.active {
					background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
					color: #fff;
				}
				.account-menu-box.active i {
					color: #fff;
				}
				.account-menu-box i {
					font-size: 32px;
					color: #76a713;
					margin-bottom: 10px;
					display: block;
				}
				.account-menu-box h5 {
					font-size: 14px;
					margin: 0;
					font-weight: 600;
				}
				.sec-subtitle {
					font-size: 20px;
					font-weight: 700;
					color: #333;
				}
				.return-status .badge {
					font-size: 14px;
					padding: 8px 15px;
					border-radius: 6px;
				}
				.badge-warning {
					background: #ff9800;
					color: #fff;
				}
				.badge-success {
					background: #4caf50;
					color: #fff;
				}
				.badge-primary {
					background: #76a713;
					color: #fff;
				}
				.info-card {
					background: #f8f9fa;
					padding: 15px;
					border-radius: 8px;
					border-left: 4px solid #76a713;
				}
				.info-label {
					font-size: 12px;
					color: #666;
					margin-bottom: 5px;
					font-weight: 600;
					text-transform: uppercase;
				}
				.info-value {
					font-size: 14px;
					color: #333;
					font-weight: 700;
				}
				.product-img {
					height: 80px;
					width: 80px;
					object-fit: cover;
					border-radius: 8px;
					border: 2px solid #f0f0f0;
				}
				.product-title {
					font-weight: 600;
					color: #333;
					margin-bottom: 5px;
				}
				.table th {
					font-weight: 600;
					font-size: 13px;
					text-transform: uppercase;
					color: #333;
					border-bottom: 2px solid #76a713;
					padding: 15px;
				}
				.table td {
					vertical-align: middle;
					padding: 20px 15px;
				}
				.table-hover tbody tr:hover {
					background-color: #f8f9fa;
				}
				.alert {
					border-radius: 8px;
					padding: 20px;
				}
				.alert h6 {
					color: inherit;
					margin-bottom: 10px;
				}
				@media (max-width: 768px) {
					.account-menu-box {
						padding: 15px 5px;
					}
					.account-menu-box i {
						font-size: 24px;
					}
					.account-menu-box h5 {
						font-size: 12px;
					}
					.info-card {
						margin-bottom: 10px;
					}
					.product-img {
						height: 60px;
						width: 60px;
					}
					.table {
						font-size: 13px;
					}
				}
			</style>
			<?php
		}
		else
		{
			?>
			<meta http-equiv="refresh" content="0;url=<?=SITE?>iadeler">
			<?php
			exit();
		}
	}
	else
	{
		?>
		<meta http-equiv="refresh" content="0;url=<?=SITE?>uyelik">
		<?php
		exit();
	}
}
else
{
	?>
	<meta http-equiv="refresh" content="0;url=<?=SITE?>uyelik">
	<?php
	exit();
}
?>
