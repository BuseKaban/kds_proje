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
                
                $sql_gelir_gider = "SELECT tarih, sum(kar) as satis_kar, sum(kira.kira_tutar) as toplam_kira
                FROM subelere_gore_aylik_kar 
                LEFT JOIN kira on kira.sube_id = subelere_gore_aylik_kar.sube_id AND kira.kira_ay = subelere_gore_aylik_kar.tarih 
                group by tarih";

                $sorgu = mysqli_query($baglanti, $sql_gelir_gider);
              
                foreach ($sorgu as $satir) {
                    echo "['".$satir["tarih"]."',".$satir["satis_kar"].",".($satir["toplam_kira"])."],";
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

        var chart = new google.visualization.LineChart(document.getElementById('toplam-gelir-gider'));
        chart.draw(data, options);
      }

      
    </script>
  </head>

  <div id="toplam-gelir-gider" class="golge flex-column min-height-400" style="flex: 1 0 50%; margin:10px;"></div>