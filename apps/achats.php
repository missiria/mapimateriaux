<?php
	include ("header.php");
	$pWindow = "achats";
	$filename = "achats.php";
	$template_filename = "achats.html";

	$sAction = get_param("FormAction");
	$sForm = get_param("FormName");

	$tpl = new Template($app_path);
	$tpl->load_file($template_filename, "achats");

	$tpl->load_file("../apps/footer.html", "Footer");

	$sheader = $tplheader->return_var("Header");
	$tpl->set_var("Header",$sheader);
	$tpl->parse("Footer", false);

	$tpl->set_var("FileName", $filename);

	/* $lookup_produits = db_fill_array("SELECT libelle,id FROM  produits");

	if(is_array($lookup_produits)) {
	reset($lookup_produits);
		while(list($value, $key) = each($lookup_produits)) {
		  $tpl->set_var("Value_produit", $value);
		  $tpl->set_var("id_produit", $key);
		  $tpl->parse("select_produit", true);
		}
	} */

	$lookup_fournisseurs = db_fill_array("SELECT nom_resp,id FROM  fournisseurs");

	if(is_array($lookup_fournisseurs)) {
	reset($lookup_fournisseurs);
		while(list($value, $key) = each($lookup_fournisseurs)) {
		  $tpl->set_var("Value_fournisseur", $value);
		  $tpl->set_var("id_fournisseur", $key);
		  $tpl->parse("select_fournisseur", true);
		}
	}

	$lookup_produits = db_fill_array("SELECT id, libelle 
					FROM produits 
					WHERE type_produit=1");
	if(is_array($lookup_produits)) {
	reset($lookup_produits);
		while(list($value, $key) = each($lookup_produits)) {
		  $tpl->set_var("Value_produit", $key);
		  $tpl->set_var("id_produit", $value);
		  $tpl->parse("select_produit", true);
		}
	}

	// $_POST TRAITEMENT
	$num_facture_achat = get_param('num_facture_achat');
	$date_regelement = get_param('date_regelement');
	$ref_fournisseur = get_param("ref_fournisseur");
	$montant_achat = get_param("montant_achat");
	$ref_produit = get_param("ref_produit");
	$qt_prod = get_param("qt_prod");

	$etat_reglement = get_param("etat_reglement");

	$mode_reglement = get_param("mode_reglement");
	$ref_bank = get_param("ref_bank");
	$id = $_POST["id"];

		if ($num_facture_achat && $date_regelement && $ref_fournisseur && $etat_reglement ) {
            if (!$id){
                $sSQL = "INSERT INTO achats (" . 
		        "num_facture_achat," .
		        "date_regelement," .
		        "ref_fournisseur," . 
		        "montant_achat," . 
		        "etat_reglement," .
		        "mode_reglement," . 
		        "ref_produit," . 
		        "qt_prod," . 
		        "ref_bank)" .
				" VALUES (" . 
		        tosql($num_facture_achat, "Number") . "," .
		        tosql($date_regelement, "Text") . "," .
		        tosql($ref_fournisseur, "Number") . "," .
		        tosql($montant_achat, "Number") . "," .
		        tosql($etat_reglement, "Text") . "," . 
		        tosql($mode_reglement, "Text") . "," .
		        tosql($ref_produit, "Number") . "," .
		        tosql($qt_prod, "Number") . "," .
		        tosql($ref_bank, "Text") .
				")";  
				$db->query($sSQL);
				$lastId = mysql_insert_id();
				$sql = "INSERT INTO operation_produit (ref_produit, ref_achat, qt_operation, ref_user) values (";
				$sql .= tosql($ref_produit, "NUMBER") . ", ";
				$sql .= tosql($lastId, "NUMBER") . ", ";
				$sql .= tosql($qt_prod, "NUMBER") . ", ";
				$sql .= "1)";
				$db->query($sql);
				$lastIdOperation = mysql_insert_id();
				$db->query("update achats set ligne_operation_prod = " . tosql($lastIdOperation,"NUMBER"). " Where id = " . tosql($lastId,"NUMBER"));
				echo '<script>alert("Vous avez saisie le bon numéro : '. $num_facture_achat .'")</script>';
                	
            } else if ($id) {
				$ligne_operation_prod = dlookup("achats","ligne_operation_prod","id=".tosql($id, "NUMBER"));
               	$sSQL = "UPDATE achats SET "; 
				$sSQL .= "num_facture_achat = " . tosql($num_facture_achat, "Number");
				$sSQL .= ",date_regelement =" . tosql($date_regelement, "Text");
				$sSQL .= ",ref_produit =" . tosql($ref_produit, "Text");
				$sSQL .= ",qt_prod =" . tosql($qt_prod, "NUMBER");
				$sSQL .= ",ref_fournisseur = " .  tosql($ref_fournisseur, "Number");
				$sSQL .= ",montant_achat =" . tosql($montant_achat, "Number");
				$sSQL .= ",etat_reglement =" . tosql($etat_reglement, "Text");
				$sSQL .= ",mode_reglement =" . tosql($mode_reglement, "Text");
				$sSQL .= ",ref_bank =" . tosql($ref_bank, "Text");
				$sSQL .= " WHERE id=" .tosql($id, "Number") ."";        	
            	$db->query($sSQL);
            	$db->query("update operation_produit set ref_produit = " . tosql($ref_produit, "Text") . ", ref_achat = " .tosql($id, "Text"). ",qt_operation = " .tosql($qt_prod, "NUMBER"). " where id = " . tosql($ligne_operation_prod,"NUMBER"));
            	echo '<script>alert("Vous avez mis à le bon numéro : '. $num_facture_achat .'")</script>';
            }
        } else if ($num_facture_achat && $date_regelement && $ref_fournisseur && $etat_reglement ) {
            if (!$id){
				$sSQL = "INSERT INTO achats (" . 
                        "num_facture_achat," .
                        "date_regelement," .
                        "ref_fournisseur," . 
                        "montant_achat," . 
                        "ref_produit," . 
                        "qt_prod," . 
                        "etat_reglement)" .
						" VALUES (" . 
                        tosql($num_facture_achat, "Number") . "," .
                        tosql($date_regelement, "Text") . "," .
                        tosql($ref_fournisseur, "Number") . "," .
                        tosql($montant_achat, "Number") . "," .
                        tosql($ref_produit, "Number") . "," .
                        tosql($qt_prod, "NUMBER") . "," .
                        tosql($etat_reglement, "Text") .
						")";       	
                		$db->query($sSQL);
						$lastIdOperation = mysql_insert_id();
						$db->query("update achats set ligne_operation_prod = " . tosql($lastIdOperation,"NUMBER"). " Where id = " . tosql($lastId,"NUMBER"));
                		echo '<script>alert("Vous avez saisie le bon numéro : '. $num_facture_achat .'")</script>';
            } else {          	    	
				$ligne_operation_prod = dlookup("achats","ligne_operation_prod","id=".tosql($id, "NUMBER"));
        		$sSQL = "UPDATE achats SET "; 
				$sSQL .= "num_facture_achat = " . tosql($num_facture_achat, "Number");
				$sSQL .= ",date_regelement =" . tosql($date_regelement, "Text");
				$sSQL .= ",ref_produit =" . tosql($ref_produit, "Text");
				$sSQL .= ",qt_prod =" . tosql($qt_prod, "NUMBER");
				$sSQL .= ",ref_fournisseur = " .  tosql($ref_fournisseur, "Number");
				$sSQL .= ",montant_achat =" . tosql($montant_achat, "Number");
				$sSQL .= ",etat_reglement =" . tosql($etat_reglement, "Text");
				$sSQL .= " WHERE id=" .tosql($id, "Number") ."";        	
				$db->query($sSQL);
            	$db->query("update operation_produit set ref_produit = " . tosql($ref_produit, "Text") . ", ref_achat = " .tosql($id, "Text"). ",qt_operation = " .tosql($qt_prod, "NUMBER"). " where id = " . tosql($ligne_operation_prod,"NUMBER"));
				echo '<script>alert("Vous avez mis à le bon numéro : '. $num_bon .'")</script>';
            }
        }	 
            
            
	$tpl->parse("BlockForm", false);
    search();
    //==============================
    function search() {
      //==============================
		global $db;
		global $tpl;
		global $sForm;
		$sActionFileName = "achats.php";
		$tpl->set_var("ActionPage", $sActionFileName);
		$keyword = strip(get_param("keyword"));
		$tpl->set_var("keyword", tohtml($keyword));

			$sSQL = "SELECT * FROM  achats ";			
			if (strlen(trim($keyword)) > 0)
				$sSQL .= "WHERE num_facture_achat LIKE '$keyword%'";

			$db->query($sSQL);
			$next_record = $db->next_record();

		$i = 1;                          
		while($next_record){ 
		//WE DISPLAY THE RESULTS
		$id = $db->f("id");
		$num_facture_achat = $db->f("num_facture_achat"); 
		$date_regelement = $db->f("date_regelement"); 
		$qt_prod = $db->f("qt_prod"); 
		$montant_achat = $db->f("montant_achat");
		$etat_reglement = $db->f("etat_reglement");
		$mode_reglement = $db->f("mode_reglement");
		$ref_bank = $db->f("ref_bank");
		$ref_fournisseur = dlookup("fournisseurs", "nom_resp", "id=".tosql($db->f("ref_fournisseur"), "NUMBER")); 
		$ref_produit = dlookup("produits", "libelle", "id=".tosql($db->f("ref_produit"), "NUMBER")); 

		$next_record = $db->next_record();

		$tpl->set_var("id",$id);
		$tpl->set_var("date",$date);
		$tpl->set_var("num_facture_achat",$num_facture_achat);
		$tpl->set_var("date_regelement",$date_regelement);
		$tpl->set_var("ref_produit",$ref_produit);
		$tpl->set_var("qt_prod",$qt_prod);
		$tpl->set_var("ref_fournisseur",$ref_fournisseur);
		$tpl->set_var("montant_achat",$montant_achat);
		$tpl->set_var("etat_reglement",$etat_reglement);
		$tpl->set_var("mode_reglement",$mode_reglement);
		$tpl->set_var("ref_bank",$ref_bank);
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
	global $db;
		$delete = get_param('delete');
		//var_dump($_GET);
		if ($delete) {
			$ligne_operation_prod = dlookup("achats","ligne_operation_prod","id=".tosql($delete, "NUMBER"));
			$sql = sprintf("DELETE FROM achats WHERE id = '".$delete."'");
			$result = $db->query($sql);    
			$result = $db->query("delete from operation_produit where id = " . tosql($ligne_operation_prod, "NUMBER"));    
			header("location: achats.php");
		}			
	}   
      
	$tpl->pparse("achats", false);      

?>
