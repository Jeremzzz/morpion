let previousImage = null;
function click_at(ligne, colonne, image) {
	document.getElementById("ligne").value=ligne;
	document.getElementById("colonne").value=colonne;
	let source = image.src.split("/")[image.src.split("/").length-1];
	if(source!="white.png") {
		alert("Cette case est déjà utilisée");
	}
	else {
		if(previousImage!=null) {
			previousImage.src = "images/white.png";
		}
		image.src = "images/X.png";
		previousImage = image;
	}
}


function verifPlay() {
	let line = document.getElementById("ligne").value;
	let column = document.getElementById("colonne").value;
	if(line=="-9" || column=="-9") {
		alert("Vous n'avez pas joué !");
		return false;
	}
	return true;
}