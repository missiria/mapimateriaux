 <?php
      include ("header.php");
      $pWindow = "productivite";
      $filename = "productivite.php";
      $template_filename = "productivite.html";
      //check_secure();
      $sAction = get_param("FormAction");
      $sForm = get_param("FormName");

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "productivite");

      $tpl->load_file("../apps/footer.html", "Footer");

      $sheader = $tplheader->return_var("Header");
      $tpl->set_var("Header",$sheader);
      $tpl->parse("Footer", false);

      $tpl->set_var("FileName", $filename);
      $date = date("Y-m-d");
      $tpl->set_var("date", $date);
      $date = get_param("date");
      $ml_beton = get_param("ml_beton");
      $ml_sable1 = get_param("ml_sable1");
      $ml_sable2 = get_param("ml_sable2");
      
      $ref_produit = get_param("ref_produit");
      
      $produit_total = get_param("produit_total");
      $produit_casse = get_param("produit_casse");
      $produit_reel = $produit_total - $produit_casse;
      $id = $_POST['id'];
      
      //////////////////////////////////////////////////
      // WE CALCUL THE SUM() FROM THE OF EACH FIELD !//
      ////////////////////////////////////////////////
      /*
      $restTtotal_beton = db_fill_array("SELECT sum(reste_beton) AS sommeResteBeton FROM  productivite");
      
      if(is_array($restTtotal_beton)) {
      reset($restTtotal_beton);
            while(list($value, $key) = each($restTtotal_beton)) {
                  $restTtotal_beton = $value;
            }
      }
      
      $restTtotal_sable1 = db_fill_array("SELECT sum(reste_sable1) AS sommeResteSable1 FROM  productivite");
      
      if(is_array($restTtotal_sable1)) {
      reset($restTtotal_sable1);
            while(list($value, $key) = each($restTtotal_sable1)) {
                  $restTtotal_sable1 = $value;
            }
      }
      
      $restTtotal_sable2 = db_fill_array("SELECT sum(reste_sable2) AS sommeResteSable2 FROM  productivite");
      
      if(is_array($restTtotal_sable2)) {
      reset($restTtotal_sable2);
            while(list($value, $key) = each($restTtotal_sable2)) {
                  $restTtotal_sable2 = $value;
            }
      }
      */
      /////////////////////////////////////////////
      // WE DISPLAY THE TOTAL OF FIELDS STOCK !///
      ///////////////////////////////////////////
      $total_beton = db_fill_array("SELECT sum(beton) AS sommeBeton FROM  stock");
      
      if(is_array($total_beton)) {
      reset($total_beton);
            while(list($value, $key) = each($total_beton)) {
                  $total_beton = $value;
            }
      }
      
      $total_sable1 = db_fill_array("SELECT sum(sable_1) AS sommeBeton FROM  stock");
      
      if(is_array($total_sable1)) {
      reset($total_sable1);
            while(list($value, $key) = each($total_sable1)) {
                  $total_sable1 = $value;
            }
      }
      
      $total_sable2 = db_fill_array("SELECT sum(sable_2) AS sommeBeton FROM  stock");
      
      if(is_array($total_sable2)) {
      reset($total_sable2);
            while(list($value, $key) = each($total_sable2)) {
                  $total_sable2 = $value;
            }
      }
      
      //////////////////////////////
      // WE CALCUL THE REMAINDER///
      ////////////////////////////
      $total_beton_pro = ($total_beton - $ml_beton) + $restTtotal_beton;
      $tpl->set_var("total_beton", $total_beton_pro);
      
      //echo "<h1>tesssssst : $ml_beton</h1>";
      
      $total_sable1_pro = ($total_sable1 - $ml_sable1) + $restTtotal_sable1;
      $tpl->set_var("total_sable1", $total_sable1_pro);
      
      $total_sable2_pro = ($total_sable2 - $ml_sable2) + $restTtotal_sable2;
      $tpl->set_var("total_sable2", $total_sable2_pro);
      
      $lookup_produits = db_fill_array("SELECT libelle,id FROM  produits");
      
      if(is_array($lookup_produits)) {
      reset($lookup_produits);
            while(list($value, $key) = each($lookup_produits)) {
              $tpl->set_var("Value_produit", $value);
              $tpl->set_var("id_produit", $key);
              $tpl->parse("select_produits", true);
            }
      }
      
      //var_dump($_POST);
      
      /*
      echo "<h1> total beton : $total_beton</h1>";
      echo "<h1> total sable 1 : $total_sable1</h1>";
      echo "<h1> total sable 2 : $total_sable2</h1>";
      
      echo "<hr>";
      echo "<h1> melange beton : $ml_beton</h1>";
      echo "<h1> melange sable 1 : $ml_sable1</h1>";
      echo "<h1> melange sable 2 : $ml_sable2</h1>";
     
      echo "<hr>";
      echo "<h1> Reste beton : $reste_beton</h1>";
      echo "<h1> Reste sable 1 : $reste_sable1</h1>";
      echo "<h1> Reste sable 2 : $reste_sable2</h1>"; 
      */
      
      
      $reste_beton = $total_beton - $ml_beton;
      $reste_sable1 = $total_sable1 - $ml_sable1;
      $reste_sable2 = $total_sable2 - $ml_sable2;
      
      $tpl->set_var("total_beton", $reste_beton);
      $tpl->set_var("total_sable2", $reste_sable1);
      $tpl->set_var("total_sable2", $reste_sable2);
      
      if ($date && $ml_beton && $ml_sable1 && $ml_sable2 && $ref_produit && $produit_total && $produit_casse && $produit_reel && $reste_beton && $reste_sable1 && $reste_sable2 && !$id) 
      { 	          	
                		$sSQL = "INSERT INTO productivite (" . 
                        "date_operation," . 
                        "reste_beton," .
                        "reste_sable1," .
                        "reste_sable2," .
                        "ml_beton," . 
                        "ml_sable1," .
                        "ml_sable2," .
                        "ref_produit," .
                        "produit_total," .
                        "produit_casse," .
                        "produit_reel)" .
                  " VALUES (" . 
                        tosql($date, "Text") . "," .
                        tosql($reste_beton, "Text") . "," .
                        tosql($reste_sable1, "Text") . "," .
                        tosql($reste_sable2, "Text") . "," .
                        tosql($ml_beton, "Number") . "," .
                        tosql($ml_sable1, "Number") . "," .
                        tosql($ml_sable2, "Number") . "," .
                        tosql($ref_produit, "Number") . "," .
                        tosql($produit_total, "Number") . "," .
                        tosql($produit_casse, "Number") . "," .
                        tosql($produit_reel, "Number") . 
                  ")";       	
                		$db->query($sSQL);
                		echo '<script>alert("Vous avez saisie le bon numéro : '. $ref_produit .'")</script>';
                		
                } else if ($id) {          	    	
                		$sSQL = "UPDATE productivite SET "; 
                  	$sSQL .= "date_operation = " . tosql($date, "Text");
                  	
                  	$sSQL .=",ml_beton = " . tosql($ml_beton, "Number");
                  	$sSQL .=",ml_sable1 =" . tosql($ml_sable1, "Number");
                  	$sSQL .=",ml_sable2 =" . tosql($ml_sable2, "Number");
                  	
                  	$sSQL .=",reste_beton = " . tosql($ml_beton, "Number");
                  	$sSQL .=",reste_sable1 =" . tosql($ml_sable1, "Number");
                  	$sSQL .=",reste_sable2 =" . tosql($ml_sable2, "Number");
                  	
                  	$sSQL .=",produit_total = " . tosql($produit_total, "Number");
                  	$sSQL .=",produit_casse =" . tosql($produit_casse, "Number");
                  	$sSQL .=",produit_reel =" . tosql($produit_reel, "Number");
                  	
                  	$sSQL .= " where id=" .tosql($id, "Number") ."";        	
                		$db->query($sSQL);
                		echo '<script>alert("Vous avez mis à le bon numéro")</script>';
                	}
   $tpl->parse("BlockForm", false);
   
      search();
      //==============================
      function search() {
      //==============================
            global $db;
            global $tpl;
            global $sForm;
            $sActionFileName = "productivite.php";
            $tpl->set_var("ActionPage", $sActionFileName);
            $keyword = strip(get_param("keyword"));
            $tpl->set_var("keyword", tohtml($keyword));
                   	
		$sSQL = "SELECT * FROM productivite ";			
		/* if (strlen(trim($keyword)) > 0)
			$sSQL .= "WHERE keyword LIKE '$keyword%'"; */
		             	
       	
		$db->query($sSQL);
		$next_record = $db->next_record();
     
            $i = 1;                          
            while($next_record) { 
            	//WE DISPLAY THE RESULTS
            	
            	$id = $db->f("id");
            	
             	$date_operation = $db->f("date_operation");
             	
             	$reste_beton = $db->f("reste_beton");
             	$reste_sable1 = $db->f("reste_sable1");
             	$reste_sable2 = $db->f("reste_sable2"); 
             	
             	$ml_beton = $db->f("ml_beton");
             	$ml_sable1 = $db->f("ml_sable1"); 
             	$ml_sable2 = $db->f("ml_sable2"); 
             	
             	$produit_total = $db->f("produit_total");
             	$produit_casse = $db->f("produit_casse");
             	$produit_reel = $db->f("produit_reel");
             	
             	$produits = dlookup("produits", "libelle", "id=".tosql($db->f("ref_produit"), "NUMBER"));
             	
             	$next_record = $db->next_record();
             	
             	$tpl->set_var("id",$id);
             	
             	$tpl->set_var("date_operation",$date_operation);
             	
			$tpl->set_var("reste_beton",$reste_beton);
			$tpl->set_var("reste_sable1",$reste_sable1);
			$tpl->set_var("reste_sable2",$reste_sable2);
			
			$tpl->set_var("ml_beton",$ml_beton);
			$tpl->set_var("ml_sable1",$ml_sable1);
			$tpl->set_var("ml_sable2",$ml_sable2);
			
			$tpl->set_var("produit_total",$produit_total);
			$tpl->set_var("produit_casse",$produit_casse);
			$tpl->set_var("produit_reel",$produit_reel);
			
			$tpl->set_var("produits",$produits);
			
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
	            $sql = sprintf("DELETE FROM productivite WHERE id = '".$delete."'");
	            $result = mysql_query($sql);    
	            header("location: productivite.php");
	      }			
      } 
   $tpl->pparse("productivite", false);      

?>
