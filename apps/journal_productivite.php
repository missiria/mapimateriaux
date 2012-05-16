<?php
      include ("header.php");
      $pWindow = "journal_productivite";
      $filename = "journal_productivite.php";
      $template_filename = "journal_productivite.html";

      $sAction = get_param("FormAction");
      $sForm = get_param("FormName");

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "journal_productivite");

      $tpl->load_file("../apps/footer.html", "Footer");

      $sheader = $tplheader->return_var("Header");
      $tpl->set_var("Header",$sheader);
      $tpl->parse("Footer", false);

      $tpl->set_var("FileName", $filename);
      $lookup_produits = db_fill_array("SELECT * FROM  produits WHERE type_produit=2");
      
      if(is_array($lookup_produits)) {
      reset($lookup_produits);
            while(list($value, $key) = each($lookup_produits)) {
              $tpl->set_var("Value_produits", $value);
              $tpl->set_var("id_produits", $key);
              $tpl->parse("select_produits", true);
            }
      }
      
      //var_dump($_POST);
      
      search();
      //==============================
      function search() {
      //==============================
        global $db;
        global $tpl;
        global $sForm;
        $sActionFileName = "journal_productivite.php";
        $tpl->set_var("ActionPage", $sActionFileName);
        
        $keyword = strip(get_param("ref_produits"));
        $machine = strip(get_param("machine"));
        $tpl->set_var("keyword", tohtml($keyword));
	
        $from = strip(get_param("from"));
        $to = strip(get_param("to"));
        $tpl->set_var("from", tohtml($from));
        $tpl->set_var("to", tohtml($to));           
                   	
        $sSQL = "SELECT * FROM productivite ";
        
        if ($from && $to)
        $sSQL .= "WHERE date_operation BETWEEN ".tosql($from, "TEXT")." AND ".tosql($to, "TEXT");
        
        if ($keyword)
        $sSQL .= " AND ref_produit=".tosql($keyword, "TEXT");
        
        if ($machine)
        $sSQL .= " AND machine=".tosql($machine, "TEXT");
        
        $db->query($sSQL);
        $next_record = $db->next_record();
        
            $i = 0;       
            $somme_total_prod = 0;       
            $somme_total_casse = 0;       
            $somme_total_reel = 0;
                 
            while($next_record) {
            
                $id = $db->f("id");
                $date_operation = $db->f("date_operation");
                $machine = $db->f("machine");
                $ml_beton = $db->f("ml_beton");
                $ml_sable1 = $db->f("ml_sable1"); 
                $ml_sable2 = $db->f("ml_sable2"); 
                $ml_sable3 = $db->f("ml_sable3"); 
                $produit_total = $db->f("produit_total");
                $produit_casse = $db->f("produit_casse");
                $produit_reel = $db->f("produit_reel");
                $produits = dlookup("produits", "libelle", "id=".tosql($db->f("ref_produit"), "NUMBER"));
                $next_record = $db->next_record();

                $tpl->set_var("date_operation",$date_operation);

                $tpl->set_var("ml_beton",$ml_beton);
                $tpl->set_var("ml_sable1",$ml_sable1);
                $tpl->set_var("ml_sable2",$ml_sable2);
                $tpl->set_var("ml_sable3",$ml_sable3);
                
                $tpl->set_var("produit_total",$produit_total);
                $tpl->set_var("produit_casse",$produit_casse);
                $tpl->set_var("produit_reel",$produit_reel);

		if ($machine == "A") {
		    $tpl->set_var("machine","VP100"); 	    
		} else if ($machine == "B") {
		   $tpl->set_var("machine","PROFIT");      
		}
                
				
				$somme_total_prod += $produit_total;       
				$somme_total_casse += $produit_casse;       
				$somme_total_reel += $produit_reel;       
				
                $tpl->set_var("produits",$produits);

                $tpl->set_var("ordrRow",$i);

                $tpl->parse("row_result", true);
                $i++;
      	}

        if ($i == 0) {
                $tpl->parse("Norow_result",false);
                $tpl->set_var("TableResult","");
		} else {
			$tpl->set_var("tl_produit",$somme_total_prod);
			$tpl->set_var("tl_casse",$somme_total_casse);
			$tpl->set_var("tl_reel",$somme_total_reel);
        
			$tpl->parse("TableResult",false);
			$tpl->set_var("Norow_result","");
        }
        $tpl->parse("block_search", false); 		
      }
   $tpl->pparse("journal_productivite", false);      

?>
