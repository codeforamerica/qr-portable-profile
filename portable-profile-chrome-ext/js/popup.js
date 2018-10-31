checkDeviceSupport(function() {
	if(hasWebcam) {
		if(isWebsiteHasWebcamPermissions === false) {
			$("#request-webcam-permissions").show();
		} else {
			$("#request-webcam-permissions").hide();
			window.location = "webcam.html"
		}
	}
});