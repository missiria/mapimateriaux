 <?php
      include ("header.php");
      $pWindow = "gestion_batteries";
      $filename = "gestion_batteries.php";
      $template_filename = "gestion_batteries.html";

      $sAction = get_param("FormAction");
      $sForm = get_param("FormName");

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "gestion_batteries");

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
      
      $num_bon = get_param("num_bon");
      $ref_vehicule = get_param('ref_vehicule');
      $date = get_param("date");
      $marque_baterie = get_param("marque_baterie");
      $nbr_batrie = get_param("nbr_batrie");
      $km = get_param("km");
      $observation = get_param("observation");
      
      var_dump($_POST);

      $sSQL = "INSERT INTO suivie_baterie (" . 
                  "num_bon," .
                  "ref_vehicule," .
                  "date," . 
                  "marque_baterie," . 
                  "nbr_batrie," . 
                  "km," . 
                  "observation)" .
            " VALUES (" . 
                  tosql($num_bon, "Number") . "," .
                  tosql($ref_vehicule, "Number") . "," .
                  tosql($date, "Text") . "," .
                  tosql($marque_baterie, "Text") . "," .
                  tosql($nbr_batrie, "Number") . "," .
                  tosql($km, "Number") . "," .
                  tosql($observation, "Text") . 
      ")";
      
      if ($num_bon && $ref_vehicule && $date && $marque_baterie && $nbr_batrie && $km) {
                  $db->query($sSQL);
                  echo '<script>alert("Vous avez saisie la marque : '. $marque_baterie .' et QT : '. $nbr_batrie .' !")</script>';
            } 
   $tpl->pparse("gestion_batteries", false);      

?>    
