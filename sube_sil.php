
<?php
include("baglanti.php");

if ($baglanti) 
{
    if (isset($_GET["sube_id"])) {
        $sube_id = strip_tags(trim($_GET["sube_id"]));
    }
    else {
        die();
    }

    $sql = "DELETE FROM `subeler` WHERE subeler.sube_id = ".$sube_id."";

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