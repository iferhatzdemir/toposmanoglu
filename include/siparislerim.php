<?php
if(!empty($_SESSION["uyeID"]))
{
	$uyeID=$VT->filter($_SESSION["uyeID"]);
	$uyebilgisi=$VT->VeriGetir("uyeler","WHERE ID=? AND durum=?",array($uyeID,1),"ORDER BY ID ASC",1);
	if($uyebilgisi!=false)
	{
?>

<!--==============================
Breadcumb
============================== -->
<div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/breadcumb/breadcumb-img-1.jpg">
	<div class="container">
		<div class="breadcumb-content text-center">
			<h1 class="breadcumb-title">Siparislerim</h1>
			<ul class="breadcumb-menu-style1 mx-auto">
				<li><a href="<?=SITE?>">Anasayfa</a></li>
				<li class="active">Siparislerim</li>
			</ul>
		</div>
	</div>
</div>

<!--==============================
My Orders Section
============================== -->
<section class="space-top space-md-bottom">
	<div class="container">
		<!-- Quick Actions Menu -->
		<div class="quick-actions-menu mb-5">
			<div class="row g-3">
				<div class="col-lg-2 col-md-4 col-6">
					<a href="<?=SITE?>siparislerim" class="action-card active">
						<i class="far fa-shopping-bag"></i>
						<span>Siparislerim</span>
					</a>
				</div>
				<div class="col-lg-2 col-md-4 col-6">
					<a href="<?=SITE?>hesabim" class="action-card">
						<i class="far fa-user"></i>
						<span>Hesabim</span>
					</a>
				</div>
				<div class="col-lg-2 col-md-4 col-6">
					<a href="<?=SITE?>iadeler" class="action-card">
						<i class="far fa-undo"></i>
						<span>Iadeler</span>
					</a>
				</div>
				<div class="col-lg-2 col-md-4 col-6">
					<a href="<?=SITE?>siparis-takip" class="action-card">
						<i class="far fa-truck"></i>
						<span>Siparis Takip</span>
					</a>
				</div>
				<div class="col-lg-2 col-md-4 col-6">
					<a href="<?=SITE?>sepet" class="action-card">
						<i class="far fa-shopping-cart"></i>
						<span>Sepetim</span>
					</a>
				</div>
				<div class="col-lg-2 col-md-4 col-6">
					<a href="<?=SITE?>cikis-yap" class="action-card">
						<i class="far fa-sign-out"></i>
						<span>Cikis</span>
					</a>
				</div>
			</div>
		</div>

		<!-- Orders List -->
		<div class="orders-wrapper">
			<?php
			$siparisler=$VT->VeriGetir("siparisler","WHERE uyeID=?",array($uyebilgisi[0]["ID"]),"ORDER BY ID DESC");
			if($siparisler!=false)
			{
				?>
				<!-- Stats Cards -->
				<div class="stats-cards mb-4">
					<div class="row g-3">
						<div class="col-lg-3 col-md-6">
							<div class="stat-card stat-total">
								<div class="stat-icon">
									<i class="far fa-receipt"></i>
								</div>
								<div class="stat-content">
									<h4><?=count($siparisler)?></h4>
									<p>Toplam Siparis</p>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6">
							<div class="stat-card stat-paid">
								<div class="stat-icon">
									<i class="far fa-check-circle"></i>
								</div>
								<div class="stat-content">
									<h4><?php
									$odenenler = 0;
									foreach($siparisler as $s) {
										if($s["durum"]==1) $odenenler++;
									}
									echo $odenenler;
									?></h4>
									<p>Odenen</p>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6">
							<div class="stat-card stat-pending">
								<div class="stat-icon">
									<i class="far fa-clock"></i>
								</div>
								<div class="stat-content">
									<h4><?php
									$bekleyenler = 0;
									foreach($siparisler as $s) {
										if($s["durum"]!=1) $bekleyenler++;
									}
									echo $bekleyenler;
									?></h4>
									<p>Bekleyen</p>
								</div>
							</div>
						</div>
						<div class="col-lg-3 col-md-6">
							<div class="stat-card stat-shipped">
								<div class="stat-icon">
									<i class="far fa-truck"></i>
								</div>
								<div class="stat-content">
									<h4><?php
									$kargolanlar = 0;
									foreach($siparisler as $s) {
										if(!empty($s["kargoadi"])) $kargolanlar++;
									}
									echo $kargolanlar;
									?></h4>
									<p>Kargoda</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Orders Cards -->
				<div class="orders-list">
					<?php
					for($i=0; $i<count($siparisler); $i++)
					{
						if($siparisler[$i]["odemetipi"]==1){$odemetipi="Kredi Karti";}
						if($siparisler[$i]["odemetipi"]==2){$odemetipi="Havale / EFT";}
						if($siparisler[$i]["odemetipi"]==3){$odemetipi="Kapida Odeme";}

						$odendiMi = $siparisler[$i]["durum"]==1;
						?>
						<div class="order-card" data-aos="fade-up" data-aos-delay="<?=$i*100?>">
							<div class="order-card-header">
								<div class="order-code-wrapper">
									<span class="order-label">Siparis Kodu</span>
									<h4 class="order-code">#<?=$siparisler[$i]["sipariskodu"]?></h4>
								</div>
								<div class="order-status-wrapper">
									<div class="payment-status-badge <?=$odendiMi ? 'paid' : 'pending'?>">
										<i class="far <?=$odendiMi ? 'fa-check-circle' : 'fa-clock'?>"></i>
										<span><?=$odendiMi ? 'ODENDI' : 'ODEME BEKLIYOR'?></span>
									</div>
								</div>
							</div>

							<div class="order-card-body">
								<div class="order-info-grid">
									<div class="info-item-order">
										<div class="info-icon-order payment">
											<i class="far fa-credit-card"></i>
										</div>
										<div class="info-text-order">
											<label>Odeme Tipi</label>
											<span><?=$odemetipi?></span>
										</div>
									</div>

									<div class="info-item-order">
										<div class="info-icon-order date">
											<i class="far fa-calendar"></i>
										</div>
										<div class="info-text-order">
											<label>Siparis Tarihi</label>
											<span><?=date("d.m.Y",strtotime($siparisler[$i]["tarih"]))?></span>
										</div>
									</div>

									<div class="info-item-order">
										<div class="info-icon-order amount">
											<i class="far fa-wallet"></i>
										</div>
										<div class="info-text-order">
											<label>Toplam Tutar</label>
											<span class="amount-value"><?=number_format($siparisler[$i]["odenentutar"],2,",",".")?> TL</span>
										</div>
									</div>

									<?php if(!empty($siparisler[$i]["kargoadi"])) { ?>
									<div class="info-item-order">
										<div class="info-icon-order shipping">
											<i class="far fa-truck"></i>
										</div>
										<div class="info-text-order">
											<label>Kargo</label>
											<span><?=$siparisler[$i]["kargoadi"]?></span>
										</div>
									</div>
									<?php } ?>
								</div>

								<!-- Price Details Toggle -->
								<div class="price-details-toggle">
									<button type="button" class="toggle-btn" onclick="togglePriceDetails(this)">
										<i class="far fa-chevron-down"></i>
										<span>Fiyat Detaylarini Goster</span>
									</button>
									<div class="price-details-content">
										<div class="price-row">
											<span>KDV Haric Tutar:</span>
											<span><?=number_format($siparisler[$i]["kdvharictutar"],2,",",".")?> TL</span>
										</div>
										<div class="price-row">
											<span>KDV Tutar:</span>
											<span><?=number_format($siparisler[$i]["kdvtutar"],2,",",".")?> TL</span>
										</div>
										<div class="price-divider"></div>
										<div class="price-row total">
											<strong>Toplam:</strong>
											<strong class="total-amount"><?=number_format($siparisler[$i]["odenentutar"],2,",",".")?> TL</strong>
										</div>
									</div>
								</div>
							</div>

							<div class="order-card-footer">
								<a href="<?=SITE?>siparis-detay/<?=$siparisler[$i]["sipariskodu"]?>" class="btn-view-order">
									<i class="far fa-eye me-2"></i>
									<span>Siparisi Incele</span>
									<i class="far fa-arrow-right ms-2"></i>
								</a>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<?php
			}
			else
			{
				?>
				<!-- Empty State -->
				<div class="empty-orders-state">
					<div class="empty-icon">
						<i class="far fa-shopping-bag"></i>
					</div>
					<h3>Henuz Siparis Vermediniz</h3>
					<p>Hemen alisverise baslayin ve ilk siparişinizi verin!</p>
					<a href="<?=SITE?>" class="vs-btn style4">
						<i class="far fa-shopping-cart me-2"></i>Alisverise Basla
					</a>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</section>

<style>
	/* Quick Actions Menu */
	.quick-actions-menu {
		animation: slideDown 0.6s ease-out;
	}
	.action-card {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		gap: 12px;
		padding: 25px 15px;
		background: #fff;
		border: 2px solid #e8e8e8;
		border-radius: 15px;
		text-decoration: none;
		transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
		height: 100%;
		position: relative;
		overflow: hidden;
	}
	.action-card::before {
		content: '';
		position: absolute;
		top: 0;
		left: -100%;
		width: 100%;
		height: 100%;
		background: linear-gradient(90deg, transparent, rgba(118, 167, 19, 0.1), transparent);
		transition: left 0.6s ease;
	}
	.action-card:hover::before {
		left: 100%;
	}
	.action-card i {
		font-size: 32px;
		color: #76a713;
		transition: all 0.3s ease;
	}
	.action-card span {
		font-size: 14px;
		font-weight: 600;
		color: #2c3e50;
		text-align: center;
	}
	.action-card:hover,
	.action-card.active {
		border-color: #76a713;
		box-shadow: 0 8px 25px rgba(118, 167, 19, 0.2);
		transform: translateY(-5px);
	}
	.action-card:hover i,
	.action-card.active i {
		transform: scale(1.15) rotate(5deg);
	}
	.action-card.active {
		background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
	}

	/* Stats Cards */
	.stats-cards {
		animation: fadeIn 0.8s ease-out;
	}
	.stat-card {
		display: flex;
		align-items: center;
		gap: 20px;
		padding: 25px;
		background: #fff;
		border-radius: 15px;
		border: 2px solid #e8e8e8;
		transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
		position: relative;
		overflow: hidden;
	}
	.stat-card::before {
		content: '';
		position: absolute;
		bottom: 0;
		left: 0;
		width: 100%;
		height: 4px;
		transition: height 0.3s ease;
	}
	.stat-card:hover::before {
		height: 100%;
		opacity: 0.1;
	}
	.stat-card:hover {
		border-color: transparent;
		transform: translateY(-5px);
		box-shadow: 0 10px 30px rgba(0,0,0,0.15);
	}

	.stat-card.stat-total::before { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
	.stat-card.stat-paid::before { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); }
	.stat-card.stat-pending::before { background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); }
	.stat-card.stat-shipped::before { background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); }

	.stat-icon {
		flex-shrink: 0;
		width: 70px;
		height: 70px;
		display: flex;
		align-items: center;
		justify-content: center;
		border-radius: 15px;
		font-size: 32px;
		color: #fff;
		position: relative;
		z-index: 1;
		transition: all 0.3s ease;
	}
	.stat-total .stat-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
	.stat-paid .stat-icon { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); }
	.stat-pending .stat-icon { background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); }
	.stat-shipped .stat-icon { background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); }

	.stat-card:hover .stat-icon {
		transform: scale(1.1) rotate(10deg);
	}

	.stat-content h4 {
		font-size: 36px;
		font-weight: 800;
		color: #2c3e50;
		margin: 0 0 5px 0;
		line-height: 1;
	}
	.stat-content p {
		font-size: 14px;
		color: #6c757d;
		margin: 0;
		font-weight: 600;
	}

	/* Orders List */
	.orders-list {
		display: flex;
		flex-direction: column;
		gap: 25px;
	}

	.order-card {
		background: #fff;
		border-radius: 20px;
		overflow: hidden;
		box-shadow: 0 5px 20px rgba(0,0,0,0.08);
		transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
		border: 2px solid transparent;
	}
	.order-card:hover {
		border-color: #76a713;
		box-shadow: 0 10px 40px rgba(118, 167, 19, 0.15);
		transform: translateY(-5px);
	}

	.order-card-header {
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		padding: 25px 30px;
		display: flex;
		justify-content: space-between;
		align-items: center;
		position: relative;
		overflow: hidden;
	}
	.order-card-header::before {
		content: '';
		position: absolute;
		top: -50%;
		right: -50%;
		width: 200%;
		height: 200%;
		background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
		animation: rotate 20s linear infinite;
	}

	.order-label {
		display: block;
		font-size: 12px;
		color: rgba(255,255,255,0.8);
		margin-bottom: 5px;
		text-transform: uppercase;
		letter-spacing: 1px;
	}
	.order-code {
		font-size: 24px;
		font-weight: 800;
		color: #fff;
		margin: 0;
		text-shadow: 0 2px 10px rgba(0,0,0,0.2);
	}

	.payment-status-badge {
		display: flex;
		align-items: center;
		gap: 10px;
		padding: 10px 20px;
		border-radius: 25px;
		font-weight: 700;
		font-size: 13px;
		backdrop-filter: blur(10px);
		box-shadow: 0 4px 15px rgba(0,0,0,0.2);
	}
	.payment-status-badge.paid {
		background: rgba(40, 167, 69, 0.9);
		color: #fff;
	}
	.payment-status-badge.pending {
		background: rgba(255, 193, 7, 0.9);
		color: #856404;
	}

	.order-card-body {
		padding: 30px;
	}

	.order-info-grid {
		display: grid;
		grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
		gap: 20px;
		margin-bottom: 25px;
	}
	.info-item-order {
		display: flex;
		align-items: center;
		gap: 15px;
		padding: 20px;
		background: #f8f9fa;
		border-radius: 12px;
		border: 2px solid #e8e8e8;
		transition: all 0.3s ease;
	}
	.info-item-order:hover {
		background: #fff;
		border-color: #76a713;
		box-shadow: 0 4px 15px rgba(118, 167, 19, 0.1);
		transform: translateX(5px);
	}

	.info-icon-order {
		flex-shrink: 0;
		width: 50px;
		height: 50px;
		display: flex;
		align-items: center;
		justify-content: center;
		border-radius: 12px;
		font-size: 22px;
		color: #fff;
		transition: all 0.3s ease;
	}
	.info-icon-order.payment { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
	.info-icon-order.date { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
	.info-icon-order.amount { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
	.info-icon-order.shipping { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

	.info-item-order:hover .info-icon-order {
		transform: scale(1.1) rotate(5deg);
	}

	.info-text-order label {
		display: block;
		font-size: 12px;
		color: #6c757d;
		margin-bottom: 5px;
		font-weight: 600;
		text-transform: uppercase;
		letter-spacing: 0.5px;
	}
	.info-text-order span {
		display: block;
		font-size: 15px;
		color: #2c3e50;
		font-weight: 600;
	}
	.amount-value {
		font-size: 18px !important;
		font-weight: 700 !important;
		color: #76a713 !important;
	}

	/* Price Details Toggle */
	.price-details-toggle {
		margin-top: 20px;
		padding-top: 20px;
		border-top: 2px dashed #e8e8e8;
	}
	.toggle-btn {
		width: 100%;
		padding: 15px;
		background: #f8f9fa;
		border: 2px solid #e8e8e8;
		border-radius: 10px;
		cursor: pointer;
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 10px;
		font-weight: 600;
		color: #2c3e50;
		transition: all 0.3s ease;
	}
	.toggle-btn:hover {
		background: #76a713;
		color: #fff;
		border-color: #76a713;
	}
	.toggle-btn i {
		transition: transform 0.3s ease;
	}
	.toggle-btn.active i {
		transform: rotate(180deg);
	}

	.price-details-content {
		max-height: 0;
		overflow: hidden;
		transition: max-height 0.4s ease-out;
		padding: 0 15px;
	}
	.price-details-content.active {
		max-height: 200px;
		padding: 20px 15px 0;
	}
	.price-row {
		display: flex;
		justify-content: space-between;
		padding: 12px 0;
		font-size: 15px;
		color: #6c757d;
	}
	.price-row.total {
		font-size: 18px;
		color: #2c3e50;
		padding-top: 15px;
	}
	.price-divider {
		height: 2px;
		background: linear-gradient(90deg, transparent, #76a713, transparent);
		margin: 10px 0;
	}
	.total-amount {
		font-size: 20px !important;
		color: #76a713 !important;
	}

	/* Order Card Footer */
	.order-card-footer {
		padding: 0 30px 30px;
	}
	.btn-view-order {
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 10px;
		width: 100%;
		padding: 16px;
		background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
		color: #fff;
		text-decoration: none;
		border-radius: 12px;
		font-weight: 700;
		font-size: 16px;
		transition: all 0.3s ease;
		box-shadow: 0 4px 15px rgba(118, 167, 19, 0.3);
		position: relative;
		overflow: hidden;
	}
	.btn-view-order::before {
		content: '';
		position: absolute;
		top: 0;
		left: -100%;
		width: 100%;
		height: 100%;
		background: rgba(255,255,255,0.2);
		transition: left 0.5s ease;
	}
	.btn-view-order:hover::before {
		left: 100%;
	}
	.btn-view-order:hover {
		transform: translateY(-2px);
		box-shadow: 0 6px 20px rgba(118, 167, 19, 0.4);
	}
	.btn-view-order .ms-2 {
		transition: transform 0.3s ease;
	}
	.btn-view-order:hover .ms-2 {
		transform: translateX(5px);
	}

	/* Empty State */
	.empty-orders-state {
		text-align: center;
		padding: 80px 30px;
		background: #fff;
		border-radius: 20px;
		box-shadow: 0 5px 20px rgba(0,0,0,0.08);
		animation: fadeIn 0.6s ease-out;
	}
	.empty-icon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 150px;
		height: 150px;
		border-radius: 50%;
		background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
		margin-bottom: 30px;
		animation: bounce 2s infinite;
	}
	.empty-icon i {
		font-size: 80px;
		color: #76a713;
	}
	.empty-orders-state h3 {
		font-size: 28px;
		font-weight: 700;
		color: #2c3e50;
		margin-bottom: 15px;
	}
	.empty-orders-state p {
		font-size: 16px;
		color: #6c757d;
		margin-bottom: 30px;
	}

	/* Animations */
	@keyframes slideDown {
		from {
			opacity: 0;
			transform: translateY(-30px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}
	@keyframes fadeIn {
		from { opacity: 0; }
		to { opacity: 1; }
	}
	@keyframes rotate {
		from { transform: rotate(0deg); }
		to { transform: rotate(360deg); }
	}
	@keyframes bounce {
		0%, 100% { transform: translateY(0); }
		50% { transform: translateY(-20px); }
	}

	/* AOS Animation Support */
	[data-aos="fade-up"] {
		opacity: 0;
		transform: translateY(30px);
		transition: opacity 0.6s ease-out, transform 0.6s ease-out;
	}
	[data-aos="fade-up"].aos-animate {
		opacity: 1;
		transform: translateY(0);
	}

	/* Responsive */
	@media (max-width: 991px) {
		.order-info-grid {
			grid-template-columns: repeat(2, 1fr);
		}
	}
	@media (max-width: 768px) {
		.action-card {
			padding: 20px 10px;
		}
		.action-card i {
			font-size: 28px;
		}
		.action-card span {
			font-size: 12px;
		}
		.stat-card {
			flex-direction: column;
			text-align: center;
		}
		.order-card-header {
			flex-direction: column;
			gap: 15px;
			text-align: center;
		}
		.order-info-grid {
			grid-template-columns: 1fr;
		}
		.stat-icon {
			width: 60px;
			height: 60px;
			font-size: 28px;
		}
		.stat-content h4 {
			font-size: 30px;
		}
	}
</style>

<script>
	// Price Details Toggle
	function togglePriceDetails(btn) {
		const content = btn.nextElementSibling;
		const icon = btn.querySelector('i');
		const text = btn.querySelector('span');

		btn.classList.toggle('active');
		content.classList.toggle('active');

		if(content.classList.contains('active')) {
			text.textContent = 'Fiyat Detaylarini Gizle';
		} else {
			text.textContent = 'Fiyat Detaylarini Goster';
		}
	}

	// Simple AOS-like Animation on Scroll
	document.addEventListener('DOMContentLoaded', function() {
		const observerOptions = {
			threshold: 0.1,
			rootMargin: '0px 0px -50px 0px'
		};

		const observer = new IntersectionObserver(function(entries) {
			entries.forEach(entry => {
				if (entry.isIntersecting) {
					entry.target.classList.add('aos-animate');
				}
			});
		}, observerOptions);

		document.querySelectorAll('[data-aos]').forEach(el => {
			observer.observe(el);
		});
	});
</script>

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
