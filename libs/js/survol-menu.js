function rollover(idlien, idbg) {
	document.getElementById(idlien).style.display = "block";
	document.getElementById(idbg).style.backgroundColor = "#F9F8F4";
}
function rollout(idlien, idbg) {
	document.getElementById(idlien).style.display = "none";
	document.getElementById(idbg).style.backgroundColor = "#F4F1EC";
}

function rollover_meilleures_ventes(idlien) {
	document.getElementById(idlien).style.backgroundColor = "#F9F8F4";
}
function rollout_meilleures_ventes(idlien, couleurBase) {
	if (couleurBase == "gris") {
		document.getElementById(idlien).style.backgroundColor = "#f2f2ef";
	}
	else {
		document.getElementById(idlien).style.backgroundColor = "#FFFFFF";	
	}
}

