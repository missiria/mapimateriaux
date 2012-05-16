<?php
	include ("header.php");
	$pWindow = "journal_lb_voyage";
	$filename = "journal_lb_voyage.php";
	$template_filename = "journal_lb_voyage.html";

	$tpl = new Template($app_path);
	$tpl->load_file($template_filename, "journal_lb_voyage");

	$tpl->load_file("../apps/footer.html", "Footer");

	$sheader = $tplheader->return_var("Header");
	$tpl->set_var("Header",$sheader);
	$tpl->parse("Footer", false);

	$tpl->set_var("FileName", $filename);

	global $db;
	global $tpl;
	global $sForm;
	$sActionFileName = "journal_lb.php";
	$tpl->set_var("ActionPage", $sActionFileName);
	$id = $_GET["id"];
	$keyword = strip(get_param("keyword"));
	$tpl->set_var("keyword", tohtml($keyword));
	
	$from = strip(get_param("from"));
	$to = strip(get_param("to"));
	$tpl->set_var("from", tohtml($from));
	$tpl->set_var("to", tohtml($to));
				
	$sSQL = "SELECT commandes.id as bon_info, operation_produit.date_operation as date, clients.raison_social as client, produits.libelle as produit, operation_produit.qt_operation as qt_liv, commandes.adresse_derniere_liv as adresse, commandes.ref_vehicule as transporteur, commandes.qt_produit as  qt_commande, commandes.time_depart as heure_depart, pparent.libelle as reference ";
	$sSQL .= "FROM operation_produit ";
	$sSQL .= "LEFT JOIN commandes ON operation_produit.ref_commande = commandes.id ";
	$sSQL .= "INNER JOIN produits ON commandes.ref_produit = produits.id ";
	$sSQL .= "INNER JOIN produits AS pparent ON commandes.ref_reference = pparent.id ";
	$sSQL .= "INNER JOIN clients ON commandes.ref_client = clients.id";
	
	if ($from && $to)
	$sSQL .= " WHERE operation_produit.date_operation BETWEEN ".tosql($from, "TEXT")." AND ".tosql($to, "TEXT");
	if ($keyword)
	$sSQL .= " AND commandes.ref_client=".tosql($keyword, "TEXT");
	
		
	$sSQL .= " order by operation_produit.date_operation LIMIT 0 , 30";
	$db->query($sSQL);
	$next_record = $db->next_record();

    $i = 1;
    while($next_record){

      	//WE DISPLAY THE RESULTS
       	$bon_info = $db->f("bon_info");
       	$date = $db->f("date");
        $clients = $db->f("client");
       	$produit = $db->f("produit");
       	$ref = $db->f("reference");
       	$qt_commande = $db->f("qt_commande");
       	$qt_liv = $db->f("qt_liv");
       	$adresse = $db->f("adresse");
       	$transporteur = $db->f("transporteur");
       	$heure_depart = $db->f("heure_depart");
		
	// WE GET THE RELATION WITH THE OTHER FIELDS
       	$libclients = dlookup("clients", "nom_resp", "id=".tosql($db->f("ref_client"), "NUMBER"));

       	// WE RECORD THE SQL
       	$next_record = $db->next_record();

       	// SET A VARIABLE IN TEMPLATE
       	$tpl->set_var("id",$bon_info);
       	$tpl->set_var("date",$date);
	$tpl->set_var("clients",$clients);
	$tpl->set_var("produit",$produit);
	$tpl->set_var("ref",$ref);
	$tpl->set_var("qt_commande",$qt_commande);
	$tpl->set_var("adresse",$adresse);
	$tpl->set_var("qt_liv",abs($qt_liv));
	$tpl->set_var("adresse",$adresse);
	$tpl->set_var("transporteur",$transporteur);
	$tpl->set_var("heure_depart",$heure_depart);
		
		// VERIFICATION
		if ($etat_commande == 1){
			$tpl->set_var("cloturer","cloturé");
		} else if ($etat_commande == 0){
			$tpl->set_var("cloturer","En cours");
		}
		
		if ($facturation == 1){
			$tpl->set_var("facturation","facturé");
		} else if ($facturation == 0){
			$tpl->set_var("facturation","En cours");
		}
		 
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
	
   $tpl->pparse("journal_lb_voyage", false);

?>
