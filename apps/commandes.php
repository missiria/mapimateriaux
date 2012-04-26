<?php
	include ("header.php");
	$pWindow = "commandes";
	$filename = "commandes.php";
	$template_filename = "commandes.html";

	$tpl = new Template($app_path);
	$tpl->load_file($template_filename, "commandes");

	$tpl->load_file("../apps/footer.html", "Footer");

	$sheader = $tplheader->return_var("Header");
	$tpl->set_var("Header",$sheader);
	$tpl->parse("Footer", false);

	$tpl->set_var("FileName", $filename);

	$lookup_clients = db_fill_array("SELECT id, raison_social FROM  clients");
	  
	if(is_array($lookup_clients)) {
	reset($lookup_clients);
		while(list($value, $key) = each($lookup_clients)) {
		  $tpl->set_var("Value_client", $key );
		  $tpl->set_var("id_client", $value);
		  $tpl->parse("select_clients", true);
		}
	}

	$lookup_produits = db_fill_array("SELECT id, libelle FROM  produits where ref_parent IS NULL and type_produit = 2");

	if(is_array($lookup_produits)) {
	// reset($lookup_produits);
		while(list($value, $key) = each($lookup_produits)) {
		  $tpl->set_var("Value_produit", $key );
		  $tpl->set_var("id_produit", $value);
		  $tpl->parse("select_produits", true);
		}
	}
	$tpl->parse("formAction", false);          

	// $_POST TRAITEMENT
	$date = get_param('date');
	$ref_client = get_param("ref_client");
	$ref_produit = get_param("ref_produit");
	$ref_reference = get_param("ref_reference");
	$qt_produit = get_param("qt_produit");
	$prix_uni = get_param("prix_uni");
	$facturation = get_param("facturation");
	$id = $_POST["id"];
	
	//var_dump($_POST);

	if ($date && $ref_client && $ref_produit && $ref_reference && $qt_produit && $prix_uni && !$id) {
				
		$sSQL = "INSERT INTO commandes (" . 
			"date," . 
			"ref_client," . 
			"ref_produit," . 
			"ref_reference," . 
			"qt_produit," . 
			"facturation," . 
			"prix_uni)" .
		" VALUES (" . 
			tosql($date, "Text") . "," .
			tosql($ref_client, "Number") . "," .
			tosql($ref_produit, "Number") . "," .
			tosql($ref_reference, "Number") . "," .
			tosql($qt_produit, "Number") . "," .
			tosql($facturation, "Number") . "," .
			tosql($prix_uni, "text") . 
		")";          	
		$db->query($sSQL);
		echo '<script>alert("Vous avez saisie : '. $qt_produit .'")</script>';
		header("location: traitement_commandes.php");
	} else if ($date && $ref_client && $ref_produit && $qt_produit && $prix_uni && $facturation && $id)  {
			$sSQL = "UPDATE commandes SET "; 
			$sSQL .="date =" . tosql($date, "Text");
			$sSQL .=",ref_client =" . tosql($ref_client, "Number");
			$sSQL .=",ref_produit =" . tosql($ref_produit, "Number");
			$sSQL .= ",qt_produit =". tosql($km_depart, "Number");
			$sSQL .= ",facturation =". tosql($facturation, "Number");
			$sSQL .= ",prix_uni =". tosql($prix_uni, "text");
			$sSQL .= " where id=" .tosql($id, "Number") ."";        	
	$db->query($sSQL);
	echo '<script>alert("Vous avez mis à le bon numéro : '. $id .'")</script>';
	}
	search();
	//==============================
	function search() {
	//==============================
	global $db;
	global $tpl;
	global $sForm;
	$sActionFileName = "commandes.php";
	$tpl->set_var("ActionPage", $sActionFileName);
	$keyword = strip(get_param("keyword"));
	$tpl->set_var("keyword", tohtml($keyword));

	$sSQL = "SELECT * FROM commandes WHERE etat_commande=0 ";			
	if (strlen(trim($keyword)) > 0)
	$sSQL .= "AND WHERE id LIKE '$keyword'";

	$db->query($sSQL);
	$next_record = $db->next_record();

	$i = 1;                          
	while($next_record){ 
	//WE DISPLAY THE RESULTS
	$id = $db->f("id");
	$date = $db->f("date");
	$etat_commande = $db->f("etat_commande");
	$prix_uni = $db->f("prix_uni");
	$qt_produit = $db->f("qt_produit");
	$ref_client = dlookup("clients", "nom_resp", "id=".tosql($db->f("ref_client"), "NUMBER")); 
	$ref_produit = dlookup("produits", "libelle", "id=".tosql($db->f("ref_produit"), "NUMBER"));
	$ref_reference = dlookup("produits", "libelle", "id=".tosql($db->f("ref_reference"), "NUMBER"));

	$next_record = $db->next_record();

	$tpl->set_var("id",$id);
	$tpl->set_var("date",$date);
	if ($etat_commande == 1){
	$tpl->set_var("etat_commande","Cloturé");
	} else if ($etat_commande == 0){
	$tpl->set_var("etat_commande","En cours");
	}

	$tpl->set_var("prix_uni",$prix_uni);
	$tpl->set_var("qt_produit",$qt_produit);
	$tpl->set_var("ref_produit",$ref_produit);
	$tpl->set_var("ref_reference",$ref_reference);
	$tpl->set_var("ref_client",$ref_client);
	$tpl->set_var("ordrRow",$i);

	$tpl->parse("row_result", true);
	$i++;
	}
	if ($i == 1){
			$tpl->parse("Norow_result",false);
			$tpl->set_var("row_result","");
	} else {
	$tpl->set_var("Norow_result","");
	}
	$tpl->parse("block_search", false); 		
	}
	delete();
	function delete() {
	  $delete = get_param('delete');
	  if ($delete) {
			$sql = sprintf("DELETE FROM commandes WHERE id = '".$delete."'");
			$result = mysql_query($sql);    
			header("location: commandes.php");
	  }			
	}

	$tpl->pparse("commandes", false);      

?>
