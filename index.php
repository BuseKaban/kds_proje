<?php
include("denetle_yonlendir.php");
include("head.php");
include("moduller/yan_menu.php");
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div class = 'sayfa flex-column'>
    <div class = 'flex-row genislik-tam'>
        <?php include("moduller/toplam-gelir-gider.php"); ?>
        <?php include("moduller/cinsiyet-dagilimi-pie.php"); ?>
    </div>
    <div class="golge genislik-tam" style="margin-top: 20px;">
        <?php include("moduller/subeler-tablo.php"); ?>
    </div>
</div>