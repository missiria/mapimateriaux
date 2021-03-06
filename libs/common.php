<?php
session_start();
error_reporting (E_ALL ^ E_NOTICE);

include("template.php");

define("_DEFAULTLANG","fr");

$lang = get_param("lang");


$_SESSION['currency'] = "dollar";

$toDollar = 1.2;
$toEuro = 1.8;
$RefPays = 1;
$treeThemeXML = "<?xml version='1.0' encoding='iso-8859-1'?><tree id='0'>";

include("db_mysql.php");

define("DATABASE_NAME","mapi");
define("DATABASE_USER","mapi");
define("DATABASE_PASSWORD","med1982aga");
define("DATABASE_HOST","mysql1095.servage.net");

$rootFR = 1;
$rootAR = 2;
$rootEN = 3;

// Database Initialize
$db = new DB_Sql();
$db->Database = DATABASE_NAME;
$db->User     = DATABASE_USER;
$db->Password = DATABASE_PASSWORD;
$db->Host     = DATABASE_HOST;

$db2 = new DB_Sql();
$db2->Database = DATABASE_NAME;
$db2->User     = DATABASE_USER;
$db2->Password = DATABASE_PASSWORD;
$db2->Host     = DATABASE_HOST;

$app_path = "."; 

function getIdIntervenant () {
	global $lang;
	
	$idIntervenant = "";
		
	switch ($lang){
		case "fr" : 
			$idIntervenant = 83;
		break;
		
		case "en" : 
			$idIntervenant = 100; 
		break;
		
		case "ar" : 
			$idIntervenant = 200; 
		break;
	}
	
	return $idIntervenant;
}

function supp_espace ($chaine) {
	$mot_cle = "";
	$array = split(" ", $chaine);
	for ($i=0;$i<sizeof($array);$i++) {
		$mot_cle .= " ".trim($array[$i]);
	}
	return trim($mot_cle);
}

function dateTime($time , $mode = 'long') {
	global $lang;
	
	switch ($lang){
		case 'fr' : 
			DEFINE("JANVIER","Janvier"); DEFINE("FEVRIER","F�vrier");	DEFINE("MARS","Mars");
			DEFINE("AVRIL","Avril"); DEFINE("MAI","Mai"); DEFINE("JUIN","Juin");
			DEFINE("JUILLET","Juillet"); DEFINE("AOUT","Ao�t");DEFINE("SEPTEMBRE","Septembre");
			DEFINE("OCTOBRE","Octobre");DEFINE("NOVEMBRE","Novembre");DEFINE("DECEMBRE","D�cembre");
			DEFINE("LUNDI","Lundi"); DEFINE("MARDI","Juin");	DEFINE("MERCREDI","Mercredi");
			DEFINE("JEUDI","Jeudi"); DEFINE("VENDREDI","Vendredi");DEFINE("SAMEDI","Samedi");
			DEFINE("DIMANCHE","Dimanche");
		break;
				
		case 'ar' : 
			DEFINE("JANVIER","?????"); DEFINE("FEVRIER","?????");	DEFINE("MARS","????");
			DEFINE("AVRIL","?????"); DEFINE("MAI","???"); DEFINE("JUIN","????");
			DEFINE("JUILLET","??????"); DEFINE("AOUT","???");DEFINE("SEPTEMBRE","??????");
			DEFINE("OCTOBRE","??????");DEFINE("NOVEMBRE","??????");DEFINE("DECEMBRE","??????");
			DEFINE("LUNDI","???????"); DEFINE("MARDI","????????");	DEFINE("MERCREDI","????????");
			DEFINE("JEUDI","??????"); DEFINE("VENDREDI","????");DEFINE("SAMEDI","?????");
			DEFINE("DIMANCHE","?????");
		break;
		
		case 'en' : 
			DEFINE("JANVIER","January"); DEFINE("FEVRIER","February");	DEFINE("MARS","March");
			DEFINE("AVRIL","April"); DEFINE("MAI","May"); DEFINE("JUIN","June");
			DEFINE("JUILLET","July"); DEFINE("AOUT","August");DEFINE("SEPTEMBRE","September");
			DEFINE("OCTOBRE","Oct");DEFINE("NOVEMBRE","Nov");DEFINE("DECEMBRE","Dec");
			DEFINE("LUNDI","Monday"); DEFINE("MARDI","Tuesday");	DEFINE("MERCREDI","Wed");
			DEFINE("JEUDI","Thu"); DEFINE("VENDREDI","Friday");DEFINE("SAMEDI","Saturday");
			DEFINE("DIMANCHE","Sunday");	
		break;
	}	
		
	setlocale( LC_TIME, "fr" );
	// Recuperation du nom du mois
	$mi =  strftime( "%m" , strtotime( $time ) );
	switch ($mi){
		case '1' : $mi = JANVIER; break;case '2' : $mi = FEVRIER; break;case '3' : $mi = MARS; break;
		case '4' : $mi = AVRIL; break;case '5' : $mi = MAI; break;case '6' : $mi = JUIN; break;
		case '7' : $mi = JUILLET; break;case '8' : $mi = AOUT; break;case '9' : $mi = SEPTEMBRE; break;
		case '10' : $mi = OCTOBRE; break;case '11' : $mi = NOVEMBRE; break;	case '12' : $mi = DECEMBRE; break;
	}
	// Recuperation du nom du jour
	$w = strftime( "%u" , strtotime( $time ) );
	switch ($w){
		case '1' : $w = LUNDI; break;case '2' : $w = MARDI; break;case '3' : $w = MERCREDI; break;
		case '4' : $w = JEUDI; break;case '5' : $w = VENDREDI; break;case '6' : $w = SAMEDI; break;
		case '7' : $w = DIMANCHE; break;
	}
	// Recuperation du jour
	$mor1 = strftime( "%d " , strtotime( $time ) );
	// Recuperation de l'ann�e
	$mor2 = strftime( "%Y" , strtotime( $time ) );
	if ( $mode == 'long' ) {
		// Recuperation de l'heure+minute+seconde
		$mor3 = strftime( "%H:%M" , strtotime( $time ) );
	}else{
		$mor3 = NULL;
	}
	return $w.' '.$mor1.' '. $mi. ' '.$mor2. ' ';
}
		
function HTMLDecode($ligne) {

	$ligne = str_replace("&quot;",chr(34),$ligne);
	$ligne = str_replace("&amp;",chr(38),$ligne);
	$ligne = str_replace("&lt;",chr(60),$ligne);
	$ligne = str_replace("&gt;",chr(62),$ligne);
	$ligne = str_replace("&nbsp;",chr(160),$ligne);
	$ligne = str_replace("&iexcl;",chr(161),$ligne);
	$ligne = str_replace("&cent;",chr(162),$ligne);
	$ligne = str_replace("&pound;",chr(163),$ligne);
	$ligne = str_replace("&curren;",chr(164),$ligne);
	$ligne = str_replace("&yen;",chr(165),$ligne);
	$ligne = str_replace("&brvbar;",chr(166),$ligne);
	$ligne = str_replace("&sect;",chr(167),$ligne);
	$ligne = str_replace("&uml;",chr(168),$ligne);
	$ligne = str_replace("&copy;",chr(169),$ligne);
	$ligne = str_replace("&ordf;",chr(170),$ligne);
	$ligne = str_replace("&laquo;",chr(171),$ligne);
	$ligne = str_replace("&not;",chr(172),$ligne);
	$ligne = str_replace("&shy;",chr(173),$ligne);
	$ligne = str_replace("&reg;",chr(174),$ligne);
	$ligne = str_replace("&macr;",chr(175),$ligne);
	$ligne = str_replace("&deg;",chr(176),$ligne);
	$ligne = str_replace("&plusmn;",chr(177),$ligne);
	$ligne = str_replace("&sup2;",chr(178),$ligne);
	$ligne = str_replace("&sup3;",chr(179),$ligne);
	$ligne = str_replace("&acute;",chr(180),$ligne);
	$ligne = str_replace("&micro;",chr(181),$ligne);
	$ligne = str_replace("&para;",chr(182),$ligne);
	$ligne = str_replace("&middot;",chr(183),$ligne);
	$ligne = str_replace("&cedil;",chr(184),$ligne);
	$ligne = str_replace("&sup1;",chr(185),$ligne);
	$ligne = str_replace("&ordm;",chr(186),$ligne);
	$ligne = str_replace("&raquo;",chr(187),$ligne);
	$ligne = str_replace("&frac14;",chr(188),$ligne);
	$ligne = str_replace("&frac12;",chr(189),$ligne);
	$ligne = str_replace("&frac34;",chr(190),$ligne);
	$ligne = str_replace("&iquest;",chr(191),$ligne);
	$ligne = str_replace("&times;",chr(215),$ligne);
	$ligne = str_replace("&divide;",chr(247),$ligne);
	$ligne = str_replace("&AElig;",chr(198),$ligne);
	$ligne = str_replace("&Aacute;",chr(193),$ligne);
	$ligne = str_replace("&Acirc;",chr(194),$ligne);
	$ligne = str_replace("&Agrave;",chr(192),$ligne);
	$ligne = str_replace("&Aring;",chr(197),$ligne);
	$ligne = str_replace("&Atilde;",chr(195),$ligne);
	$ligne = str_replace("&Auml;",chr(196),$ligne);
	$ligne = str_replace("&Ccedil;",chr(199),$ligne);
	$ligne = str_replace("&ETH;",chr(208),$ligne);
	$ligne = str_replace("&Eacute;",chr(201),$ligne);
	$ligne = str_replace("&Ecirc;",chr(202),$ligne);
	$ligne = str_replace("&Egrave;",chr(200),$ligne);
	$ligne = str_replace("&Euml;",chr(203),$ligne);
	$ligne = str_replace("&Iacute;",chr(205),$ligne);
	$ligne = str_replace("&Icirc;",chr(206),$ligne);
	$ligne = str_replace("&Igrave;",chr(204),$ligne);
	$ligne = str_replace("&Iuml;",chr(207),$ligne);
	$ligne = str_replace("&Ntilde;",chr(209),$ligne);
	$ligne = str_replace("&Oacute;",chr(211),$ligne);
	$ligne = str_replace("&Ocirc;",chr(212),$ligne);
	$ligne = str_replace("&Ograve;",chr(210),$ligne);
	$ligne = str_replace("&Oslash;",chr(216),$ligne);
	$ligne = str_replace("&Otilde;",chr(213),$ligne);
	$ligne = str_replace("&Ouml;",chr(214),$ligne);
	$ligne = str_replace("&THORN;",chr(222),$ligne);
	$ligne = str_replace("&Uacute;",chr(218),$ligne);
	$ligne = str_replace("&Ucirc;",chr(219),$ligne);
	$ligne = str_replace("&Ugrave;",chr(217),$ligne);
	$ligne = str_replace("&Uuml;",chr(220),$ligne);
	$ligne = str_replace("&Yacute;",chr(221),$ligne);
	$ligne = str_replace("&aacute;",chr(225),$ligne);
	$ligne = str_replace("&acirc;",chr(226),$ligne);
	$ligne = str_replace("&aelig;",chr(230),$ligne);
	$ligne = str_replace("&agrave;",chr(224),$ligne);
	$ligne = str_replace("&aring;",chr(229),$ligne);
	$ligne = str_replace("&atilde;",chr(227),$ligne);
	$ligne = str_replace("&auml;",chr(228),$ligne);
	$ligne = str_replace("&ccedil;",chr(231),$ligne);
	$ligne = str_replace("&eacute;",chr(233),$ligne);
	$ligne = str_replace("&ecirc;",chr(234),$ligne);
	$ligne = str_replace("&egrave;",chr(232),$ligne);
	$ligne = str_replace("&eth;",chr(240),$ligne);
	$ligne = str_replace("&euml;",chr(235),$ligne);
	$ligne = str_replace("&iacute;",chr(237),$ligne);
	$ligne = str_replace("&icirc;",chr(238),$ligne);
	$ligne = str_replace("&igrave;",chr(236),$ligne);
	$ligne = str_replace("&iuml;",chr(239),$ligne);
	$ligne = str_replace("&ntilde;",chr(241),$ligne);
	$ligne = str_replace("&oacute;",chr(243),$ligne);
	$ligne = str_replace("&ocirc;",chr(244),$ligne);
	$ligne = str_replace("&ograve;",chr(242),$ligne);
	$ligne = str_replace("&oslash;",chr(248),$ligne);
	$ligne = str_replace("&otilde;",chr(245),$ligne);
	$ligne = str_replace("&ouml;",chr(246),$ligne);
	$ligne = str_replace("&szlig;",chr(223),$ligne);
	$ligne = str_replace("&thorn;",chr(254),$ligne);
	$ligne = str_replace("&uacute;",chr(250),$ligne);
	$ligne = str_replace("&ucirc;",chr(251),$ligne);
	$ligne = str_replace("&ugrave;",chr(249),$ligne);
	$ligne = str_replace("&uuml;",chr(252),$ligne);
	$ligne = str_replace("&yacute;",chr(253),$ligne);
	$ligne = str_replace("&yuml;",chr(255),$ligne);
	$ligne = str_replace("&#8482;",chr(153),$ligne);
	$ligne = str_replace("&trade;",chr(153),$ligne);
	$ligne = str_replace("&Trade;",chr(153),$ligne);
	$ligne = str_replace("\'","'",$ligne);
	
	return $ligne;
}

//==============================================
function tobr($strValue){
	$strValue = str_replace("\n","<br>",$strValue);

	return $strValue;
}

function tospace($strValue){
	$strValue = str_replace("-"," ",$strValue);

	return $strValue;
}

function removeaccents($string)   
{    
 $string= strtr($string,    
"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ",   
"aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");    
 
 $string= str_replace("/", "+", $string);
 
 return $string;    
}

//-------------------------------
// Convert non-standard characters to HTML
//-------------------------------
function tohtml($strValue)
{

  //return html_entity_decode($strValue);
  //return htmlspecialchars ($strValue);
  return $strValue;
}

//-------------------------------
// Convert value to URL
//-------------------------------
function tourl($strValue)
{
  return urlencode($strValue);
}

function get_param($param_name)
{
  global $_POST;
  global $_GET;

  $param_value = "";
  if(isset($_POST[$param_name]))
    $param_value = $_POST[$param_name];
  else if(isset($_GET[$param_name]))
    $param_value = $_GET[$param_name];

  return $param_value;
}

function get_session($param_name)
{
  global $HTTP_POST_VARS;
  global $HTTP_GET_VARS;
  global ${$param_name};
	
  if(phpversion() > "4.0.6")
  {
	  	$param_value = "";
  		if(isset($_SESSION[$param_name])) 
	  	  $param_value = $_SESSION[$param_name];
  } else {
  	  $param_value = "";
	  if(!isset($HTTP_POST_VARS[$param_name]) && !isset($HTTP_GET_VARS[$param_name]) && session_is_registered($param_name)) 
		$param_value = ${$param_name};
 }
  return $param_value;
}

function set_session($param_name, $param_value) {

	global ${$param_name};

 	if(phpversion() > "4.0.6")
	{
		$_SESSION[$param_name] = $param_value;
	
	} else {
	
		if(session_is_registered($param_name))
			session_unregister($param_name);
		
		${$param_name} = $param_value;
		session_register($param_name);
		${$param_name} = $param_value;
	
	}
}

function is_number($string_value)
{
  if(is_numeric($string_value) || !strlen($string_value))
    return true;
  else 
    return false;
}

//-------------------------------
// Convert value for use with SQL statament
//-------------------------------
function tosql($value, $type) {

  if($value == "")
    return "NULL";
  else
    if($type == "Number")
      return str_replace (",", ".", doubleval($value));
    else
    {
      if(get_magic_quotes_gpc() == 0)
      {
        $value = str_replace("'","''",$value);
        $value = str_replace("\\","\\\\",$value);
      }
      else
      {
        $value = str_replace("\\'","''",$value);
        $value = str_replace("\\\"","\"",$value);
      }

      return "'" . $value . "'";
    }
}
function strip($value)
{
  if(get_magic_quotes_gpc() == 0)
    return $value;
  else
    return stripslashes($value);
}

function db_fill_array($sql_query)
{
  global $db;
  $db_fill = new DB_Sql();
  $db_fill->Database = $db->Database;
  $db_fill->User     = $db->User;
  $db_fill->Password = $db->Password;
  $db_fill->Host     = $db->Host;
  
  $db_fill->query($sql_query);
  if ($db_fill->next_record())
  {
    do
    {
      $ar_lookup[$db_fill->f(0)] = $db_fill->f(1);
    } while ($db_fill->next_record());
    return $ar_lookup;
  }
  else
    return false;

}

function recup_article ($filename, $lang) {
	$id_article = dlookup("cnt_article", "id", "redirect like '%".$filename."%' and ref_langue='".$lang."'");
	
	if (strlen($id_article) == 0)
		$id_article = 1;
	return $id_article;
}

//-------------------------------
// Deprecated function - use get_db_value($sql)
//-------------------------------
function dlookup($table_name, $field_name, $where_condition)
{
  $sql = "SELECT " . $field_name . " FROM " . $table_name . " WHERE " . $where_condition;
  return get_db_value($sql);
}


//-------------------------------
// Lookup field in the database based on SQL query
//-------------------------------
function get_db_value($sql)
{
  global $db;
  $db_look = new DB_Sql();
  $db_look->Database = $db->Database;
  $db_look->User     = $db->User;
  $db_look->Password = $db->Password;
  $db_look->Host     = $db->Host;

  $db_look->query($sql);
  if($db_look->next_record())
    return $db_look->f(0);
  else 
    return "";
}

//-------------------------------
// Obtain Checkbox value depending on field type
//-------------------------------
function get_checkbox_value($value, $checked_value, $unchecked_value, $type)
{
  if(!strlen($value))
    return tosql($unchecked_value, $type);
  else
    return tosql($checked_value, $type);
}

//-------------------------------
// Obtain lookup value from array containing List Of Values
//-------------------------------
function get_lov_value($value, $array)
{
  $return_result = "";

  if(sizeof($array) % 2 != 0) 
    $array_length = sizeof($array) - 1;
  else
    $array_length = sizeof($array);
  reset($array);

  for($i = 0; $i < $array_length; $i = $i + 2)
  {
    if($value == $array[$i]) $return_result = $array[$i+1];
  }

  return $return_result;
}

function is_date($Date) {
	// Format = "d-m-y"
  if (trim($Date)!="")  {
	  $tmp = split("-", $Date);
	  if ((int)$tmp[2]<1980) $tmp[2] = -1;
	  return  checkdate((int)$tmp[1],(int)$tmp[0],(int)$tmp[2]);
  } else return false;
} 

function Format_Date($pattern, $d) {
	// Format = "d-m-y"
	if(strlen($d)) {	
		$tab = split("-", $d);
		return date($pattern, mktime(0,0,0,$tab[1],$tab[2],$tab[0]));
	} else {
		return;
	}	
}

function Format_Date_tosql($format, $d_tosql) {
	if(strlen($d_tosql)) {	
		$array = split("/", $d_tosql);
		return date($format, mktime(0,0,0,$array[1],$array[0],$array[2]));
	} else {
		return;
	}	
}

function month_diff($date1, $date2) {
	$month1 = FormatDate("m", $date1);
	$month2 = FormatDate("m", $date2);
	$year1 = FormatDate("Y", $date1);
	$year2 = FormatDate("Y", $date2);
	
	if($year2>$year1){
		$duree=(12-$month1)+$month2+($year2-($year1+1))*12;
	} else if($year2==$year1) {
		$duree=($month2-$month1)+1;
	} else {
		$duree=0;
	}
	return $duree;
}

function date_diff_com($date1, $date2) {
	$date1 = FormatDate("Y-m-d", $date1);
	$date2 = FormatDate("Y-m-d", $date2);
	$date1 = strtotime ($date1." 00:00");
	$date2 = strtotime ($date2." 00:00"); 
	return (($date2-$date1)/86400);
}

//Create a random login
function create_login($value){
	//return create_password($value);
	return "admin".$value;
}

//Create a random password
function create_password($value) {
    $makepass="";
    $syllables="er,in,tia,dun,fe,pre,vet,jo,nes,al,len,son,cha,ir,ler,bo,ok,tio,nar,sim,ple,bla,ten,toe,cho,co,lat,spe,ak,er,po,co,lor,pen,cil,li,ght,wh,at,the,he,ck,is,mam,bo,no,fi,ve,any,way,pol,iti,cs,ra,dio,sou,rce,sea,rch,pa,per,com,bo,sp,eak,st,fi,rst,gr,oup,boy,ea,gle,tr,ail,bi,ble,brb,pri,dee,kay,en,be,se";
    $syllable_array=explode(",", $syllables);
    srand((double)microtime()*1000000);
    for ($count=1;$count<=4;$count++) {
       if (rand()%10 == 1) {
          $makepass .= sprintf("%0.0f",(rand()%50)+1);
       } else {
          $makepass .= sprintf("%s",$syllable_array[rand()%62]);
       }
    }
    return($makepass);
}

function date_enTofr($date){
	$annee = substr($date, 0, 4);
	$mois = substr($date, 5, 2);
	$jour = substr($date, 8, 2);
	return $jour."/".$mois."/".$annee;
}

function date_frToen($date){
	$jour = substr($date, 0, 2);
	$mois = substr($date, 3, 2);
	$annee = substr($date, 6, 4);
	return $annee."-".$mois."-".$jour;
}

function getReturnMessage($sCode){
	switch ($sCode){
		case "00000":
			return RETURN_MESSAGE_00000;
		break;		
		case "00001":
			return RETURN_MESSAGE_00001;
		break;
		case "00002":
			return RETURN_MESSAGE_00002;
		break;
		case "00003":
			return RETURN_MESSAGE_00003;
		break;
		case "00004":
			return RETURN_MESSAGE_00004;
		break;
		case "00005":
			return RETURN_MESSAGE_00005;
		break;
		case "00006":
			return RETURN_MESSAGE_00006;
		break;
		case "00007":
			return RETURN_MESSAGE_00007;
		break;
		case "00008":
			return RETURN_MESSAGE_00008;
		break;
		case "00009":
			return RETURN_MESSAGE_00009;
		break;
		case "00010":
			return RETURN_MESSAGE_00010;
		break;		
		case "00011":
			return RETURN_MESSAGE_00011;
		break;
		case "00012":
			return RETURN_MESSAGE_00012;
		break;
		case "00013":
			return RETURN_MESSAGE_00013;
		break;
		case "00014":
			return RETURN_MESSAGE_00014;
		break;
		case "00015":
			return RETURN_MESSAGE_00015;
		break;
		case "00016":
			return RETURN_MESSAGE_00016;
		break;
		case "00017":
			return RETURN_MESSAGE_00017;
		break;
		case "00018":
			return RETURN_MESSAGE_00018;
		break;
		case "00019":
			return RETURN_MESSAGE_00019;
		break;
		case "00020":
			return RETURN_MESSAGE_00020;
		break;
		case "00099":
			return RETURN_MESSAGE_00099;
		break;
		case "":
			return RETURN_MESSAGE_ANNULATION;
			break;
		default:
			return RETURN_MESSAGE_UNKNOWN;
			break;		
	}			
}

/*Normaliser l'URL*/
function NormalizeURL($str){
	
	//$str= str_replace(" ","",$str);
	//$str=str_replace("&","-",$str);
	//$str=str_replace("?","-",$str);
	//$str=str_replace("'","",$str);
	//$str=str_replace(":","",$str);
	//$str=str_replace(";","",$str);
	//$str=str_replace("/","",$str);
	//$str=str_replace("\\","",$str);
	//$str=str_replace("é","e",$str);
	//$str=str_replace("è","e",$str);
	//$str=str_replace("à","a",$str);
	//$str=str_replace("ê","e",$str);
	//$str=str_replace("â","a",$str);
	$str=ereg_replace("<\/?[^>]*>","",$str);	
	$str=str_replace("<","",$str);
	$str=str_replace(">","",$str);
	//echo $str."<br>";
	//$str=str_replace("&eacute;","e",$str);
	$str=chrClean($str);
	return $str;
}

function chrClean($chaine){
	$chaine = strtr($chaine, array(
		'&quot;'=>'', 
		'&amp;'=>'', 
		'&euro;'=>'',
		'&nbsp;'=>' ',
		'&Aacute;'=>'a',
		'&aacute;'=>'a',
		'&Acirc;'=>'a',
		'&acirc;'=>'a',
		'&Agrave;'=>'a',
		'&agrave;'=>'a',
		'&eacute;'=>'e',
		'&Eacute;'=>'e',
		'&ecirc;'=>'e',
		'&Egrave;'=>'e',
		'&egrave;'=>'e',
		));


	//$chaine = strtr($chaine, 
	//'Š?š?ŸÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜàáâãäåçèéêëìíîïñòóôõöøùúûüÿ.:!?¿,°_?%`´/&+" ',
	//'SZszYAAAAAACEEEEIIIINOOOOOOUUUUaaaaaaceeeeiiiinoooooouuuuy----------------');  
	$chaine = strtr($chaine, 
	'Š?š?ŸÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜàáâãäåçèéêëìíîïñòóôõöøùúûüÿ.:!?¿,°_?%`´/+"',
	'SZszYAAAAAACEEEEIIIINOOOOOOUUUUaaaaaaceeeeiiiinoooooouuuuy---------------');  
	$chaine = strtr($chaine, array('('=>'', ')'=>'', ' '=>'-', '«'=>'', 
		'»'=>'', '¡'=>'', '!'=>'', '¤'=>'', '²'=>'', '©'=>'', "'"=>'', 
		'"'=>'', 'G'=>'DH',  'ß'=>'ss', 
		'Œ'=>'OE', 'œ'=>'oe', 'Æ'=>'AE', 'æ'=>'ae', 'µ'=>'u', 'œ'=>'oe', 
		'¼'=>'', '¨'=>'', '?'=>''));
	$chaine = strtr($chaine, array('---' => '-', '--' => '-'));
	$chaine = eregi_replace("^-", "", $chaine);
	$chaine = eregi_replace("-$", "", $chaine); 
	return strtolower($chaine);
}

function GetDescription($str){
	$aWords = split("[,:/\\\. ]",$str);
	if(sizeof($aWords)==0){
		$str="none";
	}elseif(sizeof($aWords)==1){
		$str=$aWords[0];
	}else{
		$str=$aWords[0]." ".$aWords[1];
	}		
	$str=ereg_replace("<\/?[^>]*>","",$str);	
	$str=str_replace("<","",$str);
	$str=str_replace(">","",$str);
	
	return $str;
}

function setLength($phrase, $longueur) {
	//on verifie que la phrase est trop longue 
	if(strlen($phrase)>$longueur){ 
		//on la coupe à la longueur choisie 
		$phrase=substr($phrase,0,$longueur); 
		//on cherche le dernier espace 
		$espace=strrpos($phrase," "); 
		//on recoupe au niveau de l'espace 
		$phrase=substr($phrase,0,$espace); 
		//on fignole avec les points... 
		$phrase=$phrase.' [...]'; 
	}
	return $phrase;
}

function toJavascript($strValue){
	$strValue = str_replace("\n"," ",$strValue);
	$strValue = str_replace("\r", " ", $strValue);
	$strValue = str_replace("'", "\'", $strValue);
	return $strValue;
}

//Send an email to destination
function sendmail($to, $cci, $subject,$messageHtml, $messageText, $sFrom, $sCc){
	ini_set("SMTP",_SMTP);
	
	$Codage = "_NextPart_".md5(uniqid(rand())); 
 
  	$Entete = "Reply-to: ".$sFrom."\n"; 
	$Entete .= "From:".$sFrom."\n";
	
	if (strlen($cci)) {
		$Entete .= "Bcc:".$cci."\n";  
	}
	
	$Entete .= "Date: ".date("l j F Y, G:i")."\n"; 
	$Entete .= "MIME-Version: 1.0\n"; 
	$Entete .= "Content-Type: multipart/alternative;\n"; 
	$Entete .= " boundary=\"----=".$Codage."\"\n\n"; 

	//--- Message au format Text
	$Texte = "This is a multi-part message in MIME format.\n"; 
	$Texte .= "Ceci est un message est au format MIME.\n"; 
	$Texte .= "------=".$Codage."\n"; 
	$Texte .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n"; 
	$Texte .= "Content-Transfer-Encoding: 8bit\n\n"; 
	$Texte .= $messageText."\n\n"; 

	//--- Message au format HTML
	$HTML = "------=".$Codage."\n"; 
	$HTML .= "Content-Type: text/html; charset=\"UTF-8\"\n"; 
	$HTML .= "Content-Transfer-Encoding: 8bit\n\n"; 
	$HTML .= $messageHtml."\n\n\n------=".$Codage."\n";

	$result = mail($to, $subject, $Texte.$HTML, $Entete); 

	if ($result) {
		return (true);
	} else {
		return (false);
	}
}

function getIdent_front($pTreeDepth){
  $identString = "&nbsp;";
  
  for ($i=0;$i<$pTreeDepth;$i++) {
  	$identString .= $identString;			  
  }

  $identString .= "<img src='../images/puce3.gif' alt='' class='puce23' />&nbsp;";
  
  return $identString;	
}
function getIdent($pTreeDepth){
  $identString = "&nbsp;";
  
  for ($i=0;$i<$pTreeDepth;$i++) {
  	$identString .= $identString;			  
  }

  $identString .= "&raquo;&nbsp;";
  
  return $identString;	
}
function getIdentAjax($pTreeDepth){
  $identString = "-";
  //$identString = " ";
  
  for ($i=0;$i<$pTreeDepth;$i++) {
  	$identString .= $identString;			  
  }

  $identString .= "� ";
  
  return $identString;	
}
//-------------------------------
// Verify user's security level and redirect to login page if needed
//-------------------------------
function check_security()
{
    global $pWindow;
    $currentPage = getPageURL();
	$currentURL = $_SERVER['PHP_SELF'];
	$adminString = "/admin/";
	if (strpos($currentURL, $adminString) === FALSE){
		$redirectPage = "../apps/login.php";
	} else {
		$redirectPage = "../apps/login.php";
	}
	$allAuthorizedPages = constructList_AuthorizedPages();
	if (!strlen(get_session("capid_user"))) {
		header("Location: ".$redirectPage."");
		exit;
	}
	if (strpos($allAuthorizedPages, $currentPage) === FALSE and $pWindow == "main") {
		header("Location: ../apps/404.php");
		exit;
	} elseif (strpos($allAuthorizedPages, $currentPage) === FALSE and $pWindow == "popup") {
		header("Location: ../apps/404.html");
		exit;
	}
}


function check_security_front() {
	if (!strlen(get_session("up_id_userFront")) && !strlen(get_session("abb_id_userFront"))) {
		header("Location: ../index.php");
		exit;
	} 
}

function check_secure()
{
	if (!strlen(get_session("UserID_cap"))) {
		header("Location: ../inscription/identification.php");
		exit;
	}
}

//**********************************************************************************************************/
function getPageURL() {

	$fullCurrentURL = $_SERVER['PHP_SELF'];
	$tabURL = explode("/",$fullCurrentURL);
	$tab_size = sizeof($tabURL);
	$cell = $tab_size - 1;
	return $tabURL[$cell];

}


function constructList_AuthorizedPages() {

  global $db;

  $db2 = new DB_Sql();
  $db2->Database = DATABASE_NAME;
  $db2->User     = DATABASE_USER;
  $db2->Password = DATABASE_PASSWORD;
  $db2->Host     = DATABASE_HOST;  
  
  $aliasString = "";

  $sSQL_getFunctions = "SELECT id, titre, page_alias FROM sys_fonctions WHERE sys_fonctions.id <> 1";
  $db2->query($sSQL_getFunctions);
  $next_record = $db2->next_record();

  while($next_record)
  {
		$fldidfunction = $db2->f("id");
		$fldTitle = $db2->f("titre");
		$fldAlias = $db2->f("page_alias");
		
		$next_record = $db2->next_record();

        $sSQL_getRoleFunction = "SELECT";		
		$sSQL_getRoleFunction .= " sys_fonctions_role.consultation as rf_consultation,";
		$sSQL_getRoleFunction .= " sys_fonctions_role.insertion as rf_insertion,";
		$sSQL_getRoleFunction .= " sys_fonctions_role.edition as rf_edition,";
		$sSQL_getRoleFunction .= " sys_fonctions_role.suppression as rf_suppression,";
		$sSQL_getRoleFunction .= " sys_fonctions_role.personnalisation as rf_personnalisation";
		$sSQL_getRoleFunction .= " FROM sys_fonctions_role";
		$sSQL_getRoleFunction .= " WHERE sys_fonctions_role.ref_role =".tosql(get_session("ref_role"), "Number"). " AND";
		$sSQL_getRoleFunction .= " sys_fonctions_role.ref_fonction =".tosql($fldidfunction, "Number");

		$db->query($sSQL_getRoleFunction);
		$next_record_rFn = $db->next_record();

		while($next_record_rFn)
		{
		
			$fldIsViewable = $db->f("rf_consultation");
			$fldIsAddable = $db->f("rf_insertion");
			$fldIsChangeable = $db->f("rf_edition");
			$fldIsDeleteable = $db->f("rf_suppression");
			$fldIsPersonnelized = $db->f("rf_personnalisation");
			
			$next_record_rFn = $db->next_record();
			
			if($fldIsViewable == 1)
				$aliasString .= "list".$fldAlias.".php".";";
			
			if($fldIsAddable == 1) 
				$aliasString .= "insert".$fldAlias.".php".";";
			
			if($fldIsChangeable == 1) 
				$aliasString .= "edit".$fldAlias.".php".";";
			
			if($fldIsDeleteable == 1) 
				$aliasString .= "delete".$fldAlias.".php".";";
			
			if($fldIsPersonnelized == 1){
				$aliasString .= $fldAlias.".php".";";
				if ($fldAlias == 'fonction'){
					$aliasString .= "role".$fldAlias.".php".";";
				}
			}
		}
  }
  
  return $aliasString;
}

/*=====================================*/
function mon_rplc_callback($capture){ 
/*=====================================*/
  global $arg; 
  return ($arg['flag'] == 1)  
  ? $arg['fct']($arg['de'], $arg['par'], $capture[1]).$capture[2] 
  : $capture[1].$arg['fct']($arg['de'], $arg['par'], $capture[2]);  
} 

/*=====================================*/
function split_balise($de, $par, $txt, $fct, $flag = 1){ 
/*=====================================*/
  global $arg; 
  $arg = compact('de', 'par', 'fct', 'flag'); 
  return preg_replace_callback('#((?:(?!<[/a-z]).)*)([^>]*>|$)#si', "mon_rplc_callback", $txt);  
} 


/** plus besoin pour le moment **/
/**
function searchHTML($page, $key) {	
$result = 0;
	if ($fp = fopen("../library/upload/documents/".$page, 'r'))  {
		while ($line = fread($fp, 1024)) {
			if(strpos($line, $key) != FALSE){
				return $result; 
			} else {
				return $result;	
			}	
		}
	} 
}
*/

function getRSS($slang) {
	$xml = "";
	$xmlHeader = "";
	$fullrss = "";
	global $db;
	
		//*** Actualit�s
		$sSQL = "select id, titre, description, date_maj, date_publication from cnt_actualite where est_actif = 1 and ref_langue=".tosql($slang, "Text") . " Order by date_maj";
		$db->query($sSQL);
		$next_record = $db->next_record();
		while($next_record) {
			$fldid = $db->f("id");
			$fldtitre = $db->f("titre");
			$flddescription = $db->f("description");
			$flddate_maj = $db->f("date_maj");
			$flddate_publication = $db->f("date_publication");
			
			$mois_fr = Array("", "janvier", "f�vrier", "mars", "avril", "mai", "juin", "juillet", "ao�t", "septembre", "octobre", "novembre", "d�cembre");
			list($annee, $mois, $jour) = explode('-', $flddate_publication);
			$flddate_publication = $jour.' '.$mois_fr[intval($mois)].' '.$annee; 
			
			$xml .= "<item>";
			$xml .= "<title>".$fldtitre."</title>";
			$xml .= "<link>http://". $_SERVER['HTTP_HOST'] ."/onmp/actualites/actualite.php?lang=".$slang."&id=".$fldid."</link>";
			$xml .= "<guid>http://". $_SERVER['HTTP_HOST'] ."/onmp/actualites/actualite.php?lang=".$slang."&id=".$fldid."</guid>";
			$xml .= "<pubDate>".$flddate_maj."</pubDate>"; 
			$xml .= "<description><![CDATA[".$flddescription." <br> Publier le : ".$flddate_publication."]]></description>";
			$xml .= "<category>Actualit�s</category>";
			$xml .= "</item>";	
			$next_record = $db->next_record();
		}
	
		//*** Appels d'offre
		$sSQL = "select id, objet_".$slang.", ref_type, date_maj, date_publication from ap_appeldoffre where ref_etat=4 Order by date_maj";
		$db->query($sSQL);
		$next_record = $db->next_record();
		while($next_record) {
			$fldid = $db->f("id");
			$fldobjet = $db->f("objet_".$slang."");
			$flddate_maj = $db->f("date_maj");
			$fldtype = $db->f("ref_type");
			$flddate_publication = $db->f("date_publication");
			
			$mois_fr = Array("", "janvier", "f�vrier", "mars", "avril", "mai", "juin", "juillet", "ao�t", "septembre", "octobre", "novembre", "d�cembre");
			list($annee, $mois, $jour) = explode('-', $flddate_publication);
			$flddate_publication = $jour.' '.$mois_fr[intval($mois)].' '.$annee; 
			
			$value_type = get_db_value("SELECT description_".$slang." from ap_type WHERE id=".tosql($fldtype, "Number"));
			
			$xml .= "<item>";
			$xml .= "<title>Appel d'Offre ".$value_type."</title>";
			$xml .= "<link>http://". $_SERVER['HTTP_HOST'] ."/onmp/appeldoffre/viewappeldoffrefront.php?lang=".$slang."&ID_appeldoffre=".$fldid."</link>";
			$xml .= "<guid>http://". $_SERVER['HTTP_HOST'] ."/onmp/appeldoffre/viewappeldoffrefront.php?lang=".$slang."&ID_appeldoffre=".$fldid."</guid>";
			$xml .= "<pubDate>".$flddate_maj."</pubDate>"; 
			$xml .= "<description><![CDATA[".$fldobjet." <br> Publier le : ".$flddate_publication."]]></description>";
			$xml .= "<category>Appel d'offres</category>";
			$xml .= "</item>";	
			$next_record = $db->next_record();
		}

		//*** R�glementations
		$db2 = new DB_Sql();
		$db2->Database = DATABASE_NAME;
		$db2->User     = DATABASE_USER; 
		$db2->Password = DATABASE_PASSWORD;
		$db2->Host     = DATABASE_HOST;
	
		$sSQL = "select id, titre from cnt_doc_categorie where (ref_parent=2 or ref_parent=13 or ref_parent=18) and ref_langue=".tosql($slang, "Text");
		$db2->query($sSQL);
		$next_record2 = $db2->next_record();
		while($next_record2) {
			$fldidcat = $db2->f("id");
			$fldtitrecat = $db2->f("titre");
				
				$sSQL = "select id, titre, description, date_publication, date_maj from cnt_document where ref_categorie=".tosql($fldidcat, "Number")." and est_actif=1 Order by date_maj";
				
				$db->query($sSQL);
				$next_record = $db->next_record();
				while($next_record) {
					$fldid = $db->f("id");
					$fldtitre = $db->f("titre");
					$flddescription = $db->f("description");
					$flddate_maj = $db->f("date_maj");
					$flddate_publication = $db->f("date_publication");
					
					$mois_fr = Array("", "janvier", "f�vrier", "mars", "avril", "mai", "juin", "juillet", "ao�t", "septembre", "octobre", "novembre", "d�cembre");
					list($annee, $mois, $jour) = explode('-', $flddate_publication);
					$flddate_publication = $jour.' '.$mois_fr[intval($mois)].' '.$annee; 
					
					$xml .= "<item>";
					$xml .= "<title>".$fldtitre."</title>";
					$xml .= "<link>http://". $_SERVER['HTTP_HOST'] ."/onmp/documents/document.php?lang=".$slang."&id=".$fldid."</link>";
					$xml .= "<guid>http://". $_SERVER['HTTP_HOST'] ."/onmp/documents/document.php?lang=".$slang."&id=".$fldid."</guid>";
					$xml .= "<pubDate>".$flddate_maj."</pubDate>"; 
					$xml .= "<description><![CDATA[".$flddescription." <br> Publier le : ".$flddate_publication."]]></description>";
					$xml .= "<category>".$fldtitrecat."</category>";
					$xml .= "</item>";	
					$next_record = $db->next_record();
				}

				$next_record2 = $db2->next_record();
		
	}	

	$xml .= "</channel>";
	$xml .= "</rss>";
	$xml = formatHTMLCode($xml);
	
	if($slang == "fr")	{
		$xmlHeader = "<?xml version='1.0' encoding='UTF-8'?><rss version='2.0'>";
		$xmlHeader .= "<channel>"; 
		$xmlHeader .= "<title>ONMP</title>";
		$xmlHeader .= "<link>http://www.onmp.com</link>";
		$xmlHeader .= "<description>Flux RSS du l'Observatoire National des March�s Publics</description>";
		$fullrss = $xmlHeader.$xml;
		$fp = fopen($_SERVER['DOCUMENT_ROOT']."/onmp/rss/rss-fr.xml", 'w+');
		fputs($fp, $fullrss);
		fclose($fp);
	}	
	if($slang == "en") {	
		$xmlHeader = "<?xml version='1.0' encoding='UTF-8'?><rss version='2.0'>";
		$xmlHeader .= "<channel>"; 
		$xmlHeader .= "<title>ONMP</title>";
		$xmlHeader .= "<link>http://www.onmp.com</link>";
		$xmlHeader .= "<description>Flux RSS du l'Observatoire National des March�s Publics</description>";
		$fullrss = $xmlHeader.$xml;
		$fp = fopen($_SERVER['DOCUMENT_ROOT']."/onmp/rss/rss-en.xml", 'w+');
		fputs($fp, $fullrss);
		fclose($fp);
	}	
	if($slang == "ar") {	
		$xmlHeader = "<?xml version='1.0' encoding='UTF-8'?><rss version='2.0'>";
		$xmlHeader .= "<channel>"; 
		$xmlHeader .= "<language>ar</language>"; 
		$xmlHeader .= "<title>ONMP</title>";
		$xmlHeader .= "<link>http://www.onmp.com</link>";
		$xmlHeader .= "<description>Flux RSS du l'Observatoire National des March�s Publics</description>";
		$fullrss = $xmlHeader.$xml;
		$fp = fopen($_SERVER['DOCUMENT_ROOT']."/onmp/rss/rss-ar.xml", 'w+');
		fputs($fp, $fullrss);
		fclose($fp);
	}	
	
}

function formatHTMLCode($strXmlFile) {	
	$strXmlFile = str_replace( "&", "&amp;",$strXmlFile);
 	return $strXmlFile;
}



/*$isOnline = get_db_value("select id_session from sys_audience where id_session=".tosql(session_id(), "Text"));
if(strlen($isOnline)) {
	//$tps_max_connex = 180;  
	$temps_actuel = date("U");
	$sSQL_update = "UPDATE sys_audience SET time = ".$temps_actuel." WHERE id_session = ".tosql(session_id(), "Text"); 	
	$db->query($sSQL_update);
} else {
	$temps_actuel = date("U");	
	$sSQL_Internauteonline = "INSERT INTO sys_audience (id_session, time)";
	$sSQL_Internauteonline .= " VALUES('".session_id()."', ".$temps_actuel.")"; 
	$db->query($sSQL_Internauteonline);
}
*/



function getTheme($lang){
	global $tpl;
	global $db;
	
	if(strlen($lang)) {
		$sSQL_Langue = "SELECT id from cnt_theme WHERE ref_langue =" .tosql($lang, "Number"). " AND logical_parent_path=';;'";
		$idRootArticle = get_db_value($sSQL_Langue);
	}
	
	generateThemeXML($idRootArticle);

}



//-------------------------------//
function generateThemeXML($idTheme) {
//-------------------------------//

	global $db;
	global $treeThemeXML; 
		
	$sSQL_GetROOT = "SELECT c.id as c_id, "; 
	$sSQL_GetROOT .= "c.titre as c_titre ";
	$sSQL_GetROOT .= "FROM cnt_theme c ";
	$sSQL_GetROOT .= "WHERE c.est_actif = 1 AND c.id =" .tosql($idTheme, "Number");

	$db->query($sSQL_GetROOT);
	$next_record = $db->next_record();

	$idRootTheme = $db->f("c_id");
	$titreRootTheme = $db->f("c_titre");

	$treeThemeXML .= "<item text='".$titreRootTheme."' id='".$idRootTheme."' open='1' im0='tombs.gif' im1='tombs.gif' im2='iconSafe.gif'>";
	
	$sSQL = "SELECT c.id as c_id, "; 
	$sSQL .= "c.titre as c_titre ";
	$sSQL .= " FROM cnt_theme c ";
	$sSQL .= " WHERE c.ref_parent =".tosql($idRootTheme, "Number")." AND c.est_actif = 1";

	$db->query($sSQL);
	$next_record = $db->next_record();

	while($next_record) {
		$fldid = $db->f("c_id");
		$fldtitre = $db->f("c_titre");

		$treeThemeXML .= "<item text='".$fldtitre."' id='".$fldid."' open='1' im0='tombs.gif' im1='tombs.gif' im2='iconSafe.gif'>";
		
		/**
		* Get Article Child 
		**/
		$db2 = new DB_Sql();
		$db2->Database = DATABASE_NAME;
		$db2->User     = DATABASE_USER;
		$db2->Password = DATABASE_PASSWORD;
		$db2->Host     = DATABASE_HOST;
		
		$sSQL_GetChild = "SELECT id FROM cnt_theme WHERE ref_parent =".$fldid . " order by ordre";
		$db2->query($sSQL_GetChild);
		$next_record = $db2->next_record();
		while($next_record) {
			$fldidChild = $db2->f("id");
			generateThemeXML($fldidChild); 
			$next_record = $db2->next_record();
			$treeThemeXML .= "</item>";
		}
		/**/
		
		$treeThemeXML .= "</item>";
		$next_record = $db->next_record();
	}
		
}
?>
