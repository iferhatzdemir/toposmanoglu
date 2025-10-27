-- =====================================================
-- GALERİ SİSTEMİ İÇİN GEREKEN TÜM SQL KOMUTLARI
-- =====================================================

-- 1. ANA TABLO: resimler (Galeri için kullanılıyor)
-- Bu tablo tüm resimler için kullanılır (banner, ürün, galeri vs.)

CREATE TABLE IF NOT EXISTS `resimler` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `tablo` varchar(255) COLLATE utf8_turkish_ci NOT NULL COMMENT 'hangi modül: galeri, banner, urunler',
  `KID` int(11) NOT NULL COMMENT 'bağlı olduğu kaydın ID si, galeri için 1',
  `resim` varchar(255) COLLATE utf8_turkish_ci NOT NULL COMMENT 'dosya adı',
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'yükleme tarihi',
  PRIMARY KEY (`ID`),
  KEY `tablo_kid` (`tablo`, `KID`),
  KEY `tablo_index` (`tablo`),
  KEY `tarih_index` (`tarih`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- =====================================================
-- 2. MEVCUT RESMİ VERİTABANINA EKLEMEK İÇİN
-- (168d144407ce09.jpg dosyasını galeri tablosuna ekle)
-- =====================================================

INSERT INTO `resimler` (`tablo`, `KID`, `resim`, `tarih`) VALUES
('galeri', 1, '168d144407ce09.jpg', NOW());

-- =====================================================
-- 3. GALERİ RESİMLERİNİ KONTROL ETMEK İÇİN SORGULAR
-- =====================================================

-- Galeri resimlerini listele
SELECT * FROM `resimler` WHERE `tablo` = 'galeri' AND `KID` = '1' ORDER BY `ID` DESC;

-- Galeri resim sayısı
SELECT COUNT(*) as toplam_resim FROM `resimler` WHERE `tablo` = 'galeri' AND `KID` = '1';

-- Son eklenen galeri resimleri (son 10)
SELECT * FROM `resimler` WHERE `tablo` = 'galeri' AND `KID` = '1' ORDER BY `tarih` DESC LIMIT 10;

-- Belirli bir resmi ara
SELECT * FROM `resimler` WHERE `tablo` = 'galeri' AND `resim` = '168d144407ce09.jpg';

-- =====================================================
-- 4. KLASÖR YAPISINI KONTROL ETMEK İÇİN
-- =====================================================

-- Not: Bu klasörlerin var olduğundan emin olun:
-- C:\xampp\htdocs\topwebsite\images\resimler\  (yazma izni olmalı)
-- Klasör yoksa manuel oluşturun ve izinleri ayarlayın

-- =====================================================
-- 5. VERİTABANINDAKİ TÜM RESİMLERİ GÖRMEK İÇİN
-- =====================================================

-- Tüm modüllerdeki resimleri listele
SELECT
    `tablo` as 'Modül',
    `KID` as 'Bağlı ID',
    `resim` as 'Dosya Adı',
    `tarih` as 'Yükleme Tarihi'
FROM `resimler`
ORDER BY `tablo`, `KID`, `tarih` DESC;

-- Modül bazında resim sayıları
SELECT
    `tablo` as 'Modül',
    COUNT(*) as 'Resim Sayısı'
FROM `resimler`
GROUP BY `tablo`
ORDER BY COUNT(*) DESC;

-- =====================================================
-- 6. GALERİ SİSTEMİNİ TEMİZLEMEK İÇİN
-- =====================================================

-- Tüm galeri resimlerini sil (DİKKATLİ KULLAN!)
-- DELETE FROM `resimler` WHERE `tablo` = 'galeri' AND `KID` = '1';

-- Belirli bir galeri resmini sil
-- DELETE FROM `resimler` WHERE `tablo` = 'galeri' AND `KID` = '1' AND `resim` = 'dosya_adi.jpg';

-- =====================================================
-- 7. ÖRNEK VERİ EKLEME (Test için)
-- =====================================================

-- Test resimleri ekle
INSERT INTO `resimler` (`tablo`, `KID`, `resim`, `tarih`) VALUES
('galeri', 1, 'test-resim-1.jpg', '2024-01-15 10:30:00'),
('galeri', 1, 'test-resim-2.png', '2024-01-15 10:31:00'),
('galeri', 1, 'test-resim-3.jpg', '2024-01-15 10:32:00');

-- =====================================================
-- 8. PERFORMANS İYİLEŞTİRME
-- =====================================================

-- Galeri sorguları için optimized index
CREATE INDEX `idx_galeri` ON `resimler` (`tablo`, `KID`, `tarih`);

-- Genel resim arama için
CREATE INDEX `idx_resim_search` ON `resimler` (`resim`);

-- =====================================================
-- 9. VERİ BÜTÜNLÜĞÜ KONTROLÜ
-- =====================================================

-- Veritabanında kayıtlı ama dosyası olmayan resimleri bul
-- (Bu sorguyu çalıştırdıktan sonra manuel kontrol edin)
SELECT `ID`, `resim`, `tarih`
FROM `resimler`
WHERE `tablo` = 'galeri' AND `KID` = '1'
ORDER BY `tarih` DESC;

-- =====================================================
-- 10. YEDEKLEME VE GERI YÜKLEME
-- =====================================================

-- Sadece galeri resimlerini yedekle
-- mysqldump -u root -p top resimler --where="tablo='galeri'" > galeri_backup.sql

-- Galeri resimlerini geri yükle
-- mysql -u root -p top < galeri_backup.sql

-- =====================================================
-- KURULUM TALİMATI:
-- =====================================================
-- 1. Bu SQL dosyasını phpMyAdmin'e import edin
-- 2. images/resimler/ klasörünün yazma iznine sahip olduğundan emin olun
-- 3. Admin panelden galeri sayfasına gidin: /admin/galeri
-- 4. Dropzone ile resim yükleyin
-- 5. Kontrol sorguları ile test edin