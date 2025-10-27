<?php
// User login check
if(empty($_SESSION["uyeID"]))
{
	?>
	<meta http-equiv="refresh" content="0;url=<?=SITE?>uyelik">
	<?php
	exit();
}

$uyeID=$VT->filter($_SESSION["uyeID"]);
$uyebilgisi=$VT->VeriGetir("uyeler","WHERE ID=? AND durum=?",array($uyeID,1),"ORDER BY ID ASC",1);
if($uyebilgisi==false)
{
	?>
	<meta http-equiv="refresh" content="0;url=<?=SITE?>uyelik">
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
			<h1 class="breadcumb-title">Yorum Gonder</h1>
			<ul class="breadcumb-menu-style1 mx-auto">
				<li><a href="<?=SITE?>">Anasayfa</a></li>
				<li class="active">Yorum Gonder</li>
			</ul>
		</div>
	</div>
</div>

<!--==============================
Review Form Section
============================== -->
<section class="space-top space-md-bottom review-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xl-8 col-lg-10">
				<!-- Review Card -->
				<div class="review-card" data-aos="fade-up">
					<div class="review-card-header">
						<div class="review-icon">
							<i class="far fa-comment-alt-edit"></i>
						</div>
						<h3>Gorusunuzu Paylasin</h3>
						<p>Deneyiminizi bizimle paylasin. Yorumunuz onaylandiktan sonra sitede yayinlanacaktir.</p>
					</div>

					<?php
					// Review Processing
					$formSubmitted = false;
					$submitSuccess = false;

					if($_POST)
					{
						if(!empty($_POST["yorum_gonder"]))
						{
							$formSubmitted = true;
							$ad_soyad = $VT->filter($_POST["ad_soyad"]);
							$yorum = $VT->filter($_POST["yorum"]);
							$puan = intval($_POST["puan"]);

							if(!empty($ad_soyad) && !empty($yorum) && $puan >= 1 && $puan <= 5)
							{
								$ekle = $VT->SorguCalistir("INSERT INTO testimonials", "SET uyeID=?, ad_soyad=?, yorum=?, puan=?, onay_durumu=?, durum=?, tarih=NOW()", array($uyeID, $ad_soyad, $yorum, $puan, "beklemede", 0));

								if($ekle)
								{
									$submitSuccess = true;
									?>
									<div class="alert-modern alert-success">
										<div class="alert-icon">
											<i class="far fa-check-circle"></i>
										</div>
										<div class="alert-content">
											<h5>Basarili!</h5>
											<p>Yorumunuz basariyla gonderildi! Admin onayindan sonra yayinlanacaktir.</p>
										</div>
									</div>
									<?php
								}
								else
								{
									?>
									<div class="alert-modern alert-danger">
										<div class="alert-icon">
											<i class="far fa-exclamation-triangle"></i>
										</div>
										<div class="alert-content">
											<h5>Hata!</h5>
											<p>Yorum gonderilirken bir hata olustu. Lutfen tekrar deneyin.</p>
										</div>
									</div>
									<?php
								}
							}
							else
							{
								?>
								<div class="alert-modern alert-warning">
									<div class="alert-icon">
										<i class="far fa-exclamation-circle"></i>
									</div>
									<div class="alert-content">
										<h5>Uyari!</h5>
										<p>Lutfen tum alanlari doldurun ve gecerli bir puan verin.</p>
									</div>
								</div>
								<?php
							}
						}
					}

					// Get user name
					$userName = "";
					if($uyebilgisi[0]["tipi"]==1) {
						$userName = stripslashes($uyebilgisi[0]["ad"]." ".$uyebilgisi[0]["soyad"]);
					} else {
						$userName = stripslashes($uyebilgisi[0]["firmaadi"]);
					}
					?>

					<form action="#" method="post" class="review-form" id="reviewForm">
						<input type="hidden" name="yorum_gonder" value="1">

						<!-- Name Field -->
						<div class="form-group-review">
							<label for="ad_soyad">
								<i class="far fa-user me-2"></i>Adiniz Soyadiniz *
							</label>
							<div class="input-group-review">
								<input type="text"
									   name="ad_soyad"
									   id="ad_soyad"
									   class="form-control-review"
									   value="<?=$userName?>"
									   placeholder="Adinizi ve soyadinizi girin"
									   required>
							</div>
						</div>

						<!-- Rating Field -->
						<div class="form-group-review">
							<label>
								<i class="far fa-star me-2"></i>Puan Verin *
							</label>
							<div class="star-rating-wrapper">
								<div class="star-rating" id="starRating">
									<input type="radio" name="puan" value="5" id="star5" required>
									<label for="star5" title="Mukemmel - 5 yildiz">
										<i class="far fa-star"></i>
									</label>

									<input type="radio" name="puan" value="4" id="star4">
									<label for="star4" title="Cok iyi - 4 yildiz">
										<i class="far fa-star"></i>
									</label>

									<input type="radio" name="puan" value="3" id="star3">
									<label for="star3" title="Iyi - 3 yildiz">
										<i class="far fa-star"></i>
									</label>

									<input type="radio" name="puan" value="2" id="star2">
									<label for="star2" title="Orta - 2 yildiz">
										<i class="far fa-star"></i>
									</label>

									<input type="radio" name="puan" value="1" id="star1">
									<label for="star1" title="Zayif - 1 yildiz">
										<i class="far fa-star"></i>
									</label>
								</div>
								<div class="rating-text" id="ratingText">
									<span class="rating-label">Puan Seciniz</span>
								</div>
							</div>
							<div class="rating-description">
								<small><i class="far fa-info-circle me-1"></i>Lutfen deneyiminizi yansitan puani secin</small>
							</div>
						</div>

						<!-- Comment Field -->
						<div class="form-group-review">
							<label for="yorum">
								<i class="far fa-comment me-2"></i>Yorumunuz *
							</label>
							<div class="textarea-wrapper">
								<textarea name="yorum"
										  id="yorum"
										  rows="6"
										  class="form-control-review"
										  placeholder="Urunlerimiz ve hizmetimiz hakkindaki goruslerinizi detayli olarak payllasin..."
										  required></textarea>
								<div class="char-counter">
									<span id="charCount">0</span> / 500 karakter
								</div>
							</div>
						</div>

						<!-- Submit Button -->
						<div class="form-actions">
							<button type="submit" class="btn-review-submit" id="submitBtn">
								<span class="btn-text">
									<i class="far fa-paper-plane me-2"></i>Yorum Gonder
								</span>
								<span class="btn-loader" style="display: none;">
									<i class="far fa-spinner fa-spin"></i>Gonderiliyor...
								</span>
							</button>
						</div>
					</form>

					<!-- Info Section -->
					<div class="review-info-section">
						<h4 class="info-title">
							<i class="far fa-info-circle me-2"></i>Onemli Notlar
						</h4>
						<ul class="info-list">
							<li>
								<i class="far fa-check-circle"></i>
								<span>Yorumunuz admin onayindan sonra yayinlanacaktir</span>
							</li>
							<li>
								<i class="far fa-check-circle"></i>
								<span>Sadece uye kullanicilar yorum gonderebilir</span>
							</li>
							<li>
								<i class="far fa-check-circle"></i>
								<span>Uygunsuz yorumlar yayinlanmayacaktir</span>
							</li>
							<li>
								<i class="far fa-check-circle"></i>
								<span>Yorumunuz ana sayfada sergılenecektir</span>
							</li>
						</ul>
					</div>
				</div>

				<!-- Success Animation -->
				<?php if($submitSuccess) { ?>
				<div class="success-overlay" id="successOverlay">
					<div class="success-animation">
						<div class="success-checkmark">
							<div class="check-icon">
								<span class="icon-line line-tip"></span>
								<span class="icon-line line-long"></span>
								<div class="icon-circle"></div>
								<div class="icon-fix"></div>
							</div>
						</div>
						<h3>Tesekkurler!</h3>
						<p>Yorumunuz basariyla alindi</p>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</section>

<style>
	/* Review Section */
	.review-section {
		background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
		position: relative;
	}

	/* Review Card */
	.review-card {
		background: #fff;
		border-radius: 25px;
		padding: 50px 40px;
		box-shadow: 0 10px 50px rgba(0,0,0,0.1);
		position: relative;
		overflow: hidden;
		animation: fadeInUp 0.6s ease-out;
	}
	.review-card::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		height: 5px;
		background: linear-gradient(90deg, #76a713 0%, #5a8010 100%);
	}

	/* Review Card Header */
	.review-card-header {
		text-align: center;
		margin-bottom: 40px;
		animation: fadeInDown 0.6s ease-out;
	}
	.review-icon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 100px;
		height: 100px;
		border-radius: 50%;
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		color: #fff;
		font-size: 45px;
		margin-bottom: 25px;
		box-shadow: 0 10px 30px rgba(118, 167, 19, 0.4);
		animation: bounceIn 0.8s ease-out;
		position: relative;
	}
	.review-icon::after {
		content: '';
		position: absolute;
		width: 120%;
		height: 120%;
		border-radius: 50%;
		border: 2px solid #76a713;
		opacity: 0.3;
		animation: pulse 2s infinite;
	}
	.review-card-header h3 {
		font-size: 32px;
		font-weight: 700;
		color: #2c3e50;
		margin-bottom: 15px;
	}
	.review-card-header p {
		font-size: 15px;
		color: #6c757d;
		line-height: 1.6;
		max-width: 600px;
		margin: 0 auto;
	}

	/* Form Groups */
	.form-group-review {
		margin-bottom: 30px;
	}
	.form-group-review label {
		display: block;
		font-size: 15px;
		font-weight: 600;
		color: #2c3e50;
		margin-bottom: 12px;
	}
	.input-group-review {
		position: relative;
	}
	.form-control-review {
		width: 100%;
		padding: 16px 20px;
		border: 2px solid #e8e8e8;
		border-radius: 12px;
		font-size: 15px;
		font-weight: 500;
		color: #2c3e50;
		background: #f8f9fa;
		transition: all 0.3s ease;
	}
	.form-control-review:focus {
		outline: none;
		border-color: #76a713;
		background: #fff;
		box-shadow: 0 0 0 4px rgba(118, 167, 19, 0.1);
	}
	textarea.form-control-review {
		resize: vertical;
		min-height: 150px;
	}

	/* Star Rating */
	.star-rating-wrapper {
		display: flex;
		align-items: center;
		gap: 20px;
		padding: 20px;
		background: #f8f9fa;
		border-radius: 12px;
		border: 2px solid #e8e8e8;
	}
	.star-rating {
		display: flex;
		flex-direction: row-reverse;
		justify-content: flex-end;
		gap: 8px;
	}
	.star-rating input {
		display: none;
	}
	.star-rating label {
		cursor: pointer;
		font-size: 40px;
		color: #ddd;
		transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
		position: relative;
	}
	.star-rating label:hover {
		transform: scale(1.2) rotate(10deg);
	}
	.star-rating label i {
		transition: all 0.3s ease;
	}

	/* Star Rating States */
	.star-rating input:checked ~ label i,
	.star-rating label:hover i,
	.star-rating label:hover ~ label i {
		color: #ffc107;
		-webkit-text-stroke: 1px #ff9800;
	}
	.star-rating input:checked ~ label {
		animation: starPop 0.4s ease-out;
	}

	/* Rating Text */
	.rating-text {
		flex: 1;
		padding-left: 20px;
		border-left: 2px solid #e8e8e8;
	}
	.rating-label {
		font-size: 18px;
		font-weight: 600;
		color: #6c757d;
		transition: all 0.3s ease;
	}
	.rating-text.rated .rating-label {
		color: #76a713;
	}
	.rating-description {
		margin-top: 10px;
	}
	.rating-description small {
		color: #6c757d;
		font-size: 13px;
	}

	/* Textarea Wrapper */
	.textarea-wrapper {
		position: relative;
	}
	.char-counter {
		position: absolute;
		bottom: 12px;
		right: 15px;
		font-size: 12px;
		color: #6c757d;
		background: rgba(255,255,255,0.9);
		padding: 4px 8px;
		border-radius: 6px;
	}
	#charCount {
		font-weight: 700;
		color: #76a713;
	}

	/* Submit Button */
	.form-actions {
		text-align: center;
		padding-top: 20px;
	}
	.btn-review-submit {
		min-width: 250px;
		padding: 18px 40px;
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		color: #fff;
		border: none;
		border-radius: 50px;
		font-size: 18px;
		font-weight: 700;
		cursor: pointer;
		transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
		box-shadow: 0 8px 25px rgba(118, 167, 19, 0.4);
		position: relative;
		overflow: hidden;
	}
	.btn-review-submit::before {
		content: '';
		position: absolute;
		top: 0;
		left: -100%;
		width: 100%;
		height: 100%;
		background: rgba(255,255,255,0.2);
		transition: left 0.6s ease;
	}
	.btn-review-submit:hover::before {
		left: 100%;
	}
	.btn-review-submit:hover {
		transform: translateY(-3px);
		box-shadow: 0 12px 35px rgba(118, 167, 19, 0.5);
	}
	.btn-review-submit:active {
		transform: translateY(-1px);
	}

	/* Info Section */
	.review-info-section {
		margin-top: 50px;
		padding: 30px;
		background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
		border-radius: 15px;
		border: 2px dashed #76a713;
	}
	.info-title {
		font-size: 18px;
		font-weight: 700;
		color: #2c3e50;
		margin-bottom: 20px;
	}
	.info-list {
		list-style: none;
		padding: 0;
		margin: 0;
	}
	.info-list li {
		display: flex;
		align-items: center;
		gap: 12px;
		padding: 12px 0;
		font-size: 14px;
		color: #495057;
		transition: all 0.3s ease;
	}
	.info-list li:hover {
		padding-left: 10px;
		color: #76a713;
	}
	.info-list li i {
		font-size: 18px;
		color: #76a713;
		flex-shrink: 0;
	}

	/* Alerts */
	.alert-modern {
		display: flex;
		gap: 20px;
		padding: 25px;
		border-radius: 15px;
		margin-bottom: 30px;
		animation: slideDown 0.5s ease-out;
		border: 2px solid;
	}
	.alert-icon {
		flex-shrink: 0;
		width: 50px;
		height: 50px;
		display: flex;
		align-items: center;
		justify-content: center;
		border-radius: 50%;
		font-size: 24px;
	}
	.alert-content h5 {
		font-size: 18px;
		font-weight: 700;
		margin: 0 0 8px 0;
	}
	.alert-content p {
		margin: 0;
		font-size: 14px;
		line-height: 1.5;
	}
	.alert-success {
		background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
		border-color: #28a745;
	}
	.alert-success .alert-icon {
		background: #28a745;
		color: #fff;
	}
	.alert-success .alert-content h5,
	.alert-success .alert-content p {
		color: #155724;
	}
	.alert-danger {
		background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
		border-color: #dc3545;
	}
	.alert-danger .alert-icon {
		background: #dc3545;
		color: #fff;
	}
	.alert-danger .alert-content h5,
	.alert-danger .alert-content p {
		color: #721c24;
	}
	.alert-warning {
		background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
		border-color: #ffc107;
	}
	.alert-warning .alert-icon {
		background: #ffc107;
		color: #856404;
	}
	.alert-warning .alert-content h5,
	.alert-warning .alert-content p {
		color: #856404;
	}

	/* Success Overlay */
	.success-overlay {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: rgba(0,0,0,0.8);
		display: flex;
		align-items: center;
		justify-content: center;
		z-index: 9999;
		animation: fadeIn 0.3s ease-out;
	}
	.success-animation {
		text-align: center;
		color: #fff;
	}
	.success-checkmark {
		margin-bottom: 30px;
	}
	.check-icon {
		width: 80px;
		height: 80px;
		position: relative;
		border-radius: 50%;
		box-sizing: content-box;
		border: 4px solid #4CAF50;
		margin: 0 auto;
		animation: scaleIn 0.5s ease-out;
	}
	.check-icon::before {
		top: 3px;
		left: -2px;
		width: 30px;
		transform-origin: 100% 50%;
		border-radius: 100px 0 0 100px;
	}
	.check-icon::after {
		top: 0;
		left: 30px;
		width: 60px;
		transform-origin: 0 50%;
		border-radius: 0 100px 100px 0;
		animation: rotateCircle 4.25s ease-in;
	}
	.icon-line {
		height: 5px;
		background-color: #4CAF50;
		display: block;
		border-radius: 2px;
		position: absolute;
		z-index: 10;
	}
	.icon-line.line-tip {
		top: 46px;
		left: 14px;
		width: 25px;
		transform: rotate(45deg);
		animation: checkTip 0.75s 0.3s ease-out forwards;
	}
	.icon-line.line-long {
		top: 38px;
		right: 8px;
		width: 47px;
		transform: rotate(-45deg);
		animation: checkLong 0.75s 0.6s ease-out forwards;
	}
	.icon-circle {
		top: -4px;
		left: -4px;
		z-index: 10;
		width: 80px;
		height: 80px;
		border-radius: 50%;
		position: absolute;
		box-sizing: content-box;
		border: 4px solid rgba(76, 175, 80, .5);
	}
	.icon-fix {
		top: 8px;
		width: 5px;
		left: 26px;
		z-index: 1;
		height: 85px;
		position: absolute;
		transform: rotate(-45deg);
		background-color: #fff;
	}
	.success-animation h3 {
		font-size: 32px;
		font-weight: 700;
		margin-bottom: 10px;
	}
	.success-animation p {
		font-size: 16px;
		opacity: 0.9;
	}

	/* Animations */
	@keyframes fadeInUp {
		from {
			opacity: 0;
			transform: translateY(30px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}
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
	@keyframes starPop {
		0% {
			transform: scale(1);
		}
		50% {
			transform: scale(1.3) rotate(15deg);
		}
		100% {
			transform: scale(1);
		}
	}
	@keyframes fadeIn {
		from { opacity: 0; }
		to { opacity: 1; }
	}
	@keyframes scaleIn {
		from {
			transform: scale(0);
		}
		to {
			transform: scale(1);
		}
	}
	@keyframes checkTip {
		0% {
			width: 0;
			left: 1px;
			top: 19px;
		}
		54% {
			width: 0;
			left: 1px;
			top: 19px;
		}
		70% {
			width: 50px;
			left: -8px;
			top: 37px;
		}
		84% {
			width: 17px;
			left: 21px;
			top: 48px;
		}
		100% {
			width: 25px;
			left: 14px;
			top: 45px;
		}
	}
	@keyframes checkLong {
		0% {
			width: 0;
			right: 46px;
			top: 54px;
		}
		65% {
			width: 0;
			right: 46px;
			top: 54px;
		}
		84% {
			width: 55px;
			right: 0px;
			top: 35px;
		}
		100% {
			width: 47px;
			right: 8px;
			top: 38px;
		}
	}

	/* AOS Animation */
	[data-aos="fade-up"] {
		opacity: 0;
		transform: translateY(30px);
		transition: opacity 0.6s ease-out, transform 0.6s ease-out;
	}
	[data-aos="fade-up"].aos-animate {
		opacity: 1;
		transform: translateY(0);
	}

	/* Responsive */
	@media (max-width: 768px) {
		.review-card {
			padding: 40px 25px;
		}
		.review-icon {
			width: 80px;
			height: 80px;
			font-size: 35px;
		}
		.review-card-header h3 {
			font-size: 26px;
		}
		.star-rating-wrapper {
			flex-direction: column;
			gap: 15px;
		}
		.rating-text {
			border-left: none;
			border-top: 2px solid #e8e8e8;
			padding-left: 0;
			padding-top: 15px;
			width: 100%;
		}
		.star-rating label {
			font-size: 32px;
		}
		.btn-review-submit {
			width: 100%;
		}
	}
</style>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Star Rating
		const starInputs = document.querySelectorAll('.star-rating input');
		const ratingText = document.getElementById('ratingText');
		const ratingLabels = {
			5: 'Mukemmel',
			4: 'Cok Iyi',
			3: 'Iyi',
			2: 'Orta',
			1: 'Zayif'
		};

		starInputs.forEach(input => {
			input.addEventListener('change', function() {
				const value = this.value;
				const label = ratingText.querySelector('.rating-label');
				label.textContent = ratingLabels[value];
				ratingText.classList.add('rated');
			});
		});

		// Character Counter
		const textarea = document.getElementById('yorum');
		const charCount = document.getElementById('charCount');

		if(textarea && charCount) {
			textarea.addEventListener('input', function() {
				const count = this.value.length;
				charCount.textContent = count;

				if(count > 500) {
					charCount.style.color = '#dc3545';
					this.value = this.value.substring(0, 500);
				} else {
					charCount.style.color = '#76a713';
				}
			});
		}

		// Form Submit Animation
		const form = document.getElementById('reviewForm');
		const submitBtn = document.getElementById('submitBtn');

		if(form && submitBtn) {
			form.addEventListener('submit', function(e) {
				const btnText = submitBtn.querySelector('.btn-text');
				const btnLoader = submitBtn.querySelector('.btn-loader');

				btnText.style.display = 'none';
				btnLoader.style.display = 'inline-block';
				submitBtn.disabled = true;
			});
		}

		// Success Overlay Auto Close
		const successOverlay = document.getElementById('successOverlay');
		if(successOverlay) {
			setTimeout(() => {
				successOverlay.style.animation = 'fadeOut 0.3s ease-out';
				setTimeout(() => {
					successOverlay.remove();
				}, 300);
			}, 3000);
		}

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

	// Add fadeOut animation
	const style = document.createElement('style');
	style.textContent = `
		@keyframes fadeOut {
			from { opacity: 1; }
			to { opacity: 0; }
		}
	`;
	document.head.appendChild(style);
</script>
