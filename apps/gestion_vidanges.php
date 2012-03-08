 <?php
      include ("header.php");
      $pWindow = "gestion_vidanges";
      $filename = "gestion_vidanges.php";
      $template_filename = "gestion_vidanges.html";

      $sAction = get_param("FormAction");
      $sForm = get_param("FormName");

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "gestion_vidanges");

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
      $type_vidange = get_param("type_vidange");
      $km = get_param("km");
      $observations = get_param("observations");
      
      //var_dump($_POST);

      $sSQL = "INSERT INTO suivi_vidange (" . 
                  "ref_vehicule," .
                  "num_bon," . 
                  "date," . 
                  "type_vidange," . 
                  "km," . 
                  "observations)" .
            " VALUES (" . 
                  tosql($ref_vehicule, "Number") . "," .
                  tosql($num_bon, "Number") . "," .
                  tosql($date, "Text") . "," .
                  tosql($type_vidange, "Number") . "," .
                  tosql($km, "Number") . "," .
                  tosql($observations, "Text") . 
      ")";
      
      if ($num_bon && $ref_vehicule && $date && $type_vidange && $km) {
                  $db->query($sSQL);
                  echo '<script>alert("Vous avez saisie le bon numéro : '. $num_bon .'")</script>';
            } 
   $tpl->pparse("gestion_vidanges", false);      

?>
