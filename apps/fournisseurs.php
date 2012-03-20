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

      $nom_resp = get_param("nom_resp");
      $prenom_resp = get_param("prenom_resp");
      $raison_social = get_param("raison_social");
      $email = get_param("email");
      $tel = get_param("tel");
      $adresse = get_param("adresse");
      $num_compte_bancaire = get_param("num_compte_bancaire");
      $ville = get_param("ville");
      $id = $_POST['id'];
      
      /*
      
      echo "test : " . $nom_resp;
      echo "<br> test : " . $prenom_resp;
      echo "<br> test : " . $raison_social;
      echo "<br> test : " . $email;
      echo "<br> test : " . $tel;
      echo "<br> test : " . $adresse;
      echo "<br> test : " . $num_compte_bancaire;
      echo "<br> test : " . $ville;
      echo "<br> test : " . $id;
      
      var_dump($_POST); 
      
      */
      
      if ($nom_resp && $raison_social && $tel && $adresse && $ville && $num_compte_bancaire && !$id) {
          
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
                  tosql($tel, "Text") . "," .
                  tosql($adresse, "Text") . "," .
                  tosql($num_compte_bancaire, "Text") . "," .
                  tosql($ville, "Text") . 
            ")";         	
          		$db->query($sSQL);
          		echo '<script>alert("Vous avez saisie le fournisseurs : '. $nom_resp .'")</script>';
          	}
                 
      } // INSERT THE ROW !
      
      else if ($id) {
                  $sSQL = "UPDATE fournisseurs SET "; 
                  	$sSQL .= "nom_resp = " . tosql($nom_resp, "Text");
                  	$sSQL .= ",prenom_resp = " .  tosql($prenom_resp, "Text");
                  	$sSQL .=",raison_social =" . tosql($raison_social, "Text");
                  	$sSQL .=",email =" . tosql($email, "Text");
                  	$sSQL .= ",tel =". tosql($tel, "Text");
                  	$sSQL .= ",adresse =". tosql($adresse, "Text");
                  	$sSQL .= ",ville =". tosql($ville, "Text");
                  	$sSQL .=",num_compte_bancaire =" . tosql($num_compte_bancaire, "Text");
                  	$sSQL .= " where id=" .tosql($id, "Number") ."";        	
          		$db->query($sSQL);
          		echo '<script>alert("Vous avez mis à le bon numéro : '. $num_bon .'")</script>';
      } // EDIT THE ROW !
        
      search();
      //==============================
      function search() {
      //==============================
            global $db;
            global $tpl;
            global $sForm;
            $sActionFileName = "fournisseurs.php";
            $tpl->set_var("ActionPage", $sActionFileName);
            $keyword = strip(get_param("keyword"));
            $tpl->set_var("keyword", tohtml($keyword));
				
				$sSQL = "SELECT * FROM fournisseurs ";			
				if (strlen(trim($keyword)) > 0)
					$sSQL .= "WHERE nom_resp LIKE '$keyword%'";
				
				$db->query($sSQL);
				$next_record = $db->next_record();
     
            $i = 1;                          
            while($next_record){ 
            	//WE DISPLAY THE RESULTS
             	$id = $db->f("id");
             	$nom_resp = $db->f("nom_resp"); 
             	$prenom_resp = $db->f("prenom_resp"); 
             	$raison_social = $db->f("raison_social"); 
             	$email = $db->f("email");
             	$tel = $db->f("tel");
             	$adresse = $db->f("adresse"); 
             	$ville = $db->f("ville");
             	$num_compte_bancaire = $db->f("num_compte_bancaire");
             	
             	$next_record = $db->next_record();
             	
             	$tpl->set_var("id",$id);
             	$tpl->set_var("nom_resp",$nom_resp);
			$tpl->set_var("prenom_resp",$prenom_resp);
			$tpl->set_var("raison_social",$raison_social);
			$tpl->set_var("email",$email);
			$tpl->set_var("tel",$tel);
			$tpl->set_var("adresse",$adresse);
			$tpl->set_var("ville",$ville);
			$tpl->set_var("num_compte_bancaire",$num_compte_bancaire);
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
	            $sql = sprintf("DELETE FROM fournisseurs WHERE id = '".$delete."'");
	            $result = mysql_query($sql);    
	            header("location: fournisseurs.php");
	      }			
      } 
      
      $tpl->pparse("fournisseurs", false);

?>
