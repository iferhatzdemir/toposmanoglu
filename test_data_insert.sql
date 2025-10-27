-- Test verileri ekleme scripti
-- Önce yorumlar tablosunu temizle
DELETE FROM yorumlar WHERE ID > 1;

-- Yeni test verilerini ekle
INSERT INTO `yorumlar` (`ID`, `uyeID`, `urunID`, `puan`, `metin`, `durum`, `tarih`) VALUES
(2, 1, 6, 5, 'ANİTA DELUXE oturma grubu gerçekten çok kaliteli! Kumaş kalitesi ve işçilik mükemmel. Salonumuza çok yakıştı, misafirlerimiz çok beğeniyor. Satın aldığıma çok memnunum, kesinlikle tavsiye ederim.', 1, '2024-12-15'),
(3, 1, 7, 4, 'LUNA köşe takımı güzel ama rengi beklediğimden biraz farklıydı. Konfor açısından çok iyi, oturmak keyifli. Kargo biraz geç geldi ama genel olarak memnunum.', 1, '2024-12-14'),
(4, 1, 8, 5, 'Zümrüt masa sandalye takımı harika! Açılır masa çok pratik, misafir geldiğinde çok işe yarıyor. Sandalyeler rahat ve sağlam. Kurulum da kolaydı. Fiyatına göre çok kaliteli.', 1, '2024-12-13'),
(5, 1, 9, 4, 'Lal banklı masa takımı güzel tasarımlı. Altın detaylar çok şık duruyor. Bank çok kullanışlı, çocuklar çok seviyor. Sadece montaj biraz zor oldu ama sonuç mükemmel.', 1, '2024-12-12'),
(6, 1, 10, 5, 'Mada yatak odası takımı tam aradığımız gibiydi! Modern tasarım ve kaliteli malzeme. Dolap içi düzenlemesi çok iyi düşünülmüş. Eşim ve ben çok memnun kaldık.', 1, '2024-12-11'),
(7, 1, 21, 5, 'ASUS laptop performansı gerçekten iyi! Oyun oynayabiliyorum, iş için de mükemmel. SSD sayesinde çok hızlı açılıyor. Ekran kalitesi de güzel. Bu fiyata harika bir bilgisayar.', 1, '2024-12-10'),
(8, 1, 22, 4, 'LG televizyon görüntü kalitesi çok iyi, 4K netliği harika. Smart özellikler kullanışlı. Sadece uzaktan kumanda biraz karışık ama alışınca sorun yok. Genel olarak memnunum.', 1, '2024-12-09'),
(9, 1, 6, 3, 'Oturma grubu güzel ama renk solmaya başladı. 6 ay oldu aldığımızdan beri. Konfor iyi ama kalite beklediğim gibi değil. Fiyatı da pahalıydı açıkçası.', 0, '2024-12-08'),
(10, 1, 7, 5, 'LUNA köşe takımı salonumuzun tam ihtiyacıydı! Köşe kullanımı çok praktik, alan tasarrufu sağlıyor. Kumaş kalitesi de iyi, leke tutmuyor. Çocuklarla bile rahatça kullanabiliyoruz.', 1, '2024-12-07'),
(11, 1, 8, 4, 'Masa sandalye takımı güzel ama sandalyelerden biri biraz sallanıyor. Müşteri hizmetlerini aradım, çözüm bulacaklarını söylediler. Genel görünüm güzel, misafirlerin beğenisini topluyor.', 1, '2024-12-06'),
(12, 1, 21, 5, 'Laptop mükemmel! Üniversite için aldım, hem ders hem eğlence için harika. Pil ömrü uzun, taşıması kolay. GeForce ekran kartı sayesinde grafik işleri de yapabiliyorum. Çok memnunum.', 1, '2024-12-05'),
(13, 1, 22, 5, 'Televizyonun görüntü kalitesi inanılmaz! Netflix izlerken sinema keyfi yaşıyoruz. Ses kalitesi de çok iyi. 70 inç tam salona uygun boyut. Alışverişin en iyisiydi kesinlikle.', 1, '2024-12-04'),
(14, 1, 9, 2, 'Masa takımı güzel ama bank çok sert. Uzun süre oturmak zor. Ayrıca montaj talimatları çok karışıktı, profesyonel yardım almak zorunda kaldık. Fiyatına göre beklentimi karşılamadı.', 0, '2024-12-03'),
(15, 1, 10, 4, 'Yatak odası takımı modern ve şık. Dolap çok geniş, eşyalarımız rahatça sığıyor. Sadece yatak başlığı biraz sert ama genel olarak kaliteli. Montaj ekibi çok profesyoneldi.', 1, '2024-12-02'),
(16, 1, 6, 5, 'ANİTA DELUXE gerçekten deluxe! Kumaş çok yumuşak ve kaliteli. Berjerler de çok rahat. Misafirlerimiz sürekli takım hakkında soru soruyor. Fiyatı değer kesinlikle.', 1, '2024-12-01'),
(17, 1, 21, 3, 'Laptop genel olarak iyi ama fan sesi biraz yüksek. Oyun oynarken rahatsız edici oluyor. Performans yeterli ama bu fiyata daha sessiz olabilirdi. Servisi de yavaş.', 0, '2024-11-30'),
(18, 1, 22, 5, 'LG TV harika! Ailemizle birlikte film gecelerinin vazgeçilmezi oldu. Görüntü netliği ve renk kalitesi mükemmel. Smart özellikler çok kullanışlı, YouTube ve Netflix rahat izliyoruz.', 1, '2024-11-29'),
(19, 1, 7, 4, 'Köşe takımı oturma konforunu artırdı. L şeklinde oturma imkanı çok praktik. Kumaş kalitesi iyi, temizlemesi kolay. Sadece montaj biraz zaman aldı ama sonuç güzel oldu.', 1, '2024-11-28');

-- Önce testimonials tablosunu oluştur
CREATE TABLE IF NOT EXISTS `testimonials` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `uyeID` int(11) DEFAULT NULL,
  `ad_soyad` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `resim` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `yorum` text COLLATE utf8_turkish_ci DEFAULT NULL,
  `puan` int(1) DEFAULT 5,
  `google_link` varchar(500) COLLATE utf8_turkish_ci DEFAULT NULL,
  `durum` int(1) DEFAULT 0,
  `onay_durumu` enum('beklemede','onaylandi','reddedildi') COLLATE utf8_turkish_ci DEFAULT 'beklemede',
  `admin_notu` text COLLATE utf8_turkish_ci DEFAULT NULL,
  `sirano` int(11) DEFAULT NULL,
  `tarih` datetime DEFAULT NULL,
  `onay_tarihi` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1;

-- Testimonials tablosu için test verileri
DELETE FROM testimonials WHERE ID > 0;

INSERT INTO `testimonials` (`ID`, `uyeID`, `ad_soyad`, `resim`, `yorum`, `puan`, `google_link`, `durum`, `onay_durumu`, `admin_notu`, `sirano`, `tarih`, `onay_tarihi`) VALUES
(1, NULL, 'Mehmet Yılmaz', 'customer1.jpg', 'Özgıda Toposmanoğlu firmasından aldığımız doğal gıda ürünlerinden çok memnunuz. Özellikle organik zeytinyağları gerçekten kaliteli. Müşteri hizmetleri de çok ilgili, her türlü sorumuzu sabırla yanıtlıyorlar. Kesinlikle tavsiye ederim!', 5, 'https://google.com/reviews/xyz', 1, 'onaylandi', '', 1, '2024-12-15 10:30:00', '2024-12-15 11:00:00'),
(2, NULL, 'Ayşe Demir', 'customer2.jpg', 'Geçen hafta online sipariş verdim, ürünler çok taze geldi. Ambalajlama da özenli yapılmış. Fiyatlar da oldukça makul. Bu firmadan alışveriş yapmaya devam edeceğim. Ailem de çok beğendi ürünleri.', 5, 'https://google.com/reviews/abc', 1, 'onaylandi', '', 2, '2024-12-14 14:20:00', '2024-12-14 15:00:00'),
(3, NULL, 'Ali Kaya', 'customer3.jpg', 'Yıllardır doğal ürün arıyordum, sonunda güvenebileceğim bir firma buldum. Bal ve reçelleri harika! Kargo da çok hızlı geldi, hiç beklemediydim. Website de kullanışlı, kolay sipariş verebildim.', 4, 'https://google.com/reviews/def', 1, 'onaylandi', '', 3, '2024-12-13 09:15:00', '2024-12-13 10:00:00'),
(4, 1, 'Fatma Özkan', '', 'Arkadaşımın tavsiyesi üzerine denedim. Organik ürünlerin kalitesi gerçekten fark ediliyor. Çocuklarım için aldığım doğal meyve suları çok lezzetli. Sadece teslimat biraz geç geldi, onun dışında her şey mükemmel.', 4, '', 1, 'onaylandi', '', 4, '2024-12-16 16:45:00', '2024-12-16 17:30:00'),
(5, 1, 'Hasan Demir', '', 'İş yerimiz için toplu alışveriş yaptık. Hem kalite hem de fiyat açısından çok memnun kaldık. Özellikle kuruyemiş çeşitleri ve baharatlar çok kaliteli. Faturalandırma ve ödeme süreçleri de sorunsuzdu.', 5, '', 1, 'onaylandi', '', 5, '2024-12-16 18:20:00', '2024-12-16 19:00:00'),
(6, NULL, 'Zeynep Arslan', '', 'Doğal gıda konusunda gerçekten uzmanlar. Aldığım zeytinyağının tadı harika! Üretim yerini de gördüm, çok temiz ve hijyenik çalışıyorlar. Güven veren bir firma. Herkese tavsiye ederim.', 5, '', 1, 'onaylandi', '', 6, '2024-12-17 13:15:00', '2024-12-17 14:00:00'),
(7, NULL, 'Osman Kılıç', '', 'Online mağazaları çok kullanışlı. Ürün açıklamaları detaylı, fotoğraflar gerçeği yansıtıyor. Sipariş takibi de çok iyi. Ürünler tam zamanında geldi ve kalitesi mükemmeldi.', 4, '', 1, 'onaylandi', '', 7, '2024-12-18 08:45:00', '2024-12-18 09:30:00'),
(8, NULL, 'Elif Özdemir', '', 'Organik beslenmeye geçmeye karar verdiğimde bu firmayı buldum. Ürün çeşitliliği çok geniş. Özellikle tahıllar ve baklagiller çok taze. Müşteri danışmanları da ürünler hakkında çok bilgili.', 5, '', 0, 'beklemede', '', 8, '2024-12-19 11:30:00', NULL),
(9, NULL, 'Murat Şahin', '', 'Köyden geliyorum, doğal ürünlerin nasıl olması gerektiğini bilirim. Bu firmanın ürünleri gerçekten köy ürünleri kalitesinde. Özellikle tereyağı ve peynirler çok lezzetli. Tebrik ederim!', 5, '', 1, 'onaylandi', '', 9, '2024-12-20 10:00:00', '2024-12-20 11:15:00'),
(10, NULL, 'Sibel Aydın', '', 'İlk siparişimdi, biraz tedirgindiydim ama gerçekten memnun kaldım. Ürünlerin hepsi doğal ve katkısız. Çocuğum alerjik olduğu için çok dikkat ediyorum, burada güvenle alışveriş yapabiliyorum.', 4, '', 0, 'beklemede', '', 10, '2024-12-21 14:20:00', NULL),
(11, NULL, 'Gül Yıldız', '', 'Hamilelik dönemimde doktor doğal beslenme önerdi. Bu firmanın ürünlerini kullandım, hem bebek hem ben çok sağlıklıydık. Şimdi de çocuğum için devam ediyorum. Güvenilir bir marka.', 5, '', 1, 'onaylandi', '', 11, '2024-12-22 15:30:00', '2024-12-22 16:00:00'),
(12, NULL, 'İsmail Çelik', '', 'Restoranımız için doğal ürün tedarikçisi arıyorduk. Özgıda Toposmanoğlu ile çalışmaya başladık, gerçekten kaliteli hizmet veriyorlar. Düzenli teslimatları var, ürünlerin tazeliği sürekli aynı seviyede.', 5, '', 1, 'onaylandi', '', 12, '2024-12-23 09:45:00', '2024-12-23 10:30:00');

-- AUTO_INCREMENT değerlerini güncelle
ALTER TABLE yorumlar AUTO_INCREMENT = 20;
ALTER TABLE testimonials AUTO_INCREMENT = 13;