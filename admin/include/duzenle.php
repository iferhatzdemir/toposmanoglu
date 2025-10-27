<?php
if(!empty($_GET["tablo"]) && !empty($_GET["ID"]))
{
	$tablo=$VT->filter($_GET["tablo"]);
	$ID=$VT->filter($_GET["ID"]);
	$kontrol=$VT->VeriGetir("moduller","WHERE tablo=? AND durum=?",array($tablo,1),"ORDER BY ID ASC",1);
	if($kontrol!=false)
	{
		$veri=$VT->VeriGetir($kontrol[0]["tablo"],"WHERE ID=?",array($ID),"ORDER BY ID ASC",1);
		if($veri!=false)
		{
?>
<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row align-items-center mb-3">
          <div class="col-sm-6">
            <h1 class="m-0" style="color: #9f1239; border-left: 4px solid #f43f5e; padding-left: 15px;"><?=$kontrol[0]["baslik"]?> Düzenle</h1>
          </div>
          <div class="col-sm-6 text-right">
            <a href="<?=SITE?>liste/<?=$kontrol[0]["tablo"]?>" class="btn btn-outline-secondary btn-sm">
              <i class="fas fa-list mr-1"></i> Liste
            </a>
            <a href="<?=SITE?>ekle/<?=$kontrol[0]["tablo"]?>" class="btn btn-primary btn-sm">
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
		   if(!empty($_POST["kategori"]) && !empty($_POST["baslik"]) && !empty($_POST["anahtar"]) && !empty($_POST["description"]) && !empty($_POST["sirano"]))
		   {
			   $kategori=$VT->filter($_POST["kategori"]);
			   $baslik=$VT->filter($_POST["baslik"]);
			   $anahtar=$VT->filter($_POST["anahtar"]);
			   $seflink=$VT->seflink($baslik);
			   $description=$VT->filter($_POST["description"]);
			   $sirano=$VT->filter($_POST["sirano"]);
			   $metin=$VT->filter($_POST["metin"],true);
			   if(!empty($_FILES["resim"]["name"]))
			   {
				   $yukle=$VT->upload("resim","../images/".$kontrol[0]["tablo"]."/");
				   if($yukle!=false)
				   {
					   $ekle=$VT->SorguCalistir("UPDATE ".$kontrol[0]["tablo"],"SET baslik=?, seflink=?, kategori=?, metin=?, resim=?, anahtar=?, description=?, durum=?, sirano=?, tarih=? WHERE ID=?",array($baslik,$seflink,$kategori,$metin,$yukle,$anahtar,$description,1,$sirano,date("Y-m-d"),$veri[0]["ID"]));
				   }
				   else
				   {
					    ?>
                   <div class="alert alert-info alert-dismissible fade show">
                     <strong>Bilgi!</strong> Resim yükleme işleminiz başarısız.
                     <button type="button" class="close" data-dismiss="alert" aria-label="Kapat">
                       <span aria-hidden="true">&times;</span>
                     </button>
                   </div>
                   <?php
				   }
			   }
			   else
			   {
				   $ekle=$VT->SorguCalistir("UPDATE ".$kontrol[0]["tablo"],"SET baslik=?, seflink=?, kategori=?, metin=?, anahtar=?, description=?, durum=?, sirano=?, tarih=? WHERE ID=?",array($baslik,$seflink,$kategori,$metin,$anahtar,$description,1,$sirano,date("Y-m-d"),$veri[0]["ID"]));
			   }

			   if($ekle!=false)
			   {
				   $veri=$VT->VeriGetir($kontrol[0]["tablo"],"WHERE ID=?",array($veri[0]["ID"]),"ORDER BY ID ASC",1);
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
               <h3 class="card-title">İçerik Bilgileri</h3>
             </div>
             <div class="card-body">
               <form action="#" method="post" enctype="multipart/form-data">
                 <div class="form-group">
                   <label for="kategori">Kategori Seç</label>
                   <select class="form-control select2" name="kategori" id="kategori">
                     <?php
                     $sonuc=$VT->kategoriGetir($kontrol[0]["tablo"],$veri[0]["kategori"],-1);
                     if($sonuc!=false)
                     {
                       echo $sonuc;
                     }
                     else
                     {
                       $VT->tekKategori($kontrol[0]["tablo"]);
                     }
                     ?>
                   </select>
                 </div>

                 <div class="form-group">
                   <label for="baslik">Başlık</label>
                   <input type="text" class="form-control" id="baslik" placeholder="Başlık giriniz" name="baslik" value="<?=stripslashes($veri[0]["baslik"])?>">
                 </div>

                 <div class="form-group">
                   <label for="metin">Açıklama</label>
                   <textarea class="textarea form-control" id="metin" name="metin" rows="10"><?=stripslashes($veri[0]["metin"])?></textarea>
                 </div>

                 <hr class="my-4">
                 <h5 class="mb-3">SEO Ayarları</h5>

                 <div class="form-group">
                   <label for="anahtar">Anahtar Kelimeler</label>
                   <input type="text" class="form-control" id="anahtar" placeholder="anahtar, kelimeler, virgülle, ayrılmış" name="anahtar" value="<?=stripslashes($veri[0]["anahtar"])?>">
                 </div>

                 <div class="form-group">
                   <label for="description">Meta Description</label>
                   <textarea class="form-control" id="description" name="description" rows="3"><?=stripslashes($veri[0]["description"])?></textarea>
                 </div>

                 <hr class="my-4">

                 <div class="form-group">
                   <label for="resim">Resim</label>
                   <?php if(!empty($veri[0]["resim"])): ?>
                   <div class="mb-3">
                     <img src="<?=SITE?>../images/<?=$kontrol[0]["tablo"]?>/<?=$veri[0]["resim"]?>" alt="Mevcut resim" style="max-width: 200px; border: 1px solid #fecdd3; border-radius: 0.25rem;">
                     <p class="text-sm text-muted mt-2">Mevcut resim</p>
                   </div>
                   <?php endif; ?>
                   <div class="custom-file">
                     <input type="file" class="custom-file-input" id="resim" name="resim" accept="image/*">
                     <label class="custom-file-label" for="resim">Dosya seçiniz...</label>
                   </div>
                   <small class="form-text text-muted">Yeni resim seçmezseniz mevcut resim korunur</small>
                 </div>

                 <div class="form-group">
                   <label for="sirano">Sıra No</label>
                   <input type="number" class="form-control" id="sirano" name="sirano" value="<?=stripslashes($veri[0]["sirano"])?>" style="width: 150px;">
                 </div>

                 <hr class="my-4">
                 <div class="text-right">
                   <a href="<?=SITE?>liste/<?=$kontrol[0]["tablo"]?>" class="btn btn-secondary">İptal</a>
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

         label {
           color: #9f1239;
           font-weight: 500;
         }
       </style>

       <script>
       $(document).ready(function() {
         // Custom file input
         $('.custom-file-input').on('change', function() {
           var fileName = $(this).val().split('\\').pop();
           $(this).next('.custom-file-label').html(fileName);
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
        <meta http-equiv="refresh" content="0;url=<?=SITE?>liste/<?=$kontrol[0]["tablo"]?>">
        <?php
		}
	}
	else
	{
		?>
        <meta http-equiv="refresh" content="0;url=<?=SITE?>">
        <?php
	}
}
else
{
	?>
        <meta http-equiv="refresh" content="0;url=<?=SITE?>">
        <?php
}
 ?>
