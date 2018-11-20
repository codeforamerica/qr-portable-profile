<!DOCTYPE HTML>
<html>

	<head>
		<title>Read QR Code</title>
		<link rel="stylesheet/less" href="../resources/css/style.less">
		<script src="../resources/js/lib/less.js"></script>
		<script src="../resources/js/lib/jquery.js"></script>
		<script src="../resources/js/main.js"></script>
		<script src="../resources/js/lib/instascan.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>

		<div id="qr-code-scanner">
			<video id="preview"></video>
		</div>
		
		<br>
		
		<div id="user-info">
			<table>
			    <tr>
			        <th>Label</th>
			        <th>Value</th>
			    </tr>
			</table>
		</div>
		
		<div id="user-info-template">
			<table>
			    <tr>
			        <th>Label</th>
			        <th>Value</th>
			    </tr>
			</table>
		</div>
		
		<br>
		
		<a href="#reset" id="reset"><input type="submit" value="Reset"></a>

		<form action="../controllers/new-user.php" method="POST" style="position: absolute; top: 40px; left: 400px;">
			<label for="name">Name</label> <input type="text" name="name"><br>
			<label for="phone_number">Phone Number</label> <input type="text" name="phone_number"><br>
			<label for="email_address">Email</label> <input type="text" name="email_address"><br>
			<br><br>
			<label for="street_address_1">Street Address</label> <input type="text" name="street_address_1"><br>
			<label for="street_address_2">Apt/Unit</label> <input type="text" name="street_address_2"><br>
			<label for="address_city">City</label> <input type="text" name="address_city"><br>
			<label for="address_state">State</label> <input type="text" name="address_state"><br>
			<label for="address_zip">Zip Code</label> <input type="text" name="address_zip"><br>
			<br><br>
			<label for="birth_date">Birthday</label> <input type="date" name="birth_date"><br>
			<br><br>
			<label for="notes">Notes</label>
			<br><br>
			<textarea name="notes"></textarea>
			<br>
			<br>
			<br>
			<input type="submit" value="Save">
		</form>
		
		<script type="text/javascript">
			$("a#reset").click(function() {
				$(this).hide();
				
				table_template_html = $("#user-info-template").html();
				$("#user-info").html(table_template_html).hide();
				
				$('form').trigger("reset");
			});
			
			let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
			
			scanner.addListener('scan', function (qr_code_content) {
				console.log(qr_code_content);
				
				$.get("../controllers/get-json-user-info.php?id="+qr_code_content+"&referrer=Localhost Read Data from QR Code", function(user_info_json) {
					$("#user-info").show();
					$("a#reset").show();
					
					user_info = JSON.parse(user_info_json);
				
					$.each(user_info, function(key, value) {
						$("#user-info table").append("<tr><td>"+key+"</td><td>"+value+"</td></tr>");
				    });
					
					$.each(user_info, function(key, value) {
						$("form [name='"+key+"']").val(value);
					});
				});
			});
			
			Instascan.Camera.getCameras().then(function (cameras) {
				if (cameras.length > 0) {
					scanner.start(cameras[0]);
				} else {
					console.error('No cameras found.');
				}
			}).catch(function (e) {
				console.error(e);
			});
		</script>

	</body>
</html>