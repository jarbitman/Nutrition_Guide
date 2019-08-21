<?php
$mysqli = new mysqli("10.80.0.3", "pbconnect", 'KS4DV42pYJ2eNSYB', "pbc2");
include("header.php");

$isApp = !empty($_GET['app']) && $_GET['app'] == "true";

$items = array();
$groups = ['', "BREAKFAST / COFFEE", "SHAKES", "BOWLS/BAR-RITOS", "CHILIS/SOUPS", "SALADS/WRAPS", "KIDS MENU"];

$stmt = $mysqli->stmt_init();
$stmt->prepare("SELECT itemName, itemInfo, itemSection FROM pbc_public_nutritional WHERE published=1 ORDER BY itemName");
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_object()){
  $items[$row->itemSection][] = array("itemName" => $row->itemName, "itemInfo" => $row->itemInfo);
}
?>
<h4>Click on an item's name to view the nutrition label</h4>
<div id="accordion">
<?php
foreach ($items as $key => $value) {
  echo "  <h3 style='background-color:#b2d235;color:#ffffff;'>" . $groups[$key] . "</h3>
  <div>
  <table id='nut-" . $key . "' class='table-stripeclass:alternate table-autostripe full_width'>
    <thead>
      <tr style='background-color:#0e2244;'>
      <th style='padding:3px;'></th>\n";
      if(!$isApp){ ?>
      <th class="table-sortable:alphanumeric mobileShowHide">PROTEIN</th>
      <th class="table-sortable:alphanumeric mobileShowHide">CALS</th>
      <th class="table-sortable:alphanumeric mobileShowHide">TOTAL FAT</th>
      <th class="table-sortable:alphanumeric mobileShowHide">SAT FAT</th>
      <th class="table-sortable:alphanumeric mobileShowHide">TRANS FAT</th>
      <th class="table-sortable:alphanumeric mobileShowHide">CHOLESTEROL</th>
      <th class="table-sortable:alphanumeric mobileShowHide">SODIUM</th>
      <th class="table-sortable:alphanumeric mobileShowHide">NET CARBS</th>
      <th class="table-sortable:alphanumeric mobileShowHide">TOTAL CARBS</th>
      <th class="table-sortable:alphanumeric mobileShowHide">DIETARY FIBER</th>
      <th class="table-sortable:alphanumeric mobileShowHide">SUGARS</th>
      <?php
    } ?>
      </tr>
    </thead>
    <tbody>
<?php
      foreach($value as $item){
        $info = json_decode($item['itemInfo'], true);

        $itemName = stripslashes($item['itemName']);
        echo "        <tr>
          <td style='padding-top:5px;'><div class='itemName' id='" . strtolower(preg_replace("/[^a-z]/i", "", urlencode($itemName))) . "' data-title='". str_replace("+", " ", urlencode(strtoupper($itemName))) . "' data-options='" . $item['itemInfo'] . "'>" . $itemName . "</div></td>\n";
          if(!$isApp){
            foreach (['PR', 'Cal', 'TF', 'SF', 'TRF', 'CHO', 'SOD', 'NC', 'TC', 'DF', 'SG'] as $key) {
              echo '          <td class="mobileShowHide">' . stripslashes($info[$key]) . "</td>\n";
            }
        }
        echo "        </tr>\n";
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
      <div><span class="nutrition-item-label">Protein</span> <span class="nutrition-item">{{PR}}</span></div>
      <div><span class="nutrition-item-label">Calories</span> <span class="nutrition-item">{{Cal}}</span></div>
      <div><span class="nutrition-item-label">Total Fat</span> <span class="nutrition-item">{{TF}}</span></div>
      <div class="indent-value"><span class="nutrition-item-label">Saturated Fat</span> <span class="nutrition-item">{{SF}}</span></div>
      <div class="indent-value"><span class="nutrition-item-label">Trans Fat</span> <span class="nutrition-item">{{TRF}}</span></div>
      <div><span class="nutrition-item-label">Cholesterol</span> <span class="nutrition-item">{{CHO}}</span></div>
      <div><span class="nutrition-item-label">Sodium</span> <span class="nutrition-item">{{SOD}}</span></div>
      <div><span class="nutrition-item-label">Net Carbs</span> <span class="nutrition-item">{{NC}}</span></div>
      <div><span class="nutrition-item-label">Total Carbs</span> <span class="nutrition-item">{{TC}}</span></div>
      <div class="indent-value"><span class="nutrition-item-label">Dietary Fiber</span> <span class="nutrition-item">{{DF}}</span></div>
      <div class="indent-value"><span class="nutrition-item-label">Sugars</span> <span class="nutrition-item">{{SG}}</span></div>
  </div>
  <hr style="border: 2px solid #B2D235;">
  <div>
    <p>
       <span class="nutrition-item">Allergens</span><br>
       {{ALLERGENS}}
    </p>
    <p>
       <span class="nutrition-item">Dietary Preferences</span><br>
       {{DIETARY}}
    </p>
  </div>
</div>
</div>
</div>
<?php

include("footer.php");
