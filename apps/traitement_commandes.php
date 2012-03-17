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
      
      // INTERNE VEHICULE 
      $lookup_vehiculeIn = db_fill_array("SELECT * FROM  vehicule_externe");
      
      if(is_array($lookup_vehiculeIn)) {
      reset($lookup_vehiculeIn);
            while(list($value, $key) = each($lookup_vehiculeIn)) {
              $tpl->set_var("Value_vehiculeIn", $value);
              $tpl->set_var("id_vehiculeIn", $key);
              $tpl->parse("select_vehiculeIn", true);
            }
      }
      // EXTERNE VEHICULE 
      $lookup_vehiculeEx = db_fill_array("SELECT * FROM  vehicules");
      
      if(is_array($lookup_vehiculeEx)) {
      reset($lookup_vehiculeEx);
            while(list($value, $key) = each($lookup_vehiculeEx)) {
              $tpl->set_var("Value_vehiculeEx", $value);
              $tpl->set_var("id_vehiculeEx", $key);
              $tpl->parse("select_vehiculeEx", true);
            }
      }
      global $db;
      global $tpl;
      global $sForm;
      $sActionFileName = "traitement_commandes.php";
      $tpl->set_var("ActionPage", $sActionFileName);
      $id = $_GET["id"];
      
      if (strlen(trim($id))) {
            foreach($_GET as $key => $value){
            echo "<li>$key: $value</li>";
            }
          echo '<script>alert("IT\'S DONE FOR ' .$id. '!")</script>';
      }
			
	$sSQL = "SELECT * FROM commandes GROUP BY date";			
	$db->query($sSQL);
	$next_record = $db->next_record();
	
	//var_dump($_GET);
      
      $i = 1;
      while($next_record){ 
      	//WE DISPLAY THE RESULTS
       	$id = $db->f("id");
       	$date = $db->f("date"); 
            $ref_client = $db->f("ref_client");
       	$qt_produit = $db->f("qt_produit");
       	
       	$qt_liv = get_param("qt_liv");
       	
       	$libclients = dlookup("clients", "nom_resp", "id=".tosql($db->f("ref_client"), "NUMBER")); 
       	
       	$next_record = $db->next_record();
       	$tpl->set_var("id",$id);
       	$tpl->set_var("date",$date);
		$tpl->set_var("ref_client",$libclients);
		
		$tpl->set_var("qt_liv",$qt_liv);
		
		$tpl->set_var("qt_produit",$qt_produit);
		$tpl->set_var("consommation",$consommation);
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
	verifie();
      function verifie() {
	      $verfie = get_param('verfie');
	      if ($verfie) {
	            $sSQL = "INSERT INTO suivi_gasoil (" . 
                  "qt_liv)" .
            	" VALUES (" . 
                  tosql($km_arrive, "Number") . 
     				")";
	            $sql = sprintf("INSERT INTO FROM commandes WHERE id = '". $verfie ."'");
	            echo "ITS DONE !";
	            //$result = mysql_query($sql);    
	            header("location: $sActionFileName");
	      }			
      }   
	send();
      function send() {
	      $send = get_param('send');
	      if (strlen(trim($send))) {
	            $sql = sprintf("INSERT INTO FROM suivi_gasoil WHERE id = '".$send."'");
	            echo "ITS DONE !";
	            //$result = mysql_query($sql);    
	            header("location: $sActionFileName");
	      }			
      }   	
   $tpl->pparse("traitement_commandes", false);   

?>
