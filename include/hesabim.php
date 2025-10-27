<?php
if(!empty($_SESSION["uyeID"]))
{
	$uyeID=$VT->filter($_SESSION["uyeID"]);
	$uyebilgisi=$VT->VeriGetir("uyeler","WHERE ID=? AND durum=?",array($uyeID,1),"ORDER BY ID ASC",1);
	if($uyebilgisi!=false)
	{
		?>
		<!--==============================
		Breadcumb
		============================== -->
		<div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/breadcumb/breadcumb-img-1.jpg">
			<div class="container">
				<div class="breadcumb-content text-center">
					<h1 class="breadcumb-title">Hesabim</h1>
					<ul class="breadcumb-menu-style1 mx-auto">
						<li><a href="<?=SITE?>">Anasayfa</a></li>
						<li class="active">Hesabim</li>
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
						<a href="<?=SITE?>hesabim" class="account-menu-box text-center active">
							<i class="far fa-user"></i>
							<h5>Hesabim</h5>
						</a>
					</div>
					<div class="col-lg-2 col-md-4 col-6 mb-3">
						<a href="<?=SITE?>iadeler" class="account-menu-box text-center">
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
					Account Forms
				==============================-->
				<div class="row justify-content-center">
					<!-- Account Information Form -->
					<div class="col-xl-8 col-lg-8 col-md-12 mb-4">
						<div class="bg-white p-4 p-md-5 shadow-sm rounded">
							<h3 class="sec-subtitle mb-4">
								<i class="far fa-user-circle me-2"></i>Uyelik Bilgileri
							</h3>
							<?php
							if($_POST)
							{
								if(!empty($_POST["ozellik"]))
								{
									if(!empty($_POST["client_type"]) && $_POST["client_type"]=="private")
									{
										/* Bireysel uye ise */
										if(!empty($_POST["ad"]) && !empty($_POST["soyad"]) && !empty($_POST["adres"]) && !empty($_POST["telefon"]) && !empty($_POST["postakodu"]) && !empty($_POST["ilce"]) && !empty($_POST["il"]))
										{
											$ad=$VT->filter($_POST["ad"]);
											$soyad=$VT->filter($_POST["soyad"]);
											$adres=$VT->filter($_POST["adres"]);
											$telefon=$VT->filter($_POST["telefon"]);
											$postakodu=$VT->filter($_POST["postakodu"]);
											$ilce=$VT->filter($_POST["ilce"]);
											$il=$VT->filter($_POST["il"]);

											$guncelle=$VT->SorguCalistir("UPDATE uyeler","SET ad=?, soyad=?, adres=?, ilce=?, ilID=?, postakodu=?, telefon=?, tipi=?, durum=?, tarih=? WHERE ID=?",array($ad,$soyad,$adres,$ilce,$il,$postakodu,$telefon,1,1,date("Y-m-d"),$uyebilgisi[0]["ID"]),1);
											$_SESSION["uyeAdi"]=$ad;
											$uyebilgisi=$VT->VeriGetir("uyeler","WHERE ID=? AND durum=?",array($uyebilgisi[0]["ID"],1),"ORDER BY ID ASC",1);
											?>
											<div class="alert alert-success alert-dismissible fade show" role="alert">
												<i class="far fa-check-circle me-2"></i>Hesabiniz basariyla guncellendi.
												<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
											</div>
											<?php
										}
										else
										{
											?>
											<div class="alert alert-danger alert-dismissible fade show" role="alert">
												<i class="far fa-exclamation-triangle me-2"></i>Bos biraktiginiz alanlari doldurunuz.
												<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
											</div>
											<?php
										}
									}
									else if(!empty($_POST["client_type"]) && $_POST["client_type"]=="company")
									{
										/* Kurumsal uye */
										if(!empty($_POST["firmaadi"]) && !empty($_POST["vergidairesi"]) && !empty($_POST["vergino"]) && !empty($_POST["firmaadres"]) && !empty($_POST["firmatelefon"]) && !empty($_POST["firmapostakodu"]) && !empty($_POST["firmailce"]) && !empty($_POST["firmail"]))
										{
											$firmaadi=$VT->filter($_POST["firmaadi"]);
											$vergidairesi=$VT->filter($_POST["vergidairesi"]);
											$vergino=$VT->filter($_POST["vergino"]);
											$adres=$VT->filter($_POST["firmaadres"]);
											$telefon=$VT->filter($_POST["firmatelefon"]);
											$postakodu=$VT->filter($_POST["firmapostakodu"]);
											$ilce=$VT->filter($_POST["firmailce"]);
											$il=$VT->filter($_POST["firmail"]);

											$ekle=$VT->SorguCalistir("UPDATE uyeler","SET firmaadi=?, vergino=?, vergidairesi=?, adres=?, ilce=?, ilID=?, postakodu=?, telefon=?, tipi=?, durum=?, tarih=? WHERE ID=?",array($firmaadi,$vergino,$vergidairesi,$adres,$ilce,$il,$postakodu,$telefon,2,1,date("Y-m-d"),$uyebilgisi[0]["ID"]),1);
											$_SESSION["uyeAdi"]=$firmaadi;
											$uyebilgisi=$VT->VeriGetir("uyeler","WHERE ID=? AND durum=?",array($uyebilgisi[0]["ID"],1),"ORDER BY ID ASC",1);
											?>
											<div class="alert alert-success alert-dismissible fade show" role="alert">
												<i class="far fa-check-circle me-2"></i>Hesabiniz basariyla guncellendi.
												<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
											</div>
											<?php
										}
										else
										{
											?>
											<div class="alert alert-danger alert-dismissible fade show" role="alert">
												<i class="far fa-exclamation-triangle me-2"></i>Bos biraktiginiz alanlari doldurunuz.
												<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
											</div>
											<?php
										}
									}
								}
							}
							?>
							<form action="#" method="post" id="accountForm">
								<input type="hidden" name="ozellik" value="1">

								<!-- Email Field (Readonly) -->
								<div class="mb-3">
									<label class="form-label fw-semibold">E-posta Adresi</label>
									<input type="email" class="form-control" name="mail" value="<?=$uyebilgisi[0]["mail"]?>" readonly style="background: #f5f5f5;">
								</div>

								<hr class="my-4">

								<!-- Account Type Selection -->
								<div class="mb-4">
									<label class="form-label fw-semibold d-block mb-3">Uye Tipi</label>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="client_type" id="private" value="private" <?php if($uyebilgisi[0]["tipi"]==1) echo "checked"; ?>>
										<label class="form-check-label" for="private">
											<i class="far fa-user me-1"></i>Bireysel
										</label>
									</div>
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="radio" name="client_type" id="company" value="company" <?php if($uyebilgisi[0]["tipi"]==2) echo "checked"; ?>>
										<label class="form-check-label" for="company">
											<i class="far fa-building me-1"></i>Kurumsal
										</label>
									</div>
								</div>

								<!-- Private Account Fields -->
								<div class="private-box" style="display: <?=$uyebilgisi[0]["tipi"]==1 ? 'block' : 'none'?>;">
									<div class="row">
										<div class="col-md-6 mb-3">
											<label class="form-label">Isim <span class="text-danger">*</span></label>
											<input type="text" name="ad" class="form-control" placeholder="Isminiz" value="<?=$uyebilgisi[0]["ad"]?>">
										</div>
										<div class="col-md-6 mb-3">
											<label class="form-label">Soyisim <span class="text-danger">*</span></label>
											<input type="text" name="soyad" class="form-control" placeholder="Soyisminiz" value="<?=$uyebilgisi[0]["soyad"]?>">
										</div>
										<div class="col-12 mb-3">
											<label class="form-label">Adres <span class="text-danger">*</span></label>
											<textarea name="adres" class="form-control" rows="3" placeholder="Adresiniz"><?=$uyebilgisi[0]["adres"]?></textarea>
										</div>
										<div class="col-md-6 mb-3">
											<label class="form-label">Ilce <span class="text-danger">*</span></label>
											<input type="text" name="ilce" class="form-control" placeholder="Ilce" value="<?=$uyebilgisi[0]["ilce"]?>">
										</div>
										<div class="col-md-6 mb-3">
											<label class="form-label">Posta Kodu <span class="text-danger">*</span></label>
											<input type="text" name="postakodu" class="form-control" placeholder="Posta Kodu" value="<?=$uyebilgisi[0]["postakodu"]?>">
										</div>
										<div class="col-md-6 mb-3">
											<label class="form-label">Il <span class="text-danger">*</span></label>
											<select class="form-select" name="il">
												<option value="">Il Seciniz</option>
												<?php
												$iller=$VT->VeriGetir("il");
												if($iller!=false)
												{
													for($i=0; $i<count($iller); $i++) {
														$selected = ($uyebilgisi[0]["ilID"]==$iller[$i]["ID"]) ? 'selected' : '';
														echo '<option value="'.$iller[$i]["ID"].'" '.$selected.'>'.$iller[$i]["ADI"].'</option>';
													}
												}
												?>
											</select>
										</div>
										<div class="col-md-6 mb-3">
											<label class="form-label">Telefon <span class="text-danger">*</span></label>
											<input type="text" name="telefon" class="form-control" placeholder="5XX XXX XX XX" value="<?=$uyebilgisi[0]["telefon"]?>">
										</div>
									</div>
								</div>

								<!-- Company Account Fields -->
								<div class="company-box" style="display: <?=$uyebilgisi[0]["tipi"]==2 ? 'block' : 'none'?>;">
									<div class="row">
										<div class="col-12 mb-3">
											<label class="form-label">Firma Adi <span class="text-danger">*</span></label>
											<input type="text" name="firmaadi" class="form-control" placeholder="Firma Adiniz" value="<?=$uyebilgisi[0]["firmaadi"]?>">
										</div>
										<div class="col-md-6 mb-3">
											<label class="form-label">Vergi Dairesi <span class="text-danger">*</span></label>
											<input type="text" name="vergidairesi" class="form-control" placeholder="Vergi Dairesi" value="<?=$uyebilgisi[0]["vergidairesi"]?>">
										</div>
										<div class="col-md-6 mb-3">
											<label class="form-label">Vergi Numarasi <span class="text-danger">*</span></label>
											<input type="text" name="vergino" class="form-control" placeholder="Vergi Numarasi" value="<?=$uyebilgisi[0]["vergino"]?>">
										</div>
										<div class="col-12 mb-3">
											<label class="form-label">Firma Adresi <span class="text-danger">*</span></label>
											<textarea name="firmaadres" class="form-control" rows="3" placeholder="Firma Adresiniz"><?=$uyebilgisi[0]["adres"]?></textarea>
										</div>
										<div class="col-md-6 mb-3">
											<label class="form-label">Ilce <span class="text-danger">*</span></label>
											<input type="text" name="firmailce" class="form-control" placeholder="Ilce" value="<?=$uyebilgisi[0]["ilce"]?>">
										</div>
										<div class="col-md-6 mb-3">
											<label class="form-label">Posta Kodu <span class="text-danger">*</span></label>
											<input type="text" name="firmapostakodu" class="form-control" placeholder="Posta Kodu" value="<?=$uyebilgisi[0]["postakodu"]?>">
										</div>
										<div class="col-md-6 mb-3">
											<label class="form-label">Il <span class="text-danger">*</span></label>
											<select class="form-select" name="firmail">
												<option value="">Il Seciniz</option>
												<?php
												$iller=$VT->VeriGetir("il");
												if($iller!=false)
												{
													for($i=0; $i<count($iller); $i++) {
														$selected = ($uyebilgisi[0]["ilID"]==$iller[$i]["ID"]) ? 'selected' : '';
														echo '<option value="'.$iller[$i]["ID"].'" '.$selected.'>'.$iller[$i]["ADI"].'</option>';
													}
												}
												?>
											</select>
										</div>
										<div class="col-md-6 mb-3">
											<label class="form-label">Firma Telefonu <span class="text-danger">*</span></label>
											<input type="text" name="firmatelefon" class="form-control" placeholder="XXX XXX XX XX" value="<?=$uyebilgisi[0]["telefon"]?>">
										</div>
									</div>
								</div>

								<div class="text-center mt-4">
									<button type="submit" class="vs-btn style4">
										<i class="far fa-save me-2"></i>Hesabi Guncelle
									</button>
								</div>
							</form>
						</div>
					</div>

					<!-- Password Change Form -->
					<div class="col-xl-4 col-lg-4 col-md-12 mb-4">
						<div class="bg-white p-4 p-md-5 shadow-sm rounded">
							<h3 class="sec-subtitle mb-4">
								<i class="far fa-lock me-2"></i>Sifre Degistir
							</h3>
							<?php
							if($_POST)
							{
								if(!empty($_POST["giris"]))
								{
									if(!empty($_POST["esifre"]) && !empty($_POST["sifre"]))
									{
										$esifre=md5($VT->filter($_POST["esifre"]));
										$sifre=md5($VT->filter($_POST["sifre"]));
										if($uyebilgisi[0]["sifre"]==$esifre)
										{
											$sifreguncelle=$VT->SorguCalistir("UPDATE uyeler","SET sifre=? WHERE ID=?",array($sifre,$uyebilgisi[0]["ID"]),1);
											?>
											<div class="alert alert-success alert-dismissible fade show" role="alert">
												<i class="far fa-check-circle me-2"></i>Sifreniz basariyla guncellendi.
												<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
											</div>
											<?php
										}
										else
										{
											?>
											<div class="alert alert-danger alert-dismissible fade show" role="alert">
												<i class="far fa-times-circle me-2"></i>Eski sifreniz dogrulanamadi!
												<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
											</div>
											<?php
										}
									}
									else
									{
										?>
										<div class="alert alert-danger alert-dismissible fade show" role="alert">
											<i class="far fa-exclamation-triangle me-2"></i>Bos biraktiginiz alanlari doldurunuz.
											<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
										</div>
										<?php
									}
								}
							}
							?>
							<form action="#" method="post" id="passwordForm">
								<input type="hidden" name="giris" value="1">

								<div class="mb-3">
									<label class="form-label">Eski Parola <span class="text-danger">*</span></label>
									<div class="input-group">
										<span class="input-group-text"><i class="far fa-key"></i></span>
										<input type="password" class="form-control" name="esifre" placeholder="Mevcut parolaniz">
									</div>
								</div>

								<div class="mb-3">
									<label class="form-label">Yeni Parola <span class="text-danger">*</span></label>
									<div class="input-group">
										<span class="input-group-text"><i class="far fa-lock"></i></span>
										<input type="password" class="form-control" name="sifre" placeholder="Yeni parolaniz">
									</div>
								</div>

								<div class="alert alert-info" style="font-size: 13px;">
									<i class="far fa-info-circle me-2"></i>Guvenliginiz icin guclu bir parola kullanin.
								</div>

								<div class="text-center mt-4">
									<button type="submit" class="vs-btn style4 w-100">
										<i class="far fa-shield-check me-2"></i>Sifremi Guncelle
									</button>
								</div>
							</form>
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
				border-bottom: 2px solid #76a713;
				padding-bottom: 10px;
			}
			.form-label {
				font-size: 14px;
				color: #555;
				margin-bottom: 8px;
			}
			.form-control,
			.form-select {
				border: 1px solid #ddd;
				border-radius: 8px;
				padding: 12px 15px;
				font-size: 14px;
				transition: all 0.3s;
			}
			.form-control:focus,
			.form-select:focus {
				border-color: #76a713;
				box-shadow: 0 0 0 0.2rem rgba(118, 167, 19, 0.15);
			}
			.form-check-input:checked {
				background-color: #76a713;
				border-color: #76a713;
			}
			.input-group-text {
				background: #76a713;
				color: #fff;
				border: none;
				border-radius: 8px 0 0 8px;
			}
			.alert {
				border-radius: 8px;
				border: none;
			}
			.alert-success {
				background: #d4edda;
				color: #155724;
			}
			.alert-danger {
				background: #f8d7da;
				color: #721c24;
			}
			.alert-info {
				background: #d1ecf1;
				color: #0c5460;
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
			}
		</style>

		<script>
			// Account type toggle
			document.addEventListener('DOMContentLoaded', function() {
				const privateRadio = document.getElementById('private');
				const companyRadio = document.getElementById('company');
				const privateBox = document.querySelector('.private-box');
				const companyBox = document.querySelector('.company-box');

				function toggleAccountType() {
					if(privateRadio.checked) {
						privateBox.style.display = 'block';
						companyBox.style.display = 'none';
					} else if(companyRadio.checked) {
						privateBox.style.display = 'none';
						companyBox.style.display = 'block';
					}
				}

				privateRadio.addEventListener('change', toggleAccountType);
				companyRadio.addEventListener('change', toggleAccountType);
			});
		</script>
		<?php
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
