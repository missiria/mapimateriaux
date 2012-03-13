 <?php
      include ("header.php");
      $pWindow = "vehicule";
      $filename = "vehicule.php";
      $template_filename = "vehicule.html";

      $sAction = get_param("FormAction");
      $sForm = get_param("FormName");

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "vehicule");

      $tpl->load_file("../apps/footer.html", "Footer");

      $sheader = $tplheader->return_var("Header");
      $tpl->set_var("Header",$sheader);
      $tpl->parse("Footer", false);

      $tpl->set_var("FileName", $filename);

      $tpl->pparse("vehicule", false);
      
      
      // INTERNE PACK 
      $libelle = get_param("libelle");
      $matricule = get_param("matricule");
      $km_initial = get_param("km_initial");
      
      // EXTERNE PACK
      $num_matricule = get_param("num_matricule");
      $societe = get_param("societe");
      
      $ExterneSQL = "INSERT INTO vehicules (" . 
                  "libelle," . 
                  "matricule," . 
                  "km_initial)" . 
            " VALUES (" . 
                  tosql($libelle, "Text") . "," . 
                  tosql($matricule, "Text") . "," . 
                  tosql($km_initial, "Text") . 
      ")";
      
      $InterneSQL = "INSERT INTO vehicule_externe (" . 
                  "num_matricule," . 
                  "societe)" . 
            " VALUES (" . 
                  tosql($num_matricule, "Text") . "," . 
                  tosql($societe, "Text") . 
      ")";
      
      if ($libelle && $matricule && $km_initial && $num_matricule && $societe){
            $db->query($InterneSQL);
            $db->query($ExterneSQL);
            echo '<script>alert("Vous avez saisiez un pack externe & interne de véhicule !")</script>';
            exit();
      }
      
      if ($libelle && $matricule && $km_initial) {
            $db->query($ExterneSQL);
            echo '<script>alert("Vous avez ajouté un Interne véhicule !")</script>';
      }
        
      if ($num_matricule && $societe) {
            $db->query($InterneSQL);
            echo '<script>alert("Vous avez ajouté un externe véhicule !")</script>';
      }
      

?>
