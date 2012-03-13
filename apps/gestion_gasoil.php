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
      
      $lookup_vehicule = db_fill_array("SELECT * FROM  vehicules");
      
      if(is_array($lookup_vehicule)) {
      reset($lookup_vehicule);
            while(list($value, $key) = each($lookup_vehicule)) {
              $tpl->set_var("Value_vehicule", $value);
              $tpl->set_var("id_vehicule", $key);
              $tpl->parse("select_vehicule", true);
            }
      }
      
      $num_bon = get_param("num_bon");
      $ref_vehicule = get_param('ref_vehicule');
      $date = get_param("date");
      $qt_littre = get_param("qt_littre");
      $km_depart = get_param("km_depart");
      $km_arrive = get_param("km_arrive");
      $id = $_POST["id"];
      
      //var_dump($_POST);
           
      if ($num_bon && $ref_vehicule && $date && $qt_littre && $km_depart && $km_arrive) {
          if (strlen(trim($id))==0){
          	$num_bon_existe = dlookup("suivi_gasoil", "count(*)", "num_bon=".tosql($num_bon, "NUMBER"));

          	if ($num_bon_existe > 0) {
          		echo "<script>alert('Vous essayer de saisir un bon numéro $num_bon qui éxiste déja !!!')</script>";  
          	} else {   	          	
          		$sSQL = "INSERT INTO suivi_gasoil (" . 
                  "num_bon," . 
                  "ref_vehicule," . 
                  "date," . 
                  "qt_littre," . 
                  "km_depart" . 
                  "km_arrive)" .
            	" VALUES (" . 
                  tosql($num_bon, "Number") . "," .
                  tosql($ref_vehicule, "Number") . "," .
                  tosql($date, "Text") . "," .
                  tosql($qt_littre, "Number") . "," .
                  tosql($km_depart, "Number") . "," .
                  tosql($km_arrive, "Number") . 
     				")";          	
          		$db->query($sSQL);
          		echo '<script>alert("Vous avez saisie le bon numéro : '. $num_bon .'")</script>';
          	}
          } else {
				$num_bon_existe = dlookup("suivi_gasoil", "count(*)", "num_bon=".tosql($num_bon, "NUMBER")." and id <> ".tosql($id, "Number"));
          	if ($num_bon_existe > 0) {
          		echo "<script>alert('Vous essayer de saisir un bon numéro $num_bon qui éxiste déja !!!')</script>";          	
				} else {          	    	
          		$sSQL = "UPDATE suivi_gasoil set "; 
            	$sSQL .= "num_bon = " . tosql($num_bon, "Number");
            	$sSQL .= ",ref_vehicule = " .  tosql($ref_vehicule, "Number");
            	$sSQL .=",date =" . tosql($date, "Text");
            	$sSQL .=",qt_littre =" . tosql($qt_littre, "Number");
            	$sSQL .= ",km_depart =". tosql($km_depart, "Number");
            	$sSQL .= ",km_arrive =". tosql($km_arrive, "Number");
            	$sSQL .= " where id=" .tosql($id, "Number") ."";        	
          		$db->query($sSQL);
          		echo '<script>alert("Vous avez mis à le bon numéro : '. $num_bon .'")</script>';
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
            $sActionFileName = "gestion_gasoil.php";
            $tpl->set_var("ActionPage", $sActionFileName);
            $keyword = strip(get_param("keyword"));
            $tpl->set_var("keyword", tohtml($keyword));
				
				$sSQL = "SELECT * FROM suivi_gasoil ";			
				if (strlen(trim($keyword)) > 0)
					$sSQL .= "WHERE num_bon LIKE '$keyword%'";
				
				$db->query($sSQL);
				$next_record = $db->next_record();
     
            $i = 1;                          
            while($next_record){ 
            	//WE DISPLAY THE RESULTS
             	$id = $db->f("id");
             	$date = $db->f("date"); 
             	$km_depart = $db->f("km_depart"); 
             	$km_arrive = $db->f("km_arrive");
             	$qt_littre = $db->f("qt_littre");
             	$num_bon = $db->f("num_bon"); 
             	$libVehicule = dlookup("vehicules", "libelle", "id=".tosql($db->f("ref_vehicule"), "NUMBER")); 
             	
             	$next_record = $db->next_record();
             	
             	$tpl->set_var("id",$id);
             	$tpl->set_var("date",$date);
					$tpl->set_var("num_bon",$num_bon);
					$tpl->set_var("km_depart",$km_depart);
					$tpl->set_var("km_arrive",$km_arrive);
					$tpl->set_var("qt_littre",$qt_littre);
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
	            $sql = sprintf("DELETE FROM suivi_gasoil WHERE id = '".$delete."'");
	            $result = mysql_query($sql);    
	            header("location: gestion_gasoil.php");
	      }			
      }   
   $tpl->pparse("gestion_gasoil", false);      

?>
