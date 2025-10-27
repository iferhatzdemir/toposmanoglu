<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Müşteri Yorumları Yönetimi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=SITE?>">Anasayfa</a></li>
              <li class="breadcrumb-item active">Yorumlar Yönetimi</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
       <div class="row">
        <div class="col-12">
         <div class="card">
            <div class="card-header">
              <h3 class="card-title">Müşteri Yorumları</h3>
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
              <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width:30px;">
                    <input type="checkbox" id="tumunuSec" title="Tümünü Seç/Bırak">
                  </th>
                  <th>Müşteri</th>
                  <th>Yorum</th>
                  <th>Puan</th>
                  <th>Durum</th>
                  <th>Tarih</th>
                  <th style="width:200px;">İşlem</th>
                </tr>
                </thead>
                <tbody>
                <?php
        $veriler = $VT->VeriGetir("testimonials", "", array(), "ORDER BY tarih DESC");
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
                $durumClass = "table-success";
                break;
              case 'reddedildi':
                $durumBadge = '<span class="badge badge-danger">Reddedildi</span>';
                $durumClass = "table-danger";
                break;
            }

            // Yıldızlar
            $yildizlar = "";
            for($j = 1; $j <= 5; $j++) {
              if($j <= $veriler[$i]["puan"]) {
                $yildizlar .= "<i class='fas fa-star text-warning'></i>";
              } else {
                $yildizlar .= "<i class='far fa-star text-muted'></i>";
              }
            }

            // Üye bilgisi
            $uyeBilgi = "Misafir";
            if(!empty($veriler[$i]["uyeID"])) {
              $uye = $VT->VeriGetir("uyeler", "WHERE ID=?", array($veriler[$i]["uyeID"]), "", 1);
              if($uye) {
                $uyeBilgi = $uye[0]["adsoyad"] . " (" . $uye[0]["mail"] . ")";
              }
            }
            ?>
                        <tr class="<?=$durumClass?>">
                          <td>
                            <input type="checkbox" name="seciliYorumlar[]" value="<?=$veriler[$i]["ID"]?>" class="yorumCheckbox">
                          </td>
                          <td>
                            <strong><?=stripslashes($veriler[$i]["ad_soyad"])?></strong><br>
                            <small class="text-muted"><?=$uyeBilgi?></small>
                          </td>
                          <td>
                            <div style="max-width: 300px;">
                              <?=substr(stripslashes($veriler[$i]["yorum"]), 0, 150)?>
                              <?=strlen($veriler[$i]["yorum"]) > 150 ? "..." : ""?>
                            </div>
                            <?php if(!empty($veriler[$i]["admin_notu"])) { ?>
                            <div class="mt-2">
                              <small class="text-info"><strong>Admin Notu:</strong> <?=stripslashes($veriler[$i]["admin_notu"])?></small>
                            </div>
                            <?php } ?>
                          </td>
                          <td><?=$yildizlar?></td>
                          <td><?=$durumBadge?></td>
                          <td><?=date("d.m.Y H:i", strtotime($veriler[$i]["tarih"]))?></td>
                          <td>
                            <div class="btn-group btn-group-sm">
                              <?php if($veriler[$i]["onay_durumu"] == 'beklemede') { ?>
                              <a href="javascript:void(0)" onclick="yorumOnayla(<?=$veriler[$i]["ID"]?>)" class="btn btn-success btn-sm" title="Onayla">
                                <i class="fas fa-check"></i>
                              </a>
                              <a href="javascript:void(0)" onclick="yorumReddet(<?=$veriler[$i]["ID"]?>)" class="btn btn-warning btn-sm" title="Reddet">
                                <i class="fas fa-times"></i>
                              </a>
                              <?php } ?>
                              <a href="javascript:void(0)" onclick="yorumDetay(<?=$veriler[$i]["ID"]?>)" class="btn btn-info btn-sm" title="Detay">
                                <i class="fas fa-eye"></i>
                              </a>
                              <a href="javascript:void(0)" onclick="yorumSil(<?=$veriler[$i]["ID"]?>)" class="btn btn-danger btn-sm" title="Sil">
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
                  <th>Müşteri</th>
                  <th>Yorum</th>
                  <th>Puan</th>
                  <th>Durum</th>
                  <th>Tarih</th>
                  <th>İşlem</th>
                </tr>
                </tfoot>
              </table>
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
            $('#topluOnayla, #topluReddet, #topluSil').show();
        } else {
            $('#topluOnayla, #topluReddet, #topluSil').hide();
        }
    }
});

// Tekil işlemler
function yorumOnayla(id) {
    Swal.fire({
        title: 'Yorumu onaylıyor musunuz?',
        text: 'Onaylanan yorum ana sayfada yayınlanacak.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Evet, Onayla',
        cancelButtonText: 'İptal'
    }).then((result) => {
        if (result.isConfirmed) {
            yorumIslem('onayla', [id]);
        }
    });
}

function yorumReddet(id) {
    Swal.fire({
        title: 'Yorumu reddediyor musunuz?',
        input: 'textarea',
        inputLabel: 'Ret nedeni (isteğe bağlı)',
        inputPlaceholder: 'Ret nedeninizi yazın...',
        showCancelButton: true,
        confirmButtonText: 'Reddet',
        cancelButtonText: 'İptal'
    }).then((result) => {
        if (result.isConfirmed) {
            yorumIslem('reddet', [id], result.value);
        }
    });
}

function yorumSil(id) {
    Swal.fire({
        title: 'Yorumu silmek istediğinizden emin misiniz?',
        text: 'Bu işlem geri alınamaz!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Evet, Sil',
        cancelButtonText: 'İptal'
    }).then((result) => {
        if (result.isConfirmed) {
            yorumIslem('sil', [id]);
        }
    });
}

// Yorum işlemleri
function yorumIslem(islem, idler, not = '') {
    $.ajax({
        url: '<?=SITE?>ajax.php',
        type: 'POST',
        data: {
            action: 'yorumIslem',
            islem: islem,
            idler: idler,
            admin_notu: not
        },
        success: function(response) {
            if(response.trim() == 'success') {
                Swal.fire('Başarılı!', 'İşlem başarıyla tamamlandı.', 'success').then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Hata!', 'İşlem sırasında bir hata oluştu!', 'error');
            }
        },
        error: function() {
            Swal.fire('Hata!', 'Sunucu hatası oluştu!', 'error');
        }
    });
}
</script>