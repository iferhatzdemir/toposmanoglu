<?php
@session_start();
@ob_start();
define("DATA","data/");
define("SAYFA","include/");
define("SINIF","admin/class/");
include_once(DATA."baglanti.php");
define("SITE",$siteurl);
include_once(SAYFA."seo.php");

if (!function_exists('ozgida_generate_intro_video_sources')) {
    function ozgida_generate_intro_video_sources($url)
    {
        $result = [
            'embed' => '',
            'autoplay' => '',
        ];

        $url = trim((string) $url);
        if ($url === '') {
            return $result;
        }

        $parsedUrl = parse_url($url);
        if ($parsedUrl === false) {
            $result['embed'] = $url;
            $result['autoplay'] = $url;
            return $result;
        }

        $host = strtolower($parsedUrl['host'] ?? '');
        $path = $parsedUrl['path'] ?? '';
        $queryParams = [];

        if (!empty($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
        }

        $videoId = '';

        if (strpos($host, 'youtu.be') !== false) {
            $videoId = trim($path, '/');
        } elseif (strpos($host, 'youtube.com') !== false || strpos($host, 'youtube-nocookie.com') !== false) {
            if (strpos($path, '/embed/') === 0) {
                $videoId = trim(substr($path, strlen('/embed/')), '/');
            } elseif (!empty($queryParams['v'])) {
                $videoId = $queryParams['v'];
            }
        }

        $startTime = '';

        if (!empty($queryParams['start'])) {
            $startTime = preg_replace('/[^0-9]/', '', $queryParams['start']);
        } elseif (!empty($queryParams['t'])) {
            $timeString = $queryParams['t'];
            $timeTotal = 0;

            if (preg_match('/(\d+)h/', $timeString, $matches)) {
                $timeTotal += (int) $matches[1] * 3600;
            }

            if (preg_match('/(\d+)m/', $timeString, $matches)) {
                $timeTotal += (int) $matches[1] * 60;
            }

            if (preg_match('/(\d+)s/', $timeString, $matches)) {
                $timeTotal += (int) $matches[1];
            }

            if ($timeTotal > 0) {
                $startTime = (string) $timeTotal;
            } else {
                $startTime = preg_replace('/[^0-9]/', '', $timeString);
            }
        }

        if ($videoId === '') {
            $result['embed'] = $url;
            $result['autoplay'] = $url;
            return $result;
        }

        $embedBase = 'https://www.youtube.com/embed/' . $videoId;

        $result['embed'] = $embedBase;
        if ($startTime !== '') {
            $result['embed'] .= '?start=' . $startTime;
        }

        $autoplayParams = [
            'autoplay' => '1',
            'mute' => '1',
            'rel' => '0',
            'showinfo' => '0',
        ];

        if ($startTime !== '') {
            $autoplayParams['start'] = $startTime;
        }

        $result['autoplay'] = $embedBase . '?' . http_build_query($autoplayParams);

        return $result;
    }
}

$introVideoUrl = isset($introVideoUrl) && $introVideoUrl ? $introVideoUrl : 'https://www.youtube.com/watch?v=_sI_Ps7JSEk';
$introVideoSources = ozgida_generate_intro_video_sources($introVideoUrl);
$introVideoEmbedUrl = $introVideoSources['embed'] !== '' ? $introVideoSources['embed'] : $introVideoUrl;
$introVideoEmbedAutoplay = $introVideoSources['autoplay'] !== '' ? $introVideoSources['autoplay'] : $introVideoEmbedUrl;
?>
<!doctype html>
<html class="no-js" lang="zxx" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?=$sitebaslik?></title>
    <meta name="author" content="<?=$sitebaslik?>">
    <meta name="description" content="<?=$sitedescription?>">
    <meta name="keywords" content="<?=$siteanahtar?>" />
    <meta name="robots" content="INDEX,FOLLOW">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--==============================
	   Google Web Fonts
	============================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:wght@200;300;400;500;600;700&family=Amatic+SC:wght@400;700&family=Lato:wght@400;700&display=swap" rel="stylesheet">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?=SITE?>assets/img/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=SITE?>assets/img/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=SITE?>assets/img/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=SITE?>assets/img/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=SITE?>assets/img/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=SITE?>assets/img/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=SITE?>assets/img/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=SITE?>assets/img/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=SITE?>assets/img/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?=SITE?>assets/img/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=SITE?>assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?=SITE?>assets/img/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=SITE?>assets/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?=SITE?>assets/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?=SITE?>assets/img/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!--==============================
	    All CSS File
	============================== -->
    <!-- OLD THEME CSS (for header/footer compatibility) -->
    <link rel="stylesheet" href="<?=SITE?>css/bootstrap.custom.min.css">
    <link rel="stylesheet" href="<?=SITE?>css/style.css">
    <link rel="stylesheet" href="<?=SITE?>css/home_1.css">
    <link rel="stylesheet" href="<?=SITE?>css/testimonials-enhancement.css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?=SITE?>assets/css/bootstrap.min.css">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="<?=SITE?>assets/css/fontawesome.min.css">
    <!-- Flaticon -->
    <link rel="stylesheet" href="<?=SITE?>assets/css/flaticon.min.css">
    <!-- Layerslider -->
    <link rel="stylesheet" href="<?=SITE?>assets/css/layerslider.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="<?=SITE?>assets/css/magnific-popup.min.css">
    <!-- Slick Slider -->
    <link rel="stylesheet" href="<?=SITE?>assets/css/slick.min.css">
    <!-- Animation CSS -->
    <link rel="stylesheet" href="<?=SITE?>assets/css/animate.min.css">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="<?=SITE?>assets/css/style.css">
    <!-- THEME INTEGRATION FIXES -->
    <link rel="stylesheet" href="<?=SITE?>css/theme-fixes.css">

</head>

<body class="home-6">

    <!--[if lte IE 9]>
    	<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  	<![endif]-->

    <!--********************************
   		Code Start From Here
	******************************** -->

    <!--==============================
     Preloader
  	==============================-->
    <div class="preloader  ">
        <button class="vs-btn preloaderCls">Yüklemeyi İptal Et</button>
        <div class="preloader-inner">
            <div class="loader-logo">
                <img src="<?=SITE?>assets/img/logo.png" alt="<?=$sitebaslik?>" style="max-width: 200px; height: auto;">
            </div>
            <div class="loader-wrap pt-4">
                <span class="loader"></span>
            </div>
        </div>
    </div>

	<?php
	// Header dahil et
	include_once(DATA."ust.php");

	// Sayfa yönlendirmesi
	if($_GET && !empty($_GET["sayfa"]))
	{
		$sayfa=$_GET["sayfa"].".php";
		if(file_exists(SAYFA.$sayfa))
		{
			include_once(SAYFA.$sayfa);
		}
		else
		{
			include_once(SAYFA."home.php");
		}
	}
	else
	{
		include_once(SAYFA."home.php");
	}

	// Footer dahil et
	include_once(DATA."footer.php");
	?>

    <!--********************************
			Code End  Here
	******************************** -->

    <!-- Scroll To Top -->
    <a href="#" class="scrollToTop scroll-btn"><i class="far fa-arrow-up"></i></a>

    <!--==============================
        Intro Video Modal
    ============================== -->
    <div id="introVideoModal" class="video-modal" aria-hidden="true" data-default-video="<?=htmlspecialchars($introVideoEmbedAutoplay, ENT_QUOTES, 'UTF-8')?>">
        <div class="video-modal__overlay" data-video-modal-close></div>
        <div class="video-modal__content" role="dialog" aria-modal="true" aria-label="<?=$sitebaslik?> Tanıtım Videosu">
            <button class="video-modal__close" type="button" data-video-modal-close aria-label="Videoyu kapat">
                <i class="fas fa-times"></i>
            </button>
            <div class="video-modal__headline">
                <span class="video-modal__eyebrow"><?=$sitebaslik?>'ya Hoş Geldiniz</span>
                <h3 class="video-modal__title">Doğal Lezzetleri Keşfedin</h3>
            </div>
            <div class="video-modal__body">
                <div class="video-modal__media">
                    <iframe data-src="<?=htmlspecialchars($introVideoEmbedAutoplay, ENT_QUOTES, 'UTF-8')?>" title="<?=$sitebaslik?> Tanıtım Videosu" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <p class="video-modal__description">Organik ürünlerle hazırlanan menümüzü tanıtım videomuzla keşfedin ve çiftlikten sofraya uzanan hikâyemize ortak olun.</p>
            </div>
        </div>
    </div>

    <!--==============================
        All Js File
    ============================== -->
    <!-- Jquery -->
    <script src="<?=SITE?>assets/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- Slick Slider -->
    <script src="<?=SITE?>assets/js/slick.min.js"></script>
    <!-- Layerslider -->
    <script src="<?=SITE?>assets/js/layerslider.utils.js"></script>
    <script src="<?=SITE?>assets/js/layerslider.transitions.js"></script>
    <script src="<?=SITE?>assets/js/layerslider.kreaturamedia.jquery.js"></script>
    <!-- Bootstrap -->
    <script src="<?=SITE?>assets/js/bootstrap.bundle.min.js"></script>
    <!-- WOW.js Animation -->
    <script src="<?=SITE?>assets/js/wow.min.js"></script>
    <!-- Magnific Popup -->
    <script src="<?=SITE?>assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Isotope Filter -->
    <script src="<?=SITE?>assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="<?=SITE?>assets/js/isotope.pkgd.min.js"></script>
    <!-- Main Js File -->
    <script src="<?=SITE?>assets/js/main.js"></script>
    <!-- OLD THEME JS -->
    <script src="<?=SITE?>js/common_scripts.min.js"></script>

	<!-- SweetAlert -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<!-- Custom System JS -->
	<script src="<?=SITE?>js/sistem.js"></script>
    <!-- LayerSlider Initialize -->
    <script>
        jQuery(document).ready(function($) {
            if ($(".vs-hero-carousel").length) {
                $(".vs-hero-carousel").layerSlider({
                    sliderVersion: "6.5.0",
                    responsiveUnder: 1900,
                    layersContainer: 1900,
                    skin: "v6",
                    skinsPath: "<?=SITE?>layerslider/skins/",
                    pauseOnHover: true,
                    navStartStop: false,
                    navButtons: false,
                    showCircleTimer: false,
                    hoverBottomNav: true,
                    allowFullscreen: false
                });
            }
        });
    </script>

