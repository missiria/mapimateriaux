<?php
      include ("header.php");
      $pWindow = "commandes";
      $filename = "stock.php";
      $template_filename = "stock.html";

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "stock");

      $tpl->load_file("../apps/footer.html", "Footer");

      $sheader = $tplheader->return_var("Header");
      $tpl->set_var("Header",$sheader);
      $tpl->parse("Footer", false);

      $tpl->set_var("FileName", $filename);


      global $db;
      global $db2;
      global $tpl;
      global $sForm;
      $sActionFileName = "stock.php";
      $tpl->set_var("ActionPage", $sActionFileName);
      $id = $_GET["id"];

	$sSQL = "SELECT produits.libelle AS lib, produits.id AS idProd, SUM( qt_operation ) AS total";
	$sSQL .= " FROM operation_produit";
	$sSQL .= " INNER JOIN produits ON operation_produit.`ref_produit` = produits.id";
	$sSQL .= " GROUP BY produits.type_produit, produits.id";

	$db->query($sSQL);
	$next_record = $db->next_record();

      $i = 1;
      while($next_record){

      	//WE DISPLAY THE RESULTS
       	$fldid = $db->f("idProd");
       	$fldQuantite = $db->f("total");
        $fldLibelle = $db->f("lib");

       	// WE RECORD THE SQL
       	$next_record = $db->next_record();

       	// SET A VARIABLE IN TEMPLATE
       	$tpl->set_var("id",$fldid);
       	$tpl->set_var("produit",$fldLibelle);
		$tpl->set_var("qt_produit",$fldQuantite);

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

   $tpl->pparse("stock", false);

?>
