<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Cinsiyet');
        data.addColumn('number', 'Sayı');
        
     
        data.addRows([
            <?php 
                include("baglanti.php");
                
                $sql_kadin_erkek = "SELECT sum(kadin) as kadin_sayi, sum(erkek) as erkek_sayi FROM subelere_gore_kadin_erkek";
                $kadin_erkek_sorgu = mysqli_query($baglanti, $sql_kadin_erkek);
                $satir = mysqli_fetch_assoc($kadin_erkek_sorgu);
            
                echo "['Erkek',".$satir["erkek_sayi"]."],";
                echo "['Kadın',".$satir["kadin_sayi"]."],";
                
                mysqli_close($baglanti)
            ?>
        ]);

        var options = {
            backgroundColor: 'transparent',
            title: 'Cinsiyet Dağılımı'
        
        };

        var chart = new google.visualization.PieChart(document.getElementById('sube-cinsiyet-oran-pie'));
        chart.draw(data, options);
      }

      
    </script>
  </head>

  <div id="sube-cinsiyet-oran-pie" class="golge flex-column min-height-400" style="flex: 1 0 50%; margin: 10px;"></div>