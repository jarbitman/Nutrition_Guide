<?php
$stylesheet="
@font-face{font-family:\"Gotham Black\";src:url(\"./font/Gotham-Black.ttf\") format(\"truetype\")}
@font-face{font-family:\"Lora\";src:url(\"./font/Lora-Regular.ttf\") format(\"truetype\");font-weight:700}
@font-face{font-family:\"Trade Gothic Bold Condensed Oblique\";src:url(\"./font/TradeGothicBoldCondensedNo20Oblique.ttf\") format(\"truetype\")}
@font-face{font-family:\"Trade Gothic Bold Condensed\";src:url(\"./font/TradeGothicBoldCondensedNo20.ttf\") format(\"truetype\")}
.bluehead{
  font-family:\"Lora\";
  color:#FFFFFF;
}
.greenhead{
  font-family:\"Gotham Black\";
  color:#FFFFFF;
}
";
$pdfHead="
<body style=\"background-image:url('./icons/bg-1000.jpg'); \">";

$pdfFoot="</body>";
require_once __DIR__ . '/vendor/autoload.php';

$html = '<div style="font-family:Trade Gothic Bold Condensed;color:#FFFFFF;font-weight:400;text-transform:uppercase;letter-spacing:2px;font-size:30;">NUTRITIONAL INFORMATION</div>
';
foreach ($groups as $key => $value) {
  $html.= "
  <pagebreak sheet-size=\"A4-P\" />
  <div style=\"width:100%;height:100%;background-color:#FFFFFF;\">
  <table style=\"width:100%;\">
    <thead>
      <tr style=\"background-color:#0e2244;\">
        <th style='padding:3px;'></th>\n
        <th class=\"bluehead\"><span style='padding-left:15px;'>PROTEIN</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>CALS</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>TOTAL FAT</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>SAT FAT</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>TRANS FAT</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>CHOLESTEROL</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>SODIUM</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>NET CARBS</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>TOTAL CARBS</span></th>
        <th class=\"bluehead\"><span style='padding-left:15px;'>DIETARY FIBER</span></th>
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
$mpdf = new \Mpdf\Mpdf([
	'mode' => 'c',
  'format' => 'A4-P',
	'margin_left' => 0,
	'margin_right' => 0,
	'margin_top' => 0,
	'margin_bottom' => 5,
	'margin_header' => 0,
	'margin_footer' => 0
]);
$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($pdfHead.$html.$pdfFoot);
$mpdf->Output();
//print_r($items);
//echo $pdfHead.$html.$pdfFoot;
