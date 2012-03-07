<?php
header('Content-Type: text/html; charset=UTF-8'); 
include ("../common.php");
session_start();

$pGamme = get_param("Gamme");

	
$sSQL = "SELECT ID,Nom FROM view_produithome where Abreviation = 'TN' and EstActif = 1 and CodeLangue =".tosql($lang, "Text")." and IDCat=".$pGamme." order by 2";


$db->query($sSQL);
$next_record = $db->next_record();

while($next_record)
{
	$fldNom = $db->f("Nom");
	$fldid = $db->f("ID"); 
	$fldtitre = $fldNom;
	echo "obj.options[obj.options.length] = new Option('".$fldtitre."','".$fldid."');\n";
	$next_record = $db->next_record();
}
?> 