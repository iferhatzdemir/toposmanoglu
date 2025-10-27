<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Müşteri Yorumları</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=SITE?>">Anasayfa</a></li>
              <li class="breadcrumb-item active">Müşteri Yorumları</li>
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
         <a href="<?=SITE?>testimonials-ekle" class="btn btn-success" style="float:right; margin-bottom:10px;">
           <i class="fa fa-plus"></i> YENİ EKLE
         </a>
        </div>
       </div>
       <div class="row">
        <div class="col-12">
         <div class="card">
            <div class="card-header">
              <h3 class="card-title">Tüm Testimonials</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm" id="topluOnayla" style="display:none;">
                  <i class="fas fa-check"></i> Seçilenleri Onayla
                </button>
                <button type="button" class="btn btn-warning btn-sm" id="topluReddet" style="display:none;">
                  <i class="fas fa-times"></i> Seçilenleri Reddet
                </button>
                <button type="button" class="btn btn-danger btn-sm" id="topluSil" style="display:none;">
                  <i class="fas fa-trash"></i> Seçilenleri Sil
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form id="topluIslemForm" method="post">
              <!-- Desktop Table View -->
              <div class="table-responsive d-none d-md-block">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width:30px;">
                    <input type="checkbox" id="tumunuSec" title="Tümünü Seç/Bırak">
                  </th>
                  <th>Resim</th>
                  <th>Müşteri</th>
                  <th>Yorum</th>
                  <th>Puan</th>
                  <th>Durum</th>
                  <th class="mobile-hide">Sıra</th>
                  <th style="width:200px;">İşlem</th>
                </tr>
                </thead>
                <tbody>
                <?php
        $veriler = $VT->VeriGetir("testimonials", "", array(), "ORDER BY sirano ASC, tarih DESC");
        if($veriler != false) {
          for($i = 0; $i < count($veriler); $i++) {

            // Durum badge'leri
            $durumBadge = "";
            $durumClass = "";
            switch($veriler[$i]["onay_durumu"]) {
              case 'beklemede':
                $durumBadge = '<span class="badge badge-warning">Beklemede</span>';
                $durumClass = "table-warning";
                break;
              case 'onaylandi':
                $durumBadge = '<span class="badge badge-success">Onaylandı</span>';
                $durumClass = ($veriler[$i]["durum"] == 1) ? "table-success" : "";
                break;
              case 'reddedildi':
                $durumBadge = '<span class="badge badge-danger">Reddedildi</span>';
                $durumClass = "table-danger";
                break;
            }

            // Aktif/Pasif durumu
            $aktifDurum = ($veriler[$i]["durum"] == 1) ?
              '<span class="badge badge-success">Aktif</span>' :
              '<span class="badge badge-secondary">Pasif</span>';

            // Yıldızlar
            $yildizlar = "";
            for($j = 1; $j <= 5; $j++) {
              if($j <= $veriler[$i]["puan"]) {
                $yildizlar .= "<i class='fas fa-star text-warning'></i>";
              } else {
                $yildizlar .= "<i class='far fa-star text-muted'></i>";
              }
            }

            // Resim
            $resimPath = !empty($veriler[$i]["resim"]) ?
              ANASITE."images/testimonials/".$veriler[$i]["resim"] :
              SITE."assets/img/no-image.png";
            ?>
                        <tr class="<?=$durumClass?>">
                          <td>
                            <input type="checkbox" name="seciliTestimonials[]" value="<?=$veriler[$i]["ID"]?>" class="testimonialCheckbox">
                          </td>
                          <td>
                            <img src="<?=$resimPath?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;" alt="Müşteri">
                          </td>
                          <td>
                            <strong><?=stripslashes($veriler[$i]["ad_soyad"])?></strong>
                            <?php if(!empty($veriler[$i]["uyeID"])) { ?>
                            <br><small class="text-info"><i class="fas fa-user"></i> Üye</small>
                            <?php } ?>
                          </td>
                          <td>
                            <div style="max-width: 250px;">
                              <?=substr(stripslashes($veriler[$i]["yorum"]), 0, 100)?>
                              <?=strlen($veriler[$i]["yorum"]) > 100 ? "..." : ""?>
                            </div>
                          </td>
                          <td><?=$yildizlar?> (<?=$veriler[$i]["puan"]?>)</td>
                          <td>
                            <?=$durumBadge?><br>
                            <?=$aktifDurum?>
                          </td>
                          <td><?=$veriler[$i]["sirano"]?></td>
                          <td>
                            <div class="btn-group btn-group-sm">
                              <a href="javascript:void(0)" onclick="testimonialDetayGoster(<?=$veriler[$i]["ID"]?>)" class="btn btn-info btn-sm" title="İncele">
                                <i class="fas fa-eye"></i>
                              </a>
                              <?php if($veriler[$i]["onay_durumu"] == 'beklemede') { ?>
                              <a href="javascript:void(0)" onclick="testimonialOnayla(<?=$veriler[$i]["ID"]?>)" class="btn btn-success btn-sm" title="Onayla">
                                <i class="fas fa-check"></i>
                              </a>
                              <a href="javascript:void(0)" onclick="testimonialReddet(<?=$veriler[$i]["ID"]?>)" class="btn btn-warning btn-sm" title="Reddet">
                                <i class="fas fa-times"></i>
                              </a>
                              <?php } ?>
                              <a href="javascript:void(0)" onclick="testimonialSil(<?=$veriler[$i]["ID"]?>)" class="btn btn-danger btn-sm silmeAlani" title="Sil">
                                <i class="fas fa-trash"></i>
                              </a>
                            </div>
                          </td>
                        </tr>
                        <?php
          }
        }
        ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>
                    <input type="checkbox" id="tumunuSecAlt" title="Tümünü Seç/Bırak">
                  </th>
                  <th>Resim</th>
                  <th>Müşteri</th>
                  <th>Yorum</th>
                  <th>Puan</th>
                  <th>Durum</th>
                  <th>Sıra</th>
                  <th>İşlem</th>
                </tr>
                </tfoot>
              </table>
              </div>

              <!-- Mobile Card View -->
              <div class="d-md-none">
                <?php
                $veriler = $VT->VeriGetir("testimonials", "", array(), "ORDER BY sirano ASC, tarih DESC");
                if($veriler != false) {
                  for($i = 0; $i < count($veriler); $i++) {
                    // Durum badge'leri
                    $durumBadge = "";
                    $durumClass = "";
                    switch($veriler[$i]["onay_durumu"]) {
                      case 'beklemede':
                        $durumBadge = '<span class="badge badge-warning">Beklemede</span>';
                        $durumClass = "border-warning";
                        break;
                      case 'onaylandi':
                        $durumBadge = '<span class="badge badge-success">Onaylandı</span>';
                        $durumClass = "border-success";
                        break;
                      case 'reddedildi':
                        $durumBadge = '<span class="badge badge-danger">Reddedildi</span>';
                        $durumClass = "border-danger";
                        break;
                    }

                    // Aktif/Pasif durumu
                    $aktifDurum = ($veriler[$i]["durum"] == 1) ?
                      '<span class="badge badge-success">Aktif</span>' :
                      '<span class="badge badge-secondary">Pasif</span>';

                    // Yıldızlar
                    $yildizlar = "";
                    for($j = 1; $j <= 5; $j++) {
                      if($j <= $veriler[$i]["puan"]) {
                        $yildizlar .= "<i class='fas fa-star text-warning'></i>";
                      } else {
                        $yildizlar .= "<i class='far fa-star text-muted'></i>";
                      }
                    }

                    // Resim
                    $resimPath = !empty($veriler[$i]["resim"]) ?
                      ANASITE."images/testimonials/".$veriler[$i]["resim"] :
                      SITE."assets/img/no-image.png";
                    ?>
                    <div class="testimonial-responsive <?=$durumClass?> mb-3">
                      <div class="testimonial-header">
                        <input type="checkbox" name="seciliTestimonials[]" value="<?=$veriler[$i]["ID"]?>" class="testimonialCheckbox mr-2">
                        <?php if(!empty($veriler[$i]["resim"])) { ?>
                        <img src="<?=$resimPath?>" class="testimonial-avatar" alt="Müşteri">
                        <?php } else { ?>
                        <div class="testimonial-avatar bg-secondary d-flex align-items-center justify-content-center">
                          <i class="fas fa-user text-white"></i>
                        </div>
                        <?php } ?>
                        <div class="testimonial-info flex-grow-1">
                          <h6><?=stripslashes($veriler[$i]["ad_soyad"])?></h6>
                          <p class="testimonial-meta">
                            <?php if(!empty($veriler[$i]["uyeID"])) { ?>
                            <i class="fas fa-user text-info"></i> Üye
                            <?php } else { ?>
                            <i class="fas fa-user-slash text-muted"></i> Misafir
                            <?php } ?>
                            • Sıra: <?=$veriler[$i]["sirano"]?>
                          </p>
                        </div>
                      </div>

                      <div class="testimonial-content">
                        <div class="testimonial-yorum">
                          <?=substr(stripslashes($veriler[$i]["yorum"]), 0, 150)?>
                          <?=strlen($veriler[$i]["yorum"]) > 150 ? "..." : ""?>
                        </div>

                        <div class="testimonial-rating">
                          <?=$yildizlar?> <small class="text-muted">(<?=$veriler[$i]["puan"]?>/5)</small>
                        </div>
                      </div>

                      <div class="testimonial-footer">
                        <div class="testimonial-badges">
                          <?=$durumBadge?>
                          <?=$aktifDurum?>
                        </div>

                        <div class="testimonial-actions">
                          <a href="javascript:void(0)" onclick="testimonialDetayGoster(<?=$veriler[$i]["ID"]?>)" class="btn btn-info btn-sm" title="İncele">
                            <i class="fas fa-eye"></i>
                          </a>
                          <?php if($veriler[$i]["onay_durumu"] == 'beklemede') { ?>
                          <a href="javascript:void(0)" onclick="testimonialOnayla(<?=$veriler[$i]["ID"]?>)" class="btn btn-success btn-sm" title="Onayla">
                            <i class="fas fa-check"></i>
                          </a>
                          <a href="javascript:void(0)" onclick="testimonialReddet(<?=$veriler[$i]["ID"]?>)" class="btn btn-warning btn-sm" title="Reddet">
                            <i class="fas fa-times"></i>
                          </a>
                          <?php } ?>
                          <a href="javascript:void(0)" onclick="testimonialSil(<?=$veriler[$i]["ID"]?>)" class="btn btn-danger btn-sm" title="Sil">
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                } else {
                  echo '<div class="alert alert-info">Henüz testimonial bulunmamaktadır.</div>';
                }
                ?>
              </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
        </div>
       </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<!-- Testimonial Detay Modal -->
<div class="modal fade" id="testimonialDetayModal" tabindex="-1" role="dialog" aria-labelledby="testimonialDetayModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="testimonialDetayModalLabel">
          <i class="fas fa-star mr-2"></i>Testimonial Detayları
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="testimonialDetayIcerik">
        <div class="text-center">
          <i class="fas fa-spinner fa-spin fa-2x text-info"></i>
          <p class="mt-2">Yükleniyor...</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          <i class="fas fa-times mr-1"></i>Kapat
        </button>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    // Tümünü seç/bırak işlevi
    $('#tumunuSec, #tumunuSecAlt').change(function() {
        var isChecked = $(this).is(':checked');
        $('.testimonialCheckbox').prop('checked', isChecked);
        $('#tumunuSec, #tumunuSecAlt').prop('checked', isChecked);
        toggleTopluIslemButtons();
    });

    // Tekil checkbox değişimlerini kontrol et
    $('.testimonialCheckbox').change(function() {
        var totalCheckboxes = $('.testimonialCheckbox').length;
        var checkedCheckboxes = $('.testimonialCheckbox:checked').length;

        $('#tumunuSec, #tumunuSecAlt').prop('checked', totalCheckboxes === checkedCheckboxes);
        toggleTopluIslemButtons();
    });

    // Toplu işlem butonları göster/gizle
    function toggleTopluIslemButtons() {
        var checkedCount = $('.testimonialCheckbox:checked').length;
        if(checkedCount > 0) {
            $('#topluOnayla, #topluReddet, #topluSil').show();
        } else {
            $('#topluOnayla, #topluReddet, #topluSil').hide();
        }
    }

    // Toplu onaylama
    $('#topluOnayla').click(function() {
        var seciliTestimonials = [];
        $('.testimonialCheckbox:checked').each(function() {
            seciliTestimonials.push($(this).val());
        });

        if(seciliTestimonials.length === 0) return;

        Swal.fire({
            title: 'Seçili testimonials onaylansın mı?',
            text: seciliTestimonials.length + ' testimonial onaylanacak.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Evet, Onayla',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                testimonialIslem('onayla', seciliTestimonials);
            }
        });
    });

    // Toplu reddetme
    $('#topluReddet').click(function() {
        var seciliTestimonials = [];
        $('.testimonialCheckbox:checked').each(function() {
            seciliTestimonials.push($(this).val());
        });

        if(seciliTestimonials.length === 0) return;

        Swal.fire({
            title: 'Seçili testimonials reddedilsin mi?',
            text: seciliTestimonials.length + ' testimonial reddedilecek.',
            icon: 'warning',
            input: 'textarea',
            inputLabel: 'Red sebebi (isteğe bağlı)',
            inputPlaceholder: 'Neden reddedildiğini açıklayın...',
            showCancelButton: true,
            confirmButtonText: 'Evet, Reddet',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                testimonialIslem('reddet', seciliTestimonials, result.value || '');
            }
        });
    });

    // Toplu silme
    $('#topluSil').click(function() {
        var seciliTestimonials = [];
        $('.testimonialCheckbox:checked').each(function() {
            seciliTestimonials.push($(this).val());
        });

        if(seciliTestimonials.length === 0) return;

        Swal.fire({
            title: 'Seçili testimonials silinsin mi?',
            text: seciliTestimonials.length + ' testimonial kalıcı olarak silinecek!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Evet, Sil',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                testimonialIslem('sil', seciliTestimonials);
            }
        });
    });
});

// Tekil işlemler
function testimonialOnayla(id) {
    Swal.fire({
        title: 'Testimonial onaylansın mı?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Evet, Onayla',
        cancelButtonText: 'İptal'
    }).then((result) => {
        if (result.isConfirmed) {
            testimonialIslem('onayla', [id]);
        }
    });
}

function testimonialReddet(id) {
    Swal.fire({
        title: 'Testimonial reddedilsin mi?',
        icon: 'warning',
        input: 'textarea',
        inputLabel: 'Red sebebi (isteğe bağlı)',
        inputPlaceholder: 'Neden reddedildiğini açıklayın...',
        showCancelButton: true,
        confirmButtonText: 'Evet, Reddet',
        cancelButtonText: 'İptal'
    }).then((result) => {
        if (result.isConfirmed) {
            testimonialIslem('reddet', [id], result.value || '');
        }
    });
}

function testimonialSil(id) {
    Swal.fire({
        title: 'Testimonial silinsin mi?',
        text: 'Bu işlem geri alınamaz!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Evet, Sil',
        cancelButtonText: 'İptal'
    }).then((result) => {
        if (result.isConfirmed) {
            testimonialIslem('sil', [id]);
        }
    });
}

// Testimonial detay popup göster
function testimonialDetayGoster(testimonialID) {
    // Modal'ı aç
    $('#testimonialDetayModal').modal('show');

    // İçeriği yükleniyor durumuna getir
    $('#testimonialDetayIcerik').html(`
        <div class="text-center">
            <i class="fas fa-spinner fa-spin fa-2x text-info"></i>
            <p class="mt-2">Yükleniyor...</p>
        </div>
    `);

    // AJAX ile testimonial detaylarını getir
    $.ajax({
        url: '<?=SITE?>ajax.php',
        type: 'POST',
        data: {
            action: 'testimonialDetayGetir',
            testimonialID: testimonialID
        },
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                var modalIcerik = `
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-user mr-1"></i>Müşteri Bilgileri
                                    </h6>
                                </div>
                                <div class="card-body">
                                    ${response.resim ?
                                        '<img src="' + response.resim + '" class="img-fluid mb-3" style="max-height: 100px; border-radius: 50%;">' :
                                        '<div class="bg-secondary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;"><i class="fas fa-user fa-2x text-white"></i></div>'
                                    }
                                    <h5>${response.ad_soyad}</h5>
                                    ${response.uyeID ? '<small class="text-info"><i class="fas fa-user"></i> Kayıtlı Üye</small>' : '<small class="text-muted">Misafir</small>'}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-star mr-1"></i>Testimonial Detayları
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <strong>Puan:</strong><br>
                                            ${response.yildizlar} (${response.puan}/5)
                                        </div>
                                        <div class="col-6">
                                            <strong>Tarih:</strong><br>
                                            ${response.tarih}
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <strong>Onay Durumu:</strong><br>
                                            ${response.onay_durumu_badge}
                                        </div>
                                        <div class="col-6">
                                            <strong>Yayın Durumu:</strong><br>
                                            ${response.yayin_durumu_badge}
                                        </div>
                                    </div>
                                    ${response.google_link ?
                                        '<div class="mb-3"><strong>Google Link:</strong><br><a href="' + response.google_link + '" target="_blank" class="btn btn-sm btn-outline-primary">Google\'da Görüntüle</a></div>' :
                                        ''
                                    }
                                    ${response.admin_notu ?
                                        '<div class="mb-3"><strong>Admin Notu:</strong><br><div class="p-2 bg-light rounded">' + response.admin_notu + '</div></div>' :
                                        ''
                                    }
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-comment mr-1"></i>Testimonial İçeriği
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="p-3 bg-light rounded">
                                        ${response.yorum}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $('#testimonialDetayIcerik').html(modalIcerik);
            } else {
                $('#testimonialDetayIcerik').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        ${response.message || 'Testimonial detayları yüklenirken hata oluştu!'}
                    </div>
                `);
            }
        },
        error: function() {
            $('#testimonialDetayIcerik').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Sunucu hatası! Lütfen tekrar deneyin.
                </div>
            `);
        }
    });
}

// Testimonial işlemleri
function testimonialIslem(islem, idler, admin_notu = '') {
    $.ajax({
        url: '<?=SITE?>ajax.php',
        type: 'POST',
        data: {
            action: 'yorumIslem',
            islem: islem,
            idler: idler,
            admin_notu: admin_notu
        },
        success: function(response) {
            if(response.trim() == 'success') {
                Swal.fire('Başarılı!', 'İşlem tamamlandı.', 'success').then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Hata!', 'İşlem sırasında hata oluştu!', 'error');
            }
        },
        error: function() {
            Swal.fire('Hata!', 'Sunucu hatası!', 'error');
        }
    });
}
</script>