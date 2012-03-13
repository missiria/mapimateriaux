 <?php
      include ("header.php");
      $pWindow = "clients";
      $filename = "clients.php";
      $template_filename = "clients.html";

      $sAction = get_param("FormAction");
      $sForm = get_param("FormName");

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "clients");

      $tpl->load_file("../apps/footer.html", "Footer");

      $sheader = $tplheader->return_var("Header");
      $tpl->set_var("Header",$sheader);
      $tpl->parse("Footer", false);

      $tpl->set_var("FileName", $filename);

      $tpl->pparse("clients", false);

      $nom_resp = get_param("nom_resp");
      $prenom_resp = get_param("prenom_resp");
      
      $raison_social = get_param("raison_social");
      $email = get_param("email");
      
      $tel = get_param("tel");
      $adresse = get_param("adresse");
      
      $ville = get_param("ville");
      
      if ($nom_resp && $raison_social && $tel && $adresse && $ville) {
      
          if (strlen(trim($id))==0) {
          	$num_bon_existe = dlookup("clients", "count(*)", "nom_resp=".tosql($nom_resp, "NUMBER"));

                	if ($num_bon_existe > 0) {
                		echo "<script>alert('Vous essayer de saisir un bon numéro $nom_resp qui éxiste déja !!!')</script>";  
                	} else {   	          	
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
                              tosql($tel, "Number") . "," .
                              tosql($adresse, "Text") . "," .
                              tosql($ville, "Text") . 
                        ")";          	
                		$db->query($sSQL);
                		echo '<script>alert("Vous avez saisie le bon numéro : '. $nom_resp .'")</script>';
                	}
                }
                  
            } 

?>
