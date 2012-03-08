 <?php
      include ("header.php");
      $pWindow = "gestion_pneumatique";
      $filename = "gestion_pneumatique.php";
      $template_filename = "gestion_pneumatique.html";

      $sAction = get_param("FormAction");
      $sForm = get_param("FormName");

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "gestion_pneumatique");

      $tpl->load_file("../apps/footer.html", "Footer");

      $sheader = $tplheader->return_var("Header");
      $tpl->set_var("Header",$sheader);
      $tpl->parse("Footer", false);

      $tpl->set_var("FileName", $filename);
      
      $lookup_vehicule = db_fill_array("SELECT * FROM  vehicules");
      
      if(is_array($lookup_vehicule)) {
      reset($lookup_vehicule);
            while(list($value, $key) = each($lookup_vehicule)) {
              $tpl->set_var("Value_vehicule", $value);
              $tpl->set_var("id_vehicule", $key);
              $tpl->parse("select_vehicule", true);
            }
      }
      
      $ref_vehicule = get_param('ref_vehicule');
      $num_bon = get_param("num_bon");
      $date = get_param("date");
      $marque_pneu = get_param("marque_pneu");
      $nbr_pneu = get_param("nbr_pneu");
      $km = get_param("km");
      $observation = get_param("observation");
      
      //var_dump($_POST);

      $sSQL = "INSERT INTO suivie_pneumatique (" . 
                  "num_bon," .
                  "ref_vehicule," .
                  "date," . 
                  "marque_pneu," . 
                  "nbr_pneu," . 
                  "km," . 
                  "observation)" .
            " VALUES (" . 
                  tosql($num_bon, "Number") . "," .
                  tosql($ref_vehicule, "Number") . "," .
                  tosql($date, "Text") . "," .
                  tosql($marque_pneu, "Text") . "," .
                  tosql($nbr_pneu, "Number") . "," .
                  tosql($km, "Number") . "," .
                  tosql($observation, "Text") . 
      ")";
      
      if ($num_bon && $ref_vehicule && $date && $marque_pneu && $nbr_pneu && $km) {
                  $db->query($sSQL);
                  echo '<script>alert("Vous avez saisie la marque : '. $marque_pneu .' et QT : '. $nbr_pneu .' !")</script>';
            } 
   $tpl->pparse("gestion_pneumatique", false);      

?>    
