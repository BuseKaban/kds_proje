<?php
include("denetle_yonlendir.php");
include("head.php");
include("moduller/yan_menu.php");
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script src="js/jquery-3.6.0.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#subeekle").click(function() {
            $.post("sube_ekle.php", {
                    ilce_id: $("#ilce option:selected").val(),
                    yonetici_id: $("#yonetici_id").val(),
                    sube_ad: $("#sube_ad").val(),
                    kapasite: $("#kapasite").val()
                },
                function(data, status) {
                    if (data != 1) {
                        alert("Şube eklenemedi -> " + data)
                    } else {
                        $(location).attr("href", "index.php")
                    }
                }
            )
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#il").change(function() {
            $.get("ilce_listele.php", {
                    il_id: $("#il option:selected").val(),
                },
                function(data, status) {
                    $("#ilce").html(data)
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
                    <label for="sube_ad">Şube ad:</label>
                    <input type="text" id="sube_ad" name="sube_ad" required>
                </li>
                <li>
                    <label for="yonetici_id">Yönetici:</label>
                    <select id="yonetici_id" name="yonetici_id" required>
                        <?php
                            include("baglanti.php");

                            if ($baglanti) {
                                $sql = "SELECT * FROM yoneticiler";

                                $sonuc = mysqli_query($baglanti, $sql);

                                foreach ($sonuc as $satir) {
                                    echo "<option value='" . $satir['yonetici_id'] . "'>" . $satir['yonetici_ad']." ".$satir['yonetici_soyad'] . "</option>";
                                }
                            } 
                            else 
                            {
                                die("baglanti sağlanamadı");
                            }
                        ?>
                    </select>
                    
                </li>
                <li>
                    <label for="kapasite">Kapasite:</label>
                    <input type="number" id="kapasite" name="kapasite" required>
                </li>
                <hr>
                <li>
                    <label for="il">İl:</label>
                    <select id="il" name="il" required>
                        <option disabled selected value> -- İl seçin -- </option>
                        <?php
                            include("baglanti.php");

                            if ($baglanti) {
                                $sql = "SELECT * FROM `iller`";

                                $sonuc = mysqli_query($baglanti, $sql);

                                foreach ($sonuc as $satir) {
                                    echo "<option value='" . $satir['il_id'] . "'>" . $satir['il_ad'] . "</option>";
                                }
                            } 
                            else 
                            {
                                die("baglanti sağlanamadı");
                            }
                        ?>
                    </select>
                </li>
                <li>
                    <label for="ilce">İlçe:</label>
                    <select id="ilce" name="ilce" required>
                        <option disabled selected value> -- İlçe seçin -- </option>
                    </select>
                </li>
                <hr>

                <input id="subeekle" type="submit" value="Ekle">
            </ul>
        </form>
    
    </div>
</div>