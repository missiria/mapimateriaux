function openFocus(langue) {
	
	// Message d'erreur
	if (langue == "fr") { var message = 'votre e-mail ici' }
	else if (langue == "uk") { var message = 'your e-mail here' }
	
	
  if (document.getElementById('nl_mail').value == message) {
		document.getElementById('nl_mail').value = '';  
  }
  else if (document.getElementById('nl_mail').value == message) {
		document.getElementById('nl_mail').value = '';  
  }
  else {
	  //
  }
}

function closeFocus(langue) {
	
	// Message d'erreur
	if (langue == "fr") { var message = 'votre e-mail ici' }
	else if (langue == "uk") { var message = 'your e-mail here' }
	
	
  if (document.getElementById('nl_mail').value == '') {
	  document.getElementById('nl_mail').value = message;
  }
}