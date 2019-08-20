var dailyValues = {"fat": 65, "saturatedFat": 20, "cholesterol": 300, "sodium": 2400, "carbohydrates": 300, "fiber": 25};

function convertDailyValue(amount, dv) {
  var amountAsInt = parseInt(amount.replace(/[^0-9]/g), '');
  if (dv != 0) {
    return "" + Math.round(amountAsInt/dv * 100);
  } else {
    return amountAsInt;
  }
}

$(".itemName").on("click", function(e) {
  var elem = $("#" + e.target.id),
      itemOptions = elem.data("options"),
      nutritionLabel = $("#modalNutritionLabelParent").html();

  itemOptions.totalfatperc = convertDailyValue(itemOptions.TF, dailyValues.fat);
  itemOptions.satfatperc = convertDailyValue(itemOptions.SF, dailyValues.saturatedFat);
  itemOptions.cholesterolperc = convertDailyValue(itemOptions.CHO, dailyValues.cholesterol);
  itemOptions.sodiumperc = convertDailyValue(itemOptions.CHO, dailyValues.sodium);
  itemOptions.carbsperc = convertDailyValue(itemOptions.NC, dailyValues.carbohydrates);
  itemOptions.fiberperc = convertDailyValue(itemOptions.DF, dailyValues.fiber);

  nutritionLabel = nutritionLabel.replace(/\{\{([a-z]+)\}\}/gi, function(_, field) {
    if (itemOptions[field]) {
      return itemOptions[field];
    } else {
      return '';
    }
  });
  $( "#nutrition-dialog").html(nutritionLabel);
  $( "#nutrition-dialog").dialog({
    modal: true,
    width: 375,
    title: decodeURIComponent(elem.data("title")),
    /*
    buttons: {
      Ok: function() {
        $(this).dialog("close");
      }
    }
    */
  });
  $(".ui-dialog-title").css("white-space","normal");
});
