    <!--==============================
    Breadcumb
============================== -->
    <div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/breadcumb/breadcumb-img-1.jpg">
        <div class="container">
            <div class="breadcumb-content text-center">
                <h1 class="breadcumb-title">Cikis Yapiliyor</h1>
                <ul class="breadcumb-menu-style1 mx-auto">
                    <li><a href="<?=SITE?>">Anasayfa</a></li>
                    <li class="active">Cikis</li>
                </ul>
            </div>
        </div>
    </div>

    <!--==============================
        Logout Area
    ==============================-->
    <section class="vs-blog-wrapper space-top space-md-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 text-center">
                    <div class="py-5">
                        <div class="mb-4">
                            <i class="fas fa-sign-out-alt" style="font-size: 80px; color: #76a713;"></i>
                        </div>
                        <h2 class="sec-title4 mb-3">Cikis Yapiliyor...</h2>
                        <p class="mb-4">Hesabinizdan cikis yapiliyor. Lutfen bekleyiniz.</p>
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Yukleniyor...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
// Session sonlandirma islemleri
@session_destroy();
@ob_end_flush();
?>
<meta http-equiv="refresh" content="2;url=<?=SITE?>" />
<?php
exit();
?>
