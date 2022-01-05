<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Tip');
        data.addColumn('number', 'Adet');
        
     
        data.addRows([
            <?php 
                include("baglanti.php");
                
                $sql_siparis_tip = "SELECT COUNT(CASE WHEN siparisler.siparis_tip = 1 THEN 1 ELSE null end) as online_adet, COUNT(CASE WHEN siparisler.siparis_tip = 2 THEN 1 ELSE null end) as subeden_adet FROM siparisler 
                WHERE siparisler.sube_id = ".$_GET['id']."
                AND month(siparisler.tarih) = 12";
                $siparis_tip_sorgu = mysqli_query($baglanti, $sql_siparis_tip);
                $satir = mysqli_fetch_assoc($siparis_tip_sorgu);
            
                echo "['Online Sipariş',".$satir["online_adet"]."],";
                echo "['Şubeden Sipariş',".$satir["subeden_adet"]."],";
                
                mysqli_close($baglanti)
            ?>
        ]);

        var options = {
            backgroundColor: 'transparent',
            title: 'Sipariş Oranları'
        };

        var chart = new google.visualization.PieChart(document.getElementById('sube-siparis-oran-pie'));
        chart.draw(data, options);
      }

      
    </script>
  </head>

  <div id="sube-siparis-oran-pie" class="golge flex-column min-height-400" style="flex: 1 0 50%; margin: 10px;"></div>