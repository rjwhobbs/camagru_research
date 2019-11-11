//Global var
let width = 500,
height = 0,
selected = '',
data = '',
takePictureClicked = 0,
streaming = false;

//DOM  Elements

const save = document.getElementById('save-button');
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const photos = document.getElementById('photos');
const photoButton = document.getElementById('photo-button');
const clearButton = document.getElementById('clear-button');
//const stickerMenu = document.getElementById('sticker-menu');
const stickerMenu2 = document.getElementsByName('sticker-menu2');
//const sticker = document.getElementById('sticker1');
const img = document.createElement('img');

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
	//video.style.display = "none";
	takePicture();
	photoButton.style.display = 'none';
	if (selected == '')
		save.style.display = 'none';
	clearButton.style.display = 'inline'
	e.preventDefault();
}, false);

stickerMenu2[0].addEventListener('change', function(e) {
	if (takePictureClicked == 1)
		save.style.display = 'inline';
	selected = e.target.value;
	e.preventDefault();
})

stickerMenu2[1].addEventListener('change', function(e) {
	if (takePictureClicked == 1)
		save.style.display = 'inline';
	selected = e.target.value;
	e.preventDefault();
})

stickerMenu2[2].addEventListener('change', function(e) {
	if (takePictureClicked == 1)
		save.style.display = 'inline';
	selected = e.target.value;
	e.preventDefault();
})

stickerMenu2[3].addEventListener('change', function(e) {
	if (takePictureClicked == 1)
		save.style.display = 'inline';
	selected = e.target.value;
	e.preventDefault();
})

stickerMenu2[4].addEventListener('change', function(e) {
	if (takePictureClicked == 1)
		save.style.display = 'inline';
	selected = e.target.value;
	e.preventDefault();
})

clearButton.addEventListener('click', function(e) {
	photos.innerHTML = '';
	photoButton.style.display = 'inline';
	save.style.display = 'none';
	clearButton.style.display = 'none';
	stickerMenu2[0].checked = false;
	stickerMenu2[1].checked = false;
	stickerMenu2[2].checked = false;
	stickerMenu2[3].checked = false;
	stickerMenu2[4].checked = false;
	takePictureClicked = 0;
})

function takePicture() 
{
	takePictureClicked = 1;
	save.style.display = 'inline';
	const context = canvas.getContext('2d');
	if (width && height) 
	{
		canvas.width = width;
		canvas.height = height;
	}
	context.drawImage(video, 0, 0, width, height);
	const imgUrl = canvas.toDataURL('image/png');
	img.setAttribute('src', imgUrl);
	photos.innerHTML = ''; 
	photos.appendChild(img);
	data = imgUrl;
}

save.addEventListener('click', function(e)
{
	save.style.display = 'none';
	
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() 
	{
		if (this.readyState == 4 && this.status == 200) 
		{
			img.setAttribute('src', this.responseText);
			selected = '';
		}
	};
  	xhttp.open("POST", "uploadpic.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("img=" + data + "&sticker=" + selected);
})