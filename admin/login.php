<?php
@session_start();
@ob_start();
define("DATA","data/");
define("SAYFA","include/");
define("SINIF","class/");
include_once(DATA."baglanti.php");
define("SITE",$siteURL."admin/");
define("ANASITE",$siteURL);

// Include logger
require_once __DIR__ . '/init-logger.php';

if(!empty($_SESSION["ID"]) && !empty($_SESSION["adsoyad"]) && !empty($_SESSION["mail"]))
{
	?>
    <meta http-equiv="refresh" content="0;url=<?=SITE?>">
    <?php
	exit();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$sitebaslik?> - Admin Girişi</title>
  <meta http-equiv="keywords" content="<?=$siteanahtar?>">
  <meta http-equiv="description" content="<?=$siteaciklama?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      position: relative;
      overflow: hidden;
    }

    /* Animated background particles */
    body::before {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      background-image:
        radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 20%, rgba(255,255,255,0.1) 0%, transparent 50%);
      animation: particleFloat 20s ease-in-out infinite;
    }

    @keyframes particleFloat {
      0%, 100% { transform: translate(0, 0); }
      33% { transform: translate(30px, -30px); }
      66% { transform: translate(-20px, 20px); }
    }

    .login-container {
      background: #fff;
      border-radius: 25px;
      box-shadow: 0 30px 90px rgba(0,0,0,0.3);
      overflow: hidden;
      max-width: 450px;
      width: 100%;
      position: relative;
      z-index: 1;
      animation: slideUp 0.6s ease;
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(50px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .login-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      padding: 50px 40px 40px;
      text-align: center;
      position: relative;
    }

    .login-header::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 30px;
      background: #fff;
      border-radius: 50% 50% 0 0 / 100% 100% 0 0;
    }

    .admin-icon {
      width: 100px;
      height: 100px;
      background: linear-gradient(135deg, rgba(255,255,255,0.3), rgba(255,255,255,0.1));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      font-size: 50px;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
      animation: iconPulse 2s ease-in-out infinite;
      backdrop-filter: blur(10px);
      border: 3px solid rgba(255,255,255,0.3);
    }

    @keyframes iconPulse {
      0%, 100% { transform: scale(1); box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
      50% { transform: scale(1.05); box-shadow: 0 15px 50px rgba(0,0,0,0.3); }
    }

    .login-title {
      color: #fff;
      font-size: 32px;
      font-weight: 700;
      margin-bottom: 10px;
      text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .login-subtitle {
      color: rgba(255,255,255,0.9);
      font-size: 15px;
      font-weight: 400;
    }

    .login-body {
      padding: 50px 40px 40px;
    }

    .alert {
      padding: 15px 20px;
      border-radius: 12px;
      margin-bottom: 25px;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 12px;
      animation: slideIn 0.4s ease;
    }

    @keyframes slideIn {
      from { opacity: 0; transform: translateX(-20px); }
      to { opacity: 1; transform: translateX(0); }
    }

    .alert-danger {
      background: linear-gradient(135deg, #ffe5e5 0%, #ffcccc 100%);
      color: #c33;
      border-left: 4px solid #c33;
    }

    .alert-icon {
      font-size: 24px;
    }

    .form-group {
      margin-bottom: 25px;
      position: relative;
    }

    .form-label {
      display: block;
      color: #333;
      font-size: 14px;
      font-weight: 600;
      margin-bottom: 10px;
      padding-left: 5px;
    }

    .input-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      font-size: 20px;
      color: #667eea;
      transition: all 0.3s;
    }

    .form-control {
      width: 100%;
      padding: 16px 20px 16px 55px;
      border: 2px solid #e0e0e0;
      border-radius: 12px;
      font-size: 15px;
      color: #333;
      transition: all 0.3s;
      background: #f8f9fa;
    }

    .form-control:focus {
      outline: none;
      border-color: #667eea;
      background: #fff;
      box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .form-control:focus + .input-icon {
      color: #764ba2;
      transform: translateY(-50%) scale(1.1);
    }

    .password-toggle {
      position: absolute;
      right: 18px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 20px;
      color: #999;
      transition: all 0.3s;
      z-index: 2;
    }

    .password-toggle:hover {
      color: #667eea;
    }

    .btn-login {
      width: 100%;
      padding: 18px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: #fff;
      border: none;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s;
      box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
      position: relative;
      overflow: hidden;
    }

    .btn-login::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
      transition: left 0.5s;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
    }

    .btn-login:hover::before {
      left: 100%;
    }

    .btn-login:active {
      transform: translateY(0);
    }

    .login-footer {
      text-align: center;
      margin-top: 30px;
      padding-top: 25px;
      border-top: 1px solid #e0e0e0;
    }

    .footer-text {
      color: #999;
      font-size: 13px;
    }

    .footer-link {
      color: #667eea;
      text-decoration: none;
      font-weight: 600;
      transition: all 0.3s;
    }

    .footer-link:hover {
      color: #764ba2;
      text-decoration: underline;
    }

    /* Loading spinner */
    .btn-login.loading {
      pointer-events: none;
      opacity: 0.7;
    }

    .btn-login.loading::after {
      content: '';
      position: absolute;
      width: 20px;
      height: 20px;
      top: 50%;
      left: 50%;
      margin-left: -10px;
      margin-top: -10px;
      border: 2px solid rgba(255,255,255,0.3);
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin 0.6s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 768px) {
      .login-container {
        margin: 20px;
      }

      .login-header {
        padding: 40px 30px 30px;
      }

      .login-body {
        padding: 40px 30px 30px;
      }

      .admin-icon {
        width: 80px;
        height: 80px;
        font-size: 40px;
      }

      .login-title {
        font-size: 26px;
      }
    }

    /* Input validation states */
    .form-control.is-invalid {
      border-color: #dc3545;
      background: #fff5f5;
    }

    .form-control.is-valid {
      border-color: #28a745;
      background: #f0fff4;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="login-header">
      <div class="admin-icon">🔐</div>
      <h1 class="login-title">Admin Paneli</h1>
      <p class="login-subtitle">Yönetim paneline hoş geldiniz</p>
    </div>

    <div class="login-body">
      <?php
      if($_POST)
      {
        if(!empty($_POST["kullanici"]) && !empty($_POST["sifre"]))
        {
          $kullanici=$VT->filter($_POST["kullanici"]);
          $sifre=md5($VT->filter($_POST["sifre"]));
          $kontrol=$VT->VeriGetir("kullanicilar","WHERE kullanici=? AND sifre=?",array($kullanici,$sifre),"ORDER BY ID ASC",1);
          if($kontrol!=false)
          {
            $_SESSION["kullanici"]=$kontrol[0]["kullanici"];
            $_SESSION["adsoyad"]=$kontrol[0]["adsoyad"];
            $_SESSION["mail"]=$kontrol[0]["mail"];
            $_SESSION["ID"]=$kontrol[0]["ID"];

            // Log successful login
            $adminLogger->info('Admin login successful', [
              'username' => $kullanici,
              'admin_id' => $kontrol[0]["ID"]
            ]);
            ?>
            <meta http-equiv="refresh" content="0;url=<?=SITE?>" />
            <?php
            exit();
          }
          else
          {
            // Log failed login attempt
            $adminLogger->warning('Admin login failed - Invalid credentials', [
              'username' => $kullanici,
              'ip' => $_SERVER['REMOTE_ADDR']
            ]);
            echo '<div class="alert alert-danger">
                    <span class="alert-icon">⚠️</span>
                    <span>Kullanıcı adı veya şifre hatalıdır.</span>
                  </div>';
          }
        }
        else
        {
          // Log failed login attempt - empty fields
          $adminLogger->warning('Admin login failed - Empty fields');
          echo '<div class="alert alert-danger">
                  <span class="alert-icon">⚠️</span>
                  <span>Boş bıraktığınız alanları doldurunuz.</span>
                </div>';
        }
      }
      ?>

      <form action="#" method="post" id="loginForm">
        <div class="form-group">
          <label class="form-label">Kullanıcı Adı</label>
          <div class="input-wrapper">
            <input
              type="text"
              class="form-control"
              name="kullanici"
              placeholder="Kullanıcı adınızı girin"
              autocomplete="off"
              required
            >
            <span class="input-icon">👤</span>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">Şifre</label>
          <div class="input-wrapper">
            <input
              type="password"
              name="sifre"
              class="form-control"
              id="passwordInput"
              placeholder="Şifrenizi girin"
              autocomplete="off"
              required
            >
            <span class="input-icon">🔒</span>
            <span class="password-toggle" id="passwordToggle">👁️</span>
          </div>
        </div>

        <button type="submit" class="btn-login" id="loginBtn">
          Giriş Yap
        </button>
      </form>

      <div class="login-footer">
        <p class="footer-text">
          © <?= date('Y') ?> <?= $sitebaslik ?> - Tüm hakları saklıdır.
        </p>
      </div>
    </div>
  </div>

  <script>
    // Password toggle
    document.getElementById('passwordToggle').addEventListener('click', function() {
      const passwordInput = document.getElementById('passwordInput');
      const type = passwordInput.type === 'password' ? 'text' : 'password';
      passwordInput.type = type;
      this.textContent = type === 'password' ? '👁️' : '🙈';
    });

    // Form submit with loading state
    document.getElementById('loginForm').addEventListener('submit', function() {
      const btn = document.getElementById('loginBtn');
      btn.classList.add('loading');
      btn.textContent = '';
    });

    // Input validation
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
      input.addEventListener('blur', function() {
        if (this.value.trim() === '') {
          this.classList.add('is-invalid');
          this.classList.remove('is-valid');
        } else {
          this.classList.add('is-valid');
          this.classList.remove('is-invalid');
        }
      });

      input.addEventListener('input', function() {
        if (this.classList.contains('is-invalid') || this.classList.contains('is-valid')) {
          if (this.value.trim() === '') {
            this.classList.add('is-invalid');
            this.classList.remove('is-valid');
          } else {
            this.classList.add('is-valid');
            this.classList.remove('is-invalid');
          }
        }
      });
    });

    // Prevent multiple form submissions
    let formSubmitted = false;
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      if (formSubmitted) {
        e.preventDefault();
        return false;
      }
      formSubmitted = true;
    });
  </script>
</body>
</html>
