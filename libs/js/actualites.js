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
	fadeIn(div,0); 
	setOpacity(div, 0);
}
	
function setNews() {
	//alert(tab);
	
	document.getElementById("1").style.display = 'block';
	setTimeout("changeNews(1)",5000);
}

function changeNews(tabNews, evenement) {
	
	for (i=1;i<totalNews;i++) {
		
		document.getElementById(i).style.display = 'none';
	}
	
	tabTest = tabNews+1;
	
	if (tabTest == totalNews) {
		document.getElementById("1").style.display = 'block';
		tabTest = 1;
	} else {
		document.getElementById(tabTest).style.display = 'block';
	}
	
	fadein(tabTest);
	
	if (evenement != 1) {
		setTimeout("changeNews(tabTest, 0)", 5000);
	} 
}

window.onload = setNews;
