<?php
if(!empty($_GET["seflink"]))
{
	$seflink=$VT->filter($_GET["seflink"]);
	$bilgi=$VT->VeriGetir("kurumsal","WHERE seflink=? AND durum=?",array($seflink,1),"ORDER BY ID ASC",1);
	if($bilgi!=false)
	{
		?>
		<!--==============================
		Breadcumb
		============================== -->
		<div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="images/kurumsal/<?=$bilgi[0]["resim"]?>">
			<div class="container">
				<div class="breadcumb-content text-center">
					<h1 class="breadcumb-title"><?=stripslashes($bilgi[0]["baslik"])?></h1>
					<ul class="breadcumb-menu-style1 mx-auto">
						<li><a href="<?=SITE?>">Anasayfa</a></li>
						<li class="active"><?=stripslashes($bilgi[0]["baslik"])?></li>
					</ul>
				</div>
			</div>
		</div>

		<!--==============================
			Corporate Content Area
		==============================-->
		<section class="space-top space-md-bottom">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-10 col-xl-9">
						<!-- Corporate Content Card -->
						<div class="corporate-content-wrapper bg-white p-4 p-md-5 shadow-sm rounded">
							<!-- Page Header -->
							<div class="corporate-header mb-5">
								<div class="d-flex align-items-center mb-3">
									<div class="header-icon me-3">
										<i class="far fa-file-alt"></i>
									</div>
									<div>
										<h2 class="corporate-title mb-2"><?=stripslashes($bilgi[0]["baslik"])?></h2>
										<div class="corporate-meta">
											<span class="meta-item">
												<i class="far fa-calendar me-1"></i>
												Son Guncelleme: <?=date("d.m.Y", strtotime($bilgi[0]["tarih"]))?>
											</span>
										</div>
									</div>
								</div>
								<div class="header-divider"></div>
							</div>

							<!-- Main Content -->
							<div class="corporate-content">
								<?=stripslashes($bilgi[0]["metin"])?>
							</div>

							<!-- Quick Links Section -->
							<?php
							$otherPages = $VT->VeriGetir("kurumsal","WHERE seflink!=? AND durum=?",array($seflink,1),"ORDER BY sirano ASC",4);
							if($otherPages!=false && count($otherPages)>0) {
							?>
							<div class="related-pages mt-5">
								<h4 class="related-title mb-4">
									<i class="far fa-link me-2"></i>Diger Sayfalar
								</h4>
								<div class="row">
									<?php foreach($otherPages as $page) { ?>
									<div class="col-md-6 mb-3">
										<a href="<?=SITE?>kurumsal/<?=$page["seflink"]?>" class="related-page-card">
											<div class="d-flex align-items-center">
												<div class="related-icon">
													<i class="far fa-file-alt"></i>
												</div>
												<div class="related-info">
													<h6 class="mb-0"><?=stripslashes($page["baslik"])?></h6>
													<small class="text-muted">Detayli Bilgi</small>
												</div>
												<div class="related-arrow ms-auto">
													<i class="far fa-arrow-right"></i>
												</div>
											</div>
										</a>
									</div>
									<?php } ?>
								</div>
							</div>
							<?php } ?>

							<!-- Back Button -->
							<div class="text-center mt-5">
								<a href="<?=SITE?>" class="vs-btn style4">
									<i class="far fa-arrow-left me-2"></i>Anasayfaya Don
								</a>
							</div>
						</div>

						<!-- Contact CTA Box -->
						<div class="contact-cta-box bg-light p-4 rounded mt-4">
							<div class="row align-items-center">
								<div class="col-md-8 mb-3 mb-md-0">
									<h5 class="mb-2">
										<i class="far fa-question-circle me-2"></i>Daha Fazla Bilgi mi Gerekiyor?
									</h5>
									<p class="mb-0 text-muted">Sorulariniz icin bizimle iletisime gecebilirsiniz.</p>
								</div>
								<div class="col-md-4 text-md-end">
									<a href="<?=SITE?>iletisim" class="vs-btn style4">
										<i class="far fa-envelope me-2"></i>Iletisim
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<style>
			/* Corporate Content Wrapper */
			.corporate-content-wrapper {
				border: 1px solid #e8e8e8;
			}

			/* Header Section */
			.corporate-header {
				position: relative;
			}
			.header-icon {
				width: 60px;
				height: 60px;
				background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
				border-radius: 12px;
				display: flex;
				align-items: center;
				justify-content: center;
				flex-shrink: 0;
			}
			.header-icon i {
				font-size: 28px;
				color: #fff;
			}
			.corporate-title {
				font-size: 28px;
				font-weight: 700;
				color: #333;
				margin: 0;
			}
			.corporate-meta {
				display: flex;
				align-items: center;
				gap: 15px;
			}
			.meta-item {
				font-size: 14px;
				color: #666;
			}
			.meta-item i {
				color: #76a713;
			}
			.header-divider {
				height: 3px;
				background: linear-gradient(90deg, #76a713 0%, transparent 100%);
				margin-top: 20px;
			}

			/* Main Content Styling */
			.corporate-content {
				font-size: 16px;
				line-height: 1.8;
				color: #555;
			}
			.corporate-content h1,
			.corporate-content h2,
			.corporate-content h3,
			.corporate-content h4,
			.corporate-content h5,
			.corporate-content h6 {
				color: #333;
				font-weight: 700;
				margin-top: 30px;
				margin-bottom: 15px;
			}
			.corporate-content h2 {
				font-size: 26px;
				border-bottom: 2px solid #76a713;
				padding-bottom: 10px;
				margin-top: 40px;
			}
			.corporate-content h3 {
				font-size: 22px;
				color: #76a713;
			}
			.corporate-content h4 {
				font-size: 20px;
			}
			.corporate-content h5 {
				font-size: 18px;
			}
			.corporate-content p {
				margin-bottom: 20px;
				text-align: justify;
			}
			.corporate-content ul,
			.corporate-content ol {
				margin-bottom: 25px;
				padding-left: 30px;
			}
			.corporate-content ul li,
			.corporate-content ol li {
				margin-bottom: 12px;
				line-height: 1.7;
			}
			.corporate-content ul li::marker {
				color: #76a713;
			}
			.corporate-content strong {
				color: #333;
				font-weight: 600;
			}
			.corporate-content a {
				color: #76a713;
				text-decoration: underline;
				transition: all 0.3s;
			}
			.corporate-content a:hover {
				color: #5a8010;
			}
			.corporate-content blockquote {
				background: #f8f9fa;
				border-left: 4px solid #76a713;
				padding: 20px 25px;
				margin: 30px 0;
				font-style: italic;
				color: #666;
			}
			.corporate-content blockquote p:last-child {
				margin-bottom: 0;
			}
			.corporate-content img {
				max-width: 100%;
				height: auto;
				border-radius: 8px;
				margin: 25px 0;
				box-shadow: 0 5px 20px rgba(0,0,0,0.1);
			}
			.corporate-content table {
				width: 100%;
				margin-bottom: 25px;
				border-collapse: collapse;
			}
			.corporate-content table th,
			.corporate-content table td {
				border: 1px solid #ddd;
				padding: 12px 15px;
				text-align: left;
			}
			.corporate-content table th {
				background: #76a713;
				color: #fff;
				font-weight: 600;
			}
			.corporate-content table tr:nth-child(even) {
				background: #f9f9f9;
			}
			.corporate-content hr {
				border: none;
				height: 2px;
				background: linear-gradient(90deg, transparent 0%, #76a713 50%, transparent 100%);
				margin: 40px 0;
			}

			/* Related Pages Section */
			.related-pages {
				border-top: 2px solid #f0f0f0;
				padding-top: 30px;
			}
			.related-title {
				font-size: 20px;
				font-weight: 700;
				color: #333;
			}
			.related-page-card {
				display: block;
				padding: 20px;
				background: #f8f9fa;
				border-radius: 10px;
				border: 2px solid #e8e8e8;
				transition: all 0.3s;
				text-decoration: none;
			}
			.related-page-card:hover {
				border-color: #76a713;
				background: #fff;
				box-shadow: 0 5px 15px rgba(118, 167, 19, 0.1);
				transform: translateY(-3px);
			}
			.related-icon {
				width: 50px;
				height: 50px;
				background: #76a713;
				border-radius: 10px;
				display: flex;
				align-items: center;
				justify-content: center;
				margin-right: 15px;
			}
			.related-icon i {
				font-size: 22px;
				color: #fff;
			}
			.related-info h6 {
				color: #333;
				font-weight: 600;
				font-size: 16px;
			}
			.related-arrow {
				color: #76a713;
				font-size: 18px;
				transition: all 0.3s;
			}
			.related-page-card:hover .related-arrow {
				transform: translateX(5px);
			}

			/* Contact CTA Box */
			.contact-cta-box {
				background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
				border: 1px solid #dee2e6;
			}
			.contact-cta-box h5 {
				color: #333;
				font-weight: 700;
			}

			/* Print Styles */
			@media print {
				.breadcumb-wrapper,
				.related-pages,
				.contact-cta-box,
				.vs-btn {
					display: none;
				}
				.corporate-content-wrapper {
					box-shadow: none;
					border: none;
				}
			}

			/* Responsive */
			@media (max-width: 768px) {
				.header-icon {
					width: 50px;
					height: 50px;
				}
				.header-icon i {
					font-size: 24px;
				}
				.corporate-title {
					font-size: 22px;
				}
				.corporate-meta {
					flex-direction: column;
					align-items: flex-start;
					gap: 8px;
				}
				.corporate-content {
					font-size: 15px;
				}
				.corporate-content h2 {
					font-size: 22px;
				}
				.corporate-content h3 {
					font-size: 20px;
				}
				.corporate-content h4 {
					font-size: 18px;
				}
				.corporate-content ul,
				.corporate-content ol {
					padding-left: 20px;
				}
				.related-icon {
					width: 40px;
					height: 40px;
				}
				.related-icon i {
					font-size: 18px;
				}
				.related-info h6 {
					font-size: 14px;
				}
			}
		</style>

		<script>
			document.addEventListener('DOMContentLoaded', function() {
				// Smooth scroll for internal links
				const contentLinks = document.querySelectorAll('.corporate-content a[href^="#"]');
				contentLinks.forEach(link => {
					link.addEventListener('click', function(e) {
						e.preventDefault();
						const targetId = this.getAttribute('href').substring(1);
						const targetElement = document.getElementById(targetId);
						if(targetElement) {
							targetElement.scrollIntoView({ behavior: 'smooth' });
						}
					});
				});

				// Add external link icon
				const externalLinks = document.querySelectorAll('.corporate-content a[href^="http"]');
				externalLinks.forEach(link => {
					if(!link.hostname.includes(window.location.hostname)) {
						link.setAttribute('target', '_blank');
						link.setAttribute('rel', 'noopener noreferrer');
						link.innerHTML += ' <i class="far fa-external-link-alt" style="font-size: 12px;"></i>';
					}
				});

				// Table responsive wrapper
				const tables = document.querySelectorAll('.corporate-content table');
				tables.forEach(table => {
					const wrapper = document.createElement('div');
					wrapper.className = 'table-responsive';
					table.parentNode.insertBefore(wrapper, table);
					wrapper.appendChild(table);
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
		<div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/kurumsal/">
			<div class="container">
				<div class="breadcumb-content text-center">
					<h1 class="breadcumb-title">Hata</h1>
					<ul class="breadcumb-menu-style1 mx-auto">
						<li><a href="<?=SITE?>">Anasayfa</a></li>
						<li class="active">Hata</li>
					</ul>
				</div>
			</div>
		</div>

		<section class="space-top space-md-bottom">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-6 text-center">
						<div class="py-5">
							<i class="far fa-exclamation-triangle" style="font-size: 80px; color: #dc3545; margin-bottom: 20px;"></i>
							<h2 class="sec-title4 mb-3">Sayfa Bulunamadi</h2>
							<p class="mb-4">Aradiginiz kurumsal sayfa bulunamadi.</p>
							<a href="<?=SITE?>" class="vs-btn style4">Anasayfaya Don</a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
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
				<h1 class="breadcumb-title">Hata</h1>
				<ul class="breadcumb-menu-style1 mx-auto">
					<li><a href="<?=SITE?>">Anasayfa</a></li>
					<li class="active">Hata</li>
				</ul>
			</div>
		</div>
	</div>

	<section class="space-top space-md-bottom">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-6 text-center">
					<div class="py-5">
						<i class="far fa-exclamation-triangle" style="font-size: 80px; color: #dc3545; margin-bottom: 20px;"></i>
						<h2 class="sec-title4 mb-3">Gecersiz Link</h2>
						<p class="mb-4">Gecersiz bir kurumsal sayfa linki.</p>
						<a href="<?=SITE?>" class="vs-btn style4">Anasayfaya Don</a>
					</div>
				</div>
			</div>
		</section>
	<?php
}
?>
