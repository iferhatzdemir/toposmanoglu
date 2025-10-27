<?php
if(!empty($_GET["ID"]))
{
  $ID=$VT->filter($_GET["ID"]);

    $veri=$VT->VeriGetir("banner","WHERE ID=?",array($ID),"ORDER BY ID ASC",1);
    if($veri!=false)
    {
?>
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row align-items-center mb-3">
          <div class="col-sm-6">
            <h1 class="m-0" style="color: #9f1239; border-left: 4px solid #f43f5e; padding-left: 15px;">Banner Düzenle</h1>
          </div>
          <div class="col-sm-6 text-right">
            <a href="<?=SITE?>banner-liste" class="btn btn-outline-secondary btn-sm">
              <i class="fas fa-list mr-1"></i> Liste
            </a>
            <a href="<?=SITE?>banner-ekle" class="btn btn-primary btn-sm">
              <i class="fas fa-plus mr-1"></i> Yeni Ekle
            </a>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
       <?php
          if($_POST)
          {
                  if(!empty($_POST["sirano"]))
                  {
                          $baslik=$VT->filter($_POST["baslik"]);
        $aciklama=$VT->filter($_POST["aciklama"]);
        $url=$VT->filter($_POST["url"]);
                          $sirano=$VT->filter($_POST["sirano"]);

        $eskiMasaustu = $veri[0]["resim"];
        $eskiMobil = $veri[0]["resim_mobil"];
        $masaustuResim = $eskiMasaustu;
        $mobilResim = $eskiMobil;
        $hata=false;
        $mobilYenilendi=false;

        if(!empty($_FILES["resim"]["name"]))
        {
         $yeniMasaustu=$VT->upload("resim","../images/banner/");
          if($yeniMasaustu!=false)
          {
            if(!empty($masaustuResim) && file_exists("../images/banner/".$masaustuResim) && $masaustuResim!=$yeniMasaustu)
            {
              unlink("../images/banner/".$masaustuResim);
            }
            $masaustuResim=$yeniMasaustu;
          }
          else
          {
            $hata=true;
             ?>
                  <div class="alert alert-info alert-dismissible fade show">
                    <strong>Bilgi!</strong> Masaüstü banner yükleme işleminiz başarısız.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Kapat">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <?php
          }
        }

        if(!$hata && !empty($_FILES["resim_mobil"]["name"]))
        {
         $yeniMobil=$VT->upload("resim_mobil","../images/banner/");
         if($yeniMobil!=false)
         {
         if(!empty($mobilResim) && file_exists("../images/banner/".$mobilResim) && $mobilResim!=$yeniMobil && $mobilResim!=$masaustuResim)
          {
            unlink("../images/banner/".$mobilResim);
          }
          $mobilResim=$yeniMobil;
          $mobilYenilendi=true;
         }
         else
         {
          $hata=true;
          ?>
                  <div class="alert alert-info alert-dismissible fade show">
                    <strong>Bilgi!</strong> Mobil banner yükleme işleminiz başarısız.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Kapat">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <?php
         }
        }

        if(!$hata)
        {
         $ekle=$VT->SorguCalistir(
          "UPDATE banner",
          "SET baslik=?, aciklama=?, url=?, resim=?, resim_mobil=?, durum=?, sirano=?, tarih=? WHERE ID=?",
          array($baslik,$aciklama,$url,$masaustuResim,$mobilResim,1,$sirano,date("Y-m-d"),$veri[0]["ID"]),
          1
         );
        }
        else
        {
         $ekle=false;
        }


                          if($ekle!=false)
                          {
                                   ?>
                   <div class="alert alert-success alert-dismissible fade show">
                     <strong>Başarılı!</strong> İşleminiz başarıyla güncellendi.
                     <button type="button" class="close" data-dismiss="alert" aria-label="Kapat">
                       <span aria-hidden="true">&times;</span>
                     </button>
                   </div>
                   <?php
			   }
			   else
			   {
				    ?>
                   <div class="alert alert-danger alert-dismissible fade show">
                     <strong>Hata!</strong> İşleminiz sırasında bir sorunla karşılaşıldı.
                     <button type="button" class="close" data-dismiss="alert" aria-label="Kapat">
                       <span aria-hidden="true">&times;</span>
                     </button>
                   </div>
                   <?php
			   }
		   }
                  else
                  {
                          ?>
              <div class="alert alert-danger alert-dismissible fade show">
                <strong>Uyarı!</strong> Sıra numarası alanını doldurunuz.
                <button type="button" class="close" data-dismiss="alert" aria-label="Kapat">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <?php
                  }
	   }
	   ?>
       <div class="row">
         <div class="col-lg-10 offset-lg-1">
           <div class="card">
             <div class="card-header">
               <h3 class="card-title">Banner Bilgileri</h3>
             </div>
             <div class="card-body">
               <form action="#" method="post" enctype="multipart/form-data">
                 <div class="form-group">
                   <label for="baslik">Banner Başlığı</label>
                   <input type="text" class="form-control" id="baslik" placeholder="Banner başlığı giriniz" name="baslik" value="<?=$veri[0]["baslik"]?>">
                 </div>

                 <div class="form-group">
                   <label for="aciklama">Açıklama</label>
                   <input type="text" class="form-control" id="aciklama" placeholder="Banner açıklaması giriniz" name="aciklama" value="<?=$veri[0]["aciklama"]?>">
                 </div>

                 <div class="form-group">
                   <label for="url">URL Adresi</label>
                   <input type="text" class="form-control" id="url" placeholder="https://ornek.com" name="url" value="<?=$veri[0]["url"]?>">
                 </div>

                <hr class="my-4">

                 <div class="row">
                  <div class="col-md-6">
                    <div class="form-group banner-upload-group">
                      <label for="resim" class="d-flex align-items-center justify-content-between">
                        <span>Masaüstü Banner Görseli</span>
                        <span class="badge badge-pill badge-required">Zorunlu</span>
                      </label>
                      <div id="desktopBannerPreviewEdit" class="banner-upload-zone <?php if(!empty($veri[0]["resim"])) echo 'has-image'; ?>">
                        <div class="banner-upload-text">
                          <i class="fas fa-desktop"></i>
                          <strong>1920 x 700 px</strong>
                          <span>Geniş formatlı bir görsel yükleyiniz.</span>
                        </div>
                        <img src="<?php if(!empty($veri[0]["resim"])) echo SITE.'../images/banner/'.$veri[0]["resim"]; ?>" alt="Mevcut masaüstü banner" class="banner-upload-image" />
                      </div>
                      <div class="custom-file mt-3">
                        <input type="file" class="custom-file-input banner-upload-input" id="resim" name="resim" accept="image/*" data-preview-target="#desktopBannerPreviewEdit">
                        <label class="custom-file-label" for="resim">Dosya seçiniz...</label>
                      </div>
                      <small class="form-text text-muted">Yeni görsel seçmezseniz mevcut masaüstü görseli korunur.</small>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group banner-upload-group">
                      <label for="resim_mobil" class="d-flex align-items-center justify-content-between">
                        <span>Mobil Banner Görseli</span>
                        <span class="badge badge-pill badge-required">Zorunlu</span>
                      </label>
                      <div id="mobileBannerPreviewEdit" class="banner-upload-zone <?php if(!empty($veri[0]["resim_mobil"])) echo 'has-image'; ?>">
                        <div class="banner-upload-text">
                          <i class="fas fa-mobile-alt"></i>
                          <strong>800 x 1000 px</strong>
                          <span>Dikey oranlı bir görsel tercih ediniz.</span>
                        </div>
                        <img src="<?php if(!empty($veri[0]["resim_mobil"])) echo SITE.'../images/banner/'.$veri[0]["resim_mobil"]; ?>" alt="Mevcut mobil banner" class="banner-upload-image" />
                      </div>
                      <div class="custom-file mt-3">
                        <input type="file" class="custom-file-input banner-upload-input" id="resim_mobil" name="resim_mobil" accept="image/*" data-preview-target="#mobileBannerPreviewEdit">
                        <label class="custom-file-label" for="resim_mobil">Dosya seçiniz...</label>
                      </div>
                      <small class="form-text text-muted">Mobil için farklı bir görsel seçebilir veya mevcut görseli koruyabilirsiniz.</small>
                    </div>
                  </div>
                 </div>

                 <div class="form-group">
                   <label for="sirano">Sıra No</label>
                   <input type="number" class="form-control" id="sirano" name="sirano" value="<?=$veri[0]["sirano"]?>" style="width: 150px;">
                 </div>

                 <hr class="my-4">
                 <div class="text-right">
                   <a href="<?=SITE?>banner-liste" class="btn btn-secondary">İptal</a>
                   <button type="submit" class="btn btn-primary">
                     <i class="fas fa-save mr-1"></i> Güncelle
                   </button>
                 </div>
               </form>
             </div>
           </div>
         </div>
       </div>

       <style>
         /* Gül Kurusu Renk Paleti */
         :root {
           --rose-50: #fff1f2;
           --rose-100: #ffe4e6;
           --rose-200: #fecdd3;
           --rose-300: #fda4af;
           --rose-400: #fb7185;
           --rose-500: #f43f5e;
           --rose-600: #e11d48;
           --rose-700: #be123c;
           --rose-800: #9f1239;
           --rose-900: #881337;
         }

         .card {
           border-radius: 0.25rem;
           box-shadow: 0 4px 12px rgba(244, 63, 94, 0.15);
           transition: all 0.3s ease;
         }

         .card:hover {
           box-shadow: 0 6px 16px rgba(244, 63, 94, 0.25);
         }

         .card-header {
           background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%);
           border-bottom: 2px solid #fecdd3;
           color: #9f1239;
           font-weight: 600;
         }

         .btn-primary {
           background: linear-gradient(135deg, #f43f5e 0%, #e11d48 100%);
           border: none;
           color: white;
           transition: all 0.3s ease;
         }

         .btn-primary:hover {
           background: linear-gradient(135deg, #e11d48 0%, #be123c 100%);
           transform: translateY(-2px);
           box-shadow: 0 4px 12px rgba(244, 63, 94, 0.3);
         }

         .btn-outline-primary {
           color: #f43f5e;
           border-color: #f43f5e;
         }

         .btn-outline-primary:hover {
           background-color: #f43f5e;
           border-color: #f43f5e;
           color: white;
         }

         .alert-success {
           background: #ffe4e6;
           border-color: #fda4af;
           color: #be123c;
         }

         .custom-file-label::after {
           background-color: #f43f5e;
           color: white;
         }

         .badge-required {
           background: rgba(244, 63, 94, 0.1);
           color: #be123c;
           font-weight: 600;
           border: 1px solid rgba(244, 63, 94, 0.35);
         }

         .banner-upload-group {
           margin-bottom: 2rem;
         }

         .banner-upload-zone {
           position: relative;
           border: 2px dashed rgba(244, 63, 94, 0.45);
           border-radius: 1rem;
           padding: 2rem 1.25rem;
           background: rgba(255, 241, 242, 0.65);
           text-align: center;
           min-height: 220px;
           display: flex;
           justify-content: center;
           align-items: center;
           transition: all 0.3s ease;
           overflow: hidden;
         }

         .banner-upload-zone:hover {
           border-color: #f43f5e;
           background: rgba(255, 228, 230, 0.6);
           box-shadow: inset 0 0 0 1px rgba(244, 63, 94, 0.1);
         }

         .banner-upload-zone .banner-upload-text {
           color: #9f1239;
           display: flex;
           flex-direction: column;
           gap: 0.5rem;
           align-items: center;
           font-size: 0.95rem;
           font-weight: 500;
         }

         .banner-upload-zone .banner-upload-text i {
           font-size: 2.5rem;
           color: #f43f5e;
         }

         .banner-upload-image {
           display: none;
           max-width: 100%;
           border-radius: 0.75rem;
           box-shadow: 0 10px 30px rgba(244, 63, 94, 0.2);
         }

         .banner-upload-zone.has-image {
           border-style: solid;
           border-color: rgba(244, 63, 94, 0.4);
           background: white;
         }

         .banner-upload-zone.has-image .banner-upload-text {
           display: none;
         }

         .banner-upload-zone.has-image .banner-upload-image {
           display: block;
         }

         label {
           color: #9f1239;
           font-weight: 500;
         }
       </style>

       <script>
       $(document).ready(function() {
         function updateBannerPreview(input) {
           var targetSelector = $(input).data('preview-target');
           if (!targetSelector) { return; }

           var $zone = $(targetSelector);
           if (!$zone.length) { return; }

           var $image = $zone.find('.banner-upload-image');

           if (input.files && input.files[0]) {
             var reader = new FileReader();
             reader.onload = function(e) {
               $zone.addClass('has-image');
               $image.attr('src', e.target.result);
             };
             reader.readAsDataURL(input.files[0]);
           } else {
             $zone.removeClass('has-image');
             $image.attr('src', '');
           }
         }

         $('.banner-upload-zone').each(function() {
           var $image = $(this).find('.banner-upload-image');
           if ($image.attr('src')) {
             $(this).addClass('has-image');
           }
         });

         $('.custom-file-input').on('change', function() {
           var fileName = $(this).val().split('\\').pop();
           $(this).next('.custom-file-label').html(fileName || 'Dosya seçiniz...');
         });

         $('.banner-upload-input').on('change', function() {
           updateBannerPreview(this);
         });
       });
       </script>

      </div>
    </section>
  </div>

<?php
  }
  else
  {
    ?>
    <meta http-equiv="refresh" content="0;url=<?=SITE?>banner-liste">
    <?php
  }
}
else
{
  ?>
  <meta http-equiv="refresh" content="0;url=<?=SITE?>banner-liste">
  <?php
}
?>
