<?php
if(!empty($_GET["seflink"]))
{
	$seflink=$VT->filter($_GET["seflink"]);
	$kategoriler=$VT->VeriGetir("kategoriler","WHERE durum=? AND seflink=?",array(1,$seflink),"ORDER BY ID ASC",1);
	if($kategoriler!=false)
	{
?>

<!--==============================
Breadcumb
============================== -->
<?php
$kategoriResim = !empty($kategoriler[0]["resim"]) ? SITE."images/kategoriler/".$kategoriler[0]["resim"] : "";
$hasImage = !empty($kategoriResim);
?>
<div class="breadcumb-wrapper breadcumb-modern pt-100 pb-100 <?=$hasImage ? 'has-bg-image' : ''?>" <?=$hasImage ? 'style="background-image: url('.$kategoriResim.'); background-size: cover; background-position: center;"' : ''?>>
	<?php if($hasImage): ?>
	<div class="breadcumb-overlay"></div>
	<?php endif; ?>
	<div class="container">
		<div class="breadcumb-content text-center">
			<h1 class="breadcumb-title"><?=stripslashes($kategoriler[0]["baslik"])?></h1>
			<ul class="breadcumb-menu-style1 mx-auto">
				<li><a href="<?=SITE?>">Anasayfa</a></li>
				<li class="active"><?=stripslashes($kategoriler[0]["baslik"])?></li>
			</ul>
		</div>
	</div>
</div>

<!--==============================
	Shop Toolbar
==============================-->
<section class="shop-toolbar bg-light py-3">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-md-6 mb-2 mb-md-0">
				<div class="toolbar-left">
					<?php
					// Önce bu kategoride alt kategori var mı kontrol et
					$altkategoriler = $VT->VeriGetir("kategoriler","WHERE durum=? AND tablo=?",array(1,$kategoriler[0]["seflink"]),"ORDER BY ID ASC");

					// Toplam ürün sayısını hesapla
					$totalProducts = 0;
					if($altkategoriler!=false && count($altkategoriler)>0) {
						// Alt kategorilerdeki ürünleri say
						foreach($altkategoriler as $altkat) {
							$urunSayisi=$VT->VeriGetir("urunler","WHERE durum=? AND kategori=?",array(1,$altkat["ID"]));
							if($urunSayisi!=false) $totalProducts += count($urunSayisi);
						}
					} else {
						// Alt kategori yok, direkt bu kategorideki ürünleri say
						$urunSayisi=$VT->VeriGetir("urunler","WHERE durum=? AND kategori=?",array(1,$kategoriler[0]["ID"]));
						if($urunSayisi!=false) $totalProducts = count($urunSayisi);
					}
					?>
					<p class="mb-0">
						<i class="far fa-box-open me-2"></i>
						<strong><?=$totalProducts?></strong> urun bulundu
					</p>
				</div>
			</div>
			<div class="col-md-6">
				<div class="toolbar-right d-flex justify-content-md-end align-items-center gap-3">
					<div class="view-mode">
						<a href="<?=SITE?>kategori/<?=$kategoriler[0]["seflink"]?>" class="view-btn <?=empty($_GET["view"]) || $_GET["view"]!='list' ? 'active' : ''?>" title="Grid Gorunum">
							<i class="far fa-th"></i>
						</a>
						<a href="<?=SITE?>kategori/<?=$kategoriler[0]["seflink"]?>?view=list" class="view-btn <?=!empty($_GET["view"]) && $_GET["view"]=='list' ? 'active' : ''?>" title="Liste Gorunum">
							<i class="far fa-list"></i>
						</a>
					</div>
					<button class="vs-btn style4 btn-sm filter-toggle d-lg-none" type="button">
						<i class="far fa-filter me-2"></i>Filtreler
					</button>
				</div>
			</div>
		</div>
	</div>
</section>

<!--==============================
	Shop Area
==============================-->
<section class="space-top space-md-bottom">
	<div class="container">
		<div class="row">
			<!-- Sidebar Filters -->
			<aside class="col-lg-3 mb-4 mb-lg-0">
				<div class="shop-sidebar" id="shopSidebar">
					<div class="sidebar-close d-lg-none">
						<button type="button" class="close-btn">
							<i class="far fa-times"></i>
						</button>
					</div>

					<form action="<?=SITE?>kategori/<?=$kategoriler[0]["seflink"]?>" method="get" id="filterForm">
						<?php if(!empty($_GET["view"]) && $_GET["view"]=="list") { ?>
						<input type="hidden" name="view" value="list">
						<?php } ?>

						<!-- Categories Filter -->
						<div class="widget widget-categories">
							<h3 class="widget-title">
								<i class="far fa-list me-2"></i>Kategoriler
							</h3>
							<ul class="category-list">
								<?php
								// Sidebar için kategorileri göster
								$menukategori = array();

								// Eğer bu kategori ana kategori ise (modul), alt kategorilerini göster
								if($kategoriler[0]["tablo"]=="modul") {
									$menukategori=$VT->VeriGetir("kategoriler","WHERE durum=? AND tablo=?",array(1,$kategoriler[0]["seflink"]),"ORDER BY sirano ASC");
								}
								// Eğer bu kategori alt kategori ise, kardeş kategorilerini göster
								else {
									// Üst kategorisini bul
									$ustkategori=$VT->VeriGetir("kategoriler","WHERE durum=? AND seflink=?",array(1,$kategoriler[0]["tablo"]),"ORDER BY ID ASC",1);
									if($ustkategori!=false) {
										$menukategori=$VT->VeriGetir("kategoriler","WHERE durum=? AND tablo=?",array(1,$ustkategori[0]["seflink"]),"ORDER BY sirano ASC");
									}
								}

								if($menukategori!=false && count($menukategori)>0) {
									foreach($menukategori as $menukat) {
										$urunsay=$VT->VeriGetir("urunler","WHERE durum=? AND kategori=?",array(1,$menukat["ID"]));
										$sayac = $urunsay!=false ? count($urunsay) : 0;
										?>
										<li>
											<a href="<?=SITE?>kategori/<?=$menukat["seflink"]?>" class="category-item">
												<span class="cat-name"><?=stripslashes($menukat["baslik"])?></span>
												<span class="cat-count">(<?=$sayac?>)</span>
											</a>
										</li>
										<?php
									}
								}
								?>
							</ul>
						</div>

						<!-- Price Filter -->
						<div class="widget widget-price">
							<h3 class="widget-title">
								<i class="far fa-tag me-2"></i>Fiyat Araligi
							</h3>
							<div class="price-list">
								<label class="price-item">
									<input type="radio" name="fiyat" value="100" <?=(!empty($_GET["fiyat"]) && $_GET["fiyat"]=="100") ? 'checked' : ''?>>
									<span>0 TL - 100 TL</span>
								</label>
								<label class="price-item">
									<input type="radio" name="fiyat" value="500" <?=(!empty($_GET["fiyat"]) && $_GET["fiyat"]=="500") ? 'checked' : ''?>>
									<span>100 TL - 500 TL</span>
								</label>
								<label class="price-item">
									<input type="radio" name="fiyat" value="1000" <?=(!empty($_GET["fiyat"]) && $_GET["fiyat"]=="1000") ? 'checked' : ''?>>
									<span>500 TL - 1000 TL</span>
								</label>
								<label class="price-item">
									<input type="radio" name="fiyat" value="5000" <?=(!empty($_GET["fiyat"]) && $_GET["fiyat"]=="5000") ? 'checked' : ''?>>
									<span>1000 TL - 5000 TL</span>
								</label>
								<label class="price-item">
									<input type="radio" name="fiyat" value="5001" <?=(!empty($_GET["fiyat"]) && $_GET["fiyat"]=="5001") ? 'checked' : ''?>>
									<span>5000 TL uzeri</span>
								</label>
							</div>
						</div>

						<button type="submit" class="vs-btn style4 w-100">
							<i class="far fa-search me-2"></i>Filtrele
						</button>
					</form>
				</div>
			</aside>

			<!-- Products Grid/List -->
			<div class="col-lg-9">
				<?php
				// View mode
				$gorunum = (!empty($_GET["view"]) && $_GET["view"]=="list") ? "liste" : "kutu";

				// Price filter
				$baslamatutar = 0;
				$bitistutar = 0;
				if(!empty($_GET["fiyat"]) && ctype_digit($_GET["fiyat"])) {
					$gelenfiyat = $VT->filter($_GET["fiyat"]);
					if($gelenfiyat==100) { $baslamatutar=0; $bitistutar=100; }
					if($gelenfiyat==500) { $baslamatutar=100; $bitistutar=500; }
					if($gelenfiyat==1000) { $baslamatutar=500; $bitistutar=1000; }
					if($gelenfiyat==5000) { $baslamatutar=1000; $bitistutar=5000; }
					if($gelenfiyat==5001) { $baslamatutar=5000; $bitistutar=100000; }
				}

				// Ürünleri çek
				$urunler = array();

				// Önce bu kategoride alt kategori var mı kontrol et
				$altkategoriler = $VT->VeriGetir("kategoriler","WHERE durum=? AND tablo=?",array(1,$kategoriler[0]["seflink"]),"ORDER BY ID ASC");

				echo "<!-- DEBUG: Kategori ID: ".$kategoriler[0]["ID"]." | Seflink: ".$kategoriler[0]["seflink"]." | Tablo: ".$kategoriler[0]["tablo"]." -->";

				if($altkategoriler!=false && count($altkategoriler)>0) {
					// Alt kategoriler var - onların ürünlerini çek
					echo "<!-- DEBUG: ".count($altkategoriler)." alt kategori bulundu -->";
					foreach($altkategoriler as $altkat) {
						if(!empty($_GET["fiyat"])) {
							$temp=$VT->VeriGetir("urunler","WHERE durum=? AND kategori=? AND (fiyat BETWEEN ? AND ?)",array(1,$altkat["ID"],$baslamatutar,$bitistutar),"ORDER BY sirano ASC");
						} else {
							$temp=$VT->VeriGetir("urunler","WHERE durum=? AND kategori=?",array(1,$altkat["ID"]),"ORDER BY sirano ASC");
						}
						if($temp!=false) {
							$urunler = array_merge($urunler, $temp);
						}
						echo "<!-- DEBUG: Alt kategori ".$altkat["baslik"]." (ID:".$altkat["ID"].") - ".($temp!=false ? count($temp) : 0)." urun -->";
					}
				} else {
					// Alt kategori yok - direkt bu kategorideki ürünleri çek
					echo "<!-- DEBUG: Alt kategori yok, direkt urun cekiliyor -->";
					if(!empty($_GET["fiyat"])) {
						$urunler=$VT->VeriGetir("urunler","WHERE durum=? AND kategori=? AND (fiyat BETWEEN ? AND ?)",array(1,$kategoriler[0]["ID"],$baslamatutar,$bitistutar),"ORDER BY sirano ASC");
					} else {
						$urunler=$VT->VeriGetir("urunler","WHERE durum=? AND kategori=?",array(1,$kategoriler[0]["ID"]),"ORDER BY sirano ASC");
					}
					echo "<!-- DEBUG: ".($urunler!=false ? count($urunler) : 0)." urun bulundu -->";
				}

				if($urunler!=false && count($urunler)>0) {
					if($gorunum=="liste") {
						echo '<div class="products-list">';
					} else {
						echo '<div class="row gx-3 gy-4">';
					}

					foreach($urunler as $urun) {
						// Calculate discount
						$indirimOrani = 0;
						if(!empty($urun["indirimlifiyat"])) {
							$indirimlifiyat = $urun["indirimlifiyat"].".".$urun["indirimlikurus"];
							$normalfiyat = $urun["fiyat"].".".$urun["kurus"];
							$hesapla = (($indirimlifiyat/$normalfiyat)*100);
							$indirimOrani = round(100-$hesapla);
							$fiyat = $indirimlifiyat;
						} else {
							$fiyat = $urun["fiyat"].".".$urun["kurus"];
							$normalfiyat = $fiyat;
						}

						// KDV calculation
						if($urun["kdvdurum"]==1) {
							$oran = $urun["kdvoran"]>9 ? "1.".$urun["kdvoran"] : "1.0".$urun["kdvoran"];
							$fiyat = ($fiyat/$oran);
							if(!empty($urun["indirimlifiyat"])) {
								$normalfiyat = ($normalfiyat/$oran);
							}
						}

						// Product image
						$urunResim = !empty($urun["resim"]) ? $urun["resim"] : "varsayilan.png";

						if($gorunum=="liste") {
							// List View
							?>
							<div class="product-list-item">
								<div class="row align-items-center">
									<div class="col-md-4">
										<div class="product-image">
											<?php if($indirimOrani > 0) { ?>
											<span class="badge-discount">-<?=$indirimOrani?>%</span>
											<?php } ?>
											<a href="<?=SITE?>urun/<?=$urun["seflink"]?>">
												<img src="<?=SITE?>images/urunler/<?=$urunResim?>" alt="<?=stripslashes($urun["baslik"])?>" class="img-fluid">
											</a>
										</div>
									</div>
									<div class="col-md-8">
										<div class="product-content">
											<h4 class="product-title">
												<a href="<?=SITE?>urun/<?=$urun["seflink"]?>"><?=stripslashes($urun["baslik"])?></a>
											</h4>
											<div class="product-rating mb-2">
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="fas fa-star"></i>
												<i class="far fa-star"></i>
											</div>
											<p class="product-desc"><?=mb_substr(strip_tags(stripslashes($urun["metin"])),0,150,"UTF-8")?>...</p>
											<div class="product-price">
												<span class="price-current"><?=number_format($fiyat,2,",",".")?> TL</span>
												<?php if(!empty($urun["indirimlifiyat"])) { ?>
												<span class="price-old"><?=number_format($normalfiyat,2,",",".")?> TL</span>
												<?php } ?>
											</div>
											<div class="product-actions mt-3">
												<a href="<?=SITE?>urun/<?=$urun["seflink"]?>" class="vs-btn style4 btn-sm me-2">
													<i class="far fa-eye me-1"></i>Incele
												</a>
												<a onclick="favoriyeEkle('<?=SITE?>','<?=$urun["ID"]?>','<?=md5(sha1($urun["ID"]))?>');return false;" class="vs-btn style7 btn-sm">
													<i class="far fa-heart me-1"></i>Favori
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
						} else {
							// Grid View
							?>
							<div class="col-6 col-md-4">
								<div class="product-grid-item">
									<div class="product-image">
										<?php if($indirimOrani > 0) { ?>
										<span class="badge-discount">-<?=$indirimOrani?>%</span>
										<?php } ?>
										<a href="<?=SITE?>urun/<?=$urun["seflink"]?>">
											<img src="<?=SITE?>images/urunler/<?=$urunResim?>" alt="<?=stripslashes($urun["baslik"])?>" class="img-fluid">
										</a>
										<div class="product-overlay">
											<a onclick="favoriyeEkle('<?=SITE?>','<?=$urun["ID"]?>','<?=md5(sha1($urun["ID"]))?>');return false;" class="btn-wishlist" title="Favoriye Ekle">
												<i class="far fa-heart"></i>
											</a>
										</div>
									</div>
									<div class="product-content">
										<div class="product-rating">
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="fas fa-star"></i>
											<i class="far fa-star"></i>
										</div>
										<h5 class="product-title">
											<a href="<?=SITE?>urun/<?=$urun["seflink"]?>"><?=stripslashes($urun["baslik"])?></a>
										</h5>
										<div class="product-product-price">
											<span class="price-current"><?=number_format($fiyat,2,",",".")?> TL</span>
											<?php if(!empty($urun["indirimlifiyat"])) { ?>
											<span class="price-old"><?=number_format($normalfiyat,2,",",".")?> TL</span>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
							<?php
						}
					}

					echo '</div>';
				} else {
					?>
					<div class="empty-products text-center py-5">
						<div class="empty-icon mb-4">
							<i class="far fa-box-open"></i>
						</div>
						<h4 class="mb-3">Urun Bulunamadi</h4>
						<p class="mb-4">Bu kategoride urun bulunmamaktadir veya filtrelere uygun urun yok.</p>
						<a href="<?=SITE?>kategori/<?=$kategoriler[0]["seflink"]?>" class="vs-btn style4">
							<i class="far fa-redo me-2"></i>Filtreleri Sifirla
						</a>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</section>

<style>
	/* Modern Breadcrumb - Gradient Background veya Resim */
	.breadcumb-modern {
		position: relative;
		background: linear-gradient(135deg, #E3EDD7 0%, #FAE8E9 50%, #F1F7EB 100%);
		border-bottom: 3px solid #C98A8F;
	}
	/* Resimli kategoriler için */
	.breadcumb-modern.has-bg-image {
		background-size: cover;
		background-position: center;
	}
	.breadcumb-overlay {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: rgba(74, 93, 66, 0.7);
		z-index: 1;
	}
	.breadcumb-content {
		position: relative;
		z-index: 2;
	}
	/* Resimli kategorilerde beyaz metin */
	.breadcumb-modern.has-bg-image .breadcumb-title {
		color: #fff !important;
		text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
	}
	.breadcumb-modern.has-bg-image .breadcumb-menu-style1 li a,
	.breadcumb-modern.has-bg-image .breadcumb-menu-style1 li.active {
		color: #fff !important;
		text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
	}
	.breadcumb-title {
		color: #4A5D42 !important;
		font-size: 2.5rem;
		font-weight: 700;
		margin-bottom: 1rem;
		text-transform: uppercase;
		letter-spacing: 1px;
	}
	.breadcumb-menu-style1 {
		list-style: none;
		padding: 0;
		margin: 0;
		display: flex;
		justify-content: center;
		gap: 15px;
	}
	.breadcumb-menu-style1 li {
		position: relative;
	}
	.breadcumb-menu-style1 li:not(:last-child)::after {
		content: '›';
		margin-left: 15px;
		color: #809678;
	}
	.breadcumb-menu-style1 li a {
		color: #6E8366 !important;
		text-decoration: none;
		font-weight: 500;
		transition: color 0.3s;
	}
	.breadcumb-menu-style1 li a:hover {
		color: #C98A8F !important;
	}
	.breadcumb-menu-style1 li.active {
		color: #C98A8F !important;
		font-weight: 600;
	}

	/* Toolbar */
	.shop-toolbar {
		border-bottom: 1px solid #e8e8e8;
	}
	.toolbar-left p {
		color: #666;
		font-size: 14px;
	}
	.view-mode {
		display: flex;
		gap: 10px;
	}
	.view-btn {
		width: 40px;
		height: 40px;
		display: flex;
		align-items: center;
		justify-content: center;
		border: 2px solid #e8e8e8;
		border-radius: 6px;
		color: #666;
		transition: all 0.3s;
	}
	.view-btn:hover,
	.view-btn.active {
		border-color: #8B9D83;
		background: #8B9D83;
		color: #fff;
	}
	.filter-toggle {
		padding: 8px 20px;
	}

	/* Sidebar */
	.shop-sidebar {
		background: #fff;
		padding: 30px;
		border-radius: 10px;
		box-shadow: 0 3px 15px rgba(0,0,0,0.08);
	}
	.sidebar-close {
		text-align: right;
		margin-bottom: 20px;
	}
	.close-btn {
		background: none;
		border: none;
		font-size: 24px;
		color: #333;
		cursor: pointer;
	}
	.widget {
		margin-bottom: 30px;
	}
	.widget:last-child {
		margin-bottom: 0;
	}
	.widget-title {
		font-size: 18px;
		font-weight: 700;
		color: #333;
		margin-bottom: 20px;
		padding-bottom: 10px;
		border-bottom: 2px solid #8B9D83;
	}
	.category-list {
		list-style: none;
		padding: 0;
		margin: 0;
	}
	.category-list li {
		margin-bottom: 10px;
	}
	.category-item {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 10px;
		background: #f8f9fa;
		border-radius: 6px;
		color: #333;
		text-decoration: none;
		transition: all 0.3s;
	}
	.category-item:hover {
		background: #8B9D83;
		color: #fff;
	}
	.cat-count {
		font-size: 12px;
		color: #999;
	}
	.category-item:hover .cat-count {
		color: #fff;
	}
	.price-list {
		display: flex;
		flex-direction: column;
		gap: 10px;
	}
	.price-item {
		display: flex;
		align-items: center;
		padding: 10px;
		background: #f8f9fa;
		border-radius: 6px;
		cursor: pointer;
		transition: all 0.3s;
	}
	.price-item:hover {
		background: #e9ecef;
	}
	.price-item input {
		margin-right: 10px;
		accent-color: #8B9D83;
	}

	/* Product Grid */
	.product-grid-item {
		background: #fff;
		border-radius: 10px;
		overflow: hidden;
		box-shadow: 0 3px 15px rgba(0,0,0,0.08);
		transition: all 0.3s;
	}
	.product-grid-item:hover {
		transform: translateY(-5px);
		box-shadow: 0 10px 30px rgba(139, 157, 131, 0.15);
	}
	.product-image {
		position: relative;
		overflow: hidden;
	}
	.product-image img {
		width: 100%;
		height: 250px;
		object-fit: cover;
		transition: all 0.3s;
	}
	.product-grid-item:hover .product-image img {
		transform: scale(1.1);
	}
	.badge-discount {
		position: absolute;
		top: 10px;
		right: 10px;
		background: #dc3545;
		color: #fff;
		padding: 5px 10px;
		border-radius: 6px;
		font-size: 12px;
		font-weight: 700;
		z-index: 2;
	}
	.product-overlay {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: rgba(0,0,0,0.5);
		display: flex;
		align-items: center;
		justify-content: center;
		opacity: 0;
		transition: all 0.3s;
	}
	.product-grid-item:hover .product-overlay {
		opacity: 1;
	}
	.btn-wishlist {
		width: 40px;
		height: 40px;
		background: #fff;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		color: #8B9D83;
		font-size: 18px;
		cursor: pointer;
		transition: all 0.3s;
	}
	.btn-wishlist:hover {
		background: #8B9D83;
		color: #fff;
	}
	.product-content {
		padding: 20px;
	}
	.product-rating {
		font-size: 14px;
		color: #ffc107;
		margin-bottom: 10px;
	}
	.product-title {
		font-size: 16px;
		font-weight: 600;
		margin-bottom: 10px;
	}
	.product-title a {
		color: #333;
		text-decoration: none;
	}
	.product-title a:hover {
		color: #8B9D83;
	}
	.product-price {
		display: flex;
		align-items: center;
		gap: 10px;
	}
	.price-current {
		font-size: 18px;
		font-weight: 700;
		color: #8B9D83;
	}
	.price-old {
		font-size: 14px;
		color: #999;
		text-decoration: line-through;
	}

	/* Product List */
	.product-list-item {
		background: #fff;
		border-radius: 10px;
		padding: 20px;
		margin-bottom: 20px;
		box-shadow: 0 3px 15px rgba(0,0,0,0.08);
		transition: all 0.3s;
	}
	.product-list-item:hover {
		box-shadow: 0 10px 30px rgba(139, 157, 131, 0.15);
	}
	.product-list-item .product-image img {
		height: 200px;
		border-radius: 8px;
	}
	.product-desc {
		color: #666;
		font-size: 14px;
		margin-bottom: 15px;
	}

	/* Empty State */
	.empty-products {
		background: #fff;
		border-radius: 10px;
		padding: 60px 20px;
	}
	.empty-icon i {
		font-size: 80px;
		color: #ddd;
	}
	.empty-products h4 {
		color: #333;
		font-weight: 700;
	}
	.empty-products p {
		color: #666;
	}

	/* Mobile Sidebar */
	@media (max-width: 991px) {
		.shop-sidebar {
			position: fixed;
			top: 0;
			left: -100%;
			width: 300px;
			height: 100vh;
			overflow-y: auto;
			z-index: 9999;
			transition: all 0.3s;
		}
		.shop-sidebar.active {
			left: 0;
		}
		.sidebar-overlay {
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: rgba(0,0,0,0.5);
			z-index: 9998;
			display: none;
		}
		.sidebar-overlay.active {
			display: block;
		}
	}

	@media (max-width: 768px) {
		.product-image img {
			height: 200px !important;
		}
		.product-title {
			font-size: 14px;
		}
		.price-current {
			font-size: 16px;
		}
	}
</style>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Mobile filter toggle
		const filterToggle = document.querySelector('.filter-toggle');
		const sidebar = document.getElementById('shopSidebar');
		const closeBtn = document.querySelector('.close-btn');

		if(filterToggle) {
			filterToggle.addEventListener('click', function() {
				sidebar.classList.add('active');
				// Create overlay
				const overlay = document.createElement('div');
				overlay.className = 'sidebar-overlay active';
				document.body.appendChild(overlay);

				overlay.addEventListener('click', function() {
					sidebar.classList.remove('active');
					overlay.remove();
				});
			});
		}

		if(closeBtn) {
			closeBtn.addEventListener('click', function() {
				sidebar.classList.remove('active');
				const overlay = document.querySelector('.sidebar-overlay');
				if(overlay) overlay.remove();
			});
		}
	});
</script>

<?php
	}
}
?>
