<?php
$islemdurumu=false;
if($_POST)
{
	if(!empty($_POST["sipariskodu"]))
	{
		$sipariskodu=$VT->filter($_POST["sipariskodu"]);
		$siparisler=$VT->VeriGetir("siparisler","WHERE sipariskodu=?",array($sipariskodu),"ORDER BY ID ASC",1);
		if($siparisler!=false)
		{
			$islemdurumu=true;
		}
	}
}
?>

<!--==============================
Breadcumb
============================== -->
<div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/breadcumb/breadcumb-img-1.jpg">
	<div class="container">
		<div class="breadcumb-content text-center">
			<h1 class="breadcumb-title">Siparis Takip</h1>
			<ul class="breadcumb-menu-style1 mx-auto">
				<li><a href="<?=SITE?>">Anasayfa</a></li>
				<li class="active">Siparis Takip</li>
			</ul>
		</div>
	</div>
</div>

<!--==============================
Order Tracking Section
============================== -->
<section class="space-top space-md-bottom">
	<div class="container">
		<?php
		if($islemdurumu!=false)
		{
			$uyebilgisi=$VT->VeriGetir("uyeler","WHERE ID=? AND durum=?",array($siparisler[0]["uyeID"],1),"ORDER BY ID ASC",1);
			if($uyebilgisi!=false)
			{
				// Payment type
				if($siparisler[0]["odemetipi"]==1){$odemetipi="Kredi Karti";}
				if($siparisler[0]["odemetipi"]==2){$odemetipi="Havale / EFT";}
				if($siparisler[0]["odemetipi"]==3){$odemetipi="Kapida Odeme";}

				$AlanBaslik = $siparisler[0]["durum"]==1 ? "ODENEN" : "ODENECEK";
				$odendiMi = $siparisler[0]["durum"]==1;
				?>

				<!-- Order Found Result -->
				<div class="tracking-result-wrapper">
					<div class="success-header">
						<div class="success-icon-large">
							<i class="far fa-check-circle"></i>
						</div>
						<h3>Siparis1niz Bulundu!</h3>
						<p>Siparis kodunuz: <strong>#<?=$siparisler[0]["sipariskodu"]?></strong></p>
					</div>

					<div class="row mt-5">
						<!-- Main Info -->
						<div class="col-lg-8 mb-4">
							<!-- Order Summary Card -->
							<div class="tracking-info-card">
								<div class="card-header-track">
									<i class="far fa-receipt me-2"></i>
									<h4>Siparis Bilgileri</h4>
								</div>

								<div class="card-body-track">
									<div class="info-grid-track">
										<div class="info-box">
											<div class="info-icon-track payment">
												<i class="far fa-credit-card"></i>
											</div>
											<div class="info-content-track">
												<label>Odeme Tipi</label>
												<span><?=$odemetipi?></span>
											</div>
										</div>

										<div class="info-box">
											<div class="info-icon-track customer">
												<i class="far fa-user"></i>
											</div>
											<div class="info-content-track">
												<label>Alici</label>
												<span><?php
												if($uyebilgisi[0]["tipi"]==1) {
													echo stripslashes(mb_substr($uyebilgisi[0]["ad"],0,1,"UTF-8")."***** ".mb_substr($uyebilgisi[0]["soyad"],0,1,"UTF-8"))."*****";
												} else {
													echo mb_substr(stripslashes($uyebilgisi[0]["firmaadi"]),0,5,"UTF-8")."**********";
												}
												?></span>
											</div>
										</div>

										<div class="info-box">
											<div class="info-icon-track address">
												<i class="far fa-map-marker-alt"></i>
											</div>
											<div class="info-content-track">
												<label>Teslimat Adresi</label>
												<span><?php
												$ilBilgi=$VT->VeriGetir("il","WHERE ID=?",array($uyebilgisi[0]["ilID"]),"ORDER BY ID ASC",1);
												echo stripslashes(mb_substr($uyebilgisi[0]["adres"],0,1,"UTF-8")."***** ".$uyebilgisi[0]["ilce"]);
												if($ilBilgi!=false) {
													echo "/".mb_convert_case($ilBilgi[0]["ADI"],MB_CASE_UPPER,"UTF-8");
												}
												?></span>
											</div>
										</div>

										<div class="info-box">
											<div class="info-icon-track date">
												<i class="far fa-calendar"></i>
											</div>
											<div class="info-content-track">
												<label>Siparis Tarihi</label>
												<span><?=date("d.m.Y",strtotime($siparisler[0]["tarih"]))?></span>
											</div>
										</div>

										<?php if(!empty($siparisler[0]["kargoadi"])) { ?>
										<div class="info-box full-width">
											<div class="info-icon-track shipping">
												<i class="far fa-truck"></i>
											</div>
											<div class="info-content-track">
												<label>Kargo Bilgisi</label>
												<span>
													<strong><?=$siparisler[0]["kargoadi"]?></strong><br>
													Takip No: <code class="tracking-code"><?=$siparisler[0]["takipno"]?></code>
												</span>
											</div>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>

							<!-- Products Card -->
							<div class="tracking-info-card mt-4">
								<div class="card-header-track">
									<i class="far fa-box me-2"></i>
									<h4>Siparis Edilen Urunler</h4>
								</div>

								<div class="card-body-track p-0">
									<div class="products-track-list">
										<?php
										$siparisurunler=$VT->VeriGetir("siparisurunler","WHERE siparisID=?",array($siparisler[0]["ID"]),"ORDER BY ID ASC");
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
													?>
													<div class="product-track-item">
														<div class="product-image-track">
															<img src="<?=SITE?>images/urunler/<?=$urunler[0]["resim"]?>" alt="<?=stripslashes($urunler[0]["baslik"])?>">
														</div>
														<div class="product-details-track">
															<h6><?=stripslashes($urunler[0]["baslik"])?></h6>
															<?php if(!empty($ozellikler)) { ?>
															<p class="variant-text">
																<i class="far fa-tag me-1"></i><?=$ozellikler?>
															</p>
															<?php } ?>
															<p class="code-text">
																<i class="far fa-barcode me-1"></i>Kod: <?=$urunler[0]["urunkodu"]?>
															</p>
														</div>
														<div class="product-quantity-track">
															<span class="qty-label">Adet</span>
															<span class="qty-value">×<?=$siparisurunler[$i]["adet"]?></span>
														</div>
														<div class="product-price-track">
															<span class="price-badge">Fiyat Gizli</span>
														</div>
													</div>
													<?php
												}
											}
										}
										?>
									</div>
								</div>
							</div>
						</div>

						<!-- Sidebar -->
						<div class="col-lg-4">
							<!-- Order Status Timeline -->
							<div class="status-timeline-card">
								<h5 class="timeline-title-track">
									<i class="far fa-list-timeline me-2"></i>Siparis Durumu
								</h5>

								<div class="timeline-track">
									<div class="timeline-step <?=$odendiMi ? 'completed' : 'pending'?>">
										<div class="step-icon">
											<i class="far fa-check"></i>
										</div>
										<div class="step-content">
											<h6>Siparis Alindi</h6>
											<p><?=date("d.m.Y H:i",strtotime($siparisler[0]["tarih"]))?></p>
										</div>
									</div>

									<div class="timeline-step <?=$odendiMi ? 'completed' : 'pending'?>">
										<div class="step-icon">
											<i class="far fa-credit-card"></i>
										</div>
										<div class="step-content">
											<h6>Odeme <?=$odendiMi ? 'Tamamlandi' : 'Bekleniyor'?></h6>
											<p><?=$odendiMi ? date("d.m.Y H:i",strtotime($siparisler[0]["tarih"])) : 'Bekleniyor'?></p>
										</div>
									</div>

									<div class="timeline-step <?=!empty($siparisler[0]["kargoadi"]) ? 'completed' : 'pending'?>">
										<div class="step-icon">
											<i class="far fa-box"></i>
										</div>
										<div class="step-content">
											<h6>Hazirlaniyor</h6>
											<p><?=!empty($siparisler[0]["kargoadi"]) ? 'Tamamlandi' : 'Islemde'?></p>
										</div>
									</div>

									<div class="timeline-step <?=!empty($siparisler[0]["kargoadi"]) ? 'completed' : 'pending'?>">
										<div class="step-icon">
											<i class="far fa-truck"></i>
										</div>
										<div class="step-content">
											<h6>Kargoya Verildi</h6>
											<p><?=!empty($siparisler[0]["kargoadi"]) ? $siparisler[0]["kargoadi"] : 'Bekleniyor'?></p>
										</div>
									</div>

									<div class="timeline-step pending">
										<div class="step-icon">
											<i class="far fa-home"></i>
										</div>
										<div class="step-content">
											<h6>Teslim Edildi</h6>
											<p>-</p>
										</div>
									</div>
								</div>
							</div>

							<!-- Payment Info -->
							<div class="payment-info-card mt-4">
								<h5 class="payment-title">
									<i class="far fa-wallet me-2"></i>Odeme Bilgisi
								</h5>

								<div class="payment-status-large <?=$odendiMi ? 'paid' : 'pending'?>">
									<i class="far <?=$odendiMi ? 'fa-check-circle' : 'fa-clock'?>"></i>
									<span><?=$odendiMi ? 'ODENDI' : 'ODEME BEKLIYOR'?></span>
								</div>

								<div class="payment-note">
									<i class="far fa-info-circle me-2"></i>
									<small>Guvenlik nedeniyle tutar bilgisi gizlenmistir</small>
								</div>
							</div>

							<!-- New Search -->
							<div class="new-search-card mt-4">
								<a href="<?=SITE?>siparis-takip" class="vs-btn style4 w-100">
									<i class="far fa-search me-2"></i>Yeni Sorgulama Yap
								</a>
							</div>
						</div>
					</div>
				</div>
				<?php
			}
		}
		else
		{
			?>
			<!-- Search Form -->
			<div class="tracking-search-wrapper">
				<div class="row justify-content-center">
					<div class="col-xl-6 col-lg-7 col-md-9">
						<div class="search-card">
							<div class="search-icon-wrapper">
								<div class="search-icon">
									<i class="far fa-search"></i>
								</div>
							</div>

							<h3 class="search-title">Siparis Takip</h3>
							<p class="search-description">
								Siparislerinizin durumunu takip etmek icin siparis kodunuzu asagidaki alana girin.
							</p>

							<form action="#" method="post" class="tracking-form">
								<div class="form-group-track">
									<div class="input-wrapper-track">
										<i class="far fa-hashtag input-icon-track"></i>
										<input type="text"
											   name="sipariskodu"
											   class="form-control-track"
											   placeholder="Siparis Kodunuz (Ornek: 12345678)"
											   required
											   autocomplete="off">
									</div>
								</div>

								<button type="submit" class="btn-track-submit">
									<span>Siparisi Sorgula</span>
									<i class="far fa-arrow-right"></i>
								</button>
							</form>

							<div class="help-text">
								<i class="far fa-question-circle me-2"></i>
								<span>Siparis kodunuzu e-posta adresinize gonderilen siparisç onay mailinde bulabilirsiniz.</span>
							</div>

							<div class="quick-links-track">
								<a href="<?=SITE?>siparislerim" class="quick-link">
									<i class="far fa-list me-2"></i>Siparislerim
								</a>
								<a href="<?=SITE?>iletisim" class="quick-link">
									<i class="far fa-headset me-2"></i>Yardim
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</section>

<style>
	/* Tracking Search Wrapper */
	.tracking-search-wrapper {
		padding: 60px 0;
		animation: fadeIn 0.6s ease-out;
	}

	.search-card {
		background: #fff;
		border-radius: 25px;
		padding: 60px 50px;
		box-shadow: 0 10px 50px rgba(0,0,0,0.1);
		text-align: center;
		position: relative;
		overflow: hidden;
	}
	.search-card::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		height: 5px;
		background: linear-gradient(90deg, #76a713 0%, #5a8010 100%);
	}

	/* Search Icon */
	.search-icon-wrapper {
		margin-bottom: 30px;
	}
	.search-icon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 100px;
		height: 100px;
		border-radius: 50%;
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		color: #fff;
		font-size: 45px;
		box-shadow: 0 10px 30px rgba(118, 167, 19, 0.3);
		animation: pulse 2s infinite;
	}

	.search-title {
		font-size: 32px;
		font-weight: 700;
		color: #2c3e50;
		margin-bottom: 15px;
	}
	.search-description {
		font-size: 15px;
		color: #6c757d;
		margin-bottom: 40px;
		line-height: 1.6;
	}

	/* Tracking Form */
	.form-group-track {
		margin-bottom: 30px;
	}
	.input-wrapper-track {
		position: relative;
		display: flex;
		align-items: center;
	}
	.input-icon-track {
		position: absolute;
		left: 25px;
		color: #76a713;
		font-size: 20px;
		z-index: 2;
		transition: all 0.3s ease;
	}
	.form-control-track {
		width: 100%;
		height: 60px;
		padding: 18px 25px 18px 65px;
		border: 2px solid #e8e8e8;
		border-radius: 15px;
		font-size: 16px;
		font-weight: 500;
		color: #2c3e50;
		background: #f8f9fa;
		transition: all 0.3s ease;
		text-align: center;
	}
	.form-control-track:focus {
		outline: none;
		border-color: #76a713;
		background: #fff;
		box-shadow: 0 0 0 5px rgba(118, 167, 19, 0.1);
	}
	.form-control-track:focus + .input-icon-track {
		color: #76a713;
		transform: scale(1.2);
	}

	.btn-track-submit {
		width: 100%;
		height: 60px;
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		color: #fff;
		border: none;
		border-radius: 15px;
		font-size: 18px;
		font-weight: 700;
		cursor: pointer;
		transition: all 0.3s ease;
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 15px;
		box-shadow: 0 5px 20px rgba(118, 167, 19, 0.4);
		position: relative;
		overflow: hidden;
	}
	.btn-track-submit::before {
		content: '';
		position: absolute;
		top: 0;
		left: -100%;
		width: 100%;
		height: 100%;
		background: rgba(255,255,255,0.2);
		transition: left 0.5s ease;
	}
	.btn-track-submit:hover::before {
		left: 100%;
	}
	.btn-track-submit:hover {
		transform: translateY(-2px);
		box-shadow: 0 8px 30px rgba(118, 167, 19, 0.5);
	}
	.btn-track-submit i {
		transition: transform 0.3s ease;
	}
	.btn-track-submit:hover i {
		transform: translateX(5px);
	}

	.help-text {
		margin-top: 25px;
		padding: 20px;
		background: #fff3cd;
		border-radius: 12px;
		font-size: 14px;
		color: #856404;
		display: flex;
		align-items: center;
		justify-content: center;
		text-align: left;
		border: 2px solid #ffc107;
	}

	.quick-links-track {
		display: flex;
		justify-content: center;
		gap: 30px;
		margin-top: 30px;
		padding-top: 30px;
		border-top: 2px dashed #e8e8e8;
	}
	.quick-link {
		display: flex;
		align-items: center;
		gap: 8px;
		color: #6c757d;
		text-decoration: none;
		font-weight: 600;
		font-size: 14px;
		transition: all 0.3s ease;
	}
	.quick-link:hover {
		color: #76a713;
		transform: translateY(-2px);
	}

	/* Tracking Result */
	.tracking-result-wrapper {
		animation: fadeIn 0.6s ease-out;
	}

	.success-header {
		text-align: center;
		padding: 50px 30px;
		background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
		border-radius: 20px;
		border: 3px solid #28a745;
		margin-bottom: 40px;
	}
	.success-icon-large {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 120px;
		height: 120px;
		border-radius: 50%;
		background: #28a745;
		color: #fff;
		font-size: 60px;
		margin-bottom: 25px;
		box-shadow: 0 10px 40px rgba(40, 167, 69, 0.4);
		animation: scaleIn 0.6s ease-out;
	}
	.success-header h3 {
		font-size: 32px;
		font-weight: 700;
		color: #155724;
		margin-bottom: 10px;
	}
	.success-header p {
		font-size: 16px;
		color: #155724;
		margin: 0;
	}
	.success-header strong {
		font-size: 20px;
		font-weight: 700;
	}

	/* Tracking Info Card */
	.tracking-info-card {
		background: #fff;
		border-radius: 20px;
		overflow: hidden;
		box-shadow: 0 5px 20px rgba(0,0,0,0.08);
	}
	.card-header-track {
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		padding: 25px 30px;
		display: flex;
		align-items: center;
		gap: 10px;
		color: #fff;
	}
	.card-header-track h4 {
		margin: 0;
		font-size: 20px;
		font-weight: 700;
	}
	.card-body-track {
		padding: 30px;
	}

	.info-grid-track {
		display: grid;
		grid-template-columns: repeat(2, 1fr);
		gap: 20px;
	}
	.info-box {
		display: flex;
		gap: 15px;
		padding: 20px;
		background: #f8f9fa;
		border-radius: 12px;
		border: 2px solid #e8e8e8;
		transition: all 0.3s ease;
	}
	.info-box:hover {
		border-color: #76a713;
		background: #fff;
		box-shadow: 0 4px 15px rgba(118, 167, 19, 0.1);
	}
	.info-box.full-width {
		grid-column: 1 / -1;
	}

	.info-icon-track {
		flex-shrink: 0;
		width: 50px;
		height: 50px;
		display: flex;
		align-items: center;
		justify-content: center;
		border-radius: 12px;
		font-size: 22px;
		color: #fff;
	}
	.info-icon-track.payment { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
	.info-icon-track.customer { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
	.info-icon-track.address { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
	.info-icon-track.date { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
	.info-icon-track.shipping { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }

	.info-content-track {
		flex: 1;
	}
	.info-content-track label {
		display: block;
		font-size: 13px;
		color: #6c757d;
		font-weight: 600;
		margin-bottom: 5px;
	}
	.info-content-track span {
		display: block;
		font-size: 15px;
		color: #2c3e50;
		font-weight: 600;
		line-height: 1.5;
	}
	.tracking-code {
		background: #76a713;
		color: #fff;
		padding: 4px 12px;
		border-radius: 6px;
		font-size: 14px;
		font-family: 'Courier New', monospace;
	}

	/* Products List */
	.products-track-list {
		padding: 20px;
	}
	.product-track-item {
		display: grid;
		grid-template-columns: 100px 1fr auto auto;
		gap: 20px;
		align-items: center;
		padding: 20px;
		background: #f8f9fa;
		border-radius: 12px;
		margin-bottom: 15px;
		border: 2px solid #e8e8e8;
		transition: all 0.3s ease;
	}
	.product-track-item:hover {
		border-color: #76a713;
		background: #fff;
		box-shadow: 0 4px 15px rgba(118, 167, 19, 0.1);
	}

	.product-image-track {
		width: 100px;
		height: 100px;
		border-radius: 10px;
		overflow: hidden;
		border: 2px solid #e8e8e8;
	}
	.product-image-track img {
		width: 100%;
		height: 100%;
		object-fit: cover;
	}

	.product-details-track h6 {
		font-size: 16px;
		font-weight: 600;
		color: #2c3e50;
		margin-bottom: 8px;
	}
	.variant-text,
	.code-text {
		font-size: 13px;
		color: #6c757d;
		margin-bottom: 4px;
	}
	.variant-text {
		color: #76a713;
		font-weight: 500;
	}

	.product-quantity-track {
		text-align: center;
	}
	.qty-label {
		display: block;
		font-size: 12px;
		color: #6c757d;
		margin-bottom: 5px;
	}
	.qty-value {
		display: block;
		font-size: 18px;
		font-weight: 700;
		color: #2c3e50;
	}

	.price-badge {
		background: #e8e8e8;
		color: #6c757d;
		padding: 8px 16px;
		border-radius: 8px;
		font-size: 13px;
		font-weight: 600;
	}

	/* Status Timeline */
	.status-timeline-card {
		background: #fff;
		border-radius: 20px;
		padding: 30px;
		box-shadow: 0 5px 20px rgba(0,0,0,0.08);
	}
	.timeline-title-track {
		font-size: 18px;
		font-weight: 700;
		color: #2c3e50;
		margin-bottom: 25px;
	}

	.timeline-track {
		position: relative;
	}
	.timeline-step {
		display: flex;
		gap: 15px;
		position: relative;
		padding-bottom: 30px;
	}
	.timeline-step:not(:last-child)::before {
		content: '';
		position: absolute;
		left: 22px;
		top: 45px;
		bottom: 0;
		width: 2px;
		background: #e8e8e8;
	}
	.timeline-step.completed:not(:last-child)::before {
		background: linear-gradient(180deg, #76a713 0%, #5a8010 100%);
	}

	.step-icon {
		flex-shrink: 0;
		width: 45px;
		height: 45px;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		background: #e8e8e8;
		color: #6c757d;
		font-size: 18px;
		transition: all 0.3s ease;
	}
	.timeline-step.completed .step-icon {
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		color: #fff;
		box-shadow: 0 4px 15px rgba(118, 167, 19, 0.3);
	}

	.step-content h6 {
		font-size: 15px;
		font-weight: 600;
		color: #2c3e50;
		margin-bottom: 5px;
	}
	.step-content p {
		font-size: 13px;
		color: #6c757d;
		margin: 0;
	}

	/* Payment Info */
	.payment-info-card {
		background: #fff;
		border-radius: 20px;
		padding: 30px;
		box-shadow: 0 5px 20px rgba(0,0,0,0.08);
		text-align: center;
	}
	.payment-title {
		font-size: 18px;
		font-weight: 700;
		color: #2c3e50;
		margin-bottom: 20px;
		text-align: left;
	}

	.payment-status-large {
		display: flex;
		flex-direction: column;
		align-items: center;
		gap: 15px;
		padding: 30px;
		border-radius: 15px;
		margin-bottom: 20px;
	}
	.payment-status-large i {
		font-size: 50px;
	}
	.payment-status-large span {
		font-size: 18px;
		font-weight: 700;
	}
	.payment-status-large.paid {
		background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
		color: #155724;
		border: 3px solid #28a745;
	}
	.payment-status-large.pending {
		background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
		color: #856404;
		border: 3px solid #ffc107;
	}

	.payment-note {
		background: #f8f9fa;
		padding: 15px;
		border-radius: 10px;
		font-size: 13px;
		color: #6c757d;
		display: flex;
		align-items: center;
		justify-content: center;
	}

	/* Animations */
	@keyframes fadeIn {
		from {
			opacity: 0;
		}
		to {
			opacity: 1;
		}
	}
	@keyframes scaleIn {
		from {
			transform: scale(0);
		}
		to {
			transform: scale(1);
		}
	}
	@keyframes pulse {
		0%, 100% {
			transform: scale(1);
		}
		50% {
			transform: scale(1.05);
		}
	}

	/* Responsive */
	@media (max-width: 991px) {
		.info-grid-track {
			grid-template-columns: 1fr;
		}
	}
	@media (max-width: 768px) {
		.search-card {
			padding: 40px 30px;
		}
		.search-icon {
			width: 80px;
			height: 80px;
			font-size: 35px;
		}
		.search-title {
			font-size: 26px;
		}
		.product-track-item {
			grid-template-columns: 1fr;
			gap: 15px;
		}
		.product-image-track {
			width: 80px;
			height: 80px;
		}
		.product-quantity-track {
			text-align: left;
		}
	}
</style>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Auto-focus input
		const trackingInput = document.querySelector('.form-control-track');
		if(trackingInput) {
			trackingInput.focus();
		}

		// Format input (only numbers)
		if(trackingInput) {
			trackingInput.addEventListener('input', function(e) {
				this.value = this.value.replace(/[^0-9]/g, '');
			});
		}
	});
</script>

<?php
// Featured Products Section
if($islemdurumu==false)
{
?>
<section class="bg-white space-bottom">
	<div class="container">
		<div class="row justify-content-center text-center mb-5">
			<div class="col-lg-6">
				<h2 class="h1 mb-3">Vitrin Urunlerimiz</h2>
				<p class="text-muted">Size ozel vitrin urunlerimizi kesfedin.</p>
			</div>
		</div>

		<div class="row g-4">
			<?php
			$urunler=$VT->VeriGetir("urunler","WHERE durum=? AND vitrindurum=?",array(1,1),"ORDER BY sirano ASC LIMIT 8");
			if($urunler!=false)
			{
				for ($i=0; $i <count($urunler); $i++) {
					?>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="product-card-mini">
							<div class="product-image-mini">
								<a href="<?=SITE?>urun/<?=$urunler[$i]["seflink"]?>">
									<img src="<?=SITE?>images/urunler/<?=$urunler[$i]["resim"]?>" alt="<?=stripslashes($urunler[$i]["baslik"])?>">
								</a>
							</div>
							<div class="product-info-mini">
								<h6><a href="<?=SITE?>urun/<?=$urunler[$i]["seflink"]?>"><?=stripslashes($urunler[$i]["baslik"])?></a></h6>
								<div class="price-mini">
									<?php
									if(!empty($urunler[$i]["indirimlifiyat"])) {
										$fiyat=$urunler[$i]["indirimlifiyat"].".".$urunler[$i]["indirimlikurus"];
									} else {
										$fiyat=$urunler[$i]["fiyat"].".".$urunler[$i]["kurus"];
									}
									if($urunler[$i]["kdvdurum"]==1) {
										$oran = $urunler[$i]["kdvoran"]>9 ? "1.".$urunler[$i]["kdvoran"] : "1.0".$urunler[$i]["kdvoran"];
										$fiyat=($fiyat/$oran);
									}
									?>
									<?=number_format($fiyat,2,",",".")?> TL
								</div>
							</div>
						</div>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
</section>

<style>
	.product-card-mini {
		background: #fff;
		border-radius: 15px;
		overflow: hidden;
		transition: all 0.3s ease;
		border: 2px solid #e8e8e8;
		height: 100%;
	}
	.product-card-mini:hover {
		border-color: #76a713;
		box-shadow: 0 8px 25px rgba(118, 167, 19, 0.15);
		transform: translateY(-5px);
	}
	.product-image-mini {
		aspect-ratio: 1;
		overflow: hidden;
	}
	.product-image-mini img {
		width: 100%;
		height: 100%;
		object-fit: cover;
		transition: transform 0.3s ease;
	}
	.product-card-mini:hover .product-image-mini img {
		transform: scale(1.1);
	}
	.product-info-mini {
		padding: 20px;
	}
	.product-info-mini h6 {
		font-size: 14px;
		font-weight: 600;
		margin-bottom: 10px;
	}
	.product-info-mini a {
		color: #2c3e50;
		text-decoration: none;
	}
	.product-info-mini a:hover {
		color: #76a713;
	}
	.price-mini {
		font-size: 18px;
		font-weight: 700;
		color: #76a713;
	}
</style>
<?php
}
?>
