$(".itemName").on("click", function(e) {
  var itemOptions = $("#" + e.target.id).data("options");
  var nutritionLabel = $("#modalNutritionLabel").html();

  console.log(nutritionLabel);
  nutritionLabel = nutritionLabel.replace(/\{\{[a-z0-9]+\}\}/gi, function(_, field) {
    console.log(`field: ${field}, value ${itemOptions[field]}`);
    if (itemOptions[field]) {
      return itemOptions[field];
    } else {
      return '';
    }
  });
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
