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

?>
<div id="nutrition-dialog">
</div>
<div id="modalNutritionLabelParent">
<div id="modalNutritionLabel" class="ui-dialog-content ui-widget-content" style="width:auto;min-height:49px;height:auto;" scrolltop="0" scrollleft="0">

<div class="labelWrap fl" style="width: 280px;">

	<input type="hidden" id="valueName" value="{{itemName}}">

	<div id="nutritionLabel"><div itemscope="" itemtype="http://schema.org/NutritionInformation" class="nutritionLabel" style=" width: 260px;">
	<div class="title" tabindex="0">Nutrition Facts</div>
	<div class="serving" tabindex="0">
		<div class="cf">
			<div class="servingSizeText fl">Serving Size:</div>
			<div class="rel servingSizeField fl">1</div><!-- closing class="setter" -->
		</div><!-- closing class="cf" -->

	</div><!-- closing class="serving" -->

	<div class="bar1"></div>
	<div class="line m" tabindex="0"><strong>Amount Per Serving</strong></div>
	<div class="line">
		<div class="fr" tabindex="0">
		<div class="" tabindex="0">
      <strong>Calories</strong> <span itemprop="calories">{{calories}}</span></div>
	</div>
	<div class="bar2"></div>
	<div class="line ar "><strong>% Daily Value<sup>*</sup></strong></div>
	<div class="line" tabindex="0">
		<div class="dv" aria-hidden="true"><strong>{{totalfatperc}}</strong>%</div>
		<strong>Total Fat</strong> <span itemprop="fatContent">{{totalfat}}<span aria-hidden="true">g</span><span class="sr-only"> grams</span>
	</span></div>
	<div class="line indent" tabindex="0">
		<div class="dv" aria-hidden="true"><strong>{{satfatperc}}</strong>%</div>
		Saturated Fat <span itemprop="saturatedFatContent">{{satfat}}<span aria-hidden="true">g</span><span class="sr-only"> grams</span>
	</span></div>
	<div class="line indent" tabindex="0">
		<em>Trans</em> Fat <span itemprop="transFatContent">{{tranfat}}<span aria-hidden="true">g</span><span class="sr-only"> grams</span>
	</span></div>
	<div class="line" tabindex="0">
		<div class="dv" aria-hidden="true"><strong>{{cholesterolperc}}</strong>%</div>
		<strong>Cholesterol</strong> <span itemprop="cholesterolContent">{{cholesterol}}<span aria-hidden="true">mg</span><span class="sr-only"> milligrams</span>
	</span></div>
	<div class="line" tabindex="0">
		<div class="dv" aria-hidden="true"><strong>{{sodiumperc}}</strong>%</div>
		<strong>Sodium</strong> <span itemprop="sodiumContent">{{sodium}}<span aria-hidden="true">mg</span><span class="sr-only"> milligrams</span>
	</span></div>
	<div class="line" tabindex="0">
		<div class="dv" aria-hidden="true"><strong>{{carbsperc}}</strong>%</div>
		<strong>Total Carbohydrates</strong> <span itemprop="carbohydrateContent">{{carbs}}<span aria-hidden="true">g</span><span class="sr-only"> grams</span>
	</span></div>
	<div class="line indent" tabindex="0">
		<div class="dv" aria-hidden="true"><strong>{{fiberperc}}</strong>%</div>
		Dietary Fiber <span itemprop="fiberContent">{{fiber}}<span aria-hidden="true">g</span><span class="sr-only"> grams</span>
	</span></div>
	<div class="line indent" tabindex="0">
		Sugars <span itemprop="sugarContent">{{sugar}}<span aria-hidden="true">g</span><span class="sr-only"> grams</span>
	</span></div>
	<div class="line" tabindex="0">
<strong>Protein</strong> <span itemprop="proteinContent">{{protein}}<span aria-hidden="true">g</span><span class="sr-only"> grams</span></span></div>
	<div class="bar1"></div>
	<div class="dvCalorieDiet line">
		<div class="calorieNote">
			<span tabindex="0"><span class="star" aria-hidden="true">*</span> Percent Daily Values are based on a 2000 calorie diet.</span>
		</div><!-- closing class="calorieNote" -->

	</div><!-- closing class="dvCalorieDiet line" -->

<div class="naTooltip">Data not available</div>
</div><!-- closing class="nutritionLabel" -->
</div>
</div>
</div>
</div>
<?php

include("footer.php");
