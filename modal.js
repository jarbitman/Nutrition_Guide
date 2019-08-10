var itemOptions;

$(".itemName").on("click", function(e) {
  itemOptions = $("#" + e.target.id).data("options");
  var nutritionLabel = $("#modalNutritionLabelParent").html();

  itemOptions.calories = itemOptions.Cal;
  itemOptions.totalfat = itemOptions.TF;

  nutritionLabel = nutritionLabel.replace(/\{\{[a-z]+\}\}/gi, function(_, field) {
    console.log(`field: ${field}, value ${itemOptions[field]}`);
    if (itemOptions[field]) {
      return itemOptions[field];
    } else {
      return '';
    }
  });
  console.log(nutritionLabel);
  $( "#nutrition-dialog").html(nutritionLabel);
  $( "#nutrition-dialog").dialog({
    modal: true,
    buttons: {
      Ok: function() {
        $( this ).dialog( "close" );
      }
    }
  });
});
