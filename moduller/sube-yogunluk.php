<script>
    google.charts.load('current', {
        packages: ['corechart', 'line']
    });
    google.charts.setOnLoadCallback(drawTrendlines);

    function drawTrendlines() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Tarih');
        data.addColumn('number', 'Satış');
        data.addColumn('number', 'Kapasite');

        data.addRows([
            <?php 
                include("baglanti.php");

                $sql_kapasite = "SELECT sube_id, kapasite FROM `subeler` WHERE sube_id = ".$_GET["id"]."";
                $kapasite_sorgu = mysqli_query($baglanti, $sql_kapasite);
                $kapasite_row = mysqli_fetch_assoc($kapasite_sorgu);
                
                $sql_subeden_satis = "SELECT month(siparisler.tarih) as tarih, count(siparisler.siparis_id) as adet 
                FROM siparisler 
                LEFT JOIN urunler on siparisler.urun_id = urunler.urun_id
                WHERE siparisler.siparis_tip = 2
                AND siparisler.sube_id = ".$_GET["id"]."
                GROUP BY month(siparisler.tarih)";


                $sorgu = mysqli_query($baglanti, $sql_subeden_satis);
                
                foreach ($sorgu as $satir) {
                    echo "['".$satir["tarih"]."',".$satir["adet"].",".$kapasite_row["kapasite"]."],";
                }
                
                mysqli_close($baglanti)
            ?>
        ]);

        var options = {
            hAxis: {
                title: 'Zaman'
            },
            vAxis: {
                title: 'Adet',
                viewWindow: {
                    min: 200
                }
            },
            backgroundColor: 'transparent',
            lineWidth: 4,
          
        };

        var chart = new google.visualization.LineChart(document.getElementById('sube-yogunluk-grafik'));
        chart.draw(data, options);
    }
</script>
<div id="sube-yogunluk-grafik" class="golge flex-column min-height-400" style="flex: 1 0 50%; margin:10px;"></div>