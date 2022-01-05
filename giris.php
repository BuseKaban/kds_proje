<?php
session_start();

include("baglanti.php");

if ($baglanti) 
{
    if (isset($_POST["isim"])) {
        $isim = strip_tags(trim($_POST["isim"]));
        $isim =  mysqli_real_escape_string($baglanti, $isim);
    }
    else {
        echo "isim gelmedi";
    }

    if (isset($_POST["sifre"])) {
        $sifre = strip_tags(trim($_POST["sifre"]));
        $sifre =  mysqli_real_escape_string($baglanti, $sifre);
    }
    else {
        echo "sifre gelmedi";
    }

    $sql = "SELECT * FROM admin_giris WHERE ad LIKE '".$isim."' AND sifre LIKE '".$sifre."' ";

    $kullanici_result = mysqli_query($baglanti, $sql);

    if(mysqli_num_rows($kullanici_result) > 0)
    {
        $satir =  mysqli_fetch_assoc($kullanici_result);
        $_SESSION['kullanici_adi'] = $satir["ad"];
        echo 1;
    } 
    else 
    {
        die("geçersiz bilgi");
    }
}
else
{
    die("baglanti sağlanamadı");
}

?>