<?php
if(!empty($_SESSION["uyeID"]))
{
    $uyeID=$VT->filter($_SESSION["uyeID"]);
    $uyebilgisi=$VT->VeriGetir("uyeler","WHERE ID=? AND durum=?",array($uyeID,1),"ORDER BY ID ASC",1);
    if($uyebilgisi!=false)
    {
        if(!empty($_GET["ID"]) && ctype_digit($_GET["ID"]))
        {
            $favoriID=$VT->filter($_GET["ID"]);
            $favoriSil=$VT->VeriGetir("favoriler","WHERE uyeID=? AND ID=?",array($uyebilgisi[0]["ID"],$favoriID),"ORDER BY ID DESC",1);
            if($favoriSil!=false)
            {
                $sil=$VT->SorguCalistir("DELETE FROM favoriler","WHERE ID=?",array($favoriSil[0]["ID"]),1);
            }
            ?>
            <meta http-equiv="refresh" content="0;url=<?=SITE?>favorilerim">
            <?php
            exit();
        }
        ?>
    <!--==============================
    Breadcumb
============================== -->
    <div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/breadcumb/breadcumb-img-1.jpg">
        <div class="container">
            <div class="breadcumb-content text-center">
                <h1 class="breadcumb-title">Favori Urunlerim</h1>
                <ul class="breadcumb-menu-style1 mx-auto">
                    <li><a href="<?=SITE?>">Anasayfa</a></li>
                    <li class="active">Favorilerim</li>
                </ul>
            </div>
        </div>
    </div>

    <!--==============================
        Account Menu Area
    ==============================-->
    <section class="space-top space-md-bottom">
        <div class="container">
            <div class="row mb-40">
                <div class="col-lg-2 col-md-4 col-6 mb-3">
                    <a href="<?=SITE?>siparislerim" class="account-menu-box text-center">
                        <i class="far fa-shopping-bag"></i>
                        <h5>Siparislerim</h5>
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-3">
                    <a href="<?=SITE?>hesabim" class="account-menu-box text-center">
                        <i class="far fa-user"></i>
                        <h5>Hesabim</h5>
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-3">
                    <a href="<?=SITE?>iadeler" class="account-menu-box text-center">
                        <i class="far fa-undo"></i>
                        <h5>Iade Takibi</h5>
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-3">
                    <a href="<?=SITE?>siparis-takip" class="account-menu-box text-center">
                        <i class="far fa-truck"></i>
                        <h5>Siparis Takibi</h5>
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-3">
                    <a href="<?=SITE?>sepet" class="account-menu-box text-center">
                        <i class="far fa-shopping-cart"></i>
                        <h5>Sepetim</h5>
                    </a>
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-3">
                    <a href="<?=SITE?>cikis-yap" class="account-menu-box text-center">
                        <i class="far fa-sign-out"></i>
                        <h5>Cikis</h5>
                    </a>
                </div>
            </div>

            <!--==============================
                Favorites List
            ==============================-->
            <div class="row">
                <div class="col-12">
                    <div class="bg-white p-4 shadow-sm rounded">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>URUN BILGISI</th>
                                        <th>TARIH</th>
                                        <th class="text-center">ISLEMLER</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $favoriler=$VT->VeriGetir("favoriler","WHERE uyeID=?",array($uyebilgisi[0]["ID"]),"ORDER BY ID DESC");
                                    if($favoriler!=false)
                                    {
                                        for($i=0;$i<count($favoriler);$i++)
                                        {
                                            $urunBilgisi=$VT->VeriGetir("urunler","WHERE ID=? AND durum=?",array($favoriler[$i]["urunID"],1),"ORDER BY ID ASC",1);
                                            if($urunBilgisi!=false)
                                            {
                                                if(!empty($urunBilgisi[0]["resim"])) {
                                                    $urunResim = $urunBilgisi[0]["resim"];
                                                } else {
                                                    $urunResim = "varsayilan.png";
                                                }
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?=SITE?>images/urunler/<?=$urunResim?>" alt="<?=stripslashes($urunBilgisi[0]["baslik"])?>" style="height: 60px; width: 60px; object-fit: cover; border-radius: 8px;" class="me-3">
                                                <span><?=stripslashes($urunBilgisi[0]["baslik"])?></span>
                                            </div>
                                        </td>
                                        <td><?=date("d.m.Y",strtotime($favoriler[$i]["tarih"]))?></td>
                                        <td class="text-center">
                                            <a href="<?=SITE?>urun/<?=$urunBilgisi[0]["seflink"]?>" class="vs-btn style4 btn-sm me-2">
                                                <i class="far fa-eye"></i> Incele
                                            </a>
                                            <a href="<?=SITE?>favorilerim/<?=$favoriler[$i]["ID"]?>" class="vs-btn style8 btn-sm" onclick="return confirm('Bu urunu favorilerinizden kaldirmak istediginize emin misiniz?')">
                                                <i class="far fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                            }
                                        }
                                    }
                                    else
                                    {
                                    ?>
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <i class="far fa-heart" style="font-size: 60px; color: #ddd; margin-bottom: 15px; display: block;"></i>
                                            <p class="mb-0">Favorinizde hic urun bulunmuyor.</p>
                                            <a href="<?=SITE?>urunler" class="vs-btn style4 mt-3">Urunleri Incele</a>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .account-menu-box {
            display: block;
            padding: 20px 10px;
            background: #fff;
            border: 2px solid #e8e8e8;
            border-radius: 10px;
            transition: all 0.3s;
            text-decoration: none;
            color: #333;
        }
        .account-menu-box:hover {
            border-color: #76a713;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(118, 167, 19, 0.1);
        }
        .account-menu-box i {
            font-size: 32px;
            color: #76a713;
            margin-bottom: 10px;
            display: block;
        }
        .account-menu-box h5 {
            font-size: 14px;
            margin: 0;
            font-weight: 600;
        }
        .table th {
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            color: #333;
            border-bottom: 2px solid #76a713;
        }
        .table td {
            vertical-align: middle;
            padding: 20px 15px;
        }
        .vs-btn.btn-sm {
            padding: 8px 15px;
            font-size: 13px;
        }
        .vs-btn.style8 {
            background: #dc3545;
            color: #fff;
        }
        .vs-btn.style8:hover {
            background: #c82333;
        }
    </style>

        <?php
    }
    else
    {
        ?>
        <meta http-equiv="refresh" content="0;url=<?=SITE?>uyelik">
        <?php
        exit();
    }
}
else
{
    ?>
    <meta http-equiv="refresh" content="0;url=<?=SITE?>uyelik">
    <?php
    exit();
}
?>
