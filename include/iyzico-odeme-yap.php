<?php
$siparisKodu=$sipariskodu;

/***********************************************/

include_once('IyzipayBootstrap.php');

IyzipayBootstrap::init();

class Config
{
    public static function options()
    {
        $options = new \Iyzipay\Options();
        $options->setApiKey("xxxx");
        $options->setSecretKey("xxxx");
        $options->setBaseUrl("xxxx");
        return $options;
    }
}

$ilBilgisi=$VT->VeriGetir("il","WHERE ID=?",array($uyebilgisi[0]["ilID"]),"ORDER BY ID ASC",1);
if($ilBilgisi!=false){$ilAdi=$ilBilgisi[0]["ADI"];}else{$ilAdi="Belirtilmedi";}

if($uyebilgisi[0]["tipi"]==1)
{
	/*Bireysel bir üye ise*/
	$buyer = new \Iyzipay\Model\Buyer();
	$buyer->setId("ETC".$uyebilgisi[0]["ID"]."");
	$buyer->setName("".$uyebilgisi[0]["ad"]."");
	$buyer->setSurname("".$uyebilgisi[0]["soyad"]."");
	$buyer->setGsmNumber("+90".$uyebilgisi[0]["telefon"]."");
	$buyer->setEmail("".$uyebilgisi[0]["mail"]."");
	$buyer->setIdentityNumber("".rand(1000,9999).$uyebilgisi[0]["ID"]."");
	$buyer->setLastLoginDate("2015-10-05 12:43:35"); /*date("Y-m-d H:i:s")*/
	$buyer->setRegistrationDate("2013-04-21 15:12:09");
	$buyer->setRegistrationAddress("".$uyebilgisi[0]["adres"]." ".$uyebilgisi[0]["ilce"]."");
	$buyer->setIp("85.34.78.112");
	$buyer->setCity("".$ilAdi."");
	$buyer->setCountry("Turkey");
	$buyer->setZipCode("".$uyebilgisi[0]["postakodu"]."");

	$shippingAddress = new \Iyzipay\Model\Address();
$shippingAddress->setContactName("".$uyebilgisi[0]["ad"]." ".$uyebilgisi[0]["soyad"]."");
$shippingAddress->setCity("".$ilAdi."");
$shippingAddress->setCountry("Turkey");
$shippingAddress->setAddress("".$uyebilgisi[0]["adres"]." ".$uyebilgisi[0]["ilce"]."");
$shippingAddress->setZipCode("".$uyebilgisi[0]["postakodu"]."");


$billingAddress = new \Iyzipay\Model\Address();
$billingAddress->setContactName("".$uyebilgisi[0]["ad"]." ".$uyebilgisi[0]["soyad"]."");
$billingAddress->setCity("".$ilAdi."");
$billingAddress->setCountry("Turkey");
$billingAddress->setAddress("".$uyebilgisi[0]["adres"]." ".$uyebilgisi[0]["ilce"]."");
$billingAddress->setZipCode("".$uyebilgisi[0]["postakodu"]."");

}
else
{
	/*Kurumsal bir üye ise*/
	$buyer = new \Iyzipay\Model\Buyer();
	$buyer->setId("ETC".$uyebilgisi[0]["ID"]."");
	$buyer->setName("".$uyebilgisi[0]["firmaadi"]."");
	$buyer->setSurname("".$uyebilgisi[0]["vergino"]."");
	$buyer->setGsmNumber("+90".$uyebilgisi[0]["telefon"]."");
	$buyer->setEmail("".$uyebilgisi[0]["mail"]."");
	$buyer->setIdentityNumber("".rand(1000,9999).$uyebilgisi[0]["ID"]."");
	$buyer->setLastLoginDate("2015-10-05 12:43:35"); /*date("Y-m-d H:i:s")*/
	$buyer->setRegistrationDate("2013-04-21 15:12:09");
	$buyer->setRegistrationAddress("".$uyebilgisi[0]["adres"]." ".$uyebilgisi[0]["ilce"]."");
	$buyer->setIp("85.34.78.112");
	$buyer->setCity("".$ilAdi."");
	$buyer->setCountry("Turkey");
	$buyer->setZipCode("".$uyebilgisi[0]["postakodu"]."");

	$shippingAddress = new \Iyzipay\Model\Address();
$shippingAddress->setContactName("".$uyebilgisi[0]["firmaadi"]."");
$shippingAddress->setCity("".$ilAdi."");
$shippingAddress->setCountry("Turkey");
$shippingAddress->setAddress("".$uyebilgisi[0]["adres"]." ".$uyebilgisi[0]["ilce"]."");
$shippingAddress->setZipCode("".$uyebilgisi[0]["postakodu"]."");


$billingAddress = new \Iyzipay\Model\Address();
$billingAddress->setContactName("".$uyebilgisi[0]["firmaadi"]."");
$billingAddress->setCity("".$ilAdi."");
$billingAddress->setCountry("Turkey");
$billingAddress->setAddress("".$uyebilgisi[0]["adres"]." ".$uyebilgisi[0]["ilce"]."");
$billingAddress->setZipCode("".$uyebilgisi[0]["postakodu"]."");
}

$globalsayac=0;
$basketItems = array();
$priceTutar=0;
/****************************************************/
foreach ($_SESSION["sepet"] as $urunID => $bilgi) {
								$urunbilgisi=$VT->VeriGetir("urunler","WHERE durum=? AND ID=?",array(1,$urunID),"ORDER BY ID ASC",1);
								if($urunbilgisi!=false)
								{

									if($bilgi["varyasyondurumu"]!=false)
									{
					if(!empty($_SESSION["sepetVaryasyon"]))
					{
						foreach ($_SESSION["sepetVaryasyon"][$urunbilgisi[0]["ID"]] as $secenekID => $secenekAdet) {

							$stokTablo=$VT->VeriGetir("urunvaryasyonstoklari","WHERE ID=? AND urunID=?",array($secenekID,$urunbilgisi[0]["ID"]),"ORDER BY ID ASC",1);
							if($stokTablo!=false)
							{
								$varyasyonOzellikleri="";
								$varyasyonID=$stokTablo[0]["varyasyonID"];
								$secimID=$stokTablo[0]["secenekID"];

								if(!empty($urunbilgisi[0]["indirimlifiyat"]))
							{
								$fiyat=$urunbilgisi[0]["indirimlifiyat"].".".$urunbilgisi[0]["indirimlikurus"];
								if($urunbilgisi[0]["kdvdurum"]==1)
								{
									if($urunbilgisi[0]["kdvoran"]>9)
									{
										$oran="1.".$urunbilgisi[0]["kdvoran"];
									}
									else
									{
										$oran="1.0".$urunbilgisi[0]["kdvoran"];
									}
									$kdvsizBirimfiyat=($fiyat/$oran);/*kdvsiz hali*/
								}
								else
								{
									$kdvsizBirimfiyat=$fiyat;
								}
							}
							else
							{
								$fiyat=$urunbilgisi[0]["fiyat"].".".$urunbilgisi[0]["kurus"];
								if($urunbilgisi[0]["kdvdurum"]==1)
								{
									if($urunbilgisi[0]["kdvoran"]>9)
									{
										$oran="1.".$urunbilgisi[0]["kdvoran"];
									}
									else
									{
										$oran="1.0".$urunbilgisi[0]["kdvoran"];
									}
									$kdvsizBirimfiyat=($fiyat/$oran);/*kdvsiz hali*/
								}
								else
								{
									$kdvsizBirimfiyat=$fiyat;
								}
							}
								$toplamFiyat=($kdvsizBirimfiyat*$secenekAdet["adet"]);

$kategoriBilgisi=$VT->VeriGetir("kategoriler","WHERE ID=?",array($urunbilgisi[0]["kategori"]),"ORDER BY ID ASC",1);
	$firstBasketItem = new \Iyzipay\Model\BasketItem();
$firstBasketItem->setId("".$urunbilgisi[0]["urunkodu"]."");
$firstBasketItem->setName("".$urunbilgisi[0]["baslik"]."");
$firstBasketItem->setCategory1("".$kategoriBilgisi[0]["baslik"]."");
$firstBasketItem->setCategory2("".$kategoriBilgisi[0]["baslik"]."");
$firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
$firstBasketItem->setPrice("".number_format($toplamFiyat,2,".","")."");
$basketItems[$globalsayac] = $firstBasketItem;
$globalsayac++;
$priceTutar=($priceTutar+number_format($toplamFiyat,2,".",""));

									$toplamtutar=($fiyat*$secenekAdet["adet"]);


							if($urunbilgisi[0]["kdvdurum"]==1)
							{
								/*KDV li fiyat*/

								if($urunbilgisi[0]["kdvoran"]>9)
								{
									$oran="1.".$urunbilgisi[0]["kdvoran"];
								}
								else
								{
									$oran="1.0".$urunbilgisi[0]["kdvoran"];
								}
								$kdvlifiyat=$toplamtutar;
								$kdvsizfiyat=($toplamtutar/$oran);/*kdvsiz hali*/
								$kdvtutari=($toplamtutar-$kdvsizfiyat);/*KDV Fiyatı*/
								if($urunbilgisi[0]["kdvoran"]==18){$sepetkdvtutar18=($sepetkdvtutar18+$kdvtutari);}
								if($urunbilgisi[0]["kdvoran"]==8){$sepetkdvtutar8=($sepetkdvtutar8+$kdvtutari);}
								if($urunbilgisi[0]["kdvoran"]==6){$sepetkdvtutar6=($sepetkdvtutar6+$kdvtutari);}
								if($urunbilgisi[0]["kdvoran"]==1){$sepetkdvtutar1=($sepetkdvtutar1+$kdvtutari);}
								$sepetkdvharictutar=($sepetkdvharictutar+$kdvsizfiyat);
								$sepetTutar=($sepetTutar+$kdvlifiyat);
							}
							else
							{
								/*KDV Hariç Fiyat*/
								$oran=$urunbilgisi[0]["kdvoran"];
								$kdvsizfiyat=$toplamtutar;
								$kdvtutari=(($kdvsizfiyat*$oran)/100);
								$kdvlifiyat=($kdvsizfiyat+$kdvtutari);
								if($urunbilgisi[0]["kdvoran"]==18){$sepetkdvtutar18=($sepetkdvtutar18+$kdvtutari);}
								if($urunbilgisi[0]["kdvoran"]==8){$sepetkdvtutar8=($sepetkdvtutar8+$kdvtutari);}
								if($urunbilgisi[0]["kdvoran"]==6){$sepetkdvtutar6=($sepetkdvtutar6+$kdvtutari);}
								if($urunbilgisi[0]["kdvoran"]==1){$sepetkdvtutar1=($sepetkdvtutar1+$kdvtutari);}
								$sepetkdvharictutar=($sepetkdvharictutar+$kdvsizfiyat);
								$sepetTutar=($sepetTutar+$kdvlifiyat);
							}

							}


						}
					}
									}
									else
									{

							if(!empty($urunbilgisi[0]["indirimlifiyat"]))
							{
								$fiyat=$urunbilgisi[0]["indirimlifiyat"].".".$urunbilgisi[0]["indirimlikurus"];
								if($urunbilgisi[0]["kdvdurum"]==1)
								{
									if($urunbilgisi[0]["kdvoran"]>9)
									{
										$oran="1.".$urunbilgisi[0]["kdvoran"];
									}
									else
									{
										$oran="1.0".$urunbilgisi[0]["kdvoran"];
									}
									$kdvsizBirimfiyat=($fiyat/$oran);/*kdvsiz hali*/
								}
								else
								{
									$kdvsizBirimfiyat=$fiyat;
								}
							}
							else
							{
								$fiyat=$urunbilgisi[0]["fiyat"].".".$urunbilgisi[0]["kurus"];
								if($urunbilgisi[0]["kdvdurum"]==1)
								{
									if($urunbilgisi[0]["kdvoran"]>9)
									{
										$oran="1.".$urunbilgisi[0]["kdvoran"];
									}
									else
									{
										$oran="1.0".$urunbilgisi[0]["kdvoran"];
									}
									$kdvsizBirimfiyat=($fiyat/$oran);/*kdvsiz hali*/
								}
								else
								{
									$kdvsizBirimfiyat=$fiyat;
								}
							}
								$toplamFiyat=($kdvsizBirimfiyat*$bilgi["adet"]);

				$kategoriBilgisi=$VT->VeriGetir("kategoriler","WHERE ID=?",array($urunbilgisi[0]["kategori"]),"ORDER BY ID ASC",1);
	$firstBasketItem = new \Iyzipay\Model\BasketItem();
$firstBasketItem->setId("".$urunbilgisi[0]["urunkodu"]."");
$firstBasketItem->setName("".$urunbilgisi[0]["baslik"]."");
$firstBasketItem->setCategory1("".$kategoriBilgisi[0]["baslik"]."");
$firstBasketItem->setCategory2("".$kategoriBilgisi[0]["baslik"]."");
$firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
$firstBasketItem->setPrice("".number_format($toplamFiyat,2,".","")."");
$basketItems[$globalsayac] = $firstBasketItem;
$globalsayac++;
$priceTutar=($priceTutar+number_format($toplamFiyat,2,".",""));


							$toplamtutar=($fiyat*$bilgi["adet"]);


							if($urunbilgisi[0]["kdvdurum"]==1)
							{
								/*KDV li fiyat*/
								if($urunbilgisi[0]["kdvoran"]>9)
								{
									$oran="1.".$urunbilgisi[0]["kdvoran"];
								}
								else
								{
									$oran="1.0".$urunbilgisi[0]["kdvoran"];
								}
								$kdvlifiyat=$toplamtutar;
								$kdvsizfiyat=($toplamtutar/$oran);/*kdvsiz hali*/
								$kdvtutari=($toplamtutar-$kdvsizfiyat);/*KDV Fiyatı*/
								if($urunbilgisi[0]["kdvoran"]==18){$sepetkdvtutar18=($sepetkdvtutar18+$kdvtutari);}
								if($urunbilgisi[0]["kdvoran"]==8){$sepetkdvtutar8=($sepetkdvtutar8+$kdvtutari);}
								if($urunbilgisi[0]["kdvoran"]==6){$sepetkdvtutar6=($sepetkdvtutar6+$kdvtutari);}
								if($urunbilgisi[0]["kdvoran"]==1){$sepetkdvtutar1=($sepetkdvtutar1+$kdvtutari);}
								$sepetkdvharictutar=($sepetkdvharictutar+$kdvsizfiyat);
								$sepetTutar=($sepetTutar+$kdvlifiyat);
							}
							else
							{
								/*KDV Hariç Fiyat*/
								$oran=$urunbilgisi[0]["kdvoran"];
								$kdvsizfiyat=$toplamtutar;
								$kdvtutari=(($kdvsizfiyat*$oran)/100);
								$kdvlifiyat=($kdvsizfiyat+$kdvtutari);
								if($urunbilgisi[0]["kdvoran"]==18){$sepetkdvtutar18=($sepetkdvtutar18+$kdvtutari);}
								if($urunbilgisi[0]["kdvoran"]==8){$sepetkdvtutar8=($sepetkdvtutar8+$kdvtutari);}
								if($urunbilgisi[0]["kdvoran"]==6){$sepetkdvtutar6=($sepetkdvtutar6+$kdvtutari);}
								if($urunbilgisi[0]["kdvoran"]==1){$sepetkdvtutar1=($sepetkdvtutar1+$kdvtutari);}
								$sepetkdvharictutar=($sepetkdvharictutar+$kdvsizfiyat);
								$sepetTutar=($sepetTutar+$kdvlifiyat);
							}

									}


								}
							}

		$genelKDVTutar=0;
				if($sepetkdvtutar1>0)
				{
					$genelKDVTutar=($genelKDVTutar+$sepetkdvtutar1);

				}
				if($sepetkdvtutar6>0)
				{
					$genelKDVTutar=($genelKDVTutar+$sepetkdvtutar6);
				}
				if($sepetkdvtutar8>0)
				{
					$genelKDVTutar=($genelKDVTutar+$sepetkdvtutar8);
				}
				if($sepetkdvtutar18>0)
				{
					$genelKDVTutar=($genelKDVTutar+$sepetkdvtutar18);
				}

			$_SESSION["siparisKodu"]=$sipariskodu;

/***************************************************/

$request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
$request->setLocale(\Iyzipay\Model\Locale::TR);
$request->setConversationId("".$siparisKodu."");
$request->setPrice("".number_format($priceTutar,2,".","").""); /*kdvsiz hali*/
$request->setPaidPrice("".number_format($sepetTutar,2,".","")."");/*ödenecek tutar*/
$request->setCurrency(\Iyzipay\Model\Currency::TL);
$request->setBasketId("".$siparisKodu."");
$request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
$request->setCallbackUrl("http://localhost/eticaret/kk-odeme-sonuc");
$request->setEnabledInstallments(array(2, 3, 6, 9));
$request->setBuyer($buyer);
$request->setShippingAddress($shippingAddress);
$request->setBillingAddress($billingAddress);
$request->setBasketItems($basketItems);

$checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, Config::options());
?>

<!--==============================
Breadcumb
============================== -->
<div class="breadcumb-wrapper breadcumb-layout1 bg-fluid pt-200 pb-200" data-bg-src="assets/img/breadcumb/breadcumb-img-1.jpg">
	<div class="container">
		<div class="breadcumb-content text-center">
			<h1 class="breadcumb-title">Guvenli Odeme</h1>
			<ul class="breadcumb-menu-style1 mx-auto">
				<li><a href="<?=SITE?>">Anasayfa</a></li>
				<li><a href="<?=SITE?>sepet">Sepet</a></li>
				<li class="active">Odeme</li>
			</ul>
		</div>
	</div>
</div>

<!--==============================
	Payment Section
==============================-->
<section class="space-top space-md-bottom">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-10">
				<!-- Payment Info Box -->
				<div class="payment-info-box bg-white p-4 mb-4 shadow-sm rounded">
					<div class="row align-items-center">
						<div class="col-md-8">
							<h5 class="mb-2">
								<i class="far fa-shield-check me-2 text-success"></i>
								Guvenli Odeme Sayfasina Yonlendiriliyorsunuz
							</h5>
							<p class="mb-0 text-muted">Odeme bilgileriniz SSL sertifikasi ile sifrelenmektedir.</p>
						</div>
						<div class="col-md-4 text-md-end mt-3 mt-md-0">
							<div class="payment-badges">
								<img src="<?=SITE?>assets/img/payment/ssl-secure.png" alt="SSL Secure" class="img-fluid" style="max-height: 50px;">
							</div>
						</div>
					</div>
				</div>

				<!-- Order Summary -->
				<div class="order-summary-box bg-white p-4 mb-4 shadow-sm rounded">
					<h5 class="mb-3 pb-3 border-bottom">
						<i class="far fa-shopping-cart me-2"></i>Siparis Ozeti
					</h5>
					<div class="row">
						<div class="col-md-6 mb-3">
							<div class="summary-item">
								<span class="summary-label">Siparis Kodu:</span>
								<span class="summary-value fw-bold"><?=$siparisKodu?></span>
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<div class="summary-item">
								<span class="summary-label">Odeme Tutari:</span>
								<span class="summary-value fw-bold text-success"><?=number_format($sepetTutar,2,",",".")?> TL</span>
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<div class="summary-item">
								<span class="summary-label">Musteri:</span>
								<span class="summary-value">
									<?php
									if($uyebilgisi[0]["tipi"]==1) {
										echo stripslashes($uyebilgisi[0]["ad"]." ".$uyebilgisi[0]["soyad"]);
									} else {
										echo stripslashes($uyebilgisi[0]["firmaadi"]);
									}
									?>
								</span>
							</div>
						</div>
						<div class="col-md-6 mb-3">
							<div class="summary-item">
								<span class="summary-label">E-posta:</span>
								<span class="summary-value"><?=$uyebilgisi[0]["mail"]?></span>
							</div>
						</div>
					</div>
				</div>

				<!-- Error Message Display -->
				<?php if(!empty($checkoutFormInitialize->getErrorMessage())) { ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<i class="far fa-exclamation-triangle me-2"></i>
					<strong>Hata:</strong> <?=$checkoutFormInitialize->getErrorMessage()?>
					<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
				</div>
				<?php } ?>

				<!-- Iyzico Payment Frame -->
				<div class="payment-frame-wrapper bg-white p-4 shadow-sm rounded">
					<div class="text-center mb-4">
						<h5 class="mb-3">
							<i class="far fa-credit-card me-2"></i>Kart Bilgilerinizi Giriniz
						</h5>
						<div class="payment-logos d-flex justify-content-center align-items-center gap-3 mb-3">
							<img src="<?=SITE?>assets/img/payment/visa.png" alt="Visa" style="height: 30px;">
							<img src="<?=SITE?>assets/img/payment/mastercard.png" alt="Mastercard" style="height: 30px;">
							<img src="<?=SITE?>assets/img/payment/amex.png" alt="Amex" style="height: 30px;">
						</div>
						<p class="text-muted small">
							<i class="far fa-info-circle me-1"></i>
							Tum odemeler iyzico guvenli odeme altyapisi ile gerceklestirilmektedir.
						</p>
					</div>

					<!-- Iyzico Checkout Form -->
					<div id="iyzipay-checkout-form" class="responsive">
						<?php
						if(!empty($checkoutFormInitialize->getCheckoutFormContent())) {
							echo $checkoutFormInitialize->getCheckoutFormContent();
						}
						?>
					</div>

					<!-- Loading Overlay -->
					<div id="payment-loading" style="display: none;">
						<div class="text-center py-5">
							<div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;">
								<span class="visually-hidden">Yukleniyor...</span>
							</div>
							<p class="mt-3 text-muted">Odeme formu yukleniyor...</p>
						</div>
					</div>
				</div>

				<!-- Security Notice -->
				<div class="security-notice mt-4 text-center">
					<div class="d-flex justify-content-center align-items-center gap-4 flex-wrap">
						<div class="security-badge">
							<i class="far fa-lock text-success"></i>
							<span class="ms-2 small">256-bit SSL Sifreleme</span>
						</div>
						<div class="security-badge">
							<i class="far fa-shield-check text-success"></i>
							<span class="ms-2 small">PCI DSS Uyumlu</span>
						</div>
						<div class="security-badge">
							<i class="far fa-check-circle text-success"></i>
							<span class="ms-2 small">3D Secure Korunmali</span>
						</div>
					</div>
				</div>

				<!-- Help Box -->
				<div class="help-box bg-light p-4 rounded mt-4">
					<div class="row align-items-center">
						<div class="col-md-8">
							<h6 class="mb-2">
								<i class="far fa-question-circle me-2"></i>Odeme sirasinda sorun mu yasiyorsunuz?
							</h6>
							<p class="mb-0 small text-muted">Musteri hizmetlerimiz size yardimci olmaktan mutluluk duyar.</p>
						</div>
						<div class="col-md-4 text-md-end mt-3 mt-md-0">
							<a href="<?=SITE?>iletisim" class="vs-btn style4 btn-sm">
								<i class="far fa-headset me-2"></i>Iletisim
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<style>
	.payment-info-box {
		border-left: 4px solid #4caf50;
	}
	.payment-info-box h5 {
		color: #333;
		font-weight: 700;
	}
	.payment-badges img {
		opacity: 0.8;
		transition: all 0.3s;
	}
	.payment-badges img:hover {
		opacity: 1;
	}
	.order-summary-box h5 {
		color: #333;
		font-weight: 700;
	}
	.summary-item {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 10px;
		background: #f8f9fa;
		border-radius: 6px;
	}
	.summary-label {
		color: #666;
		font-size: 14px;
	}
	.summary-value {
		color: #333;
		font-size: 14px;
	}
	.payment-frame-wrapper {
		border: 2px solid #e8e8e8;
		min-height: 400px;
	}
	.payment-frame-wrapper h5 {
		color: #333;
		font-weight: 700;
	}
	.payment-logos img {
		filter: grayscale(100%);
		opacity: 0.7;
		transition: all 0.3s;
	}
	.payment-logos img:hover {
		filter: grayscale(0%);
		opacity: 1;
	}
	#iyzipay-checkout-form {
		min-height: 300px;
	}
	#iyzipay-checkout-form.responsive {
		width: 100% !important;
	}
	#payment-loading {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background: rgba(255,255,255,0.95);
		z-index: 999;
	}
	.security-badge {
		display: inline-flex;
		align-items: center;
		padding: 10px 15px;
		background: #f8f9fa;
		border-radius: 6px;
	}
	.security-badge i {
		font-size: 18px;
	}
	.help-box {
		border: 1px solid #dee2e6;
	}
	.help-box h6 {
		color: #333;
		font-weight: 700;
	}
	.alert {
		border-radius: 8px;
	}
	@media (max-width: 768px) {
		.payment-info-box h5 {
			font-size: 16px;
		}
		.order-summary-box h5 {
			font-size: 16px;
		}
		.summary-item {
			flex-direction: column;
			align-items: flex-start;
			gap: 5px;
		}
		.payment-frame-wrapper {
			padding: 20px 15px !important;
		}
		.security-badge {
			font-size: 12px;
			padding: 8px 12px;
		}
	}
</style>

<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Show loading while iframe loads
		const iyzicoFrame = document.getElementById('iyzipay-checkout-form');
		const loadingOverlay = document.getElementById('payment-loading');

		if(iyzicoFrame && loadingOverlay) {
			// Check if iframe is loading
			const observer = new MutationObserver(function(mutations) {
				mutations.forEach(function(mutation) {
					if(mutation.addedNodes.length > 0) {
						loadingOverlay.style.display = 'none';
					}
				});
			});

			observer.observe(iyzicoFrame, {
				childList: true,
				subtree: true
			});

			// Hide loading after 3 seconds anyway
			setTimeout(function() {
				loadingOverlay.style.display = 'none';
			}, 3000);
		}

		// Warn before leaving page
		window.addEventListener('beforeunload', function(e) {
			e.preventDefault();
			e.returnValue = 'Odeme isleminiz devam ediyor. Sayfadan ayrilmak istediginize emin misiniz?';
		});
	});
</script>
