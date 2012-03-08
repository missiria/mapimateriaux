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
      global $tpl;
	global $db;
      //check_security();

      $sql = mysql_query("SELECT libelle FROM  vehicules");
      $vehiculeSql = mysql_fetch_array($sql);
      echo "<pre>";
      var_dump($vehiculeSql);
      echo "</pre>";
      
      
     
     
     
     
     
     
     
      $tpl->set_var("libelle_vehicules", "");

      if(is_array($vehiculeSql)) {
            reset($vehiculeSql);
            while(list($key, $value) = each($vehiculeSql)) {
                  $tpl->set_var("ID", $key);
                  $tpl->set_var("Value", $value);
                  $tpl->parse("libelle_vehicule", true);
            }
      }
      
      
      
      
      
      
      
      
      $tpl->pparse("gestion_gasoil", false);

      $ref_vehicule = get_param("ref_vehicule");
      $date = get_param("date");
      $qt_littre = get_param("qt_littre");
      $km = get_param("km");
      
      $sSQL = "INSERT INTO clients (" . 
                  "ref_vehicule," . 
                  "date," . 
                  "qt_littre," . 
                  "km" . 
            " VALUES (" . 
                  tosql($ref_vehicule, "Text") . "," .
                  tosql($date, "Text") . "," .
                  tosql($qt_littre, "Text") . "," .
                  tosql($km, "Text") . 
      ")";
      
      if ($nom_resp && $raison_social && $tel && $adresse && $ville) {
                  $db->query($sSQL);
                  echo '<script>alert("Vous avez ajouté le client : '. $nom_resp .'")</script>';
            } 

?>
