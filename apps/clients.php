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

      

      $nom_resp = get_param("nom_resp");
      $prenom_resp = get_param("prenom_resp");
      $raison_social = get_param("raison_social");
      $email = get_param("email");
      $tel = get_param("tel");
      $adresse = get_param("adresse");
      $ville = get_param("ville");
      $id = get_param("id");
      
      if ($nom_resp && $raison_social && $tel && $adresse && $ville && !$id) {
      
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
                  
            } else if ($id) {
                  $sSQL = "UPDATE clients SET "; 
            	$sSQL .= "nom_resp = " . tosql($nom_resp, "Text");
            	$sSQL .= ", prenom_resp = " . tosql($prenom_resp, "Text");
            	$sSQL .= ", raison_social = " . tosql($raison_social, "Text");
            	$sSQL .= ", email = " . tosql($email, "Text");
            	$sSQL .= ", tel = " . tosql($tel, "Text");
            	$sSQL .= ", adresse = " . tosql($adresse, "Text");
            	$sSQL .= ", ville = " . tosql($ville, "Text");
            	$sSQL .= " where id=" .tosql($id, "Number") ."";        	
          		$db->query($sSQL);
          		echo '<script>alert("Vous avez mis à le bon numéro")</script>';
            }
        search();
      //==============================
      function search() {
      //==============================
            global $db;
            global $tpl;
            global $sForm;
            $sActionFileName = "clients.php";
            $tpl->set_var("ActionPage", $sActionFileName);
            $keyword = strip(get_param("keyword"));
            $tpl->set_var("keyword", tohtml($keyword));
                   	
		$sSQL = "SELECT * FROM clients ";			
		if (strlen(trim($keyword)) > 0)
					$sSQL .= "WHERE nom_resp LIKE '$keyword%'";
					
		$db->query($sSQL);
		$next_record = $db->next_record();
     
            $i = 1;                          
            while($next_record) { 
            	//WE DISPLAY THE RESULTS
            	
            	$id = $db->f("id");
             	
             	$nom_resp = $db->f("nom_resp");
             	$prenom_resp = $db->f("prenom_resp");
             	$raison_social = $db->f("raison_social");
             	$email = $db->f("email");
             	$tel = $db->f("tel");
             	$adresse = $db->f("adresse");
             	$ville = $db->f("ville");
             	
             	$next_record = $db->next_record();
             	
             	$tpl->set_var("id",$id);
			
			$tpl->set_var("nom_resp",$nom_resp);
			$tpl->set_var("prenom_resp",$prenom_resp);
			$tpl->set_var("raison_social",$raison_social);
			$tpl->set_var("email",$email);
			$tpl->set_var("tel",$tel);
			$tpl->set_var("adresse",$adresse);
                  $tpl->set_var("ville",$ville);

			
			$tpl->set_var("ordrRow",$i);

            	$tpl->parse("row_result", true);
            	$i++;
      		}

      		if ($i == 1){
  					$tpl->parse("Norow_result",false);
  					$tpl->set_var("row_result","");
  				} else {
      			$tpl->set_var("Norow_result","");
      		}
				$tpl->parse("block_search", false); 		
      }
      delete();
      function delete() {
	      $delete = get_param('delete');
	      if ($delete) {
	            $sql = sprintf("DELETE FROM clients WHERE id = '".$delete."'");
	            $result = mysql_query($sql);    
	            header("location: clients.php");
	      }			
      }
      $tpl->pparse("clients", false);
?>
