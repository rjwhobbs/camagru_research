//Global var
let width = 500,
	height = 0,
	test = '',
	streaming = false;

//DOM  Elements
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const photos = document.getElementById('photos');
const photoButton = document.getElementById('photo-button');
const clearButton = document.getElementById('clear-button');
const stickerMenu = document.getElementById('sticker-menu');
//const sticker = document.getElementById('sticker1');

//Get Media Stream
navigator.mediaDevices.getUserMedia({video: true, audio: false})
.then(function (stream)	
{
	video.srcObject = stream;
	video.play(); 
})
.catch(function (err) 
{
	console.log(`Error: ${err}`);
});

video.addEventListener('canplay', function(e) 
{
	if (!streaming) 
	{
		height = video.videoHeight / (video.videoWidth / width);
		video.setAttribute('width', width);
		video.setAttribute('height', height);
		canvas.setAttribute('width', width);
		canvas.setAttribute('height', height);
		streaming = true;
	}
}, false);

photoButton.addEventListener('click', function(e) 
{
	takePicture();
	e.preventDefault();
}, false);

stickerMenu.addEventListener('change', function(e) {
	test = e.target.value;
	e.preventDefault();
})

clearButton.addEventListener('click', function(e) {
	photos.innerHTML = '';
})

function takePicture() 
{
	const context = canvas.getContext('2d');
	if (width && height) 
	{
		canvas.width = width;
		canvas.height = height;
	}
	context.drawImage(video, 0, 0, width, height);
	if (test != '')
	{
		let sticker = document.getElementById(test);
		context.drawImage(sticker, 10, 10, canvas.width / 2, canvas.height / 2);
	}
	const imgUrl = canvas.toDataURL('image/png');
	const img = document.createElement('img');
	img.setAttribute('src', imgUrl);
	photos.innerHTML = '';
	photos.appendChild(img);

	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() 
	{
		if (this.readyState == 4 && this.status == 200) 
		{
    		console.log(this.responseText);
    	}
  	};
  	xhttp.open("POST", "test1.php", true);
  	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  	//xhttp.setRequestHeader("Content-type", "image/png");
  	xhttp.send("img=" + imgUrl);
}
