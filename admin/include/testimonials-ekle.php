<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Yeni Müşteri Yorumu Ekle</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=SITE?>">Anasayfa</a></li>
              <li class="breadcrumb-item"><a href="<?=SITE?>testimonials-liste">Müşteri Yorumları</a></li>
              <li class="breadcrumb-item active">Yeni Ekle</li>
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
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Testimonial Bilgileri</h3>
              </div>

              <?php
              if(!empty($_POST["kaydet"])) {
                  $ad_soyad = $VT->filter($_POST["ad_soyad"]);
                  $yorum = $VT->filter($_POST["yorum"]);
                  $puan = intval($_POST["puan"]);
                  $google_link = $VT->filter($_POST["google_link"]);
                  $onay_durumu = $VT->filter($_POST["onay_durumu"]);
                  $durum = intval($_POST["durum"]);
                  $sirano = intval($_POST["sirano"]);

                  // Resim upload
                  $resim = "";
                  if(!empty($_FILES["resim"]["tmp_name"])) {
                      $upload = new Upload($_FILES["resim"]);
                      if($upload->uploaded) {
                          $upload->file_new_name_body = 'testimonial_' . time();
                          $upload->image_resize = true;
                          $upload->image_x = 400;
                          $upload->image_y = 400;
                          $upload->image_ratio_crop = true;
                          $upload->process('../images/testimonials/');

                          if($upload->processed) {
                              $resim = $upload->file_dst_name;

                              // Thumbnail oluştur
                              $upload->file_new_name_body = 'thumb_testimonial_' . time();
                              $upload->image_x = 100;
                              $upload->image_y = 100;
                              $upload->process('../images/testimonials/');
                              $upload->clean();
                          }
                      }
                  }

                  if(!empty($ad_soyad) && !empty($yorum) && $puan >= 1 && $puan <= 5) {
                      $ekle = $VT->SorguCalistir("INSERT INTO testimonials", "SET ad_soyad=?, yorum=?, puan=?, google_link=?, onay_durumu=?, durum=?, sirano=?, resim=?, tarih=NOW()", array($ad_soyad, $yorum, $puan, $google_link, $onay_durumu, $durum, $sirano, $resim));

                      if($ekle) {
                          echo '<div class="alert alert-success">Testimonial başarıyla eklendi!</div>';
                      } else {
                          echo '<div class="alert alert-danger">Bir hata oluştu!</div>';
                      }
                  } else {
                      echo '<div class="alert alert-warning">Lütfen zorunlu alanları doldurun!</div>';
                  }
              }
              ?>

              <form action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="ad_soyad">Ad Soyad *</label>
                        <input type="text" class="form-control" id="ad_soyad" name="ad_soyad" required>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="puan">Puan *</label>
                        <select class="form-control" id="puan" name="puan" required>
                          <option value="">Seçin</option>
                          <option value="5" selected>5 Yıldız</option>
                          <option value="4">4 Yıldız</option>
                          <option value="3">3 Yıldız</option>
                          <option value="2">2 Yıldız</option>
                          <option value="1">1 Yıldız</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="sirano">Sıra No</label>
                        <input type="number" class="form-control" id="sirano" name="sirano" value="1">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="yorum">Yorum *</label>
                    <textarea class="form-control" id="yorum" name="yorum" rows="4" required placeholder="Müşteri yorumu..."></textarea>
                  </div>

                  <div class="form-group">
                    <label for="google_link">Google Review Linki</label>
                    <input type="url" class="form-control" id="google_link" name="google_link" placeholder="https://...">
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="onay_durumu">Onay Durumu</label>
                        <select class="form-control" id="onay_durumu" name="onay_durumu">
                          <option value="beklemede">Beklemede</option>
                          <option value="onaylandi" selected>Onaylandı</option>
                          <option value="reddedildi">Reddedildi</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="durum">Durum</label>
                        <select class="form-control" id="durum" name="durum">
                          <option value="0">Pasif</option>
                          <option value="1" selected>Aktif</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="resim">Müşteri Resmi</label>
                    <input type="file" class="form-control-file" id="resim" name="resim" accept="image/*">
                    <small class="form-text text-muted">400x400 px boyutunda yüklenecektir. Otomatik thumbnail oluşturulacak.</small>
                  </div>
                </div>

                <div class="card-footer">
                  <button type="submit" name="kaydet" class="btn btn-primary">
                    <i class="fas fa-save"></i> Kaydet
                  </button>
                  <a href="<?=SITE?>testimonials-liste" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Geri Dön
                  </a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>