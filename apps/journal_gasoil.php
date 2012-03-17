 <?php
      include ("header.php");
      $pWindow = "journal_gasoil";
      $filename = "journal_gasoil.php";
      $template_filename = "journal_gasoil.html";

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "journal_gasoil");

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
      $km = get_param("km");
      
      $from = get_param("from");
      $to = get_param("to");
      
      //var_dump($_POST);
      
      search();
      //==============================
      function search() {
      //==============================
            global $db;
            global $tpl;
            global $sForm;
            $sActionFileName = "journal_gasoil.php";
            $tpl->set_var("ActionPage", $sActionFileName);
            $ref_vehicule = strip(get_param("ref_vehicule"));
            $tpl->set_var("ref_vehicule", tohtml($ref_vehicule));
            
            $from = strip(get_param("from"));
            $to = strip(get_param("to"));
            $tpl->set_var("from", tohtml($from));
            $tpl->set_var("to", tohtml($to));
				
				$sSQL = "SELECT * FROM suivi_gasoil ";			
				if ($from && $to)
					$sSQL .= "WHERE date BETWEEN ".tosql($from, "TEXT")." AND ".tosql($to, "TEXT");		
				
				$db->query($sSQL);
				$next_record = $db->next_record();

            while($next_record){ 
            	//WE DISPLAY THE RESULTS
             	$id = $db->f("id");
             	$date = $db->f("date"); 
             	$km_depart = $db->f("km_depart"); 
             	$km_arrive = $db->f("km_arrive");
             	$parcours = $km_arrive - $km_depart;
             	$qt_littre = $db->f("qt_littre");
             	$num_bon = $db->f("num_bon");
             	
             	// Calcul the consommation !
             	$total = $qt_littre / $parcours * 100;
             	$consommation = round($total, 2);
             	$libVehicule = dlookup("vehicules", "libelle", "id=".tosql($db->f("ref_vehicule"), "NUMBER")); 
             	
             	$next_record = $db->next_record();
                   	$tpl->set_var("id",$id);
                   	$tpl->set_var("date",$date);
				$tpl->set_var("num_bon",$num_bon);
				$tpl->set_var("km_depart",$km_depart);
				$tpl->set_var("km_arrive",$km_arrive);
				$tpl->set_var("parcours",$parcours);
				$tpl->set_var("qt_littre",$qt_littre);
				$tpl->set_var("consommation",$consommation);
				$tpl->set_var("ref_vehicule",$libVehicule);
        
            	$tpl->parse("row_result", true);
      		}
      		if ($i == 1){
  					$tpl->parse("Norow_result",false);
  					$tpl->set_var("row_result","");
  				} else {
      			$tpl->set_var("Norow_result","");
      		}
				$tpl->parse("block_search", false); 		
      }   
   $tpl->pparse("journal_gasoil", false);      

?>
