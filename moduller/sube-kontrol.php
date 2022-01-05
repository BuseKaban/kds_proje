<?php
    include("baglanti.php");

    $sql_kapasite = "SELECT sube_id, kapasite FROM `subeler` WHERE sube_id = " . $_GET["id"] . "";
    $kapasite_sorgu = mysqli_query($baglanti, $sql_kapasite);
    $kapasite_row = mysqli_fetch_assoc($kapasite_sorgu);

    $sql_subeden_satis = "SELECT MONTH(tarih) as tarih, count(siparisler.siparis_id) as adet 
                        FROM siparisler 
                        LEFT JOIN urunler on siparisler.urun_id = urunler.urun_id
                        WHERE siparisler.siparis_tip = 2
                        AND siparisler.sube_id = " . $_GET["id"] . "
                        AND MONTH(siparisler.tarih) = 12";

    $sorgu = mysqli_query($baglanti, $sql_subeden_satis);
    $adet_row = mysqli_fetch_assoc($sorgu);

    if ($adet_row["adet"] > $kapasite_row["kapasite"] * 0.9) {
        echo "<a href='sube_ekle_form.php?' class=\"uyari tehlike genislik-tam\">Şube kapasitesi yetersiz! Aynı bölgeye şube açmayı gözden geçirmelisiniz.<span style=\"float: right; padding-right: 10px;\">>></span></a>";
    } else if ($adet_row["adet"] > ($kapasite_row["kapasite"] * 0.65)) {
        echo "<a href='sube_ekle_form.php?' class=\"uyari genislik-tam\">Şube kapasitesi düşük! Bölgede yeni bir şube açılabilir.<span style=\"float: right; padding-right: 10px;\">>></span></a>";
    }

    $sql_toplam_satis = "SELECT subelere_gore_toplam_personel.sube_id, AVG(siparis_adet), personel_sayisi, (AVG(siparis_adet)/personel_sayisi) as personel_basina_ortalama_yogunluk
        FROM 
        subelere_gore_gunluk_siparis 
        LEFT JOIN subelere_gore_toplam_personel on subelere_gore_gunluk_siparis.sube_id = subelere_gore_toplam_personel.sube_id
        WHERE subelere_gore_gunluk_siparis.sube_id = ".$_GET["id"]."
        AND month(subelere_gore_gunluk_siparis.tarih) = 12
        ";

    $sorgu = mysqli_query($baglanti, $sql_toplam_satis);
    $satir = mysqli_fetch_assoc($sorgu);

    if ($satir["personel_basina_ortalama_yogunluk"] > 10) {
        echo "<a href='personel_ekle_form.php?sube_id=".$_GET['id']."' class=\"uyari tehlike genislik-tam\">Personel başına düşen yoğunluk çok fazla! Personel almalısınız.<span style=\"float: right; padding-right: 10px;\">>></span></a>";
    } else if ($satir["personel_basina_ortalama_yogunluk"] > 8.50) {
        echo "<a href='personel_ekle_form.php?sube_id=".$_GET['id']."' class=\"uyari genislik-tam\">Personel başına düşen yoğunluk yüksek! Personel alınabilir.<span style=\"float: right; padding-right: 10px;\">>></span></a>";
    } else if ($satir["personel_basina_ortalama_yogunluk"] < 6.50) {
        echo "<a href='#personeller-tablo' class=\"uyari genislik-tam\">Personel başına yoğunluk düşük! Yakın zamanda personel azaltmanız gerekebilir.<span style=\"float: right; padding-right: 10px;\">>></span></a>";
    } else if ($satir["personel_basina_ortalama_yogunluk"] < 3.50) {
        echo "<a href='#personeller-tablo' class=\"uyari tehlike genislik-tam\">Personel başına yoğunluk çok düşük! Personel çıkartın veya başka şubeye aktarın.<span style=\"float: right; padding-right: 10px;\">>></span></a>";
    }

    $sql_cinsiyet = "SELECT * FROM `subelere_gore_kadin_erkek` WHERE sube_id = ".$_GET['id']."";
    $sorgu = mysqli_query($baglanti, $sql_cinsiyet);
    $satir = mysqli_fetch_assoc($sorgu);

    if ($satir["kadin"] < $satir['erkek']*0.4) {
        echo "<a href='personel_ekle_form.php?sube_id=".$_GET['id']."' class=\"uyari genislik-tam\">Şubenin cinsiyet dağılımı orantısız. Kadın çalışan alınabilir.<span style=\"float: right; padding-right: 10px;\">>></span></a>";
    } else if($satir["erkek"] < $satir['kadin']*0.7){
        echo "<a href='personel_ekle_form.php?sube_id=".$_GET['id']."' class=\"uyari genislik-tam\">Şubenin cinsiyet dağılımı orantısız. Erkek çalışan alınabilir.<span style=\"float: right; padding-right: 10px;\">>></span></a>";
 
    }

    mysqli_close($baglanti)          

?>