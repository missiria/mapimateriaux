 <?php
      include ("header.php");
      $pWindow = "fournisseurs";
      $filename = "fournisseurs.php";
      $template_filename = "fournisseurs.html";

      $sAction = get_param("FormAction");
      $sForm = get_param("FormName");

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "fournisseurs");

      $tpl->load_file("../apps/footer.html", "Footer");

      $sheader = $tplheader->return_var("Header");
      $tpl->set_var("Header",$sheader);
      $tpl->parse("Footer", false);

      $tpl->set_var("FileName", $filename);

      $tpl->pparse("fournisseurs", false);

      $nom_resp = get_param("nom_resp");
      $prenom_resp = get_param("prenom_resp");
      
      $raison_social = get_param("raison_social");
      $email = get_param("email");
      
      $tel = get_param("tel");
      $adresse = get_param("adresse");
      
      $num_compte_bancaire = get_param("num_compte_bancaire");
      $ville = get_param("ville");
      
      if ($nom_resp && $raison_social && $tel && $adresse && $ville) {
          
          $num_bon_existe = dlookup("fournisseurs", "count(*)", "nom_resp=".tosql($nom_resp, "TEXT"));

          	if ($nom_resp_existe > 0) {
          		echo "<script>alert('Vous essayer de saisir un bon numéro $nom_resp qui éxiste déja !!!')</script>";  
          	} else {   	          	
          		$sSQL = "INSERT INTO fournisseurs (" . 
                  "nom_resp," . 
                  "prenom_resp," . 
                  "raison_social," . 
                  "email," . 
                  "tel," . 
                  "adresse," .
                  "num_compte_bancaire," .
                  "ville)" . 
            " VALUES (" . 
                  tosql($nom_resp, "Text") . "," . 
                  tosql($prenom_resp, "Text") . "," . 
                  tosql($raison_social, "Text") . "," .
                  tosql($email, "Text") . "," .
                  tosql($tel, "Number") . "," .
                  tosql($adresse, "Text") . "," .
                  tosql($num_compte_bancaire, "Number") . "," .
                  tosql($ville, "Text") . 
            ")";         	
          		$db->query($sSQL);
          		echo '<script>alert("Vous avez saisie le fournisseurs : '. $nom_resp .'")</script>';
          	}
                  
      }
        
        

?>
