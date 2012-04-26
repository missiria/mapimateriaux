<?php
      include ("header.php");
      $pWindow = "journal_commandes";
      $filename = "journal_commandes.php";
      $template_filename = "journal_commandes.html";

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "journal_commandes");

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
      
        search();
        //==============================
        function search() {
        //==============================
			global $db;
			global $tpl;
			global $sForm;
			$sActionFileName = "journal_commandes.php";
			$tpl->set_var("ActionPage", $sActionFileName);
			$keyword = strip(get_param("keyword"));
			$tpl->set_var("keyword", tohtml($keyword));
			
			$from = strip(get_param("from"));
			$to = strip(get_param("to"));
			$tpl->set_var("from", tohtml($from));
			$tpl->set_var("to", tohtml($to));
			
			// var_dump($_GET);
			// echo "<hr>";
			// var_dump($_POST);
			
			$sSQL = "SELECT * FROM commandes ";			
			if ($from && $to)
			$sSQL .= "WHERE date BETWEEN ".tosql($from, "TEXT")." AND ".tosql($to, "TEXT");
			if ($keyword)
			$sSQL .= " AND ref_client=".tosql($keyword, "TEXT");
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
			$facturation = $db->f("facturation");
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
			
			if ($facturation == 1){
			$tpl->set_var("facturation","Facturé");
			} else if ($facturation == 0){
			$tpl->set_var("facturation","NON facturé");
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
	    
   $tpl->pparse("journal_commandes", false);      

?>
