<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row align-items-center mb-3">
          <div class="col-sm-6">
            <h1 class="m-0" style="color: #9f1239; border-left: 4px solid #f43f5e; padding-left: 15px;">
              <i class="fas fa-image mr-2"></i>Banner Ekle
            </h1>
          </div>
          <div class="col-sm-6 text-right">
            <a href="<?=SITE?>banner-liste" class="btn btn-outline-secondary btn-sm">
              <i class="fas fa-list mr-1"></i> Banner Listesi
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
		   $media_type = !empty($_POST["media_type"]) ? $VT->filter($_POST["media_type"]) : "image";
		   $baslik = !empty($_POST["baslik"]) ? $VT->filter($_POST["baslik"]) : "";
           $aciklama = !empty($_POST["aciklama"]) ? $VT->filter($_POST["aciklama"]) : "";
           $butontext = !empty($_POST["butontext"]) ? $VT->filter($_POST["butontext"]) : "";
           $url = !empty($_POST["url"]) ? $VT->filter($_POST["url"]) : "";
		   $sirano = !empty($_POST["sirano"]) ? $VT->filter($_POST["sirano"]) : 1;

		   if($media_type == "video") {
			   // Video banner
			   $video_url = !empty($_POST["video_url"]) ? $VT->filter($_POST["video_url"]) : "";

			   // Video poster (önizleme resmi)
			   $video_poster = "";
			   if(!empty($_FILES["video_poster"]["name"])) {
				   $video_poster = $VT->upload("video_poster","../images/banner/");
			   }

			   if(!empty($video_url)) {
				   $ekle = $VT->SorguCalistir("INSERT INTO banner",
					   "SET baslik=?, aciklama=?, butontext=?, url=?, media_type=?, video_url=?, video_poster=?, durum=?, sirano=?, tarih=?",
					   array($baslik, $aciklama, $butontext, $url, "video", $video_url, $video_poster, 1, $sirano, date("Y-m-d")));

				   if($ekle != false) {
					   ?>
					   <div class="alert alert-success alert-dismissible fade show">
						 <i class="fas fa-check-circle mr-2"></i>
						 <strong>Başarılı!</strong> Video banner başarıyla eklendi.
						 <button type="button" class="close" data-dismiss="alert">
						   <span>&times;</span>
						 </button>
					   </div>
					   <?php
				   } else {
					   ?>
					   <div class="alert alert-danger alert-dismissible fade show">
						 <i class="fas fa-times-circle mr-2"></i>
						 <strong>Hata!</strong> Banner eklenirken bir sorun oluştu.
						 <button type="button" class="close" data-dismiss="alert">
						   <span>&times;</span>
						 </button>
					   </div>
					   <?php
				   }
			   } else {
				   ?>
				   <div class="alert alert-warning alert-dismissible fade show">
					 <i class="fas fa-exclamation-circle mr-2"></i>
					 <strong>Uyarı!</strong> Lütfen video URL'si giriniz.
					 <button type="button" class="close" data-dismiss="alert">
					   <span>&times;</span>
					 </button>
				   </div>
				   <?php
			   }
		   } else {
			   // Resim banner
			   if(!empty($_FILES["resim"]["name"])) {
				   // Desktop resim yükleme
				   $yukle = $VT->upload("resim","../images/banner/");

				   // Mobil resim yükleme (opsiyonel)
				   $mobilYukle = "";
				   if(!empty($_FILES["resim_mobil"]["name"])) {
					   $mobilYukle = $VT->upload("resim_mobil","../images/banner/");
				   }

				   if($yukle != false) {
					   $ekle = $VT->SorguCalistir("INSERT INTO banner",
						   "SET baslik=?, aciklama=?, butontext=?, url=?, resim=?, resim_mobil=?, media_type=?, durum=?, sirano=?, tarih=?",
						   array($baslik, $aciklama, $butontext, $url, $yukle, $mobilYukle, "image", 1, $sirano, date("Y-m-d")));

					   if($ekle != false) {
						   ?>
						   <div class="alert alert-success alert-dismissible fade show">
							 <i class="fas fa-check-circle mr-2"></i>
							 <strong>Başarılı!</strong> Banner başarıyla eklendi.
							 <button type="button" class="close" data-dismiss="alert">
							   <span>&times;</span>
							 </button>
						   </div>
						   <?php
					   } else {
						   ?>
						   <div class="alert alert-danger alert-dismissible fade show">
							 <i class="fas fa-times-circle mr-2"></i>
							 <strong>Hata!</strong> Banner eklenirken bir sorun oluştu.
							 <button type="button" class="close" data-dismiss="alert">
							   <span>&times;</span>
							 </button>
						   </div>
						   <?php
					   }
				   } else {
					   ?>
					   <div class="alert alert-danger alert-dismissible fade show">
						 <i class="fas fa-exclamation-triangle mr-2"></i>
						 <strong>Hata!</strong> Resim yükleme başarısız.
						 <button type="button" class="close" data-dismiss="alert">
						   <span>&times;</span>
						 </button>
					   </div>
					   <?php
				   }
			   } else {
				   ?>
				   <div class="alert alert-warning alert-dismissible fade show">
					 <i class="fas fa-exclamation-circle mr-2"></i>
					 <strong>Uyarı!</strong> Lütfen en az desktop resmi yükleyiniz.
					 <button type="button" class="close" data-dismiss="alert">
					   <span>&times;</span>
					 </button>
				   </div>
				   <?php
			   }
		   }
	   }
	   ?>
       <div class="row">
         <div class="col-lg-10 offset-lg-1">
           <div class="card shadow-lg">
             <div class="card-header bg-gradient">
               <h3 class="card-title mb-0">
                 <i class="fas fa-info-circle mr-2"></i>Banner Bilgileri
               </h3>
             </div>
             <div class="card-body p-4">
               <form action="#" method="post" enctype="multipart/form-data" id="bannerForm">

                 <!-- Media Type Selector -->
                 <div class="section-divider">
                   <h5><i class="fas fa-layer-group mr-2 text-rose"></i>Banner Tipi Seçin</h5>
                 </div>

                 <div class="row mb-4">
                   <div class="col-md-6">
                     <div class="media-type-card" data-type="image">
                       <input type="radio" name="media_type" value="image" id="type_image" checked>
                       <label for="type_image" class="media-type-label">
                         <i class="fas fa-image fa-3x mb-3"></i>
                         <h5>Resim Banner</h5>
                         <p class="text-muted">Desktop ve mobil için resim yükleyin</p>
                       </label>
                     </div>
                   </div>
                   <div class="col-md-6">
                     <div class="media-type-card" data-type="video">
                       <input type="radio" name="media_type" value="video" id="type_video">
                       <label for="type_video" class="media-type-label">
                         <i class="fas fa-video fa-3x mb-3"></i>
                         <h5>Video Banner</h5>
                         <p class="text-muted">Arka plan videosu için URL girin</p>
                       </label>
                     </div>
                   </div>
                 </div>

                 <hr class="my-4">

                 <!-- Image Upload Section -->
                 <div id="imageUploadSection">
                   <div class="section-divider">
                     <h5><i class="fas fa-images mr-2 text-rose"></i>Banner Görselleri</h5>
                     <p class="text-muted small mb-3">
                       <i class="fas fa-info-circle mr-1"></i>
                       Farklı cihazlar için optimize edilmiş görseller yükleyin
                     </p>
                   </div>

                   <div class="row">
                     <!-- Desktop Görsel (Zorunlu) -->
                     <div class="col-md-6">
                       <div class="image-upload-container">
                         <label class="image-upload-label">
                           <i class="fas fa-desktop mr-2"></i>Desktop Görseli
                           <span class="text-danger">*</span>
                           <span class="badge badge-info ml-2">1920x800px</span>
                         </label>

                         <div class="custom-file-upload" id="desktopUploadArea">
                           <input type="file" class="file-input" id="resim" name="resim" accept="image/*">
                           <div class="upload-area">
                             <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                             <p class="mb-2"><strong>Desktop için resim seçin</strong></p>
                             <p class="text-muted small">veya sürükleyip bırakın</p>
                             <button type="button" class="btn btn-sm btn-outline-primary mt-2">
                               <i class="fas fa-folder-open mr-1"></i>Dosya Seç
                             </button>
                           </div>
                           <div class="preview-area" id="desktopPreview" style="display: none;">
                             <img src="" alt="Preview" class="preview-image">
                             <div class="preview-overlay">
                               <button type="button" class="btn btn-sm btn-danger remove-image" data-target="resim">
                                 <i class="fas fa-trash mr-1"></i>Kaldır
                               </button>
                             </div>
                           </div>
                         </div>
                         <small class="form-text text-muted">
                           <i class="fas fa-check-circle text-success mr-1"></i>Önerilen: 1920x800px, Max: 5MB
                         </small>
                       </div>
                     </div>

                     <!-- Mobil Görsel (Opsiyonel) -->
                     <div class="col-md-6">
                       <div class="image-upload-container">
                         <label class="image-upload-label">
                           <i class="fas fa-mobile-alt mr-2"></i>Mobil Görseli
                           <span class="badge badge-secondary ml-2">Opsiyonel</span>
                           <span class="badge badge-info ml-2">768x600px</span>
                         </label>

                         <div class="custom-file-upload" id="mobileUploadArea">
                           <input type="file" class="file-input" id="resim_mobil" name="resim_mobil" accept="image/*">
                           <div class="upload-area">
                             <i class="fas fa-mobile-alt fa-3x text-muted mb-3"></i>
                             <p class="mb-2"><strong>Mobil için resim seçin</strong></p>
                             <p class="text-muted small">Opsiyonel - Mobil cihazlar için</p>
                             <button type="button" class="btn btn-sm btn-outline-secondary mt-2">
                               <i class="fas fa-folder-open mr-1"></i>Dosya Seç
                             </button>
                           </div>
                           <div class="preview-area" id="mobilePreview" style="display: none;">
                             <img src="" alt="Preview" class="preview-image">
                             <div class="preview-overlay">
                               <button type="button" class="btn btn-sm btn-danger remove-image" data-target="resim_mobil">
                                 <i class="fas fa-trash mr-1"></i>Kaldır
                               </button>
                             </div>
                           </div>
                         </div>
                         <small class="form-text text-muted">
                           <i class="fas fa-info-circle text-info mr-1"></i>Boş bırakılırsa desktop görseli kullanılır
                         </small>
                       </div>
                     </div>
                   </div>
                 </div>

                 <!-- Video Upload Section -->
                 <div id="videoUploadSection" style="display: none;">
                   <div class="section-divider">
                     <h5><i class="fas fa-video mr-2 text-rose"></i>Video Banner Ayarları</h5>
                     <p class="text-muted small mb-3">
                       <i class="fas fa-info-circle mr-1"></i>
                       Arka plan videosu için bilgileri girin
                     </p>
                   </div>

                   <div class="row">
                     <div class="col-md-12">
                       <div class="form-group">
                         <label for="video_url">
                           <i class="fas fa-link text-rose mr-1"></i>Video URL
                           <span class="text-danger">*</span>
                         </label>
                         <input type="text" class="form-control" id="video_url" name="video_url"
                                placeholder="assets/video/banner-video.mp4 veya https://example.com/video.mp4">
                         <small class="form-text text-muted">
                           Video dosyasının yolu veya URL'si (MP4 formatı önerilir)
                         </small>
                       </div>
                     </div>
                   </div>

                   <div class="row">
                     <div class="col-md-12">
                       <div class="image-upload-container">
                         <label class="image-upload-label">
                           <i class="fas fa-image mr-2"></i>Video Önizleme Resmi (Poster)
                           <span class="badge badge-secondary ml-2">Opsiyonel</span>
                         </label>

                         <div class="custom-file-upload" id="posterUploadArea">
                           <input type="file" class="file-input" id="video_poster" name="video_poster" accept="image/*">
                           <div class="upload-area">
                             <i class="fas fa-image fa-3x text-muted mb-3"></i>
                             <p class="mb-2"><strong>Video yüklenmeden önce gösterilecek resim</strong></p>
                             <p class="text-muted small">Poster resmi seçin</p>
                             <button type="button" class="btn btn-sm btn-outline-primary mt-2">
                               <i class="fas fa-folder-open mr-1"></i>Dosya Seç
                             </button>
                           </div>
                           <div class="preview-area" id="posterPreview" style="display: none;">
                             <img src="" alt="Preview" class="preview-image">
                             <div class="preview-overlay">
                               <button type="button" class="btn btn-sm btn-danger remove-image" data-target="video_poster">
                                 <i class="fas fa-trash mr-1"></i>Kaldır
                               </button>
                             </div>
                           </div>
                         </div>
                         <small class="form-text text-muted">
                           <i class="fas fa-info-circle text-info mr-1"></i>Video yüklenene kadar gösterilir
                         </small>
                       </div>
                     </div>
                   </div>
                 </div>

                 <hr class="my-4">

                 <!-- Opsiyonel Bilgiler -->
                 <div class="section-divider">
                   <h5><i class="fas fa-edit mr-2 text-rose"></i>Banner İçeriği (Opsiyonel)</h5>
                   <p class="text-muted small mb-3">Bu alanlar boş bırakılabilir</p>
                 </div>

                 <div class="row">
                   <div class="col-md-8">
                     <div class="form-group">
                       <label for="baslik">
                         <i class="fas fa-heading text-rose mr-1"></i>Banner Başlığı
                       </label>
                       <input type="text" class="form-control" id="baslik"
                              placeholder="Örn: Yaz İndirimleri Başladı" name="baslik">
                       <small class="form-text text-muted">Banner üzerinde gösterilecek başlık</small>
                     </div>
                   </div>

                   <div class="col-md-4">
                     <div class="form-group">
                       <label for="sirano">
                         <i class="fas fa-sort-numeric-down text-rose mr-1"></i>Sıra No
                       </label>
                       <input type="number" class="form-control" id="sirano" name="sirano"
                              value="<?php
                              $sirano = $VT->IDGetir("banner");
                              echo $sirano ? $sirano : "1";
                              ?>" min="1">
                     </div>
                   </div>
                 </div>

                 <div class="form-group">
                   <label for="aciklama">
                     <i class="fas fa-align-left text-rose mr-1"></i>Açıklama
                   </label>
                   <textarea class="form-control" id="aciklama" rows="2" name="aciklama"
                             placeholder="Banner açıklaması (opsiyonel)"></textarea>
                 </div>

                 <div class="row">
                   <div class="col-md-6">
                     <div class="form-group">
                       <label for="butontext">
                         <i class="fas fa-mouse-pointer text-rose mr-1"></i>Buton Metni
                       </label>
                       <input type="text" class="form-control" id="butontext"
                              placeholder="Örn: Alışverişe Başla" name="butontext">
                     </div>
                   </div>

                   <div class="col-md-6">
                     <div class="form-group">
                       <label for="url">
                         <i class="fas fa-link text-rose mr-1"></i>Link URL
                       </label>
                       <input type="url" class="form-control" id="url"
                              placeholder="https://ornek.com/sayfa" name="url">
                     </div>
                   </div>
                 </div>

                 <hr class="my-4">

                 <!-- Form Actions -->
                 <div class="form-actions">
                   <a href="<?=SITE?>banner-liste" class="btn btn-lg btn-secondary">
                     <i class="fas fa-times mr-2"></i>İptal
                   </a>
                   <button type="submit" class="btn btn-lg btn-primary">
                     <i class="fas fa-save mr-2"></i>Banner Kaydet
                   </button>
                 </div>
               </form>
             </div>
           </div>
         </div>
       </div>

      </div>
    </section>
  </div>

  <style>
    :root {
      --rose-500: #f43f5e;
      --rose-600: #e11d48;
      --rose-700: #be123c;
      --rose-800: #9f1239;
    }

    .text-rose { color: var(--rose-600) !important; }

    .card {
      border: none;
      border-radius: 12px;
      transition: all 0.3s ease;
    }

    .card.shadow-lg {
      box-shadow: 0 10px 40px rgba(244, 63, 94, 0.12) !important;
    }

    .card:hover {
      transform: translateY(-2px);
      box-shadow: 0 20px 60px rgba(244, 63, 94, 0.18) !important;
    }

    .card-header.bg-gradient {
      background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%);
      border-bottom: 3px solid #fecdd3;
      color: var(--rose-800);
      padding: 1.25rem 1.5rem;
    }

    .section-divider {
      margin-bottom: 1.5rem;
      padding-bottom: 0.75rem;
      border-bottom: 2px solid #ffe4e6;
    }

    .section-divider h5 {
      color: var(--rose-800);
      font-weight: 600;
      margin-bottom: 0.25rem;
    }

    /* Media Type Selector */
    .media-type-card {
      position: relative;
      border: 3px solid #e5e7eb;
      border-radius: 12px;
      padding: 2rem;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s ease;
      background: #f9fafb;
    }

    .media-type-card input[type="radio"] {
      position: absolute;
      opacity: 0;
    }

    .media-type-card:hover {
      border-color: var(--rose-500);
      background: #fff1f2;
      transform: translateY(-2px);
    }

    .media-type-card input[type="radio"]:checked + .media-type-label {
      color: var(--rose-600);
    }

    .media-type-card input[type="radio"]:checked ~ * {
      border-color: var(--rose-500);
    }

    .media-type-card:has(input[type="radio"]:checked) {
      border-color: var(--rose-500);
      background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%);
      box-shadow: 0 4px 12px rgba(244, 63, 94, 0.2);
    }

    .media-type-label {
      cursor: pointer;
      margin: 0;
    }

    .media-type-card i {
      color: #9ca3af;
      transition: color 0.3s ease;
    }

    .media-type-card:has(input[type="radio"]:checked) i {
      color: var(--rose-500);
    }

    .form-control {
      border: 2px solid #e5e7eb;
      border-radius: 8px;
      padding: 0.75rem 1rem;
      transition: all 0.3s ease;
    }

    .form-control:focus {
      border-color: var(--rose-500);
      box-shadow: 0 0 0 3px rgba(244, 63, 94, 0.1);
    }

    label {
      color: var(--rose-800);
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    /* Image Upload */
    .custom-file-upload {
      position: relative;
      border: 3px dashed #d1d5db;
      border-radius: 12px;
      background: #f9fafb;
      transition: all 0.3s ease;
      min-height: 250px;
    }

    .custom-file-upload:hover {
      border-color: var(--rose-500);
      background: #fff1f2;
    }

    .file-input {
      position: absolute;
      opacity: 0;
      width: 100%;
      height: 100%;
      cursor: pointer;
      z-index: 10;
    }

    .upload-area {
      padding: 3rem 2rem;
      text-align: center;
    }

    .custom-file-upload:hover .upload-area .fa-cloud-upload-alt,
    .custom-file-upload:hover .upload-area .fa-image,
    .custom-file-upload:hover .upload-area .fa-mobile-alt {
      color: var(--rose-500);
      transform: translateY(-5px);
    }

    .preview-area {
      position: relative;
      padding: 1rem;
    }

    .preview-image {
      width: 100%;
      height: 220px;
      object-fit: cover;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .preview-overlay {
      position: absolute;
      top: 1rem;
      right: 1rem;
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .preview-area:hover .preview-overlay {
      opacity: 1;
    }

    /* Buttons */
    .btn-primary {
      background: linear-gradient(135deg, var(--rose-500) 0%, var(--rose-600) 100%);
      border: none;
      color: white;
      font-weight: 600;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(244, 63, 94, 0.2);
    }

    .btn-primary:hover {
      background: linear-gradient(135deg, var(--rose-600) 0%, var(--rose-700) 100%);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(244, 63, 94, 0.3);
    }

    .btn-lg {
      padding: 1rem 2.5rem;
      font-size: 1.125rem;
    }

    .form-actions {
      display: flex;
      justify-content: flex-end;
      gap: 1rem;
    }

    .alert {
      border-radius: 8px;
      border: none;
      padding: 1rem 1.5rem;
    }

    .alert-success {
      background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
      color: #065f46;
      border-left: 4px solid #10b981;
    }

    .alert-danger {
      background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
      color: #991b1b;
      border-left: 4px solid #ef4444;
    }

    .alert-warning {
      background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
      color: #92400e;
      border-left: 4px solid #f59e0b;
    }

    @media (max-width: 768px) {
      .form-actions {
        flex-direction: column;
      }
      .form-actions .btn {
        width: 100%;
      }
    }
  </style>

  <script>
  $(document).ready(function() {
    // Media Type Toggle
    $('input[name="media_type"]').on('change', function() {
      const type = $(this).val();
      if(type === 'video') {
        $('#imageUploadSection').slideUp();
        $('#videoUploadSection').slideDown();
        $('#resim').prop('required', false);
      } else {
        $('#videoUploadSection').slideUp();
        $('#imageUploadSection').slideDown();
        $('#resim').prop('required', true);
      }
    });

    // Image Preview
    function setupImagePreview(inputId, previewId) {
      const input = document.getElementById(inputId);
      const previewArea = document.getElementById(previewId);
      if (!input || !previewArea) return;

      input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
          if (!file.type.match('image.*')) {
            alert('Lütfen sadece resim dosyası seçiniz!');
            return;
          }
          if (file.size > 5 * 1024 * 1024) {
            alert('Dosya boyutu 5MB\'dan küçük olmalıdır!');
            return;
          }

          const reader = new FileReader();
          reader.onload = function(e) {
            previewArea.querySelector('.preview-image').src = e.target.result;
            previewArea.style.display = 'block';
            previewArea.previousElementSibling.style.display = 'none';
          };
          reader.readAsDataURL(file);
        }
      });
    }

    setupImagePreview('resim', 'desktopPreview');
    setupImagePreview('resim_mobil', 'mobilePreview');
    setupImagePreview('video_poster', 'posterPreview');

    // Remove image
    $('.remove-image').on('click', function() {
      const target = $(this).data('target');
      $('#' + target).val('');
      $(this).closest('.preview-area').hide().siblings('.upload-area').show();
    });

    // Drag and drop
    $('.custom-file-upload').on('dragover', function(e) {
      e.preventDefault();
      $(this).css('border-color', '#f43f5e');
    }).on('dragleave drop', function(e) {
      e.preventDefault();
      $(this).css('border-color', '#d1d5db');
      if (e.type === 'drop') {
        const files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
          $(this).find('.file-input')[0].files = files;
          $(this).find('.file-input').trigger('change');
        }
      }
    });

    // Auto-dismiss alerts
    setTimeout(() => $('.alert').fadeOut('slow'), 5000);
  });
  </script>
