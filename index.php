<?php
include("header.php");
$groups[1]="BREAKFAST / COFFEE";
$groups[2]="SMOOTHIES";
$groups[3]="BOWLS/BAR-RITOS";
$groups[4]="CHILIS/SOUPS";
$groups[5]="SALADS/WRAPS";
$groups[6]="KIDS MENU";

echo " <div id=\"accordion\">";
foreach ($groups as $key => $value) {
  echo "  <h3 style='background-color:#b2d235;color:#FFFFFF;'>$value</h3>
  <div>
  <table class=\"table-autosort:2 table-stripeclass:alternate table-autostripe full_width\" style='width:100%;'>
    <thead>
      <tr>
      <th class=\"\"  style='background-color:#0e2244;color:#FFFFFF;'></th>
      <th class=\"table-sortable:numeric\"  style='background-color:#0e2244;color:#FFFFFF;padding:3px;'>CALORIES</th>
      <th class=\"table-sortable:numeric\"  style='background-color:#0e2244;color:#FFFFFF;'>TOTAL FAT</th>
      <th class=\"table-sortable:numeric\"  style='background-color:#0e2244;color:#FFFFFF;'>SAT FAT</th>
      <th class=\"table-sortable:numeric\"  style='background-color:#0e2244;color:#FFFFFF;'>TRANS FAT</th>
      <th class=\"table-sortable:numeric\"  style='background-color:#0e2244;color:#FFFFFF;'>CHOLESTEROL</th>
      <th class=\"table-sortable:numeric\"  style='background-color:#0e2244;color:#FFFFFF;'>SODIUM</th>
      <th class=\"table-sortable:numeric\"  style='background-color:#0e2244;color:#FFFFFF;'>NET CARBS</th>
      <th class=\"table-sortable:numeric\"  style='background-color:#0e2244;color:#FFFFFF;'>TOTAL CARBS</th>
      <th class=\"table-sortable:numeric\"  style='background-color:#0e2244;color:#FFFFFF;'>DIETARY FIBER</th>
      <th class=\"table-sortable:numeric\"  style='background-color:#0e2244;color:#FFFFFF;'>SUGARS</th>
      <th class=\"table-sortable:numeric\"  style='background-color:#0e2244;color:#FFFFFF;'>PROTEIN</th>
      </tr>

      </table>
  </div>";
}
echo "</div>";

include("footer.php");
