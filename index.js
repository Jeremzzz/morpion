function checkEntry() {
	let userEntry = document.getElementById("taille").value;
	if(isNaN(userEntry)) {
		alert( "Veuillez choisir un nombre");
		return false;
	}
	else {
		let taille = parseInt(userEntry);
		if( taille>2 && taille<6 ) {
			return true;
		}
		else {
			alert("Veuillez prendre un nombre entre 3 et 5");
			return false;
		}
	}
}