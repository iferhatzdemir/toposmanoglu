<!-- Orijinal footer (yorum satırında bırakıldı) -->
<!--
<footer class="main-footer">
   <strong>Copyright &copy; <?=date("Y")?> </strong>
   Tüm hakları saklıdır.
   <div class="float-right d-none d-sm-inline-block">
     <b>Version</b> 1.0
   </div>
 </footer>
-->

<footer class="main-footer bg-dark text-light py-3" role="contentinfo" aria-label="Yönetim paneli alt bilgi">
  <div class="container-fluid d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2">
    <nav aria-label="Alt menü" class="order-1 order-sm-1">
      <ul class="list-unstyled d-flex flex-wrap gap-3 mb-0">
        <li><a class="link-light text-decoration-none" href="/admin/help.php">Yardım</a></li>
        <li><a class="link-light text-decoration-none" href="/admin/shortcuts.php">Kısayollar</a></li>
        <li><a class="link-light text-decoration-none" href="/admin/status.php">Sistem Durumu</a></li>
        <li><a class="link-light text-decoration-none" href="/admin/contact.php">İletişim</a></li>
      </ul>
    </nav>
    <div class="order-3 order-sm-2 small text-secondary text-center">
      <span>© <?=date('Y')?> Topwebsite Admin. Tüm hakları saklıdır.</span>
    </div>
    <div class="order-2 order-sm-3 small text-secondary">
      <b>Sürüm</b> 1.0
    </div>
  </div>
</footer>