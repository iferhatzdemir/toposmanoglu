<?php
if(!empty($_GET["tablo"]) && !empty($_GET["ID"]))
{
  $tablo=$VT->filter($_GET["tablo"]);
  $ID=$VT->filter($_GET["ID"]);
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Resim Yönetimi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=SITE?>">Anasayfa</a></li>
              <li class="breadcrumb-item active">Resim Yönetimi</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
      <div class="container-fluid">
     
       <form action="<?=SITE?>ajax.php" method="post" class="dropzone" enctype="multipart/form-data">
        <input type="hidden" name="tablo" value="<?=$tablo?>">
        <input type="hidden" name="ID" value="<?=$ID?>">
       </form>
       
      </div><!-- /.container-fluid -->
    </section>

     <section class="content">
      <div class="container-fluid">
      
       <div class="card">
            <div class="card-header">
              <h3 class="card-title">Resim Yönetimi</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-danger btn-sm" id="topluSil" style="display:none;">
                  <i class="fas fa-trash"></i> Seçilenleri Sil
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <form id="topluSilForm" method="post">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width:30px;">
                    <input type="checkbox" id="tumunuSec" title="Tümünü Seç/Bırak">
                  </th>
                  <th style="width:50px;">Sıra</th>
                  <th>Resim</th>
                  <th style="width:80px;">Tarih</th>
                  <th style="width:120px;">Kaldır</th>
                </tr>
                </thead>
                <tbody>
                <?php
        $veriler=$VT->VeriGetir("resimler","WHERE tablo=? AND KID=?",array($tablo,$ID),"ORDER BY ID ASC");
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
                          <a href="<?=SITE?>resim-sil/<?=$tablo?>/<?=$ID?>/<?=$veriler[$i]["ID"]?>" class="btn btn-danger btn-sm silmeAlani">Kaldır</a>
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
                  <th>Kaldır</th>
                </tr>
                </tfoot>
              </table>
              </form>
            </div>
            <!-- /.card-body -->
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
        $('.resimCheckbox').prop('checked', isChecked);
        $('#tumunuSec, #tumunuSecAlt').prop('checked', isChecked);
        toggleTopluSilButton();
    });

    // Tekil checkbox değişimlerini kontrol et
    $('.resimCheckbox').change(function() {
        var totalCheckboxes = $('.resimCheckbox').length;
        var checkedCheckboxes = $('.resimCheckbox:checked').length;

        $('#tumunuSec, #tumunuSecAlt').prop('checked', totalCheckboxes === checkedCheckboxes);
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
                        tablo: '<?=$tablo?>',
                        KID: '<?=$ID?>'
                    },
                    success: function(response) {
                        console.log('Ajax Response:', response);
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

<?php
}
?>