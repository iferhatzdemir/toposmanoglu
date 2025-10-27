    <!--==============================
    Breadcumb
============================== -->
    <div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/breadcumb/breadcumb-img-1.jpg">
        <div class="container">
            <div class="breadcumb-content text-center">
                <h1 class="breadcumb-title">Blog</h1>
                <ul class="breadcumb-menu-style1 mx-auto">
                    <li><a href="<?=SITE?>">Anasayfa</a></li>
                    <li class="active">Blog</li>
                </ul>
            </div>
        </div>
    </div>
    <!--==============================
        Blog Area
    ==============================-->
    <section class="vs-blog-wrapper space-top space-md-bottom" id="blog">
        <div class="container">
            <div class="row ">
                <?php
                $bloglar = $VT->VeriGetir("bloglar", "WHERE durum=?", array(1), "ORDER BY sirano ASC");
                if($bloglar != false) {
                    foreach($bloglar as $blog) {
                        if(!empty($blog["resim"])) {
                            $resim = $blog["resim"];
                        } else {
                            $resim = "varsayilan.png";
                        }
                ?>
                <div class="col-sm-6 col-lg-4">
                    <div class="vs-blog blog-grid">
                        <div class="blog-img image-scale-hover">
                            <a href="<?=SITE?>blog-detay/<?=$blog["seflink"]?>">
                                <img src="<?=SITE?>images/bloglar/<?=$resim?>" alt="<?=stripslashes($blog["baslik"])?>" class="w-100">
                            </a>
                        </div>
                        <div class="blog-content">
                            <h4 class="blog-title fw-semibold">
                                <a href="<?=SITE?>blog-detay/<?=$blog["seflink"]?>"><?=stripslashes($blog["baslik"])?></a>
                            </h4>
                            <div class="blog-meta">
                                <a href="<?=SITE?>blog-detay/<?=$blog["seflink"]?>"><?=date("d.m.Y", strtotime($blog["tarih"]))?></a>
                                <a href="<?=SITE?>blog-detay/<?=$blog["seflink"]?>"><?=isset($blog["goruntulenme"]) ? $blog["goruntulenme"] : 0?> Görüntülenme</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                } else {
                ?>
                <div class="col-12 text-center">
                    <p>Henüz blog yazısı bulunmamaktadır.</p>
                </div>
                <?php
                }
                ?>
            </div>
            <?php if($bloglar != false && count($bloglar) > 0) { ?>
            <div class="pagination-layout1 list-style-none mt-30 mb-30">
                <ul>
                    <li><a href="#">Önceki</a></li>
                    <li><a href="#" class="active">1</a></li>
                    <li><a href="#">Sonraki</a></li>
                </ul>
            </div>
            <?php } ?>
        </div>
    </section>