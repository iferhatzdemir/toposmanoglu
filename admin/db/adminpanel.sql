-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 14 Mar 2020, 11:47:45
-- Sunucu sürümü: 5.6.17
-- PHP Sürümü: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `adminpanel`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayarlar`
--

CREATE TABLE IF NOT EXISTS `ayarlar` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(160) COLLATE utf8_turkish_ci DEFAULT NULL,
  `anahtar` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `aciklama` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `telefon` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  `mail` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `adres` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `fax` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  `url` varchar(120) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `ayarlar`
--

INSERT INTO `ayarlar` (`ID`, `baslik`, `anahtar`, `aciklama`, `telefon`, `mail`, `adres`, `fax`, `url`) VALUES
(1, 'Yönetim Paneli Uygulaması', 'yönetim paneli, admin panel, php ile yönetim paneli', 'Php ile yönetim paneli eğitimleri - mehmet ulus', '58885899658', 'test@hotmail.com', 'mahalle cadde', '5454545554548', 'http://localhost/adminpanel/');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bloglar`
--

CREATE TABLE IF NOT EXISTS `bloglar` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `seflink` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `kategori` int(11) DEFAULT NULL,
  `metin` text COLLATE utf8_turkish_ci,
  `resim` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `anahtar` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `durum` int(5) DEFAULT NULL,
  `sirano` int(11) DEFAULT NULL,
  `tarih` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `hizmetler`
--

CREATE TABLE IF NOT EXISTS `hizmetler` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `seflink` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `kategori` int(11) DEFAULT NULL,
  `metin` text COLLATE utf8_turkish_ci,
  `resim` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `anahtar` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `durum` int(5) DEFAULT NULL,
  `sirano` int(11) DEFAULT NULL,
  `tarih` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `hizmetler`
--

INSERT INTO `hizmetler` (`ID`, `baslik`, `seflink`, `kategori`, `metin`, `resim`, `anahtar`, `description`, `durum`, `sirano`, `tarih`) VALUES
(1, 'Hizmet Adı', 'hizmet-adi', 3, '<p>Bu bir hizmet açıklamasıdır.</p>', '15e25ffbcc52dd.png', 'hizmet, bilgi', 'bu bir açıklamadır.', 1, 1, '2020-01-24');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

CREATE TABLE IF NOT EXISTS `kategoriler` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `seflink` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `tablo` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `anahtar` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `durum` int(5) DEFAULT NULL,
  `sirano` int(11) DEFAULT NULL,
  `tarih` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=6 ;

--
-- Tablo döküm verisi `kategoriler`
--

INSERT INTO `kategoriler` (`ID`, `baslik`, `seflink`, `tablo`, `anahtar`, `description`, `durum`, `sirano`, `tarih`) VALUES
(1, 'Kurumsal', 'kurumsal', 'modul', NULL, NULL, 1, NULL, '2020-01-04'),
(2, 'Ürünler', 'urunler', 'modul', NULL, NULL, 1, NULL, '2020-01-14'),
(3, 'Hizmetler', 'hizmetler', 'modul', NULL, NULL, 1, NULL, '2020-01-14'),
(4, 'Bloglar', 'bloglar', 'modul', NULL, NULL, 1, NULL, '2020-01-14'),
(5, 'Projeler', 'projeler', 'modul', NULL, NULL, 1, NULL, '2020-01-14');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE IF NOT EXISTS `kullanicilar` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `adsoyad` varchar(120) COLLATE utf8_turkish_ci DEFAULT NULL,
  `kullanici` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `sifre` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `mail` varchar(120) COLLATE utf8_turkish_ci DEFAULT NULL,
  `tarih` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`ID`, `adsoyad`, `kullanici`, `sifre`, `mail`, `tarih`) VALUES
(1, 'Mehmet ULUS', 'mehmet', '827ccb0eea8a706c4c34a16891f84e7b', 'test@hotmail.com', '2020-02-02');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kurumsal`
--

CREATE TABLE IF NOT EXISTS `kurumsal` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `seflink` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `kategori` int(11) DEFAULT NULL,
  `metin` text COLLATE utf8_turkish_ci,
  `resim` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `anahtar` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `durum` int(5) DEFAULT NULL,
  `sirano` int(11) DEFAULT NULL,
  `tarih` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `moduller`
--

CREATE TABLE IF NOT EXISTS `moduller` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `tablo` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `durum` int(5) DEFAULT NULL,
  `tarih` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=6 ;

--
-- Tablo döküm verisi `moduller`
--

INSERT INTO `moduller` (`ID`, `baslik`, `tablo`, `durum`, `tarih`) VALUES
(1, 'Kurumsal', 'kurumsal', 1, '2020-01-04'),
(2, 'Ürünler', 'urunler', 1, '2020-01-14'),
(3, 'Hizmetler', 'hizmetler', 1, '2020-01-14'),
(4, 'Bloglar', 'bloglar', 1, '2020-01-14'),
(5, 'Projeler', 'projeler', 1, '2020-01-14');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `projeler`
--

CREATE TABLE IF NOT EXISTS `projeler` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `seflink` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `kategori` int(11) DEFAULT NULL,
  `metin` text COLLATE utf8_turkish_ci,
  `resim` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `anahtar` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `durum` int(5) DEFAULT NULL,
  `sirano` int(11) DEFAULT NULL,
  `tarih` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE IF NOT EXISTS `urunler` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `baslik` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `seflink` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `kategori` int(11) DEFAULT NULL,
  `metin` text COLLATE utf8_turkish_ci,
  `resim` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `anahtar` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_turkish_ci DEFAULT NULL,
  `durum` int(5) DEFAULT NULL,
  `sirano` int(11) DEFAULT NULL,
  `tarih` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=3 ;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`ID`, `baslik`, `seflink`, `kategori`, `metin`, `resim`, `anahtar`, `description`, `durum`, `sirano`, `tarih`) VALUES
(1, 'Ürün Adı 1', 'urun-adi-1', 2, '<p>bu bir ürün açıklamasıdır</p>', NULL, 'urun', 'urun metni', 1, 1, '2020-01-20'),
(2, 'Ürün Adı 2', 'urun-adi-2', 2, '<p>dfsdfdsgs</p>', NULL, 'dfsfs', 'fdsfs', 1, 2, '2020-01-26');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ziyaretciler`
--

CREATE TABLE IF NOT EXISTS `ziyaretciler` (
  `ID` double NOT NULL AUTO_INCREMENT,
  `IP` varchar(20) COLLATE utf8_turkish_ci DEFAULT NULL,
  `tekil` int(11) DEFAULT NULL,
  `cogul` int(11) DEFAULT NULL,
  `tarayici` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  `xr` int(11) DEFAULT NULL,
  `tarih` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ziyarettarayici`
--

CREATE TABLE IF NOT EXISTS `ziyarettarayici` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `tarayici` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  `ziyaret` double NOT NULL,
  `hiz` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=6 ;

--
-- Tablo döküm verisi `ziyarettarayici`
--

INSERT INTO `ziyarettarayici` (`ID`, `tarayici`, `ziyaret`, `hiz`) VALUES
(1, 'chrome', 1, NULL),
(2, 'explorer', 1, NULL),
(3, 'firefox', 1, NULL),
(4, 'diger', 1, NULL),
(5, 'sayfahizi', 4, '2.86');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
