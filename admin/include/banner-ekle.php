<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row align-items-center mb-3">
          <div class="col-sm-6">
            <h1 class="m-0" style="color: #9f1239; border-left: 4px solid #f43f5e; padding-left: 15px;">Banner Ekle</h1>
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
          if(
            !empty($_POST["sirano"]) &&
            !empty($_FILES["resim"]["name"]) &&
            !empty($_FILES["resim_mobil"]["name"])
          )
          {
                  $baslik=$VT->filter($_POST["baslik"]);
         $aciklama=$VT->filter($_POST["aciklama"]);
         $url=$VT->filter($_POST["url"]);
                          $sirano=$VT->filter($_POST["sirano"]);

                                  $masaustuResim=$VT->upload("resim","../images/banner/");
                                  if($masaustuResim!=false)
                                  {
                                          $mobilResim=$VT->upload("resim_mobil","../images/banner/");
                                          if($mobilResim!=false)
                                          {
                                                  $ekle=$VT->SorguCalistir(
                                                    "INSERT INTO banner",
                                                    "SET baslik=?, aciklama=?, url=?, resim=?, resim_mobil=?, durum=?, sirano=?, tarih=?",
                                                    array($baslik,$aciklama,$url,$masaustuResim,$mobilResim,1,$sirano,date("Y-m-d"))
                                                  );
                                          }
                                          else
                                          {
            $ekle=false;
            if(file_exists("../images/banner/".$masaustuResim))
            {
              unlink("../images/banner/".$masaustuResim);
            }
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
                                  else
                                  {
            $ekle=false;
                                          ?>
                  <div class="alert alert-info alert-dismissible fade show">
                    <strong>Bilgi!</strong> Masaüstü ya da mobil banner yükleme işleminiz başarısız.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Kapat">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <?php
				   }


			   if($ekle!=false)
			   {
				    ?>
                   <div class="alert alert-success alert-dismissible fade show">
                     <strong>Başarılı!</strong> İşleminiz başarıyla kaydedildi.
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
                 <strong>Uyarı!</strong> Boş bıraktığınız alanları doldurunuz.
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
                   <input type="text" class="form-control" id="baslik" placeholder="Banner başlığı giriniz" name="baslik">
                 </div>

                 <div class="form-group">
                   <label for="aciklama">Açıklama</label>
                   <input type="text" class="form-control" id="aciklama" placeholder="Banner açıklaması giriniz" name="aciklama">
                 </div>

                 <div class="form-group">
                   <label for="url">URL Adresi</label>
                   <input type="text" class="form-control" id="url" placeholder="https://ornek.com" name="url">
                 </div>

                 <hr class="my-4">

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="resim">Masaüstü Banner Görseli <span class="text-danger">*</span></label>
                    <div class="banner-upload-card">
                      <div class="banner-preview" id="preview-desktop" data-original="">
                        <span class="banner-preview-text">1920x700 piksel önerilir</span>
                      </div>
                      <div class="custom-file mt-3">
                        <input type="file" class="custom-file-input" id="resim" name="resim" accept="image/*" required>
                        <label class="custom-file-label" for="resim">Dosya seçiniz...</label>
                      </div>
                      <small class="form-text text-muted">Geniş ekranlar için yatay bir görsel yükleyiniz.</small>
                    </div>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="resim_mobil">Mobil Banner Görseli <span class="text-danger">*</span></label>
                    <div class="banner-upload-card">
                      <div class="banner-preview" id="preview-mobile" data-original="">
                        <span class="banner-preview-text">800x1000 piksel önerilir</span>
                      </div>
                      <div class="custom-file mt-3">
                        <input type="file" class="custom-file-input" id="resim_mobil" name="resim_mobil" accept="image/*" required>
                        <label class="custom-file-label" for="resim_mobil">Dosya seçiniz...</label>
                      </div>
                      <small class="form-text text-muted">Mobil cihazlar için dikey bir görsel yükleyiniz.</small>
                    </div>
                  </div>
                </div>

                 <div class="form-group">
                   <label for="sirano">Sıra No</label>
                   <input type="number" class="form-control" id="sirano" name="sirano" value="<?php
                   $sirano=$VT->IDGetir("banner");
                   if($sirano!=false){
                     echo $sirano;
                   }
                   else
                   {
                     echo "1";
                   }
                   ?>" style="width: 150px;">
                 </div>

                 <hr class="my-4">
                 <div class="text-right">
                   <a href="<?=SITE?>banner-liste" class="btn btn-secondary">İptal</a>
                   <button type="submit" class="btn btn-primary">
                     <i class="fas fa-save mr-1"></i> Kaydet
                   </button>
                 </div>
               </form>
             </div>
           </div>
         </div>
       </div>

       <style>
         .banner-upload-card {
           border: 1px dashed #fecdd3;
           border-radius: 0.75rem;
           padding: 1.5rem;
           background: linear-gradient(135deg, rgba(255, 241, 242, 0.6), rgba(255, 228, 230, 0.6));
           transition: border-color 0.3s ease, box-shadow 0.3s ease;
         }

         .banner-upload-card:hover {
           border-color: #fda4af;
           box-shadow: 0 8px 20px rgba(244, 63, 94, 0.12);
         }

         .banner-preview {
           position: relative;
           width: 100%;
           padding-top: 55%;
           border-radius: 0.75rem;
           background-color: rgba(255, 255, 255, 0.65);
           background-size: cover;
           background-position: center;
           display: flex;
           align-items: center;
           justify-content: center;
           color: #9f1239;
           font-weight: 600;
           text-align: center;
           overflow: hidden;
           border: 1px solid rgba(244, 63, 94, 0.25);
         }

         .banner-preview.has-image {
           color: transparent;
           border-color: rgba(244, 63, 94, 0.35);
           background-color: rgba(255, 255, 255, 0.9);
         }

         .banner-preview-text {
           padding: 0 1rem;
         }

         @media (max-width: 767.98px) {
           .banner-upload-card {
             margin-bottom: 1.5rem;
           }
         }
       </style>

       <script>
       function updatePreview(input, previewId) {
         var preview = document.getElementById(previewId);
         if(!preview) { return; }

         if(input.files && input.files[0]) {
           var reader = new FileReader();
           reader.onload = function(e) {
             preview.style.backgroundImage = 'url(' + e.target.result + ')';
             preview.classList.add('has-image');
           };
           reader.readAsDataURL(input.files[0]);
         } else {
           var original = preview.getAttribute('data-original');
           if(original) {
             preview.style.backgroundImage = 'url(' + original + ')';
             preview.classList.add('has-image');
           } else {
             preview.style.backgroundImage = '';
             preview.classList.remove('has-image');
           }
         }
       }

       $(document).ready(function() {
         $('.custom-file-input').on('change', function() {
           var fileName = $(this).val().split('\\').pop();
           $(this).next('.custom-file-label').text(fileName || 'Dosya seçiniz...');
         });

         $('#resim').on('change', function() {
           updatePreview(this, 'preview-desktop');
         });

         $('#resim_mobil').on('change', function() {
           updatePreview(this, 'preview-mobile');
         });
       });
       </script>

      </div>
    </section>
  </div>
