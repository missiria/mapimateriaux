
var ajax = new Array();
var ajax_result = new Array();

function getProduct_result() {

	var URLID1 = document.getElementById('URLID1').value;
	var URLID2 = document.getElementById('URLID2').value;
	if ( (document.search.elements[3].value == "") || (document.search.elements[4].value == "") ){
		document.getElementById('divErreur').innerHTML = 'Vous devez selectionner deux produits';
	} else {
		var result = ajax_result.length;
		ajax_result[result] = new sack();
		ajax_result[result].requestFile = '../comparer-produit/resultcomparer.php?URLID1='+URLID1+'&URLID2='+URLID2;	
		ajax_result[result].onCompletion = function(){ afficher(result)};//;	
		ajax_result[result].runAJAX();
		//alert(ajax_result[result].responseText);
		//alert (result)
	}

}
function afficher(result){
	document.getElementById('divErreur').innerHTML = ajax_result[result].response;
}

function getProduct_compare(sel){
	
	var Gamme_compare = sel.options[sel.selectedIndex].value;
	
	document.getElementById('URLID1').options.length = 0;
	document.getElementById('URLID1').options[document.getElementById('URLID1').options.length] = new Option('-- Selectionner Un Produit --','');
	document.getElementById('URLID2').options.length = 0;
	document.getElementById('URLID2').options[document.getElementById('URLID2').options.length] = new Option('-- Selectionner Un Produit --','');
	if(Gamme_compare.length>0){
		var index = ajax.length; 
		ajax[index] = new sack();
		ajax[index].requestFile = '../library/ajax/getProduct.php?Gamme='+Gamme_compare;	
		ajax[index].onCompletion = function(){ createSubCategories_compare(index) };	
		ajax[index].runAJAX();		
	}
}


function createSubCategories_compare(index)
{
	var obj1 = document.getElementById('URLID1');
	var obj2 = document.getElementById('URLID2');
	document.getElementById('choixBloc').style.display = "block";
	
	eval(ajax[index].response);
}