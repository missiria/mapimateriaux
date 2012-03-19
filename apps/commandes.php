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
      
      $lookup_clients = db_fill_array("SELECT nom_resp,id FROM  clients");
      
      if(is_array($lookup_clients)) {
      reset($lookup_clients);
            while(list($value, $key) = each($lookup_clients)) {
              $tpl->set_var("Value_client", $value);
              $tpl->set_var("id_client", $key);
              $tpl->parse("select_clients", true);
            }
      }
      $lookup_produits = db_fill_array("SELECT libelle,id FROM  produits");
      
      if(is_array($lookup_produits)) {
      reset($lookup_produits);
            while(list($value, $key) = each($lookup_produits)) {
              $tpl->set_var("Value_produit", $value);
              $tpl->set_var("id_produit", $key);
              $tpl->parse("select_produits", true);
            }
      }
      
      
      // $_POST TRAITEMENT
      $date = get_param('date');
      $ref_client = get_param("ref_client");
      $ref_produit = get_param("ref_produit");
      $qt_produit = get_param("qt_produit");
      $prix_uni = get_param("prix_uni");
      
      //var_dump($_POST);
      
      if ($date && $ref_client && $ref_produit && $qt_produit && $prix_uni) {
       	          	
	                  $sSQL = "INSERT INTO commandes (" . 
                        "date," . 
                        "ref_client," . 
                        "ref_produit," . 
                        "qt_produit," . 
                        "prix_uni)" .
	                  " VALUES (" . 
                        tosql($date, "Text") . "," .
                        tosql($ref_client, "Number") . "," .
                        tosql($ref_produit, "Number") . "," .
                        tosql($qt_produit, "Number") . "," .
                        tosql($prix_uni, "Number") . 
		                  ")";          	
	                  $db->query($sSQL);
	                  echo '<script>alert("Vous avez saisie : '. $qt_produit .'")</script>';
	                  header("location: traitement_commandes.php");
      } 
   $tpl->pparse("commandes", false);      

?>
