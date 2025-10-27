
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap4.min.css">

<style>
/* Gül Kurusu Renk Paleti ve Stil */
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
  --dusty-rose: #c9ada7;
  --dusty-rose-dark: #9a8c98;
  --mauve-light: #e8b4b8;
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

.table th {
  background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%);
  color: #9f1239;
  font-weight: 600;
  border-color: #fecdd3;
}

.table-hover tbody tr:hover {
  background-color: #fff1f2;
}

.table tbody tr {
  transition: all 0.2s ease;
}

.banner-image {
  border: 2px solid #fecdd3;
  border-radius: 0.25rem;
  transition: all 0.3s ease;
}

.banner-image:hover {
  border-color: #fda4af;
  box-shadow: 0 2px 8px rgba(244, 63, 94, 0.2);
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

/* DataTables Custom Buttons */
.dt-button.buttons-excel {
  background: #9a8c98 !important;
  border-color: #9a8c98 !important;
}

.dt-button.buttons-pdf {
  background: #c9ada7 !important;
  border-color: #c9ada7 !important;
}

.dt-button.buttons-copy {
  background: #e8b4b8 !important;
  border-color: #e8b4b8 !important;
}

/* DataTables Pagination */
.dataTables_wrapper .dataTables_paginate .paginate_button.current {
  background: #f43f5e !important;
  border-color: #f43f5e !important;
  color: white !important;
}

.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
  background: #fecdd3 !important;
  border-color: #fda4af !important;
  color: #9f1239 !important;
}

/* Custom Switch - Gül Kurusu */
.custom-switch .custom-control-input:checked ~ .custom-control-label::before {
  background-color: #f43f5e !important;
  border-color: #f43f5e !important;
}

.custom-switch .custom-control-input:focus ~ .custom-control-label::before {
  box-shadow: 0 0 0 0.2rem rgba(244, 63, 94, 0.25) !important;
}
</style>

<div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row align-items-center mb-3">
          <div class="col-sm-6">
            <?php
            $veriler=$VT->VeriGetir("banner","","","ORDER BY ID ASC");
            $toplamKayit = $veriler ? count($veriler) : 0;
            ?>
            <h1 class="m-0" style="color: #9f1239; border-left: 4px solid #f43f5e; padding-left: 15px;">Banner Listesi <small class="text-muted">(<?=$toplamKayit?> kayit)</small></h1>
          </div>
          <div class="col-sm-6 text-right">
            <a href="<?=SITE?>banner-ekle" class="btn btn-primary">
              <i class="fas fa-plus mr-1"></i> Yeni Banner Ekle
            </a>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Banner Listesi</h3>
          </div>
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th style="width:80px;">Sira</th>
                <th>Banner Bilgileri</th>
                <th style="width:100px;">Durum</th>
                <th style="width:150px;">Tarih</th>
                <th style="width:250px;">Islem</th>
              </tr>
              </thead>
              <tbody>
              <?php
				if($veriler!=false)
				{
					$sira=0;
					for($i=0;$i<count($veriler);$i++)
					{
						$sira++;
						if($veriler[$i]["durum"]==1){$aktifpasif=' checked="checked"';}else{$aktifpasif='';}
						?>
                        <tr>
                          <td><?=$sira?></td>
                          <td>
                            <div style="display: flex; align-items: center;">
                              <div style="margin-right: 15px; display:flex; flex-direction:column; gap:8px;">
                                <div>
                                  <span class="badge badge-pill badge-light" style="background-color:#ffe4e6; color:#9f1239;">Masaüstü</span>
                                  <img src="<?=ANASITE?>images/banner/<?=$veriler[$i]["resim"]?>" class="banner-image mt-1" style="height: 60px; width: 100px; object-fit: cover;">
                                </div>
                                <?php if(!empty($veriler[$i]["resim_mobil"])): ?>
                                <div>
                                  <span class="badge badge-pill badge-light" style="background-color:#fecdd3; color:#9f1239;">Mobil</span>
                                  <img src="<?=ANASITE?>images/banner/<?=$veriler[$i]["resim_mobil"]?>" class="banner-image mt-1" style="height: 60px; width: 100px; object-fit: cover;">
                                </div>
                                <?php endif; ?>
                              </div>
                              <div>
                                <strong style="color: #9f1239;"><?=stripslashes($veriler[$i]["baslik"])?></strong>
                              </div>
                            </div>
                          </td>
                          <td>
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                              <input type="checkbox" class="custom-control-input aktifpasif<?=$veriler[$i]["ID"]?>" id="customSwitch3<?=$veriler[$i]["ID"]?>"<?=$aktifpasif?> value="<?=$veriler[$i]["ID"]?>" onclick="aktifpasif(<?=$veriler[$i]["ID"]?>,'banner');">
                              <label class="custom-control-label" for="customSwitch3<?=$veriler[$i]["ID"]?>"></label>
                            </div>
                          </td>
                          <td><?=$veriler[$i]["tarih"]?></td>
                          <td>
                            <a href="<?=SITE?>banner-duzenle/<?=$veriler[$i]["ID"]?>" class="btn btn-sm btn-warning" title="Duzenle">
                              <i class="fas fa-edit"></i> Duzenle
                            </a>
                            <a href="<?=SITE?>banner-sil/<?=$veriler[$i]["ID"]?>" class="btn btn-sm btn-danger silmeAlani" title="Kaldir">
                              <i class="fas fa-trash"></i> Kaldir
                            </a>
                          </td>
                        </tr>
                        <?php
					}
				}
                else
                {
                    ?>
                    <tr>
                      <td colspan="5" class="text-center py-5">
                        <p class="text-muted mb-3">Henuz banner bulunamadi</p>
                        <a href="<?=SITE?>banner-ekle" class="btn btn-primary">
                          <i class="fas fa-plus"></i> Ilk Banner'i Ekle
                        </a>
                      </td>
                    </tr>
                    <?php
                }
				?>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </section>
  </div>

<!-- DataTables Scripts -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.colVis.min.js"></script>

<script>
$(function () {
  $("#example1").DataTable({
    "responsive": true,
    "lengthChange": true,
    "autoWidth": false,
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/tr.json"
    },
    "buttons": [
      {
        extend: 'copy',
        text: 'Kopyala',
        className: 'btn btn-sm btn-secondary'
      },
      {
        extend: 'csv',
        text: 'CSV',
        className: 'btn btn-sm btn-secondary'
      },
      {
        extend: 'excel',
        text: 'Excel',
        className: 'btn btn-sm buttons-excel'
      },
      {
        extend: 'pdf',
        text: 'PDF',
        className: 'btn btn-sm buttons-pdf'
      },
      {
        extend: 'print',
        text: 'Yazdir',
        className: 'btn btn-sm btn-info'
      }
    ]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

  // Silme onay popup'ı
  $('.silmeAlani').on('click', function(e) {
    if(!confirm('Bu kaydı silmek istediğinizden emin misiniz?')) {
      e.preventDefault();
      return false;
    }
  });
});
</script>
