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

 //phto button event
 photoButton.addEventListener('click', function(e) {
	takePicture();

	e.preventDefault();
 }, false);

 //Filter event
 photoFilter.addEventListener('change', function(e) {
	//set filter to chosen option
	filter = e.target.value;
	//set filter to video
	video.style.filter = filter;
	e.preventDefault();
 })

 clearButton.addEventListener('click', function(e) {
	 //clear photos
	 photos.innerHTML = '';
	 //change filter back to none
	 filter = 'none';
	 //set video
	 video.style.filter = filter;
	 //Reset select list
	 photoFilter.selectedIndex = 0;
 })

 //Take picture from canvas
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
	photos.innerHTML = '';
	photos.appendChild(img);
	//set filter to img
	img.style.filter = filter;

	let xhttp = new XMLHttpRequest();
  	xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
	  
    }
  };
  xhttp.open("POST", "../test1.php", true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhttp.send("img="+imgUrl);
 }

//  function download(blob){
// 	// uses the <a download> to download a Blob
// 	let a = document.createElement('a'); 
// 	a.href = URL.createObjectURL(blob);
// 	a.download = 'screenshot.jpg';
// 	document.body.appendChild(a);
// 	a.click();
//   }