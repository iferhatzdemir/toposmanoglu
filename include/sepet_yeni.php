<link href="<?=SITE?>css/cart.css" rel="stylesheet">
<style>
/* Modern Cart Styling */
.cart-wrapper {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    padding: 40px 0;
}

.cart-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
}

.cart-header {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    margin-bottom: 30px;
    animation: slideDown 0.5s ease-out;
}

.cart-header h1 {
    font-size: 36px;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 15px;
}

.cart-header h1::before {
    content: "🛒";
    font-size: 40px;
}

.cart-steps {
    display: flex;
    justify-content: space-between;
    margin-top: 25px;
    padding-top: 25px;
    border-top: 2px solid #e2e8f0;
}

.cart-step {
    flex: 1;
    text-align: center;
    position: relative;
    padding: 15px;
}

.cart-step::after {
    content: '';
    position: absolute;
    top: 25px;
    right: -50%;
    width: 100%;
    height: 3px;
    background: #e2e8f0;
    z-index: -1;
}

.cart-step:last-child::after {
    display: none;
}

.cart-step.active {
    color: #667eea;
}

.cart-step.active .step-number {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.step-number {
    display: inline-block;
    width: 50px;
    height: 50px;
    line-height: 50px;
    border-radius: 50%;
    background: #e2e8f0;
    color: #718096;
    font-weight: 700;
    font-size: 20px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
}

.step-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #718096;
}

.alert-modern {
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
    padding: 20px 30px;
    border-radius: 15px;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 10px 30px rgba(72, 187, 120, 0.3);
    animation: slideDown 0.5s ease-out;
}

.alert-modern::before {
    content: "✓";
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    font-size: 24px;
    font-weight: 700;
}

.cart-content {
    display: grid;
    grid-template-columns: 1fr 380px;
    gap: 30px;
    align-items: start;
}

.cart-items-section {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    animation: fadeIn 0.6s ease-out;
}

.cart-item {
    display: grid;
    grid-template-columns: 120px 1fr auto;
    gap: 25px;
    padding: 25px;
    background: #f7fafc;
    border-radius: 15px;
    margin-bottom: 20px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.cart-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 4px;
    height: 100%;
    background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
}

.cart-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.item-image {
    width: 120px;
    height: 120px;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.cart-item:hover .item-image img {
    transform: scale(1.1);
}

.item-details {
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 10px;
}

.item-title {
    font-size: 18px;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
    line-height: 1.4;
}

.item-variant {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 14px;
    background: white;
    border-radius: 20px;
    font-size: 13px;
    color: #667eea;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.item-variant::before {
    content: "✦";
    color: #667eea;
}

.item-price-section {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 15px;
    min-width: 200px;
}

.item-price {
    font-size: 24px;
    font-weight: 700;
    color: #2d3748;
    white-space: nowrap;
}

.item-unit-price {
    font-size: 13px;
    color: #718096;
    font-weight: 500;
}

.quantity-control {
    display: flex;
    align-items: center;
    gap: 12px;
    background: white;
    padding: 8px 12px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}

.qty-btn {
    width: 36px;
    height: 36px;
    border: none;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 8px;
    font-size: 20px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
}

.qty-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.qty-btn:active {
    transform: scale(0.95);
}

.qty-input {
    width: 60px;
    height: 36px;
    text-align: center;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 700;
    color: #2d3748;
    transition: all 0.3s ease;
}

.qty-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.item-remove {
    position: absolute;
    top: 15px;
    right: 15px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #fed7d7;
    color: #e53e3e;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    transition: all 0.3s ease;
    opacity: 0.7;
}

.item-remove:hover {
    opacity: 1;
    background: #e53e3e;
    color: white;
    transform: rotate(90deg);
}

.cart-actions {
    display: flex;
    gap: 15px;
    margin-top: 30px;
    padding-top: 25px;
    border-top: 2px solid #e2e8f0;
}

.btn-update, .btn-clear {
    flex: 1;
    padding: 16px 30px;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    text-align: center;
    display: inline-block;
}

.btn-update {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
}

.btn-update:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(102, 126, 234, 0.5);
}

.btn-clear {
    background: white;
    color: #e53e3e;
    border: 2px solid #fed7d7;
}

.btn-clear:hover {
    background: #e53e3e;
    color: white;
    border-color: #e53e3e;
}

.cart-summary {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    position: sticky;
    top: 30px;
    animation: fadeIn 0.6s ease-out 0.2s backwards;
}

.summary-title {
    font-size: 24px;
    font-weight: 700;
    color: #2d3748;
    margin: 0 0 25px 0;
    padding-bottom: 20px;
    border-bottom: 2px solid #e2e8f0;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 0;
    font-size: 15px;
}

.summary-label {
    color: #718096;
    font-weight: 500;
}

.summary-value {
    color: #2d3748;
    font-weight: 700;
}

.summary-row.tax {
    font-size: 14px;
    padding: 8px 0;
}

.summary-row.tax .summary-label {
    color: #a0aec0;
}

.summary-row.tax .summary-value {
    color: #4a5568;
    font-weight: 600;
}

.summary-divider {
    height: 2px;
    background: linear-gradient(90deg, transparent 0%, #e2e8f0 50%, transparent 100%);
    margin: 20px 0;
}

.summary-total {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 20px;
    border-radius: 12px;
    margin: 20px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.summary-total .summary-label,
.summary-total .summary-value {
    color: white;
    font-size: 20px;
    font-weight: 700;
}

.btn-checkout {
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 18px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    text-align: center;
    display: block;
    box-shadow: 0 5px 20px rgba(72, 187, 120, 0.4);
}

.btn-checkout:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(72, 187, 120, 0.5);
}

.btn-checkout::after {
    content: " →";
    margin-left: 10px;
    transition: margin-left 0.3s ease;
}

.btn-checkout:hover::after {
    margin-left: 15px;
}

.secure-badge {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 15px;
    padding: 10px;
    background: #f7fafc;
    border-radius: 8px;
    font-size: 13px;
    color: #718096;
}

.secure-badge::before {
    content: "🔒";
    font-size: 16px;
}

.empty-cart {
    background: white;
    border-radius: 20px;
    padding: 80px 40px;
    text-align: center;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    animation: fadeIn 0.6s ease-out;
}

.empty-cart-icon {
    font-size: 120px;
    margin-bottom: 30px;
    opacity: 0.5;
}

.empty-cart h2 {
    font-size: 32px;
    font-weight: 700;
    color: #2d3748;
    margin: 0 0 15px 0;
}

.empty-cart p {
    font-size: 16px;
    color: #718096;
    margin: 0 0 30px 0;
}

.btn-shop {
    display: inline-block;
    padding: 16px 40px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-decoration: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 16px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
}

.btn-shop:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 30px rgba(102, 126, 234, 0.5);
}

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
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

@media (max-width: 1024px) {
    .cart-content {
        grid-template-columns: 1fr;
    }

    .cart-summary {
        position: static;
    }
}

@media (max-width: 768px) {
    .cart-header h1 {
        font-size: 28px;
    }

    .cart-steps {
        flex-direction: column;
        gap: 10px;
    }

    .cart-step::after {
        display: none;
    }

    .cart-item {
        grid-template-columns: 80px 1fr;
        gap: 15px;
    }

    .item-image {
        width: 80px;
        height: 80px;
    }

    .item-price-section {
        grid-column: 1 / -1;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #e2e8f0;
    }

    .cart-actions {
        flex-direction: column;
    }
}
</style>

<?php
if(!empty($_SESSION["sepet"]))
{
?>
<div class="cart-wrapper">
    <div class="cart-container">
        <div class="cart-header">
            <h1>Alışveriş Sepetim</h1>
            <div class="cart-steps">
                <div class="cart-step active">
                    <span class="step-number">1</span>
                    <span class="step-label">Sepet</span>
                </div>
                <div class="cart-step">
                    <span class="step-number">2</span>
                    <span class="step-label">Teslimat</span>
                </div>
                <div class="cart-step">
                    <span class="step-number">3</span>
                    <span class="step-label">Ödeme</span>
                </div>
                <div class="cart-step">
                    <span class="step-number">4</span>
                    <span class="step-label">Onay</span>
                </div>
            </div>
        </div>

        <?php
        if($_POST)
        {
            if(!empty($_POST["adet"]))
            {
                $toplamNesneAdeti=count($_POST["adet"]);
                $adetsayaci=0;
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
                                        $adetpost=$VT->filter($_POST["adet"][$adetsayaci]);
                                        if($stokTablo[0]["stok"]>=$adetpost)
                                        {
                                            $_SESSION["sepetVaryasyon"][$urunbilgisi[0]["ID"]][$stokTablo[0]["ID"]]["adet"]=$adetpost;
                                        }
                                    }
                                    $adetsayaci++;
                                }
                            }
                        }
                        else
                        {
                            $adetpost=$VT->filter($_POST["adet"][$adetsayaci]);
                            if($urunbilgisi[0]["stok"]>=$adetpost)
                            {
                                $_SESSION["sepet"][$urunbilgisi[0]["ID"]]["adet"]=$adetpost;
                            }
                            $adetsayaci++;
                        }
                    }
                }
        ?>
        <div class="alert-modern">
            Sepetiniz başarıyla güncellenmiştir
        </div>
        <?php
            }
        }
        ?>

        <?php
        $sepetkdvharictutar=0;
        $sepetkdvtutar18=0;
        $sepetkdvtutar8=0;
        $sepetkdvtutar6=0;
        $sepetkdvtutar1=0;
        $sepetTutar=0;
        ?>

        <form action="#" method="post" id="cartForm">
            <div class="cart-content">
                <div class="cart-items-section">
                    <?php
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

                                            if(strpos($varyasyonID,"@")!=false)
                                            {
                                                $varyasyondizi=explode("@", $varyasyonID);
                                                $secenekdizi=explode("@", $secimID);
                                                for($i=0;$i<count($varyasyondizi);$i++)
                                                {
                                                    $varyasyonBilgisi=$VT->VeriGetir("urunvaryasyonlari","WHERE ID=?",array($varyasyondizi[$i]),"ORDER BY ID ASC",1);
                                                    $secenekBilgisi=$VT->VeriGetir("urunvaryasyonsecenekleri","WHERE ID=?",array($secenekdizi[$i]),"ORDER BY ID ASC",1);
                                                    if($varyasyonBilgisi!=false && $secenekBilgisi!=false)
                                                    {
                                                        $varyasyonOzellikleri.=stripslashes($secenekBilgisi[0]["baslik"])." ".$varyasyonBilgisi[0]["baslik"]." ";
                                                    }
                                                }
                                            }
                                            else
                                            {
                                                $varyasyonBilgisi=$VT->VeriGetir("urunvaryasyonlari","WHERE ID=?",array($varyasyonID),"ORDER BY ID ASC",1);
                                                $secenekBilgisi=$VT->VeriGetir("urunvaryasyonsecenekleri","WHERE ID=?",array($secimID),"ORDER BY ID ASC",1);
                                                if($varyasyonBilgisi!=false && $secenekBilgisi!=false)
                                                {
                                                    $varyasyonOzellikleri=stripslashes($secenekBilgisi[0]["baslik"])." ".$varyasyonBilgisi[0]["baslik"];
                                                }
                                            }

                                            // Fiyat hesaplama
                                            if(!empty($urunbilgisi[0]["indirimlifiyat"]))
                                            {
                                                $fiyat=$urunbilgisi[0]["indirimlifiyat"].".".$urunbilgisi[0]["indirimlikurus"];
                                            }
                                            else
                                            {
                                                $fiyat=$urunbilgisi[0]["fiyat"].".".$urunbilgisi[0]["kurus"];
                                            }

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
                                                $kdvsizBirimfiyat=($fiyat/$oran);
                                            }
                                            else
                                            {
                                                $kdvsizBirimfiyat=$fiyat;
                                            }

                                            $toplamtutar=($fiyat*$secenekAdet["adet"]);

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
                                                $kdvsizToplamTutar=($fiyat/$oran);
                                            }
                                            else
                                            {
                                                $kdvsizToplamTutar=$fiyat;
                                            }
                                            $kdvsizToplamTutar=($kdvsizToplamTutar*$secenekAdet["adet"]);

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
                                                $kdvlifiyat=$toplamtutar;
                                                $kdvsizfiyat=($toplamtutar/$oran);
                                                $kdvtutari=($toplamtutar-$kdvsizfiyat);
                                                if($urunbilgisi[0]["kdvoran"]==18){$sepetkdvtutar18=($sepetkdvtutar18+$kdvtutari);}
                                                if($urunbilgisi[0]["kdvoran"]==8){$sepetkdvtutar8=($sepetkdvtutar8+$kdvtutari);}
                                                if($urunbilgisi[0]["kdvoran"]==6){$sepetkdvtutar6=($sepetkdvtutar6+$kdvtutari);}
                                                if($urunbilgisi[0]["kdvoran"]==1){$sepetkdvtutar1=($sepetkdvtutar1+$kdvtutari);}
                                                $sepetkdvharictutar=($sepetkdvharictutar+$kdvsizfiyat);
                                                $sepetTutar=($sepetTutar+$kdvlifiyat);
                                            }
                                            else
                                            {
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
                    ?>
                    <div class="cart-item">
                        <div class="item-image">
                            <img src="<?=SITE?>images/urunler/<?=$urunbilgisi[0]["resim"]?>" alt="<?=stripslashes($urunbilgisi[0]["baslik"])?>">
                        </div>
                        <div class="item-details">
                            <h3 class="item-title"><?=stripslashes($urunbilgisi[0]["baslik"])?></h3>
                            <?php if(!empty($varyasyonOzellikleri)) { ?>
                            <span class="item-variant"><?=$varyasyonOzellikleri?></span>
                            <?php } ?>
                            <div class="item-unit-price">Birim Fiyat: <?=number_format($kdvsizBirimfiyat,2,",",".")?> TL</div>
                        </div>
                        <div class="item-price-section">
                            <div class="item-price"><?=number_format($kdvsizToplamTutar,2,",",".")?> TL</div>
                            <div class="quantity-control">
                                <button type="button" class="qty-btn qty-minus">−</button>
                                <input type="number" class="qty-input" name="adet[]" value="<?=$secenekAdet["adet"]?>" min="1" max="<?=$stokTablo[0]["stok"]?>">
                                <button type="button" class="qty-btn qty-plus">+</button>
                            </div>
                        </div>
                        <a href="<?=SITE?>sepet-sil/<?=$urunbilgisi[0]["ID"]?>/<?=$secenekID?>" class="item-remove" title="Ürünü Sil">×</a>
                    </div>
                    <?php
                                        }
                                    }
                                }
                            }
                            else
                            {
                                // Varyasyonsuz ürün
                                if(!empty($urunbilgisi[0]["indirimlifiyat"]))
                                {
                                    $fiyat=$urunbilgisi[0]["indirimlifiyat"].".".$urunbilgisi[0]["indirimlikurus"];
                                }
                                else
                                {
                                    $fiyat=$urunbilgisi[0]["fiyat"].".".$urunbilgisi[0]["kurus"];
                                }

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
                                    $kdvsizBirimfiyat=($fiyat/$oran);
                                }
                                else
                                {
                                    $kdvsizBirimfiyat=$fiyat;
                                }

                                $toplamtutar=($fiyat*$bilgi["adet"]);

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
                                    $kdvsizToplamTutar=($fiyat/$oran);
                                }
                                else
                                {
                                    $kdvsizToplamTutar=$fiyat;
                                }
                                $kdvsizToplamTutar=($kdvsizToplamTutar*$bilgi["adet"]);

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
                                    $kdvlifiyat=$toplamtutar;
                                    $kdvsizfiyat=($toplamtutar/$oran);
                                    $kdvtutari=($toplamtutar-$kdvsizfiyat);
                                    if($urunbilgisi[0]["kdvoran"]==18){$sepetkdvtutar18=($sepetkdvtutar18+$kdvtutari);}
                                    if($urunbilgisi[0]["kdvoran"]==8){$sepetkdvtutar8=($sepetkdvtutar8+$kdvtutari);}
                                    if($urunbilgisi[0]["kdvoran"]==6){$sepetkdvtutar6=($sepetkdvtutar6+$kdvtutari);}
                                    if($urunbilgisi[0]["kdvoran"]==1){$sepetkdvtutar1=($sepetkdvtutar1+$kdvtutari);}
                                    $sepetkdvharictutar=($sepetkdvharictutar+$kdvsizfiyat);
                                    $sepetTutar=($sepetTutar+$kdvlifiyat);
                                }
                                else
                                {
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
                    ?>
                    <div class="cart-item">
                        <div class="item-image">
                            <img src="<?=SITE?>images/urunler/<?=$urunbilgisi[0]["resim"]?>" alt="<?=stripslashes($urunbilgisi[0]["baslik"])?>">
                        </div>
                        <div class="item-details">
                            <h3 class="item-title"><?=stripslashes($urunbilgisi[0]["baslik"])?></h3>
                            <div class="item-unit-price">Birim Fiyat: <?=number_format($kdvsizBirimfiyat,2,",",".")?> TL</div>
                        </div>
                        <div class="item-price-section">
                            <div class="item-price"><?=number_format($kdvsizToplamTutar,2,",",".")?> TL</div>
                            <div class="quantity-control">
                                <button type="button" class="qty-btn qty-minus">−</button>
                                <input type="number" class="qty-input" name="adet[]" value="<?=$bilgi["adet"]?>" min="1" max="<?=$urunbilgisi[0]["stok"]?>">
                                <button type="button" class="qty-btn qty-plus">+</button>
                            </div>
                        </div>
                        <a href="<?=SITE?>sepet-sil/<?=$urunbilgisi[0]["ID"]?>" class="item-remove" title="Ürünü Sil">×</a>
                    </div>
                    <?php
                            }
                        }
                    }
                    ?>

                    <div class="cart-actions">
                        <button type="submit" class="btn-update">Sepeti Güncelle</button>
                        <a href="<?=SITE?>sepet-sil/clear" class="btn-clear" onclick="return confirm('Sepetteki tüm ürünleri silmek istediğinize emin misiniz?')">Sepeti Temizle</a>
                    </div>
                </div>

                <div class="cart-summary">
                    <h2 class="summary-title">Sipariş Özeti</h2>

                    <div class="summary-row">
                        <span class="summary-label">Ara Toplam</span>
                        <span class="summary-value"><?=number_format(($sepetkdvharictutar),2,",",".")?> TL</span>
                    </div>

                    <?php if($sepetkdvtutar1>0) { ?>
                    <div class="summary-row tax">
                        <span class="summary-label">KDV (%1)</span>
                        <span class="summary-value"><?=number_format(($sepetkdvtutar1),2,",",".")?> TL</span>
                    </div>
                    <?php } ?>

                    <?php if($sepetkdvtutar6>0) { ?>
                    <div class="summary-row tax">
                        <span class="summary-label">KDV (%6)</span>
                        <span class="summary-value"><?=number_format(($sepetkdvtutar6),2,",",".")?> TL</span>
                    </div>
                    <?php } ?>

                    <?php if($sepetkdvtutar8>0) { ?>
                    <div class="summary-row tax">
                        <span class="summary-label">KDV (%8)</span>
                        <span class="summary-value"><?=number_format(($sepetkdvtutar8),2,",",".")?> TL</span>
                    </div>
                    <?php } ?>

                    <?php if($sepetkdvtutar18>0) { ?>
                    <div class="summary-row tax">
                        <span class="summary-label">KDV (%18)</span>
                        <span class="summary-value"><?=number_format(($sepetkdvtutar18),2,",",".")?> TL</span>
                    </div>
                    <?php } ?>

                    <div class="summary-divider"></div>

                    <div class="summary-total">
                        <span class="summary-label">Toplam Tutar</span>
                        <span class="summary-value"><?=number_format(($sepetTutar),2,",",".")?> TL</span>
                    </div>

                    <?php
                    if(!empty($_SESSION["uyeID"]))
                    {
                        $uyeID=$VT->filter($_SESSION["uyeID"]);
                        $uyebilgisi=$VT->VeriGetir("uyeler","WHERE ID=? AND durum=?",array($uyeID,1),"ORDER BY ID ASC",1);
                        if($uyebilgisi!=false)
                        {
                    ?>
                    <a href="<?=SITE?>odeme-tipi" class="btn-checkout">Ödemeye Geç</a>
                    <?php
                        }
                        else
                        {
                    ?>
                    <a href="<?=SITE?>uyelik" class="btn-checkout">Üye Ol ve Öde</a>
                    <?php
                        }
                    }
                    else
                    {
                    ?>
                    <a href="<?=SITE?>uyelik" class="btn-checkout">Üye Ol ve Öde</a>
                    <?php
                    }
                    ?>

                    <div class="secure-badge">
                        Güvenli Ödeme
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Quantity controls
document.addEventListener('DOMContentLoaded', function() {
    // Plus/Minus buttons
    document.querySelectorAll('.qty-plus').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.qty-input');
            const max = parseInt(input.getAttribute('max'));
            let value = parseInt(input.value);
            if(value < max) {
                input.value = value + 1;
                updateCartItem(input);
            }
        });
    });

    document.querySelectorAll('.qty-minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.qty-input');
            let value = parseInt(input.value);
            if(value > 1) {
                input.value = value - 1;
                updateCartItem(input);
            }
        });
    });

    // Input change
    document.querySelectorAll('.qty-input').forEach(input => {
        input.addEventListener('change', function() {
            const min = parseInt(this.getAttribute('min'));
            const max = parseInt(this.getAttribute('max'));
            let value = parseInt(this.value);

            if(value < min) this.value = min;
            if(value > max) this.value = max;

            updateCartItem(this);
        });
    });

    function updateCartItem(input) {
        // Auto-submit form after 1 second of inactivity
        clearTimeout(window.cartUpdateTimeout);
        window.cartUpdateTimeout = setTimeout(() => {
            // Optional: Show loading state
            document.querySelectorAll('.btn-update').forEach(btn => {
                btn.textContent = 'Güncelleniyor...';
                btn.disabled = true;
            });

            // Auto-submit
            // document.getElementById('cartForm').submit();
        }, 1000);
    }

    // Remove item confirmation
    document.querySelectorAll('.item-remove').forEach(link => {
        link.addEventListener('click', function(e) {
            if(!confirm('Bu ürünü sepetten çıkarmak istediğinize emin misiniz?')) {
                e.preventDefault();
            }
        });
    });
});
</script>

<?php
}
else
{
?>
<div class="cart-wrapper">
    <div class="cart-container">
        <div class="empty-cart">
            <div class="empty-cart-icon">🛒</div>
            <h2>Sepetiniz Boş</h2>
            <p>Henüz sepetinize ürün eklemediniz. Alışverişe başlamak için ürünlerimize göz atın.</p>
            <a href="<?=SITE?>" class="btn-shop">Alışverişe Başla</a>
        </div>
    </div>
</div>
<?php
}
?>
