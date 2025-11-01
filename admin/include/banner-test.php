<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center mb-3">
                <div class="col-sm-12">
                    <h1 class="m-0" style="color: #9f1239; border-left: 4px solid #f43f5e; padding-left: 15px;">
                        <i class="fas fa-bug mr-2"></i>Banner Test & Debug Sayfası
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
<?php
// Banner Test & Debug Sayfası
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

// 1. Veritabanı Bağlantısı Kontrolü
echo "<h3>1. Veritabanı Bağlantı Testi</h3>";
try {
    if(isset($VT)) {
        echo "<span style='color: green;'>✓ VT objesi mevcut</span><br>";
    } else {
        echo "<span style='color: red;'>✗ VT objesi bulunamadı!</span><br>";
    }
} catch(Exception $e) {
    echo "<span style='color: red;'>✗ Hata: " . $e->getMessage() . "</span><br>";
}

// 2. Banner Tablosu Yapısı
echo "<h3>2. Banner Tablosu Yapısı</h3>";
try {
    $tableCheck = $VT->SorguCalistir("DESCRIBE banner", "", array());
    if($tableCheck) {
        echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        foreach($tableCheck as $column) {
            echo "<tr>";
            echo "<td>" . $column['Field'] . "</td>";
            echo "<td>" . $column['Type'] . "</td>";
            echo "<td>" . $column['Null'] . "</td>";
            echo "<td>" . $column['Key'] . "</td>";
            echo "<td>" . ($column['Default'] ?? 'NULL') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} catch(Exception $e) {
    echo "<span style='color: red;'>✗ Hata: " . $e->getMessage() . "</span><br>";
}

// 3. Mevcut Bannerlar
echo "<h3>3. Mevcut Bannerlar</h3>";
try {
    $banners = $VT->VeriGetir("banner", "", array(), "ORDER BY ID DESC LIMIT 5");
    if($banners && count($banners) > 0) {
        echo "<span style='color: green;'>✓ " . count($banners) . " banner bulundu (son 5)</span><br><br>";
        echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Başlık</th><th>Media Type</th><th>Resim</th><th>Video URL</th><th>Durum</th></tr>";
        foreach($banners as $banner) {
            echo "<tr>";
            echo "<td>" . $banner['ID'] . "</td>";
            echo "<td>" . $banner['baslik'] . "</td>";
            echo "<td>" . ($banner['media_type'] ?? 'N/A') . "</td>";
            echo "<td>" . ($banner['resim'] ?? 'N/A') . "</td>";
            echo "<td>" . ($banner['video_url'] ?? 'N/A') . "</td>";
            echo "<td>" . $banner['durum'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<span style='color: orange;'>⚠ Hiç banner bulunamadı</span><br>";
    }
} catch(Exception $e) {
    echo "<span style='color: red;'>✗ Hata: " . $e->getMessage() . "</span><br>";
}

// 4. Upload Dizini Kontrolü
echo "<h3>4. Upload Dizini Kontrolü</h3>";
$uploadDir = "../images/banner/";
if(is_dir($uploadDir)) {
    echo "<span style='color: green;'>✓ Dizin mevcut: " . realpath($uploadDir) . "</span><br>";

    if(is_writable($uploadDir)) {
        echo "<span style='color: green;'>✓ Dizin yazılabilir</span><br>";
    } else {
        echo "<span style='color: red;'>✗ Dizin yazılabilir değil!</span><br>";
    }

    // Dizindeki dosyaları listele
    $files = scandir($uploadDir);
    $imageFiles = array_filter($files, function($file) use ($uploadDir) {
        return is_file($uploadDir . $file) && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
    });
    echo "<span style='color: blue;'>ℹ Dizinde " . count($imageFiles) . " resim dosyası var</span><br>";
} else {
    echo "<span style='color: red;'>✗ Dizin bulunamadı: " . $uploadDir . "</span><br>";
}

// 5. PHP Ayarları
echo "<h3>5. PHP Ayarları</h3>";
echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
echo "<tr><th>Ayar</th><th>Değer</th></tr>";
echo "<tr><td>upload_max_filesize</td><td>" . ini_get('upload_max_filesize') . "</td></tr>";
echo "<tr><td>post_max_size</td><td>" . ini_get('post_max_size') . "</td></tr>";
echo "<tr><td>max_execution_time</td><td>" . ini_get('max_execution_time') . " saniye</td></tr>";
echo "<tr><td>memory_limit</td><td>" . ini_get('memory_limit') . "</td></tr>";
echo "<tr><td>file_uploads</td><td>" . (ini_get('file_uploads') ? 'Enabled' : 'Disabled') . "</td></tr>";
echo "</table>";

// 6. POST ve FILES Test Formu
echo "<h3>6. Test Formu</h3>";
?>

<div style="background: #f0f0f0; padding: 20px; border-radius: 8px; margin: 20px 0;">
    <h4>Banner Ekle Test Formu</h4>
    <form action="" method="post" enctype="multipart/form-data">
        <div style="margin: 10px 0;">
            <label><strong>Banner Tipi:</strong></label><br>
            <input type="radio" name="media_type" value="image" id="type_image" checked>
            <label for="type_image">Resim</label>

            <input type="radio" name="media_type" value="video" id="type_video">
            <label for="type_video">Video</label>
        </div>

        <div id="imageFields">
            <div style="margin: 10px 0;">
                <label><strong>Desktop Resim:</strong></label><br>
                <input type="file" name="resim" accept="image/*">
            </div>

            <div style="margin: 10px 0;">
                <label><strong>Mobil Resim (Opsiyonel):</strong></label><br>
                <input type="file" name="resim_mobil" accept="image/*">
            </div>
        </div>

        <div id="videoFields" style="display: none;">
            <div style="margin: 10px 0;">
                <label><strong>Video URL:</strong></label><br>
                <input type="text" name="video_url" placeholder="assets/video/banner.mp4" style="width: 400px;">
            </div>

            <div style="margin: 10px 0;">
                <label><strong>Video Poster (Opsiyonel):</strong></label><br>
                <input type="file" name="video_poster" accept="image/*">
            </div>
        </div>

        <div style="margin: 10px 0;">
            <label><strong>Başlık (Opsiyonel):</strong></label><br>
            <input type="text" name="baslik" placeholder="Banner Başlığı" style="width: 400px;">
        </div>

        <div style="margin: 10px 0;">
            <label><strong>Açıklama (Opsiyonel):</strong></label><br>
            <textarea name="aciklama" rows="3" style="width: 400px;" placeholder="Banner açıklaması"></textarea>
        </div>

        <div style="margin: 10px 0;">
            <label><strong>Buton Metni (Opsiyonel):</strong></label><br>
            <input type="text" name="butontext" placeholder="Alışverişe Başla" style="width: 400px;">
        </div>

        <div style="margin: 10px 0;">
            <label><strong>Link (Opsiyonel):</strong></label><br>
            <input type="text" name="url" placeholder="https://example.com" style="width: 400px;">
        </div>

        <div style="margin: 10px 0;">
            <label><strong>Sıra No:</strong></label><br>
            <input type="number" name="sirano" value="1" min="1" style="width: 100px;">
        </div>

        <div style="margin: 20px 0;">
            <button type="submit" name="test_submit" style="padding: 10px 30px; background: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;">
                <strong>Test Banner Ekle</strong>
            </button>
        </div>
    </form>
</div>

<script>
document.querySelectorAll('input[name="media_type"]').forEach(radio => {
    radio.addEventListener('change', function() {
        if(this.value === 'video') {
            document.getElementById('imageFields').style.display = 'none';
            document.getElementById('videoFields').style.display = 'block';
        } else {
            document.getElementById('videoFields').style.display = 'none';
            document.getElementById('imageFields').style.display = 'block';
        }
    });
});
</script>

<?php

// 7. Form Submit İşlemi
if(isset($_POST['test_submit'])) {
    echo "<h3>7. Form Submit Sonucu</h3>";
    echo "<div style='background: #fff3cd; padding: 20px; border-radius: 8px; border-left: 4px solid #ffc107;'>";

    echo "<h4>POST Verileri:</h4>";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    echo "<h4>FILES Verileri:</h4>";
    echo "<pre>";
    print_r($_FILES);
    echo "</pre>";

    try {
        $media_type = !empty($_POST["media_type"]) ? $_POST["media_type"] : "image";
        $baslik = !empty($_POST["baslik"]) ? $_POST["baslik"] : "";
        $aciklama = !empty($_POST["aciklama"]) ? $_POST["aciklama"] : "";
        $butontext = !empty($_POST["butontext"]) ? $_POST["butontext"] : "";
        $url = !empty($_POST["url"]) ? $_POST["url"] : "";
        $sirano = !empty($_POST["sirano"]) ? $_POST["sirano"] : 1;

        echo "<h4>İşlem Adımları:</h4>";

        if($media_type == "video") {
            echo "<p>✓ Video modu seçildi</p>";

            $video_url = !empty($_POST["video_url"]) ? $_POST["video_url"] : "";
            echo "<p>Video URL: " . ($video_url ? $video_url : "BOŞ") . "</p>";

            $video_poster = "";
            if(!empty($_FILES["video_poster"]["name"])) {
                echo "<p>✓ Video poster dosyası seçildi: " . $_FILES["video_poster"]["name"] . "</p>";
                echo "<p>Dosya boyutu: " . $_FILES["video_poster"]["size"] . " bytes</p>";
                echo "<p>Dosya tipi: " . $_FILES["video_poster"]["type"] . "</p>";

                if(method_exists($VT, 'upload')) {
                    $video_poster = $VT->upload("video_poster","../images/banner/");
                    if($video_poster !== false) {
                        echo "<p style='color: green;'>✓ Poster yüklendi: " . $video_poster . "</p>";
                    } else {
                        echo "<p style='color: red;'>✗ Poster yüklenemedi!</p>";
                    }
                } else {
                    echo "<p style='color: red;'>✗ VT->upload metodu bulunamadı!</p>";
                }
            } else {
                echo "<p>⚠ Poster dosyası seçilmedi</p>";
            }

            if(!empty($video_url)) {
                echo "<p>✓ Video URL mevcut, veritabanına ekleniyor...</p>";

                $ekle = $VT->SorguCalistir("INSERT INTO banner",
                    "SET baslik=?, aciklama=?, butontext=?, url=?, media_type=?, video_url=?, video_poster=?, durum=?, sirano=?, tarih=?",
                    array($baslik, $aciklama, $butontext, $url, "video", $video_url, $video_poster, 1, $sirano, date("Y-m-d")));

                if($ekle !== false) {
                    echo "<p style='color: green; font-weight: bold;'>✓✓✓ VIDEO BANNER BAŞARIYLA EKLENDİ! ✓✓✓</p>";
                } else {
                    echo "<p style='color: red; font-weight: bold;'>✗✗✗ VERITABANINA EKLENEMEDI! ✗✗✗</p>";
                }
            } else {
                echo "<p style='color: red;'>✗ Video URL girilmedi!</p>";
            }

        } else {
            echo "<p>✓ Resim modu seçildi</p>";

            if(!empty($_FILES["resim"]["name"])) {
                echo "<p>✓ Desktop resim seçildi: " . $_FILES["resim"]["name"] . "</p>";
                echo "<p>Dosya boyutu: " . $_FILES["resim"]["size"] . " bytes</p>";
                echo "<p>Dosya tipi: " . $_FILES["resim"]["type"] . "</p>";
                echo "<p>Geçici dosya: " . $_FILES["resim"]["tmp_name"] . "</p>";
                echo "<p>Hata kodu: " . $_FILES["resim"]["error"] . "</p>";

                if($_FILES["resim"]["error"] === 0) {
                    echo "<p style='color: green;'>✓ Dosya hatası yok</p>";

                    if(method_exists($VT, 'upload')) {
                        $yukle = $VT->upload("resim","../images/banner/");

                        if($yukle !== false && is_string($yukle)) {
                            echo "<p style='color: green;'>✓ Desktop resim yüklendi: " . $yukle . "</p>";

                            $mobilYukle = "";
                            if(!empty($_FILES["resim_mobil"]["name"])) {
                                echo "<p>✓ Mobil resim seçildi: " . $_FILES["resim_mobil"]["name"] . "</p>";
                                $mobilYukle = $VT->upload("resim_mobil","../images/banner/");
                                if($mobilYukle !== false) {
                                    echo "<p style='color: green;'>✓ Mobil resim yüklendi: " . $mobilYukle . "</p>";
                                }
                            } else {
                                echo "<p>⚠ Mobil resim seçilmedi (opsiyonel)</p>";
                            }

                            echo "<p>✓ Veritabanına ekleniyor...</p>";

                            $ekle = $VT->SorguCalistir("INSERT INTO banner",
                                "SET baslik=?, aciklama=?, butontext=?, url=?, resim=?, resim_mobil=?, media_type=?, durum=?, sirano=?, tarih=?",
                                array($baslik, $aciklama, $butontext, $url, $yukle, $mobilYukle, "image", 1, $sirano, date("Y-m-d")));

                            if($ekle !== false) {
                                echo "<p style='color: green; font-weight: bold;'>✓✓✓ RESİM BANNER BAŞARIYLA EKLENDİ! ✓✓✓</p>";
                                echo "<p>Eklenen ID: " . $ekle . "</p>";
                            } else {
                                echo "<p style='color: red; font-weight: bold;'>✗✗✗ VERITABANINA EKLENEMEDI! ✗✗✗</p>";
                            }

                        } else {
                            echo "<p style='color: red;'>✗ Resim yüklenemedi! Upload sonucu: " . var_export($yukle, true) . "</p>";
                        }
                    } else {
                        echo "<p style='color: red;'>✗ VT->upload metodu bulunamadı!</p>";
                    }
                } else {
                    echo "<p style='color: red;'>✗ Dosya yükleme hatası: " . $_FILES["resim"]["error"] . "</p>";

                    $uploadErrors = array(
                        UPLOAD_ERR_INI_SIZE => 'Dosya php.ini\'deki upload_max_filesize değerini aşıyor',
                        UPLOAD_ERR_FORM_SIZE => 'Dosya HTML formundaki MAX_FILE_SIZE değerini aşıyor',
                        UPLOAD_ERR_PARTIAL => 'Dosya kısmen yüklendi',
                        UPLOAD_ERR_NO_FILE => 'Dosya yüklenmedi',
                        UPLOAD_ERR_NO_TMP_DIR => 'Geçici klasör eksik',
                        UPLOAD_ERR_CANT_WRITE => 'Diske yazılamadı',
                        UPLOAD_ERR_EXTENSION => 'PHP uzantısı dosya yüklemeyi durdurdu'
                    );

                    if(isset($uploadErrors[$_FILES["resim"]["error"]])) {
                        echo "<p style='color: red;'>Hata açıklaması: " . $uploadErrors[$_FILES["resim"]["error"]] . "</p>";
                    }
                }

            } else {
                echo "<p style='color: red;'>✗ Desktop resim seçilmedi!</p>";
            }
        }

    } catch(Exception $e) {
        echo "<p style='color: red; font-weight: bold;'>HATA: " . $e->getMessage() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }

    echo "</div>";
}

?>
        </div>
    </section>
</div>

<style>
.card {
    border: none;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}
.card-header {
    background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%);
    border-bottom: 2px solid #fecdd3;
    color: #9f1239;
    font-weight: 600;
    padding: 15px 20px;
}
table {
    width: 100%;
    background: white;
    border-radius: 8px;
    overflow: hidden;
}
table th {
    background: #f43f5e;
    color: white;
    padding: 10px;
    text-align: left;
}
table td {
    padding: 8px 10px;
    border-bottom: 1px solid #f0f0f0;
}
</style>
