<?php
      include ("header.php");
      $pWindow = "facture";
      $filename = "facture.php";
      $template_filename = "facture.html";

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "facture");

      $tpl->load_file("../apps/footer.html", "Footer");

      $sheader = $tplheader->return_var("Header");
      $tpl->set_var("Header",$sheader);
      $tpl->parse("Footer", false);

      $tpl->set_var("FileName", $filename);
     
      global $db;
      global $tpl;
      global $sForm;
      $sSQL = "SELECT * FROM commandes WHERE facturation=1";			
      $db->query($sSQL);
      $next_record = $db->next_record();

	
      $i = 1;
      while($next_record){ 
      	//WE DISPLAY THE RESULTS
       	$id = $db->f("id");
       	$date = $db->f("date"); 
        $ref_client = $db->f("ref_client");
       	$qt_produit = $db->f("qt_produit");
       	$ref_produit = $db->f("ref_produit");
       	$prix_uni = $db->f("prix_uni");
       	
       	$qt_liv = get_param("qt_liv");
       	
       	$libclients = dlookup("clients", "nom_resp", "id=".tosql($db->f("ref_client"), "NUMBER")); 
       	$libproduits = dlookup("produits", "libelle", "id=".tosql($db->f("ref_produit"), "NUMBER")); 
       	$libreferences = dlookup("produits", "ref", "id=".tosql($db->f("ref_produit"), "NUMBER")); 
       	
       	$next_record = $db->next_record();
       	$tpl->set_var("id",$id);
       	$tpl->set_var("date",$date);
	$tpl->set_var("ref_client",$libclients);
	
	$tpl->set_var("qt_liv",$qt_liv);
	
	// WE CALCUL THE TOTAL
	$prix = $qt_produit * $prix_uni;
	
	$tpl->set_var("montant",$prix);
	$tpl->set_var("prix_uni",$prix_uni);
	$tva = $prix * 20/100;
	$ttc = $prix + $tva;
	
	$tpl->set_var("tva",$tva);
	$tpl->set_var("ttc",$ttc);
	
	$tpl->set_var("qt_produit",$qt_produit);
	$tpl->set_var("libproduits",$libproduits);
	$tpl->set_var("libreferences",$libreferences);
	$tpl->set_var("consommation",$consommation);
	$tpl->set_var("ref_vehicule",$libVehicule);
	$tpl->set_var("date",$date);
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
   $tpl->pparse("facture", false);      

?>
