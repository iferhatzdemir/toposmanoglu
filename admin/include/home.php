<style>
  .dashboard-modern {
    background: #f5f7fa;
    padding: 30px;
    min-height: calc(100vh - 100px);
  }

  .dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 40px;
    border-radius: 20px;
    margin-bottom: 30px;
    box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
    position: relative;
    overflow: hidden;
  }

  .dashboard-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
  }

  .dashboard-header h1 {
    color: #fff;
    font-size: 36px;
    margin-bottom: 10px;
    font-weight: 700;
    position: relative;
    z-index: 1;
  }

  .dashboard-header p {
    color: rgba(255,255,255,0.9);
    font-size: 16px;
    position: relative;
    z-index: 1;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-bottom: 30px;
  }

  .stat-card {
    background: #fff;
    padding: 30px;
    border-radius: 18px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    animation: fadeInUp 0.6s ease;
  }

  .stat-card:nth-child(1) { animation-delay: 0.1s; }
  .stat-card:nth-child(2) { animation-delay: 0.2s; }
  .stat-card:nth-child(3) { animation-delay: 0.3s; }
  .stat-card:nth-child(4) { animation-delay: 0.4s; }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.15);
  }

  .stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 5px;
    background: linear-gradient(90deg, var(--card-color1), var(--card-color2));
  }

  .stat-card.info {
    --card-color1: #4facfe;
    --card-color2: #00f2fe;
  }

  .stat-card.success {
    --card-color1: #43e97b;
    --card-color2: #38f9d7;
  }

  .stat-card.warning {
    --card-color1: #fa709a;
    --card-color2: #fee140;
  }

  .stat-card.danger {
    --card-color1: #f093fb;
    --card-color2: #f5576c;
  }

  .stat-icon {
    width: 70px;
    height: 70px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    margin-bottom: 20px;
    background: linear-gradient(135deg, var(--card-color1), var(--card-color2));
    box-shadow: 0 8px 20px rgba(0,0,0,0.12);
  }

  .stat-value {
    font-size: 42px;
    font-weight: 800;
    color: #2c3e50;
    margin-bottom: 8px;
    background: linear-gradient(135deg, var(--card-color1), var(--card-color2));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .stat-label {
    color: #7f8c8d;
    font-size: 15px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .charts-grid {
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    gap: 25px;
    margin-bottom: 30px;
  }

  .chart-card {
    background: #fff;
    border-radius: 18px;
    padding: 30px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    animation: fadeIn 0.8s ease;
  }

  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  .chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 20px;
    border-bottom: 2px solid #f0f0f0;
  }

  .chart-title {
    font-size: 20px;
    font-weight: 700;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .chart-icon {
    font-size: 24px;
  }

  .chart-legend {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin-top: 20px;
  }

  .legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #7f8c8d;
  }

  .legend-color {
    width: 16px;
    height: 16px;
    border-radius: 4px;
  }

  @media (max-width: 1200px) {
    .charts-grid {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 768px) {
    .stats-grid {
      grid-template-columns: 1fr;
    }

    .dashboard-header {
      padding: 30px 25px;
    }

    .dashboard-header h1 {
      font-size: 28px;
    }

    .stat-value {
      font-size: 36px;
    }
  }

  /* Loading animation */
  .loading-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
  }

  @keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
  }
</style>

<div class="dashboard-modern">
  <?php
  // Visitor statistics
  $buguntekil = 0;
  $buguncogul = 0;
  $geneltekil = 0;
  $genelcogul = 0;

  $buguntekilSorgu = $VT->VeriGetir("ziyaretciler","WHERE tarih=?",array(date("Y-m-d")),"ORDER BY ID ASC");
  if($buguntekilSorgu != false) {
    $buguntekil = count($buguntekilSorgu);
    for($x=0; $x<count($buguntekilSorgu); $x++) {
      $buguncogul += $buguntekilSorgu[$x]["cogul"];
    }
  }

  $geneltekilSorgu = $VT->VeriGetir("ziyaretciler","","","ORDER BY ID ASC");
  if($geneltekilSorgu != false) {
    $geneltekil = count($geneltekilSorgu);
    for($x=0; $x<count($geneltekilSorgu); $x++) {
      $genelcogul += $geneltekilSorgu[$x]["cogul"];
    }
  }

  // Log dashboard view
  if(isset($adminLogger)) {
    $adminLogger->info('Admin dashboard viewed');
  }
  ?>

  <div class="dashboard-header">
    <h1>👋 Hoş Geldiniz, <?= $_SESSION["adsoyad"] ?? 'Admin' ?></h1>
    <p>İşte sitenizin genel durumu ve istatistikleri</p>
  </div>

  <div class="stats-grid">
    <div class="stat-card info">
      <div class="stat-icon">📊</div>
      <div class="stat-value"><?= number_format($buguntekil) ?></div>
      <div class="stat-label">Bugün Tekil Ziyaretçi</div>
    </div>

    <div class="stat-card success">
      <div class="stat-icon">📈</div>
      <div class="stat-value"><?= number_format($buguncogul) ?></div>
      <div class="stat-label">Bugün Çoğul Ziyaretçi</div>
    </div>

    <div class="stat-card warning">
      <div class="stat-icon">👥</div>
      <div class="stat-value"><?= number_format($geneltekil) ?></div>
      <div class="stat-label">Toplam Tekil Ziyaretçi</div>
    </div>

    <div class="stat-card danger">
      <div class="stat-icon">🌐</div>
      <div class="stat-value"><?= number_format($genelcogul) ?></div>
      <div class="stat-label">Toplam Çoğul Ziyaretçi</div>
    </div>
  </div>

  <div class="charts-grid">
    <div class="chart-card">
      <div class="chart-header">
        <div class="chart-title">
          <span class="chart-icon">💰</span>
          Sipariş Raporları (TL)
        </div>
      </div>
      <div style="position: relative; height: 300px;">
        <canvas id="barChart"></canvas>
      </div>
      <div class="chart-legend">
        <div class="legend-item">
          <div class="legend-color" style="background: rgba(233,30,99,0.9);"></div>
          <span>Kredi Kartı</span>
        </div>
        <div class="legend-item">
          <div class="legend-color" style="background: rgba(210, 214, 222, 1);"></div>
          <span>Havale / EFT</span>
        </div>
        <div class="legend-item">
          <div class="legend-color" style="background: rgba(60,141,188,0.9);"></div>
          <span>Kapıda Ödeme</span>
        </div>
      </div>
    </div>

    <div class="chart-card">
      <div class="chart-header">
        <div class="chart-title">
          <span class="chart-icon">🌍</span>
          Tarayıcı İstatistiği
        </div>
      </div>
      <div style="position: relative; height: 300px;">
        <canvas id="donutChart"></canvas>
      </div>
    </div>
  </div>
</div>

<?php
// Calculate monthly sales data
$krediKartiAylar = array();
$HavaleAylar = array();
$KapidaAylar = array();

for($i=1; $i<13; $i++) {
  if($i<10) { $ay = "0".$i; } else { $ay = $i; }
  $baslamatarih = date("Y")."-".$ay."-01";
  $bitistarih = date("Y")."-".$ay."-31";

  // Credit card payments
  $siparisraporKrediKarti = $VT->VeriGetir("siparisler","WHERE odemetipi=? AND tarih BETWEEN ? AND ?",array(1,$baslamatarih,$bitistarih),"ORDER BY ID ASC");
  if($siparisraporKrediKarti != false) {
    $toplamdeger = 0;
    for($x=0; $x<count($siparisraporKrediKarti); $x++) {
      $toplamdeger = ($toplamdeger + $siparisraporKrediKarti[$x]["odenentutar"]);
    }
    $krediKartiAylar[] = $toplamdeger;
  } else {
    $krediKartiAylar[] = 0;
  }

  // Bank transfer payments
  $siparisraporHavale = $VT->VeriGetir("siparisler","WHERE odemetipi=? AND tarih BETWEEN ? AND ?",array(2,$baslamatarih,$bitistarih),"ORDER BY ID ASC");
  if($siparisraporHavale != false) {
    $toplamdeger = 0;
    for($x=0; $x<count($siparisraporHavale); $x++) {
      $toplamdeger = ($toplamdeger + $siparisraporHavale[$x]["odenentutar"]);
    }
    $HavaleAylar[] = $toplamdeger;
  } else {
    $HavaleAylar[] = 0;
  }

  // Cash on delivery payments
  $siparisraporKapida = $VT->VeriGetir("siparisler","WHERE odemetipi=? AND tarih BETWEEN ? AND ?",array(3,$baslamatarih,$bitistarih),"ORDER BY ID ASC");
  if($siparisraporKapida != false) {
    $toplamdeger = 0;
    for($x=0; $x<count($siparisraporKapida); $x++) {
      $toplamdeger = ($toplamdeger + $siparisraporKapida[$x]["odenentutar"]);
    }
    $KapidaAylar[] = $toplamdeger;
  } else {
    $KapidaAylar[] = 0;
  }
}

// Browser statistics
$trycilr = $VT->VeriGetir("ziyarettarayici","WHERE ID<>?",array(5),"ORDER BY ID ASC");
$crom = ($trycilr != false && isset($trycilr[0]["ziyaret"])) ? $trycilr[0]["ziyaret"] : 0;
$mozilla = ($trycilr != false && isset($trycilr[2]["ziyaret"])) ? $trycilr[2]["ziyaret"] : 0;
$internet = ($trycilr != false && isset($trycilr[1]["ziyaret"])) ? $trycilr[1]["ziyaret"] : 0;
$diger = ($trycilr != false && isset($trycilr[3]["ziyaret"])) ? $trycilr[3]["ziyaret"] : 0;
?>

<script type="text/javascript">
  $(function () {
    // Chart data
    var areaChartData = {
      labels: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'],
      datasets: [
        {
          label: 'Havale / EFT İle Satışlar',
          backgroundColor: 'rgba(210, 214, 222, 1)',
          borderColor: 'rgba(210, 214, 222, 1)',
          borderWidth: 2,
          pointRadius: 4,
          pointBackgroundColor: 'rgba(210, 214, 222, 1)',
          pointBorderColor: '#fff',
          pointHoverRadius: 6,
          data: [<?= implode(',', $HavaleAylar) ?>]
        },
        {
          label: 'Kredi Kartı İle Satışlar',
          backgroundColor: 'rgba(233,30,99,0.9)',
          borderColor: 'rgba(233,30,99,0.8)',
          borderWidth: 2,
          pointRadius: 4,
          pointBackgroundColor: '#e91e63',
          pointBorderColor: '#fff',
          pointHoverRadius: 6,
          data: [<?= implode(',', $krediKartiAylar) ?>]
        },
        {
          label: 'Kapıda Ödeme İle Satışlar',
          backgroundColor: 'rgba(60,141,188,0.9)',
          borderColor: 'rgba(60,141,188,0.8)',
          borderWidth: 2,
          pointRadius: 4,
          pointBackgroundColor: '#3b8bba',
          pointBorderColor: '#fff',
          pointHoverRadius: 6,
          data: [<?= implode(',', $KapidaAylar) ?>]
        }
      ]
    };

    // Bar Chart
    var barChartCanvas = $('#barChart').get(0).getContext('2d');
    var barChartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            color: 'rgba(0, 0, 0, 0.05)',
            drawBorder: false
          },
          ticks: {
            callback: function(value) {
              return value.toLocaleString('tr-TR') + ' ₺';
            }
          }
        },
        x: {
          grid: {
            display: false
          }
        }
      }
    };

    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: areaChartData,
      options: barChartOptions
    });

    // Donut Chart
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d');
    var donutData = {
      labels: ['Chrome', 'IE', 'FireFox', 'Diğer'],
      datasets: [{
        data: [<?= $crom ?>, <?= $internet ?>, <?= $mozilla ?>, <?= $diger ?>],
        backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef'],
        borderWidth: 0
      }]
    };

    var donutOptions = {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            padding: 15,
            font: {
              size: 13
            }
          }
        }
      }
    };

    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    });
  });
</script>
