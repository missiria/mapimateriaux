

var serverSideFile = '../agenda/ajax-poller-cast-vote-php.php';
var voteCenterImage = '../images/poller/graph_middle_1.gif';

var graphMaxWidth = 130;	// It will actually be a little wider than this because of the rounded image at the left and right
var graphMinWidth = 15;	// Minimum size of graph
var pollScrollSpeed = 5;	// Lower = faster
var useCookiesToRememberCastedVotes = true;	// Use cookie to remember casted votes
var txt_totalVotes = 'Nombre de votes total: ';

var ajaxObjects = new Array();
var pollVotes = new Array();
var pollVoteCounted = new Array();
var totalVotes = new Array();


/* Preload images */

var preloadedImages = new Array();
preloadedImages[0] = new Image();
preloadedImages[1] = new Image();
preloadedImages[2] = new Image();
preloadedImages[2].src = voteCenterImage;

/*
These cookie functions are downloaded from 
http://www.mach5.com/support/analyzer/manual/html/General/CookiesJavaScript.htm
*/	
function Poller_Get_Cookie(name) { 
   var start = document.cookie.indexOf(name+"="); 
   var len = start+name.length+1; 
   if ((!start) && (name != document.cookie.substring(0,name.length))) return null; 
   if (start == -1) return null; 
   var end = document.cookie.indexOf(";",len); 
   if (end == -1) end = document.cookie.length; 
   return unescape(document.cookie.substring(len,end)); 
} 
// This function has been slightly modified
function Poller_Set_Cookie(name,value,expires,path,domain,secure) { 
	expires = expires * 60*60*24*1000;
	var today = new Date();
	var expires_date = new Date( today.getTime() + (expires) );
    var cookieString = name + "=" +escape(value) + 
       ( (expires) ? ";expires=" + expires_date.toGMTString() : "") + 
       ( (path) ? ";path=" + path : "") + 
       ( (domain) ? ";domain=" + domain : "") + 
       ( (secure) ? ";secure" : ""); 
    document.cookie = cookieString; 
}

	
function showVoteResults(pollId,ajaxIndex)
{
	document.getElementById('poller_waitMessage' + pollId).style.display='none';
	
	var xml = ajaxObjects[ajaxIndex].response;
	xml = xml.replace(/\n/gi,'');
	
	var reg = new RegExp("^.*?<pollerTitle>(.*?)<.*$","gi");
	var pollerTitle = xml.replace(reg,'$1');
	
	var resultDiv = document.getElementById('poller_results' + pollId);

	var titleP = document.createElement('P');
	titleP.className='result_pollerTitle';
	titleP.innerHTML = pollerTitle;
	resultDiv.appendChild(titleP);	
	
	var options = xml.split(/<option>/gi);
	
	pollVotes[pollId] = new Array();
	totalVotes[pollId] = 0;
	for(var no=1;no<options.length;no++){
		
		var elements = options[no].split(/</gi);
		var currentOptionId = false;
		for(var no2=0;no2<elements.length;no2++){
			if(elements[no2].substring(0,1)!='/'){
				var key = elements[no2].replace(/^(.*?)>.*$/gi,'$1');
				var value = elements[no2].replace(/^.*?>(.*)$/gi,'$1');
			
				if(key.indexOf('optionText')>=0){
					var pOption = document.createElement('P');
					pOption.className='result_pollerOption';
					pOption.innerHTML = value;
					resultDiv.appendChild(pOption);					
					
				}
				
				if(key.indexOf('optionId')>=0){
					currentOptionId = value/1;
				}
				
				if(key.indexOf('votes')>=0){
					var voteDiv = document.createElement('DIV');
					voteDiv.className='result_pollGraph';
					resultDiv.appendChild(voteDiv);	
					
					
					
					var numberDiv = document.createElement('DIV');
					numberDiv.style.backgroundImage = 'url(\'' + voteCenterImage + '\')';
					numberDiv.innerHTML = '0%';
					numberDiv.id = 'result_voteTxt' + currentOptionId;
					voteDiv.appendChild(numberDiv);	
					
					pollVotes[pollId][currentOptionId] = value;					
					totalVotes[pollId] = totalVotes[pollId]/1 + value/1;
					
				}
			}
		}
	}
	
	var totalVoteP = document.createElement('P');
	totalVoteP.className = 'result_totalVotes';
	totalVoteP.innerHTML = txt_totalVotes + totalVotes[pollId];

	voteDiv.appendChild(totalVoteP);	
	
	setPercentageVotes(pollId);
	slideVotes(pollId,0);
}

function setPercentageVotes(pollId)
{
	for(var prop in pollVotes[pollId]){
		pollVotes[pollId][prop] =  Math.round( (pollVotes[pollId][prop] / totalVotes[pollId]) * 100);				
	}	
	
	var currentSum = 0;
	for(var prop in pollVotes[pollId]){
		currentSum = currentSum + pollVotes[pollId][prop]/1;			
	}
	pollVotes[pollId][prop] = pollVotes[pollId][prop] + (100-currentSum);
	
	
}

function slideVotes(pollId,currentPercent)
{
	currentPercent = currentPercent/1 + 1;
	
	for(var prop in pollVotes[pollId]){
		if(pollVotes[pollId][prop]>=currentPercent){
			var obj = document.getElementById('result_voteTxt' + prop);
			obj.innerHTML = currentPercent + '%';
			obj.style.width = Math.max(graphMinWidth,Math.round(currentPercent/100*graphMaxWidth)) + 'px';
		}			
	}
	
	if(currentPercent<100)setTimeout('slideVotes("' + pollId + '","' + currentPercent + '")',pollScrollSpeed);
}


function prepareForPollResults(pollId)
{
	document.getElementById('poller_waitMessage' + pollId).style.display='block';
	document.getElementById('poller_question' + pollId).style.display='none';	
}

//*************************************************/
// Ajouter un commentaire
//*************************************************/
function insertavis(formObj)
{	
	var commentaires = formObj.elements['Commentaire'].value;
	var nbrEtoile = formObj.elements['NbrEtoiles'].value;
	
	if((parseInt(nbrEtoile) > 10)||(parseInt(nbrEtoile) < 0)) {
		alert("Nombre d'étoiles est eronné");
		return false;
	}
	
	var refProduit = formObj.elements['idproduit'].value;

		var ajaxIndex = ajaxObjects.length;
		ajaxObjects[ajaxIndex] = new sack();
		ajaxObjects[ajaxIndex].requestFile = 'ajouter-avis-submit.php?Commentaire='+commentaires+'&NbrEtoiles='+nbrEtoile+'&idproduit='+refProduit ;		
		//prepareForPollResults(pollId);
		//ajaxObjects[ajaxIndex].onCompletion = function(){ showVoteResults(pollId,ajaxIndex); };	// Specify function that will be executed after file has been found
		ajaxObjects[ajaxIndex].runAJAX();		// Execute AJAX function	
		affiche_caracteristique(refProduit);		

}	


function sendMessage(formObj)
{	
	var nomprenom = formObj.elements['NomPrenomFriend'].value;
	var emailexp = formObj.elements['EmailExpFriend'].value;
	var emailfriend = formObj.elements['EmailFriend'].value;
	var message = formObj.elements['MessageToFriend'].value;
	var refproduit  = formObj.elements['idproduit'].value;

	var msgErr = "";
	
	if(nomprenom=="")
		msgErr += "Veuillez saisir votre nom et prénom\n";
	
	reg = /^([a-zA-Z0-9]+(([\.\-\_]?[a-zA-Z0-9]+)+)?)\@(([a-zA-Z0-9]+[\.\-\_])+[a-zA-Z]{2,4})$/gi;
	
	if(emailexp!="") {
		result = emailexp.match(reg) ;
		if (result==null) 
			msgErr += "Email Expéditeur est éronné\n";
	} else {
			msgErr += "Email Expéditeur est vide\n";
	}
	
	if(emailfriend!="") {
		result_email = emailfriend.match(reg) ;
		if (result_email==null) 
			msgErr += "Email Ami est éronné\n";
	} else {
			msgErr += "Email Ami est vide\n";
	}

	if(message=="")
		msgErr += "Veuillez saisir votre message\n";

	if(msgErr!="") {
			alert(msgErr);
			return false;
	}


	var url = '';
	url += 'informer-ami-submit.php?NomPrenomFriend='+nomprenom+'&EmailExpFriend='+emailexp+'&EmailFriend='+emailfriend+'&MessageToFriend='+message;
	url += '&refproduit='+refproduit;
	
		var ajaxIndex = ajaxObjects.length;
		ajaxObjects[ajaxIndex] = new sack();
		ajaxObjects[ajaxIndex].requestFile = url ;		
		//prepareForPollResults(pollId);
		//ajaxObjects[ajaxIndex].onCompletion = function(){ showVoteResults(pollId,ajaxIndex); };	// Specify function that will be executed after file has been found
		ajaxObjects[ajaxIndex].runAJAX();		// Execute AJAX function	
		affiche_caracteristique(refproduit);		
}	
//*************************************************/



function castMyVote(pollId,formObj)
{	
	var elements = formObj.elements['vote[' + pollId + ']'];
	var optionId = false;
	for(var no=0;no<elements.length;no++){
		if(elements[no].checked)optionId = elements[no].value;
	}
	Poller_Set_Cookie('dhtmlgoodies_poller_' + pollId,'1',6000000);
	if(optionId){
	
		var ajaxIndex = ajaxObjects.length;
		ajaxObjects[ajaxIndex] = new sack();
		ajaxObjects[ajaxIndex].requestFile = serverSideFile + '?pollId=' + pollId + '&optionId=' + optionId;
		prepareForPollResults(pollId);

		ajaxObjects[ajaxIndex].onCompletion = function(){ showVoteResults(pollId,ajaxIndex); };	// Specify function that will be executed after file has been found
		ajaxObjects[ajaxIndex].runAJAX();		// Execute AJAX function	

	}	
}	

function displayResultsWithoutVoting(pollId)
{

	var ajaxIndex = ajaxObjects.length;
	ajaxObjects[ajaxIndex] = new sack();
	ajaxObjects[ajaxIndex].requestFile = serverSideFile + '?pollId=' + pollId;
	prepareForPollResults(pollId);
	ajaxObjects[ajaxIndex].onCompletion = function(){ showVoteResults(pollId,ajaxIndex); };	// Specify function that will be executed after file has been found
	ajaxObjects[ajaxIndex].runAJAX();		// Execute AJAX function		
	
	
}

