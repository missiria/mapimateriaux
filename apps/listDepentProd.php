<?php
    include ("../libs/common.php");

	$str = get_param("id");
	$lookup_product = db_fill_array("SELECT id, libelle FROM produits where ref_parent = " . tosql($str, "Number"));
	$listOption = "<option value=''>S&eacute;l&eacute;ctionnez un produit</option>";
	if(is_array($lookup_product)) {
		reset($lookup_product);
		while(list($value, $key) = each($lookup_product)) {
			$listOption .= "<option value='".$value."'>".$key."</option>";
		}
	}
	echo $listOption;
	exit;		

?>