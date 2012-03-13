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
      
      $lookup_fournisseurs = db_fill_array("SELECT nom_resp,id FROM  fournisseurs");
      
      if(is_array($lookup_fournisseurs)) {
      reset($lookup_fournisseurs);
            while(list($value, $key) = each($lookup_fournisseurs)) {
              $tpl->set_var("Value_fournisseurs", $value);
              $tpl->set_var("id_fournisseurs", $key);
              $tpl->parse("select_fournisseurs", true);
            }
      }
      
      // $_POST TRAITEMENT
      $ref_vehicule = get_param('vehicule');
      $num_bon = get_param("bon");
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
   $tpl->pparse("achats", false);      

?>
