<?php
@session_start();
@ob_start();
header('Set-Cookie: same-site-cookie=foo; SameSite=Lax');
header('Set-Cookie: cross-site-cookie=bar; SameSite=None; Secure');
define("DATA","data/");
define("SAYFA","include/");
define("SINIF","admin/class/");
include_once(DATA."baglanti.php");
define("SITE",$siteurl);
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

$token=$_POST['token'];
$siparis_no=$_SESSION["siparisKodu"];

$request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
$request->setLocale(\Iyzipay\Model\Locale::TR);
$request->setConversationId("$siparis_no");
$request->setToken("$token");
$checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, Config::options());

//print_r($checkoutForm->getStatus());
echo $odeme_durum=$checkoutForm->getPaymentStatus();
echo "<br>";
$islem_no=$checkoutForm->getpaymentId();

if ($odeme_durum=="FAILURE") {
	
	echo "Başarısız Ödeme...";

} elseif ($odeme_durum=="SUCCESS") {

?>
<meta http-equiv="refresh" content="0;url=<?=SITE?>kk-kayit">
<?php
	/*echo "Başarılı Ödeme işlem numaranız :".$islem_no;*/
	
}
?>