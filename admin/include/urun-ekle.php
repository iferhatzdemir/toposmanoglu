<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Ürün Ekle</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=SITE?>">Anasayfa</a></li>
              <li class="breadcrumb-item active">Ürün Ekle</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
      <div class="row">
      <div class="col-md-12">
      <a href="<?=SITE?>urun-liste" class="btn btn-info" style="float:right; margin-bottom:10px; margin-left:10px;"><i class="fas fa-bars"></i> LİSTE</a> 
       <a href="<?=SITE?>urun-ekle" class="btn btn-success" style="float:right; margin-bottom:10px;"><i class="fa fa-plus"></i> YENİ EKLE</a>
       </div>
       </div>
       <?php
	   if($_POST)
	   {
		   // Debug: Hangi alanlar boş kontrol et
		   $bosAlanlar = [];
		   if(empty($_POST["kategori"])) $bosAlanlar[] = "Kategori";
		   if(empty($_POST["baslik"])) $bosAlanlar[] = "Başlık";
		   if(empty($_POST["sirano"])) $bosAlanlar[] = "Sıra No";
		   if(empty($_POST["urunkodu"])) $bosAlanlar[] = "Ürün Kodu";
		   if(empty($_POST["fiyat"])) $bosAlanlar[] = "Fiyat";
		   if(empty($_POST["kdvoran"])) $bosAlanlar[] = "KDV Oranı";
		   if(empty($_POST["kdvdurum"])) $bosAlanlar[] = "KDV Durumu";
		   if(empty($_POST["genelstok"])) $bosAlanlar[] = "Stok";
		   if(empty($_FILES["resim"]["name"])) $bosAlanlar[] = "Resim";

		   // Zorunlu alanlar: kategori, baslik, sirano, urunkodu, fiyat, kdvoran, kdvdurum, genelstok, resim
		   if(!empty($_POST["kategori"]) && !empty($_POST["baslik"]) && !empty($_POST["sirano"]) && !empty($_POST["urunkodu"]) && !empty($_POST["fiyat"]) && !empty($_POST["kdvoran"]) && !empty($_POST["kdvdurum"]) && !empty($_POST["genelstok"]) && !empty($_FILES["resim"]["name"]))
		   {
			   $kategori=$VT->filter($_POST["kategori"]);
			   $baslik=$VT->filter($_POST["baslik"]);
			   // Anahtar ve description opsiyonel
			   $anahtar=!empty($_POST["anahtar"]) ? $VT->filter($_POST["anahtar"]) : "";
			   $seflink=$VT->seflink($baslik);
			   $description=!empty($_POST["description"]) ? $VT->filter($_POST["description"]) : "";
			   $sirano=$VT->filter($_POST["sirano"]);
			   $metin=!empty($_POST["metin"]) ? $VT->filter($_POST["metin"],true) : "";
         $urunkodu=$VT->filter($_POST["urunkodu"]);
         $fiyat=$VT->filter($_POST["fiyat"]);
         $kdvoran=$VT->filter($_POST["kdvoran"]);
         $kdvdurum=$VT->filter($_POST["kdvdurum"]);
         $stok=$VT->filter($_POST["genelstok"]);

         if(!empty($_POST["kurus"])){$kurus=$_POST["kurus"];}else{$kurus="0";}
         $indirimlifiyat=false;
         if(!empty($_POST["indirimlifiyat"]))
         {
          $indirimlifiyat=$VT->filter($_POST["indirimlifiyat"]);
          if(!empty($_POST["indirimlikurus"])){$indirimlikurus=$_POST["indirimlikurus"];}else{$indirimlikurus="0";}
         }

			  
				   $yukle=$VT->upload("resim","../images/urunler/");
				   if($yukle!=false)
				   {
              $urunID=$VT->IDGetir("urunler");
            if($indirimlifiyat!=false)
            {
              $ekle=$VT->SorguCalistir("INSERT INTO urunler","SET baslik=?, seflink=?, kategori=?, metin=?, urunkodu=?, resim=?, anahtar=?, description=?, fiyat=?, kurus=?, indirimlifiyat=?, indirimlikurus=?, kdvoran=?, kdvdurum=?, stok=?, durum=?, sirano=?, tarih=?",array($baslik,$seflink,$kategori,$metin,$urunkodu,$yukle,$anahtar,$description,$fiyat,$kurus,$indirimlifiyat,$indirimlikurus,$kdvoran,$kdvdurum,$stok,1,$sirano,date("Y-m-d")));
            }
            else
            {
              $ekle=$VT->SorguCalistir("INSERT INTO urunler","SET baslik=?, seflink=?, kategori=?, metin=?, urunkodu=?, resim=?, anahtar=?, description=?, fiyat=?, kurus=?, kdvoran=?, kdvdurum=?, stok=?, durum=?, sirano=?, tarih=?",array($baslik,$seflink,$kategori,$metin,$urunkodu,$yukle,$anahtar,$description,$fiyat,$kurus,$kdvoran,$kdvdurum,$stok,1,$sirano,date("Y-m-d")));
            }

					   

				   }
				   else
				   {
             $ekle=false;
					    ?>
                   <div class="alert alert-info">Resim yükleme işleminiz başarısız.</div>
                   <?php
				   }
			  
			   $genelStokToplami=0;
			   if($ekle!=false)
			   {

            if(!empty($_SESSION["varyasyonlar"]) && !empty($_SESSION["secenekler"]))
            {
                foreach ($_SESSION["varyasyonlar"] as $value) {
                 $varyasyonAdi=$VT->filter($value);
                 $varyasyonID=$VT->IDGetir("urunvaryasyonlari");
                  $varyasyonEkle=$VT->SorguCalistir("INSERT INTO urunvaryasyonlari","SET urunID=?, baslik=?, tarih=?",array($urunID,$varyasyonAdi,date("Y-m-d")));
                  foreach ($_SESSION["secenekler"][$varyasyonAdi] as $secenek) {
                  
                      $secenekAdi=$VT->filter($secenek);
                      $secenekID=$VT->IDGetir("urunvaryasyonsecenekleri");
                      $secenekEkle=$VT->SorguCalistir("INSERT INTO urunvaryasyonsecenekleri","SET urunID=?, varyasyonID=?, baslik=?, tarih=?",array($urunID,$varyasyonID,$secenekAdi,date("Y-m-d")));

                  }

                }

                $varyasyonAdet=count($_SESSION["varyasyonlar"]);
                switch ($varyasyonAdet) {
                  case 1:
                  $varaysyon=$_SESSION["varyasyonlar"][0];
                  for($w=0;$w<count($_SESSION["secenekler"][$varaysyon]);$w++)
                   {
                      $varaysyonIDOgreneme=$VT->VeriGetir("urunvaryasyonlari","WHERE baslik=? AND urunID=?",array($varaysyon,$urunID));
                      $secenekIDOgreneme=$VT->VeriGetir("urunvaryasyonsecenekleri","WHERE baslik=? AND urunID=?",array($_SESSION["secenekler"][$varaysyon][$w],$urunID));
                      if($varaysyonIDOgreneme!=false && $secenekIDOgreneme!=false)
                      {
                        $varyasyonStok=$VT->filter($_POST["stok"][$w]);
                         $genelStokToplami=($genelStokToplami+$varyasyonStok);
                        $stokEkle=$VT->SorguCalistir("INSERT INTO urunvaryasyonstoklari","SET urunID=?, varyasyonID=?, secenekID=?, stok=?, tarih=?",array($urunID,$varaysyonIDOgreneme[0]["ID"],$secenekIDOgreneme[0]["ID"],$varyasyonStok,date("Y-m-d")));
                      }
                   }
                  break;
                  case 2:
                   $varaysyon=$_SESSION["varyasyonlar"][0];
                   $varaysyon2=$_SESSION["varyasyonlar"][1];
                   $stokNo=0;
                  for($w=0;$w<count($_SESSION["secenekler"][$varaysyon]);$w++)
                   {
                      $varaysyonIDOgreneme=$VT->VeriGetir("urunvaryasyonlari","WHERE baslik=? AND urunID=?",array($varaysyon,$urunID));
                      $secenekIDOgreneme=$VT->VeriGetir("urunvaryasyonsecenekleri","WHERE baslik=? AND urunID=?",array($_SESSION["secenekler"][$varaysyon][$w],$urunID));
                   for($r=0;$r<count($_SESSION["secenekler"][$varaysyon2]);$r++)
                   {
                     $varaysyonIDOgreneme2=$VT->VeriGetir("urunvaryasyonlari","WHERE baslik=? AND urunID=?",array($varaysyon2,$urunID));
                      $secenekIDOgreneme2=$VT->VeriGetir("urunvaryasyonsecenekleri","WHERE baslik=? AND urunID=?",array($_SESSION["secenekler"][$varaysyon2][$r],$urunID));
                      
                      if($varaysyonIDOgreneme!=false && $secenekIDOgreneme!=false && $varaysyonIDOgreneme2!=false && $secenekIDOgreneme2!=false)
                      {
                        $varyasyonStok=$VT->filter($_POST["stok"][$stokNo]);
                         $genelStokToplami=($genelStokToplami+$varyasyonStok);
                        $stokNo++;
                        $stokEkle=$VT->SorguCalistir("INSERT INTO urunvaryasyonstoklari","SET urunID=?, varyasyonID=?, secenekID=?, stok=?, tarih=?",array($urunID,$varaysyonIDOgreneme[0]["ID"]."@".$varaysyonIDOgreneme2[0]["ID"],$secenekIDOgreneme[0]["ID"]."@".$secenekIDOgreneme2[0]["ID"],$varyasyonStok,date("Y-m-d")));
                      }

                   }

                      
                   }
                    break;
                }

                unset($_SESSION["varyasyonlar"]);
                unset($_SESSION["secenekler"]);
                $urunStokGuncelle=$VT->SorguCalistir("UPDATE urunler","SET stok=? WHERE ID=?",array($genelStokToplami,$urunID),1);
            }
				    ?>
                   <div class="alert alert-success">İşleminiz başarıyla kaydedildi.</div>
                   <?php
			   }
			   else
			   {
				    ?>
                   <div class="alert alert-danger">İşleminiz sırasında bir sorunla karşılaşıldı. Lütfen daha sonra tekrar deneyiniz.</div>
                   <?php
			   }
		   }
		   else
		   {
			   ?>
               <div class="alert alert-danger">
                   <strong>Eksik Bilgi - <?=count($bosAlanlar)?> Alan Boş</strong><br>
                   Boş Bırakılan Alanlar:<br>
                   <ul style="margin-top: 10px;">
                   <?php foreach($bosAlanlar as $alan): ?>
                       <li><?=$alan?></li>
                   <?php endforeach; ?>
                   </ul>
               </div>
               <?php
		   }
	   }
	   ?>
       <form action="#" method="post" class="urunEklemeFormu" enctype="multipart/form-data">
        <div class="row">
       <div class="col-md-6">
       <div class="card-body card card-primary">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label>Kategori Seç</label>
                  <select class="form-control select2" style="width: 100%;" name="kategori">
                    <?php
					$sonuc=$VT->kategoriGetir("urunler","",-1);
					if($sonuc!=false)
					{
						echo $sonuc;
					}
					else
					{
						$VT->tekKategori("urunler");
					}
					?>
                  </select>
                </div>
              <!-- /.col -->
            </div>
            <div class="col-md-12">
                <div class="form-group">
                <label>Başlık</label>
                <input type="text" class="form-control" placeholder="Başlık ..." name="baslik">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                <label>Açıklama</label>
                <textarea class="textarea" placeholder="Açıklama alanıdır." name="metin"
                          style="width: 100%; height: 350px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
            </div>
             <div class="col-md-12">
                <div class="form-group">
                <label>Anahtar</label>
                <input type="text" class="form-control" placeholder="Anahtar ..." name="anahtar">
                </div>
            </div>
             <div class="col-md-12">
                <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control" placeholder="Description ..." name="description">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                <label>Resim <small class="text-muted">(JPG, JPEG, PNG, GIF, WebP, SVG - Maks. 5MB)</small></label>
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="resimInput" name="resim" accept="image/jpeg,image/jpg,image/png,image/gif,image/webp,image/svg+xml">
                  <label class="custom-file-label" for="resimInput">Resim seçiniz...</label>
                </div>
                <small class="form-text text-muted">
                  <i class="fas fa-info-circle"></i> Desteklenen formatlar: JPG, JPEG, PNG, GIF, WebP, SVG
                </small>
                <div id="resimOnizleme" style="margin-top: 15px; display: none;">
                  <div class="card">
                    <div class="card-header bg-light">
                      <h6 class="mb-0"><i class="fas fa-image"></i> Resim Önizleme</h6>
                    </div>
                    <div class="card-body text-center">
                      <img id="onizlemeResim" src="" alt="Önizleme" style="max-width: 100%; max-height: 300px; border: 2px dashed #dee2e6; padding: 10px; border-radius: 5px;">
                      <div id="resimBilgi" class="mt-3">
                        <p class="mb-1"><strong>Dosya Adı:</strong> <span id="dosyaAdi"></span></p>
                        <p class="mb-1"><strong>Dosya Boyutu:</strong> <span id="dosyaBoyutu"></span></p>
                        <p class="mb-1"><strong>Boyutlar:</strong> <span id="resimBoyutlari"></span></p>
                        <p class="mb-0"><strong>Tip:</strong> <span id="dosyaTipi"></span></p>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
            </div>
            
          
            
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
        </div>
        </div>
         <div class="col-md-6">
         <div class="card-body card card-primary">
              <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                <label>Ürün Kodu</label>
                <input type="text" class="form-control" placeholder="Ürün Kodu ..." name="urunkodu">
                  </div>
              </div>

              <div class="col-md-8">
                <div class="form-group">
                <label>Fiyat</label>
                <input type="text" class="form-control" placeholder="Fiyat ..." name="fiyat">
                  </div>
              </div>
               <div class="col-md-3">
                <div class="form-group">
                <label>Kuruş</label>
                <input type="text" class="form-control" placeholder="Kuruş ..." name="kurus"  maxlength="2" value="00">
                  </div>
              </div>
              <div class="col-md-8">
                <div class="form-group">
                <label>İndirimli Fiyat</label>
                <input type="text" class="form-control" placeholder="İndirimli Fiyat ..." name="indirimlifiyat">
                  </div>
              </div>
               <div class="col-md-3">
                <div class="form-group">
                <label>İndirimli Kuruş</label>
                <input type="text" class="form-control" placeholder="İndirimli Kuruş ..." name="indirimlikurus" maxlength="2" value="00">
                  </div>
              </div>

              <div class="col-md-12">
                <div class="form-group">
                <label>KDV Oranı</label>
                <select class="form-control" name="kdvoran">
                  <option value="18">%18</option>
                  <option value="8">%8</option>
                  <option value="6">%6</option>
                  <option value="1">%1</option>
                </select>
                  </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                <label>KDV Durumu</label>
                <select class="form-control" name="kdvdurum">
                  <option value="1">KDV Dahil</option>
                  <option value="2">KDV Hariç</option>
                </select>
                  </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                <label>Stok</label>
                <input type="number" class="form-control" placeholder="Stok ..." name="genelstok" style="width:100px;" min="1" value="1">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                <label>Sıra No</label>
                <input type="number" class="form-control" placeholder="Sıra No ..." name="sirano" style="width:100px;" value="<?php
                $sirano=$VT->IDGetir("urunler");
                if($sirano!=false){
                  echo $sirano;
                }
                else
                {
                  echo "1";
                }
                ?>">
                </div>
            </div>

              </div>
          </div>
        </div>
        <div class="col-md-12" style="margin-bottom: 20px;">
          <div class="card card-primary card-outline">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-layer-group"></i> Ürün Varyasyonları</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-primary varyasyonEkleme">
                  <i class="fa fa-plus"></i> Varyasyon Ekle
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <strong>Bilgi:</strong> Ürününüz için farklı varyasyonlar (örn: Beden, Renk, Kapasite) ekleyebilirsiniz.
                Her varyasyon için seçenekler ekledikçe stok tablosu otomatik olarak oluşturulacaktır.
              </div>
              <div class="row varyasyonGrup" style="display:block; clear: both;"></div>
              <div class="row stokYonetimAlani" style="display: block; clear: both; margin-top: 20px;"></div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary">KAYDET</button>
                </div>
            </div>
        </div>
      </div>
       </form>
       
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
 
