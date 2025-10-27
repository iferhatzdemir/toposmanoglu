<?php
if(!empty($_SESSION["uyeID"]))
{
	?>
	<meta http-equiv="refresh" content="0;url=<?=SITE?>hesabim">
	<?php
	exit();
}
?>

<!--==============================
Breadcumb
============================== -->
<div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/breadcumb/breadcumb-img-1.jpg">
	<div class="container">
		<div class="breadcumb-content text-center">
			<h1 class="breadcumb-title">Uyelik</h1>
			<ul class="breadcumb-menu-style1 mx-auto">
				<li><a href="<?=SITE?>">Anasayfa</a></li>
				<li class="active">Giris Yap / Uye Ol</li>
			</ul>
		</div>
	</div>
</div>

<!--==============================
Login & Register Section
============================== -->
<section class="space-top space-md-bottom auth-section">
	<div class="container">
		<div class="row justify-content-center">
			<!-- Login Card -->
			<div class="col-xl-6 col-lg-6 col-md-10 mb-4">
				<div class="auth-card login-card" data-aos="fade-right">
					<div class="auth-card-header">
						<div class="auth-icon login-icon">
							<i class="far fa-sign-in"></i>
						</div>
						<h3>Giris Yap</h3>
						<p>Hesabiniza giris yapin</p>
					</div>

					<?php
					// Login Processing
					if($_POST)
					{
						if(!empty($_POST["giris"]))
						{
							if(!empty($_POST["mail"]) && !empty($_POST["sifre"]))
							{
								$mail=$VT->filter($_POST["mail"]);
								$sifre=md5($VT->filter($_POST["sifre"]));
								$kontrol=$VT->VeriGetir("uyeler","WHERE mail=? AND sifre=? AND durum=?",array($mail,$sifre,1),"ORDER BY ID ASC",1);
								if($kontrol!=false)
								{
									$_SESSION["uyeID"]=$kontrol[0]["ID"];
									$_SESSION["uyeTipi"]=$kontrol[0]["tipi"];
									if($kontrol[0]["tipi"]==1)
									{
										$_SESSION["uyeAdi"]=$kontrol[0]["ad"];
									}
									else
									{
										$_SESSION["uyeAdi"]=$kontrol[0]["firmaadi"];
									}
									?>
									<meta http-equiv="refresh" content="0;url=<?=SITE?>hesabim">
									<?php
								}
								else
								{
									?>
									<div class="alert alert-danger alert-modern">
										<i class="far fa-exclamation-circle me-2"></i>E-mail veya sifre hatali!
									</div>
									<?php
								}
							}
							else
							{
								?>
								<div class="alert alert-danger alert-modern">
									<i class="far fa-exclamation-circle me-2"></i>Bos biraktiginiz alanlari doldurunuz.
								</div>
								<?php
							}
						}
					}
					?>

					<form action="#" method="post" class="auth-form">
						<input type="hidden" name="giris" value="1">

						<div class="form-group-auth">
							<div class="input-group-auth">
								<i class="far fa-envelope input-icon-auth"></i>
								<input type="email"
									   name="mail"
									   class="form-control-auth"
									   placeholder="E-mail Adresiniz"
									   required>
							</div>
						</div>

						<div class="form-group-auth">
							<div class="input-group-auth">
								<i class="far fa-lock input-icon-auth"></i>
								<input type="password"
									   name="sifre"
									   class="form-control-auth"
									   placeholder="Sifreniz"
									   id="loginPassword"
									   required>
								<button type="button" class="toggle-password-auth" data-target="loginPassword">
									<i class="far fa-eye"></i>
								</button>
							</div>
						</div>

						<div class="form-actions">
							<div class="forgot-link">
								<a href="#" id="forgotPasswordBtn">
									<i class="far fa-question-circle me-1"></i>Sifremi Unuttum
								</a>
							</div>
						</div>

						<button type="submit" class="btn-auth btn-primary">
							<span>Giris Yap</span>
							<i class="far fa-arrow-right"></i>
						</button>
					</form>

					<!-- Forgot Password Section -->
					<div class="forgot-password-section" id="forgotPasswordSection">
						<div class="forgot-header">
							<button type="button" class="back-btn" id="backToLoginBtn">
								<i class="far fa-arrow-left"></i>
							</button>
							<h4>Sifre Sifirlama</h4>
						</div>
						<p>E-mail adresinize sifre sifirlama baglantisi gonderilecektir.</p>
						<div class="form-group-auth">
							<div class="input-group-auth">
								<i class="far fa-envelope input-icon-auth"></i>
								<input type="email"
									   class="form-control-auth sifremail"
									   placeholder="E-mail Adresiniz">
							</div>
						</div>
						<button type="button" class="btn-auth btn-primary" onclick="sifreIste('<?=SITE?>');">
							<span>Sifre Sifirlama Linki Gonder</span>
							<i class="far fa-paper-plane"></i>
						</button>
					</div>
				</div>
			</div>

			<!-- Register Card -->
			<div class="col-xl-6 col-lg-6 col-md-10 mb-4">
				<div class="auth-card register-card" data-aos="fade-left">
					<div class="auth-card-header">
						<div class="auth-icon register-icon">
							<i class="far fa-user-plus"></i>
						</div>
						<h3>Uye Ol</h3>
						<p>Yeni hesap olusturun</p>
					</div>

					<?php
					// Register Processing
					if($_POST)
					{
						if(!empty($_POST["ozellik"]))
						{
							if(!empty($_POST["sozlesme"]) && $_POST["sozlesme"]==1)
							{
								if(!empty($_POST["client_type"]) && $_POST["client_type"]=="private")
								{
									// Individual Member
									if(!empty($_POST["ad"]) && !empty($_POST["soyad"]) && !empty($_POST["adres"]) && !empty($_POST["telefon"]) && !empty($_POST["postakodu"]) && !empty($_POST["ilce"]) && !empty($_POST["mail"]) && !empty($_POST["sifre"]) && !empty($_POST["il"]))
									{
										$ad=$VT->filter($_POST["ad"]);
										$soyad=$VT->filter($_POST["soyad"]);
										$adres=$VT->filter($_POST["adres"]);
										$telefon=$VT->filter($_POST["telefon"]);
										$postakodu=$VT->filter($_POST["postakodu"]);
										$ilce=$VT->filter($_POST["ilce"]);
										$mail=$VT->filter($_POST["mail"]);
										$sifre=md5($VT->filter($_POST["sifre"]));
										$il=$VT->filter($_POST["il"]);
										$kontrol=$VT->VeriGetir("uyeler","WHERE mail=?",array($mail),"ORDER BY ID ASC",1);
										if($kontrol!=false)
										{
											?>
											<div class="alert alert-danger alert-modern">
												<i class="far fa-exclamation-triangle me-2"></i>Bu hesap zaten mevcut. Lutfen giris yapiniz.
											</div>
											<?php
										}
										else
										{
											$ekle=$VT->SorguCalistir("INSERT INTO uyeler","SET ad=?, soyad=?, mail=?, sifre=?, adres=?, ilce=?, ilID=?, postakodu=?, telefon=?, tipi=?, durum=?, tarih=?",array($ad,$soyad,$mail,$sifre,$adres,$ilce,$il,$postakodu,$telefon,1,1,date("Y-m-d")));
											?>
											<div class="alert alert-success alert-modern-success">
												<i class="far fa-check-circle me-2"></i>Hesabiniz basariyla olusturuldu. Artik giris yapabilirsiniz.
											</div>
											<?php
										}
									}
									else
									{
										?>
										<div class="alert alert-danger alert-modern">
											<i class="far fa-exclamation-circle me-2"></i>Bos biraktiginiz alanlari doldurunuz.
										</div>
										<?php
									}
								}
								else if(!empty($_POST["client_type"]) && $_POST["client_type"]=="company")
								{
									// Corporate Member
									if(!empty($_POST["firmaadi"]) && !empty($_POST["vergidairesi"]) && !empty($_POST["vergino"]) && !empty($_POST["firmaadres"]) && !empty($_POST["firmatelefon"]) && !empty($_POST["firmapostakodu"]) && !empty($_POST["firmailce"]) && !empty($_POST["mail"]) && !empty($_POST["sifre"]) && !empty($_POST["firmail"]))
									{
										$firmaadi=$VT->filter($_POST["firmaadi"]);
										$vergidairesi=$VT->filter($_POST["vergidairesi"]);
										$vergino=$VT->filter($_POST["vergino"]);
										$adres=$VT->filter($_POST["firmaadres"]);
										$telefon=$VT->filter($_POST["firmatelefon"]);
										$postakodu=$VT->filter($_POST["firmapostakodu"]);
										$ilce=$VT->filter($_POST["firmailce"]);
										$mail=$VT->filter($_POST["mail"]);
										$sifre=md5($VT->filter($_POST["sifre"]));
										$il=$VT->filter($_POST["firmail"]);
										$kontrol=$VT->VeriGetir("uyeler","WHERE mail=?",array($mail),"ORDER BY ID ASC",1);
										if($kontrol!=false)
										{
											?>
											<div class="alert alert-danger alert-modern">
												<i class="far fa-exclamation-triangle me-2"></i>Bu hesap zaten mevcut. Lutfen giris yapiniz.
											</div>
											<?php
										}
										else
										{
											$ekle=$VT->SorguCalistir("INSERT INTO uyeler","SET firmaadi=?, vergino=?, vergidairesi=?, mail=?, sifre=?, adres=?, ilce=?, ilID=?, postakodu=?, telefon=?, tipi=?, durum=?, tarih=?",array($firmaadi,$vergino,$vergidairesi,$mail,$sifre,$adres,$ilce,$il,$postakodu,$telefon,2,1,date("Y-m-d")));
											?>
											<div class="alert alert-success alert-modern-success">
												<i class="far fa-check-circle me-2"></i>Hesabiniz basariyla olusturuldu. Artik giris yapabilirsiniz.
											</div>
											<?php
										}
									}
									else
									{
										?>
										<div class="alert alert-danger alert-modern">
											<i class="far fa-exclamation-circle me-2"></i>Bos biraktiginiz alanlari doldurunuz.
										</div>
										<?php
									}
								}
							}
							else
							{
								?>
								<div class="alert alert-danger alert-modern">
									<i class="far fa-exclamation-triangle me-2"></i>Sozlesmeyi kabul etmek zorundasiniz.
								</div>
								<?php
							}
						}
					}
					?>

					<form action="#" method="post" class="auth-form">
						<input type="hidden" name="ozellik" value="1">

						<!-- Email & Password -->
						<div class="form-group-auth">
							<div class="input-group-auth">
								<i class="far fa-envelope input-icon-auth"></i>
								<input type="email"
									   name="mail"
									   class="form-control-auth"
									   placeholder="E-mail Adresiniz"
									   required>
							</div>
						</div>

						<div class="form-group-auth">
							<div class="input-group-auth">
								<i class="far fa-lock input-icon-auth"></i>
								<input type="password"
									   name="sifre"
									   class="form-control-auth"
									   placeholder="Sifreniz"
									   id="registerPassword"
									   required>
								<button type="button" class="toggle-password-auth" data-target="registerPassword">
									<i class="far fa-eye"></i>
								</button>
							</div>
						</div>

						<!-- Member Type Toggle -->
						<div class="member-type-toggle">
							<label class="type-radio">
								<input type="radio" name="client_type" value="private" checked>
								<span class="radio-btn">
									<i class="far fa-user"></i>
									<span>Bireysel</span>
								</span>
							</label>
							<label class="type-radio">
								<input type="radio" name="client_type" value="company">
								<span class="radio-btn">
									<i class="far fa-building"></i>
									<span>Kurumsal</span>
								</span>
							</label>
						</div>

						<!-- Private Member Fields -->
						<div class="member-fields private-fields">
							<div class="row g-3">
								<div class="col-md-6">
									<div class="form-group-auth">
										<input type="text" name="ad" class="form-control-auth" placeholder="Isim *">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group-auth">
										<input type="text" name="soyad" class="form-control-auth" placeholder="Soyisim *">
									</div>
								</div>
								<div class="col-12">
									<div class="form-group-auth">
										<textarea name="adres" class="form-control-auth" rows="3" placeholder="Adres *"></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group-auth">
										<input type="text" name="ilce" class="form-control-auth" placeholder="Ilce *">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group-auth">
										<input type="text" name="postakodu" class="form-control-auth" placeholder="Posta Kodu *">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group-auth">
										<select name="il" class="form-control-auth">
											<option value="">Il Secin *</option>
											<?php
											$iller=$VT->VeriGetir("il");
											if($iller!=false)
											{
												for ($i=0; $i <count($iller); $i++) {
													?>
													<option value="<?=$iller[$i]["ID"]?>"><?=$iller[$i]["ADI"]?></option>
													<?php
												}
											}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group-auth">
										<input type="text" name="telefon" class="form-control-auth" placeholder="Telefon *">
									</div>
								</div>
							</div>
						</div>

						<!-- Company Member Fields -->
						<div class="member-fields company-fields" style="display: none;">
							<div class="row g-3">
								<div class="col-12">
									<div class="form-group-auth">
										<input type="text" name="firmaadi" class="form-control-auth" placeholder="Firma Adi *">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group-auth">
										<input type="text" name="vergidairesi" class="form-control-auth" placeholder="Vergi Dairesi *">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group-auth">
										<input type="text" name="vergino" class="form-control-auth" placeholder="Vergi No *">
									</div>
								</div>
								<div class="col-12">
									<div class="form-group-auth">
										<textarea name="firmaadres" class="form-control-auth" rows="3" placeholder="Adres *"></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group-auth">
										<input type="text" name="firmailce" class="form-control-auth" placeholder="Ilce *">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group-auth">
										<input type="text" name="firmapostakodu" class="form-control-auth" placeholder="Posta Kodu *">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group-auth">
										<select name="firmail" class="form-control-auth">
											<option value="">Il Secin *</option>
											<?php
											$iller=$VT->VeriGetir("il");
											if($iller!=false)
											{
												for ($i=0; $i <count($iller); $i++) {
													?>
													<option value="<?=$iller[$i]["ID"]?>"><?=$iller[$i]["ADI"]?></option>
													<?php
												}
											}
											?>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group-auth">
										<input type="text" name="firmatelefon" class="form-control-auth" placeholder="Telefon *">
									</div>
								</div>
							</div>
						</div>

						<!-- Terms Checkbox -->
						<div class="form-group-auth">
							<label class="checkbox-auth">
								<?php
								$bilgiler=$VT->VeriGetir("gizlilikpolitikasi","WHERE durum=?",array(1),"ORDER BY ID ASC",1);
								if($bilgiler!=false)
								{
									?>
									<input type="checkbox" name="sozlesme" value="1" required>
									<span class="checkmark-auth"></span>
									<span class="checkbox-text">
										<a href="<?=SITE?>gizlilik-politikasi/<?=$bilgiler[0]["seflink"]?>" target="_blank">Uyelik Sozlesmesi</a>'ni okudum, kabul ediyorum.
									</span>
									<?php
								}
								?>
							</label>
						</div>

						<button type="submit" class="btn-auth btn-success">
							<span>Hesap Olustur</span>
							<i class="far fa-check"></i>
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

<style>
	/* Auth Section */
	.auth-section {
		background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
		position: relative;
	}

	/* Auth Card */
	.auth-card {
		background: #fff;
		border-radius: 25px;
		padding: 50px 40px;
		box-shadow: 0 10px 50px rgba(0,0,0,0.1);
		position: relative;
		overflow: hidden;
		transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
	}
	.auth-card::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		height: 5px;
		transition: height 0.3s ease;
	}
	.login-card::before {
		background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
	}
	.register-card::before {
		background: linear-gradient(90deg, #76a713 0%, #5a8010 100%);
	}
	.auth-card:hover {
		box-shadow: 0 15px 60px rgba(0,0,0,0.15);
		transform: translateY(-5px);
	}
	.auth-card:hover::before {
		height: 8px;
	}

	/* Auth Card Header */
	.auth-card-header {
		text-align: center;
		margin-bottom: 40px;
		animation: fadeInDown 0.6s ease-out;
	}
	.auth-icon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 90px;
		height: 90px;
		border-radius: 50%;
		font-size: 40px;
		color: #fff;
		margin-bottom: 20px;
		position: relative;
		animation: bounceIn 0.8s ease-out;
	}
	.login-icon {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
	}
	.register-icon {
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		box-shadow: 0 10px 30px rgba(118, 167, 19, 0.4);
	}
	.auth-icon::after {
		content: '';
		position: absolute;
		width: 120%;
		height: 120%;
		border-radius: 50%;
		border: 2px solid currentColor;
		opacity: 0.3;
		animation: pulse 2s infinite;
	}
	.auth-card-header h3 {
		font-size: 28px;
		font-weight: 700;
		color: #2c3e50;
		margin-bottom: 10px;
	}
	.auth-card-header p {
		font-size: 15px;
		color: #6c757d;
		margin: 0;
	}

	/* Form Groups */
	.form-group-auth {
		margin-bottom: 20px;
	}
	.input-group-auth {
		position: relative;
		display: flex;
		align-items: center;
	}
	.input-icon-auth {
		position: absolute;
		left: 20px;
		color: #76a713;
		font-size: 18px;
		z-index: 2;
		transition: all 0.3s ease;
	}
	.form-control-auth {
		width: 100%;
		padding: 16px 55px 16px 55px;
		border: 2px solid #e8e8e8;
		border-radius: 12px;
		font-size: 15px;
		font-weight: 500;
		color: #2c3e50;
		background: #f8f9fa;
		transition: all 0.3s ease;
	}
	.form-control-auth:focus {
		outline: none;
		border-color: #76a713;
		background: #fff;
		box-shadow: 0 0 0 4px rgba(118, 167, 19, 0.1);
	}
	.form-control-auth:focus + .input-icon-auth {
		color: #76a713;
		transform: scale(1.1);
	}
	textarea.form-control-auth {
		resize: vertical;
		padding-left: 20px;
	}
	select.form-control-auth {
		padding-left: 20px;
		cursor: pointer;
	}

	/* Toggle Password */
	.toggle-password-auth {
		position: absolute;
		right: 20px;
		background: none;
		border: none;
		color: #6c757d;
		font-size: 18px;
		cursor: pointer;
		padding: 0;
		width: 30px;
		height: 30px;
		display: flex;
		align-items: center;
		justify-content: center;
		transition: all 0.3s ease;
		z-index: 2;
	}
	.toggle-password-auth:hover {
		color: #76a713;
		transform: scale(1.1);
	}
	.toggle-password-auth.active i::before {
		content: "\f070";
	}

	/* Form Actions */
	.form-actions {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 25px;
	}
	.forgot-link a {
		color: #667eea;
		text-decoration: none;
		font-size: 14px;
		font-weight: 600;
		transition: all 0.3s ease;
	}
	.forgot-link a:hover {
		color: #764ba2;
		transform: translateX(3px);
		display: inline-block;
	}

	/* Auth Buttons */
	.btn-auth {
		width: 100%;
		padding: 16px;
		border: none;
		border-radius: 12px;
		font-size: 16px;
		font-weight: 700;
		cursor: pointer;
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 10px;
		transition: all 0.3s ease;
		position: relative;
		overflow: hidden;
	}
	.btn-auth::before {
		content: '';
		position: absolute;
		top: 0;
		left: -100%;
		width: 100%;
		height: 100%;
		background: rgba(255,255,255,0.2);
		transition: left 0.5s ease;
	}
	.btn-auth:hover::before {
		left: 100%;
	}
	.btn-auth.btn-primary {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		color: #fff;
		box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
	}
	.btn-auth.btn-primary:hover {
		transform: translateY(-2px);
		box-shadow: 0 8px 30px rgba(102, 126, 234, 0.5);
	}
	.btn-auth.btn-success {
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		color: #fff;
		box-shadow: 0 5px 20px rgba(118, 167, 19, 0.4);
	}
	.btn-auth.btn-success:hover {
		transform: translateY(-2px);
		box-shadow: 0 8px 30px rgba(118, 167, 19, 0.5);
	}
	.btn-auth i {
		transition: transform 0.3s ease;
	}
	.btn-auth:hover i {
		transform: translateX(5px);
	}

	/* Forgot Password Section */
	.forgot-password-section {
		max-height: 0;
		overflow: hidden;
		transition: max-height 0.5s ease-out, padding 0.5s ease-out;
		padding: 0;
	}
	.forgot-password-section.active {
		max-height: 400px;
		padding: 30px 0 0;
		border-top: 2px dashed #e8e8e8;
		margin-top: 30px;
	}
	.forgot-header {
		display: flex;
		align-items: center;
		gap: 15px;
		margin-bottom: 20px;
	}
	.back-btn {
		width: 40px;
		height: 40px;
		border-radius: 50%;
		background: #f8f9fa;
		border: 2px solid #e8e8e8;
		display: flex;
		align-items: center;
		justify-content: center;
		cursor: pointer;
		transition: all 0.3s ease;
	}
	.back-btn:hover {
		background: #667eea;
		color: #fff;
		border-color: #667eea;
		transform: translateX(-3px);
	}
	.forgot-header h4 {
		font-size: 20px;
		font-weight: 700;
		color: #2c3e50;
		margin: 0;
	}
	.forgot-password-section p {
		font-size: 14px;
		color: #6c757d;
		margin-bottom: 20px;
	}

	/* Member Type Toggle */
	.member-type-toggle {
		display: grid;
		grid-template-columns: 1fr 1fr;
		gap: 15px;
		margin-bottom: 25px;
		padding: 20px 0;
		border-top: 2px dashed #e8e8e8;
		border-bottom: 2px dashed #e8e8e8;
	}
	.type-radio {
		position: relative;
		cursor: pointer;
	}
	.type-radio input {
		position: absolute;
		opacity: 0;
	}
	.radio-btn {
		display: flex;
		flex-direction: column;
		align-items: center;
		gap: 10px;
		padding: 20px;
		background: #f8f9fa;
		border: 2px solid #e8e8e8;
		border-radius: 12px;
		transition: all 0.3s ease;
	}
	.radio-btn i {
		font-size: 30px;
		color: #6c757d;
		transition: all 0.3s ease;
	}
	.radio-btn span {
		font-size: 14px;
		font-weight: 600;
		color: #2c3e50;
	}
	.type-radio input:checked + .radio-btn {
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		border-color: #76a713;
		box-shadow: 0 5px 20px rgba(118, 167, 19, 0.3);
	}
	.type-radio input:checked + .radio-btn i,
	.type-radio input:checked + .radio-btn span {
		color: #fff;
	}
	.type-radio:hover .radio-btn {
		transform: translateY(-3px);
		box-shadow: 0 4px 15px rgba(0,0,0,0.1);
	}

	/* Member Fields */
	.member-fields {
		animation: fadeIn 0.5s ease-out;
	}

	/* Checkbox */
	.checkbox-auth {
		display: flex;
		align-items: flex-start;
		gap: 12px;
		cursor: pointer;
		position: relative;
	}
	.checkbox-auth input {
		position: absolute;
		opacity: 0;
	}
	.checkmark-auth {
		flex-shrink: 0;
		width: 22px;
		height: 22px;
		border: 2px solid #e8e8e8;
		border-radius: 6px;
		transition: all 0.3s ease;
		position: relative;
	}
	.checkmark-auth::after {
		content: '\f00c';
		font-family: 'Font Awesome 5 Pro';
		font-weight: 900;
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%) scale(0);
		color: #fff;
		font-size: 12px;
		transition: transform 0.3s ease;
	}
	.checkbox-auth input:checked + .checkmark-auth {
		background: #76a713;
		border-color: #76a713;
	}
	.checkbox-auth input:checked + .checkmark-auth::after {
		transform: translate(-50%, -50%) scale(1);
	}
	.checkbox-text {
		font-size: 14px;
		color: #6c757d;
		line-height: 1.5;
	}
	.checkbox-text a {
		color: #76a713;
		text-decoration: none;
		font-weight: 600;
	}
	.checkbox-text a:hover {
		text-decoration: underline;
	}

	/* Alerts */
	.alert-modern {
		display: flex;
		align-items: center;
		padding: 16px 20px;
		border-radius: 12px;
		margin-bottom: 25px;
		font-size: 14px;
		font-weight: 500;
		animation: slideDown 0.5s ease-out;
	}
	.alert-modern-success {
		background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
		color: #155724;
		border: 2px solid #28a745;
	}

	/* Animations */
	@keyframes fadeInDown {
		from {
			opacity: 0;
			transform: translateY(-30px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}
	@keyframes bounceIn {
		0% {
			opacity: 0;
			transform: scale(0.3);
		}
		50% {
			transform: scale(1.05);
		}
		70% {
			transform: scale(0.9);
		}
		100% {
			opacity: 1;
			transform: scale(1);
		}
	}
	@keyframes pulse {
		0%, 100% {
			transform: scale(1);
			opacity: 0.3;
		}
		50% {
			transform: scale(1.1);
			opacity: 0;
		}
	}
	@keyframes slideDown {
		from {
			opacity: 0;
			transform: translateY(-20px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}
	@keyframes fadeIn {
		from { opacity: 0; }
		to { opacity: 1; }
	}

	/* AOS Animation */
	[data-aos="fade-right"] {
		opacity: 0;
		transform: translateX(-30px);
		transition: opacity 0.6s ease-out, transform 0.6s ease-out;
	}
	[data-aos="fade-left"] {
		opacity: 0;
		transform: translateX(30px);
		transition: opacity 0.6s ease-out, transform 0.6s ease-out;
	}
	[data-aos="fade-right"].aos-animate,
	[data-aos="fade-left"].aos-animate {
		opacity: 1;
		transform: translateX(0);
	}

	/* Responsive */
	@media (max-width: 768px) {
		.auth-card {
			padding: 40px 25px;
		}
		.auth-icon {
			width: 75px;
			height: 75px;
			font-size: 35px;
		}
		.auth-card-header h3 {
			font-size: 24px;
		}
		.member-type-toggle {
			grid-template-columns: 1fr;
		}
	}
</style>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Toggle Password Visibility
		const toggleButtons = document.querySelectorAll('.toggle-password-auth');
		toggleButtons.forEach(btn => {
			btn.addEventListener('click', function() {
				const targetId = this.getAttribute('data-target');
				const input = document.getElementById(targetId);
				const icon = this.querySelector('i');

				if(input.type === 'password') {
					input.type = 'text';
					icon.classList.remove('fa-eye');
					icon.classList.add('fa-eye-slash');
					this.classList.add('active');
				} else {
					input.type = 'password';
					icon.classList.remove('fa-eye-slash');
					icon.classList.add('fa-eye');
					this.classList.remove('active');
				}
			});
		});

		// Forgot Password Toggle
		const forgotBtn = document.getElementById('forgotPasswordBtn');
		const forgotSection = document.getElementById('forgotPasswordSection');
		const backBtn = document.getElementById('backToLoginBtn');

		if(forgotBtn) {
			forgotBtn.addEventListener('click', function(e) {
				e.preventDefault();
				forgotSection.classList.add('active');
			});
		}

		if(backBtn) {
			backBtn.addEventListener('click', function() {
				forgotSection.classList.remove('active');
			});
		}

		// Member Type Toggle
		const clientTypeRadios = document.querySelectorAll('input[name="client_type"]');
		const privateFields = document.querySelector('.private-fields');
		const companyFields = document.querySelector('.company-fields');

		clientTypeRadios.forEach(radio => {
			radio.addEventListener('change', function() {
				if(this.value === 'private') {
					privateFields.style.display = 'block';
					companyFields.style.display = 'none';
				} else {
					privateFields.style.display = 'none';
					companyFields.style.display = 'block';
				}
			});
		});

		// AOS Animation
		const observerOptions = {
			threshold: 0.1,
			rootMargin: '0px 0px -50px 0px'
		};

		const observer = new IntersectionObserver(function(entries) {
			entries.forEach(entry => {
				if (entry.isIntersecting) {
					entry.target.classList.add('aos-animate');
				}
			});
		}, observerOptions);

		document.querySelectorAll('[data-aos]').forEach(el => {
			observer.observe(el);
		});
	});
</script>
