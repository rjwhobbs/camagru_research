let width = 500,
height = 0,
selected = '',
data = '',
takePictureClicked = 0,
path = '',
streaming = false;

const save = document.getElementById('save-button');
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const photos = document.getElementById('photos');
const photoButton = document.getElementById('photo-button');
const clearButton = document.getElementById('clear-button');
const stickerMenu2 = document.getElementsByName('sticker-menu2');
const img = document.createElement('img');
const imageUpload = document.getElementById('uploadImage');
const imageLable = document.getElementById('imagelable');
const stickers = document.getElementById('stickers');

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
	photoButton.style.display = 'none';
	imageUpload.style.display = 'none';
	imageLable.style.display = 'none';
	if (selected == '')
		save.style.display = 'none';
	clearButton.style.display = 'inline';

	save.style.display = 'inline';
	
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() 
	{
		if (this.readyState == 4 && this.status == 200) 
		{
			path = this.responseText;
			img.setAttribute('src', path);
			selected = '';
		}
	};
  	xhttp.open("POST", "uploadpic.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("img=" + data + "&sticker=" + selected);
	stickers.style.display = 'none';

	e.preventDefault();
}, false);

stickerMenu2[0].addEventListener('change', function(e) {
	if (takePictureClicked == 1)
		save.style.display = 'inline';
	photoButton.style.display = 'inline';
	imageUpload.style.display = 'inline';
	imageLable.style.display = 'inline';
	if (stickerMenu2[0].checked == false &&
		stickerMenu2[1].checked == false &&
		stickerMenu2[2].checked == false &&
		stickerMenu2[3].checked == false 
		)
	{
		photoButton.style.display = 'none';
		imageUpload.style.display = 'none';
		imageLable.style.display = 'none';
	}
	selected = selected + e.target.value + ':';
	if	(stickerMenu2[0].checked == false)
		selected = selected.replace(/sticker1.png:/g,'');
	e.preventDefault();
})

stickerMenu2[1].addEventListener('change', function(e) {
	if (takePictureClicked == 1)
		save.style.display = 'inline';
	photoButton.style.display = 'inline';
	imageUpload.style.display = 'inline';
	imageLable.style.display = 'inline';
	if (stickerMenu2[0].checked == false &&
		stickerMenu2[1].checked == false &&
		stickerMenu2[2].checked == false &&
		stickerMenu2[3].checked == false 
		)
	{
		photoButton.style.display = 'none';
		imageUpload.style.display = 'none';
		imageLable.style.display = 'none';
	}
	selected = selected + e.target.value + ':';
	if	(stickerMenu2[1].checked == false)
		selected = selected.replace(/sticker2.png:/g,'');
	e.preventDefault();
})

stickerMenu2[2].addEventListener('change', function(e) {
	if (takePictureClicked == 1)
		save.style.display = 'inline';
	photoButton.style.display = 'inline';
	imageUpload.style.display = 'inline';
	imageLable.style.display = 'inline';
	if (stickerMenu2[0].checked == false &&
		stickerMenu2[1].checked == false &&
		stickerMenu2[2].checked == false &&
		stickerMenu2[3].checked == false 
		)
	{
		photoButton.style.display = 'none';
		imageUpload.style.display = 'none';
		imageLable.style.display = 'none';
	}
	selected = selected + e.target.value + ':';
	if	(stickerMenu2[2].checked == false)
		selected = selected.replace(/sticker3.png:/g,'');
	e.preventDefault();
})

stickerMenu2[3].addEventListener('change', function(e) {
	if (takePictureClicked == 1)
		save.style.display = 'inline';
	photoButton.style.display = 'inline';
	imageUpload.style.display = 'inline';
	imageLable.style.display = 'inline';
	if (stickerMenu2[0].checked == false &&
		stickerMenu2[1].checked == false &&
		stickerMenu2[2].checked == false &&
		stickerMenu2[3].checked == false 
		)
	{
		photoButton.style.display = 'none';
		imageUpload.style.display = 'none';
		imageLable.style.display = 'none';
	}
	selected = selected + e.target.value + ':';
	if	(stickerMenu2[3].checked == false)
		selected = selected.replace(/sticker4.png:/g,'');
	e.preventDefault();
})

clearButton.addEventListener('click', function(e) {
	stickers.style.display = 'inline';
	photos.innerHTML = '';
	photoButton.style.display = 'none';
	imageUpload.style.display = 'none';
	imageLable.style.display = 'none';
	save.style.display = 'none';
	clearButton.style.display = 'none';
	stickerMenu2[0].checked = false;
	stickerMenu2[1].checked = false;
	stickerMenu2[2].checked = false;
	stickerMenu2[3].checked = false;
	//stickerMenu2[4].checked = false;
	takePictureClicked = 0;

	if (path.length > 0)
	{
		deleteFromFile();
	}
	else
	{
		path = '';
		location.reload();
	}
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
	//img.setAttribute('src', imgUrl);
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
			photos.innerHTML = this.responseText; 
			path = '';
			//create an element
		}
	};
  	xhttp.open("POST", "savepic.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("path=" + path);
	
	e.preventDefault();
})

function deleteFromFile()
{	
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() 
	{
		if (this.readyState == 4 && this.status == 200) 
		{
			photos.innerHTML = this.responseText; 
			path = '';
			//create an element
		}
	};
  	xhttp.open("POST", "delete_pic.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("deletepath=" + path);
}

imageUpload.addEventListener('change', function() 
{
	let file = this.files[0];
	let formData = new FormData();
	formData.append('file', file);
	formData.append("sticker", selected);
	
	clearButton.style.display = 'inline';
	photoButton.style.display = 'none';
	imageUpload.style.display = 'none';
	imageLable.style.display = 'none';
	save.style.display = 'inline';
	if(file)
	{
		let xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function()
		{
			if (this.readyState == 4 && this.status == 200)
			{
				path = this.responseText;
				//console.log(path);
				photos.appendChild(img);
				img.setAttribute('src', path);
				selected = '';	
				imageUpload.value = "";
			}
		};
		xhttp.open("POST", "upload_user_pic.php", true);
		xhttp.send(formData);
	}
});