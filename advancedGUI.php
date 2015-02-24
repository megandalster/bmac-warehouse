<html>
<head>
<link rel="stylesheet" href="lib/jquery-ui.css" />
<link rel="stylesheet" href="styles.css" type="text/css" />
<script src="lib/jquery-1.9.1.js"></script>
<script src="lib/jquery-ui.js"></script>
<script>
$(function() {
	$(document).on("keyup", "product-id", function() {
		var str = $(this).val();
		var target = $(this);
		$.ajax({
			type: 'get',
			url: 'advanced_getProducts.php?q='+str,
			success: function (response) {
				var suggestions = $.parseJSON(response);
				console.log(target);
				target.autocomplete({
					source: suggestions
				});
			}
		});
	});

	$("#add-more").on('click', function(e) {
		e.preventDefault();
		var new_input = '<div class="ui-widget"> <input type="text" name="product-ids[]" class="product-id"></div>';
		$("#product-id-inputs").append(new_input);
	})
	$( "#from" ).datepicker({dateFormat: 'yy-mm-dd',changeMonth:true,changeYear:true});
	$( "#to" ).datepicker({dateFormat: 'yy-mm-dd',changeMonth:true,changeYear:true});

});
</script>
</head>
<body>
<div>
	<p>
	<form method="post">
		<p> <b>Example Autofill and Datepicker Elements</b>
		<br> Today's date: <?php echo Date("F d, Y");?></p>
	<table>	<tr>
		<td valign="top"> Select Date Range: 
			<p> from : <input name = "from" type="text" id="from">
							to : <input name = "to" type="text" id="to"></p>
		</td>
		<td> Select Products:
		    <p id="product-id-inputs" class="ui-widget"> 
		    <input type="text" name="product-ids[]" class="product-id" id="1"></p>
		<button id="add-more">add more</button><br><br>
		</td>
		
	</tr></table>
	</form>
</div>

</body>
</html>


