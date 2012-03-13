function validEmail(email) {
	invalidChars = "/:,;~"
	// verifie qu'il n'y a pas de caracteres pas autorises
	for (i=0; i<invalidChars.length; i++) {
	badChar = invalidChars.charAt(i)
	if (email.indexOf(badChar,0) > -1) {
	return false
	}
	}
	// verifie qu'il y a un @
	atPos = email.indexOf("@",1)
	if (atPos == -1) {
	return false
	}
	// et seulement un @
	if (email.indexOf("@", atPos+1) != -1) {
	return false
	}
	// et au moins un point apres le @
	periodPos = email.indexOf(".",atPos)
	if (periodPos == -1) {
	return false
	}
	//verifie qu'il y a au moins un caractère entre le @ et le .
	if (periodPos - atPos < 2) {
	return false
	}
	//verifie qu'il y a au moins deux caracteres apres le point
	if (periodPos+3 > email.length) {
	return false
	}
	return true
}

function valeurCheck() {
	var email = document.getElementById('email').value;
	
	 if(email == "" ){
		document.getElementById('email').focus();
		document.getElementById('email').value = 'Entrez votre e-mail';
		
	}else if (!validEmail(email)) {
		document.getElementById('email').focus();
		document.getElementById('email').select();
		document.getElementById('email').value= 'E-mail invalide';
	}else{
		document.getElementById('email').value = email;
		document.forms['newsletter'].submit();
	}
	
	
	if ( (email == "") || (!validEmail(email) ) ) {
		return false;
	}
	
}