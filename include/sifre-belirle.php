<?php
if(!empty($_SESSION["uyeninSifresiIcinID"]) && !empty($_SESSION["dogrulamaKodu"]))
{
?>

<!--==============================
Breadcumb
============================== -->
<div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/breadcumb/breadcumb-img-1.jpg">
	<div class="container">
		<div class="breadcumb-content text-center">
			<h1 class="breadcumb-title">Sifre Sifirlama</h1>
			<ul class="breadcumb-menu-style1 mx-auto">
				<li><a href="<?=SITE?>">Anasayfa</a></li>
				<li class="active">Sifre Belirle</li>
			</ul>
		</div>
	</div>
</div>

<!--==============================
Password Reset Section
============================== -->
<section class="space-top space-md-bottom">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xl-6 col-lg-7 col-md-9">
				<?php
				if(!empty($_GET["seflink"]))
				{
					$islemtipi=$VT->filter($_GET["seflink"]);

					// STEP 1: Verification Code
					if($islemtipi=="dogulama")
					{
						if($_POST)
						{
							if(!empty($_POST["kod"]) && $_POST["kod"]==$_SESSION["dogrulamaKodu"])
							{
								$_SESSION["guvenlikKilidi"]="OK";
								?>
								<meta http-equiv="refresh" content="0;url=<?=SITE?>sifre-belirle/sifreIste">
								<?php
							}
							else
							{
								?>
								<div class="alert alert-danger alert-modern mb-4">
									<i class="far fa-exclamation-circle me-2"></i>Dogrulama kodu hatali! Lutfen tekrar deneyin.
								</div>
								<?php
							}
						}
						?>

						<!-- Verification Card -->
						<div class="password-reset-card">
							<div class="card-icon-wrapper">
								<div class="card-icon verification">
									<i class="far fa-shield-check"></i>
								</div>
							</div>

							<h3 class="card-title">Dogrulama Kodu</h3>
							<p class="card-description">
								E-posta adresinize gonderilen 6 haneli dogrulama kodunu asagidaki alana girin.
							</p>

							<form action="#" method="post" class="password-reset-form">
								<div class="form-group-modern">
									<div class="input-icon-wrapper">
										<i class="far fa-key input-icon"></i>
										<input type="text"
											   class="form-control-modern"
											   name="kod"
											   placeholder="Dogrulama Kodu"
											   maxlength="6"
											   required
											   autocomplete="off">
									</div>
									<small class="form-hint">
										<i class="far fa-info-circle me-1"></i>Kod 15 dakika gecerlidir
									</small>
								</div>

								<button type="submit" class="btn-modern btn-primary w-100">
									<span class="btn-text">Dogrula ve Devam Et</span>
									<i class="far fa-arrow-right btn-icon"></i>
								</button>
							</form>

							<div class="card-footer-links">
								<a href="<?=SITE?>sifremi-unuttum" class="footer-link">
									<i class="far fa-redo me-1"></i>Yeni kod gonder
								</a>
								<a href="<?=SITE?>uyelik" class="footer-link">
									<i class="far fa-arrow-left me-1"></i>Girise don
								</a>
							</div>
						</div>
						<?php
					}
					// STEP 2: New Password
					else if($islemtipi=="sifreIste" && !empty($_SESSION["guvenlikKilidi"]) && $_SESSION["guvenlikKilidi"]=="OK")
					{
						if($_POST)
						{
							if(!empty($_POST["sifre"]) && !empty($_POST["tsifre"]))
							{
								if($_POST["sifre"]==$_POST["tsifre"])
								{
									$sifre=md5($VT->filter($_POST["sifre"]));
									$uyeID=$VT->filter($_SESSION["uyeninSifresiIcinID"]);
									$guncelle=$VT->SorguCalistir("UPDATE uyeler","SET sifre=? WHERE ID=?",array($sifre,$uyeID),1);
									unset($_SESSION["guvenlikKilidi"]);
									unset($_SESSION["uyeninSifresiIcinID"]);
									unset($_SESSION["dogrulamaKodu"]);
									?>
									<div class="alert alert-success alert-modern-success mb-4">
										<div class="success-icon">
											<i class="far fa-check-circle"></i>
										</div>
										<div class="success-content">
											<h5>Basarili!</h5>
											<p>Sifreniz basariyla guncellendi. Giris sayfasina yonlendiriliyorsunuz...</p>
										</div>
									</div>
									<meta http-equiv="refresh" content="3;url=<?=SITE?>uyelik">
									<?php
								}
								else
								{
									?>
									<div class="alert alert-danger alert-modern mb-4">
										<i class="far fa-exclamation-triangle me-2"></i>Sifreler eslesmiyor! Lutfen tekrar deneyin.
									</div>
									<?php
								}
							}
							else
							{
								?>
								<div class="alert alert-danger alert-modern mb-4">
									<i class="far fa-exclamation-circle me-2"></i>Lutfen tum alanlari doldurun.
								</div>
								<?php
							}
						}
						?>

						<!-- New Password Card -->
						<div class="password-reset-card">
							<div class="card-icon-wrapper">
								<div class="card-icon password">
									<i class="far fa-lock-alt"></i>
								</div>
							</div>

							<h3 class="card-title">Yeni Sifre Belirle</h3>
							<p class="card-description">
								Hesabiniz icin guclu ve guvenli bir sifre olusturun.
							</p>

							<!-- Password Strength Indicator -->
							<div class="password-strength-wrapper mb-4">
								<div class="strength-bars">
									<div class="strength-bar" data-strength="1"></div>
									<div class="strength-bar" data-strength="2"></div>
									<div class="strength-bar" data-strength="3"></div>
									<div class="strength-bar" data-strength="4"></div>
								</div>
								<span class="strength-text">Sifre gucu: <strong id="strengthText">-</strong></span>
							</div>

							<form action="#" method="post" class="password-reset-form" id="passwordForm">
								<div class="form-group-modern">
									<div class="input-icon-wrapper">
										<i class="far fa-lock input-icon"></i>
										<input type="password"
											   class="form-control-modern"
											   name="sifre"
											   id="password"
											   placeholder="Yeni Sifre"
											   required
											   autocomplete="new-password">
										<button type="button" class="toggle-password" data-target="password">
											<i class="far fa-eye"></i>
										</button>
									</div>
								</div>

								<div class="form-group-modern">
									<div class="input-icon-wrapper">
										<i class="far fa-lock input-icon"></i>
										<input type="password"
											   class="form-control-modern"
											   name="tsifre"
											   id="confirmPassword"
											   placeholder="Sifre Tekrar"
											   required
											   autocomplete="new-password">
										<button type="button" class="toggle-password" data-target="confirmPassword">
											<i class="far fa-eye"></i>
										</button>
									</div>
									<div class="password-match-indicator" id="matchIndicator"></div>
								</div>

								<!-- Password Requirements -->
								<div class="password-requirements mb-4">
									<h6 class="requirements-title">
										<i class="far fa-list-check me-2"></i>Sifre Gereksinimleri
									</h6>
									<ul class="requirements-list">
										<li class="requirement-item" data-requirement="length">
											<i class="far fa-circle"></i>
											<span>En az 8 karakter</span>
										</li>
										<li class="requirement-item" data-requirement="uppercase">
											<i class="far fa-circle"></i>
											<span>En az 1 buyuk harf (A-Z)</span>
										</li>
										<li class="requirement-item" data-requirement="lowercase">
											<i class="far fa-circle"></i>
											<span>En az 1 kucuk harf (a-z)</span>
										</li>
										<li class="requirement-item" data-requirement="number">
											<i class="far fa-circle"></i>
											<span>En az 1 rakam (0-9)</span>
										</li>
									</ul>
								</div>

								<button type="submit" class="btn-modern btn-success w-100" id="submitBtn" disabled>
									<span class="btn-text">Sifremi Guncelle</span>
									<i class="far fa-check btn-icon"></i>
								</button>
							</form>

							<div class="card-footer-links">
								<a href="<?=SITE?>uyelik" class="footer-link">
									<i class="far fa-arrow-left me-1"></i>Girise don
								</a>
							</div>
						</div>
						<?php
					}
				}
				?>
			</div>
		</div>
	</div>
</section>

<style>
	/* Password Reset Card - Premium Design */
	.password-reset-card {
		background: #fff;
		border-radius: 20px;
		padding: 50px 40px;
		box-shadow: 0 10px 40px rgba(0,0,0,0.1);
		position: relative;
		overflow: hidden;
		animation: slideUp 0.6s ease-out;
	}
	.password-reset-card::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		height: 5px;
		background: linear-gradient(90deg, #76a713 0%, #5a8010 100%);
	}

	/* Card Icon */
	.card-icon-wrapper {
		text-align: center;
		margin-bottom: 30px;
	}
	.card-icon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 100px;
		height: 100px;
		border-radius: 50%;
		font-size: 45px;
		color: #fff;
		box-shadow: 0 10px 30px rgba(0,0,0,0.15);
		animation: bounceIn 0.8s ease-out;
		position: relative;
	}
	.card-icon.verification {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
	}
	.card-icon.password {
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
	}
	.card-icon::after {
		content: '';
		position: absolute;
		width: 120%;
		height: 120%;
		border-radius: 50%;
		border: 2px solid currentColor;
		opacity: 0.2;
		animation: pulse 2s infinite;
	}

	/* Card Title & Description */
	.card-title {
		font-size: 28px;
		font-weight: 700;
		color: #2c3e50;
		text-align: center;
		margin-bottom: 15px;
	}
	.card-description {
		font-size: 15px;
		color: #6c757d;
		text-align: center;
		margin-bottom: 35px;
		line-height: 1.6;
	}

	/* Modern Form Group */
	.form-group-modern {
		margin-bottom: 25px;
	}
	.input-icon-wrapper {
		position: relative;
		display: flex;
		align-items: center;
	}
	.input-icon {
		position: absolute;
		left: 20px;
		color: #76a713;
		font-size: 18px;
		z-index: 2;
		transition: all 0.3s ease;
	}
	.form-control-modern {
		width: 100%;
		height: 55px;
		padding: 15px 55px 15px 55px;
		border: 2px solid #e8e8e8;
		border-radius: 12px;
		font-size: 15px;
		font-weight: 500;
		color: #2c3e50;
		background: #fff;
		transition: all 0.3s ease;
	}
	.form-control-modern:focus {
		outline: none;
		border-color: #76a713;
		box-shadow: 0 0 0 4px rgba(118, 167, 19, 0.1);
	}
	.form-control-modern:focus + .input-icon {
		color: #76a713;
		transform: scale(1.1);
	}

	/* Toggle Password Button */
	.toggle-password {
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
	.toggle-password:hover {
		color: #76a713;
		transform: scale(1.1);
	}
	.toggle-password.active i::before {
		content: "\f070";
	}

	/* Form Hint */
	.form-hint {
		display: block;
		margin-top: 8px;
		font-size: 13px;
		color: #6c757d;
		padding-left: 5px;
	}

	/* Password Strength Indicator */
	.password-strength-wrapper {
		background: #f8f9fa;
		padding: 20px;
		border-radius: 12px;
		border: 2px solid #e8e8e8;
	}
	.strength-bars {
		display: flex;
		gap: 8px;
		margin-bottom: 12px;
	}
	.strength-bar {
		flex: 1;
		height: 6px;
		background: #e8e8e8;
		border-radius: 3px;
		transition: all 0.4s ease;
	}
	.strength-bar.active-weak {
		background: linear-gradient(90deg, #dc3545, #c82333);
	}
	.strength-bar.active-fair {
		background: linear-gradient(90deg, #ffc107, #ff9800);
	}
	.strength-bar.active-good {
		background: linear-gradient(90deg, #17a2b8, #138496);
	}
	.strength-bar.active-strong {
		background: linear-gradient(90deg, #28a745, #218838);
	}
	.strength-text {
		font-size: 14px;
		color: #6c757d;
	}
	.strength-text strong {
		color: #2c3e50;
	}

	/* Password Match Indicator */
	.password-match-indicator {
		margin-top: 8px;
		font-size: 13px;
		padding-left: 5px;
		font-weight: 500;
	}
	.password-match-indicator.match {
		color: #28a745;
	}
	.password-match-indicator.no-match {
		color: #dc3545;
	}

	/* Password Requirements */
	.password-requirements {
		background: #f8f9fa;
		padding: 20px;
		border-radius: 12px;
		border: 2px solid #e8e8e8;
	}
	.requirements-title {
		font-size: 14px;
		font-weight: 600;
		color: #2c3e50;
		margin-bottom: 15px;
	}
	.requirements-list {
		list-style: none;
		padding: 0;
		margin: 0;
	}
	.requirement-item {
		display: flex;
		align-items: center;
		gap: 10px;
		padding: 8px 0;
		font-size: 14px;
		color: #6c757d;
		transition: all 0.3s ease;
	}
	.requirement-item i {
		font-size: 12px;
		color: #dee2e6;
		transition: all 0.3s ease;
	}
	.requirement-item.valid {
		color: #28a745;
	}
	.requirement-item.valid i {
		color: #28a745;
	}
	.requirement-item.valid i::before {
		content: "\f058";
		font-weight: 900;
	}

	/* Modern Buttons */
	.btn-modern {
		position: relative;
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 10px;
		height: 55px;
		padding: 15px 30px;
		border: none;
		border-radius: 12px;
		font-size: 16px;
		font-weight: 600;
		color: #fff;
		cursor: pointer;
		overflow: hidden;
		transition: all 0.3s ease;
	}
	.btn-modern::before {
		content: '';
		position: absolute;
		top: 0;
		left: -100%;
		width: 100%;
		height: 100%;
		background: rgba(255,255,255,0.2);
		transition: left 0.5s ease;
	}
	.btn-modern:hover::before {
		left: 100%;
	}
	.btn-modern:disabled {
		opacity: 0.6;
		cursor: not-allowed;
	}
	.btn-modern.btn-primary {
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
	}
	.btn-modern.btn-primary:hover:not(:disabled) {
		transform: translateY(-2px);
		box-shadow: 0 8px 30px rgba(102, 126, 234, 0.5);
	}
	.btn-modern.btn-success {
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		box-shadow: 0 5px 20px rgba(118, 167, 19, 0.4);
	}
	.btn-modern.btn-success:hover:not(:disabled) {
		transform: translateY(-2px);
		box-shadow: 0 8px 30px rgba(118, 167, 19, 0.5);
	}
	.btn-icon {
		font-size: 18px;
		transition: transform 0.3s ease;
	}
	.btn-modern:hover .btn-icon {
		transform: translateX(5px);
	}

	/* Card Footer Links */
	.card-footer-links {
		display: flex;
		justify-content: center;
		gap: 30px;
		margin-top: 30px;
		padding-top: 25px;
		border-top: 2px dashed #e8e8e8;
	}
	.footer-link {
		display: flex;
		align-items: center;
		gap: 5px;
		font-size: 14px;
		font-weight: 500;
		color: #6c757d;
		text-decoration: none;
		transition: all 0.3s ease;
	}
	.footer-link:hover {
		color: #76a713;
		transform: translateX(-3px);
	}

	/* Alerts */
	.alert-modern {
		display: flex;
		align-items: center;
		padding: 18px 25px;
		border-radius: 12px;
		font-size: 15px;
		font-weight: 500;
		animation: slideDown 0.5s ease-out;
	}
	.alert-modern i {
		font-size: 20px;
	}
	.alert-modern-success {
		background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
		border: 2px solid #28a745;
		padding: 25px;
		display: flex;
		align-items: center;
		gap: 20px;
	}
	.success-icon {
		flex-shrink: 0;
		width: 60px;
		height: 60px;
		display: flex;
		align-items: center;
		justify-content: center;
		background: #28a745;
		border-radius: 50%;
		color: #fff;
		font-size: 30px;
		animation: scaleIn 0.5s ease-out;
	}
	.success-content h5 {
		font-size: 18px;
		font-weight: 700;
		color: #155724;
		margin: 0 0 8px 0;
	}
	.success-content p {
		font-size: 14px;
		color: #155724;
		margin: 0;
	}

	/* Animations */
	@keyframes slideUp {
		from {
			opacity: 0;
			transform: translateY(30px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
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
		0% {
			transform: scale(1);
			opacity: 0.2;
		}
		50% {
			transform: scale(1.1);
			opacity: 0;
		}
		100% {
			transform: scale(1);
			opacity: 0;
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

	/* Responsive */
	@media (max-width: 768px) {
		.password-reset-card {
			padding: 40px 25px;
		}
		.card-icon {
			width: 80px;
			height: 80px;
			font-size: 35px;
		}
		.card-title {
			font-size: 24px;
		}
		.card-footer-links {
			flex-direction: column;
			gap: 15px;
		}
	}
</style>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Toggle Password Visibility
		const toggleButtons = document.querySelectorAll('.toggle-password');
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

		// Password Strength Checker
		const passwordInput = document.getElementById('password');
		const confirmInput = document.getElementById('confirmPassword');
		const submitBtn = document.getElementById('submitBtn');

		if(passwordInput) {
			passwordInput.addEventListener('input', function() {
				checkPasswordStrength(this.value);
				checkPasswordRequirements(this.value);
				checkPasswordMatch();
			});
		}

		if(confirmInput) {
			confirmInput.addEventListener('input', function() {
				checkPasswordMatch();
			});
		}

		function checkPasswordStrength(password) {
			const strengthBars = document.querySelectorAll('.strength-bar');
			const strengthText = document.getElementById('strengthText');

			let strength = 0;

			if(password.length >= 8) strength++;
			if(password.match(/[a-z]/)) strength++;
			if(password.match(/[A-Z]/)) strength++;
			if(password.match(/[0-9]/)) strength++;
			if(password.match(/[^a-zA-Z0-9]/)) strength++;

			// Reset bars
			strengthBars.forEach(bar => {
				bar.className = 'strength-bar';
			});

			// Set strength
			const strengthLevels = ['', 'Zayif', 'Orta', 'Iyi', 'Guclu'];
			const strengthClasses = ['', 'active-weak', 'active-fair', 'active-good', 'active-strong'];

			let level = Math.min(Math.floor(strength / 1.5), 4);

			for(let i = 0; i < level; i++) {
				strengthBars[i].classList.add(strengthClasses[level]);
			}

			strengthText.textContent = strengthLevels[level] || '-';
			strengthText.style.color = ['#6c757d', '#dc3545', '#ffc107', '#17a2b8', '#28a745'][level] || '#6c757d';
		}

		function checkPasswordRequirements(password) {
			const requirements = {
				length: password.length >= 8,
				uppercase: /[A-Z]/.test(password),
				lowercase: /[a-z]/.test(password),
				number: /[0-9]/.test(password)
			};

			for(let req in requirements) {
				const item = document.querySelector(`[data-requirement="${req}"]`);
				if(item) {
					if(requirements[req]) {
						item.classList.add('valid');
					} else {
						item.classList.remove('valid');
					}
				}
			}

			// Enable submit if all requirements met
			const allValid = Object.values(requirements).every(v => v);
			const passwordsMatch = passwordInput.value === confirmInput.value && confirmInput.value !== '';

			if(submitBtn) {
				submitBtn.disabled = !(allValid && passwordsMatch);
			}
		}

		function checkPasswordMatch() {
			const matchIndicator = document.getElementById('matchIndicator');

			if(!matchIndicator || !passwordInput || !confirmInput) return;

			if(confirmInput.value === '') {
				matchIndicator.textContent = '';
				matchIndicator.className = 'password-match-indicator';
			} else if(passwordInput.value === confirmInput.value) {
				matchIndicator.textContent = ' Sifreler esles1yor';
				matchIndicator.className = 'password-match-indicator match';
			} else {
				matchIndicator.textContent = ' Sifreler eslesm1yor';
				matchIndicator.className = 'password-match-indicator no-match';
			}

			// Update submit button
			const allRequirements = document.querySelectorAll('.requirement-item.valid').length === 4;
			const passwordsMatch = passwordInput.value === confirmInput.value && confirmInput.value !== '';

			if(submitBtn) {
				submitBtn.disabled = !(allRequirements && passwordsMatch);
			}
		}

		// Auto-focus first input
		const firstInput = document.querySelector('.form-control-modern');
		if(firstInput) {
			firstInput.focus();
		}
	});
</script>

<?php
}
?>
