
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Ürün Yorumları</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=SITE?>">Anasayfa</a></li>
              <li class="breadcrumb-item active">Ürün Yorumları</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
     
       <div class="card">
            <div class="card-header">
              <h3 class="card-title">Ürün Yorumları</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-success btn-sm" id="topluOnayla" style="display:none;">
                  <i class="fas fa-check"></i> Seçilenleri Onayla
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
                  <th style="width:50px;">Sıra</th>
                  <th>Ürün</th>
                  <th>Müşteri</th>
                  <th>Yorum & Puan</th>
                  <th style="width:80px;">Durum</th>
                  <th style="width:80px;" class="mobile-hide">Tarih</th>
                  <th style="width:120px;">İşlem</th>
                </tr>
                </thead>
                <tbody>
                <?php
				$veriler=$VT->VeriGetir("yorumlar","","","ORDER BY ID DESC");
				if($veriler!=false)
				{
					$sira=0;
					for($i=0;$i<count($veriler);$i++)
					{
						$sira++;
						if($veriler[$i]["durum"]==1){$aktifpasif=' checked="checked"';}else{$aktifpasif='';}
            // Üye bilgisi
            $uyebilgisi=$VT->VeriGetir("uyeler","WHERE ID=?",array($veriler[$i]["uyeID"]),"ORDER BY ID ASC",1);
            if($uyebilgisi!=false) {
              $uyeadsoyad=$uyebilgisi[0]["ad"]." ".$uyebilgisi[0]["soyad"];
              $uyemail=$uyebilgisi[0]["mail"];
            } else {
              $uyeadsoyad="Üye Bilgisi Bulunmadı";
              $uyemail="";
            }

            // Ürün bilgisi
            $urunbilgisi=$VT->VeriGetir("urunler","WHERE ID=?",array($veriler[$i]["urunID"]),"ORDER BY ID ASC",1);
            if($urunbilgisi!=false) {
              $urunbaslik=$urunbilgisi[0]["baslik"];
              $urunresim=$urunbilgisi[0]["resim"];
            } else {
              $urunbaslik="Ürün Bilgisi Bulunmadı";
              $urunresim="";
            }

            // Yıldızlar
            $yildizlar = "";
            $puan = intval($veriler[$i]["puan"]);
            for($j = 1; $j <= 5; $j++) {
              if($j <= $puan) {
                $yildizlar .= "<i class='fas fa-star text-warning'></i>";
              } else {
                $yildizlar .= "<i class='far fa-star text-muted'></i>";
              }
            }

            // Durum rengi
            $durumClass = ($veriler[$i]["durum"] == 1) ? "table-success" : "table-warning";
						?>
                        <tr class="<?=$durumClass?>">
                          <td>
                            <input type="checkbox" name="seciliYorumlar[]" value="<?=$veriler[$i]["ID"]?>" class="yorumCheckbox">
                          </td>
                          <td><?=$sira?></td>
                          <td>
                            <?php if(!empty($urunresim)) { ?>
                            <img src="<?=ANASITE?>images/urunler/<?=$urunresim?>" style="width: 40px; height: 40px; object-fit: cover; float: left; margin-right: 8px;">
                            <?php } ?>
                            <strong><?=mb_substr(stripslashes($urunbaslik), 0, 50, "UTF-8")?></strong>
                          </td>
                          <td>
                            <strong><?=$uyeadsoyad?></strong>
                            <?php if(!empty($uyemail)) { ?>
                            <br><small class="text-muted"><?=$uyemail?></small>
                            <?php } ?>
                          </td>
                          <td>
                            <div style="max-width: 200px;">
                              <?=mb_substr(stripslashes($veriler[$i]["metin"]), 0, 100, "UTF-8")?>
                              <?=strlen($veriler[$i]["metin"]) > 100 ? "..." : ""?>
                            </div>
                            <div class="mt-1">
                              <?=$yildizlar?> (<?=$puan?>/5)
                            </div>
                          </td>
                          <td>
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                              <input type="checkbox" class="custom-control-input aktifpasif<?=$veriler[$i]["ID"]?>" id="customSwitch3<?=$veriler[$i]["ID"]?>"<?=$aktifpasif?> value="<?=$veriler[$i]["ID"]?>" onclick="aktifpasif(<?=$veriler[$i]["ID"]?>,'yorumlar');">
                              <label class="custom-control-label" for="customSwitch3<?=$veriler[$i]["ID"]?>"></label>
                            </div>
                          </td>
                          <td class="mobile-hide"><?=date("d.m.Y", strtotime($veriler[$i]["tarih"]))?></td>
                          <td>
                            <div class="btn-group btn-group-sm">
                              <a href="javascript:void(0)" onclick="yorumDetayGoster(<?=$veriler[$i]["ID"]?>)" class="btn btn-info btn-sm" title="İncele">
                                <i class="fas fa-eye"></i>
                              </a>
                              <a href="javascript:void(0)" onclick="yorumSil(<?=$veriler[$i]["ID"]?>)" class="btn btn-danger btn-sm silmeAlani" title="Sil">
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
                  <th>Sıra</th>
                  <th>Ürün</th>
                  <th>Müşteri</th>
                  <th>Yorum & Puan</th>
                  <th>Durum</th>
                  <th>Tarih</th>
                  <th>İşlem</th>
                </tr>
                </tfoot>
              </table>
              </div>

              <!-- Mobile Card View -->
              <div class="d-md-none">
                <?php
                $veriler=$VT->VeriGetir("yorumlar","","","ORDER BY ID DESC");
                if($veriler!=false)
                {
                  $sira=0;
                  for($i=0;$i<count($veriler);$i++)
                  {
                    $sira++;
                    if($veriler[$i]["durum"]==1){$aktifpasif=' checked="checked"';}else{$aktifpasif='';}

                    // Üye bilgisi
                    $uyebilgisi=$VT->VeriGetir("uyeler","WHERE ID=?",array($veriler[$i]["uyeID"]),"ORDER BY ID ASC",1);
                    if($uyebilgisi!=false) {
                      $uyeadsoyad=$uyebilgisi[0]["ad"]." ".$uyebilgisi[0]["soyad"];
                      $uyemail=$uyebilgisi[0]["mail"];
                    } else {
                      $uyeadsoyad="Üye Bilgisi Bulunmadı";
                      $uyemail="";
                    }

                    // Ürün bilgisi
                    $urunbilgisi=$VT->VeriGetir("urunler","WHERE ID=?",array($veriler[$i]["urunID"]),"ORDER BY ID ASC",1);
                    if($urunbilgisi!=false) {
                      $urunbaslik=$urunbilgisi[0]["baslik"];
                      $urunresim=$urunbilgisi[0]["resim"];
                    } else {
                      $urunbaslik="Ürün Bilgisi Bulunmadı";
                      $urunresim="";
                    }

                    // Yıldızlar
                    $yildizlar = "";
                    $puan = intval($veriler[$i]["puan"]);
                    for($j = 1; $j <= 5; $j++) {
                      if($j <= $puan) {
                        $yildizlar .= "<i class='fas fa-star text-warning'></i>";
                      } else {
                        $yildizlar .= "<i class='far fa-star text-muted'></i>";
                      }
                    }

                    // Durum rengi
                    $durumClass = ($veriler[$i]["durum"] == 1) ? "border-success" : "border-warning";
                    $durumBadge = ($veriler[$i]["durum"] == 1) ? '<span class="badge badge-success">Yayında</span>' : '<span class="badge badge-warning">Beklemede</span>';
                    ?>
                    <div class="testimonial-responsive <?=$durumClass?> mb-3">
                      <div class="testimonial-header">
                        <input type="checkbox" name="seciliYorumlar[]" value="<?=$veriler[$i]["ID"]?>" class="yorumCheckbox mr-2">
                        <?php if(!empty($urunresim)) { ?>
                        <img src="<?=ANASITE?>images/urunler/<?=$urunresim?>" class="testimonial-avatar" alt="Ürün">
                        <?php } else { ?>
                        <div class="testimonial-avatar bg-secondary d-flex align-items-center justify-content-center">
                          <i class="fas fa-shopping-bag text-white"></i>
                        </div>
                        <?php } ?>
                        <div class="testimonial-info flex-grow-1">
                          <h6><?=mb_substr(stripslashes($urunbaslik), 0, 40, "UTF-8")?></h6>
                          <p class="testimonial-meta">
                            <strong><?=$uyeadsoyad?></strong>
                            <?php if(!empty($uyemail)) { ?>
                            <br><small class="text-muted"><?=$uyemail?></small>
                            <?php } ?>
                            <br><small class="text-info"><?=date("d.m.Y", strtotime($veriler[$i]["tarih"]))?></small>
                          </p>
                        </div>
                      </div>

                      <div class="testimonial-content">
                        <div class="testimonial-yorum">
                          <?=mb_substr(stripslashes($veriler[$i]["metin"]), 0, 120, "UTF-8")?>
                          <?=strlen($veriler[$i]["metin"]) > 120 ? "..." : ""?>
                        </div>

                        <div class="testimonial-rating">
                          <?=$yildizlar?> <small class="text-muted">(<?=$puan?>/5)</small>
                        </div>
                      </div>

                      <div class="testimonial-footer">
                        <div class="testimonial-badges">
                          <?=$durumBadge?>
                          <span class="badge badge-info">#<?=$sira?></span>
                        </div>

                        <div class="testimonial-actions">
                          <a href="javascript:void(0)" onclick="yorumDetayGoster(<?=$veriler[$i]["ID"]?>)" class="btn btn-info btn-sm" title="İncele">
                            <i class="fas fa-eye"></i>
                          </a>
                          <label class="switch-mobile">
                            <input type="checkbox" class="aktifpasif<?=$veriler[$i]["ID"]?>"<?=$aktifpasif?> value="<?=$veriler[$i]["ID"]?>" onclick="aktifpasif(<?=$veriler[$i]["ID"]?>,'yorumlar');">
                            <span class="slider-mobile"></span>
                          </label>
                          <a href="javascript:void(0)" onclick="yorumSil(<?=$veriler[$i]["ID"]?>)" class="btn btn-danger btn-sm" title="Sil">
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </div>
                    </div>
                    <?php
                  }
                } else {
                  echo '<div class="alert alert-info">Henüz yorum bulunmamaktadır.</div>';
                }
                ?>
              </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
       
       
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<!-- Yorum Detay Modal -->
<div class="modal fade" id="yorumDetayModal" tabindex="-1" role="dialog" aria-labelledby="yorumDetayModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="yorumDetayModalLabel">
          <i class="fas fa-comment-dots mr-2"></i>Yorum Detayları
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="yorumDetayIcerik">
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
        $('.yorumCheckbox').prop('checked', isChecked);
        $('#tumunuSec, #tumunuSecAlt').prop('checked', isChecked);
        toggleTopluIslemButtons();
    });

    // Tekil checkbox değişimlerini kontrol et
    $('.yorumCheckbox').change(function() {
        var totalCheckboxes = $('.yorumCheckbox').length;
        var checkedCheckboxes = $('.yorumCheckbox:checked').length;

        $('#tumunuSec, #tumunuSecAlt').prop('checked', totalCheckboxes === checkedCheckboxes);
        toggleTopluIslemButtons();
    });

    // Toplu işlem butonları göster/gizle
    function toggleTopluIslemButtons() {
        var checkedCount = $('.yorumCheckbox:checked').length;
        if(checkedCount > 0) {
            $('#topluOnayla, #topluSil').show();
        } else {
            $('#topluOnayla, #topluSil').hide();
        }
    }

    // Toplu onaylama
    $('#topluOnayla').click(function() {
        var seciliYorumlar = [];
        $('.yorumCheckbox:checked').each(function() {
            seciliYorumlar.push($(this).val());
        });

        if(seciliYorumlar.length === 0) return;

        Swal.fire({
            title: 'Seçili yorumları onayla?',
            text: seciliYorumlar.length + ' yorum onaylanacak ve yayında olacak.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Evet, Onayla',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                urunYorumIslem('onayla', seciliYorumlar);
            }
        });
    });

    // Toplu silme
    $('#topluSil').click(function() {
        var seciliYorumlar = [];
        $('.yorumCheckbox:checked').each(function() {
            seciliYorumlar.push($(this).val());
        });

        if(seciliYorumlar.length === 0) return;

        Swal.fire({
            title: 'Seçili yorumları sil?',
            text: seciliYorumlar.length + ' yorum kalıcı olarak silinecek!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Evet, Sil',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                urunYorumIslem('sil', seciliYorumlar);
            }
        });
    });
});

// Tekil işlemler
function yorumSil(id) {
    Swal.fire({
        title: 'Bu yorumu silmek istediğinizden emin misiniz?',
        text: 'Bu işlem geri alınamaz!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Evet, Sil',
        cancelButtonText: 'İptal'
    }).then((result) => {
        if (result.isConfirmed) {
            urunYorumIslem('sil', [id]);
        }
    });
}

// Ürün yorum işlemleri
function urunYorumIslem(islem, idler) {
    $.ajax({
        url: '<?=SITE?>ajax.php',
        type: 'POST',
        data: {
            action: 'urunYorumIslem',
            islem: islem,
            idler: idler
        },
        success: function(response) {
            console.log('Response:', response);
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

// Yorum detay popup göster
function yorumDetayGoster(yorumID) {
    // Modal'ı aç
    $('#yorumDetayModal').modal('show');

    // İçeriği yükleniyor durumuna getir
    $('#yorumDetayIcerik').html(`
        <div class="text-center">
            <i class="fas fa-spinner fa-spin fa-2x text-info"></i>
            <p class="mt-2">Yükleniyor...</p>
        </div>
    `);

    // AJAX ile yorum detaylarını getir
    $.ajax({
        url: '<?=SITE?>ajax.php',
        type: 'POST',
        data: {
            action: 'yorumDetayGetir',
            yorumID: yorumID
        },
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                var modalIcerik = `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-user mr-1"></i>Müşteri Bilgileri
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Ad Soyad:</strong><br>${response.uyeAdi}</p>
                                    <p><strong>E-posta:</strong><br>${response.uyeMail}</p>
                                    <p><strong>Tarih:</strong><br>${response.tarih}</p>
                                    <p><strong>Durum:</strong><br>${response.durum}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-shopping-bag mr-1"></i>Ürün Bilgileri
                                    </h6>
                                </div>
                                <div class="card-body text-center">
                                    <img src="${'<?=ANASITE?>'}images/urunler/${response.urunResim}"
                                         class="img-fluid mb-2"
                                         style="max-height: 120px; object-fit: cover;">
                                    <p><strong>${response.urunBaslik}</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0">
                                        <i class="fas fa-comment mr-1"></i>Yorum & Değerlendirme
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <strong>Puan:</strong> ${response.yildizlar} (${response.puan}/5)
                                    </div>
                                    <div>
                                        <strong>Yorum:</strong>
                                        <div class="mt-2 p-3 bg-light rounded">
                                            ${response.metin}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                $('#yorumDetayIcerik').html(modalIcerik);
            } else {
                $('#yorumDetayIcerik').html(`
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        ${response.message || 'Yorum detayları yüklenirken hata oluştu!'}
                    </div>
                `);
            }
        },
        error: function() {
            $('#yorumDetayIcerik').html(`
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Sunucu hatası! Lütfen tekrar deneyin.
                </div>
            `);
        }
    });
}
</script>

