<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/webfont/1.6.28/webfontloader.js"></script>
<script src="//c2.theproteinbar.com/Nutrition_Guide/table.min.js"></script>
<script src="//c2.theproteinbar.com/Nutrition_Guide/modal.js"></script>
<script type="text/javascript">
  WebFont.load({custom: { families: ["Gotham Black", "Lora", "Lora", "Trade Gothic Bold Condensed Oblique", "Trade Gothic Bold Condensed"] }});
  $(function() {
    $( "#accordion" ).accordion({
      heightStyle: "content"
    });
  });
  Modernizr.addTest("maybemobile", function(){ return (Modernizr.touchevents && Modernizr.mq("only screen and (max-width: 768px)")) ? true : false; });
</script>
</body>
