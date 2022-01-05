
<?php
include("baglanti.php");

if ($baglanti) 
{
    if(isset($_GET['il_id']))
    {
        $sql = "SELECT * FROM `ilceler` WHERE ilceler.il_id = ".$_GET['il_id']."";

        $sonuc = mysqli_query($baglanti, $sql);
        
        foreach ($sonuc as $satir) {
            echo "<option value='".$satir['ilce_id']."'>".$satir['ilce_ad']."</option>";
        }
    }
   else
   {
       die("il id gelmedi");
   }
}
else
{
    die("baglanti sağlanamadı");
}

?>