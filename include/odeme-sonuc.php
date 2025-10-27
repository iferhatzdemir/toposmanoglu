<?php
if(!empty($_SESSION["siparisKodu"]))
{
	$siparisKodu = $_SESSION["siparisKodu"];

	// Get order details
	$siparisBilgi = $VT->VeriGetir("siparisler","WHERE sipariskodu=?",array($siparisKodu),"ORDER BY ID DESC",1);
	?>

	<!--==============================
	Breadcumb
	============================== -->
	<div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/breadcumb/breadcumb-img-1.jpg">
		<div class="container">
			<div class="breadcumb-content text-center">
				<h1 class="breadcumb-title">Siparis Tamamlandi</h1>
				<ul class="breadcumb-menu-style1 mx-auto">
					<li><a href="<?=SITE?>">Anasayfa</a></li>
					<li><a href="<?=SITE?>sepet">Sepet</a></li>
					<li class="active">Siparis Sonuc</li>
				</ul>
			</div>
		</div>
	</div>

	<!--==============================
		Order Success Section
	==============================-->
	<section class="space-top space-md-bottom">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-9">
					<!-- Success Animation -->
					<div class="success-animation-wrapper text-center mb-5">
						<div class="success-checkmark">
							<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
								<circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"/>
								<path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
							</svg>
						</div>
						<h2 class="success-title mt-4 mb-3">Siparisiniz Basariyla Alindi!</h2>
						<p class="success-text mb-4">Siparişiniz başarıyla oluşturuldu ve ödemeniz onaylandı.</p>
						<div class="order-number-badge">
							<span class="badge-label">Siparis Numaraniz:</span>
							<span class="badge-number"><?=$siparisKodu?></span>
						</div>
					</div>

					<!-- Progress Steps -->
					<div class="order-progress-wrapper mb-5">
						<div class="progress-steps">
							<div class="progress-step completed">
								<div class="step-icon">
									<i class="far fa-check"></i>
								</div>
								<div class="step-label">Siparis Alindi</div>
							</div>
							<div class="progress-line completed"></div>
							<div class="progress-step active">
								<div class="step-icon">
									<i class="far fa-box"></i>
								</div>
								<div class="step-label">Hazirlaniyor</div>
							</div>
							<div class="progress-line"></div>
							<div class="progress-step">
								<div class="step-icon">
									<i class="far fa-truck"></i>
								</div>
								<div class="step-label">Kargoda</div>
							</div>
							<div class="progress-line"></div>
							<div class="progress-step">
								<div class="step-icon">
									<i class="far fa-home"></i>
								</div>
								<div class="step-label">Teslim Edildi</div>
							</div>
						</div>
					</div>

					<!-- Order Details Card -->
					<div class="order-details-card bg-white p-4 p-md-5 shadow-sm rounded mb-4">
						<h4 class="card-title mb-4">
							<i class="far fa-file-invoice me-2 text-success"></i>Siparis Detaylari
						</h4>
						<div class="row">
							<div class="col-md-6 mb-3">
								<div class="detail-box">
									<div class="detail-icon">
										<i class="far fa-barcode"></i>
									</div>
									<div class="detail-info">
										<span class="detail-label">Siparis Kodu</span>
										<span class="detail-value"><?=$siparisKodu?></span>
									</div>
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="detail-box">
									<div class="detail-icon">
										<i class="far fa-credit-card"></i>
									</div>
									<div class="detail-info">
										<span class="detail-label">Odeme Tutari</span>
										<span class="detail-value text-success">
											<?php
											if($siparisBilgi!=false) {
												echo number_format($siparisBilgi[0]["odenentutar"],2,",",".");
											}
											?> TL
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="detail-box">
									<div class="detail-icon">
										<i class="far fa-calendar-check"></i>
									</div>
									<div class="detail-info">
										<span class="detail-label">Siparis Tarihi</span>
										<span class="detail-value"><?=date("d.m.Y H:i")?></span>
									</div>
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<div class="detail-box">
									<div class="detail-icon">
										<i class="far fa-info-circle"></i>
									</div>
									<div class="detail-info">
										<span class="detail-label">Siparis Durumu</span>
										<span class="detail-value">
											<span class="badge badge-warning">Hazirlaniyor</span>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Information Boxes -->
					<div class="row mb-4">
						<div class="col-md-6 mb-3">
							<div class="info-card bg-light p-4 rounded h-100">
								<div class="info-icon mb-3">
									<i class="far fa-envelope-open-text"></i>
								</div>
								<h5 class="info-title mb-2">E-posta Gonderildi</h5>
								<p class="info-text mb-0">Siparis detaylari e-posta adresinize gonderilmistir.</p>
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<div class="info-card bg-light p-4 rounded h-100">
								<div class="info-icon mb-3">
									<i class="far fa-truck-loading"></i>
								</div>
								<h5 class="info-title mb-2">Kargo Sureci</h5>
								<p class="info-text mb-0">Siparisiz 1-3 is gunu icinde kargoya verilecektir.</p>
							</div>
						</div>
					</div>

					<!-- Action Buttons -->
					<div class="action-buttons-wrapper text-center mb-4">
						<a href="<?=SITE?>siparislerim" class="vs-btn style4 me-2 mb-2">
							<i class="far fa-shopping-bag me-2"></i>Siparislerime Git
						</a>
						<a href="<?=SITE?>siparis-detay/<?=$siparisKodu?>" class="vs-btn style7 me-2 mb-2">
							<i class="far fa-file-invoice me-2"></i>Siparis Detay
						</a>
						<a href="<?=SITE?>" class="vs-btn style8 mb-2">
							<i class="far fa-home me-2"></i>Alisverise Devam
						</a>
					</div>

					<!-- Thank You Box -->
					<div class="thank-you-box bg-white p-4 rounded shadow-sm text-center">
						<div class="thank-icon mb-3">
							<i class="far fa-heart"></i>
						</div>
						<h5 class="mb-3">Bizi Tercih Ettiginiz Icin Tesekkur Ederiz!</h5>
						<p class="mb-4 text-muted">Siparisiz ozenle hazirlaniyor. Sorulariniz icin musteri hizmetlerimizle iletisime gecebilirsiniz.</p>
						<div class="d-flex justify-content-center gap-3">
							<a href="<?=SITE?>iletisim" class="text-link">
								<i class="far fa-envelope me-2"></i>Iletisim
							</a>
							<a href="<?=SITE?>siparis-takip" class="text-link">
								<i class="far fa-search me-2"></i>Siparis Takip
							</a>
						</div>
					</div>

					<!-- Social Share -->
					<div class="social-share-box mt-4 text-center">
						<p class="mb-3">Arkadaslarinizla Paylasin:</p>
						<div class="social-buttons">
							<a href="#" class="social-btn facebook" title="Facebook">
								<i class="fab fa-facebook-f"></i>
							</a>
							<a href="#" class="social-btn twitter" title="Twitter">
								<i class="fab fa-twitter"></i>
							</a>
							<a href="#" class="social-btn whatsapp" title="WhatsApp">
								<i class="fab fa-whatsapp"></i>
							</a>
						</div>
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
		}
		.checkmark {
			width: 120px;
			height: 120px;
			border-radius: 50%;
			display: block;
			stroke-width: 3;
			stroke: #4caf50;
			stroke-miterlimit: 10;
			box-shadow: inset 0px 0px 0px #4caf50;
			animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
		}
		.checkmark-circle {
			stroke-dasharray: 166;
			stroke-dashoffset: 166;
			stroke-width: 3;
			stroke-miterlimit: 10;
			stroke: #4caf50;
			fill: none;
			animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
		}
		.checkmark-check {
			transform-origin: 50% 50%;
			stroke-dasharray: 48;
			stroke-dashoffset: 48;
			stroke: #4caf50;
			animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
		}
		@keyframes stroke {
			100% { stroke-dashoffset: 0; }
		}
		@keyframes scale {
			0%, 100% { transform: none; }
			50% { transform: scale3d(1.1, 1.1, 1); }
		}
		@keyframes fill {
			100% { box-shadow: inset 0px 0px 0px 30px #4caf50; }
		}

		/* Success Title */
		.success-title {
			font-size: 32px;
			font-weight: 700;
			color: #333;
		}
		.success-text {
			font-size: 16px;
			color: #666;
		}
		.order-number-badge {
			display: inline-flex;
			flex-direction: column;
			background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
			color: #fff;
			padding: 15px 30px;
			border-radius: 10px;
			box-shadow: 0 5px 20px rgba(118, 167, 19, 0.3);
		}
		.badge-label {
			font-size: 12px;
			opacity: 0.9;
			margin-bottom: 5px;
		}
		.badge-number {
			font-size: 24px;
			font-weight: 700;
			letter-spacing: 2px;
		}

		/* Progress Steps */
		.order-progress-wrapper {
			background: #fff;
			padding: 40px 30px;
			border-radius: 10px;
			box-shadow: 0 3px 15px rgba(0,0,0,0.08);
		}
		.progress-steps {
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		.progress-step {
			display: flex;
			flex-direction: column;
			align-items: center;
			position: relative;
			z-index: 2;
		}
		.step-icon {
			width: 60px;
			height: 60px;
			background: #e9ecef;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			margin-bottom: 10px;
			transition: all 0.3s;
		}
		.step-icon i {
			font-size: 24px;
			color: #999;
		}
		.progress-step.completed .step-icon {
			background: #4caf50;
		}
		.progress-step.completed .step-icon i {
			color: #fff;
		}
		.progress-step.active .step-icon {
			background: #76a713;
			animation: pulse 2s infinite;
		}
		.progress-step.active .step-icon i {
			color: #fff;
		}
		@keyframes pulse {
			0%, 100% { box-shadow: 0 0 0 0 rgba(118, 167, 19, 0.7); }
			50% { box-shadow: 0 0 0 10px rgba(118, 167, 19, 0); }
		}
		.step-label {
			font-size: 13px;
			color: #666;
			font-weight: 600;
			text-align: center;
		}
		.progress-line {
			flex: 1;
			height: 3px;
			background: #e9ecef;
			position: relative;
			top: -35px;
		}
		.progress-line.completed {
			background: #4caf50;
		}

		/* Order Details Card */
		.order-details-card {
			border: 1px solid #e8e8e8;
		}
		.card-title {
			color: #333;
			font-weight: 700;
			border-bottom: 2px solid #4caf50;
			padding-bottom: 15px;
		}
		.detail-box {
			display: flex;
			align-items: center;
			padding: 20px;
			background: #f8f9fa;
			border-radius: 10px;
			border: 2px solid #e9ecef;
			transition: all 0.3s;
		}
		.detail-box:hover {
			border-color: #76a713;
			transform: translateY(-2px);
		}
		.detail-icon {
			width: 50px;
			height: 50px;
			background: #76a713;
			border-radius: 10px;
			display: flex;
			align-items: center;
			justify-content: center;
			margin-right: 15px;
			flex-shrink: 0;
		}
		.detail-icon i {
			font-size: 22px;
			color: #fff;
		}
		.detail-info {
			display: flex;
			flex-direction: column;
		}
		.detail-label {
			font-size: 12px;
			color: #666;
			margin-bottom: 5px;
		}
		.detail-value {
			font-size: 16px;
			color: #333;
			font-weight: 700;
		}
		.badge-warning {
			background: #ff9800;
			color: #fff;
			padding: 5px 12px;
			border-radius: 6px;
			font-size: 12px;
		}

		/* Info Cards */
		.info-card {
			border: 2px solid #e9ecef;
			transition: all 0.3s;
		}
		.info-card:hover {
			border-color: #76a713;
			transform: translateY(-3px);
		}
		.info-icon {
			font-size: 40px;
			color: #76a713;
		}
		.info-title {
			font-size: 18px;
			font-weight: 700;
			color: #333;
		}
		.info-text {
			font-size: 14px;
			color: #666;
		}

		/* Action Buttons */
		.action-buttons-wrapper {
			padding: 30px 0;
		}
		.vs-btn.style8 {
			background: #6c757d;
			color: #fff;
		}
		.vs-btn.style8:hover {
			background: #5a6268;
		}

		/* Thank You Box */
		.thank-you-box {
			border: 2px solid #e8e8e8;
		}
		.thank-icon {
			font-size: 50px;
			color: #e91e63;
		}
		.thank-you-box h5 {
			color: #333;
			font-weight: 700;
		}
		.text-link {
			color: #76a713;
			text-decoration: none;
			font-weight: 600;
			transition: all 0.3s;
		}
		.text-link:hover {
			color: #5a8010;
		}

		/* Social Share */
		.social-share-box p {
			color: #666;
			font-size: 14px;
		}
		.social-buttons {
			display: flex;
			justify-content: center;
			gap: 15px;
		}
		.social-btn {
			width: 45px;
			height: 45px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			color: #fff;
			font-size: 18px;
			transition: all 0.3s;
		}
		.social-btn:hover {
			transform: translateY(-3px);
		}
		.social-btn.facebook {
			background: #3b5998;
		}
		.social-btn.twitter {
			background: #1da1f2;
		}
		.social-btn.whatsapp {
			background: #25d366;
		}

		/* Responsive */
		@media (max-width: 768px) {
			.success-checkmark {
				width: 100px;
				height: 100px;
			}
			.checkmark {
				width: 100px;
				height: 100px;
			}
			.success-title {
				font-size: 24px;
			}
			.success-text {
				font-size: 14px;
			}
			.badge-number {
				font-size: 20px;
			}
			.progress-steps {
				flex-wrap: wrap;
			}
			.progress-step {
				flex: 0 0 50%;
				margin-bottom: 30px;
			}
			.progress-line {
				display: none;
			}
			.step-icon {
				width: 50px;
				height: 50px;
			}
			.step-icon i {
				font-size: 20px;
			}
			.detail-box {
				padding: 15px;
			}
			.detail-icon {
				width: 40px;
				height: 40px;
			}
			.detail-icon i {
				font-size: 18px;
			}
		}
	</style>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// Print order option
			const printBtn = document.createElement('button');
			printBtn.className = 'vs-btn style7 btn-sm d-print-none';
			printBtn.innerHTML = '<i class="far fa-print me-2"></i>Yazdir';
			printBtn.onclick = function() {
				window.print();
			};

			// Add print button to action buttons
			const actionButtons = document.querySelector('.action-buttons-wrapper');
			if(actionButtons) {
				actionButtons.appendChild(printBtn);
			}

			// Confetti effect (simple version)
			console.log('Order completed successfully! 🎉');
		});
	</script>

	<?php
}
else
{
	?>
	<meta http-equiv="refresh" content="0;url=<?=SITE?>hesabim">
	<?php
}
?>
