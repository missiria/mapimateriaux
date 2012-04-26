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
      $ref = get_param("ref");
      $id = get_param("id");
      $fldcarac_prod = get_param("carac_prod");
      $fldref_parent = get_param("ref_parent");
      $fldtype_produit = get_param("type_produit");
      
      if ($produit && $ref && !$id & $_POST) {
            $sSQL = "INSERT INTO produits (" . 
                  "libelle," . 
                  "caracteristique," . 
                  "ref," . 
                  "ref_parent," . 
                  "type_produit)" .
            " VALUES (" . 
                  tosql($produit, "Text") . "," .
                  tosql($fldcarac_prod, "Text") . "," .
                  tosql($ref, "Text") . "," .
                  tosql($fldref_parent, "Number") . "," .
                  tosql($fldtype_produit, "Number") . 
            ")";       	
          		$db->query($sSQL);
          		echo '<script>alert("Vous avez saisie le bon numéro : '. $produit .'")</script>';
          		
          } else if ($id && $_POST) {          	    	
          		$sSQL = "UPDATE produits SET "; 
            	$sSQL .= "libelle = " . tosql($produit, "Text");
            	$sSQL .= ",caracteristique = " . tosql($fldcarac_prod, "Text");
            	$sSQL .= ",ref_parent = " . tosql($fldref_parent, "Number");
            	$sSQL .= ",type_produit = " . tosql($fldtype_produit, "Number");
            	$sSQL .= ", ref = " . tosql($ref, "Text");
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
                   	
		$sSQL = "SELECT * 
				FROM produits 
				ORDER 
				BY libelle 
				ASC ";			
		             	
		$db->query($sSQL);
		$next_record = $db->next_record();
     
            $i = 1;                          
            while($next_record) { 
            	//WE DISPLAY THE RESULTS
            	
            	$id = $db->f("id");
             	
             	$libelle = $db->f("libelle");
             	$ref = $db->f("ref"); 
             	$carac = $db->f("caracteristique"); 
             	$parent = $db->f("ref_parent"); 
             	$type = $db->f("type_produit"); 
             	
             	$next_record = $db->next_record();
             	
             	$tpl->set_var("id",$id);
			
			$tpl->set_var("libelle",$libelle);
			$tpl->set_var("ref",$ref);
			$tpl->set_var("carac",$carac);
			$tpl->set_var("ref_parent",$parent);
			$tpl->set_var("type_produit",$type);
			
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
 
	  $lookup_produits = db_fill_array("SELECT id, libelle FROM produits");
	  
      if(is_array($lookup_produits)) {
      reset($lookup_produits);
            while(list($value, $key) = each($lookup_produits)) {
              $tpl->set_var("Value_prod", $key);
              $tpl->set_var("id_prod", $value);
              $tpl->parse("select_produit", true);
            }
      }
	  
      $tpl->parse("BlockForm", false);
      $tpl->pparse("product", false);
?>
