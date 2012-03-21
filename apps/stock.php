 <?php
      include ("header.php");
      $pWindow = "stock";
      $filename = "stock.php";
      $template_filename = "stock.html";

      $sAction = get_param("FormAction");
      $sForm = get_param("FormName");

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "stock");

      $tpl->load_file("../apps/footer.html", "Footer");

      $sheader = $tplheader->return_var("Header");
      $tpl->set_var("Header",$sheader);
      $tpl->parse("Footer", false);

      $tpl->set_var("FileName", $filename);
      
      ////////////////////////////////////////////
      // WE DISPLAY THE TOTAL OF FIELDS STOCK !//
      ///////////////////////////////////////////
      $total_beton = db_fill_array("SELECT sum(beton) AS sommeBeton FROM  stock");
      
      if(is_array($total_beton)) {
      reset($total_beton);
            while(list($value, $key) = each($total_beton)) {
                  $tpl->set_var("total_beton",$value);
                  $tpl->parse("Total", false);
            }
      }
      
      $total_sable1 = db_fill_array("SELECT sum(sable_1) AS sommeSable1 FROM  stock");
      
      if(is_array($total_sable1)) {
      reset($total_sable1);
            while(list($value, $key) = each($total_sable1)) {
                  $tpl->set_var("total_sable1",$value);
                  $tpl->parse("Total", false);
            }
      }
      
      $total_sable2 = db_fill_array("SELECT sum(sable_2) AS sommeSable2 FROM  stock");
      
      if(is_array($total_sable2)) {
      reset($total_sable2);
            while(list($value, $key) = each($total_sable2)) {
                  $tpl->set_var("total_sable2",$value);
                  $tpl->parse("Total", false);
            }
      }
      
      $beton = get_param("beton");
      $sable_1 = get_param("sable_1");
      $sable_2 = get_param("sable_2");
      $id = $_POST['id'];
      
      //var_dump($_POST);
      
      if ($beton && $sable_1 && $sable_2 && !$id) { 	          	
                		$sSQL = "INSERT INTO stock (" . 
                        "beton," . 
                        "sable_1," . 
                        "sable_2)" .
                  " VALUES (" . 
                        tosql($beton, "Number") . "," .
                        tosql($sable_1, "Number") . "," .
                        tosql($sable_2, "Number") . 
                  ")";       	
                		$db->query($sSQL);
                		echo '<script>alert("Vous avez saisie un nouveau stock")</script>';
                		header("location: productivite.php");
                		
                } else if ($id) {          	    	
                		$sSQL = "UPDATE stock SET "; 
                  	$sSQL .= "beton = " . tosql($beton, "Number");
                  	$sSQL .=",sable_1 =" . tosql($sable_1, "Number");
                  	$sSQL .=",sable_2 =" . tosql($sable_2, "Number");
                  	$sSQL .= " where id=" .tosql($id, "Number") ."";        	
                		$db->query($sSQL);
                		echo '<script>alert("Vous avez ajouté un stock !!")</script>';
                	}
      $tpl->parse("BlockForm", false);
      search();
      //==============================
      function search() {
      //==============================
            global $db;
            global $tpl;
            global $sForm;
            $sActionFileName = "stock.php";
            $tpl->set_var("ActionPage", $sActionFileName);
            $keyword = strip(get_param("keyword"));
            $tpl->set_var("keyword", tohtml($keyword));
				
				$sSQL = "SELECT * FROM stock ";			
				if (strlen(trim($keyword)) > 0)
					$sSQL .= "WHERE beton LIKE '$keyword%'";
				
				$db->query($sSQL);
				$next_record = $db->next_record();
     
            $i = 1;                          
            while($next_record){ 
            	//WE DISPLAY THE RESULTS
             	$id = $db->f("id");
             	$beton = $db->f("beton");
             	$sable_1 = $db->f("sable_1");
             	$sable_2 = $db->f("sable_2"); 
             	
             	$next_record = $db->next_record();
             	
                         	$tpl->set_var("id",$id);
					$tpl->set_var("beton",$beton);
					$tpl->set_var("sable_1",$sable_1);
					$tpl->set_var("sable_2",$sable_2);
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
	            $sql = sprintf("DELETE FROM stock WHERE id = '".$delete."'");
	            $result = mysql_query($sql);    
	            header("location: stock.php");
	      }			
      } 
   $tpl->pparse("stock", false);      

?>
