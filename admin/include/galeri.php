<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Galeri Yönetimi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=SITE?>">Anasayfa</a></li>
              <li class="breadcrumb-item active">Galeri Yönetimi</li>
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
         <form action="<?=SITE?>ajax.php" method="post" class="dropzone" enctype="multipart/form-data">
          <input type="hidden" name="tablo" value="galeri">
          <input type="hidden" name="ID" value="1">
         </form>
        </div>
       </div>
      </div><!-- /.container-fluid -->
    </section>

     <section class="content">
      <div class="container-fluid">
       <div class="row">
        <div class="col-12">
         <div class="card">
            <div class="card-header">
              <h3 class="card-title">Galeri Resimleri</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-danger btn-sm" id="topluSil" style="display:none;">
                  <i class="fas fa-trash"></i> <span class="d-none d-sm-inline">Seçilenleri Sil</span>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form id="topluSilForm" method="post">

              <!-- Desktop Table View -->
              <div class="d-none d-md-block">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width:30px;">
                    <input type="checkbox" id="tumunuSec" title="Tümünü Seç/Bırak">
                  </th>
                  <th style="width:50px;">Sıra</th>
                  <th>Resim</th>
                  <th style="width:80px;">Tarih</th>
                  <th style="width:120px;">İşlem</th>
                </tr>
                </thead>
                <tbody>
                <?php
        $veriler=$VT->VeriGetir("resimler","WHERE tablo=? AND KID=?",array("galeri","1"),"ORDER BY ID ASC");

        // Debug: Veritabanındaki kayıtları kontrol et
        echo "<script>console.log('Veritabanında " . ($veriler ? count($veriler) : 0) . " kayıt bulundu.');</script>";
        if($veriler) {
            foreach($veriler as $v) {
                echo "<script>console.log('DB Kayıt: " . $v['resim'] . "');</script>";
            }
        }

        // Debug: Fiziksel dosyaları kontrol et
        $dosyalar = glob("../images/resimler/*.{jpg,jpeg,png,gif}", GLOB_BRACE);
        echo "<script>console.log('Fiziksel dosya sayısı: " . count($dosyalar) . "');</script>";
        foreach($dosyalar as $dosya) {
            $dosyaAdi = basename($dosya);
            echo "<script>console.log('Fiziksel dosya: " . $dosyaAdi . "');</script>";
        }

        if($veriler!=false)
        {
          $sira=0;
          for($i=0;$i<count($veriler);$i++)
          {
            $sira++;
            ?>
                        <tr>
                          <td>
                            <input type="checkbox" name="seciliResimler[]" value="<?=$veriler[$i]["ID"]?>" class="resimCheckbox">
                          </td>
                          <td><?=$sira?></td>
                          <td>
                            <img src="<?=ANASITE?>images/resimler/<?=$veriler[$i]["resim"]?>" style="height: 60px; width: auto; margin-right: 8px; float: left;">
                          </td>
                          <td><?=$veriler[$i]["tarih"]?></td>
                          <td>
                          <a href="<?=SITE?>resim-sil/galeri/1/<?=$veriler[$i]["ID"]?>" class="btn btn-danger btn-sm silmeAlani">Kaldır</a>
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
                  <th>Resim</th>
                  <th>Tarih</th>
                  <th>İşlem</th>
                </tr>
                </tfoot>
              </table>
              </div>
              </div>

              <!-- Mobile Card View -->
              <div class="d-block d-md-none">
                <div class="mb-3">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="tumunuSecMobile" title="Tümünü Seç/Bırak">
                    <label class="custom-control-label" for="tumunuSecMobile">Tümünü Seç/Bırak</label>
                  </div>
                </div>

                <?php
                if($veriler!=false)
                {
                  $sira=0;
                  for($i=0;$i<count($veriler);$i++)
                  {
                    $sira++;
                    ?>
                <div class="card mb-3 mobile-card">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-2">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" name="seciliResimler[]" value="<?=$veriler[$i]["ID"]?>" class="custom-control-input resimCheckbox" id="mobile_check_<?=$veriler[$i]["ID"]?>">
                          <label class="custom-control-label" for="mobile_check_<?=$veriler[$i]["ID"]?>"></label>
                        </div>
                      </div>
                      <div class="col-3">
                        <img src="<?=ANASITE?>images/resimler/<?=$veriler[$i]["resim"]?>" class="img-fluid rounded" style="max-height: 60px;">
                      </div>
                      <div class="col-4">
                        <small class="text-muted">Sıra: <?=$sira?></small><br>
                        <small class="text-muted"><?=$veriler[$i]["tarih"]?></small>
                      </div>
                      <div class="col-3 text-right">
                        <a href="<?=SITE?>resim-sil/galeri/1/<?=$veriler[$i]["ID"]?>" class="btn btn-danger btn-sm silmeAlani">
                          <i class="fas fa-trash"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
                    <?php
                  }
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

<script>
$(document).ready(function() {
    // Tümünü seç/bırak işlevi (Desktop + Mobile)
    $('#tumunuSec, #tumunuSecAlt, #tumunuSecMobile').change(function() {
        var isChecked = $(this).is(':checked');
        $('.resimCheckbox').prop('checked', isChecked);
        $('#tumunuSec, #tumunuSecAlt, #tumunuSecMobile').prop('checked', isChecked);
        toggleTopluSilButton();
    });

    // Tekil checkbox değişimlerini kontrol et
    $('.resimCheckbox').change(function() {
        var totalCheckboxes = $('.resimCheckbox').length;
        var checkedCheckboxes = $('.resimCheckbox:checked').length;

        $('#tumunuSec, #tumunuSecAlt, #tumunuSecMobile').prop('checked', totalCheckboxes === checkedCheckboxes);
        toggleTopluSilButton();
    });

    // Toplu sil butonu göster/gizle
    function toggleTopluSilButton() {
        var checkedCount = $('.resimCheckbox:checked').length;
        if(checkedCount > 0) {
            $('#topluSil').show();
        } else {
            $('#topluSil').hide();
        }
    }

    // Toplu silme işlemi
    $('#topluSil').click(function() {
        var seciliResimler = [];
        $('.resimCheckbox:checked').each(function() {
            seciliResimler.push($(this).val());
        });

        if(seciliResimler.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Uyarı!',
                text: 'Lütfen silinecek resimleri seçin!',
                confirmButtonText: 'Tamam'
            });
            return;
        }

        Swal.fire({
            title: 'Emin misiniz?',
            text: seciliResimler.length + ' resmi silmek istediğinizden emin misiniz?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Evet, Sil!',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Buton deaktif et ve loading göster
                $('#topluSil').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Siliniyor...');

                // Loading sweetalert göster
                Swal.fire({
                    title: 'Siliniyor...',
                    text: 'Resimler siliniyor, lütfen bekleyin.',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });

                $.ajax({
                    url: '<?=SITE?>ajax.php',
                    type: 'POST',
                    data: {
                        action: 'topluResimSil',
                        resimIds: seciliResimler,
                        tablo: 'galeri',
                        KID: '1'
                    },
                    success: function(response) {
                        console.log('Ajax Response:', response); // Debug için
                        if(response.trim() == 'success') {
                            // Başarılı silme mesajı
                            Swal.fire({
                                icon: 'success',
                                title: 'Başarılı!',
                                text: seciliResimler.length + ' resim başarıyla silindi.',
                                confirmButtonText: 'Tamam'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Hata!',
                                text: 'Silme işlemi sırasında bir hata oluştu!',
                                confirmButtonText: 'Tamam'
                            });
                            // Butonu tekrar aktif et
                            $('#topluSil').prop('disabled', false).html('<i class="fas fa-trash"></i> Seçilenleri Sil');
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Hata!',
                            text: 'Silme işlemi sırasında bir hata oluştu!',
                            confirmButtonText: 'Tamam'
                        });
                        // Butonu tekrar aktif et
                        $('#topluSil').prop('disabled', false).html('<i class="fas fa-trash"></i> Seçilenleri Sil');
                    }
                });
            }
        });
    });
});
</script>

<style>
/* Responsive Styles */
@media (max-width: 767.98px) {
    .mobile-card {
        border: 1px solid #dee2e6;
        transition: box-shadow 0.15s ease-in-out;
    }

    .mobile-card:hover {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .card-header .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    .card-title {
        font-size: 1.1rem;
        margin-bottom: 0;
    }

    /* Dropzone responsive */
    .dropzone {
        min-height: 120px !important;
        padding: 20px 10px;
    }

    .dropzone .dz-message {
        font-size: 14px;
    }
}

@media (min-width: 768px) and (max-width: 991.98px) {
    .table th, .table td {
        padding: 0.5rem;
        font-size: 0.9rem;
    }

    .btn-sm {
        padding: 0.25rem 0.4rem;
        font-size: 0.8rem;
    }
}

/* General responsive improvements */
.table-responsive {
    -webkit-overflow-scrolling: touch;
}

.card-tools .btn {
    white-space: nowrap;
}

@media (max-width: 575.98px) {
    .content-header h1 {
        font-size: 1.5rem;
    }

    .breadcrumb {
        font-size: 0.85rem;
    }

    .card-header {
        padding: 0.75rem 1rem;
    }

    .card-body {
        padding: 1rem;
    }
}
</style>