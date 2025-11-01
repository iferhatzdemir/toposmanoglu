<?php
if(!empty($_GET["seflink"]))
{
	$seflink=$VT->filter($_GET["seflink"]);
	$bilgi=$VT->VeriGetir("bloglar","WHERE seflink=? AND durum=?",array($seflink,1),"ORDER BY ID ASC",1);
	if($bilgi!=false)
	{
		// Kategori bilgisini çek
		$kategori_adi = "";
		if(!empty($bilgi[0]["kategori"]))
		{
			$kategori_bilgi = $VT->VeriGetir("bloglar","WHERE kategori=? AND durum=?",array($bilgi[0]["kategori"],1),"ORDER BY ID ASC",1);
			if($kategori_bilgi!=false)
			{
				$kategori_adi = stripslashes($bilgi[0]["kategori"]);
			}
		}

		// Tarih formatı
		$tarih = date("d F, Y", strtotime($bilgi[0]["tarih"]));
		?>
		<!--==============================
		Breadcumb
		============================== -->
		<div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/breadcumb/breadcumb-img-1.jpg">
			<div class="container">
				<div class="breadcumb-content text-center">
					<h1 class="breadcumb-title"><?=stripslashes($bilgi[0]["baslik"])?></h1>
					<ul class="breadcumb-menu-style1 mx-auto">
						<li><a href="<?=SITE?>">Home</a></li>
						<li class="active">Blog</li>
					</ul>
				</div>
			</div>
		</div>
		<!--==============================
			Blog Area
		==============================-->
		<section class="vs-blog-wrapper blog-details space-top space-md-bottom">
			<div class="container">
				<div class="row gx-5">
					<div class="col-lg-8 col-xl-9">
						<div class="vs-blog blog-single">
							<?php if(!empty($bilgi[0]["resim"])) { ?>
							<div class="blog-image">
								<img src="<?=SITE?>images/bloglar/<?=$bilgi[0]["resim"]?>" alt="<?=stripslashes($bilgi[0]["baslik"])?>">
								<?php if(!empty($kategori_adi)) { ?>
								<div class="blog-category">
									<a href="#"><?=$kategori_adi?></a>
								</div>
								<?php } ?>
							</div>
							<?php } ?>
							<div class="blog-header">
								<h2 class="blog-title h1"><?=stripslashes($bilgi[0]["baslik"])?></h2>
								<div class="blog-meta">
									<a href="#"><i class="fal fa-calendar-alt"></i><?=$tarih?></a>
								</div>
							</div>
							<div class="blog-content">
								<?=stripslashes($bilgi[0]["metin"])?>
							</div>
							<div class="share-links clearfix my-60">
								<div class="row align-items-xl-center">
									<?php if(!empty($bilgi[0]["anahtar"])) {
										$tags = explode(",", $bilgi[0]["anahtar"]);
									?>
									<div class="col-sm-6">
										<span class="fs-xs fw-semibold text-title me-3">Tags:</span>
										<div class="tagcloud">
											<?php foreach($tags as $tag) { ?>
											<a href="#"><?=trim(stripslashes($tag))?></a>
											<?php } ?>
										</div>
									</div>
									<?php } ?>
									<div class="col-sm-6 text-start text-md-end">
										<span class="fs-xs fw-semibold text-title me-3">Sosyal Medya:</span>
										<ul class="blog-social list-unstyled">
											<li><a class="facebook" href="#"><i class="fab fa-facebook-f"></i></a></li>
											<li><a class="twitter" href="#"><i class="fab fa-twitter"></i></a></li>
											<li><a class="instagram" href="#"><i class="fab fa-pinterest"></i></a></li>
											<li><a class="linkedin" href="#"><i class="fab fa-linkedin"></i></a></li>
										</ul><!-- End Social Share -->
									</div><!-- Share Links Area end -->
								</div>
							</div>
						</div>
						<?php
						// İlgili blog yazıları
						$ilgili_bloglar = $VT->VeriGetir("bloglar","WHERE ID!=? AND durum=?",array($bilgi[0]["ID"],1),"ORDER BY ID DESC",3);
						if($ilgili_bloglar!=false && count($ilgili_bloglar)>0)
						{
						?>
						<div class="related-post-wrapper pt-40">
							<h2 class="inner-title1 h1">Diğer <span class="text-theme">Bloglarımız</span></h2>
							<div class="row text-center vs-carousel" data-slide-show="3" data-lg-slide-show="2">
								<?php foreach($ilgili_bloglar as $ilgili) { ?>
								<div class="col-lg-4">
									<div class="vs-blog blog-grid">
										<?php if(!empty($ilgili["resim"])) { ?>
										<div class="blog-img image-scale-hover">
											<a href="<?=SITE?>?sayfa=blog-detay&seflink=<?=$ilgili["seflink"]?>"><img src="<?=SITE?>images/bloglar/<?=$ilgili["resim"]?>" alt="<?=stripslashes($ilgili["baslik"])?>" class="w-100"></a>
										</div>
										<?php } ?>
										<div class="blog-content">
											<h4 class="blog-title fw-semibold"><a href="<?=SITE?>?sayfa=blog-detay&seflink=<?=$ilgili["seflink"]?>"><?=stripslashes($ilgili["baslik"])?></a></h4>
											<div class="blog-meta">
												<a href="<?=SITE?>?sayfa=blog-detay&seflink=<?=$ilgili["seflink"]?>"><?=date("F d, Y", strtotime($ilgili["tarih"]))?></a>
											</div>
										</div>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
						<?php } ?>
					</div>
					<div class="col-lg-4 col-xl-3">
						<aside class="sidebar-area sticky-sidebar">
							<div class="widget widget_search">
								<h3 class="widget_title">Arama</h3>
								<form class="search-form" action="<?=SITE?>" method="get">
									<input type="hidden" name="sayfa" value="blog">
									<input type="text" name="q" placeholder="Search">
									<button type="submit"><i class="far fa-search"></i></button>
								</form>
							</div>
							<?php
							// Son blog yazıları
							$son_bloglar = $VT->VeriGetir("bloglar","WHERE durum=?",array(1),"ORDER BY ID DESC",3);
							if($son_bloglar!=false && count($son_bloglar)>0)
							{
							?>
							<div class="widget">
								<h3 class="widget_title">Son Bloglar</h3>
								<div class="vs-widget-recent-post">
									<?php foreach($son_bloglar as $son) { ?>
									<div class="recent-post d-flex align-items-center">
										<?php if(!empty($son["resim"])) { ?>
										<div class="media-img">
											<img src="<?=SITE?>images/bloglar/<?=$son["resim"]?>" width="100" height="73" alt="<?=stripslashes($son["baslik"])?>">
										</div>
										<?php } ?>
										<div class="media-body pl-30">
											<h4 class="recent-post-title h5 mb-0"><a href="<?=SITE?>?sayfa=blog-detay&seflink=<?=$son["seflink"]?>"><?=stripslashes($son["baslik"])?></a></h4>
											<a href="<?=SITE?>?sayfa=blog-detay&seflink=<?=$son["seflink"]?>" class="text-theme fs-12"><?=date("F d, Y", strtotime($son["tarih"]))?></a>
										</div>
									</div>
									<?php } ?>
								</div>
							</div>
							<?php } ?>
						</aside>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
	else
	{
		echo '<div class="container margin_30"><div class="alert alert-warning">Blog yazısı bulunamadı.</div></div>';
	}
}
else
{
	echo '<div class="container margin_30"><div class="alert alert-warning">Geçersiz blog linki.</div></div>';
}
?>