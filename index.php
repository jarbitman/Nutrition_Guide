<?php
$mysqli = new mysqli("10.80.0.3", "pbconnect", 'KS4DV42pYJ2eNSYB', "pbc2");
include("header.php");
$groups[1]="BREAKFAST / COFFEE";
$groups[2]="SHAKES";
$groups[3]="BOWLS/BAR-RITOS";
$groups[4]="CHILIS/SOUPS";
$groups[5]="SALADS/WRAPS";
$groups[6]="KIDS MENU";
echo "
<style>
th {
  color:#FFFFFF;
}
tr.alternate{
  background-color:#ccf
}
</style>
<div id=\"accordion\">";
foreach ($groups as $key => $value) {
  echo "  <h3 style='background-color:#b2d235;color:#FFFFFF;'>$value</h3>
  <div>
  <table id=\"nut-".$key."\" class=\"table-autosort:2 table-stripeclass:alternate table-autostripe full_width\" style='width:100%;'>
    <thead>
      <tr style='background-color:#0e2244;'>
      <th class=\"\"  style='padding:3px;'></th>
      <th class=\"table-sortable:numeric\"  style=''>PROTEIN</th>
      <th class=\"table-sortable:numeric\"  style=''>CALS</th>
      <th class=\"table-sortable:numeric\"  style=''>TOTAL<br>FAT</th>
      <th class=\"table-sortable:numeric\"  style=''>SAT<br>FAT</th>
      <th class=\"table-sortable:numeric\"  style=''>TRANS<br>FAT</th>
      <th class=\"table-sortable:numeric\"  style=''>CHOLES-<br>TEROL</th>
      <th class=\"table-sortable:numeric\"  style=''>SODIUM</th>
      <th class=\"table-sortable:numeric\"  style=''>NET<br>CARBS</th>
      <th class=\"table-sortable:numeric\"  style=''>TOTAL<br>CARBS</th>
      <th class=\"table-sortable:numeric\"  style=''>DIETARY<br>FIBER</th>
      <th class=\"table-sortable:numeric\"  style=''>SUGARS</th>
      </tr>
      </thead>
      <tbody>
      ";
      $q="SELECT itemName,itemInfo FROM pbc_public_nutritional WHERE published=1 and itemSection='".$key."'";
      $stmt = $mysqli->stmt_init();
      $stmt->prepare($q);
      $stmt->execute();
      $result = $stmt->get_result();
      while($row=$result->fetch_object()){
        $info=json_decode($row->itemInfo);
        echo "
          <tr>
          <td style='padding-top:5px;'><div  class='itemName' id='".strtolower(preg_replace("/[^a-z]/i", "", stripslashes($row->itemName)))."' data-options='".$row->itemInfo."'>".stripslashes($row->itemName)."</div></td>
          <td>".stripslashes($info->PR)."</td>
          <td>".stripslashes($info->Cal)."</td>
          <td>".stripslashes($info->TF)."</td>
          <td>".stripslashes($info->SF)."</td>
          <td>".stripslashes($info->TRF)."</td>
          <td>".stripslashes($info->CHO)."</td>
          <td>".stripslashes($info->SOD)."</td>
          <td>".stripslashes($info->NC)."</td>
          <td>".stripslashes($info->TC)."</td>
          <td>".stripslashes($info->DF)."</td>
          <td>".stripslashes($info->SG)."</td>
          </tr>
        ";
      }

echo   "
        </tbody>
      </table>
  </div>";
}
echo "</div>";

include("footer.php");
