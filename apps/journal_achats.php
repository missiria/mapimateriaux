<?php
      include ("header.php");
      $pWindow = "journal_achats";
      $filename = "journal_achats.php";
      $template_filename = "journal_achats.html";

      $sAction = get_param("FormAction");
      $sForm = get_param("FormName");

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "journal_achats");

      $tpl->load_file("../apps/footer.html", "Footer");

      $sheader = $tplheader->return_var("Header");
      $tpl->set_var("Header",$sheader);
      $tpl->parse("Footer", false);

      $tpl->set_var("FileName", $filename);
      
      $lookup_fournisseurs = db_fill_array("SELECT nom_resp,id FROM  fournisseurs");
      
      if(is_array($lookup_fournisseurs)) {
      reset($lookup_fournisseurs);
            while(list($value, $key) = each($lookup_fournisseurs)) {
              $tpl->set_var("Value_fournisseur", $value);
              $tpl->set_var("id_fournisseur", $key);
              $tpl->parse("select_fournisseur", true);
            }
      }
      
      // $_POST TRAITEMENT
      $num_facture_achat = get_param('num_facture_achat');
      $date_regelement = get_param('date_regelement');
      $ref_fournisseur = get_param("ref_fournisseur");
      $montant_achat = get_param("montant_achat");
      
      $etat_reglement = get_param("etat_reglement");
      
      $mode_reglement = get_param("mode_reglement");
      $ref_bank = get_param("ref_bank");
      $id = $_POST["id"];
      
      //var_dump($_POST);

      search();
      //==============================
      function search() {
      //==============================
            global $db;
            global $tpl;
            global $sForm;
            $sActionFileName = "journal_achats.php";
            $tpl->set_var("ActionPage", $sActionFileName);
            $ref_fournisseur = strip(get_param("ref_fournisseur"));
            $tpl->set_var("keyword", tohtml($keyword));

			$from = strip(get_param("from"));
			$to = strip(get_param("to"));
			$tpl->set_var("from", tohtml($from));
			$tpl->set_var("to", tohtml($to));

			$sSQL = "SELECT * FROM  achats ";			
			if ($from && $to)
			$sSQL .= "WHERE date_regelement BETWEEN ".tosql($from, "TEXT")." AND ".tosql($to, "TEXT");
			if ($ref_fournisseur)
			$sSQL .= " AND ref_fournisseur=".tosql($ref_fournisseur, "TEXT");
			$db->query($sSQL);
			$next_record = $db->next_record();

            $i = 1;                          
            while($next_record){ 
	            //WE DISPLAY THE RESULTS
             	$id = $db->f("id");
             	$num_facture_achat = $db->f("num_facture_achat"); 
             	$date_regelement = $db->f("date_regelement"); 
             	$montant_achat = $db->f("montant_achat");
             	$etat_reglement = $db->f("etat_reglement");
             	$mode_reglement = $db->f("mode_reglement");
             	$ref_bank = $db->f("ref_bank");
             	$ref_fournisseur = dlookup("fournisseurs", "nom_resp", "id=".tosql($db->f("ref_fournisseur"), "NUMBER")); 
             	$produits = dlookup("produits", "libelle", "id=".tosql($db->f("ref_produit"), "NUMBER")); 
             	$next_record = $db->next_record();
             	
                $tpl->set_var("id",$id);
                $tpl->set_var("date",$date);
                $tpl->set_var("num_facture_achat",$num_facture_achat);
                $tpl->set_var("date_regelement",$date_regelement);
                $tpl->set_var("ref_fournisseur",$ref_fournisseur);
                $tpl->set_var("montant_achat",$montant_achat);
                $tpl->set_var("etat_reglement",$etat_reglement);
                $tpl->set_var("mode_reglement",$mode_reglement);
                $tpl->set_var("ref_bank",$ref_bank);
                $tpl->set_var("produits",$produits);
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
      
   $tpl->pparse("journal_achats", false);      

?>
