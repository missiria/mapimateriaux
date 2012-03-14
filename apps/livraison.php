 <?php
      include ("header.php");
      $pWindow = "livraison";
      $filename = "livraison.php";
      $template_filename = "livraison.html";

      $sAction = get_param("FormAction");
      $sForm = get_param("FormName");

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "livraison");

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
      $ref_vehicule = get_param('ref_vehicule');
      $num_bon = get_param("num_bon");
      $date = get_param("date");
      
      $prix_unitaire = get_param("prix_unitaire");
      $qt_commande = get_param("qt_commande");
      $ref_produit = get_param("ref_produit");
      
      //var_dump($_POST);

      $dcSQL = "INSERT INTO detail_commande (" . 
                  "prix_unitaire," .
                  "qt_commande," . 
                  "ref_produit)" .
            " VALUES (" . 
                  tosql($prix_unitaire, "Number") . "," .
                  tosql($qt_commande, "Number") . "," .
                  tosql($ref_produit, "Number") . 
      ")";
      
      if ($prix_unitaire && $qt_commande && $ref_produit) {
                  $db->query($sSQL);
                  echo '<script>alert("merci")</script>';
            } 
   $tpl->pparse("livraison", false);      

?>
