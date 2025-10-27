<?php
if($_GET && !empty($_GET["sayfa"]))
{
	$sayfa=$_GET["sayfa"];
	if(file_exists(SAYFA.$sayfa.".php"))
	{
		switch ($sayfa) {
			case 'kurumsal':
			case 'sayfa':
				if(!empty($_GET["seflink"]))
				{
					$seflink=$VT->filter($_GET["seflink"]);
					$bilgi=$VT->VeriGetir("kurumsal","WHERE seflink=? AND durum=?",array($seflink,1),"ORDER BY ID ASC",1);
					if($bilgi!=false)
					{
						$sitebaslik=stripslashes($bilgi[0]["baslik"])." - ".$sitebaslik;
						$sitedescription=stripslashes($bilgi[0]["description"]);
						$siteanahtar=stripslashes($bilgi[0]["anahtar"]);
					}
				}
				break;

			case 'blog-detay':
				if(!empty($_GET["seflink"]))
				{
					$seflink=$VT->filter($_GET["seflink"]);
					$bilgi=$VT->VeriGetir("bloglar","WHERE seflink=? AND durum=?",array($seflink,1),"ORDER BY ID ASC",1);
					if($bilgi!=false)
					{
						$sitebaslik=stripslashes($bilgi[0]["baslik"])." - ".$sitebaslik;
						$sitedescription=stripslashes($bilgi[0]["description"]);
						$siteanahtar=stripslashes($bilgi[0]["anahtar"]);
					}
				}
				break;

			case 'gizlilik-politikasi':
				if(!empty($_GET["seflink"]))
				{
					$seflink=$VT->filter($_GET["seflink"]);
					$bilgi=$VT->VeriGetir("gizlilikpolitikasi","WHERE seflink=? AND durum=?",array($seflink,1),"ORDER BY ID ASC",1);
					if($bilgi!=false)
					{
						$sitebaslik=stripslashes($bilgi[0]["baslik"])." - ".$sitebaslik;
						$sitedescription=stripslashes($bilgi[0]["description"]);
						$siteanahtar=stripslashes($bilgi[0]["anahtar"]);
					}
				}
				break;

			case 'kategoriler':
			case 'kategori':
				if(!empty($_GET["seflink"]))
				{
					$seflink=$VT->filter($_GET["seflink"]);
					$bilgi=$VT->VeriGetir("kategoriler","WHERE seflink=? AND durum=?",array($seflink,1),"ORDER BY ID ASC",1);
					if($bilgi!=false)
					{
						$sitebaslik=stripslashes($bilgi[0]["baslik"])." - ".$sitebaslik;
						$sitedescription=stripslashes($bilgi[0]["description"]);
						$siteanahtar=stripslashes($bilgi[0]["anahtar"]);
					}
				}
				break;

			case 'urun-detay':
			case 'urun':
				if(!empty($_GET["seflink"]))
				{
					$seflink=$VT->filter($_GET["seflink"]);
					$bilgi=$VT->VeriGetir("urunler","WHERE seflink=? AND durum=?",array($seflink,1),"ORDER BY ID ASC",1);
					if($bilgi!=false)
					{
						$sitebaslik=stripslashes($bilgi[0]["baslik"])." - ".$sitebaslik;
						$sitedescription=stripslashes($bilgi[0]["description"]);
						$siteanahtar=stripslashes($bilgi[0]["anahtar"]);
					}
				}
				break;

			case "sepet":
				$sitebaslik="Sepetim - ".$sitebaslik;
				$sitedescription="Alisveris sepetinizi doldurun ve firsati yakalayin.";
				$siteanahtar="sepetim, e-ticaret sepeti, urun sepeti, ".$siteanahtar;
				break;

			case "bloglar":
			case "blog":
				$sitebaslik="Blog - ".$sitebaslik;
				$sitedescription="Aradiginiz her sey blogda!";
				$siteanahtar="blog, e-ticaret blog, ".$siteanahtar;
				break;

			case "uyelik":
			case "giris-yap":
			case "kayit-ol":
				$sitebaslik="Giris Yap / Uye Ol - ".$sitebaslik;
				$sitedescription="Hemen yeni bir hesap olusturun yada giris yapin.";
				$siteanahtar="uyelik, e-ticaret uyelik, giris yap, ".$siteanahtar;
				break;

			case "favorilerim":
				$sitebaslik="Favorilerim - ".$sitebaslik;
				$sitedescription="Favori listesinde yildiz urunlerinizi onerin.";
				$siteanahtar="favorilerim, e-ticaret favorilerim, ".$siteanahtar;
				break;

			case "hesabim":
				$sitebaslik="Hesabim - ".$sitebaslik;
				$sitedescription="Hesabinizi yonetmek icin hemen basla.";
				$siteanahtar="hesabim, uyelik, e-ticaret hesabim, giris yap, ".$siteanahtar;
				break;

			case "cikis":
			case "cikis-yap":
				$sitebaslik="Cikis - ".$sitebaslik;
				$sitedescription="Hesabinizdan guvenle cikis yapin.";
				$siteanahtar="hesabim, uyelik, e-ticaret hesabim, cikis yap, ".$siteanahtar;
				break;

			case "sifre-belirle":
			case "sifremi-unuttum":
				$sitebaslik="Sifre Belirle - ".$sitebaslik;
				$sitedescription="Hesabinizi guvene almak icin yeni bir sifre belirleyin.";
				$siteanahtar="hesabim, uyelik, e-ticaret hesabim, sifre belirle, sifre iste, ".$siteanahtar;
				break;

			case "odeme-tipi":
				$sitebaslik="Odeme Tipi - ".$sitebaslik;
				$sitedescription="Alisverisini tamamlamak icin odeme yontemi secin.";
				$siteanahtar="odeme yap, hesabim, odeme tipi, e-ticaret odeme ".$siteanahtar;
				break;

			case "odeme-yap":
			case "iyzico-odeme-yap":
				$sitebaslik="Odeme Yap - ".$sitebaslik;
				$sitedescription="Alisverisi tamamlamak icin odeme yapin!";
				$siteanahtar="odeme yap, hesabim, odeme tipi, e-ticaret odeme ".$siteanahtar;
				break;

			case "odeme-sonuc":
			case "kk-odeme-sonuc":
			case "kk-kayit":
				$sitebaslik="Odeme Sonucunuz - ".$sitebaslik;
				$sitedescription="Alisverisini tamamlandi. Odeme sonucunu ogrenin.";
				$siteanahtar="odeme yap, hesabim, odeme tipi, e-ticaret odeme, odeme sonucu ".$siteanahtar;
				break;

			case "siparislerim":
				$sitebaslik="Siparislerim - ".$sitebaslik;
				$sitedescription="Siparislerinizi takip etmek icin hemen siparis listeni ziyaret et.";
				$siteanahtar="hesabim, siparislerim, siparis listesi, alisveris, alisveris listesi ".$siteanahtar;
				break;

			case "siparis-detay":
				$sitebaslik="Siparis Detayim - ".$sitebaslik;
				$sitedescription="Siparislerinizi takip etmek icin hemen siparis listeni ziyaret et.";
				$siteanahtar="hesabim, siparislerim, siparis listesi, alisveris, alisveris listesi ".$siteanahtar;
				break;

			case "siparis-takip":
				$sitebaslik="Siparis Takibi - ".$sitebaslik;
				$sitedescription="Siparislerinizi takip etmek icin siparis kodunuz ile arama yapin.";
				$siteanahtar="hesabim, siparislerim, siparis listesi, alisveris, alisveris listesi, siparis takibi ".$siteanahtar;
				break;

			case "iadeler":
				$sitebaslik="Iadelerim - ".$sitebaslik;
				$sitedescription="Iadelerinizi takip etmek icin hemen iade listeni ziyaret et.";
				$siteanahtar="hesabim, Iadelerim, iade listesi, alisveris, alisveris listesi ".$siteanahtar;
				break;

			case "iade-detay":
				$sitebaslik="Iade Detayi - ".$sitebaslik;
				$sitedescription="Iadelerinizi takip etmek icin hemen iade listeni ziyaret et.";
				$siteanahtar="hesabim, Iadelerim, iade listesi, alisveris, alisveris listesi ".$siteanahtar;
				break;

			case "iletisim":
				$sitebaslik="Iletisim - ".$sitetelefon." - ".$sitebaslik;
				$sitedescription="Destek icin bizimle iletisime gecin. ".$sitetelefon." | ".$siteadres;
				$siteanahtar="iletisim, ".$sitetelefon.", ".$sitemail.", ".$siteadres.", alisveris listesi ".$siteanahtar;
				break;

			case "hesap-numaramiz":
			case "hesap-numaralari":
				$sitebaslik="Hesap Numaralarimiz - ".$sitebaslik;
				$sitedescription="Havale /EFT odemeleri icin hesap numaralarimizi inceleyebilirsiniz.";
				$siteanahtar="hesabim, hesap numaramiz, banka hesap numarasi ".$siteanahtar;
				break;

			case "arama":
				$sitebaslik="Arama Sonuclari - ".$sitebaslik;
				$sitedescription="E-Ticaret'de aradiginiz urune kolayca ulasin.";
				$siteanahtar="arama, eticarette arama, arama yap, arama motoru, ".$siteanahtar;
				break;

			default:
				/*N*/
				break;
		}
	}
}
?>
