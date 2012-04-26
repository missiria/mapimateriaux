<?php
	include ("header.php");
	$pWindow = "journal_lb";
	$filename = "journal_lb.php";
	$template_filename = "journal_lb.html";

	$tpl = new Template($app_path);
	$tpl->load_file($template_filename, "journal_lb");

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
			
			
	$sSQL = "SELECT * FROM commandes ";
	if ($from && $to)
	$sSQL .= "WHERE date BETWEEN ".tosql($from, "TEXT")." AND ".tosql($to, "TEXT");
	if ($keyword)
	$sSQL .= " AND ref_client=".tosql($keyword, "TEXT");
	
	$db->query($sSQL);
	$next_record = $db->next_record();

	//var_dump($_GET);

      $i = 1;
    while($next_record){

      	//WE DISPLAY THE RESULTS
       	$id = $db->f("id");
       	$date = $db->f("date");
        $ref_client = $db->f("ref_client");
       	$qt_produit = $db->f("qt_produit");
       	$qt_liv = $db->f("qt_liv");
       	$ref_prod = $db->f("ref_produit");
       	$ref_prod_ref = $db->f("ref_reference");
       	$ref_vehicule = $db->f("ref_vehicule");
       	$time_depart = $db->f("time_depart");
       	$etat_commande = $db->f("etat_commande");
       	$facturation = $db->f("facturation");
		
		// WE GET THE RELATION WITH THE OTHER FIELDS
       	$libclients = dlookup("clients", "nom_resp", "id=".tosql($db->f("ref_client"), "NUMBER"));
       	$produit = dlookup("produits", "libelle", "id=".tosql($db->f("ref_produit"), "Text"));
       	$produit_ref = dlookup("produits", "libelle", "id=".tosql($db->f("ref_reference"), "Text"));
       	$telClient = dlookup("clients", "tel", "id=".tosql($db->f("ref_client"), "NUMBER"));
       	$adresseClient = dlookup("clients", "adresse", "id=".tosql($db->f("ref_client"), "Text"));
       	$ref_vehicule = dlookup("vehicules", "libelle", "id=".tosql($db->f("ref_vehicule"), "Text"));

       	// WE RECORD THE SQL
       	$next_record = $db->next_record();

       	// SET A VARIABLE IN TEMPLATE
       	$tpl->set_var("id",$id);
       	$tpl->set_var("date",$date);
		$tpl->set_var("ref_client",$libclients);
		$tpl->set_var("produit",$produit);
		$tpl->set_var("ref_reference",$produit_ref);
		$tpl->set_var("telClient",$telClient);
		$tpl->set_var("adresseClient",$adresseClient);
		$tpl->set_var("qt_liv",$qt_liv);
		$tpl->set_var("qt_produit",$qt_produit);
		$tpl->set_var("time_depart",$time_depart);
		$tpl->set_var("ref_vehicule",$ref_vehicule);
		$tpl->set_var("ref_prod",$ref_prod_ref);
		
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
	
   $tpl->pparse("journal_lb", false);

?>
