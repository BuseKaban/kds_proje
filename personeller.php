<?php
include("denetle_yonlendir.php");
include("head.php");
include("moduller/yan_menu.php");
?>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<div class = 'sayfa flex-column'>
    <div class = 'golge genislik-tam'>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {
    'packages': ['corechart', 'controls']
  });
  google.charts.setOnLoadCallback(drawTable);

  function drawTable() {
    var data = new google.visualization.DataTable();
    data.addColumn('number', 'Id');
    data.addColumn('string', 'Ad');
    data.addColumn('string', 'Soyad');
    data.addColumn('string', 'Şube');
    data.addColumn('string', 'Cinsiyet');
    data.addRows([
      <?php
      include("baglanti.php");

      $sql_personel_bilgi = "SELECT personel_id, personel_ad, personel_soyad, sube_ad, cinsiyet
                            FROM personeller 
                            LEFT JOIN subeler on personeller.sube_id = subeler.sube_id
                            LEFT JOIN cinsiyet on cinsiyet.cinsiyet_id = personeller.cinsiyet_id";

      $sorgu = mysqli_query($baglanti, $sql_personel_bilgi);

      foreach ($sorgu as $satir) {
        echo "[" . $satir["personel_id"] . ",'" . $satir["personel_ad"] . "','" . $satir["personel_soyad"] . "','" . $satir["sube_ad"] . "','" . $satir["cinsiyet"] ."'],";
      }

      mysqli_close($baglanti)
      ?>
    ]);

    var dashboard = new google.visualization.Dashboard(document.querySelector('#personeller-tablo-dash'));

    var stringFilter = new google.visualization.ControlWrapper({
      controlType: 'StringFilter',
      containerId: 'ad-arama-div',
      options: {
        filterColumnIndex: 1
      }
    });


    var stringFilter2 = new google.visualization.ControlWrapper({
      controlType: 'StringFilter',
      containerId: 'soyad-arama-div',
      options: {
        filterColumnIndex: 2
      }
    });

  
    var stringFilter3 = new google.visualization.ControlWrapper({
      controlType: 'StringFilter',
      containerId: 'sube-arama-div',
      options: {
        filterColumnIndex: 3
      }
    });


    var table = new google.visualization.ChartWrapper({
      chartType: 'Table',
      containerId: 'personeller-tablo',
      options: {
        width: '100%',
        height: '100%',
        allowHtml: true,
      }
    });

    dashboard.bind(stringFilter, table);
    dashboard.bind(stringFilter2, table);
    dashboard.bind(stringFilter3, table);

    dashboard.draw(data);

  }
</script>
</head>

<div class="golge personeller-tablo-dash">
  <ul class="flex-row" style="justify-content:left; margin:8px; padding:4px">
    <li style="margin-left:20px;">
      <div id="ad-arama-div"></div>
    </li>
    <li style="margin-left:20px;">

      <div id="soyad-arama-div"></div>
    </li>
    <li style="margin-left: 20px;">
      <div id="sube-arama-div"></div>

    </li>
  </ul>
  <div id="personeller-tablo"></div>
</div>
    </div>
</div>