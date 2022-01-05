<?php
include("denetle_yonlendir.php");
include("head.php");
include("moduller/yan_menu.php");
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="js/jquery-3.6.0.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#personel-test-button").click(function() {
            $(location).attr("href", "sube.php?id=<?php echo $_GET['id'] ?>&personel=" + $("#personel-test").val())
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#personelekle").click(function() {
            $(location).attr("href", "personel_ekle_form.php?sube_id=<?php echo $_GET['id'] ?>");
        });
    });
</script>

<div class="sayfa flex-column">
    <?php include("moduller/sube-kontrol.php"); ?>

    <ul class="flex-row genislik-tam golge" style="padding: 10px; margin:10px 0px 10px 0px; ">
        <li style="align-self: center; flex: 1;">
            <b><?php include("baglanti.php");
            $sql_sube = "SELECT iller.il_ad, ilceler.ilce_ad, subeler.sube_ad 
                        FROM subeler 
                        LEFT JOIN ilceler on ilceler.ilce_id = subeler.ilce_id 
                        LEFT JOIN iller on iller.il_id = ilceler.il_id 
                        WHERE sube_id =".$_GET['id']."";

            $sorgu = mysqli_query($baglanti, $sql_sube);
            $satir = mysqli_fetch_assoc($sorgu);

            echo $satir["il_ad"]."/".$satir['ilce_ad']." - ".$satir['sube_ad']." Şubesi";


            mysqli_close($baglanti); ?>
            </b>
        </li>
        <li>
            <label for="personel-test">Personel Sayısını Test Et: </label>
            <input type="number" id="personel-test" name="personel-test" required>
            <a id="personel-test-button" class="button" style="background-color:#fC255A;">Test</a>
            <a class="button" style="background-color:#fC255A;" href="sube.php?id=<?php echo $_GET['id'] ?>">Sıfırla</a>
             
        </li>
        <li style="padding-left:10px;">
        <a id="personelekle" class="button" style="background-color:#55f;">Personel Ekle</a>
        </li>
    </ul>

    <div class="flex-row genislik-tam">
        <?php include("moduller/sube-giderleri.php"); ?>
        <?php include("baglanti.php");
            $sql_personel = "SELECT subelere_gore_toplam_personel.sube_id, AVG(siparis_adet) as ortalama, personel_sayisi, (AVG(siparis_adet)/personel_sayisi) as personel_basina_ortalama_yogunluk
                    FROM 
                    subelere_gore_gunluk_siparis 
                    LEFT JOIN subelere_gore_toplam_personel on subelere_gore_gunluk_siparis.sube_id = subelere_gore_toplam_personel.sube_id
                    WHERE subelere_gore_gunluk_siparis.sube_id =".$_GET["id"]."
                    AND month(subelere_gore_gunluk_siparis.tarih) = 12
                    ";

            $sorgu = mysqli_query($baglanti, $sql_personel);
            $satir = mysqli_fetch_assoc($sorgu);

            $ortalama = $satir["personel_basina_ortalama_yogunluk"];


            echo '<div class="flex-column min-height-400" style="flex: 1 0 50%; margin:10px;">
                    <div class="flex-row genislik-tam" style="flex: 1;">
                        <div class="golge center kutu";"><b>Personel Sayısı</b><br><span class="buyuk">' . $satir["personel_sayisi"] . '</span>';

            if (isset($_GET["personel"])) {
                if ($_GET["personel"] > $satir["personel_sayisi"]) {
                    echo '<span class="tahmin" style="color:green;">Hedef personel sayisi: ' . $_GET["personel"] . '</span>';
                } else {
                    echo '<span class="tahmin" style="color:red;">Hedef personel sayisi: ' . $_GET["personel"] . '</span>';
                }
            }

            echo '</div>';
            echo '<div class="golge center kutu";"><b>Günlük ortalama satış</b><br><span class="buyuk">' . number_format($satir["ortalama"], 2) . '</span></div>
                    </div>
                    <div id="sube-personel-basina-yogunluk" class="center golge flex-column genislik-tam" style="flex:1; margin:4px; padding: 20px;">
                        <p style="font-weight:bold; margin-bottom:12px;">PERSONEL BAŞINA GÜNLÜK MÜŞTERİ YOĞUNLUĞU</p>';


            echo '<p style="font-weight:bold; font-size:xxx-large; text-align:center;">' . number_format($ortalama, 2);
            
            
            if (isset($_GET["personel"])) {
                $hedefortalama = $satir['ortalama'] / $_GET["personel"];

                if ($hedefortalama > 6.50 && $hedefortalama < 8.50) {
                    echo "<br><span class='tahmin' style='font-weight:normal; font-size:large; color:green;'>Tahmini personel başına yoğunluk: " . number_format($hedefortalama, 2) . "</span>";
                } else {
                    echo "<br><span class='tahmin'  style='font-weight:normal; font-size:large; color:red;'>Tahmini personel başına yoğunluk: " . number_format($hedefortalama, 2) . "</span>";
                }
            }
            echo "<br><span style='font-weight:normal; font-size:medium; color:#3e3e3e; '>Personel başına günlük müşteri yoğunluğu 6.5 ile 8.5 arası olmalıdır.<span>";

           
           
            echo "</p></div></div>";

            mysqli_close($baglanti); ?>
    </div>

    <div class="flex-row genislik-tam">
        <?php include("moduller/sube-yogunluk.php"); ?>
        <?php include("moduller/sube-siparis-oran-pie.php"); ?>
    </div>
    
    <div class="genislik-tam">
        <?php include("moduller/sube-calisanlar-tablo.php"); ?>
    </div>
</div>