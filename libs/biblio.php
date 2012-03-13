<?php
function setdate()
{
global $tpl;
$annee = date("Y", $temps);
setlocale (LC_TIME, 'fr_FR','fra');

$tpl->set_var("date",utf8_encode(strftime("%A %d %B %Y %T ")));
$tpl->set_var("Heure",strftime("%H")); 
}



//====================================
function save_visite_article($idarticle )
//====================================
{
global $db;
 $sSQL = "update cnt_article set nbr_visites=nbr_visites+1 where id=" . tosql($idarticle, "Number"); 
$db->query($sSQL);
}
//====================================
function showpushtheme($code_push){
//====================================
global $tpl;
global $db;
$titrepush	= "";
$alias	= "";
$parametre_cle	= "";
$libelle	= "";
$nombre_enregistrement		= "";
$procedures = ""; 
$sSQL = "select *  " ;
$sSQL .= "from push where id = " .$code_push ;
$db->query($sSQL);
	
	
	$next_record = $db->next_record();
	
	
	if($next_record) {
		$titrepush =  $db->f("libelle");
		$alias =  $db->f("alias");
		$parametre_cle =  $db->f("parametre_cle");
		$libelle =  $db->f("libelle");
		$nombre_enregistrement	=  $db->f("nombre_enregistrement");
		$procedures =  $db->f("procedures");
	}
	

		
$sSQL = "select *  " ;
$sSQL .= "from ".$procedures." where ". $parametre_cle ." LIMIT 0 , ".$nombre_enregistrement;

$db->query($sSQL);


$next_record = $db->next_record();
if(!$next_record) {
	$tpl->set_var($alias, "");
	return;
}
    $i =0;
	while($next_record) {
	    
		$tpl->set_var("titrearticle", tohtml($db->f("a_titre")));
		$tpl->set_var("datearticle", tohtml($db->f("a_date_creation")));
		$tpl->set_var("descriptionarticle", tohtml($db->f("a_description")));
		$tpl->set_var("idarticle", tohtml($db->f("a_id")));
		$tpl->set_var("url_image", tohtml($db->f("a_url_image")));
		$tpl->set_var("idtheme", tohtml($db->f("t_id")));
		
		if($i==0){
		if(strlen($tpl->DBlocks["article".$alias."1er"])>0)
			{
			$tpl->parse("article".$alias."1er", true);
			}else
			{	
			$tpl->parse("article".$alias, true);
			}
		}else{
		$tpl->parse("article".$alias, true);
		}
		
		$next_record = $db->next_record();
		$i++;
	}
	
	
	$tpl->set_var("titrepush", tohtml($titrepush));
	$tpl->set_var("ref_push", tohtml($code_push));
	$tpl->parse($alias, false);
	$tpl->set_var("article".$alias, "");
} 
//====================================
function showbourseindice(){
//====================================
global $tpl;
global $db;


		
$sSQL = "SELECT o.libelle AS o_libelle, b.nouvelle_valeur AS b_nouvelle_valeur,b.signe_variation as b_signe_variation" .
		"	FROM organisme o, bourse_valeur b" .
		"	WHERE o.id = b.ref_organisme" .
		"	and b.est_indice = 1 " .
		"	ORDER BY b.valeur_variation DESC " .
 		" 	LIMIT 0 ,2 ";

$db->query($sSQL);
$next_record = $db->next_record();
if(!$next_record) {
	$tpl->set_var("blochaussejour", "");
	return;
}
	
	while($next_record) {
		$tpl->set_var("organisme", tohtml($db->f("o_libelle")));
		$tpl->set_var("nouvelle_valeur", tohtml($db->f("b_nouvelle_valeur")));
		$tpl->set_var("signevariation",$db->f("b_signe_variation"));
		$tpl->parse("indice", true);
		$next_record = $db->next_record();
		$i++;
	}
	
	

} 

//====================================
function showboursebaisseannee($nombre_enregistrement){
//====================================
global $tpl;
global $db;


		
$sSQL = "SELECT DISTINCT (b.id),o.libelle AS o_libelle, b.valeur_variation AS b_valeur_variation" .
		"	FROM organisme o, historique_bourse b" .
		"	WHERE o.id = b.ref_organisme" .
		"	AND b.signe_variation =0" .
		"	ORDER BY b.valeur_variation DESC " .
 		" 	LIMIT 0 , ".$nombre_enregistrement;

$db->query($sSQL);
$next_record = $db->next_record();
if(!$next_record) {
	$tpl->set_var("blochaussejour", "");
	return;
}
	$i	=	0;
	while($next_record) {
		$tpl->set_var("organisme", tohtml($db->f("o_libelle")));
		$tpl->set_var("valeur_variation", tohtml(number_format ($db->f("b_valeur_variation"),1)));
		$tpl->set_var("ordre",$i%2);
		$tpl->parse("baisseannee", true);
		$next_record = $db->next_record();
		$i++;
	}
	
	
	$tpl->parse("blocbaisseannee", false);
	$tpl->set_var("baisseannee", "");


} 

//====================================
function showboursehausseannee($nombre_enregistrement){
//====================================
global $tpl;
global $db;


		
$sSQL = "SELECT DISTINCT (b.id),o.libelle AS o_libelle, b.valeur_variation AS b_valeur_variation" .
		"	FROM organisme o, historique_bourse b" .
		"	WHERE o.id = b.ref_organisme" .
		"	AND b.signe_variation =1" .
		"	ORDER BY b.valeur_variation DESC " .
 		" 	LIMIT 0 , ".$nombre_enregistrement;

$db->query($sSQL);
$next_record = $db->next_record();
if(!$next_record) {
	$tpl->set_var("blochaussejour", "");
	return;
}
	$i	=	0;
	while($next_record) {
		$tpl->set_var("organisme", tohtml($db->f("o_libelle")));
		$tpl->set_var("valeur_variation", tohtml(number_format ($db->f("b_valeur_variation"),1)));
		$tpl->set_var("ordre",$i%2);
		$tpl->parse("hausseannee", true);
		$next_record = $db->next_record();
		$i++;
	}
	
	
	$tpl->parse("blochausseannee", false);
	$tpl->set_var("hausseannee", "");


} 

//====================================
function showboursehausse($nombre_enregistrement){
//====================================
global $tpl;
global $db;


		
$sSQL = "SELECT o.libelle AS o_libelle, b.valeur_variation AS b_valeur_variation" .
		"	FROM organisme o, bourse_valeur b" .
		"	WHERE o.id = b.ref_organisme" .
		"	AND b.signe_variation =1" .
		"	ORDER BY b.valeur_variation DESC " .
 		" 	LIMIT 0 , ".$nombre_enregistrement;

$db->query($sSQL);
$next_record = $db->next_record();
if(!$next_record) {
	$tpl->set_var("blochaussejour", "");
	return;
}
	$i	=	0;
	while($next_record) {
		$tpl->set_var("organisme", tohtml($db->f("o_libelle")));
		$tpl->set_var("valeur_variation", tohtml(number_format ($db->f("b_valeur_variation"),1)));
		$tpl->set_var("ordre",$i%2);
		$tpl->parse("haussejour", true);
		$next_record = $db->next_record();
		$i++;
	}
	
	
	$tpl->parse("blochaussejour", false);
	$tpl->set_var("haussejour", "");




} 

//====================================
function showboursebaisse($nombre_enregistrement){
//====================================
global $tpl;
global $db;


		
$sSQL = "SELECT o.libelle AS o_libelle, b.valeur_variation AS b_valeur_variation" .
		"	FROM organisme o, bourse_valeur b" .
		"	WHERE o.id = b.ref_organisme" .
		"	AND b.signe_variation =0" .
		"	ORDER BY b.valeur_variation DESC " .
 		" 	LIMIT 0 , ".$nombre_enregistrement;

$db->query($sSQL);
$next_record = $db->next_record();
if(!$next_record) {
	$tpl->set_var("blocbaissejour", "");
	return;
}
	$i	=	0;
	while($next_record) {
		$tpl->set_var("organisme", tohtml($db->f("o_libelle")));
		$tpl->set_var("valeur_variation", tohtml(number_format ($db->f("b_valeur_variation") ,1)));
		
		$tpl->set_var("ordre",$i%2);
		$tpl->parse("baissejour", true);
		$next_record = $db->next_record();
		$i++;
	}
	
	
	$tpl->parse("blocbaissejour", false);
	$tpl->set_var("baissejour", "");


} 
//====================================
function showbanniere ($ref_zone) {
//====================================
global $tpl;
global $db;
$code = "";
$libelle = "";


			$sSQL = " SELECT ";
			$sSQL .= " b.id AS b_id, ";
			$sSQL .= " b.libelle AS b_libelle, ";
			$sSQL .= " b.code AS b_code, ";
			$sSQL .= " b.est_actif AS b_est_actif, ";
			$sSQL .= " b.ref_zone AS b_ref_zone ";
			$sSQL .= " FROM ban_banniere b ";
			$sSQL .= " WHERE  b.ref_zone = ". $ref_zone;
	
	$db->query($sSQL);

	$next_record = $db->next_record();
	if($next_record) {
	
		$code =  $db->f("b_code");
		$libelle =  $db->f("b_libelle");
		
		$tpl->set_var("code", $db->f("b_code"));
		//$next_record = $db2->next_record();
		}

	
	$tpl->parse("banniere".$libelle, false);
	//$tpl->set_var("code", "");
		
}

//====================================
function showarticle($id,$idtheme){
//====================================
global $tpl;
global $db;
$titrepush	= "";
$alias	= "";
$parametre_cle	= "";
$libelle	= "";
$nombre_enregistrement		= "";
$procedures = ""; 
$swhere = "" ; 
 if(strlen($idtheme)>0){
 	$swhere = " AND t_id = " .$idtheme;
	$sSQL = "select *  " ;
$sSQL .= "from view_article_theme where a_id = " .$id . $swhere;

 }
 else{
 $sSQL = "select '' as t_titre, "; 
  $sSQL .= "a.id as a_id, ";
  $sSQL .= "a.titre as a_titre , ";
  $sSQL .= "a.contenu as a_contenu, ";
  $sSQL .= "a.date_creation as a_date_creation, ";
  $sSQL .= "a.url_image as a_url_image ";
  $sSQL .= "from cnt_article a  where a.id = " .$id;
 }

$db->query($sSQL);
	$next_record = $db->next_record();
	

	
	
	if($next_record) {
		$titretheme =  $db->f("t_titre");
	
		
	}
	else {
	$tpl->set_var("articletheme", "");
	return;
}

		


	while($next_record) {
	    
		$tpl->set_var("titrearticle", tohtml($db->f("a_titre")));
		$tpl->set_var("contenu", tohtml($db->f("a_contenu")));
		//$tpl->set_var("datearticle", tohtml($db->f("a_date_creation")));
		$tpl->set_var("datearticle", "");
		$tpl->set_var("idarticle", tohtml($db->f("a_id")));
		$tpl->set_var("url_image", tohtml($db->f("a_url_image")));
		$tpl->parse("article", true);
		$next_record = $db->next_record();
		
	}
	
	
	$tpl->set_var("titretheme", tohtml($titretheme));
	$tpl->parse("articletheme", false);
	$tpl->set_var("article", "");

} 

//==============================================
function showarticletheme($ref_theme, $FileName){
//==============================================
			global $tpl;
			global $db;
			$titrepush	= "";
			$alias	= "";
			$parametre_cle	= "";
			$libelle	= "";
			$nombre_enregistrement		= "";
			$procedures = ""; 
			
		//$FileName = "article_theme.php";

	$tpl->set_var("FileName", $FileName);


$sSQL = "select *  " ;
$sSQL .= "from view_article_theme where t_id = " .$ref_theme ;
$db->query($sSQL);
	$next_record = $db->next_record();
	
	
	if($next_record) {
		$titretheme =  $db->f("t_titre");
	
	}
	else {
	$tpl->set_var("articletheme", "");
	return;
}


	if($sCountSQL == ""){
		$sCountSQL = "select count(*) from view_article_theme where t_id = " .$ref_theme;
	}

	$iRecordsPerPage = 5;
	$iCounter = 0;
	
	$iPage = get_param("Formlist_Page");
	$db_count = get_db_value($sCountSQL);
	$dResult = intval($db_count) / $iRecordsPerPage;
	$iPageCount = intval($dResult);

	if($iPageCount < $dResult) $iPageCount = $iPageCount + 1;
	
	$tpl->set_var("listPageCount", $iPageCount);
	
	if(!strlen($iPage))
		$iPage = 1;
	else{
		if($iPage == "last") $iPage = $iPageCount;
	}
		
	if(($iPage - 1) * $iRecordsPerPage != 0){
		do{
			$iCounter++;
		}
		while ($iCounter < ($iPage - 1) * $iRecordsPerPage && $db->next_record());
			$next_record = $db->next_record();
	}
	
	$iCounter = 0;

	while($next_record && $iCounter < $iRecordsPerPage) {
	    
		$tpl->set_var("titrearticle", tohtml($db->f("a_titre")));
		$tpl->set_var("datearticle", tohtml($db->f("a_date_creation")));
		$tpl->set_var("descriptionarticle", tohtml($db->f("a_description")));
		$tpl->set_var("idarticle", tohtml($db->f("a_id")));
		$tpl->set_var("url_image", tohtml($db->f("a_url_image")));
		$tpl->set_var("idtheme", $ref_theme);
		$tpl->parse("article", true);
		$next_record = $db->next_record();
		$iCounter++;
		
		
	}
	$bEof = $next_record;

	if(!$bEof && $iPage == 1)
		$tpl->set_var("listNavigator", "");
	else{
		$iCounter = 1;
		$iHasPages = $iPage;
		$iDisplayPages = 0;
		$iNumberOfPages = 10;
		$iHasPages = $iPageCount;
		if (($iHasPages - $iPage) < intval($iNumberOfPages / 2))
			$iStartPage = $iHasPages - $iNumberOfPages;
		else
			$iStartPage = $iPage - $iNumberOfPages + intval($iNumberOfPages / 2);
	
		if($iStartPage < 0) $iStartPage = 0;
		
		for($iPageCount = $iStartPage + 1;  $iPageCount <= $iPage - 1; $iPageCount++){
			$tpl->set_var( "NavigatorPageNumber", $iPageCount);
			$tpl->set_var( "NavigatorPageNumberView", $iPageCount);
			$tpl->parse( "listNavigatorPages", true);
			$iDisplayPages++;
		}

		$tpl->set_var( "NavigatorPageSwitch", "_");
		$tpl->set_var( "NavigatorPageNumber", $iPage);
		/*Mise En forme des pages vistées lors de la pagination*/
		$tpl->set_var( "NavigatorPageNumberView", "<font color='#0099FF'>".$iPage."</font>");
		$tpl->parse( "listNavigatorPages", true);
		$iDisplayPages++;
		$tpl->set_var( "NavigatorPageSwitch", "");
		$iPageCount = $iPage + 1;

		while ($iDisplayPages < $iNumberOfPages && $iStartPage + $iDisplayPages < $iHasPages){
			$tpl->set_var( "NavigatorPageNumber", $iPageCount);
			$tpl->set_var( "NavigatorPageNumberView", $iPageCount);
			$tpl->parse( "listNavigatorPages", true);
			$iDisplayPages++;
			$iPageCount++;
		}

		if(!$bEof)
			$tpl->set_var("listNavigatorLastPage", "_");
		else
			$tpl->set_var("NextPage", ($iPage + 1));

		if($iPage == 1)
			$tpl->set_var("listNavigatorFirstPage", "_");
		else
			$tpl->set_var("PrevPage", ($iPage - 1));
	
		$tpl->set_var("listCurrentPage", $iPage);
		$tpl->parse( "listNavigator", false);
	}
	
	
	$tpl->set_var("titretheme", tohtml($titretheme));
	$tpl->parse("articletheme", false);
	$tpl->set_var("article", "");


} 

//====================================
function showlistversionimprimable ($id){
//====================================
	global $tpl;
	global $db;


		$sSQL = "SELECT * ";
		$sSQL .= "FROM version_papier ";
		$sSQL .= "ORDER BY date DESC ";


	$db->query($sSQL);
	
	$next_record = $db->next_record();
	
	
	
	while($next_record) {
				
		$tpl->set_var("titre", tohtml($db->f("titre")));
		$tpl->set_var("image", tohtml($db->f("image")));
		$tpl->set_var("date", tohtml($db->f("date")));
		$tpl->set_var("description", tohtml($db->f("description")));
		$tpl->set_var("pdf", tohtml($db->f("pdf")));
		$tpl->parse("versionpapierdetail", true);
		$next_record = $db->next_record();
		}
	$tpl->parse("versionpapier", false);
	$tpl->set_var("versionpapierdetail", "");
}



//====================================
function showversionimprimable (){
//====================================
global $tpl;
global $db;


		$sSQL = "SELECT * ";
		$sSQL .= "FROM version_papier ";
		$sSQL .= "ORDER BY date DESC ";
		$sSQL .= "LIMIT 0, 1 ";


	$db->query($sSQL);
	
	$next_record = $db->next_record();
	if($next_record) {
		$image =  $db->f("image");
		$titre =  $db->f("titre");
		$pdf =  $db->f("pdf");
		
		}
		
	$tpl->set_var("image", tohtml($image));
	$tpl->set_var("titre", tohtml($titre));
	$tpl->set_var("pdf", tohtml($pdf));
	$tpl->parse("versionpapier", false);


}

function getTagArticle($id, $isArticle){

	global $db;
	$sSQLTag = "";
	$sTag = "";

	if ($isArticle == 1) 
		$sSQLTag = "Select tag as c_tag from cnt_article where id = " .tosql($id, "Number");
	else
		$sSQLTag = "Select distinct tag as c_tag from cnt_article c, cnt_article_theme ct, cnt_theme t where c.id = ct.ref_article and ct.ref_theme = t.id and t.id = " .tosql($id, "Number");

	if (strlen($sSQLTag)) {
		$db->query($sSQLTag);
		$next_record = $db->next_record();
		while ($next_record){
			$sTag .= $db->f("c_tag").",";
			$next_record = $db->next_record();
		}
	} 
	$TabKey = explode(",", $sTag);
	$TabKey = array_unique ($TabKey);
	$sTag = implode(",", $TabKey);
	return substr($sTag, 0, (strlen($sTag)-1)); ;

}

?>