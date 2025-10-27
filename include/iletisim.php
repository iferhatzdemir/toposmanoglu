<!--==============================
Breadcumb
============================== -->
<div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/breadcumb/breadcumb-img-1.jpg">
	<div class="container">
		<div class="breadcumb-content text-center">
			<h1 class="breadcumb-title">Iletisim</h1>
			<ul class="breadcumb-menu-style1 mx-auto">
				<li><a href="<?=SITE?>">Anasayfa</a></li>
				<li class="active">Iletisim</li>
			</ul>
		</div>
	</div>
</div>

<!--==============================
	Contact Info Boxes
==============================-->
<section class="space-top">
	<div class="container">
		<div class="row text-center mb-60">
			<div class="col-12">
				<h2 class="sec-title4 mb-3">Bize Ulasin</h2>
				<p class="sec-text">Soru ve talepleriniz icin bizimle iletisime gecebilirsiniz.</p>
			</div>
		</div>
		<div class="row justify-content-center">
			<!-- Phone Box -->
			<div class="col-lg-4 col-md-6 mb-4">
				<div class="contact-info-box text-center">
					<div class="contact-icon">
						<i class="far fa-phone-alt"></i>
					</div>
					<h4 class="contact-title">Telefon</h4>
					<div class="contact-content">
						<a href="tel:<?=$sitetelefon?>" class="contact-link"><?=$sitetelefon?></a>
						<?php if(!empty($sitetelefon2)){ ?>
							<br><a href="tel:<?=$sitetelefon2?>" class="contact-link"><?=$sitetelefon2?></a>
						<?php } ?>
						<?php if(!empty($sitefax)){ ?>
							<br><small class="text-muted">Fax: <?=$sitefax?></small>
						<?php } ?>
					</div>
				</div>
			</div>

			<!-- Address Box -->
			<div class="col-lg-4 col-md-6 mb-4">
				<div class="contact-info-box text-center">
					<div class="contact-icon">
						<i class="far fa-map-marker-alt"></i>
					</div>
					<h4 class="contact-title">Adres</h4>
					<div class="contact-content">
						<p><?=$siteadres?></p>
					</div>
				</div>
			</div>

			<!-- Email Box -->
			<div class="col-lg-4 col-md-6 mb-4">
				<div class="contact-info-box text-center">
					<div class="contact-icon">
						<i class="far fa-envelope"></i>
					</div>
					<h4 class="contact-title">E-Mail</h4>
					<div class="contact-content">
						<a href="mailto:<?=$sitemail?>" class="contact-link"><?=$sitemail?></a>
						<?php if(!empty($sitemail2)){ ?>
							<br><a href="mailto:<?=$sitemail2?>" class="contact-link"><?=$sitemail2?></a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!--==============================
	Contact Form & Map
==============================-->
<section class="space-bottom">
	<div class="container">
		<div class="row">
			<!-- Contact Form -->
			<div class="col-lg-5 col-md-12 mb-4">
				<div class="contact-form-wrapper bg-white p-4 p-md-5 shadow-sm rounded">
					<h3 class="sec-subtitle mb-4">
						<i class="far fa-paper-plane me-2"></i>Mesaj Gonder
					</h3>

					<?php
					if($_POST)
					{
						if(!empty($_POST["adsoyad"]) && !empty($_POST["mail"]) && !empty($_POST["mesaj"]) && !empty($_POST["telefon"]))
						{
							$adsoyad=$VT->filter($_POST["adsoyad"]);
							$mail=$VT->filter($_POST["mail"]);
							$telefon=$VT->filter($_POST["telefon"]);
							$mesaj=$VT->filter($_POST["mesaj"]);
							$mesajdetay="Ad Soyad : ".$adsoyad."<br>
							E-Mail : ".$mail."<br>
							Telefon : ".$telefon."<br>
							Mesaj : ".$mesaj."";
							$kaydet=$VT->SorguCalistir("INSERT INTO mesajlar","SET adsoyad=?, mail=?, telefon=?, metin=?, durum=?, tarih=?",array($adsoyad,$mail,$telefon,$mesaj,1,date("Y-m-d")));
							$mailgonder=$VT->MailGonder($sitemail,"Websitenizden Yeni Mesaj Var!",$mesajdetay);
							?>
							<div class="alert alert-success alert-dismissible fade show" role="alert">
								<i class="far fa-check-circle me-2"></i>Mesajiniz basariyla gonderilmistir. En kisa surede size donecegiz.
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
					?>

					<form action="#" method="post" id="contactForm">
						<div class="mb-3">
							<label class="form-label">Adi Soyadi <span class="text-danger">*</span></label>
							<div class="input-group">
								<span class="input-group-text"><i class="far fa-user"></i></span>
								<input type="text" class="form-control" name="adsoyad" placeholder="Adiniz ve soyadiniz" required>
							</div>
						</div>

						<div class="mb-3">
							<label class="form-label">E-Mail <span class="text-danger">*</span></label>
							<div class="input-group">
								<span class="input-group-text"><i class="far fa-envelope"></i></span>
								<input type="email" class="form-control" name="mail" placeholder="ornek@mail.com" required>
							</div>
						</div>

						<div class="mb-3">
							<label class="form-label">Telefon <span class="text-danger">*</span></label>
							<div class="input-group">
								<span class="input-group-text"><i class="far fa-phone"></i></span>
								<input type="text" class="form-control" name="telefon" placeholder="5XX XXX XX XX" required>
							</div>
						</div>

						<div class="mb-3">
							<label class="form-label">Mesajiniz <span class="text-danger">*</span></label>
							<textarea class="form-control" name="mesaj" rows="5" placeholder="Mesajinizi buraya yazin..." required></textarea>
						</div>

						<div class="alert alert-info border-0" style="font-size: 13px;">
							<i class="far fa-info-circle me-2"></i>Tum alanlar zorunludur. Mesajinizi aldigimizda en kisa surede size donecegiz.
						</div>

						<button type="submit" class="vs-btn style4 w-100">
							<i class="far fa-paper-plane me-2"></i>Mesaji Gonder
						</button>
					</form>
				</div>
			</div>

			<!-- Google Map -->
			<div class="col-lg-7 col-md-12 mb-4">
				<div class="map-wrapper shadow-sm rounded overflow-hidden">
					<iframe class="contact-map" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d56050.339548947275!2d29.01063997847854!3d41.01897027122958!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1str!2str!4v1593971552343!5m2!1str!2str" style="border: 0; width: 100%; height: 100%; min-height: 550px;" allowfullscreen loading="lazy"></iframe>
				</div>
			</div>
		</div>
	</div>
</section>

<!--==============================
	Why Contact Us Section
==============================-->
<section class="bg-light space-top space-bottom">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6 mb-4 mb-lg-0">
				<h3 class="sec-title4 mb-4">Neden Bizimle Iletisime Gecmelisiniz?</h3>
				<div class="why-contact-list">
					<div class="why-contact-item d-flex mb-3">
						<div class="why-icon">
							<i class="far fa-check-circle"></i>
						</div>
						<div class="why-content">
							<h5>Hizli Yanit Suresi</h5>
							<p>Mesajlariniza en gec 24 saat icinde donuyoruz.</p>
						</div>
					</div>
					<div class="why-contact-item d-flex mb-3">
						<div class="why-icon">
							<i class="far fa-headset"></i>
						</div>
						<div class="why-content">
							<h5>Profesyonel Destek</h5>
							<p>Uzman ekibimiz her zaman yardima hazir.</p>
						</div>
					</div>
					<div class="why-contact-item d-flex mb-3">
						<div class="why-icon">
							<i class="far fa-clock"></i>
						</div>
						<div class="why-content">
							<h5>7/24 Mesaj Aliyoruz</h5>
							<p>Istediginiz zaman mesaj gonderebilirsiniz.</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="contact-image-wrapper">
					<img src="<?=SITE?>assets/img/about/contact-support.jpg" alt="Iletisim" class="img-fluid rounded shadow-sm">
				</div>
			</div>
		</div>
	</div>
</section>

<!--==============================
	Working Hours
==============================-->
<section class="space-top space-bottom">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<div class="working-hours-box bg-white p-4 p-md-5 shadow-sm rounded text-center">
					<div class="working-icon mb-3">
						<i class="far fa-clock"></i>
					</div>
					<h3 class="sec-title4 mb-4">Calisma Saatlerimiz</h3>
					<div class="row">
						<div class="col-md-6 mb-3">
							<div class="working-day">
								<strong>Hafta Ici:</strong>
								<p class="mb-0">Pazartesi - Cuma<br>09:00 - 18:00</p>
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<div class="working-day">
								<strong>Hafta Sonu:</strong>
								<p class="mb-0">Cumartesi - Pazar<br>10:00 - 16:00</p>
							</div>
						</div>
					</div>
					<div class="alert alert-warning border-0 mt-4">
						<i class="far fa-exclamation-circle me-2"></i>
						Resmi tatil gunlerinde kapalidir.
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<style>
	.sec-title4 {
		font-size: 32px;
		color: #333;
		font-weight: 700;
	}
	.sec-text {
		font-size: 16px;
		color: #666;
		max-width: 600px;
		margin: 0 auto;
	}
	.sec-subtitle {
		font-size: 20px;
		font-weight: 700;
		color: #333;
		border-bottom: 2px solid #76a713;
		padding-bottom: 10px;
	}
	/* Contact Info Boxes */
	.contact-info-box {
		background: #fff;
		padding: 40px 30px;
		border-radius: 15px;
		box-shadow: 0 5px 20px rgba(0,0,0,0.08);
		transition: all 0.3s;
		height: 100%;
	}
	.contact-info-box:hover {
		transform: translateY(-10px);
		box-shadow: 0 15px 40px rgba(118, 167, 19, 0.15);
	}
	.contact-icon {
		width: 80px;
		height: 80px;
		line-height: 80px;
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		border-radius: 50%;
		margin: 0 auto 20px;
		transition: all 0.3s;
	}
	.contact-info-box:hover .contact-icon {
		transform: rotate(360deg);
	}
	.contact-icon i {
		font-size: 32px;
		color: #fff;
	}
	.contact-title {
		font-size: 22px;
		font-weight: 700;
		color: #333;
		margin-bottom: 15px;
	}
	.contact-content {
		font-size: 15px;
		color: #666;
	}
	.contact-link {
		color: #76a713;
		text-decoration: none;
		font-weight: 600;
		transition: all 0.3s;
	}
	.contact-link:hover {
		color: #5a8010;
		text-decoration: underline;
	}
	/* Contact Form */
	.contact-form-wrapper {
		height: 100%;
	}
	.form-label {
		font-size: 14px;
		color: #555;
		margin-bottom: 8px;
		font-weight: 600;
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
	.alert-warning {
		background: #fff3cd;
		color: #856404;
	}
	/* Map */
	.map-wrapper {
		height: 100%;
		min-height: 550px;
		position: relative;
	}
	/* Why Contact Section */
	.why-contact-item {
		background: #fff;
		padding: 20px;
		border-radius: 10px;
		box-shadow: 0 3px 10px rgba(0,0,0,0.05);
	}
	.why-icon {
		width: 50px;
		height: 50px;
		line-height: 50px;
		text-align: center;
		background: #76a713;
		border-radius: 50%;
		margin-right: 15px;
		flex-shrink: 0;
	}
	.why-icon i {
		font-size: 20px;
		color: #fff;
	}
	.why-content h5 {
		font-size: 16px;
		font-weight: 700;
		color: #333;
		margin-bottom: 5px;
	}
	.why-content p {
		font-size: 14px;
		color: #666;
		margin: 0;
	}
	.contact-image-wrapper img {
		max-height: 400px;
		object-fit: cover;
		width: 100%;
	}
	/* Working Hours */
	.working-hours-box {
		border: 2px solid #f0f0f0;
	}
	.working-icon {
		width: 100px;
		height: 100px;
		line-height: 100px;
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		border-radius: 50%;
		margin: 0 auto;
	}
	.working-icon i {
		font-size: 48px;
		color: #fff;
	}
	.working-day {
		background: #f8f9fa;
		padding: 20px;
		border-radius: 8px;
	}
	.working-day strong {
		font-size: 16px;
		color: #333;
		display: block;
		margin-bottom: 10px;
	}
	.working-day p {
		font-size: 14px;
		color: #666;
		line-height: 1.8;
	}
	@media (max-width: 768px) {
		.sec-title4 {
			font-size: 24px;
		}
		.sec-text {
			font-size: 14px;
		}
		.contact-info-box {
			padding: 30px 20px;
		}
		.contact-icon {
			width: 60px;
			height: 60px;
			line-height: 60px;
		}
		.contact-icon i {
			font-size: 24px;
		}
		.contact-title {
			font-size: 18px;
		}
		.map-wrapper {
			min-height: 300px;
		}
		.working-icon {
			width: 80px;
			height: 80px;
			line-height: 80px;
		}
		.working-icon i {
			font-size: 36px;
		}
	}
</style>

<script>
	// Form validation
	document.addEventListener('DOMContentLoaded', function() {
		const form = document.getElementById('contactForm');
		if(form) {
			form.addEventListener('submit', function(e) {
				const telefon = form.querySelector('[name="telefon"]');
				const telefonValue = telefon.value.replace(/\s/g, '');

				// Telefon numarası doğrulama (basit kontrol)
				if(telefonValue.length < 10) {
					e.preventDefault();
					alert('Lutfen gecerli bir telefon numarasi giriniz.');
					telefon.focus();
					return false;
				}
			});
		}
	});
</script>
