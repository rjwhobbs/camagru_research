// const likesButton = document.getElementById('likes');



// likesButton.addEventListener('click',function()
// {
// 	let xhttp = new XMLHttpRequest();
//     xhttp.onreadystatechange = function() {
//         if (this.readyState == 4 && this.status == 200) {
//             document.getElementById("likesamount").innerHTML =
// 			this.responseText;
// 			//console.log(this.responseText);
//        }
//     };
// 	xhttp.open("POST", "likes_manager.php", true);
// 	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//     xhttp.send("likes=" + '1'); 
// });

function likeFunction(e)
{
	// console.log(e.value);
	// console.log(e.id);
	let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById(e.id).innerHTML =
			this.responseText + " Like+";
			//console.log(this.responseText + "SOME WORDS");
       }
    };
	xhttp.open("POST", "likes_manager.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("likes=" + '1' + "&image_path=" + e.value + "&image_id=" + e.id); 
}