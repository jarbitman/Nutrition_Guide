$(".itemName").on("click", function(e) {
  itemOptions = $("#" + e.target.id).data("options");
  var nutritionLabel = $("#modalNutritionLabelParent").html();
  var dailyValues = {"fat": 65, "saturatedFat": 20, "cholesterol": 300, "sodium": 2400, "carbohydrates": 300, "fiber": 25};

  itemOptions.totalfatperc = "" + Math.round(parseInt(itemOptions.TF.replace(/[^0-9]/g), '')/dailyValues.fat * 100);
  itemOptions.satfatperc = "" + Math.round(parseInt(itemOptions.SF.replace(/[^0-9]/g), '')/dailyValues.saturatedFat * 100);
  itemOptions.cholesterolperc = "" + Math.round(parseInt(itemOptions.CHO.replace(/[^0-9]/g), '')/dailyValues.cholesterol * 100);
  itemOptions.sodiumperc = "" + Math.round(parseInt(itemOptions.CHO.replace(/[^0-9]/g), '')/dailyValues.sodium * 100);
  itemOptions.carbsperc = "" + Math.round(parseInt(itemOptions.NC.replace(/[^0-9]/g), '')/dailyValues.carbohydrates * 100);
  itemOptions.fiberperc = "" + Math.round(parseInt(itemOptions.DF.replace(/[^0-9]/g), '')/dailyValues.fiber * 100);

  nutritionLabel = nutritionLabel.replace(/\{\{([a-z]+)\}\}/gi, function(_, field) {
    if (itemOptions[field]) {
      return itemOptions[field].replace(/[^0-9]/g, '');
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
