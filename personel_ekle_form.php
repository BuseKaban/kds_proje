<?php
include("denetle_yonlendir.php");
include("head.php");
include("moduller/yan_menu.php");
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script src="js/jquery-3.6.0.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#personelekle").click(function() {
            $.post("personel_ekle.php", {
                    personel_ad: $("#personel_ad").val(),
                    personel_soyad: $("#personel_soyad").val(),
                    cinsiyet_id: $("#cinsiyet option:selected").val(),
                    sube_id: $("#sube option:selected").val()
                },
                function(data, status) {
                    if (data != 1) {
                        alert("Personel eklenemedi -> " + data)
                    } else {
                        $(location).attr("href", "personeller.php")
                    }
                }
            )
        });
    });
</script>

<div class="sayfa flex-column">
    <div class="flex-row genislik-tam">
        <form class="ekle-form golge">
            <ul>
                <li>
                    <label for="personel_ad">Ad:</label>
                    <input type="text" id="personel_ad" name="personel_ad" required>
                </li>
                <li>
                    <label for="personel_soyad">Soyad:</label>
                    <input type="text" id="personel_soyad" name="personel_soyad" required>
                </li>
                <hr>
                <li>
                    <label for="sube">Şube:</label>
                    <select id="sube" name="sube" required>
                    <?php
                        include("baglanti.php");

                        if (!isset($_GET["sube_id"])) 
                        {
                            echo "<option disabled selected value> -- şube seçin -- </option>";
                        }
                        

                        if ($baglanti) {
                            $sql = "SELECT * FROM `subeler`";

                            $sonuc = mysqli_query($baglanti, $sql);
                            
                            if(isset($_GET["sube_id"]))
                            {
                                foreach ($sonuc as $satir) {
                                
                                    if($satir['sube_id'] == $_GET['sube_id'])
                                    {
                                        echo "<option selected value='" . $satir['sube_id'] . "'>" . $satir['sube_ad'] . "</option>";
                                    }
                                    else
                                    {
                                        echo "<option value='" . $satir['sube_id'] . "'>" . $satir['sube_ad'] . "</option>";
                                    }
                                }
                            }
                            else
                            {
                                foreach ($sonuc as $satir) {
                                    echo "<option value='" . $satir['sube_id'] . "'>" . $satir['sube_ad'] . "</option>";
                                }
                            }
                            
                        } else {
                            die("baglanti sağlanamadı");
                        }
                        ?>
                    </select>
                </li>
                <hr>
                <li>
                    <label for="cinsiyet">Cinsiyet:</label>
                    <select id="cinsiyet" name="cinsiyet" required>
                        <option disabled selected value> -- cinsiyet seçin -- </option>
                        <?php
                        include("baglanti.php");

                        if ($baglanti) {
                            $sql = "SELECT * FROM `cinsiyet`";

                            $sonuc = mysqli_query($baglanti, $sql);

                            foreach ($sonuc as $satir) {
                                echo "<option value='" . $satir['cinsiyet_id'] . "'>" . $satir['cinsiyet'] . "</option>";
                            }
                        } else {
                            die("baglanti sağlanamadı");
                        }
                        ?>
                    </select>
                </li>
                <hr>

                <input id="personelekle" type="submit" value="Ekle">
            </ul>
        </form>

    </div>
</div>