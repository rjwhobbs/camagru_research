//Global var
let width = 500,
	height = 0,
	filter = 'none',
	streaming = false;

//DOM  Elements
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const photos = document.getElementById('photos');
const photoButton = document.getElementById('photo-button');
const clearButton = document.getElementById('clear-button');
const photoFilter = document.getElementById('photo-filter');

//Get Media Stream
navigator.mediaDevices.getUserMedia({video: true, audio: false})
 .then(function (stream){
	//Link Video source
	video.srcObject = stream;
	//Play video
	video.play(); 
 })
 .catch(function (err) {
	   console.log(`Error: ${err}`);
 });

 //Play when ready
 video.addEventListener('canplay', function(e) {
	if(!streaming) {
		// set video / canvas height

		height = video.videoHeight / (video.videoWidth / width);

		video.setAttribute('width', width);
		video.setAttribute('height', height);
		canvas.setAttribute('width', width);
		canvas.setAttribute('height', height);

		streaming = true;
	}
 }, false);

 photoButton.addEventListener('click', function(e) {
	takePicture();

	e.preventDefault();
 }, false);

 function takePicture() {
	//Create canvas
	const context = canvas.getContext('2d');
	if(width && height) {
		//set canvas properties
		canvas.width = width;
		canvas.height = height;
	}

	//Draw an of the video on the canvas
	context.drawImage(video, 0, 0, width, height);

	//Create image from the canvas
	const imgUrl = canvas.toDataURL('image/png');

	//Create img element
	const img = document.createElement('img');

	//Set img src
	img.setAttribute('src', imgUrl);

	//Add img to photos
	photos.appendChild(img);
 }