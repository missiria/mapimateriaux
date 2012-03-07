var sContentMinIndex = 1;
var sContentIndex = 1;
var sContentMaxIndex = 3;

function initInnovation(iMin, iMax){
	sContentMinIndex = iMin;
	sContentIndex = iMin;
	sContentMaxIndex = iMax;
}

function nextContent(){
	if(sContentIndex < sContentMaxIndex){
		showContent(++sContentIndex);
	}else{
		sContentIndex = sContentMinIndex;
		showContent(sContentIndex);
	}
}

function previousContent(){
	if(sContentIndex > 1){			
		showContent(--sContentIndex);
	}else{
		sContentIndex = sContentMaxIndex;
		showContent(sContentIndex);
	}
}

function hideAll(){
	$(".content").hide();
}

function showContent(sIndex){
	if(sContentMinIndex > 0){
		hideAll();
		$("#content" + sIndex).show();
	}
}

function showTab(sTabName){
	$('#TabAvis').hide();
	$('#TabInformerAmi').hide();
	$('#TabProduit').hide();
	$('#TabCommentaire').hide();
	$('#' + sTabName).show();
}

function sendMessageToFriend(){
	var sEmailDestination = $('#EmailFriend').val();
	var sMessageToFriend = $('#MessageToFriend').val();
	var sLink = window.location.href;
	if(sEmailDestination == "")	{
		showMessagetoFriendError("Email destination obligatoire");		
	}else{
		$.post("sendtofriend.php", 
			{ 'email': sEmailDestination, 'message': sMessageToFriend, 'link' : sLink }, 
			function(data){
				alert("Message envoyé avec succès");
				clearSendToFriendForm();
		});
	}
}

function clearSendToFriendForm(){
	$('#EmailFriend').val('');
	$('#MessageToFriend').val('');
	showMessagetoFriendError('');
}
function showMessagetoFriendError(sMsg){
	$('#MessageToFriendError').html(sMsg);	
}
