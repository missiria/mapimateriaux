 <?php
      include ("header.php");
      $pWindow = "product";
      $filename = "product.php";
      $template_filename = "product.html";

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "product");

      $tpl->load_file("../apps/footer.html", "Footer");

      $sheader = $tplheader->return_var("Header");
      $tpl->set_var("Header",$sheader);
      $tpl->parse("Footer", false);

      $tpl->set_var("FileName", $filename);

      $produit = get_param("produit");
      $caracteristique = get_param("caracteristique");
      $ref_product = get_param("ref_product");
      $id = get_param("id");
      
      if ($produit && $caracteristique && $ref_product && !$id) {
            $sSQL = "INSERT INTO produits (" . 
                  "libelle," . 
                  "caracteristique," .
                  "ref_product)" .
            " VALUES (" . 
                  tosql($produit, "Text") . "," .
                  tosql($caracteristique, "Text") . "," .
                  tosql($ref_product, "Text") . 
            ")";       	
          		$db->query($sSQL);
          		echo '<script>alert("Vous avez saisie le bon numéro : '. $produit .'")</script>';
          		
          } else if ($id) {          	    	
          		$sSQL = "UPDATE produits SET "; 
            	$sSQL .= "libelle = " . tosql($produit, "Text");
            	$sSQL .= ", caracteristique = " . tosql($caracteristique, "Text");
            	$sSQL .= ", ref_product = " . tosql($ref_product, "Text");
            	$sSQL .= " where id=" .tosql($id, "Number") ."";        	
          		$db->query($sSQL);
          		echo '<script>alert("Vous avez mis à le bon numéro")</script>';
          	}
        search();
      //==============================
      function search() {
      //==============================
            global $db;
            global $tpl;
            global $sForm;
            $sActionFileName = "product.php";
            $tpl->set_var("ActionPage", $sActionFileName);
            $keyword = strip(get_param("keyword"));
            $tpl->set_var("keyword", tohtml($keyword));
                   	
		$sSQL = "SELECT * FROM produits ";			
		             	
		$db->query($sSQL);
		$next_record = $db->next_record();
     
            $i = 1;                          
            while($next_record) { 
            	//WE DISPLAY THE RESULTS
            	
            	$id = $db->f("id");
             	
             	$libelle = $db->f("libelle");
             	$caracteristique = $db->f("caracteristique");
             	$ref_product = $db->f("ref_product"); 
             	
             	$next_record = $db->next_record();
             	
             	$tpl->set_var("id",$id);
			
			$tpl->set_var("libelle",$libelle);
			$tpl->set_var("caracteristique",$caracteristique);
			$tpl->set_var("ref_product",$ref_product);
			
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
	            $sql = sprintf("DELETE FROM produits WHERE id = '".$delete."'");
	            $result = mysql_query($sql);    
	            header("location: product.php");
	      }			
      }
      $tpl->pparse("product", false);
?>
