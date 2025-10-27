function sepeteEkle(SITE,urunID)
{
	var adet=$(".adet").val();
	$.ajax({
     method:"POST",
     url:SITE+"ajax.php",
     data:$("form#urunbilgisi").serialize()+"&urunID="+urunID+"&islemtipi=sepeteEkle",
     success: function(sonuc)
     {
       if(sonuc=="TAMAM")
       {
       	/*Sepete eklendi.*/
       	swal("Sepete Eklendi.", "Ürün sepetinize eklendi.", "success");
       }
       else if(sonuc=="STOK")
       {
		   	swal("Stokta Bulunmuyor.", "Bu ürün stokda bulunmuyor.", "warning");
       }
       else
       {
		   swal("İşlem Geçersiz!", "İşleminiz şuan geçersizdir. Lütfen daha sonra tekrar deneyiniz.", "warning");
       }
     }
   });
}

function sifreIste(SITE) {
  var mailadresi=$(".sifremail").val();
  $.ajax({
     method:"POST",
     url:SITE+"ajax.php",
     data:{"mailadresi":mailadresi,"islemtipi":"sifreIste"},
     success: function(sonuc)
     {
       if(sonuc=="TAMAM")
       {
        window.location.href = SITE+"sifre-belirle/dogulama";
       }
       else
       {
         swal("İşlem Geçersiz!", "İşleminiz şuan geçersizdir. Lütfen daha sonra tekrar deneyiniz.", "warning");
       }
     }
   });
}

function favoriyeEkle(SITE,urunID,key)
{
   $.ajax({
     method:"POST",
     url:SITE+"ajax.php",
     data:{"urunID":urunID,"urunKey":key,"islemtipi":"favoriyeEkle"},
     success: function(sonuc)
     {
       if(sonuc=="TAMAM")
       {
		   	swal("Favoriye Eklendi.", "Ürün favori listenize eklendi.", "success");
       }
       else if(sonuc=="VAR")
       {
		   swal("Favorinizde Var!", "Bu ürün zaten favorinizde!", "info");
       }
       else if(sonuc=="GUVENLIK")
       {
		   swal("Güvenlik İhlali!", "Güvenlik ihlali tespit edildi.", "error");
       }
       else
       {
		   swal("İşlem Geçersiz!", "İşleminiz şuan geçersizdir. Üyelik girişi yapınız.", "warning");
       }
     }
   });
}