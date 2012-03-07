function changeimgarticle(){
 var href = window.location.href;
 objid = href.substring(href.indexOf('id=')+3,href.length);

 if (objid == 15) {
document.getElementById('blocimgtitle').innerHTML ='<img title="" alt="" src="../images/espace-feu.gif" />';
} 

else if (objid == 16) {
document.getElementById('blocimgtitle').innerHTML ='<img title="" alt="" src="../images/conseils-decos.gif" />';
} 

else if (objid == 17) {
document.getElementById('blocimgtitle').innerHTML ='<img title="" alt="" src="../images/qui-somme-ns.gif" />';
} 

else if (objid == 18) {
document.getElementById('blocimgtitle').innerHTML ='<img title="" alt="" src="../images/engagements.gif" />';
} 

else if (objid == 19) {
document.getElementById('blocimgtitle').innerHTML ='<img title="" alt="" src="../images/faq.gif" />';
} 

else if (objid == 20) {
document.getElementById('blocimgtitle').innerHTML ='<img title="" alt="" src="../images/glossaire.gif" />';
} 

else if (objid == 21) {
document.getElementById('blocimgtitle').innerHTML ='<img title="" alt="" src="../images/condition-v.gif" />';
} 

else if (objid == 22) {
document.getElementById('blocimgtitle').innerHTML ='<img title="" alt="" src="../images/paiement.gif" />';
} 

else if (objid == 23) {
document.getElementById('blocimgtitle').innerHTML ='<img title="" alt="" src="../images/nabeul.gif" />';
} 
}
 
window.onload = changeimgarticle