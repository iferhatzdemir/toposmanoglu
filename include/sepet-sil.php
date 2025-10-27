<?php
if(!empty($_SESSION["sepet"]))
{
	if(!empty($_GET["urunID"]) && ctype_digit($_GET["urunID"]))
	{
		$urunID=$VT->filter($_GET["urunID"]);
		if(!empty($_GET["varyasyonID"]) && ctype_digit($_GET["varyasyonID"]))
		{
			// Varyasyonlu ürün silme
			$varyasyonID=$VT->filter($_GET["varyasyonID"]);
			if(!empty($_SESSION["sepetVaryasyon"][$urunID][$varyasyonID]))
			{
				unset($_SESSION["sepetVaryasyon"][$urunID][$varyasyonID]);
			}

			// Eğer bu üründen başka varyasyon kalmadıysa, ürünü de sepetten çıkar
			if(!empty($_SESSION["sepetVaryasyon"][$urunID]))
			{
				// Başka varyasyonlar var, sadece varyasyonu sildik
			}
			else
			{
				// Hiç varyasyon kalmadı, ürünü de sepetten çıkar
				unset($_SESSION["sepet"][$urunID]);
			}
		}
		else
		{
			// Varyasyonsuz ürün silme
			if(!empty($_SESSION["sepet"][$urunID]))
			{
				unset($_SESSION["sepet"][$urunID]);
			}
		}
	}
	else
	{
		// Tüm sepeti temizle
		if($_GET["urunID"]=="clear")
		{
			unset($_SESSION["sepet"]);
			if(!empty($_SESSION["sepetVaryasyon"]))
			{
				unset($_SESSION["sepetVaryasyon"]);
			}
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
			<h1 class="breadcumb-title">Sepetten Siliniyor</h1>
			<ul class="breadcumb-menu-style1 mx-auto">
				<li><a href="<?=SITE?>">Anasayfa</a></li>
				<li><a href="<?=SITE?>sepet">Sepet</a></li>
				<li class="active">Siliniyor</li>
			</ul>
		</div>
	</div>
</div>

<!--==============================
	Removing from Cart
==============================-->
<section class="space-top space-md-bottom">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-6">
				<div class="removing-animation-wrapper text-center py-5">
					<!-- Animated Trash Icon -->
					<div class="trash-animation mb-4">
						<div class="trash-icon">
							<i class="far fa-trash-alt"></i>
						</div>
						<div class="trash-lid"></div>
					</div>

					<h3 class="removing-title mb-3">Sepetten Siliniyor...</h3>
					<p class="removing-text mb-4">
						<?php
						if(!empty($_GET["urunID"]) && $_GET["urunID"]=="clear") {
							echo "Sepetinizdeki tum urunler siliniyor.";
						} else {
							echo "Sectiginiz urun sepetten cikariliyor.";
						}
						?>
					</p>

					<!-- Progress Bar -->
					<div class="progress-wrapper">
						<div class="progress" style="height: 6px;">
							<div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%"></div>
						</div>
					</div>

					<!-- Loading Spinner -->
					<div class="spinner-wrapper mt-4">
						<div class="spinner-border text-success" role="status">
							<span class="visually-hidden">Yukleniyor...</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<style>
	/* Trash Animation */
	.trash-animation {
		position: relative;
		width: 120px;
		height: 120px;
		margin: 0 auto;
		animation: trashShake 0.5s ease-in-out;
	}
	.trash-icon {
		width: 120px;
		height: 120px;
		background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
		border-radius: 20px;
		display: flex;
		align-items: center;
		justify-content: center;
		box-shadow: 0 10px 30px rgba(220, 53, 69, 0.3);
		animation: trashBounce 2s ease-in-out infinite;
	}
	.trash-icon i {
		font-size: 50px;
		color: #fff;
	}
	.trash-lid {
		position: absolute;
		top: -10px;
		left: 50%;
		transform: translateX(-50%);
		width: 100px;
		height: 8px;
		background: #dc3545;
		border-radius: 10px;
		animation: lidOpen 1s ease-in-out infinite;
	}
	.trash-lid::before {
		content: '';
		position: absolute;
		top: -15px;
		left: 50%;
		transform: translateX(-50%);
		width: 40px;
		height: 15px;
		background: #dc3545;
		border-radius: 5px 5px 0 0;
	}

	@keyframes trashShake {
		0%, 100% { transform: translateX(0); }
		25% { transform: translateX(-10px); }
		75% { transform: translateX(10px); }
	}
	@keyframes trashBounce {
		0%, 100% { transform: translateY(0); }
		50% { transform: translateY(-10px); }
	}
	@keyframes lidOpen {
		0%, 100% { transform: translateX(-50%) rotate(0deg); }
		50% { transform: translateX(-50%) rotate(-20deg); }
	}

	/* Text */
	.removing-title {
		font-size: 28px;
		font-weight: 700;
		color: #333;
	}
	.removing-text {
		font-size: 16px;
		color: #666;
	}

	/* Progress Bar */
	.progress-wrapper {
		max-width: 400px;
		margin: 0 auto;
	}
	.progress {
		border-radius: 10px;
		overflow: hidden;
		background: #e9ecef;
	}

	/* Spinner */
	.spinner-wrapper {
		display: flex;
		justify-content: center;
	}
	.spinner-border {
		width: 3rem;
		height: 3rem;
		border-width: 4px;
	}

	/* Responsive */
	@media (max-width: 768px) {
		.trash-icon {
			width: 100px;
			height: 100px;
		}
		.trash-icon i {
			font-size: 40px;
		}
		.trash-lid {
			width: 80px;
		}
		.removing-title {
			font-size: 22px;
		}
		.removing-text {
			font-size: 14px;
		}
	}
</style>

<script>
	// Auto redirect after 1 second
	setTimeout(function() {
		window.location.href = '<?=SITE?>sepet';
	}, 1000);
</script>

<meta http-equiv="refresh" content="1;url=<?=SITE?>sepet">
