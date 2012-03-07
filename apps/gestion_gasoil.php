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
      $tpl->set_var("vehicule", $vehicule);
      $lookup_vehicule = db_fill_array("SELECT * FROM  suivi_gasoil");
      while (list($key, $value) = each($lookup_vehicule)) {
            echo "test" .$value;
      }
      $tpl->pparse("gestion_gasoil", false);

      $nom_resp = get_param("nom_resp");
      $prenom_resp = get_param("prenom_resp");
      
      $raison_social = get_param("raison_social");
      $email = get_param("email");
      
      $tel = get_param("tel");
      $adresse = get_param("adresse");
      
      $ville = get_param("ville");
      
      $sSQL = "INSERT INTO clients (" . 
                  "nom_resp," . 
                  "prenom_resp," . 
                  "raison_social," . 
                  "email," . 
                  "tel," . 
                  "adresse," .
                  "ville)" . 
            " VALUES (" . 
                  tosql($nom_resp, "Text") . "," . 
                  tosql($prenom_resp, "Text") . "," . 
                  tosql($raison_social, "Text") . "," .
                  tosql($email, "Text") . "," .
                  tosql($tel, "Text") . "," .
                  tosql($adresse, "Text") . "," .
                  tosql($ville, "Text") . 
      ")";
      
      if ($nom_resp && $raison_social && $tel && $adresse && $ville) {
                  $db->query($sSQL);
                  echo '<script>alert("Vous avez ajouté le client : '. $nom_resp .'")</script>';
            } 

?>
