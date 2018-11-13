const constraints = {
  video: true
};

navigator.mediaDevices.getUserMedia(constraints).then((stream) => {
	window.close();
});