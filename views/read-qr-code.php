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
		
		<a href="#reset" id="reset">Reset</a>

		<script type="text/javascript">
			$("a#reset").click(function() {
				$(this).hide();
				
				table_template_html = $("#user-info-template").html();
				$("#user-info").html(table_template_html).hide();
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