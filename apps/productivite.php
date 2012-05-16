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
        date_default_timezone_set("Europe/Berlin");
        $date = date("Y-m-d");
        $tpl->set_var("date", $date);
        $date = get_param("date");

		$sSQL = "SELECT produits.libelle as lib, 
		         produits.id as idProd, 
		         SUM( qt_operation ) as total";
		$sSQL .= " FROM operation_produit";
		$sSQL .= " INNER JOIN produits ON operation_produit.`ref_produit` = produits.id";
		$sSQL .= " WHERE produits.type_produit =1";
		$sSQL .= " GROUP BY produits.libelle, produits.id";
		
			    
		$db->query($sSQL);
		$next_record = $db->next_record();
		$arrProdPrim = array();
		$arrIdProd = array();
        while($next_record) {
		$strLibProd = $db->f("lib");
		$arrIdProd[] = $db->f("idProd");
		
		$next_record = $db->next_record();
		$arrProdPrim[] = get_param(preg_replace("/ /","_",$strLibProd));
	}
		
      $ref_produit = get_param("ref_produit");
      $machine = get_param("machine");
      $produit_total = get_param("produit_total");
      $produit_casse = get_param("produit_casse");
      $produit_reel = $produit_total - $produit_casse;
      $id = $_POST['id'];

      /////////////////////////////////////////////
      // WE DISPLAY THE TOTAL OF FIELDS STOCK !///
      ///////////////////////////////////////////
		$db->query($sSQL);
		$next_record = $db->next_record();
		
		$result	= array();
		$i = 0;
        while($next_record) { 
			$strLibProd = $db->f("lib"); 
			$strTotalProd = $db->f("total");
			$result[] = $strTotalProd;
			
			$next_record = $db->next_record();
            $i++;
			$tpl->set_var("LibelleProd",$strLibProd);
			$tpl->set_var("LibelleProdForm",preg_replace("/ /","_",$strLibProd));
			$tpl->set_var("total_beton",$strTotalProd);
			
			$tpl->parse("BlockProduitPrimaire", true);
			$tpl->parse("BlockProduitPrimaireForm", true);
		}
      
		if ($i > 0){
			$tpl->set_var("BlockNoProduitPrimaire", "");
			$tpl->set_var("BlockNoProduitPrimaireForm", "");
        } else {
			$tpl->set_var("BlockProduitPrimaire", "");
			$tpl->set_var("BlockProduitPrimaireForm", "");
			$tpl->parse("BlockNoProduitPrimaire", false);
			$tpl->parse("BlockNoProduitPrimaireForm", false);
		}

      $total_beton_pro = ($total_beton - $result[0]) + $restTtotal_beton;
      $tpl->set_var("total_beton", $total_beton_pro);
      
      $total_sable1_pro = ($total_sable1 - $result[1]) + $restTtotal_sable1;
      $tpl->set_var("total_sable1", $total_sable1_pro);
      
      $total_sable2_pro = ($total_sable2 - $result[2]) + $restTtotal_sable2;
      $tpl->set_var("total_sable2", $total_sable2_pro);
      
	  $total_sable3_pro = ($total_sable2 - $result[3]) + $restTtotal_sable3;
      $tpl->set_var("total_sable3", $total_sable3_pro);
      
      $lookup_produits = db_fill_array("SELECT libelle,id FROM  produits where type_produit = 2");
      
      if(is_array($lookup_produits)) {
      reset($lookup_produits);
            while(list($value, $key) = each($lookup_produits)) {
              $tpl->set_var("Value_produit", $value);
              $tpl->set_var("id_produit", $key);
              $tpl->parse("select_produits", true);
            }
      }
      
      //var_dump($_POST);
      
	  for($i = 0; $i < count($arrProdPrim) ; $i++){
		$reste_mat[] = $result[$i] - $arrProdPrim[$i];
	  }

    if ($date && count($arrProdPrim) && $ref_produit &&  $machine &&$produit_total && $produit_casse && $produit_reel && count($reste_mat) && !$id){ 	          	
		$sSQL = "INSERT INTO productivite (" . 
			        "date_operation," . 
			        "reste_beton," .
			        "reste_sable1," .
			        "reste_sable2," .
			        "reste_sable3," .
			        "ml_beton," . 
			        "ml_sable1," .
			        "ml_sable2," .
			        "ml_sable3," .
			        "ref_produit," .
			        "machine," .
			        "produit_total," .
			        "produit_casse," .
			        "produit_reel)" .
			" VALUES (" . 
			        tosql($date, "Text") . "," .
			        tosql($reste_mat[0], "Number") . "," .
			        tosql($reste_mat[1], "Number") . "," .
			        tosql($reste_mat[2], "Number") . "," .
			        tosql($reste_mat[3], "Number") . "," .
			        tosql($arrProdPrim[0], "Number") . "," .
			        tosql($arrProdPrim[1], "Number") . "," .
			        tosql($arrProdPrim[2], "Number") . "," .
			        tosql($arrProdPrim[3], "Number") . "," .
			        tosql($ref_produit, "Number") . "," .
			        tosql($machine, "Text") . "," .
			        tosql($produit_total, "Text") . "," .
			        tosql($produit_casse, "Text") . "," .
			        tosql($produit_reel, "Text") . 
			")";       	
			$db->query($sSQL);
			$lastId = mysql_insert_id();
		
		$arrProdOperation = array();
		for($i = 0; $i < count($arrIdProd) ; $i++){
			$reste_mat[] = $result[$i] - $arrProdPrim[$i];
			$sql = "INSERT 
				INTO operation_produit (
				ref_produit, 
				ref_melange, 
				qt_operation, 
				ref_user) values (";
			$sql .= tosql($arrIdProd[$i], "NUMBER") . ", ";
			$sql .= tosql($lastId, "NUMBER") . ", ";
			$sql .= tosql("-".$arrProdPrim[$i], "NUMBER") . ", ";
			$sql .= "1)";
			$db->query($sql);
			$arrProdOperation[] = mysql_insert_id();
		}
		
		$sql = "insert into operation_produit (ref_produit, ref_melange, qt_operation, ref_user) values (";
		$sql .= tosql($ref_produit, "NUMBER") . ", ";
		$sql .= tosql($lastId, "NUMBER") . ", ";
		$sql .= tosql($produit_reel, "NUMBER") . ", ";
		$sql .= "1)";
		$db->query($sql);
		
		$arrProdOperation[] = mysql_insert_id();
		$db->query("update productivite set ligne_operation_prod = " . tosql(json_encode($arrProdOperation),"Text"). " Where id = " . tosql($lastId,"NUMBER"));
		
		echo '<script>alert("Vous avez saisie le bon numéro : '. $ref_produit .'")</script>';
		echo '<script>window.location.href = "productivite.php";</script>';
    } else if ($date && count($arrProdPrim) && $ref_produit && $produit_total && $produit_casse && $produit_reel && count($reste_mat) && $id) {          	    	
		$ligne_operation_prod = json_decode(dlookup("productivite","ligne_operation_prod","id=".tosql($id, "NUMBER")));
		$sSQL = "UPDATE productivite SET "; 
		$sSQL .= "date_operation = " . tosql($date, "Text");

		$sSQL .=",ml_beton = " . tosql($arrProdPrim[0], "Number");
		$sSQL .=",ml_sable1 =" . tosql($arrProdPrim[1], "Number");
		$sSQL .=",ml_sable2 =" . tosql($arrProdPrim[2], "Number");
		$sSQL .=",ml_sable3 =" . tosql($arrProdPrim[3], "Number");

		$sSQL .=",reste_beton = " . tosql($reste_mat[0], "Number");
		$sSQL .=",reste_sable1 =" . tosql($reste_mat[1], "Number");
		$sSQL .=",reste_sable2 =" . tosql($reste_mat[2], "Number");
		$sSQL .=",reste_sable3 =" . tosql($reste_mat[3], "Number");

		$sSQL .=",produit_total = " . tosql($produit_total, "Text");
		$sSQL .=",produit_casse =" . tosql($produit_casse, "Text");
		$sSQL .=",produit_reel =" . tosql($produit_reel, "Text");
		
		$sSQL .=",ref_produit =" . tosql($ref_produit, "Number");
		// $sSQL .=",machine =" . tosql($machine, "Text");
	
		$sSQL .= " where id=" .tosql($id, "Number") ."";        	
		print_r($ligne_operation_prod);
		echo "<br>";
		echo "<br> sql : " . $sSQL;
		$db->query($sSQL);
		
		$i=0;
		for($i=0;$i<=3;$i++){
			echo "<br>" . "update operation_produit set qt_operation = " . tosql("-".$arrProdPrim[$i],"NUMBER") . " where id = " . tosql($ligne_operation_prod[$i], "Number");
			$db->query("update operation_produit set qt_operation = " . tosql("-".$arrProdPrim[$i],"NUMBER") . " where id = " . tosql($ligne_operation_prod[$i], "Number"));
		}
		
		$db->query("update operation_produit set qt_operation = " . tosql($produit_reel,"NUMBER") . " where id = " . tosql($ligne_operation_prod[$i], "Number"));
		echo "<br>" . "update operation_produit set ref_produit = ".tosql($ref_produit, "NUMBER").", qt_operation = " . tosql($produit_reel,"NUMBER") . " where id = " . tosql($ligne_operation_prod[$i], "Number");
		exit;
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
             	$reste_sable3 = $db->f("reste_sable3"); 
             	
             	$ml_beton = $db->f("ml_beton");
             	$ml_sable1 = $db->f("ml_sable1"); 
             	$ml_sable2 = $db->f("ml_sable2"); 
             	$ml_sable3 = $db->f("ml_sable3"); 
             	
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
			$tpl->set_var("reste_sable3",$reste_sable3);
			
			$tpl->set_var("ml_beton",$ml_beton);
			$tpl->set_var("ml_sable1",$ml_sable1);
			$tpl->set_var("ml_sable2",$ml_sable2);
			$tpl->set_var("ml_sable3",$ml_sable3);
			
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
		global $db;
	      $delete = get_param('delete');
	      if ($delete) {
				$ligne_operation_prod = json_decode(dlookup("productivite","ligne_operation_prod","id=".tosql($delete, "NUMBER")));
	            $sql = sprintf("DELETE FROM productivite WHERE id = '".$delete."'");
	            $result = mysql_query($sql);
				if ($result){
					for($i=0;$i<=4;$i++){
						$db->query("DELETE FROM operation_produit where id = " . tosql($ligne_operation_prod[$i], "Number"));
					}
				}
	            header("location: productivite.php");
	      }			
      } 
   $tpl->pparse("productivite", false);      

?>
