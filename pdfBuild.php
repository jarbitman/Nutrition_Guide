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
  border-color:#0e2244;
  border-width: 1px;
  border-style: solid;
  background-color:#0e2244;
}
.greenhead{
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
";
$pdfHead="
<body style=\"background-image:url('./icons/bg-1000.jpg'); \">";

$pdfFoot="</body>";

$html = '<div class="pageheader">NUTRITIONAL INFORMATION<br><span style="font-size:30;">'.date("Y").'</span></div>
<div class="pageheader"><img src="./icons/PBK-Logo_Primary_White.png"></div>';
foreach ($groups as $key => $value) {
  $html.= "
  <pagebreak sheet-size=\"A4-P\" />
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
      foreach($items[$key] as $item){
        $info = json_decode($item['itemInfo'], true);

        $itemName = stripslashes($item['itemName']);
        $html.= "        <tr style=\"font-family: 'Lora';\">
          <td style='padding-top:5px;'><div class='itemName' id='" . strtolower(preg_replace("/[^a-z]/i", "", urlencode($itemName))) . "' data-title='". str_replace("+", " ", urlencode(strtoupper($itemName))) . "' data-options='" . $item['itemInfo'] . "'>" . $itemName . "</div></td>\n";
          if(!$isApp){
            foreach (['PR', 'Cal', 'TF', 'SF', 'TRF', 'CHO', 'SOD', 'NC', 'TC', 'DF', 'SG'] as $key) {
              $html.= '          <td>' . stripslashes($info[$key]) . "</td>\n";
            }
        }
        $html.= "        </tr>\n";
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
	'margin_left' => 0,
	'margin_right' => 0,
	'margin_top' => 0,
	'margin_bottom' => 0,
	'margin_header' => 0,
	'margin_footer' => 0,
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
$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($pdfHead.$html.$pdfFoot);
$mpdf->Output();
//print_r($items);
//echo $pdfHead.$html.$pdfFoot;
