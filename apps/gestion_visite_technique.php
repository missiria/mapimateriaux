 <?php
      include ("header.php");
      $pWindow = "gestion_visite_technique";
      $filename = "gestion_visite_technique.php";
      $template_filename = "gestion_visite_technique.html";

      $sAction = get_param("FormAction");
      $sForm = get_param("FormName");

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "gestion_visite_technique");

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
      $date = get_param("date");
      
      //var_dump($_POST);

      $sSQL = "INSERT INTO suivie_visite (" .
                  "ref_vehicule," .
                  "date)" .
            " VALUES (" . 
                  tosql($ref_vehicule, "Number") . "," .
                  tosql($date, "Text") . 
      ")";
      
      if ($ref_vehicule && $date) {
                  $db->query($sSQL);
                  echo '<script>alert("Merci !")</script>';
            } 
   $tpl->pparse("gestion_visite_technique", false);      

?>    
