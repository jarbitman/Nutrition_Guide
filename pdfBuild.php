<?php
$stylesheet="
.bluehead{
  font-size:12;
  font-family:\"tradegothic\";
  color:#FFFFFF;
  background-color:#0e2244;
  margin 2px;
}
th.bluehead{
  font-size:12;
  border-color:#0e2244;
  border-width: 1px;
  border-style: solid;
  background-color:#0e2244;
}
.greenhead{
  font-size:12;
  font-family:\"tradegothic\";
  color:#FFFFFF;
  padding: 5px;
}
.pageheader{
  font-family:tradegothic;
  color:#FFFFFF;
  font-weight:400;
  text-transform:uppercase;
  letter-spacing:1px;
  font-size:50;
  width:100%;
  height:30%;
  padding-top:25%;
  text-align:center;
}
th {
  background-color:#0e2244;
}
td{
  font-family: 'Lora';
  font-size:10;
  padding:3px;
}
tr.white{
  background-color:#FFFFFF;
  border-color:#FFFFFF;
  border-width: 1px;
  border-style: solid;
}
tr.grey{
  background-color:#e7e4e3;
  border-color:#e7e4e3;
  border-width: 1px;
  border-style: solid;
}
td.footer{
  color:#888584;
}
";
$pdfHead="
<body>";

$pdfFoot="</body>";

$html = '
<div style="background-image:url(\'./icons/bg-1000.jpg\');">
<div class="pageheader">NUTRITIONAL INFORMATION<br><span style="font-size:30;">'.date("Y").'</span></div>
<div class="pageheader" style="margin-top:25%;"><img src="./icons/PBK-Logo_Primary_White.png"  /></div></div>';
foreach ($groups as $key => $value) {
  $html.= "
  <pagebreak sheet-size=\"A4-P\" />
  <!--mpdf
  <htmlpagefooter name=\"myHTMLHeader\"><div style='width:100%;'>
  <table style='width:100%;'>
    <tr>
      <td class='footer'><img src='./icons/PBK-Logo_100.png' /></td>
      <td class='footer'>".date("Y")." Nutritional Info Chart</td>
      <td class='footer'>Printed: ".date("m/d/Y")."</td>
      </tr>
      </table>
    </div>
    </htmlpagefooter>
  mpdf-->
  <!--mpdf
  <sethtmlpagefooter name=\"myHTMLHeader\" page=\"O\" value=\"on\" show-this-page=\"1\" />
  <sethtmlpagefooter name=\"myHTMLHeader\" page=\"E\" value=\"on\" />
  mpdf-->
  <div style=\"width:100%;height:100%;background-color:#ffffff;\">
  <table style=\"width:100%;border-collapse:collapse;\">
    <thead>
      <tr>
        <th class=\"bluehead\" style='padding:3px;width:30%;'><span style='color:#0e2244;'>Name</span></th>
        <th class=\"bluehead\" style=''><span style='padding:2px;'>PROTEIN</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>CALORIES</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>TOTAL<br>FAT</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>SAT<br>FAT</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>TRANS<br>FAT</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>CHOLES-<br>TEROL</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>SODIUM</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>NET<br>CARBS</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>TOTAL<br>CARBS</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>DIETARY<br>FIBER</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>SUGARS</span></th>
        </tr>
      </thead>
      <tbody>
      <tr style=\"background-color:#b2d235;color:#FFFFFF;\">
        <td class=\"greenhead\" colspan=\"12\">" . $value . "</td>
      </tr>";
      $count=0;
      foreach($items[$key] as $item){
        $trStyle=(($count % 2) == 0) ? "white" : "grey";
        $info = json_decode($item['itemInfo'], true);

        $itemName = stripslashes($item['itemName']);
        $html.= "        <tr class=\"".$trStyle."\">
          <td style='padding-top:5px;'><div class='itemName'>" . $itemName . "</div></td>\n";
          if(!$isApp){
            foreach (['PR', 'Cal', 'TF', 'SF', 'TRF', 'CHO', 'SOD', 'NC', 'TC', 'DF', 'SG'] as $key) {
              $html.= '          <td>' . stripslashes($info[$key]) . "</td>\n";
            }
        }
        $html.= "        </tr>\n";
        $html.= "<tr class=\"".$trStyle."\"><td colspan=\"12\"><i>Allergens: ".$info['allergens']."</i></td></tr>\n";
        $count++;
      }

    $html.="
    </table></div>";
}
$path = (getenv('MPDF_ROOT')) ? getenv('MPDF_ROOT') : __DIR__;
require_once __DIR__ . '/vendor/autoload.php';
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
$mpdf = new \Mpdf\Mpdf([
	'mode' => 's',
  'format' => 'A4-P',
	'margin_left' => 10,
	'margin_right' => 10,
	'margin_top' => 10,
	'margin_bottom' => 10,
	'margin_header' => 10,
	'margin_footer' => 10,
  'fontDir' => array_merge($fontDirs, [__DIR__.'/font']),
'fontdata' => $fontData + [
  'lora' => [
    'R' => 'lora-regular.ttf',
    'I' => 'lora-italic.ttf',
  ],
  'gothamblack' => [
    'R' => 'gotham-black.ttf',
    'I' => 'gotham-black.ttf',
  ],
  'tradegothic' => [
    'R' => 'tradegothic.ttf',
    'I' => 'tradegothici.ttf',
  ]
],
'default_font' => 'lora'
]);
$mpdf->SetTitle("PBK ".date("Y")." Nutritional Info Chart");
$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($pdfHead.$html.$pdfFoot);
$mpdf->Output("/var/www/html/c2.theproteinbar.com/RaupCWYghyVCKxyP6Vwa/PBK_Nutritional_Guide-".date("Ymd").".pdf");
$file = "/var/www/html/c2.theproteinbar.com/RaupCWYghyVCKxyP6Vwa/PBK_Nutritional_Guide-".date("Ymd").".pdf";
$filename = "PBK_Nutritional_Guide-".date("Ymd").".pdf";
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="' . $filename . '"');
header('Content-Transfer-Encoding: binary');
header('Accept-Ranges: bytes');
echo file_get_contents($file);
//print_r($items);
//echo $pdfHead.$html.$pdfFoot;
