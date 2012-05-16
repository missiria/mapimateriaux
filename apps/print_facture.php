<?php
      include ("header.php");
      $pWindow = "print_facture";
      $filename = "print_facture.php";
      $template_filename = "print_facture.html";

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "print_facture");

      
      $id=get_param("id");
      $send=get_param("send");
      
      $db->query("SELECT * FROM  commandes WHERE id=".tosql($id, "NUMBER"));
	  $next_record = $db->next_record();
	  while($next_record){
		$date=$db->f("date");
		$client=$db->f("ref_client");
		$qt_produit=$db->f("qt_produit");
		$qt_liv=$db->f("qt_liv");
		$tel=$db->f("telClient");
		$prix_uni = $db->f("prix_uni");
		$time=$db->f("time_depart");
		$adresse=$db->f("adresse_derniere_liv");
		
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
		$ref_vehicule = dlookup("vehicules", "libelle", "id=".tosql($db->f("ref_vehicule"), "NUMBER"));
		$produits = dlookup("produits", "libelle", "id=".tosql($db->f("ref_produit"), "NUMBER"));
		$libref = dlookup("produits", "libelle", "id=".tosql($db->f("ref_reference"), "NUMBER"));
		$raison_social = dlookup("clients", "raison_social", "id=".tosql($db->f("ref_client"), "NUMBER"));
		$next_record = $db->next_record();
        }
        
        $prix = $qt_liv * $prix_uni;
        $tpl->set_var("montant",$prix);
        $tpl->set_var("prix_uni",$prix_uni);
        $tva = $prix * 20/100;
        $ttc = $prix + $tva;
        
        //var_dump($_GET);
        
		$qt_liv = $_GET["qt_liv"];
		
        $tpl->set_var("id",$id);
        $tpl->set_var("date",$date);
        $tpl->set_var("client",$raison_social);
        $tpl->set_var("qt_liv",$qt_liv);
        $tpl->set_var("tva",$tva);
        $tpl->set_var("ttc",$ttc);
        $tpl->set_var("libreferences",$libref);
        $tpl->set_var("libproduits",$produits);
      
      if ($send) {
        global $db;
        
        $date = date("Y-m-d");
        
        //echo "<h1>tessssssssst : $libref </h1>";
	      
	      $num_commande_existe = dlookup("fact_save", "count(*)", "num_commande=".tosql($id, "NUMBER"));

	      if ($num_commande_existe > 0) {
	            echo "<script>alert('Vous essayer de soldé un bon commande $id qui éxiste déja !!!')</script>";
	      } else {
	            $sSQL = "INSERT INTO fact_save (" . 
                        "clients," .
                        "produit," .
                        "reference," . 
                        "num_commande," .
                        "date_save,". 
                        "qt_produit," . 
                        "qt_liv," .
                        "prix_uni," . 
                        "montant," . 
                        "tva," .
                        "ttc)" .
                  " VALUES (" . 
                        tosql($raison_social, "Text") . "," .
                        tosql($produits, "Text") . "," .
                        tosql($libref, "Text") . "," .
                        tosql($id, "Number") . "," .
                        tosql($date, "Text") . "," .
                        tosql($qt_produit, "Number") . "," .
                        tosql($qt_liv, "Number") . "," .
                        tosql($prix_uni, "Number") . "," .
                        tosql($prix, "Number") . "," .
                        tosql($tva, "Number") . "," .
                        tosql($ttc, "Number") . 
                  ")";       	
                  $db->query($sSQL);
                  echo '<script>alert("Vous avez soldé le bon numéro : '. $id .'")</script>';
                  
	      }
            
	}
      
      $tpl->pparse("print_facture", false);   

?>
