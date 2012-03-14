 <?php
      include ("header.php");
      $pWindow = "commandes";
      $filename = "traitement_commandes.php";
      $template_filename = "traitement_commandes.html";

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "traitement_commandes");

      $tpl->load_file("../apps/footer.html", "Footer");

      $sheader = $tplheader->return_var("Header");
      $tpl->set_var("Header",$sheader);
      $tpl->parse("Footer", false);

      $tpl->set_var("FileName", $filename);
      
      // WE CALL THE FUNCTION OF SEARCH THE COMMANDES !!
      search();
      // WE HAVE A FUNCTION OF TRAITEMENT OF COMMANDES !!
      function search() {
            global $db;
            global $tpl;
            global $sForm;
            $sActionFileName = "traitement_commandes.php";
            $tpl->set_var("ActionPage", $sActionFileName);
				
		$sSQL = "SELECT * FROM commandes GROUP BY date";			
		$db->query($sSQL);
		$next_record = $db->next_record();
		
		//var_dump($sSQL);
            //$i = 1;
            
            while($next_record){ 
            	//WE DISPLAY THE RESULTS
             	$id = $db->f("id");
             	$date = $db->f("date"); 
                  $ref_client = $db->f("ref_client");
             	$qt_littre = $db->f("qt_produit");
             	
             	
             	// Calcul the consommation !
             	$total = $qt_littre / $parcours * 100;
             	$consommation = round($total, 2);
             	$libclients = dlookup("clients", "nom_resp", "id=".tosql($db->f("ref_client"), "NUMBER")); 
             	
             	$next_record = $db->next_record();
                   	$tpl->set_var("id",$id);
                   	$tpl->set_var("date",$date);
				$tpl->set_var("ref_client",$libclients);
				
				$tpl->set_var("qt_produit",$qt_littre);
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
   $tpl->pparse("traitement_commandes", false);      

?>
