<?php
      include ("header.php");
      $pWindow = "journal_pneumatique";
      $filename = "journal_pneumatique.php";
      $template_filename = "journal_pneumatique.html";

      $sAction = get_param("FormAction");
      $sForm = get_param("FormName");

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "journal_pneumatique");

      $tpl->load_file("../apps/footer.html", "Footer");

      $sheader = $tplheader->return_var("Header");
      $tpl->set_var("Header",$sheader);
      $tpl->parse("Footer", false);

      $tpl->set_var("FileName", $filename);
      
      $num_bon = get_param("num_bon");
      $ref_vehicule = get_param('ref_vehicule');
      $date = get_param("date");
      $marque_pneu = get_param("marque_pneu");
      $nbr_pneu = get_param("nbr_pneu");
      $km_depart = get_param("km_depart");
      $km_arrive = get_param("km_arrive");
      $observation = get_param("observation");
      $id = $_POST["id"];
      
      //var_dump($_POST);

      search();
      //==============================
      function search() {
      //==============================
            global $db;
            global $tpl;
            global $sForm;
            $sActionFileName = "gestion_pneumatique.php";
            $tpl->set_var("ActionPage", $sActionFileName);
            $keyword = strip(get_param("keyword"));
            $tpl->set_var("keyword", tohtml($keyword));
				
				$sSQL = "SELECT * FROM suivie_pneumatique ";			
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
             	$parcours = $km_arrive - $km_depart;
             	$marque_pneu = $db->f("marque_pneu");
             	$nbr_pneu = $db->f("nbr_pneu");
             	$num_bon = $db->f("num_bon");
             	$observation = $db->f("observation"); 
             	$libVehicule = dlookup("vehicules", "libelle", "id=".tosql($db->f("ref_vehicule"), "NUMBER")); 
             	
             	$next_record = $db->next_record();
             	
         	$tpl->set_var("id",$id);
         	$tpl->set_var("date",$date);
		$tpl->set_var("num_bon",$num_bon);
		$tpl->set_var("km_depart",$km_depart);
		$tpl->set_var("km_arrive",$km_arrive);
		$tpl->set_var("parcours",$parcours);
		$tpl->set_var("marque_pneu",$marque_pneu);
		$tpl->set_var("nbr_pneu",$nbr_pneu);
		$tpl->set_var("observation",$observation);
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
   $tpl->pparse("journal_pneumatique", false);      

?>    
