<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Tarih');
        data.addColumn('number', 'Gelir');
        data.addColumn('number', 'Gider');
        
        <?php 
           if(isset($_GET["personel"]))
           {
               echo "data.addColumn('number', 'Tahmini Gider');";
           }
        ?>
     
        data.addRows([
            <?php 
                include("baglanti.php");
                
                $sql_gelir_gider = "SELECT tarih, sum(kar) as satis_kar, sum(kira.kira_tutar) as kira_tutar
                FROM subelere_gore_aylik_kar 
                LEFT JOIN kira on kira.sube_id = subelere_gore_aylik_kar.sube_id AND kira.kira_ay = subelere_gore_aylik_kar.tarih 
                where subelere_gore_aylik_kar.sube_id=".$_GET["id"]."
                group by tarih";
                $sorgu = mysqli_query($baglanti, $sql_gelir_gider);

                $sql_personel_toplam_maas = "SELECT sum(maas) as toplam_maas, maas_ay FROM maas,personeller
                WHERE personeller.personel_id = maas.personel_id
                AND personeller.sube_id = ".$_GET["id"]."
                GROUP by maas_ay";
                $personel_sorgu = mysqli_query($baglanti, $sql_personel_toplam_maas);
             
                for ($i=0; $i < 12; $i++) { 

                    $personel_maas = mysqli_fetch_assoc($personel_sorgu);
                    $sube_gelir_gider = mysqli_fetch_assoc($sorgu);

                    $toplam_gider = $sube_gelir_gider["kira_tutar"]+$personel_maas["toplam_maas"];

                    if(isset($_GET["personel"]))
                    {
                        echo "['".$sube_gelir_gider["tarih"]."',".$sube_gelir_gider["satis_kar"].",". $toplam_gider.",".  ($sube_gelir_gider["kira_tutar"] + ($_GET["personel"]*4500))."],";
                    }
                    else
                    {
                        echo "['".$sube_gelir_gider["tarih"]."',".$sube_gelir_gider["satis_kar"].",". $toplam_gider."],";
                    }
                }
            
                
                
                mysqli_close($baglanti)
            ?>
        ]);

        var options = {
            hAxis: {
                title: 'Zaman'
            },
            vAxis: {
                title: 'Miktar',
                viewWindow: {
                    min:100000
                }
            },
            lineWidth: 4,
            backgroundColor: 'transparent',
        };

        var chart = new google.visualization.LineChart(document.getElementById('sube-giderleri-grafik'));
        chart.draw(data, options);
      }

      
    </script>
  </head>

  <div id="sube-giderleri-grafik" class="golge flex-column min-height-400" style="flex: 1 0 50%; margin:10px;"></div>