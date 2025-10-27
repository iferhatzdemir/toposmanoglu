<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=SITE?>" class="brand-link">
      <img src="<?=SITE?>dist/img/AdminLTELogo.png" alt="Mehmet ULUS Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">E-TİCARET YÖNETİM</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?=SITE?>dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?=$_SESSION["adsoyad"]?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
              <!-- <li class="nav-item">
            <a href="<?=SITE?>modul-ekle" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Modül Ekle
               
              </p>
            </a>
          </li>-->

           <li class="nav-item">
            <a href="<?=SITE?>banner-liste" class="nav-link">
              <i class="nav-icon fas fa-image"></i>
              <p>
                Banner
               
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?=SITE?>kategori-liste" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Kategoriler
               
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=SITE?>urun-liste" class="nav-link">
              <i class="nav-icon fas fa-tshirt"></i>
              <p>
                Ürünler

              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?=SITE?>galeri" class="nav-link">
              <i class="nav-icon fas fa-images"></i>
              <p>
                Galeri Yönetimi

              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-comments"></i>
              <p>
                Yorum Yönetimi
                <?php
                $bekleyenTestimonials = $VT->VeriGetir("testimonials", "WHERE onay_durumu=?", array("beklemede"), "");
                $bekleyenUrunYorumlar = $VT->VeriGetir("yorumlar", "WHERE durum=?", array(0), "");
                $toplamBekleyen = 0;
                if($bekleyenTestimonials) $toplamBekleyen += count($bekleyenTestimonials);
                if($bekleyenUrunYorumlar) $toplamBekleyen += count($bekleyenUrunYorumlar);
                if($toplamBekleyen > 0) {
                  echo '<span class="badge badge-warning right">'.$toplamBekleyen.'</span>';
                }
                ?>
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=SITE?>testimonials-liste" class="nav-link">
                  <i class="far fa-star nav-icon"></i>
                  <p>İşletme Yorumları
                    <?php
                    if($bekleyenTestimonials && count($bekleyenTestimonials) > 0) {
                      echo '<span class="badge badge-warning right">'.count($bekleyenTestimonials).'</span>';
                    }
                    ?>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=SITE?>testimonials-ekle" class="nav-link">
                  <i class="far fa-plus nav-icon"></i>
                  <p>İşletme Yorumu Ekle</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?=SITE?>yorumlar" class="nav-link">
                  <i class="far fa-shopping-bag nav-icon"></i>
                  <p>Ürün Yorumları
                    <?php
                    if($bekleyenUrunYorumlar && count($bekleyenUrunYorumlar) > 0) {
                      echo '<span class="badge badge-warning right">'.count($bekleyenUrunYorumlar).'</span>';
                    }
                    ?>
                  </p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?=SITE?>siparis-liste" class="nav-link">
              <i class="nav-icon fas fa-shipping-fast"></i>
              <p>
                Siparisler
               <?php
               $yenisiparis=$VT->VeriGetir("siparisler WHERE takipno IS NULL");
               if($yenisiparis!=false)
               {
                ?>
                <span class="right badge badge-danger"><?=count($yenisiparis)?></span>
                <?php
               }
               ?>
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="<?=SITE?>iade-liste" class="nav-link">
              <i class="nav-icon fas fa-shipping-fast"></i>
              <p>
                İadeler
               <?php
               $yeniiadeler=$VT->VeriGetir("iadeler","WHERE durum=?",array(1));
               if($yeniiadeler!=false)
               {
                ?>
                <span class="right badge badge-danger"><?=count($yeniiadeler)?></span>
                <?php
               }
               ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=SITE?>yorumlar" class="nav-link">
              <i class="nav-icon fas fa-comment"></i>
              <p>
                Yorumlar
               <?php
               $yeniyorumlar=$VT->VeriGetir("yorumlar","WHERE durum=?",array(2));
               if($yeniyorumlar!=false)
               {
                ?>
                <span class="right badge badge-danger"><?=count($yeniyorumlar)?></span>
                <?php
               }
               ?>
              </p>
            </a>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Sayfalar
                <i class="right fas fa-angle-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
             <?php
			 $moduller=$VT->VeriGetir("moduller","WHERE durum=?",array(1),"ORDER BY ID ASC");
			 if($moduller!=false)
			 {
				 for($i=0;$i<count($moduller);$i++)
				 {
					 ?>
                      <li class="nav-item">
                        <a href="<?=SITE?>liste/<?=$moduller[$i]["tablo"]?>" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p><?=$moduller[$i]["baslik"]?></p>
                        </a>
                      </li>
                     <?php
				 }
			 }
			 ?>
             
             
              
              
            </ul>
          </li>
          <li class="nav-item">
            <a href="<?=SITE?>mesajlar" class="nav-link">
              <i class="nav-icon fas fa-comments"></i>
              <p>
                Mesajlar
               <?php
               $yenimesajlar=$VT->VeriGetir("mesajlar","WHERE durum=?",array(1));
               if($yenimesajlar!=false)
               {
                ?>
                <span class="right badge badge-danger"><?=count($yenimesajlar)?></span>
                <?php
               }
               ?>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=SITE?>hesap-numarasi-liste" class="nav-link">
              <i class="nav-icon fas fa-university"></i>
              <p>
                Banka Hesap Numaraları
               
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=SITE?>seo-ayarlari" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Seo Ayarları
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="<?=SITE?>iletisim-ayarlari" class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                İletişim Ayarları
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=SITE?>mehmet-ulus" class="nav-link">
              <i class="nav-icon fas fa-question"></i>
              <p>Destek Hattı</p>
            </a>
          </li>
         <li class="nav-item">
            <a href="<?=SITE?>cikis" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Çıkış Yap
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>