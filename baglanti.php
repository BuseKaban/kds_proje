<?php 
    $baglanti = mysqli_connect("localhost","root"," ","2019469038");

    if($baglanti)
        {
            mysqli_query($baglanti, "SET CHARACTER SET 'utf8'");
            mysqli_query($baglanti, "SET NAME 'utf8'");
        }
?>