let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
scanner.addListener('scan', function (qr_code_content) {
	console.log(qr_code_content);

	chrome.tabs.query({active: true, currentWindow: true}, function(tabs) {
		var current_tab = tabs[0];
		console.log(current_tab);
	
		$.get("http://localhost/portable-profile/controllers/get-json-user-info.php?id="+qr_code_content+"&referrer="+current_tab.title, function(user_info_json) {
			console.log(user_info_json);
			user_info = JSON.parse(user_info_json);

			chrome.tabs.executeScript(current_tab.id, { file: "js/lib/jquery.js" }, function() {
				chrome.tabs.executeScript(current_tab.id, {file: 'js/inject.js'}, function() {
					chrome.tabs.sendMessage(current_tab.id, user_info);
				});
			});
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

$("#test-button").click(function() {

	$.get("http://localhost/portable-profile/controllers/get-json-user-info.php?id=38", function(user_info_json) {
		console.log(user_info_json);
		user_info = JSON.parse(user_info_json);

		chrome.tabs.query({active: true, currentWindow: true}, function(tabs) {
			var current_tab = tabs[0];
			
			chrome.tabs.executeScript(current_tab.id, { file: "js/lib/jquery.js" }, function() {
				chrome.tabs.executeScript(current_tab.id, {file: 'js/inject.js'}, function() {
					chrome.tabs.sendMessage(current_tab.id, user_info);
				});
			});
		});
	});
		
});