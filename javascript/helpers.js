function likeFunction(e)
{
	let xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() 
	{
		if (this.readyState == 4 && this.status == 200) 
		{
            document.getElementById(e.id).innerHTML =
			this.responseText + " Like+";
		}
    };
	xhttp.open("POST", "likes_manager.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("likes=" + '1' + "&image_path=" + e.value + "&image_id=" + e.id); 
}