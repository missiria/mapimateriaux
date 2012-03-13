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
      $id = $_POST["id"];
      
      //var_dump($_POST);
      
      if ($ref_vehicule && $date) {
            if (strlen(trim($id))==0){
          	$date_existe = dlookup("suivie_visite", "count(*)", "date=".tosql($date, "NUMBER"));

          	if ($date_existe > 0) {
          		echo "<script>alert('Vous essayer de saisir un bon numéro $date qui éxiste déja !!')</script>";  
          	} else {   	          	
          		$sSQL = "INSERT INTO suivie_visite (" . 
                  "ref_vehicule," .
                  "date)" . 
            " VALUES (" . 
                  tosql($ref_vehicule, "Number") . "," .
                  tosql($date, "Text") . 
            ")";       	
          		$db->query($sSQL);
          		echo '<script>alert("Vous avez saisie le bon numéro : '. $date .'")</script>';
          	}
          } else {
				$date_existe = dlookup("suivie_visite", "count(*)", "date=".tosql($date, "NUMBER")." and id <> ".tosql($id, "Number"));
          	if ($date_existe > 0) {
          		echo "<script>alert('Vous essayer de saisir un bon numéro $date qui éxiste déja !!!')</script>";          	
			} else {          	    	
          		$sSQL = "UPDATE suivie_visite SET "; 
            	$sSQL .= "ref_vehicule = " .  tosql($ref_vehicule, "Number");
            	$sSQL .=",date =" . tosql($date, "Text");
            	$sSQL .= " where id=" .tosql($id, "Number") ."";        	
          		$db->query($sSQL);
          		echo '<script>alert("Vous avez mis à le bon numéro : '. $date .'")</script>';
          	}
          }  
      }
      $tpl->parse("BlockForm", false);
      search();
      //==============================
      function search() {
      //==============================
            global $db;
            global $tpl;
            global $sForm;
            $sActionFileName = "gestion_visite_technique.php";
            $tpl->set_var("ActionPage", $sActionFileName);
            $keyword = strip(get_param("keyword"));
            $tpl->set_var("keyword", tohtml($keyword));
				
				$sSQL = "SELECT * FROM suivie_visite ";			
				if (strlen(trim($keyword)) > 0)
					$sSQL .= "WHERE num_bon LIKE '$keyword%'";
				
				$db->query($sSQL);
				$next_record = $db->next_record();
     
            $i = 1;                          
            while($next_record){ 
            	//WE DISPLAY THE RESULTS
             	$id = $db->f("id");
             	$date = $db->f("date"); 
             	$km = $db->f("km"); 
             	$marque_pneu = $db->f("marque_pneu");
             	$nbr_pneu = $db->f("nbr_pneu");
             	$num_bon = $db->f("num_bon");
             	$observation = $db->f("observation"); 
             	$libVehicule = dlookup("vehicules", "libelle", "id=".tosql($db->f("ref_vehicule"), "NUMBER")); 
             	
             	$next_record = $db->next_record();
             	
                         	$tpl->set_var("id",$id);
                         	$tpl->set_var("date",$date);
					$tpl->set_var("ref_vehicule",$libVehicule);
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
	            $sql = sprintf("DELETE FROM suivie_visite WHERE id = '".$delete."'");
	            $result = mysql_query($sql);    
	            header("location: gestion_visite_technique.php");
	      }			
      }   
   $tpl->pparse("gestion_visite_technique", false);      

?>    
