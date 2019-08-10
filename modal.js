$(".itemName").on("click", function(e) {
  itemOptions = $("#" + e.target.id).data("options");
  var nutritionLabel = $("#modalNutritionLabelParent").html();

  itemOptions.totalfatperc = "" + Math.round(parseInt(itemOptions.TF.replace(/[^0-9]/g), '')/65 * 100);
  itemOptions.satfatperc = "" + Math.round(parseInt(itemOptions.SF.replace(/[^0-9]/g), '')/20 * 100);
  itemOptions.cholesterolperc = "" + Math.round(parseInt(itemOptions.CHO.replace(/[^0-9]/g), '')/300 * 100);
  itemOptions.sodiumperc = "" + Math.round(parseInt(itemOptions.CHO.replace(/[^0-9]/g), '')/2400 * 100);
  itemOptions.carbsperc = "" + Math.round(parseInt(itemOptions.NC.replace(/[^0-9]/g), '')/300 * 100);
  itemOptions.fiberperc = "" + Math.round(parseInt(itemOptions.DF.replace(/[^0-9]/g), '')/25 * 100);

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
