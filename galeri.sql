-- Tek galeri sistemi için SQL
-- Mevcut resimler tablosu kullanılacak, sadece tablo='galeri' ve KID='1' ile

-- Eğer resimler tablosu yoksa oluştur (genelde zaten var olmalı)
CREATE TABLE IF NOT EXISTS `resimler` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `tablo` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `KID` int(11) NOT NULL,
  `resim` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `tarih` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  KEY `tablo_kid` (`tablo`, `KID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

-- Galeri için images/resimler/ klasörünün varlığını kontrol et
-- Bu klasör manuel olarak oluşturulmalı ve yazma izni verilmeli

-- Galeri kullanımı:
-- - Tüm galeri resimleri resimler tablosunda tablo='galeri' ve KID='1' olarak saklanır
-- - Admin panelde /galeri sayfasından toplu resim yükleme yapılır
-- - Resimler images/resimler/ klasöründe saklanır
-- - Silme işlemi mevcut resim-sil sistemi ile yapılır

-- Test için örnek veri (isteğe bağlı)
-- INSERT INTO `resimler` (`tablo`, `KID`, `resim`, `tarih`) VALUES
-- ('galeri', 1, 'ornek-resim.jpg', NOW());