<?php
@session_start();
@ob_start();
define("DATA","data/");
define("SAYFA","include/");
define("SINIF","admin/class/");
include_once(DATA."baglanti.php");
define("SITE",$siteurl);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Slider Test</title>
    <link rel="stylesheet" href="<?=SITE?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=SITE?>assets/css/layerslider.min.css">
    <link rel="stylesheet" href="<?=SITE?>assets/css/style.css">
    <style>
        body { margin: 0; padding: 0; }
        .hero-layout7 { min-height: 600px; }
    </style>
</head>
<body>
    <h1 style="padding: 20px; background: #f0f0f0;">Hero Slider Test</h1>

    <?php
    // Test: Banner verilerini kontrol et
    $banner=$VT->VeriGetir("banner","WHERE durum=?",array(1),"ORDER BY sirano ASC");
    echo "<div style='padding: 20px; background: #fff; border: 2px solid #333; margin: 20px;'>";
    echo "<h2>Banner Veritabanı Kontrolü:</h2>";
    if($banner!=false) {
        echo "<p style='color: green;'>✓ Banner verileri bulundu: " . count($banner) . " adet</p>";
        for($i=0; $i<count($banner); $i++) {
            echo "<p>Banner " . ($i+1) . ": " . stripslashes($banner[$i]["baslik"]) . "</p>";
            echo "<p>Resim: images/banner/" . $banner[$i]["resim"] . "</p>";
            echo "<img src='<?=SITE?>images/banner/".$banner[$i]["resim"]."' style='max-width: 200px; border: 1px solid #ccc;'><br><br>";
        }
    } else {
        echo "<p style='color: red;'>✗ Banner verisi bulunamadı!</p>";
    }
    echo "</div>";

    // Hero bölümünü yükle
    echo "<h2 style='padding: 20px;'>Hero Section:</h2>";
    include_once(SAYFA."home.php");
    ?>

    <script src="<?=SITE?>assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="<?=SITE?>assets/js/layerslider.utils.js"></script>
    <script src="<?=SITE?>assets/js/layerslider.transitions.js"></script>
    <script src="<?=SITE?>assets/js/layerslider.kreaturamedia.jquery.js"></script>
    <script>
        console.log("LayerSlider JS loaded");
        jQuery(document).ready(function($) {
            console.log("jQuery ready");
            if (typeof $.fn.layerSlider !== 'undefined') {
                console.log("LayerSlider initialized");
            } else {
                console.error("LayerSlider NOT initialized!");
            }
        });
    </script>
</body>
</html>
