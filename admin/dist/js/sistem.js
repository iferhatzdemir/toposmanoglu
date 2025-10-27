 
 var SITE=$("html").data("url");
 var ANASITE=$("html").data("anaurl");

 $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });


  });

   $(function () {
    // Summernote
    $('.textarea').summernote();
  });
  function aktifpasif(ID,tablo)
  {
    var durum=0;
   if($(".aktifpasif"+ID).is(':checked'))
   {
     durum=1;
   }
   else
   {
     durum=2;
   }
   
   $.ajax({
     method:"POST",
     url:SITE+"ajax.php",
     data:{"tablo":tablo,"ID":ID,"durum":durum},
     success: function(sonuc)
     {
       if(sonuc=="TAMAM")
       {
       }
       else
       {
         alert("İşleminiz şuan geçersizdir. Lütfen daha sonra tekrar deneyiniz.");
       }
     }
   });
  }

  function vitrinaktifpasif(ID,tablo)
  {
    var durum=0;
   if($(".vitrinaktifpasif"+ID).is(':checked'))
   {
     durum=1;
   }
   else
   {
     durum=2;
   }
   
   $.ajax({
     method:"POST",
     url:SITE+"ajax.php",
     data:{"tablo":tablo,"ID":ID,"vitrindurum":durum},
     success: function(sonuc)
     {
       if(sonuc=="TAMAM")
       {
       }
       else
       {
         alert("İşleminiz şuan geçersizdir. Lütfen daha sonra tekrar deneyiniz.");
       }
     }
   });
  }

  function stokOlustur()
  {
       $.ajax({
       method:"POST",
       url:SITE+"ajax.php",
       data:$(".urunEklemeFormu").serialize(),
       success: function(sonuc)
       {
         if(sonuc=="BOS")
         {
         }
         else
         {
           $(".stokYonetimAlani").html(sonuc);
         }
       }
     });
  }

  function secenekSil(secenekNo, varyasyonID)
  {
    Swal.fire({
      title: "Seçeneği silmek istediğinize emin misiniz?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Evet, Sil!",
      cancelButtonText: "İptal"
    }).then((result) => {
      if (result.isConfirmed) {
        $(".liste"+secenekNo).remove();

        // Eğer hiç seçenek kalmadıysa uyarı göster
        if($(".secenekler_"+varyasyonID+" li").length === 0) {
          Swal.fire({
            icon: "info",
            title: "Seçenek Kalmadı",
            text: "Bu varyasyon için en az bir seçenek eklemelisiniz.",
            confirmButtonText: "Tamam"
          });
        }

        // Otomatik olarak stok tablosunu güncelle
        stokOlustur();

        Swal.fire("Silindi!", "Seçenek başarıyla silindi.", "success");
      }
    });
  }

 var listeSira=0;
 function secenekEkleme(varyasyonID,varyasyonAdi)
     {
      listeSira=(listeSira+1);
      var tempListeSira = listeSira;

       Swal.fire({
          title: varyasyonAdi+" Seçeneği:",
          input: "text",
          inputPlaceholder: "Örn: S, M, L, XL veya Kırmızı, Mavi...",
          showCancelButton: true,
          confirmButtonText: "Ekle",
          cancelButtonText: "İptal",
          inputValidator: (value) => {
            if (!value) {
              return 'Seçenek boş olamaz!'
            }
          }
        })
        .then((result) => {
          if(result.isConfirmed && result.value)
          {
           var value = result.value;

           var secenekHTML = '<li class="list-group-item liste'+tempListeSira+'" style="padding: 10px 15px;">'+
             '<div style="display: flex; justify-content: space-between; align-items: center;">'+
               '<span><i class="fas fa-tag text-muted mr-2"></i><strong>'+value+'</strong></span>'+
               '<button type="button" class="btn btn-sm btn-danger" onclick="secenekSil('+tempListeSira+', '+varyasyonID+');">'+
                 '<i class="fa fa-trash"></i>'+
               '</button>'+
             '</div>'+
             '<input type="hidden" name="secenek'+varyasyonID+'[]" value="'+value+'" />'+
           '</li>';

           $(".secenekler_"+varyasyonID).append(secenekHTML);

           // Otomatik olarak stok tablosunu güncelle
           stokOlustur();

           // Başka seçenek eklemek isteyip istemediğini sor
           Swal.fire({
             title: "Seçenek Eklendi!",
             text: "Başka bir seçenek eklemek ister misiniz?",
             icon: "success",
             showCancelButton: true,
             confirmButtonText: "Evet, Ekle",
             cancelButtonText: "Hayır"
           }).then((result2) => {
             if(result2.isConfirmed) {
               secenekEkleme(varyasyonID, varyasyonAdi);
             }
           });
          }
        })
        .catch((error) => {
          console.error('Seçenek ekleme hatası:', error);
        });
     }

  $(function(){
    $(".silmeAlani").click(function(e){
      
      e.preventDefault();
      var yonlenecekAdres=e.currentTarget.getAttribute("href");

      Swal.fire({
  title: "Kaldırmak istediğinizden emin misiniz?",
  text: "Bu veriyi sildiğinizde bir daha geri alamayacaksınız.",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#d33",
  cancelButtonColor: "#3085d6",
  confirmButtonText: "Evet, Sil!",
  cancelButtonText: "İptal"
})
.then((result) => {
  if (result.isConfirmed) {
   window.location.href=yonlenecekAdres;
  } else {
    Swal.fire("İşleminiz başarıyla iptal edildi.");
  }
});

     
     
      });

   

      var varyasyonNo=0;

      // Varyasyon Silme Fonksiyonu
      function varyasyonSil(varyasyonNumarasi) {
        Swal.fire({
          title: "Varyasyonu silmek istediğinize emin misiniz?",
          text: "Bu varyasyona ait tüm seçenekler de silinecektir.",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Evet, Sil!",
          cancelButtonText: "İptal"
        }).then((result) => {
          if (result.isConfirmed) {
            $(".varyasyonNo_"+varyasyonNumarasi).remove();
            varyasyonNo--;

            // Eğer hiç varyasyon kalmadıysa stok tablosunu temizle
            if($(".varyasyonGrup > div").length === 0) {
              $(".stokYonetimAlani").html("");
            } else {
              // Otomatik stok tablosunu yeniden oluştur
              stokOlustur();
            }

            Swal.fire("Silindi!", "Varyasyon başarıyla silindi.", "success");
          }
        });
      }

      // Varyasyon Ekleme
      $(".varyasyonEkleme").click(function(){

        if(varyasyonNo >= 2) {
          Swal.fire({
            icon: "warning",
            title: "Maksimum Limit",
            text: "Maksimum 2 adet varyasyon tanımlayabilirsiniz."
          });
          return false;
        }

        varyasyonNo=(varyasyonNo+1);
        Swal.fire({
          title: "Varyasyon İsmi:",
          input: "text",
          inputPlaceholder: "Örn: Beden, Renk, Kapasite...",
          showCancelButton: true,
          confirmButtonText: "Ekle",
          cancelButtonText: "İptal",
          inputValidator: (value) => {
            if (!value) {
              return 'Varyasyon ismi boş olamaz!'
            }
          }
        })
        .then((result) => {
          if(result.isConfirmed && result.value)
          {
            var value = result.value;

            var varyasyonHTML = '<div class="col-md-6 varyasyonNo_'+varyasyonNo+'" style="margin-bottom: 20px;">'+
              '<div class="card card-outline card-success">'+
                '<div class="card-header">'+
                  '<h3 class="card-title"><i class="fas fa-tags"></i> <strong>'+value+'</strong></h3>'+
                  '<div class="card-tools">'+
                    '<button type="button" class="btn btn-sm btn-success" onclick="secenekEkleme('+varyasyonNo+',\''+value+'\');">'+
                      '<i class="fa fa-plus"></i> Seçenek Ekle'+
                    '</button> '+
                    '<button type="button" class="btn btn-sm btn-danger" onclick="varyasyonSil('+varyasyonNo+');">'+
                      '<i class="fa fa-trash"></i> Sil'+
                    '</button>'+
                  '</div>'+
                '</div>'+
                '<div class="card-body">'+
                  '<ul class="secenekler_'+varyasyonNo+' list-group"></ul>'+
                  '<input type="hidden" name="varyasyon'+varyasyonNo+'" value="'+value+'" />'+
                '</div>'+
              '</div>'+
            '</div>';

            $(".varyasyonGrup").append(varyasyonHTML);

            // İlk seçeneği otomatik olarak ekle
            setTimeout(function() {
              secenekEkleme(varyasyonNo, value);
            }, 300);
          } else {
            varyasyonNo--;
          }
        })
        .catch((error) => {
          console.error('Varyasyon ekleme hatası:', error);
          varyasyonNo--;
        });

      });

      // Global fonksiyon olarak tanımla (onclick için)
      window.varyasyonSil = varyasyonSil;

  });

  // Resim Yükleme ve Önizleme
  $(function() {
    if($("#resimInput").length > 0) {
      // Custom file input label güncelleme
      $("#resimInput").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).next(".custom-file-label").html(fileName);

        // Dosya seçildiyse önizleme göster
        if(this.files && this.files[0]) {
          var file = this.files[0];

          // Dosya tipi kontrolü
          var validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
          if(!validTypes.includes(file.type)) {
            Swal.fire({
              icon: 'error',
              title: 'Geçersiz Dosya Tipi',
              text: 'Lütfen sadece JPG, JPEG, PNG, GIF, WebP veya SVG formatında resim yükleyiniz.',
              confirmButtonColor: '#dc3545'
            });
            $(this).val('');
            $(this).next(".custom-file-label").html('Resim seçiniz...');
            $("#resimOnizleme").hide();
            return false;
          }

          // Dosya boyutu kontrolü (5MB)
          var maxSize = 5 * 1024 * 1024; // 5MB
          if(file.size > maxSize) {
            Swal.fire({
              icon: 'error',
              title: 'Dosya Çok Büyük',
              text: 'Resim boyutu maksimum 5MB olmalıdır. Seçilen dosya: ' + (file.size / 1024 / 1024).toFixed(2) + ' MB',
              confirmButtonColor: '#dc3545'
            });
            $(this).val('');
            $(this).next(".custom-file-label").html('Resim seçiniz...');
            $("#resimOnizleme").hide();
            return false;
          }

          // Dosya bilgilerini göster
          $("#dosyaAdi").text(file.name);
          $("#dosyaBoyutu").text(formatBytes(file.size));
          $("#dosyaTipi").text(file.type.replace('image/', '').toUpperCase());

          // FileReader ile resim önizleme
          var reader = new FileReader();
          reader.onload = function(e) {
            $("#onizlemeResim").attr('src', e.target.result);

            // Resim boyutlarını al
            var img = new Image();
            img.onload = function() {
              $("#resimBoyutlari").text(this.width + ' x ' + this.height + ' px');
            };
            img.src = e.target.result;

            $("#resimOnizleme").fadeIn();
          };
          reader.readAsDataURL(file);
        }
      });

      // Byte formatını okunabilir hale getir
      function formatBytes(bytes, decimals = 2) {
        if(bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
      }
    }
  });

  // Form Validasyonu - Boş Alanları Kırmızı İşaretle
  // Sadece ürün ekleme formunda çalışır
  $(function() {
    if($(".urunEklemeFormu").length > 0) {
      $(".urunEklemeFormu").on("submit", function(e) {
       var bosAlanVar = false;
       var bosAlanlar = []; // Boş alanların listesi

       // Tüm required alanları kontrol et (anahtar, description, metin hariç)
       // Summernote editörünün içindeki alanları da hariç tut
       $(".urunEklemeFormu input[type='text']:not([name='indirimlifiyat']):not([name='indirimlikurus']):not([name='kurus']):not([name='anahtar']):not([name='description']), .urunEklemeFormu input[type='number'], .urunEklemeFormu input[type='file'], .urunEklemeFormu select").each(function() {
         var $field = $(this);

         // Summernote editörünün içindeki input'ları atla
         if($field.closest('.note-editor').length > 0) {
           return true; // continue to next iteration
         }

         var fieldName = $field.attr('name') || 'bilinmeyen alan';
         var fieldLabel = $field.closest('.form-group').find('label').first().text() || fieldName;

         // Önceki hata stilini temizle
         $field.removeClass("is-invalid");
         $field.css({
           "border-color": "",
           "background-color": ""
         });
         $field.closest('.form-group').find('label').css({
           "color": "",
           "font-weight": ""
         });

         // Alan boş mu kontrol et
         if($field.val() === "" || $field.val() === null) {
           bosAlanVar = true;
           bosAlanlar.push('• ' + fieldLabel.replace(':', '').trim() + ' (' + fieldName + ')');

           // Alanı kırmızı işaretle
           $field.addClass("is-invalid");
           $field.css({
             "border-color": "#dc3545",
             "background-color": "#ffe6e6"
           });

           // Label'ı da kırmızı yap
           $field.closest('.form-group').find('label').css({
             "color": "#dc3545",
             "font-weight": "bold"
           });

           // Focus olduğunda kırmızı işareti kaldır
           $field.one("focus change", function() {
             $(this).removeClass("is-invalid");
             $(this).css({
               "border-color": "",
               "background-color": ""
             });
             $(this).closest('.form-group').find('label').css({
               "color": "",
               "font-weight": ""
             });
           });
         }
       });

       // Select2 alanları için özel kontrol (kategori) - KALDIRILDI
       // Kategori kontrolü PHP tarafında yapılıyor

       // Summernote (textarea) kontrolü - KALDIRILDI (metin artık opsiyonel)

       // Eğer boş alan varsa formu gönderme
       if(bosAlanVar) {
         e.preventDefault();

         // Boş alanların listesini hazırla
         var bosAlanlarHTML = '<div style="text-align: left; max-height: 300px; overflow-y: auto;"><strong>Boş Bırakılan Alanlar:</strong><br><br>' +
                             bosAlanlar.join('<br>') +
                             '</div>';

         // Detaylı uyarı mesajı göster
         Swal.fire({
           icon: "error",
           title: "Eksik Bilgi - " + bosAlanlar.length + " Alan Boş",
           html: bosAlanlarHTML,
           confirmButtonText: "Tamam, Dolduracağım",
           confirmButtonColor: "#dc3545",
           width: '600px',
           customClass: {
             htmlContainer: 'text-left'
           }
         });

         // İlk boş alana scroll yap
         setTimeout(function() {
           var $firstInvalid = $(".is-invalid:first, .note-editor:first");
           if($firstInvalid.length > 0) {
             $("html, body").animate({
               scrollTop: $firstInvalid.offset().top - 100
             }, 500);

             // İlk alana focus
             if($firstInvalid.is('input, select, textarea')) {
               $firstInvalid.focus();
             }
           }
         }, 500);

         // Console'a da yazdır
         console.log('Boş Alanlar:', bosAlanlar);

         return false;
       }
      });
    }
  });