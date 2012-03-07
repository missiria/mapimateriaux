function getlistevent(date_var) {
	window.location.href = 'liste-evenement.php?today='+date_var; }

		function getserverresponse(strURL,type,param) {
					var inst = '';
					inst = 'var xmlHttpReq'+type+'=false;';
					eval(inst) ;
					var self = this;
					// Mozilla/Safari
					if (window.XMLHttpRequest) 
					{
						self.eval('xmlHttpReq'+type+'= new XMLHttpRequest()');
					}
					// IE
					else if (window.ActiveXObject) {
						self.eval('xmlHttpReq'+type+'= new ActiveXObject("Microsoft.XMLHTTP")') ;
					}
				
					self.eval('xmlHttpReq'+type).open('POST', strURL, true);
					//alert(strURL);
					self.eval('xmlHttpReq'+type).setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
					self.eval('xmlHttpReq'+type).onreadystatechange = function()
					{
						if (self.eval('xmlHttpReq'+type).readyState == 4) 
						{
							var gridcontent;
							
							//*************************/
							if(type==1){
								retour = self.eval('xmlHttpReq'+type).responseText;
								document.getElementById('agenda').innerHTML = retour;
							 }
							if(type==2){
								retour = self.eval('xmlHttpReq'+type).responseText;
								document.getElementById('content-tabs').innerHTML = retour;
							 }
							if(type==3){
								retour = self.eval('xmlHttpReq'+type).responseText;
								document.getElementById('content-tabs').innerHTML = retour;
							 }
							if(type==4){
								retour = self.eval('xmlHttpReq'+type).responseText;
								document.getElementById('content-tabs').innerHTML = retour;
							 }
							if(type==5){
								retour = self.eval('xmlHttpReq'+type).responseText;
								document.getElementById('content-tabs').innerHTML = retour;
							 }
							if(type==6){
								retour = self.eval('xmlHttpReq'+type).responseText;
								document.getElementById('blocpersonnaliser').innerHTML = retour;
							 }
							if(type==7){ // Ici le code du retour
								document.getElementById('blocpersonnaliser').innerHTML = "";
								document.getElementById('blocpersonnaliser').style.display = "none";

							}
							//*************************/
						}
						
					 }
					self.eval('xmlHttpReq'+type).send(strURL);
	}

function affiche(month, year){


		if(month == "" && year == "") 
			url = "../agenda/calendrier.php";
		else
			url = "../agenda/calendrier.php?year="+year+"&month="+month+"";
				getserverresponse(url,1);
				//setCookie("affiche1", 1, 1);
}
//**********************************/
function affiche_caracteristique(id){
	url = "../produit/caracteristiques.php?id="+id;
	document.getElementById('content-tabs').innerHTML = '<img src="../images/poller/loading2.gif" alt="" class="loading-ajax" />';
	getserverresponse(url,2);
    document.getElementById('tabs1').className='tabs-p tabs-active';
	document.getElementById('tabs2').className='tabs-p tabs-inactive';
	document.getElementById('tabs3').className='tabs-p tabs-inactive';
}

function affiche_inform(id){
	url = "../produit/informer-ami.php?idproduit="+id;
	document.getElementById('content-tabs').innerHTML = '<img src="../images/poller/loading2.gif" alt="" class="loading-ajax" />';
	getserverresponse(url,3);
	document.getElementById('tabs3').className='tabs-p tabs-active';
	document.getElementById('tabs1').className='tabs-p tabs-inactive';
	document.getElementById('tabs2').className='tabs-p tabs-inactive';

}
function affiche_avis(id){
	url = "../produit/avis-internautes.php?idproduit="+id;
	document.getElementById('content-tabs').innerHTML = '<img src="../images/poller/loading2.gif" alt="" class="loading-ajax" />';
	document.getElementById('tabs2').className='tabs-p tabs-active';
	document.getElementById('tabs1').className='tabs-p tabs-inactive';
	document.getElementById('tabs3').className='tabs-p tabs-inactive';	getserverresponse(url,4);
}
function form_avis(id){
	url = "../produit/ajouter-avis.php?idproduit="+id;
	document.getElementById('content-tabs').innerHTML = '<img src="../images/poller/loading2.gif" alt="" class="loading-ajax" />';
	getserverresponse(url,5);
}

function personaliser_produit(id){
	url = "../commande/personnaliser.php?idproduit="+id;
	document.getElementById('blocpersonnaliser').innerHTML = '<img src="../images/poller/loading2.gif" alt="" class="loading-ajax" />';
	document.getElementById('blocpersonnaliser').style.display ="block";
	getserverresponse(url,6);
}
//**********************************/

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

function personaliseProduct(page){

	url = "../commande/"+page;
  
  MOOdalBox.open(url, '', '440 240');
  return false;  
}
/* 
function sendFormData(page)
{
  var qs = document.getElementById('email').value;
  
  if (qs != "") {
 	 url = "../newsletter/"+page+"/?email=" + qs;
  } else {
	 url = "../newsletter/"+page;
  }

  MOOdalBox.open(url, '', '430 340');
  return false;  
} */

function valideFormData()
{
  var nom = document.getElementById('Nom').value;
  var prenom = document.getElementById('Prenom').value;
  var email = document.getElementById('Email').value;
   
  url = "../newsletter/newsletters.php?Nom= "+ nom+"&Prenom="+nom+"&Email=" + email +"&FormAction=insert&FormName=Front_Newsletters";

  MOOdalBox.open(url, '', '430 340');
  return false;  
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
		 return false;
	}else{
		document.getElementById('email').value = email;
        //sendFormData('newsletters.php')
	}
	
	
	if ( (email == "") || (!validEmail(email) ) ) {
		
	}
}

function fadeIn(objId,opacity) {
	if (document.getElementById) {
		//obj = document.getElementById(objId);
		//alert(obj);
		if (opacity <= 100) {
			setOpacity(objId, opacity);
			opacity += 5;
			window.setTimeout("fadeIn('"+objId+"',"+opacity+")", 50);
		}
	}
}

function setOpacity(obj, opacity) {
	opacity = (opacity == 100)?99.999:opacity;
	// IE/Win
	document.getElementById(obj).style.filter = "alpha(opacity="+opacity+")";
	// Safari<1.2, Konqueror
	document.getElementById(obj).style.KHTMLOpacity = opacity/50;
	// Older Mozilla and Firefox
	document.getElementById(obj).style.MozOpacity = opacity/50;
	// Safari 1.2, newer Firefox and Mozilla, CSS3
	document.getElementById(obj).style.opacity = opacity/50;
	
}

function fadein(div) {
	fadeIn(div, 0); 
	setOpacity(div, 0);
}
	
//function setNews() {
//		
//	document.getElementById("act_1").style.display = 'block';
//	setTimeout("changeNews('act_1')",5000);
//}

function changeNews(tabNews, evenement) {
	
	for (i=1;i<totalNews;i++) {
		var news = "act_"+ i;
		document.getElementById(news).style.display = 'none';
	}
	
	tabNews = tabNews.substring(4, 20);
	tabTest = parseInt(tabNews)+1;
	
	if (tabTest == totalNews) {
		document.getElementById("act_1").style.display = 'block';
		tabTest = "act_1";
	} else {
		tabTest = "act_"+tabTest;
		tabTest = String(tabTest);
		document.getElementById(tabTest).style.display = 'block';
	}
	
	/* fadein(tabTest); */
	
	if (evenement != 1) {
		setTimeout("changeNews(tabTest, 0)", 5000);
	} 
}
//window.onload = setNews;

function vider_champ_newsletter(){

	document.getElementById("email").value= "";

}

var ajax = new Array();
function getProduct(sel){
	var Gamme = sel.options[sel.selectedIndex].value;

	document.getElementById('produit').options.length = 0;
	document.getElementById('produit').options[document.getElementById('produit').options.length] = new Option('-- Selectionner Un Produit --','');
	
	if(Gamme.length>0){
		var index = ajax.length; 
		ajax[index] = new sack();
		ajax[index].requestFile = '../library/ajax/produits_gamme.php?Gamme='+Gamme;	
		ajax[index].onCompletion = function(){ createSubCategories(index) };	
		ajax[index].runAJAX();		
	}
}


function createSubCategories(index)
{
	var obj = document.getElementById('produit');
	eval(ajax[index].response);		
}	

function display2(div) {
document.getElementById('tri-date').className=document.getElementById('tri-date').className=="tri-date"?"tri-date2":"tri-date";
}

//Module Inscription/////////////////////////////////////////////////////////////////////////

function edit_input_fact() {

	if (document.getElementById("adresse_liv").checked == true) {
		document.getElementById("adresse_fact").style.display="none";
		document.getElementById("NomFact").value=document.getElementById("NomLiv").value;
		document.getElementById("AdresseFact").value=document.getElementById("AdresseLiv").value;
		document.getElementById("PrenomFact").value=document.getElementById("PrenomLiv").value;
		document.getElementById("CodeFact").value=document.getElementById("CodeLiv").value;
		document.getElementById("VilleFact").value=document.getElementById("VilleLiv").value;
		document.getElementById("PaysFact").value=document.getElementById("RefLivPays").value;
	} else {
		document.getElementById("adresse_fact").style.display="inline";
		document.getElementById("NomFact").value="";
		document.getElementById("AdresseFact").value="";
		document.getElementById("PrenomFact").value="";
		document.getElementById("CodeFact").value="";
		document.getElementById("VilleFact").value="";
		document.getElementById("PaysFact").value="";
	}
}
function edit_input_inscrit() {
	if (document.getElementById("adresse_liv").checked == true) {
		document.getElementById("adresse_fact").style.display="none";
		document.getElementById("NomFact").value=document.getElementById("NomLiv").value;
		document.getElementById("AdresseFact").value=document.getElementById("AdresseLiv").value;
		document.getElementById("PrenomFact").value=document.getElementById("PrenomLiv").value;
		document.getElementById("CodeFact").value=document.getElementById("CodeLiv").value;
		document.getElementById("VilleFact").value=document.getElementById("VilleLiv").value;
		document.getElementById("PaysFact").value=document.getElementById("RefLivPays").value;
		
	}
}

function champsObligatoires () {
	
	var nom = document.getElementById('Nom').value;
	var prenom = document.getElementById('Prenom').value;
	var email = document.getElementById('Email').value;
	
	if ( (nom == "") || (prenom == "") || (email == "") ) {
		
		document.getElementById('spanErreur').innerHTML = "Veuillez remplir les champs obligatoires svp";
		document.getElementById('spanErreur').style.display = "Block";
		return false;
	
	} else if (!validEmail(email)) {
		
		document.getElementById('spanErreur').innerHTML = "Votre Email est invalide";
		document.getElementById('spanErreur').style.display = "Block";
	    return false;
	} 
	
}

function personnaliserObligatoire () {
	
	var textPersonnaliser = document.getElementById('textPersonnaliser').value;
	
	if (textPersonnaliser == "") {
		alert("La valeur dans le champ personnaliser produit est obligatoire");
	} else {
		
		validePersonnaliser();
	}
}

function validePersonnaliser() {

  var textPersonnaliser = document.getElementById('textPersonnaliser').value;
  var idproduit = document.getElementById('idproduit').value;
	url = "../commande/personnaliser.php?idproduit= "+ idproduit +"&textPersonnaliser= "+ textPersonnaliser+"&FormAction=insert&FormName=personaliser_product";
	getserverresponse(url,7);

}

function refuserToucheEntree(event)
{
	// Compatibilité IE / Firefox
    if(!event && window.event) {
        event = window.event;
    }
    // IE
    if(event.keyCode == 13) {
        event.returnValue = false;
        event.cancelBubble = true;
    }
    // DOM
    if(event.which == 13) {
        event.preventDefault();
        event.stopPropagation();
    }
}

// Panier

	function UpdateCart(){		
		document.formCart.FormAction.value = 'update';
		document.formCart.submit();
	}

	function emptylist(FormName,ListName) {		
		document.forms[FormName].elements[ListName].options.length = 0;
	}
	
	function DynamicSelect(IDSource, FormName, ListSource, ListDest, WithBlank, IDSousFamille) {
		// Vider la liste à afficher
		emptylist(FormName, ListDest);
		var count;
		var Nbr_Rows = document.forms[FormName].elements[ListSource].options.length;
		var IDa = "";
		var Value = "";
		var Label = "";
		var Tmp_Com = "";		
		
		var selected = document.forms[FormName].elements[ListSource].selectedIndex;
			selected = document.forms[FormName].elements[ListSource].options[selected].value;
			selected = selected.split("_");
			selected = selected[1];
			
		// Ajouter un blanc au début de la liste
		if (WithBlank==true) {
			count = 1;
			document.forms[FormName].elements[ListDest].options[0]= new Option("","");
		} else
			count = 0;
		
		for (var i=0;i<Nbr_Rows;i++) {
			//Sélectionner l'ID de la famille
			IDa = document.forms[FormName].elements[ListSource].options[i].label;
			//alert('IDSource = ' + IDSource);
			//alert('IDa = ' + IDa);
			//alert('IDSousFamille = ' + IDSousFamille);
			tabID = IDa.split(",");
			for (var j=0;j<tabID.length;j++) {
				//alert(tabID[j]);
				if (IDSource == tabID[j]) {// Si la famille traitée est une sous_famille de la famille sélectionnée dans la liste des familles
				// sélectionner la valeur
				Value = document.forms[FormName].elements[ListSource].options[i].text;
				// sélectionner l'ID
				IDOption = document.forms[FormName].elements[ListSource].options[i].value;
				//alert  (IDOption);
				index = document.forms[FormName].elements[ListSource].selectedIndex;
				IDSelectedValue = document.forms[FormName].elements[ListSource].options[index].value;
				//if(document.forms[FormName].elements[ListSource].options[i].selected==true){
				//	IDSelectedValue = IDOption;					
				//	alert  (document.forms[FormName].elements[ListSource].selectedIndex);
				//}
				// créer une nouvelle instance dans la liste des sous-familles avec les paramètres sélectionnées auparavant
				document.forms[FormName].elements[ListDest].options[count]= new Option(Value,IDOption);
				//if (IDOption == IDSousFamille) document.forms[FormName].elements[ListDest].options[count].selected = true;
				if (IDOption == IDSelectedValue) document.forms[FormName].elements[ListDest].options[count].selected = true;
				if (tabID[j] == selected) document.forms[FormName].elements[ListDest].selectedIndex = count;
				count++;
			}
			document.forms[FormName].elements[ListDest].length = count;
			}			
		}
	}
	
		function ValidateMyForm(myForm){
		var erreur = false;
		//var broderieVide = '{BroderieVide}';
		var broderieVide = '{BroderieVide}';
		var inputs = document.getElementsByTagName('input');
		var errorElem;
		for(i=0;i<inputs.length && !erreur;i++){
			var id = inputs[i].id;
			if(id!=''){
				var elem = id.split('_');
				var selectedBroderie = 	document.getElementById(elem[2]).value;
				var textBroderie = document.getElementById(id).value;
				if(selectedBroderie != broderieVide && textBroderie==''){
					erreur = true;
					errorElem = id;
				}
			}
		}
		
		if(erreur){
			//alert('{TexteBroderieObligatoire}');
			alert('{TexteBroderieObligatoire}');
			document.getElementById(errorElem).focus();
			return false;
		}else{
			return true;
		}
	}
	
    function edit_input2() {
	document.getElementById("AdrLivNom").disabled= false;
	document.getElementById("AdrLivPrenom").disabled= false;
	document.getElementById("AdrLivAdresse").disabled= false;
	document.getElementById("AdrLivCode").disabled= false;
	document.getElementById("AdrLivVille").disabled= false;
	document.getElementById("RefLivPays").disabled= false;
	}
	function edit_input() {
	document.getElementById("AdrFctNom").disabled= false;
	document.getElementById("AdrFctPrenom").disabled= false;
	document.getElementById("AdrFctAdresse").disabled= false;
	document.getElementById("AdrFctCode").disabled= false;
	document.getElementById("AdrFctVille").disabled= false;
	document.getElementById("RefFactPays").disabled= false;
}



