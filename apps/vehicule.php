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
      
      $id = $_POST['id'];
      
      // INTERNE PACK 
      $libelle = get_param("libelle");
      $matricule = get_param("matricule");
      $km_initial = get_param("km_initial");
      
      // EXTERNE PACK
      $num_matricule = get_param("num_matricule");
      $societe = get_param("societe");
      
      if ($libelle && $matricule && $km_initial && $num_matricule && $societe && !$id){
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
            $db->query($InterneSQL);
            $db->query($ExterneSQL);
            echo '<script>alert("Vous avez saisiez un pack externe & interne de véhicule !")</script>';
            exit();
      } else if ($id) {
            $ExterneSQL = "UPDATE vehicules SET "; 
            $ExterneSQL .="libelle =" . tosql($libelle, "Text");
            $ExterneSQL .= ",matricule =". tosql($matricule, "Text");
            $ExterneSQL .= ",km_initial =". tosql($km_initial, "Text");
            $ExterneSQL .= " where id=" .tosql($id, "Number") ."";        	
            $db->query($ExterneSQL);
            
      }
      
      if ($libelle && $matricule && $km_initial && !$id) {
            $ExterneSQL = "INSERT INTO vehicules (" . 
                  "libelle," . 
                  "matricule," . 
                  "km_initial)" . 
            " VALUES (" . 
                  tosql($libelle, "Text") . "," . 
                  tosql($matricule, "Text") . "," . 
                  tosql($km_initial, "Text") . 
            ")";
            $db->query($ExterneSQL);
            echo '<script>alert("Vous avez ajouté un Interne véhicule !")</script>';
      } else if ($id) {
            // EXTERNE
            $ExterneSQL = "UPDATE vehicules SET "; 
            $ExterneSQL .="libelle =" . tosql($libelle, "Text");
            $ExterneSQL .= ",matricule =". tosql($matricule, "Text");
            $ExterneSQL .= ",km_initial =". tosql($km_initial, "Text");
            $ExterneSQL .= " where id=" .tosql($id, "Number") .""; 
            
            // INTERNE  
            $InterneSQL = "UPDATE vehicule_externe SET "; 
            $InterneSQL .="num_matricule =" . tosql($num_matricule, "Text");
            $InterneSQL .= ",societe =". tosql($societe, "Text");
            $InterneSQL .= " where id=" .tosql($id, "Number") ."";   
              	
            $db->query($ExterneSQL);
            $db->query($InterneSQL);
            
            echo '<script>alert("Vous avez mis à les deux type de vehicule : '. $matricule .' et '. $num_matricule .'")</script>';        	
            
      }
        
      if ($num_matricule && $societe && !$id) {
            $InterneSQL = "INSERT INTO vehicule_externe (" . 
                  "num_matricule," . 
                  "societe)" . 
            " VALUES (" . 
                  tosql($num_matricule, "Text") . "," . 
                  tosql($societe, "Text") . 
            ")";
            $db->query($InterneSQL);
            echo '<script>alert("Vous avez ajouté un externe véhicule !")</script>';
      } else if ($id) {
            $InterneSQL = "UPDATE vehicule_externe SET "; 
            $InterneSQL .="num_matricule =" . tosql($num_matricule, "Text");
            $InterneSQL .= ",societe =". tosql($societe, "Text");
            $InterneSQL .= " where id=" .tosql($id, "Number") ."";        	
            $db->query($InterneSQL);
            echo '<script>alert("Vous avez mis à le vehicule : '. $num_matricule .'")</script>';
      }
      
      search_Interne();
      //==============================
      function search_Interne() {
      //==============================
            global $db;
            global $tpl;
            global $sForm;
            $sActionFileName = "vehicule.php";
            $tpl->set_var("ActionInterne", $sActionFileName);
            $keyword = strip(get_param("keyword"));
            $tpl->set_var("keyword", tohtml($keyword));
				
				$sSQL = "SELECT * FROM vehicules ";			
				if (strlen(trim($keyword)) > 0)
					$sSQL .= "WHERE nom_resp LIKE '$keyword%'";
				
				$db->query($sSQL);
				$next_record = $db->next_record();
     
            $i = 1;                          
            while($next_record){ 
            	//WE DISPLAY THE RESULTS
             	$id = $db->f("id");
             	
             	$libelle = $db->f("libelle");
             	$matricule = $db->f("matricule");
             	$km_initial = $db->f("km_initial"); 

             	$next_record = $db->next_record();
             	
             	$tpl->set_var("id",$id);
			$tpl->set_var("libelle",$libelle);
			$tpl->set_var("matricule",$matricule);
			$tpl->set_var("km_initial",$km_initial);
			$tpl->set_var("ordrRow",$i);
        
            	$tpl->parse("row_result_Interne", true);
            	$i++;
      		}
      		if ($i == 1){
  					$tpl->parse("Norow_result_Interne",false);
  					$tpl->set_var("row_result_Interne","");
  				} else {
      			$tpl->set_var("Norow_result_Interne","");
      		}
				$tpl->parse("block_search_interne", false); 		
      }
      deleteInterne();
      function deleteInterne() {
	      $delete = get_param('deleteInterne');
	      if ($delete) {
	            $sql = sprintf("DELETE FROM vehicules WHERE id = '".$delete."'");
	            $result = mysql_query($sql);    
	            header("location: vehicule.php");
	      }			
      }
      search_Externe();
      //==============================
      function search_Externe() {
      //==============================
            global $db;
            global $tpl;
            global $sForm;
            $sActionFileName = "vehicule.php";
            $tpl->set_var("ActionExterne", $sActionFileName);
            $keyword = strip(get_param("keyword"));
            $tpl->set_var("keyword", tohtml($keyword));
				
		$sSQL = "SELECT * FROM vehicule_externe ";			
		$db->query($sSQL);
		$next_record = $db->next_record();
     
            $i = 1;                          
            while($next_record){ 
            	//WE DISPLAY THE RESULTS
             	$id = $db->f("id");
             	
             	$num_matricule = $db->f("num_matricule");
             	$societe = $db->f("societe");

             	$next_record = $db->next_record();
             	
             	$tpl->set_var("id",$id);
			$tpl->set_var("num_matricule",$num_matricule);
			$tpl->set_var("societe",$societe);
			$tpl->set_var("ordrRow",$i);
        
            	$tpl->parse("row_result_Externe", true);
            	$i++;
      		}
      		if ($i == 1){
  					$tpl->parse("Norow_result_Externe",false);
  					$tpl->set_var("row_result_Externe","");
  				} else {
      			$tpl->set_var("Norow_result_Externe","");
      		}
				$tpl->parse("block_search_Externe", false); 		
      }
      deleteExterne();
      function deleteExterne() {
	      $delete = get_param('deleteExterne');
	      if ($delete) {
	            $sql = sprintf("DELETE FROM vehicule_externe WHERE id = '".$delete."'");
	            $result = mysql_query($sql);    
	            header("location: vehicule.php");
	      }			
      }
      $tpl->pparse("vehicule", false);
?>
