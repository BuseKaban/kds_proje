<?php include("denetle_yonlendir.php"); ?>

<?php
function active($currect_page){
  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);  
  if($currect_page == $url){
      echo 'current'; //class name in css 
  } 
}
?>

<div class= "yan_menu">
    <nav class="flex-column genislik-tam">
        <ul class="genislik-tam">
            <li style="color: white; font-weight:bolder; font-size:larger; padding:30px;">KDS - Proje</li>
            <hr>
            <li style="color: white; padding:16px;"><?php echo $_SESSION['kullanici_adi'] ?></li>
            <hr style="margin-bottom:46px;">
            <li class="<?php active('index');?>"><a href="index">Şubeler</a></li>
            <li class="<?php active('sube_ekle_form');?>"><a style="padding-left: 50px;" href="sube_ekle_form">Şube Ekle</a></li>
            <li class="<?php active('personeller');?>"><a href="personeller">Personeller</a></li>
            <li class="<?php active('personel_ekle_form');?>"><a style="padding-left: 50px;" href="personel_ekle_form">Personel Ekle</a></li>
        </ul>
        <ul class="genislik-tam" style="margin-bottom: 20px;">
            <li><a href="cikis.php">Çıkış</a></li>
        </ul>
    </nav>
</div>