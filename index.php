<?php
$mysqli = new mysqli("10.80.0.3", "pbconnect", 'KS4DV42pYJ2eNSYB', "pbc2");
include("header.php");

$isApp = !empty($_GET['app']) && $_GET['app'] == "true";

$items = array();
$groups = [1=>"BREAKFAST SCRAMBLES", 8=>"BREAKFAST OATMEAL", 2=>"SHAKES", 3=>"BOWLS/BAR-RITOS", 5=>"SALADS/WRAPS",4=>"CHILIS/SOUPS",  6=>"KIDS MENU", 7=>"COFFEE"];

$stmt = $mysqli->stmt_init();
$stmt->prepare("SELECT itemName, itemInfo, itemSection FROM pbc_public_nutritional WHERE published=1 ORDER BY itemSection,itemName");
$stmt->execute();
$result = $stmt->get_result();
while($row = $result->fetch_object()){
  $items[$row->itemSection][] = array("itemName" => $row->itemName, "itemInfo" => $row->itemInfo);
}
?>
<h4>Click on an item's name to view the nutrition label</h4>
<div id="accordion">
<?php
foreach ($groups as $key => $value) {
  echo "  <h3 style='background-color:#b2d235;color:#ffffff;'>" . $value . "</h3>
  <div>
  <table id='nut-" . $key . "' class='table-autosort:0 table-stripeclass:alternate table-autostripe full_width'>
    <thead>
      <tr style='background-color:#0e2244;'>
        <th style='padding:3px;'></th>\n";
      if(!$isApp){ ?>
        <th class="table-sortable:alphanumeric mobileShowHide"><span style="padding-left:15px;">PROTEIN</span></th>
        <th class="table-sortable:alphanumeric mobileShowHide"><span style="padding-left:15px;">CALS</span></th>
        <th class="table-sortable:alphanumeric mobileShowHide"><span style="padding-left:15px;">TOTAL FAT</span></th>
        <th class="table-sortable:alphanumeric mobileShowHide"><span style="padding-left:15px;">SAT FAT</span></th>
        <th class="table-sortable:alphanumeric mobileShowHide"><span style="padding-left:15px;">TRANS FAT</span></th>
        <th class="table-sortable:alphanumeric mobileShowHide"><span style="padding-left:15px;">CHOLESTEROL</span></th>
        <th class="table-sortable:alphanumeric mobileShowHide"><span style="padding-left:15px;">SODIUM</span></th>
        <th class="table-sortable:alphanumeric mobileShowHide"><span style="padding-left:15px;">NET CARBS</span></th>
        <th class="table-sortable:alphanumeric mobileShowHide"><span style="padding-left:15px;">TOTAL CARBS</span></th>
        <th class="table-sortable:alphanumeric mobileShowHide"><span style="padding-left:15px;">DIETARY FIBER</span></th>
        <th class="table-sortable:alphanumeric mobileShowHide"><span style="padding-left:15px;">SUGARS</span></th>
      <?php
    } ?>
      </tr>
    </thead>
    <tbody>
<?php
      foreach($items[$key] as $item){
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
<div class="nutrition-item" style="size:-1.5em">Please note that these nutrition values are estimated based on our standard serving portions. As food servings may have a slight variance each time you visit, please expect these values to be with in 10% +/- of your actual meal. If you have any questions about our nutrition calculator, please contact hq@theproteinbar.com</div>
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
       <span class="nutrition-item"><strong>Allergens</strong><br>{{allergens}}</span>
    </p>
    <p>
       <span class="nutrition-item"><strong>Dietary Preferences</strong><br>{{preferences}}</span>
    </p>
  </div>
</div>
</div>
</div>
<?php

include("footer.php");
