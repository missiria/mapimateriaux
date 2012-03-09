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
      $km = get_param("km");
      
      //var_dump($_POST);

      $sSQL = "INSERT INTO suivi_gasoil (" . 
                  "num_bon," . 
                  "ref_vehicule," . 
                  "date," . 
                  "qt_littre," . 
                  "km)" . 
            " VALUES (" . 
                  tosql($num_bon, "Number") . "," .
                  tosql($ref_vehicule, "Number") . "," .
                  tosql($date, "Text") . "," .
                  tosql($qt_littre, "Number") . "," .
                  tosql($km, "Number") . 
      ")";
      
      if ($num_bon && $ref_vehicule && $date && $qt_littre && $km) {
                  $db->query($sSQL);
                  echo '<script>alert("Vous avez saisie le bon numéro : '. $num_bon .'")</script>';
            }
      
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
            
            if ($keyword == "") {
                  $query = mysql_query("SELECT *
                                        FROM suivi_gasoil");
                                        
             while($row = mysql_fetch_array( $query )) 
             { 
             //WE DISPLAY THE RESULTS
             $id = $row['id'];
             $date = $row['date']; 
             $km = $row['km']; 
             $qt_littre = $row['qt_littre'];
             $num_bon = $row['num_bon']; 
             $ref_vehicule = $row['ref_vehicule']; 
             
             // VARIABLE WE SET INTO TEMPLATE
             $tpl->set_var("id", $id);
             $tpl->set_var("date", $date);
             $tpl->set_var("km", $km);
             $tpl->set_var("qt_littre", $qt_littre);
             $tpl->set_var("num_bon", $num_bon);
             $tpl->set_var("ref_vehicule", $ref_vehicule);
             $tpl->parse("row_result", true); 
             }
            }
            
            $query = mysql_query("SELECT *
                                  FROM suivi_gasoil 
                                  WHERE num_bon 
                                  LIKE ". $keyword ."");
            while($row = mysql_fetch_array( $query )) 
             { 
             //WE DISPLAY THE RESULTS
             $id = $row['id'];
             $date = $row['date']; 
             $km = $row['km']; 
             $qt_littre = $row['qt_littre'];
             $num_bon = $row['num_bon']; 
             $ref_vehicule = $row['ref_vehicule']; 
             
             // VARIABLE WE SET INTO TEMPLATE
             $tpl->set_var("id", $id);
             $tpl->set_var("date", $date);
             $tpl->set_var("km", $km);
             $tpl->set_var("qt_littre", $qt_littre);
             $tpl->set_var("num_bon", $num_bon);
             $tpl->set_var("ref_vehicule", $ref_vehicule);
             $tpl->parse("row_result", true); 
             } 
            
            /* if ($keyword) {
                  
            $lookup_num_bon = db_fill_array("SELECT date, num_bon, ref_vehicule, qt_littre, km
                                             FROM suivi_gasoil 
                                             WHERE num_bon LIKE ". $keyword ."");
                  echo "test :"; print_r($lookup_num_bon);
                  if(is_array($lookup_num_bon)) {
                        reset($lookup_num_bon);
                        
                        while(list($key, $value) = each($lookup_num_bon)) {
                        
                              if ($value == $keyword) {
	                              $tpl->set_var("ID", $key);
                                    $tpl->set_var("NUM_BON", $value);
                                    $tpl->set_var("DATE", $value);
                                    
	                        } else {
	                              $tpl->set_var("DATE", "");
                                    $tpl->set_var("NUM_BON", "");
                                    $tpl->set_var("DATE", "");
	                        }
                           
                           $tpl->parse("row_result", true);   
	                        
                        }
                  }
            } */
            
            $tpl->parse("block_search", false);
      }
      edit();
      function edit() {
	      $edit = get_param('edit');
	      if ($edit) {
	            $query = mysql_query("SELECT *
                                  FROM suivi_gasoil 
                                  WHERE num_bon 
                                  LIKE ". $keyword ."");
                        
	      }
	  //$tpl->parse("block_edit", false);
      }
      delete();
      function delete() {
	      $delete = get_param('delete');
	      if ($delete) {
	            $sql = sprintf("DELETE FROM suivi_gasoil WHERE id = '".$delete."'");
	            $result = mysql_query($sql);
	            
	      }
	
      }
   
   $tpl->pparse("gestion_gasoil", false);      

?>
