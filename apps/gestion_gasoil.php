 <?php
      include ("header.php");
      $pWindow = "gestion_gasoil";
      $filename = "gestion_gasoil.php";
      $template_filename = "gestion_gasoil.html";

      $sAction = get_param("FormAction");
      $sForm = get_param("FormName");

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "gestion_gasoil");

      $tpl->load_file("../apps/footer.html", "Footer");

      $sheader = $tplheader->return_var("Header");
      $tpl->set_var("Header",$sheader);
      $tpl->parse("Footer", false);

      $tpl->set_var("FileName", $filename);
      //$tpl->set_var("vehicule", $vehicule);
      $lookup_vehicule = db_fill_array("SELECT * FROM  suivi_gasoil");
      echo $db->f('qt_littre');
      
print_r($lookup_vehicule);      
      
 	if(is_array($lookup_vehicule)){
      reset($lookup_vehicule);
      while(list($key, $value) = each($lookup_vehicule))
      {
        $tpl->set_var("ID", $key);
        $tpl->set_var("Value", $value);
        if($key == $fldref_vehicule)
          $tpl->set_var("Selected", "SELECTED" );
        else
          $tpl->set_var("Selected", "");
        $tpl->parse("select_vehicule", true);
      }
    }
     

      $nom_resp = get_param("nom_resp");
      $prenom_resp = get_param("prenom_resp");
      
      $raison_social = get_param("raison_social");
      $email = get_param("email");
      
      $tel = get_param("date");
      $qt_littre = get_param("qt_littre");
      $km = get_param("km");
      
      $ville = get_param("ville");
      
      $sSQL = "INSERT INTO clients (" . 
                  "nom_resp," . 
                  "ville)" . 
            " VALUES (" . 
                  tosql($nom_resp, "Text") . "," .
                  tosql($ville, "Text") . 
      ")";
      
      if ($nom_resp && $raison_social && $tel && $adresse && $ville) {
                  $db->query($sSQL);
                  echo '<script>alert("Vous avez ajouté le client : '. $nom_resp .'")</script>';
            } 
   $tpl->pparse("gestion_gasoil", false);      

?>
