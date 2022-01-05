<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  google.charts.load('current', {
    'packages': ['corechart', 'controls']
  });
  google.charts.setOnLoadCallback(drawTable);

  function drawTable() {
    var data = new google.visualization.DataTable();
    data.addColumn('number', 'Id');
    data.addColumn('string', 'Şube');
    data.addColumn('string', 'İl');
    data.addColumn('string', 'İlçe');
    data.addColumn('string', 'Yönetici');
    data.addColumn('string', 'Yoğunluk/Kapasite');
    data.addColumn('string', 'Personel Sayısı');
    data.addColumn('string', 'Personel Başına Yoğunluk');
    data.addColumn('string', 'İşlem');
    data.addRows([
      <?php
      include("baglanti.php");

      $sql_personel_sayi = "SELECT
                                subeler.*,iller.il_ad,ilceler.ilce_ad,
                                subelere_gore_aylik_subeden_satis.adet AS subeden_satis,
                                CONCAT(yoneticiler.yonetici_ad,' ',yoneticiler.yonetici_soyad) AS yonetici_ad_soyad,
                                personel_sayisi,
                                AVG(siparis_adet) / personel_sayisi AS personel_basina_ortalama_yogunluk
                            
                            FROM
                                subeler
                            LEFT JOIN subelere_gore_gunluk_siparis ON subelere_gore_gunluk_siparis.sube_id = subeler.sube_id
                            LEFT JOIN subelere_gore_toplam_personel ON subelere_gore_toplam_personel.sube_id = subeler.sube_id
                            LEFT JOIN subelere_gore_aylik_subeden_satis ON subelere_gore_aylik_subeden_satis.sube_id = subeler.sube_id
                            LEFT JOIN yoneticiler ON yoneticiler.yonetici_id = subeler.yonetici_id
                            LEFT JOIN ilceler on ilceler.ilce_id = subeler.ilce_id
                            LEFT JOIN iller on iller.il_id = ilceler.il_id
                            
                            WHERE
                                MONTH(subelere_gore_gunluk_siparis.tarih) = 12
                            
                            GROUP BY
                                subeler.sube_id,
                                MONTH(subelere_gore_gunluk_siparis.tarih)";

      $sorgu = mysqli_query($baglanti, $sql_personel_sayi);

      foreach ($sorgu as $satir) {

        $uyari = "";
        if ($satir["personel_basina_ortalama_yogunluk"] > 10) {
          $uyari = '<span class="uyari tehlike" style="margin-left:10px;" title="Personel başına düşen yoğunluk aşırı yüksek! Personel almalısınız!">&#129093;</span>';
        } else if ($satir["personel_basina_ortalama_yogunluk"] > 8.50) {
          $uyari = '<span class="uyari" style="margin-left:10px;" title="Personel başına düşen yoğunluk yüksek! Yakın zamanda personel almayı gözden geçirmelisiniz.">&#129093;</span>';
        } else if ($satir["personel_basina_ortalama_yogunluk"] < 6.50) {
          $uyari = '<span class="uyari" style="margin-left:10px;" title="Personel başına düşen yoğunluk düşük! Yakın zamanda personel çıkarmayı gözden geçirmelisiniz.">&#129095;</span>';
        } else if ($satir["personel_basina_ortalama_yogunluk"] < 3.50) {
          $uyari = '<span class="uyari tehlike" style="margin-left:10px;" title="Personel başına düşen yoğunluk aşırı yüksek! Personel çıkarmalısınız!">&#129095;</span>';
        }

        echo
        "[" . $satir["sube_id"] . ",'" . $satir["sube_ad"] . "','" . $satir["il_ad"] . "','"
          . $satir["ilce_ad"] . "','" . $satir["yonetici_ad_soyad"] . "','" . $satir["subeden_satis"] . " / "
          . $satir["kapasite"] . "','" . $satir["personel_sayisi"] . "','" . number_format($satir["personel_basina_ortalama_yogunluk"], 2) . $uyari ."','".
          "<a class=\"button\" style=\"margin-right:10px; background-color: green;\" href=\"sube.php?id=" . $satir["sube_id"] . "\">Git</a><a class=\"tehlike button\" href=\"sube_sil.php?sube_id=" . $satir["sube_id"] . "\" onclick=\"return confirm(\'Are you sure?\')\">Sil</a>" . "'],";
      }

      mysqli_close($baglanti)
      ?>
    ]);

    var dashboard = new google.visualization.Dashboard(document.querySelector('#sube-calisanlar-tablo-dash'));

    var stringFilter = new google.visualization.ControlWrapper({
      controlType: 'StringFilter',
      containerId: 'sube-arama-div',
      options: {
        filterColumnIndex: 1
      }
    });


    var stringFilter2 = new google.visualization.ControlWrapper({
      controlType: 'StringFilter',
      containerId: 'il-arama-div',
      options: {
        filterColumnIndex: 2
      }
    });


    var stringFilter3 = new google.visualization.ControlWrapper({
      controlType: 'StringFilter',
      containerId: 'ilce-arama-div',
      options: {
        filterColumnIndex: 3
      }
    });


    /* NOT: GOOGLE CHART CSS
        https://developers.google.com/chart/interactive/docs/gallery/table?hl=en
        
        headerRow - Assigns a class name to the table header row (<tr> element).
        tableRow - Assigns a class name to the non-header rows (<tr> elements).
        oddTableRow - Assigns a class name to odd table rows (<tr> elements). Note: the alternatingRowStyle option must be set to true.
        selectedTableRow - Assigns a class name to the selected table row (<tr> element).
        hoverTableRow - Assigns a class name to the hovered table row (<tr> element).
        headerCell - Assigns a class name to all cells in the header row (<td> element).
        tableCell - Assigns a class name to all non-header table cells (<td> element).
        rowNumberCell - Assigns a class name to the cells in the row number column (<td> element). Note: the showRowNumber option must be set to true.
        
        Example: var cssClassNames = {headerRow: 'bigAndBoldClass',hoverTableRow: 'highlightClass'};
    

    var cssClassNames = {
      headerRow: 'tablo-baslik'
    };
*/

    var table = new google.visualization.ChartWrapper({
      chartType: 'Table',
      containerId: 'sube-calisanlar-tablo',
      options: {
        // NOT: soldaki cssClassNames tabloya ait sağdaki ise yukarıdaki yerel değişken aynı isimde olsalarda js sorun çıkarmıyor
        // bu şekilde de renk veremedim
        // cssClassNames: cssClassNames,
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

<div class="sube-calisanlar-tablo-dash">
  <ul class="flex-row" style="justify-content:left; margin:8px; padding:4px">
    <li style="margin-left:20px;">
      <div id="sube-arama-div"></div>
    </li>
    <li style="margin-left:20px;">

      <div id="il-arama-div"></div>
    </li>
    <li style="margin-left: 20px;">
      <div id="ilce-arama-div"></div>

    </li>
  </ul>
  <div id="sube-calisanlar-tablo"></div>
</div>