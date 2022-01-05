
<?php
include("baglanti.php");

if ($baglanti) 
{
    if (isset($_POST["ilce_id"])) {
        $ilce_id = strip_tags(trim($_POST["ilce_id"]));
    }
    else {
        die();
    }
    if (isset($_POST["yonetici_id"])) {
        $yonetici_id = strip_tags(trim($_POST["yonetici_id"]));
    }
    else {
        die();
    }
    if (isset($_POST["sube_ad"])) {
        $sube_ad = strip_tags(trim($_POST["sube_ad"]));
    }
    else {
        die();
    }
    if (isset($_POST["kapasite"])) {
        $kapasite = strip_tags(trim($_POST["kapasite"]));
    }
    else {
        die();
    }

    $sql = "INSERT INTO `subeler`(`ilce_id`, `yonetici_id`, `sube_ad`, `kapasite`) 
    VALUES (".$ilce_id.",'".$yonetici_id."','".$sube_ad."','".$kapasite."')";

    $basari = mysqli_query($baglanti, $sql);
    if ($basari) {
        echo 1;
    }
    else
    {
        die(mysqli_error($baglanti));
    }
}
else
{
    die("baglanti sağlanamadı");
}

?>