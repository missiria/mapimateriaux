 <?php
      include ("header.php");
      $pWindow = "journal_vidanges";
      $filename = "journal_vidanges.php";
      $template_filename = "journal_vidanges.html";

      $sAction = get_param("FormAction");
      $sForm = get_param("FormName");

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "journal_vidanges");

      $tpl->load_file("../apps/footer.html", "Footer");

      $sheader = $tplheader->return_var("Header");
      $tpl->set_var("Header",$sheader);
      $tpl->parse("Footer", false);

      $tpl->set_var("FileName", $filename);
      
      $ref_vehicule = get_param('ref_vehicule');
      $num_bon = get_param("num_bon");
      $date = get_param("date");
      $type_vidange = get_param("type_vidange");
      $km_depart = get_param("km_depart");
      $km_arrive = get_param("km_arrive");
      $observations = get_param("observations");
      $id = $_POST['id'];
      
      //var_dump($_POST);
      
      search();
      //==============================
      function search() {
      //==============================
            global $db;
            global $tpl;
            global $sForm;
            $sActionFileName = "gestion_vidanges.php";
            $tpl->set_var("ActionPage", $sActionFileName);
            $keyword = strip(get_param("keyword"));
            $tpl->set_var("keyword", tohtml($keyword));
				
				$sSQL = "SELECT * FROM suivi_vidange ";			
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
             	$type_vidange = $db->f("type_vidange");
             	$num_bon = $db->f("num_bon");
             	$observations = $db->f("observations"); 
             	$libVehicule = dlookup("vehicules", "libelle", "id=".tosql($db->f("ref_vehicule"), "NUMBER")); 
             	
             	$next_record = $db->next_record();
             	
                         	$tpl->set_var("id",$id);
                         	$tpl->set_var("date",$date);
					$tpl->set_var("num_bon",$num_bon);
					$tpl->set_var("km_depart",$km_depart);
					$tpl->set_var("km_arrive",$km_arrive);
					$tpl->set_var("parcours",$parcours);
					$tpl->set_var("type_vidange",$type_vidange);
					$tpl->set_var("observations",$observations);
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
   $tpl->pparse("journal_vidanges", false);      

?>
