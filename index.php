<?php
$mysqli = new mysqli("10.80.0.3", "pbconnect", 'KS4DV42pYJ2eNSYB', "pbc2");
include("header.php");

$isApp = !empty($_GET['app']) && $_GET['app'] == "true";

$items = array();
$groups[1]="BREAKFAST / COFFEE";
$groups[2]="SHAKES";
$groups[3]="BOWLS/BAR-RITOS";
$groups[4]="CHILIS/SOUPS";
$groups[5]="SALADS/WRAPS";
$groups[6]="KIDS MENU";
$q = "SELECT itemName,itemInfo,itemSection FROM pbc_public_nutritional WHERE published=1 ORDER BY itemName";
$stmt = $mysqli->stmt_init();
$stmt->prepare($q);
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_object()){
  $items[$row->itemSection][] = array("itemName" => $row->itemName, "itemInfo" => $row->itemInfo);
}
?>
<style>
th {
  color: #FFFFFF;
}
tr.alternate{
  background-color: #ccf;
}
td {
  font-family: "Lora";
}
.itemName:hover {
  text-decoration: underline;
}
.indent-value {
  text-indent: 15px;
}
.ui-widget-header{
  font-family: "Trade Gothic Bold Condensed";
  font-size: 1.75em;
  text-transform: uppercase;
  overflow-wrap: break-word;
  background-color: #F36C21;
  color: #FFFFFF;
}
.ui-dialog .ui-dialog-title {
  white-space: wrap;
  overflow: wrap;
}
.nutrition-item-label {
  font-family: "Trade Gothic Bold Condensed";
  color:#0E2244;
  font-size:1.5em;
  text-transform:uppercase;
  letter-spacing:2px;
}
.nutrition-item {
  font-family: "Lora";
  font-size: 1rem;
  line-height:1.5;
  color:#444;
}
@media all and (max-width: 767px) {
  td.mobileShowHide{
    display:none;
    width: 0;
    height: 0;
    opacity: 0;
    visibility: collapse;
  }
  th.mobileShowHide{
    display: none;
    width: 0;
    height: 0;
    opacity: 0;
    visibility: collapse;
  }
}
</style>
<h4>Click on an item's name to view the nutrition label</h4>
<div id="accordion">
<?php
foreach ($items as $key => $value) {
  echo "  <h3 style='background-color:#b2d235;color:#FFFFFF;'>" . $groups[$key] . "</h3>
  <div>
  <table id=\"nut-".$key."\" class=\"table-stripeclass:alternate table-autostripe full_width\" style='width:100%;'>
    <thead>
      <tr style='background-color:#0e2244;'>
      <th class=\"\" style='padding:3px;'></th>
      ";
      if(!$isApp){ ?>
      <th class="table-sortable:numeric mobileShowHide" style="font-family: 'Trade Gothic Bold Condensed';">PROTEIN</th>
      <th class="table-sortable:numeric mobileShowHide" style="font-family: 'Trade Gothic Bold Condensed';">CALS</th>
      <th class="table-sortable:numeric mobileShowHide" style="font-family: 'Trade Gothic Bold Condensed';">TOTAL FAT</th>
      <th class="table-sortable:numeric mobileShowHide" style="font-family: 'Trade Gothic Bold Condensed';">SAT FAT</th>
      <th class="table-sortable:numeric mobileShowHide" style="font-family: 'Trade Gothic Bold Condensed';">TRANS FAT</th>
      <th class="table-sortable:numeric mobileShowHide" style="font-family: 'Trade Gothic Bold Condensed';">CHOLESTEROL</th>
      <th class="table-sortable:numeric mobileShowHide" style="font-family: 'Trade Gothic Bold Condensed';">SODIUM</th>
      <th class="table-sortable:numeric mobileShowHide" style="font-family: 'Trade Gothic Bold Condensed';">NET CARBS</th>
      <th class="table-sortable:numeric mobileShowHide" style="font-family: 'Trade Gothic Bold Condensed';">TOTAL CARBS</th>
      <th class="table-sortable:numeric mobileShowHide" style="font-family: 'Trade Gothic Bold Condensed';">DIETARY FIBER</th>
      <th class="table-sortable:numeric mobileShowHide" style="font-family: 'Trade Gothic Bold Condensed';">SUGARS</th>
      <?php
    } ?>
      </tr>
      </thead>
      <tbody>
<?php
      foreach($value as $item){
        $info=json_decode($item['itemInfo']);

        $itemName = stripslashes($item['itemName']);
        echo "
          <tr>
          <td style='padding-top:5px;'><div class='itemName' id='" . strtolower(preg_replace("/[^a-z]/i", "", urlencode($itemName))) . "' data-title='". str_replace("+", " ", urlencode(strtoupper($itemName))) . "' data-options='" . $item['itemInfo'] . "'>" . $itemName . "</div></td>
          ";
          if(!$isApp){
      echo "
          <td class=\"mobileShowHide\">" . stripslashes($info->PR) . "</td>
          <td class=\"mobileShowHide\">" . stripslashes($info->Cal) . "</td>
          <td class=\"mobileShowHide\">" . stripslashes($info->TF) . "</td>
          <td class=\"mobileShowHide\">" . stripslashes($info->SF) . "</td>
          <td class=\"mobileShowHide\">" . stripslashes($info->TRF) . "</td>
          <td class=\"mobileShowHide\">" . stripslashes($info->CHO) . "</td>
          <td class=\"mobileShowHide\">" . stripslashes($info->SOD) . "</td>
          <td class=\"mobileShowHide\">" . stripslashes($info->NC) . "</td>
          <td class=\"mobileShowHide\">" . stripslashes($info->TC) . "</td>
          <td class=\"mobileShowHide\">" . stripslashes($info->DF) . "</td>
          <td class=\"mobileShowHide\">" . stripslashes($info->SG) . "</td>
          ";
        }
        echo    "
          </tr>
        ";
      }
?>
        </tbody>
      </table>
  </div>
<?php
}
?>
</div>
<div id="nutrition-dialog">
</div>
<div id="modalNutritionLabelParent" style="display:none;">
<div id="modalNutritionLabel" class="ui-dialog-content ui-widget-content" style="width:auto;min-height:49px;height:auto;" scrolltop="0" scrollleft="0">

<div class="labelWrap fl" style="width: 300px;">

	<input type="hidden" id="valueName" value="{{itemName}}">
  <div>
      <div><span class="nutrition-item-label">Protein</span> <span class="nutrition-item" >{{PR}}</span></div>
      <div><span class="nutrition-item-label">Calories</span> <span class="nutrition-item" >{{Cal}}</span></div>
      <div><span class="nutrition-item-label">Total Fat</span> <span class="nutrition-item" >{{TF}}</span></div>
      <div style="text-indent: 15px;"><span class="nutrition-item-label">Saturated Fat</span> <span class="nutrition-item" >{{SF}}</span></div>
      <div style="text-indent: 15px;"><span class="nutrition-item-label">Trans Fat</span> <span class="nutrition-item" >{{TRF}}</span></div>
      <div><span class="nutrition-item-label">Cholesterol</span> <span class="nutrition-item" >{{CHO}}</span></div>
      <div><span class="nutrition-item-label">Sodium</span> <span class="nutrition-item" >{{SOD}}</span></div>
      <div><span class="nutrition-item-label">Net Carbs</span> <span class="nutrition-item" >{{NC}}</span></div>
      <div><span class="nutrition-item-label">Total Carbs</span> <span class="nutrition-item" >{{TC}}</span></div>
      <div style="text-indent: 15px;"><span class="nutrition-item-label">Dietary Fiber</span> <span class="nutrition-item" >{{DF}}</span></div>
      <div style="text-indent: 15px;"><span class="nutrition-item-label">Sugars</span> <span class="nutrition-item" >{{SG}}</span></div>
  </div>
  <hr style="border: 2px solid #B2D235;">
  <div>
    <p>
       <span class="nutrition-item" >Allergens</span><br>
       {{ALLERGENS}}
    </p>
    <p>
       <span class="nutrition-item" >Dietary Preferences</span><br>
       {{DIETARY}}
    </p>
  </div>
</div>
</div>
</div>
<?php

include("footer.php");
