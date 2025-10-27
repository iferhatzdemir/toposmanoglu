<?php
if(!empty($_GET["ID"])) {
    $ID = $VT->filter($_GET["ID"]);
    $kayit = $VT->VeriGetir("testimonials", "WHERE ID=?", array($ID), "", 1);

    if($kayit == false) {
        ?>
        <meta http-equiv="refresh" content="0;url=<?=SITE?>testimonials-liste">
        <?php
        exit();
    }
} else {
    ?>
    <meta http-equiv="refresh" content="0;url=<?=SITE?>testimonials-liste">
    <?php
    exit();
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Müşteri Yorumu Düzenle</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=SITE?>">Anasayfa</a></li>
              <li class="breadcrumb-item"><a href="<?=SITE?>testimonials-liste">Müşteri Yorumları</a></li>
              <li class="breadcrumb-item active">Düzenle</li>
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
                  $admin_notu = $VT->filter($_POST["admin_notu"]);

                  // Resim upload
                  $resim = $kayit[0]["resim"];
                  if(!empty($_FILES["resim"]["tmp_name"])) {
                      // Eski resmi sil
                      if(!empty($resim) && file_exists("../images/testimonials/".$resim)) {
                          unlink("../images/testimonials/".$resim);
                      }
                      if(!empty($resim) && file_exists("../images/testimonials/thumb_".$resim)) {
                          unlink("../images/testimonials/thumb_".$resim);
                      }

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
                      $guncelle = $VT->SorguCalistir("UPDATE testimonials", "SET ad_soyad=?, yorum=?, puan=?, google_link=?, onay_durumu=?, durum=?, sirano=?, resim=?, admin_notu=? WHERE ID=?", array($ad_soyad, $yorum, $puan, $google_link, $onay_durumu, $durum, $sirano, $resim, $admin_notu, $ID));

                      if($guncelle) {
                          echo '<div class="alert alert-success">Testimonial başarıyla güncellendi!</div>';
                          // Güncel verileri çek
                          $kayit = $VT->VeriGetir("testimonials", "WHERE ID=?", array($ID), "", 1);
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
                        <input type="text" class="form-control" id="ad_soyad" name="ad_soyad" value="<?=stripslashes($kayit[0]["ad_soyad"])?>" required>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="puan">Puan *</label>
                        <select class="form-control" id="puan" name="puan" required>
                          <option value="">Seçin</option>
                          <option value="5" <?=($kayit[0]["puan"] == 5) ? "selected" : ""?>>5 Yıldız</option>
                          <option value="4" <?=($kayit[0]["puan"] == 4) ? "selected" : ""?>>4 Yıldız</option>
                          <option value="3" <?=($kayit[0]["puan"] == 3) ? "selected" : ""?>>3 Yıldız</option>
                          <option value="2" <?=($kayit[0]["puan"] == 2) ? "selected" : ""?>>2 Yıldız</option>
                          <option value="1" <?=($kayit[0]["puan"] == 1) ? "selected" : ""?>>1 Yıldız</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="sirano">Sıra No</label>
                        <input type="number" class="form-control" id="sirano" name="sirano" value="<?=$kayit[0]["sirano"]?>">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="yorum">Yorum *</label>
                    <textarea class="form-control" id="yorum" name="yorum" rows="4" required><?=stripslashes($kayit[0]["yorum"])?></textarea>
                  </div>

                  <div class="form-group">
                    <label for="google_link">Google Review Linki</label>
                    <input type="url" class="form-control" id="google_link" name="google_link" value="<?=stripslashes($kayit[0]["google_link"])?>" placeholder="https://...">
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="onay_durumu">Onay Durumu</label>
                        <select class="form-control" id="onay_durumu" name="onay_durumu">
                          <option value="beklemede" <?=($kayit[0]["onay_durumu"] == "beklemede") ? "selected" : ""?>>Beklemede</option>
                          <option value="onaylandi" <?=($kayit[0]["onay_durumu"] == "onaylandi") ? "selected" : ""?>>Onaylandı</option>
                          <option value="reddedildi" <?=($kayit[0]["onay_durumu"] == "reddedildi") ? "selected" : ""?>>Reddedildi</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="durum">Durum</label>
                        <select class="form-control" id="durum" name="durum">
                          <option value="0" <?=($kayit[0]["durum"] == 0) ? "selected" : ""?>>Pasif</option>
                          <option value="1" <?=($kayit[0]["durum"] == 1) ? "selected" : ""?>>Aktif</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Üye Bilgisi</label>
                        <?php if(!empty($kayit[0]["uyeID"])) {
                            $uye = $VT->VeriGetir("uyeler", "WHERE ID=?", array($kayit[0]["uyeID"]), "", 1);
                            if($uye) {
                                echo '<p class="form-control-static text-info"><i class="fas fa-user"></i> '.$uye[0]["adsoyad"].' ('.$uye[0]["mail"].')</p>';
                            }
                        } else {
                            echo '<p class="form-control-static text-muted">Manuel eklendi</p>';
                        } ?>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="admin_notu">Admin Notu</label>
                    <textarea class="form-control" id="admin_notu" name="admin_notu" rows="2" placeholder="Admin notu..."><?=stripslashes($kayit[0]["admin_notu"])?></textarea>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="resim">Müşteri Resmi</label>
                        <input type="file" class="form-control-file" id="resim" name="resim" accept="image/*">
                        <small class="form-text text-muted">400x400 px boyutunda yüklenecektir.</small>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <?php if(!empty($kayit[0]["resim"])) { ?>
                      <div class="form-group">
                        <label>Mevcut Resim</label><br>
                        <img src="<?=ANASITE?>images/testimonials/<?=$kayit[0]["resim"]?>" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;" alt="Mevcut resim">
                      </div>
                      <?php } ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <small class="text-muted">
                        <strong>Oluşturulma:</strong> <?=date("d.m.Y H:i", strtotime($kayit[0]["tarih"]))?>
                      </small>
                    </div>
                    <div class="col-md-6">
                      <?php if(!empty($kayit[0]["onay_tarihi"])) { ?>
                      <small class="text-muted">
                        <strong>Onay/Red Tarihi:</strong> <?=date("d.m.Y H:i", strtotime($kayit[0]["onay_tarihi"]))?>
                      </small>
                      <?php } ?>
                    </div>
                  </div>
                </div>

                <div class="card-footer">
                  <button type="submit" name="kaydet" class="btn btn-primary">
                    <i class="fas fa-save"></i> Güncelle
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