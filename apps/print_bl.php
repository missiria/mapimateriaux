<?php
      include ("header.php");
      $pWindow = "print_bl";
      $filename = "print_bl.php";
      $template_filename = "print_bl.html";

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "print_bl");
      
      $id=get_param("id");
	  
	  $db->query("SELECT * FROM  commandes WHERE id=".tosql($id, "NUMBER"));
	  $next_record = $db->next_record();
	  
	  while($next_record){
		$date=$db->f("date");
		$client=$db->f("ref_client");
		$qt_produit=$db->f("qt_produit");
		$ref_reference=$db->f("ref_reference");
		$prix_uni=$db->f("prix_uni");
		$qt_liv=$db->f("qt_liv");
		$tel=$db->f("telClient");
		$time=$db->f("time_depart");
		$facturation = $db->f('facturation');
		$observation = $db->f('observation');
		$adresse=$db->f("adresse_derniere_liv");
		$ref_vehicule=$db->f("ref_vehicule");
		
		$db2->query("SELECT qt_operation 
					FROM operation_produit 
					WHERE ref_commande = " .tosql($db->f("id"), "NUMBER"));
		$next_record2 = $db2->next_record();
		$somRslt = 0;
		while($next_record2){
			$somRslt += abs($db2->f("qt_operation"));
			$qt_liv = abs($db2->f("qt_operation"));
			$next_record2 = $db2->next_record();
		}

	$client = dlookup("clients", "nom_resp", "id=".tosql($db->f("ref_client"), "NUMBER")); 
	$telClient = dlookup("clients", "tel", "id=".tosql($db->f("ref_client"), "NUMBER"));
	$ref_reference = dlookup("produits", "libelle", "id=".tosql($db->f("ref_reference"), "NUMBER"));
	$produit = dlookup("produits", "libelle", "id=".tosql($db->f("ref_produit"), "NUMBER"));
	$next_record = $db->next_record();
	
	}
		$montant = $qt_liv * $prix_uni;
		
        $tpl->set_var("id",$id);
        $tpl->set_var("date",$date);
        $tpl->set_var("client",$client);
        $tpl->set_var("qt_produit",$qt_produit);
        $tpl->set_var("qt_liv",$qt_liv);
        $tpl->set_var("prix_uni",$prix_uni);
        $tpl->set_var("montant",$montant);
        $qt_RestGlob = $qt_produit - $somRslt;
        $tpl->set_var("qt_reste",$qt_RestGlob);
        $tpl->set_var("time_depart",$time);
        $tpl->set_var("ref_vehicule",$ref_vehicule);
        $tpl->set_var("telClient",$telClient);
        $tpl->set_var("adresse",$adresse);
        $tpl->set_var("observation",$observation);
	$tpl->set_var("ref_reference",$ref_reference);
	$tpl->set_var("produit",$produit);
        
        if ($facturation == 0) {
                $tpl->set_var("print","print_black");
                $tpl->set_var("titre","Bon livraison :");
                $tpl->set_var("style","black_style");
                $tpl->set_var("Signature","Signature :");
        } else {
                $tpl->set_var("print","print");
                $tpl->parse("_Black", false);
                $tpl->set_var("_Black","");
                $tpl->set_var("style","bo_style");
                $tpl->parse("Black2", false);
                $tpl->set_var("Black2","");
        }
      /*
      echo "<pre>";
      var_dump($facturation);
      echo "</pre>";
      */
      
      $tpl->pparse("print_bl", false);   

?>
