<?php
include("baglanti.php");

if ($baglanti) 
{
    if (isset($_POST["sube_id"])) {
        $sube_id = strip_tags(trim($_POST["sube_id"]));
    }
    else {
        die();
    }
    if (isset($_POST["cinsiyet_id"])) {
        $cinsiyet_id = strip_tags(trim($_POST["cinsiyet_id"]));
    }
    else {
        die();
    }
    if (isset($_POST["personel_ad"])) {
        $personel_ad = strip_tags(trim($_POST["personel_ad"]));
    }
    else {
        die();
    }
    if (isset($_POST["personel_soyad"])) {
        $personel_soyad = strip_tags(trim($_POST["personel_soyad"]));
    }
    else {
        die();
    }

    $sql = "INSERT INTO `personeller`(`sube_id`, `cinsiyet_id`, `personel_ad`, `personel_soyad`) 
    VALUES (".$sube_id.",'".$cinsiyet_id."','".$personel_ad."','".$personel_soyad."')";

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