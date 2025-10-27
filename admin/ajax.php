<?php
@session_start();
@ob_start();
define("DATA","data/");
define("SAYFA","include/");
define("SINIF","class/");
include_once(DATA."baglanti.php");
define("SITE",$siteURL."admin/");
define("ANASITE",$siteURL);
if(!empty($_POST["tablo"]) && !empty($_POST["ID"]) && $_FILES && !empty($_FILES["file"]["tmp_name"]))
	{
			 $tablo=$VT->filter($_POST["tablo"]);
 			 $ID=$VT->filter($_POST["ID"]);
 			 $resim=$VT->uploadMulti("file",$tablo,$ID,"../images/resimler/");
				 
	}
if($_POST)
{
	// Toplu resim silme işlemi
	if(!empty($_POST["action"]) && $_POST["action"] == "topluResimSil" && !empty($_POST["resimIds"]))
	{
		$resimIds = $_POST["resimIds"];
		$tablo = $VT->filter($_POST["tablo"]);
		$KID = $VT->filter($_POST["KID"]);

		$basarili = true;
		foreach($resimIds as $resimId)
		{
			$resimId = $VT->filter($resimId);

			// Resim bilgisini al
			$resimBilgi = $VT->VeriGetir("resimler", "WHERE ID=? AND tablo=? AND KID=?", array($resimId, $tablo, $KID), "");

			if($resimBilgi != false)
			{
				// Dosyayı sil
				if(!empty($resimBilgi[0]["resim"]) && file_exists("../images/resimler/".$resimBilgi[0]["resim"]))
				{
					unlink("../images/resimler/".$resimBilgi[0]["resim"]);
				}

				// Veritabanından sil
				$sil = $VT->SorguCalistir("DELETE FROM resimler", "WHERE ID=?", array($resimId));
				if($sil == false)
				{
					$basarili = false;
				}
			}
		}

		if($basarili)
		{
			echo "success";
		}
		else
		{
			echo "error";
		}
		exit;
	}

	// Yorum işlemleri
	if(!empty($_POST["action"]) && $_POST["action"] == "yorumIslem" && !empty($_POST["islem"]) && !empty($_POST["idler"]))
	{
		$islem = $VT->filter($_POST["islem"]);
		$idler = $_POST["idler"];
		$admin_notu = isset($_POST["admin_notu"]) ? $VT->filter($_POST["admin_notu"]) : "";

		$basarili = true;
		foreach($idler as $yorumId)
		{
			$yorumId = $VT->filter($yorumId);

			switch($islem) {
				case 'onayla':
					$guncelle = $VT->SorguCalistir("UPDATE testimonials", "SET onay_durumu=?, durum=?, onay_tarihi=NOW() WHERE ID=?", array("onaylandi", 1, $yorumId));
					break;
				case 'reddet':
					$guncelle = $VT->SorguCalistir("UPDATE testimonials", "SET onay_durumu=?, durum=?, admin_notu=?, onay_tarihi=NOW() WHERE ID=?", array("reddedildi", 0, $admin_notu, $yorumId));
					break;
				case 'sil':
					$guncelle = $VT->SorguCalistir("DELETE FROM testimonials", "WHERE ID=?", array($yorumId));
					break;
				default:
					$guncelle = false;
			}

			if($guncelle == false) {
				$basarili = false;
			}
		}

		if($basarili) {
			echo "success";
		} else {
			echo "error";
		}
		exit;
	}

	// Testimonial detay getir
	if(!empty($_POST["action"]) && $_POST["action"] == "testimonialDetayGetir" && !empty($_POST["testimonialID"]))
	{
		$testimonialID = $VT->filter($_POST["testimonialID"]);

		$testimonial = $VT->VeriGetir("testimonials", "WHERE ID=?", array($testimonialID), "ORDER BY ID ASC", 1);
		if($testimonial != false)
		{
			// Onay durumu badge
			$onay_durumu_badge = "";
			switch($testimonial[0]["onay_durumu"]) {
				case 'beklemede':
					$onay_durumu_badge = '<span class="badge badge-warning">Beklemede</span>';
					break;
				case 'onaylandi':
					$onay_durumu_badge = '<span class="badge badge-success">Onaylandı</span>';
					break;
				case 'reddedildi':
					$onay_durumu_badge = '<span class="badge badge-danger">Reddedildi</span>';
					break;
			}

			// Yayın durumu badge
			$yayin_durumu_badge = ($testimonial[0]["durum"] == 1) ?
				'<span class="badge badge-success">Yayında</span>' :
				'<span class="badge badge-secondary">Pasif</span>';

			// Yıldızlar
			$yildizlar = "";
			$puan = intval($testimonial[0]["puan"]);
			for($j = 1; $j <= 5; $j++) {
				if($j <= $puan) {
					$yildizlar .= "<i class='fas fa-star text-warning'></i>";
				} else {
					$yildizlar .= "<i class='far fa-star text-muted'></i>";
				}
			}

			// Resim yolu
			$resim = "";
			if(!empty($testimonial[0]["resim"])) {
				$resim = ANASITE."images/testimonials/".$testimonial[0]["resim"];
			}

			$response = array(
				'success' => true,
				'ad_soyad' => stripslashes($testimonial[0]["ad_soyad"]),
				'uyeID' => $testimonial[0]["uyeID"],
				'resim' => $resim,
				'yorum' => stripslashes($testimonial[0]["yorum"]),
				'puan' => $puan,
				'yildizlar' => $yildizlar,
				'google_link' => $testimonial[0]["google_link"],
				'admin_notu' => stripslashes($testimonial[0]["admin_notu"]),
				'onay_durumu_badge' => $onay_durumu_badge,
				'yayin_durumu_badge' => $yayin_durumu_badge,
				'tarih' => date("d.m.Y H:i", strtotime($testimonial[0]["tarih"]))
			);

			echo json_encode($response);
		}
		else
		{
			echo json_encode(array('success' => false, 'message' => 'Testimonial bulunamadı'));
		}
		exit;
	}

	// Ürün yorum işlemleri
	if(!empty($_POST["action"]) && $_POST["action"] == "urunYorumIslem" && !empty($_POST["islem"]) && !empty($_POST["idler"]))
	{
		$islem = $VT->filter($_POST["islem"]);
		$idler = $_POST["idler"];

		$basarili = true;
		foreach($idler as $yorumId)
		{
			$yorumId = $VT->filter($yorumId);

			switch($islem) {
				case 'onayla':
					$guncelle = $VT->SorguCalistir("UPDATE yorumlar", "SET durum=? WHERE ID=?", array(1, $yorumId));
					break;
				case 'sil':
					$guncelle = $VT->SorguCalistir("DELETE FROM yorumlar", "WHERE ID=?", array($yorumId));
					break;
				default:
					$guncelle = false;
			}

			if($guncelle == false) {
				$basarili = false;
			}
		}

		if($basarili) {
			echo "success";
		} else {
			echo "error";
		}
		exit;
	}

	// Yorum detay getir
	if(!empty($_POST["action"]) && $_POST["action"] == "yorumDetayGetir" && !empty($_POST["yorumID"]))
	{
		$yorumID = $VT->filter($_POST["yorumID"]);

		$yorumlar = $VT->VeriGetir("yorumlar", "WHERE ID=?", array($yorumID), "ORDER BY ID ASC", 1);
		if($yorumlar != false)
		{
			$uyebilgisi = $VT->VeriGetir("uyeler", "WHERE ID=?", array($yorumlar[0]["uyeID"]), "ORDER BY ID ASC", 1);
			$urunbilgisi = $VT->VeriGetir("urunler", "WHERE ID=?", array($yorumlar[0]["urunID"]), "ORDER BY ID ASC", 1);

			if($uyebilgisi != false && $urunbilgisi != false)
			{
				// Üye adı
				if($uyebilgisi[0]["tipi"] == 1) {
					$uyeAdi = stripslashes($uyebilgisi[0]["ad"]." ".$uyebilgisi[0]["soyad"]);
				} else {
					$uyeAdi = stripslashes($uyebilgisi[0]["firmaadi"]);
				}

				// Durum
				$durum = ($yorumlar[0]["durum"] == 1) ? '<strong style="color:#4caf50;">YAYINDA</strong>' : '<strong style="color:#ff9800;">PASİF</strong>';

				// Yıldızlar
				$yildizlar = "";
				$puan = intval($yorumlar[0]["puan"]);
				for($j = 1; $j <= 5; $j++) {
					if($j <= $puan) {
						$yildizlar .= "<i class='fas fa-star text-warning'></i>";
					} else {
						$yildizlar .= "<i class='far fa-star text-muted'></i>";
					}
				}

				$response = array(
					'success' => true,
					'uyeAdi' => $uyeAdi,
					'uyeMail' => $uyebilgisi[0]["mail"],
					'urunBaslik' => stripslashes($urunbilgisi[0]["baslik"]),
					'urunResim' => $urunbilgisi[0]["resim"],
					'tarih' => date("d.m.Y", strtotime($yorumlar[0]["tarih"])),
					'metin' => stripslashes($yorumlar[0]["metin"]),
					'puan' => $puan,
					'yildizlar' => $yildizlar,
					'durum' => $durum
				);

				echo json_encode($response);
			}
			else
			{
				echo json_encode(array('success' => false, 'message' => 'Üye veya ürün bilgisi bulunamadı'));
			}
		}
		else
		{
			echo json_encode(array('success' => false, 'message' => 'Yorum bulunamadı'));
		}
		exit;
	}

	if(!empty($_POST["tablo"]) && !empty($_POST["ID"]) && !empty($_POST["durum"]))
	{
		$tablo=$VT->filter($_POST["tablo"]);
		$ID=$VT->filter($_POST["ID"]);
		$durum=$VT->filter($_POST["durum"]);
		$guncelle=$VT->SorguCalistir("UPDATE ".$tablo,"SET durum=? WHERE ID=?",array($durum,$ID),1);
		if($guncelle!=false)
		{
			echo "TAMAM";
		}
		else
		{
			echo "HATA";
		}
	}
	else if(!empty($_POST["tablo"]) && !empty($_POST["ID"]) && !empty($_POST["vitrindurum"]))
	{
		$tablo=$VT->filter($_POST["tablo"]);
		$ID=$VT->filter($_POST["ID"]);
		$durum=$VT->filter($_POST["vitrindurum"]);
		$guncelle=$VT->SorguCalistir("UPDATE ".$tablo,"SET vitrindurum=? WHERE ID=?",array($durum,$ID),1);
		if($guncelle!=false)
		{
			echo "TAMAM";
		}
		else
		{
			echo "HATA";
		}
	}
	else if(!empty($_POST["varyasyon1"]) && !empty($_POST["secenek1"]))
	{
		$varyasyon1=$VT->filter($_POST["varyasyon1"]);

		// İki varyasyon varsa (Beden + Renk gibi)
		if(!empty($_POST["varyasyon2"]) && !empty($_POST["secenek2"]))
		{
			$varyasyon2=$VT->filter($_POST["varyasyon2"]);
			$_SESSION["varyasyonlar"]=array($varyasyon1,$varyasyon2);
			$_SESSION["secenekler"]=array($varyasyon1=>$_POST["secenek1"],$varyasyon2=>$_POST["secenek2"]);
			?>
			<div class="alert alert-info">
				<strong><i class="fas fa-info-circle"></i> Varyasyon Bilgisi:</strong>
				<strong><?=$varyasyon1?></strong> için <?=count($_POST["secenek1"])?> seçenek,
				<strong><?=$varyasyon2?></strong> için <?=count($_POST["secenek2"])?> seçenek eklendi.
				Toplam <strong><?=(count($_POST["secenek1"]) * count($_POST["secenek2"]))?> kombinasyon</strong> oluşturuldu.
			</div>
			<table class="table table-bordered table-striped">
				<thead class="bg-light">
					<tr>
						<th style="width: 60%;">Varyasyon Kombinasyonu</th>
						<th style="width: 40%;">Stok Adedi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$kombinasyonNo = 0;
					for($i=0;$i<count($_POST["secenek1"]);$i++)
					{
						for($x=0;$x<count($_POST["secenek2"]);$x++)
						{
							$kombinasyonNo++;
							?>
							<tr>
								<td>
									<strong><?=$kombinasyonNo?>.</strong>
									<?=$_POST["secenek1"][$i]?> <?=$varyasyon1?>
									<i class="fas fa-times text-muted mx-2"></i>
									<?=$_POST["secenek2"][$x]?> <?=$varyasyon2?>
								</td>
								<td>
									<input type="number" class="form-control form-control-sm" value="1" name="stok[]" min="0" style="width: 100px;">
								</td>
							</tr>
							<?php
						}
					}
					?>
				</tbody>
			</table>
			<?php
		}
		// Tek varyasyon varsa (Sadece Beden gibi)
		else
		{
			$_SESSION["varyasyonlar"]=array($varyasyon1);
			$_SESSION["secenekler"]=array($varyasyon1=>$_POST["secenek1"]);
			?>
			<div class="alert alert-info">
				<strong><i class="fas fa-info-circle"></i> Varyasyon Bilgisi:</strong>
				<strong><?=$varyasyon1?></strong> için <strong><?=count($_POST["secenek1"])?> seçenek</strong> eklendi.
			</div>
			<table class="table table-bordered table-striped">
				<thead class="bg-light">
					<tr>
						<th style="width: 60%;">Varyasyon</th>
						<th style="width: 40%;">Stok Adedi</th>
					</tr>
				</thead>
				<tbody>
					<?php
					for($i=0;$i<count($_POST["secenek1"]);$i++)
					{
						?>
						<tr>
							<td>
								<strong><?=($i+1)?>.</strong> <?=$_POST["secenek1"][$i]?> <?=$varyasyon1?>
							</td>
							<td>
								<input class="form-control form-control-sm" type="number" value="1" name="stok[]" min="0" style="width: 100px;">
							</td>
						</tr>
						<?php
					}
					?>
				</tbody>
			</table>
			<?php
		}
	}
	else
	{
		echo "BOS";
	}
}
?>