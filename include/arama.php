<main>
		
		<div class="bg_gray">
		<div class="container margin_60_35">
			<div class="main_title">
				<h2>Arama Sonuçları</h2>
				<p>Merak ettiğiniz neler mi var?</p>
			</div>
			<div class="row small-gutters">
				<?php
				$SRC=false;
					if(!empty($_GET["search"]))
					{
						$aranacakKelime=$VT->filter($_GET["search"]);
						$urunler=$VT->VeriGetir("urunler","WHERE durum=? AND (baslik LIKE ? OR metin LIKE ? OR urunkodu LIKE ?)",array(1,"%".$aranacakKelime."%","%".$aranacakKelime."%","%".$aranacakKelime."%"),"ORDER BY sirano ASC");
						if($urunler!=false)
						{
						}
						else
						{
							$SRC=true;
							$urunler=$VT->VeriGetir("urunler","WHERE durum=?",array(1),"ORDER BY RAND() ASC",32);
						}
					}
					else
					{
						$urunler=$VT->VeriGetir("urunler","WHERE durum=?",array(1),"ORDER BY RAND() ASC",32);
					}
					if($SRC!=false)
					{
						?>
						<div class="col-md-12" style="padding-top: 8px; padding-bottom: 8px; margin-bottom: 10px; background: #f1e4ff; border: 1px solid #ddd;">
							Aradığınız kriterlere uygun ürün bulamadık. Ama size önereceğimiz şu ürünlere göz atın.
						</div>
						<?php
					}
				if($urunler!=false)
				{
					for ($i=0; $i <count($urunler) ; $i++) 
					{ 
						?>
						<div class="col-6 col-md-4 col-xl-3">
					<div class="grid_item">
						<figure class="ozelyukseklik">
							<?php
							if(!empty($urunler[$i]["indirimlifiyat"]))
							{
								$indirimlifiyat=$urunler[$i]["indirimlifiyat"].".".$urunler[$i]["indirimlikurus"];
								$normalfiyat=$urunler[$i]["fiyat"].".".$urunler[$i]["kurus"];
								$hesapla=(($indirimlifiyat/$normalfiyat)*100);
								$indirimorani=round(100-$hesapla); 
								/*indirim oranı hesaplama*/
								?>
								<span class="ribbon off">%<?=$indirimorani?> İndirim</span>
								<?php
							}
							?>
							<a href="<?=SITE?>urun/<?=$urunler[$i]["seflink"]?>">
								<img class="img-fluid lazy" src="<?=SITE?>images/urunler/<?=$urunler[$i]["resim"]?>" data-src="<?=SITE?>images/urunler/<?=$urunler[$i]["resim"]?>" alt="<?=stripslashes($urunler[$i]["baslik"])?>">
								
							</a>
						</figure>
						<div class="rating"><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star"></i></div>
						<a href="<?=SITE?>urun/<?=$urunler[$i]["seflink"]?>">
							<h3><?=stripslashes($urunler[$i]["baslik"])?></h3>
						</a>
						<div class="price_box">
							<?php
							if(!empty($urunler[$i]["indirimlifiyat"]))
							{
								$fiyat=$urunler[$i]["indirimlifiyat"].".".$urunler[$i]["indirimlikurus"];
								$normalfiyat=$urunler[$i]["fiyat"].".".$urunler[$i]["kurus"];
								if($urunler[$i]["kdvdurum"]==1)
							{
								if($urunler[$i]["kdvoran"]>9)
								{
									$oran="1.".$urunler[$i]["kdvoran"];
								}
								else
								{
									$oran="1.0".$urunler[$i]["kdvoran"];
								}
								$fiyat=($fiyat/$oran);/*kdvsiz hali*/
								$normalfiyat=($normalfiyat/$oran);
							}

								?>
								<span class="new_price"><?=number_format($fiyat,2,",",".")?> TL</span>
							<span class="old_price"><?=number_format($normalfiyat,2,",",".")?> TL</span>
								<?php
							}
							else
							{
								$fiyat=$urunler[$i]["fiyat"].".".$urunler[$i]["kurus"];
								if($urunler[$i]["kdvdurum"]==1)
							{
								if($urunler[$i]["kdvoran"]>9)
								{
									$oran="1.".$urunler[$i]["kdvoran"];
								}
								else
								{
									$oran="1.0".$urunler[$i]["kdvoran"];
								}
								$fiyat=($fiyat/$oran);/*kdvsiz hali*/
							}

								?>
								<span class="new_price"><?=number_format($fiyat,2,",",".")?> TL</span>
								<?php
							}
							?>
							
						</div>
						<ul>
							<li><a onclick="favoriyeEkle('<?=SITE?>','<?=$urunler[$i]["ID"]?>','<?=md5(sha1($urunler[$i]["ID"]))?>');" class="tooltip-1" data-toggle="tooltip" data-placement="left" title="Favoriye Ekle"><i class="ti-heart"></i><span>Favoriye Ekle</span></a></li>
							
						</ul>
					</div>
					<!-- /grid_item -->
				</div>
				<!-- /col -->
						<?php
					}
				}
				?>
				<!-- /box_news -->
			</div>
		</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</main>
	<!-- /main -->