<?php
$mysqli = new mysqli("10.80.0.3", "pbconnect", 'KS4DV42pYJ2eNSYB', "pbc2");
include("header.php");
$items=array();
$groups[1]="BREAKFAST / COFFEE";
$groups[2]="SHAKES";
$groups[3]="BOWLS/BAR-RITOS";
$groups[4]="CHILIS/SOUPS";
$groups[5]="SALADS/WRAPS";
$groups[6]="KIDS MENU";
$q="SELECT itemName,itemInfo,itemSection FROM pbc_public_nutritional WHERE published=1 ORDER BY itemName";
$stmt = $mysqli->stmt_init();
$stmt->prepare($q);
$stmt->execute();
$result = $stmt->get_result();
while($row=$result->fetch_object()){
  $items[$row->itemSection][]=array("itemName"=>$row->itemName,"itemInfo"=>$row->itemInfo);
}
echo "
<style>
th {
  color:#FFFFFF;

}
tr.alternate{
  background-color:#ccf
}
.ui-widget-header{
  font-family:\"Gotham Black\";font-weight:500;
  background-color:#F36C21;
  color:#FFFFFF;
}
@media all and (max-width: 767px) {
  td.mobileShowHide{
    display:none;
    width:0;
    height:0;
    opacity:0;
    visibility: collapse;
  }
  th.mobileShowHide{
    display:none;
    width:0;
    height:0;
    opacity:0;
    visibility: collapse;
  }
}
</style>
<h4>Click on an item's name to view the nutrition label</h4>
<div id=\"accordion\">";
foreach ($items as $key => $value) {
  echo "  <h3 style='background-color:#b2d235;color:#FFFFFF;'>".$groups[$key]."</h3>
  <div>
  <table id=\"nut-".$key."\" class=\"table-stripeclass:alternate table-autostripe full_width\" style='width:100%;'>
    <thead>
      <tr style='background-color:#0e2244;'>
      <th class=\"\"  style='padding:3px;'></th>
      ";
      if(!isset($_GET['app']) || $_GET['app']!="true"){
  echo    "
      <th class=\"table-sortable:numeric mobileShowHide\"  style=''>PROTEIN</th>
      <th class=\"table-sortable:numeric mobileShowHide\"  style=''>CALS</th>
      <th class=\"table-sortable:numeric mobileShowHide\"  style=''>TOTAL<br>FAT</th>
      <th class=\"table-sortable:numeric mobileShowHide\"  style=''>SAT<br>FAT</th>
      <th class=\"table-sortable:numeric mobileShowHide\"  style=''>TRANS<br>FAT</th>
      <th class=\"table-sortable:numeric mobileShowHide\"  style=''>CHOLES-<br>TEROL</th>
      <th class=\"table-sortable:numeric mobileShowHide\"  style=''>SODIUM</th>
      <th class=\"table-sortable:numeric mobileShowHide\"  style=''>NET<br>CARBS</th>
      <th class=\"table-sortable:numeric mobileShowHide\"  style=''>TOTAL<br>CARBS</th>
      <th class=\"table-sortable:numeric mobileShowHide\"  style=''>DIETARY<br>FIBER</th>
      <th class=\"table-sortable:numeric mobileShowHide\"  style=''>SUGARS</th>
      <th class=\"table-sortable:numeric mobileShowHide\"  style=''>ALLERGENS</th>
      ";
    }
    echo    "
      </tr>
      </thead>
      <tbody>
      ";
      foreach($value as $item){
        $info=json_decode($item['itemInfo']);
        echo "
          <tr>
          <td style='padding-top:5px;'><div  class='itemName' id='".strtolower(preg_replace("/[^a-z]/i", "", stripslashes($item['itemName'])))."' data-title='".stripslashes($item['itemName'])."' data-options='".$item['itemInfo']."'>".stripslashes($item['itemName'])."</div></td>
          ";
          if(!isset($_GET['app']) || $_GET['app']!="true"){
      echo    "
          <td class=\"mobileShowHide\">".stripslashes($info->PR)."</td>
          <td class=\"mobileShowHide\">".stripslashes($info->Cal)."</td>
          <td class=\"mobileShowHide\">".stripslashes($info->TF)."</td>
          <td class=\"mobileShowHide\">".stripslashes($info->SF)."</td>
          <td class=\"mobileShowHide\">".stripslashes($info->TRF)."</td>
          <td class=\"mobileShowHide\">".stripslashes($info->CHO)."</td>
          <td class=\"mobileShowHide\">".stripslashes($info->SOD)."</td>
          <td class=\"mobileShowHide\">".stripslashes($info->NC)."</td>
          <td class=\"mobileShowHide\">".stripslashes($info->TC)."</td>
          <td class=\"mobileShowHide\">".stripslashes($info->DF)."</td>
          <td class=\"mobileShowHide\">".stripslashes($info->SG)."</td>
          <td class=\"mobileShowHide\"></td>
          ";
        }
        echo    "
          </tr>
        ";
      }

echo   "
        </tbody>
      </table>
  </div>";
}
echo "</div>";

?>
<div id="nutrition-dialog">
</div>
<div id="modalNutritionLabelParent" style="display:none;">
<div id="modalNutritionLabel" class="ui-dialog-content ui-widget-content" style="width:auto;min-height:49px;height:auto;" scrolltop="0" scrollleft="0">

<div class="labelWrap fl" style="width: 300px;">

	<input type="hidden" id="valueName" value="{{itemName}}">

	<div id="nutritionLabel"><div itemscope="" itemtype="http://schema.org/NutritionInformation" class="nutritionLabel" style=" width: 310px;">

	<div class="bar1"></div>
	<div class="line m" tabindex="0"><strong>Amount Per Serving</strong></div>
  <div class="line">
  		<div class="fr" tabindex="0">
  </div>
  		<div class="" tabindex="0">
  <strong>Calories</strong> <span itemprop="calories">{{Cal}}</span></div>
  	</div>
	<div class="bar2"></div>
	<div class="line ar "><strong>% Daily Value<sup>*</sup></strong></div>
	<div class="line" tabindex="0">
		<div class="dv" aria-hidden="true"><strong>{{totalfatperc}}</strong>%</div>
		<strong>Total Fat</strong> <span itemprop="fatContent">{{TF}}<span aria-hidden="true">g</span><span class="sr-only"> grams</span>
	</span></div>
	<div class="line indent" tabindex="0">
		<div class="dv" aria-hidden="true"><strong>{{satfatperc}}</strong>%</div>
		Saturated Fat <span itemprop="saturatedFatContent">{{SF}}<span aria-hidden="true">g</span><span class="sr-only"> grams</span>
	</span></div>
	<div class="line indent" tabindex="0">
		<em>Trans</em> Fat <span itemprop="transFatContent">{{TRF}}<span aria-hidden="true">g</span><span class="sr-only"> grams</span>
	</span></div>
	<div class="line" tabindex="0">
		<div class="dv" aria-hidden="true"><strong>{{cholesterolperc}}</strong>%</div>
		<strong>Cholesterol</strong> <span itemprop="cholesterolContent">{{CHO}}<span aria-hidden="true">mg</span><span class="sr-only"> milligrams</span>
	</span></div>
	<div class="line" tabindex="0">
		<div class="dv" aria-hidden="true"><strong>{{sodiumperc}}</strong>%</div>
		<strong>Sodium</strong> <span itemprop="sodiumContent">{{SOD}}<span aria-hidden="true">mg</span><span class="sr-only"> milligrams</span>
	</span></div>
	<div class="line" tabindex="0">
		<div class="dv" aria-hidden="true"><strong>{{carbsperc}}</strong>%</div>
		<strong>Net Carbohydrates</strong> <span itemprop="carbohydrateContent">{{NC}}<span aria-hidden="true">g</span><span class="sr-only"> grams</span>
	</span></div>
	<div class="line indent" tabindex="0">
		<div class="dv" aria-hidden="true"><strong>{{fiberperc}}</strong>%</div>
		Dietary Fiber <span itemprop="fiberContent">{{DF}}<span aria-hidden="true">g</span><span class="sr-only"> grams</span>
	</span></div>
	<div class="line indent" tabindex="0">
		Sugars <span itemprop="sugarContent">{{SG}}<span aria-hidden="true">g</span><span class="sr-only"> grams</span>
	</span></div>
	<div class="line" tabindex="0">
<strong>Protein</strong> <span itemprop="proteinContent">{{PR}}<span aria-hidden="true">g</span><span class="sr-only"> grams</span></span></div>
	<div class="bar1"></div>
	<div class="dvCalorieDiet line">
		<div class="calorieNote">
			<span tabindex="0"><span class="star" aria-hidden="true">*</span> Percent Daily Values are based on a 2000 calorie diet.</span>
		</div>

	</div>

</div>
</div>
</div>
</div>
</div>
<?php

include("footer.php");
