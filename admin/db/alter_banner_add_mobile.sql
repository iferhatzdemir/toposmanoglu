-- Banner tablosuna mobil görsel alanı eklemek için kullanılabilir.
ALTER TABLE `banner`
  ADD COLUMN `resim_mobil` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL AFTER `resim`;

-- Var olan kayıtların mobil görseli boş ise masaüstü görsel ile doldur.
UPDATE `banner`
  SET `resim_mobil` = `resim`
  WHERE (`resim_mobil` IS NULL OR `resim_mobil` = '') AND `resim` IS NOT NULL;
