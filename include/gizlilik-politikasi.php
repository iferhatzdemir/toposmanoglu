<?php
if(!empty($_GET["seflink"]))
{
	$seflink=$VT->filter($_GET["seflink"]);
	$bilgi=$VT->VeriGetir("gizlilikpolitikasi","WHERE seflink=? AND durum=?",array($seflink,1),"ORDER BY ID ASC",1);
	if($bilgi!=false)
	{
		?>
		<!--==============================
		Breadcumb
		============================== -->
		<div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/breadcumb/breadcumb-img-1.jpg">
			<div class="container">
				<div class="breadcumb-content text-center">
					<h1 class="breadcumb-title"><?=stripslashes($bilgi[0]["baslik"])?></h1>
					<ul class="breadcumb-menu-style1 mx-auto">
						<li><a href="<?=SITE?>">Anasayfa</a></li>
						<li class="active">Gizlilik Politikasi</li>
					</ul>
				</div>
			</div>
		</div>

		<!--==============================
			Privacy Policy Content Area
		==============================-->
		<section class="vs-blog-wrapper space-top space-md-bottom">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-10 col-xl-9">
						<div class="bg-white p-4 p-md-5 shadow-sm rounded">
							<div class="page-header mb-40">
								<h2 class="sec-title4 mb-3"><?=stripslashes($bilgi[0]["baslik"])?></h2>
								<div class="border-bottom pb-3"></div>
							</div>

							<div class="privacy-content">
								<?=stripslashes($bilgi[0]["metin"])?>
							</div>

							<div class="text-center mt-50">
								<a href="<?=SITE?>" class="vs-btn style4">
									<i class="far fa-arrow-left me-2"></i>Anasayfaya Don
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<style>
			.privacy-content {
				font-size: 15px;
				line-height: 1.8;
				color: #555;
			}
			.privacy-content h1,
			.privacy-content h2,
			.privacy-content h3,
			.privacy-content h4,
			.privacy-content h5,
			.privacy-content h6 {
				color: #333;
				font-weight: 600;
				margin-top: 30px;
				margin-bottom: 15px;
			}
			.privacy-content h2 {
				font-size: 24px;
				border-bottom: 2px solid #76a713;
				padding-bottom: 10px;
			}
			.privacy-content h3 {
				font-size: 20px;
				color: #76a713;
			}
			.privacy-content h4 {
				font-size: 18px;
			}
			.privacy-content p {
				margin-bottom: 20px;
				text-align: justify;
			}
			.privacy-content ul,
			.privacy-content ol {
				margin-bottom: 20px;
				padding-left: 25px;
			}
			.privacy-content ul li,
			.privacy-content ol li {
				margin-bottom: 10px;
			}
			.privacy-content strong {
				color: #333;
				font-weight: 600;
			}
			.privacy-content a {
				color: #76a713;
				text-decoration: underline;
			}
			.privacy-content a:hover {
				color: #5a8010;
			}
			.privacy-content blockquote {
				background: #f9f9f9;
				border-left: 4px solid #76a713;
				padding: 20px;
				margin: 25px 0;
				font-style: italic;
				color: #666;
			}
			.privacy-content table {
				width: 100%;
				margin-bottom: 20px;
				border-collapse: collapse;
			}
			.privacy-content table th,
			.privacy-content table td {
				border: 1px solid #ddd;
				padding: 12px;
				text-align: left;
			}
			.privacy-content table th {
				background: #76a713;
				color: #fff;
				font-weight: 600;
			}
			.privacy-content table tr:nth-child(even) {
				background: #f9f9f9;
			}
			.page-header {
				position: relative;
			}
			.sec-title4 {
				font-size: 32px;
				color: #333;
				font-weight: 700;
			}
			@media (max-width: 768px) {
				.sec-title4 {
					font-size: 24px;
				}
				.privacy-content {
					font-size: 14px;
				}
				.privacy-content h2 {
					font-size: 20px;
				}
				.privacy-content h3 {
					font-size: 18px;
				}
			}
		</style>
		<?php
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

		<section class="vs-blog-wrapper space-top space-md-bottom">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-6 text-center">
						<div class="py-5">
							<i class="far fa-exclamation-triangle" style="font-size: 80px; color: #dc3545; margin-bottom: 20px;"></i>
							<h2 class="sec-title4 mb-3">Sayfa Bulunamadi</h2>
							<p class="mb-4">Aradiginiz gizlilik politikasi sayfasi bulunamadi.</p>
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

	<section class="vs-blog-wrapper space-top space-md-bottom">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-6 text-center">
					<div class="py-5">
						<i class="far fa-exclamation-triangle" style="font-size: 80px; color: #dc3545; margin-bottom: 20px;"></i>
						<h2 class="sec-title4 mb-3">Gecersiz Link</h2>
						<p class="mb-4">Gecersiz bir gizlilik politikasi linki.</p>
						<a href="<?=SITE?>" class="vs-btn style4">Anasayfaya Don</a>
					</div>
				</div>
			</div>
		</section>
	<?php
}
?>
