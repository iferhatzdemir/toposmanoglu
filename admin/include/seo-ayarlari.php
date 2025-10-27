
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row align-items-center mb-3">
          <div class="col-sm-6">
            <h1 class="m-0" style="color: #9f1239; border-left: 4px solid #f43f5e; padding-left: 15px;">SEO Ayarları</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=SITE?>" style="color: #f43f5e;">Anasayfa</a></li>
              <li class="breadcrumb-item active">SEO Ayarları</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
       <?php
	   if($_POST)
	   {
		   if(!empty($_POST["baslik"]) && !empty($_POST["anahtar"]) && !empty($_POST["description"]))
		   {
			   $baslik=$VT->filter($_POST["baslik"]);
			   $anahtar=$VT->filter($_POST["anahtar"]);
			   $description=$VT->filter($_POST["description"]);

				   $guncelle=$VT->SorguCalistir("UPDATE ayarlar","SET baslik=?, anahtar=?, aciklama=? WHERE ID=?",array($baslik,$anahtar,$description,1),1);

			   if($guncelle!=false)
			   {
				    ?>
                   <div class="alert alert-success alert-dismissible fade show">
                     <strong>Başarılı!</strong> İşleminiz başarıyla kaydedildi.
                     <button type="button" class="close" data-dismiss="alert" aria-label="Kapat">
                       <span aria-hidden="true">&times;</span>
                     </button>
                   </div>
                   <meta http-equiv="refresh" content="2;url=<?=SITE?>seo-ayarlari" />
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
               <h3 class="card-title">Site SEO Bilgileri</h3>
             </div>
             <div class="card-body">
               <form action="#" method="post" enctype="multipart/form-data">
                 <div class="form-group">
                   <label for="baslik">Site Başlığı</label>
                   <input type="text" class="form-control" id="baslik" placeholder="Site başlığı giriniz" name="baslik" value="<?=$sitebaslik?>">
                 </div>

                 <div class="form-group">
                   <label for="anahtar">Anahtar Kelimeler</label>
                   <input type="text" class="form-control" id="anahtar" placeholder="anahtar, kelimeler, virgülle, ayrılmış" name="anahtar" value="<?=$siteanahtar?>">
                 </div>

                 <div class="form-group">
                   <label for="description">Meta Description</label>
                   <textarea class="form-control" id="description" placeholder="Arama motorları için kısa açıklama" name="description" rows="4"><?=$siteaciklama?></textarea>
                 </div>

                 <hr class="my-4">
                 <div class="text-right">
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

         .alert-success {
           background: #ffe4e6;
           border-color: #fda4af;
           color: #be123c;
         }

         label {
           color: #9f1239;
           font-weight: 500;
         }

         .breadcrumb-item.active {
           color: #9f1239;
         }
       </style>

      </div>
    </section>
  </div>
