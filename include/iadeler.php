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
					<h1 class="breadcumb-title">Iade Takibi</h1>
					<ul class="breadcumb-menu-style1 mx-auto">
						<li><a href="<?=SITE?>">Anasayfa</a></li>
						<li class="active">Iadeler</li>
					</ul>
				</div>
			</div>
		</div>

		<!--==============================
			Account Menu Area
		==============================-->
		<section class="space-top space-md-bottom">
			<div class="container">
				<!-- Account Menu Boxes -->
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
						<a href="<?=SITE?>iadeler" class="account-menu-box text-center active">
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
					Returns List
				==============================-->
				<div class="row">
					<div class="col-12">
						<div class="bg-white p-4 p-md-5 shadow-sm rounded">
							<div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
								<h3 class="sec-subtitle mb-0">
									<i class="far fa-clipboard-list me-2"></i>Iade Listesi
								</h3>
								<div class="info-text">
									<i class="far fa-info-circle me-2"></i>
									<span>Toplam <strong><?php
									$iadeler=$VT->VeriGetir("iadeler","WHERE uyeID=?",array($uyebilgisi[0]["ID"]),"ORDER BY ID DESC");
									echo $iadeler!=false ? count($iadeler) : 0;
									?></strong> iade talebi</span>
								</div>
							</div>

							<?php
							if($iadeler!=false)
							{
								?>
								<!-- Desktop Table View -->
								<div class="table-responsive d-none d-lg-block">
									<table class="table table-hover align-middle">
										<thead class="table-light">
											<tr>
												<th width="15%">IADE KODU</th>
												<th width="40%">ACIKLAMA</th>
												<th width="15%" class="text-center">DURUM</th>
												<th width="15%">TARIH</th>
												<th width="15%" class="text-center">ISLEMLER</th>
											</tr>
										</thead>
										<tbody>
											<?php
											for($i=0;$i<count($iadeler);$i++)
											{
												?>
												<tr>
													<td>
														<span class="return-code">
															<i class="far fa-barcode me-2"></i><?=$iadeler[$i]["iadekodu"]?>
														</span>
													</td>
													<td>
														<div class="return-description">
															<?=mb_substr(stripslashes($iadeler[$i]["metin"]),0,80,"UTF-8")?>...
														</div>
													</td>
													<td class="text-center">
														<?php
														if($iadeler[$i]["durum"]==1)
														{
															?>
															<span class="badge badge-warning">
																<i class="far fa-clock me-1"></i>BEKLIYOR
															</span>
															<?php
														}
														else
														{
															?>
															<span class="badge badge-success">
																<i class="far fa-check-circle me-1"></i>CEVAPLANDI
															</span>
															<?php
														}
														?>
													</td>
													<td>
														<span class="return-date">
															<i class="far fa-calendar me-2"></i><?=date("d.m.Y",strtotime($iadeler[$i]["tarih"]))?>
														</span>
													</td>
													<td class="text-center">
														<a href="<?=SITE?>iade-detay/<?=$iadeler[$i]["iadekodu"]?>" class="vs-btn style4 btn-sm">
															<i class="far fa-eye me-1"></i>Incele
														</a>
													</td>
												</tr>
												<?php
											}
											?>
										</tbody>
									</table>
								</div>

								<!-- Mobile Card View -->
								<div class="d-lg-none">
									<?php
									for($i=0;$i<count($iadeler);$i++)
									{
										?>
										<div class="return-card mb-3">
											<div class="return-card-header">
												<div class="d-flex justify-content-between align-items-center">
													<span class="return-code">
														<i class="far fa-barcode me-2"></i><?=$iadeler[$i]["iadekodu"]?>
													</span>
													<?php
													if($iadeler[$i]["durum"]==1)
													{
														?>
														<span class="badge badge-warning">
															<i class="far fa-clock me-1"></i>BEKLIYOR
														</span>
														<?php
													}
													else
													{
														?>
														<span class="badge badge-success">
															<i class="far fa-check-circle me-1"></i>CEVAPLANDI
														</span>
														<?php
													}
													?>
												</div>
											</div>
											<div class="return-card-body">
												<p class="return-description">
													<?=mb_substr(stripslashes($iadeler[$i]["metin"]),0,100,"UTF-8")?>...
												</p>
												<div class="return-date">
													<i class="far fa-calendar me-2"></i><?=date("d.m.Y",strtotime($iadeler[$i]["tarih"]))?>
												</div>
											</div>
											<div class="return-card-footer">
												<a href="<?=SITE?>iade-detay/<?=$iadeler[$i]["iadekodu"]?>" class="vs-btn style4 w-100">
													<i class="far fa-eye me-2"></i>Detayli Incele
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
								<div class="empty-state text-center py-5">
									<div class="empty-icon mb-4">
										<i class="far fa-inbox"></i>
									</div>
									<h4 class="empty-title mb-3">Henuz Iade Talebiniz Yok</h4>
									<p class="empty-text mb-4">Henuz kayitli bir iade bildiriminiz bulunmamaktadir.</p>
									<a href="<?=SITE?>siparislerim" class="vs-btn style4">
										<i class="far fa-shopping-bag me-2"></i>Siparislerime Git
									</a>
								</div>
								<?php
							}
							?>
						</div>
					</div>
				</div>

				<?php if($iadeler!=false && count($iadeler)>0) { ?>
				<!-- Help Section -->
				<div class="row mt-4">
					<div class="col-12">
						<div class="help-section bg-light p-4 rounded">
							<div class="row align-items-center">
								<div class="col-md-8">
									<h5 class="mb-2">
										<i class="far fa-question-circle me-2"></i>Iade Surecinde Yardima mi Ihtiyaciniz Var?
									</h5>
									<p class="mb-0 text-muted">Iade talepleriniz ile ilgili sorulariniz icin musteri hizmetlerimizle iletisime gecebilirsiniz.</p>
								</div>
								<div class="col-md-4 text-md-end mt-3 mt-md-0">
									<a href="<?=SITE?>iletisim" class="vs-btn style8">
										<i class="far fa-headset me-2"></i>Iletisim
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
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
			.account-menu-box:hover,
			.account-menu-box.active {
				border-color: #76a713;
				transform: translateY(-5px);
				box-shadow: 0 10px 20px rgba(118, 167, 19, 0.1);
			}
			.account-menu-box.active {
				background: linear-gradient(135deg, #76a713 0%, #5a8010 100%);
				color: #fff;
			}
			.account-menu-box.active i {
				color: #fff;
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
			.sec-subtitle {
				font-size: 20px;
				font-weight: 700;
				color: #333;
			}
			.info-text {
				font-size: 14px;
				color: #666;
			}
			.info-text strong {
				color: #76a713;
				font-weight: 700;
			}
			.table th {
				font-weight: 600;
				font-size: 13px;
				text-transform: uppercase;
				color: #333;
				border-bottom: 2px solid #76a713;
				padding: 15px;
			}
			.table td {
				vertical-align: middle;
				padding: 20px 15px;
				border-bottom: 1px solid #f0f0f0;
			}
			.table-hover tbody tr:hover {
				background-color: #f8f9fa;
				transform: scale(1.01);
				transition: all 0.2s;
			}
			.return-code {
				font-weight: 700;
				color: #333;
				font-size: 14px;
				font-family: monospace;
			}
			.return-description {
				color: #555;
				font-size: 14px;
				line-height: 1.6;
			}
			.return-date {
				color: #666;
				font-size: 14px;
			}
			.badge {
				font-size: 12px;
				padding: 6px 12px;
				border-radius: 6px;
				font-weight: 600;
			}
			.badge-warning {
				background: #ff9800;
				color: #fff;
			}
			.badge-success {
				background: #4caf50;
				color: #fff;
			}
			.vs-btn.btn-sm {
				padding: 8px 15px;
				font-size: 13px;
			}
			/* Mobile Card Styles */
			.return-card {
				border: 2px solid #e8e8e8;
				border-radius: 10px;
				overflow: hidden;
				transition: all 0.3s;
			}
			.return-card:hover {
				border-color: #76a713;
				box-shadow: 0 5px 15px rgba(118, 167, 19, 0.1);
			}
			.return-card-header {
				background: #f8f9fa;
				padding: 15px;
				border-bottom: 1px solid #e8e8e8;
			}
			.return-card-body {
				padding: 15px;
			}
			.return-card-body .return-description {
				margin-bottom: 10px;
				color: #555;
			}
			.return-card-body .return-date {
				font-size: 13px;
				color: #666;
			}
			.return-card-footer {
				padding: 15px;
				border-top: 1px solid #e8e8e8;
				background: #fafafa;
			}
			/* Empty State */
			.empty-state {
				padding: 60px 20px;
			}
			.empty-icon i {
				font-size: 80px;
				color: #ddd;
			}
			.empty-title {
				font-size: 22px;
				color: #333;
				font-weight: 700;
			}
			.empty-text {
				font-size: 15px;
				color: #666;
			}
			/* Help Section */
			.help-section {
				background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
				border: 1px solid #dee2e6;
			}
			.help-section h5 {
				color: #333;
				font-weight: 700;
			}
			.vs-btn.style8 {
				background: #76a713;
				color: #fff;
				padding: 12px 30px;
			}
			.vs-btn.style8:hover {
				background: #5a8010;
			}
			@media (max-width: 768px) {
				.account-menu-box {
					padding: 15px 5px;
				}
				.account-menu-box i {
					font-size: 24px;
				}
				.account-menu-box h5 {
					font-size: 12px;
				}
				.sec-subtitle {
					font-size: 18px;
				}
				.info-text {
					font-size: 12px;
				}
				.empty-icon i {
					font-size: 60px;
				}
				.empty-title {
					font-size: 18px;
				}
				.empty-text {
					font-size: 14px;
				}
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
