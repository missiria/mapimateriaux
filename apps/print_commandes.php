<?php
      include ("header.php");
      $pWindow = "print_commandes";
      $filename = "print_commandes.php";
      $template_filename = "print_commandes.html";

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "print_commandes");
      
      $id=get_param("id");
	  
	  $db->query("SELECT * FROM  commandes WHERE id=".tosql($id, "NUMBER"));
	  $next_record = $db->next_record();
	  while($next_record){
	  
		$date=$db->f("date");
		$client=$db->f("ref_client");
		$qt_produit=$db->f("qt_produit");
		$qt_liv=$db->f("qt_liv");
		$tel=$db->f("telClient");
		$ref_vehicule=$db->f("ref_vehicule");
		$time=$db->f("time_depart");
		$adresse=$db->f("adresse_derniere_liv");
		$client = dlookup("clients", "nom_resp", "id=".tosql($db->f("ref_client"), "NUMBER")); 
		$telClient = dlookup("clients", "tel", "id=".tosql($db->f("ref_client"), "NUMBER"));
		$next_record = $db->next_record();
	  }
      
        $tpl->set_var("id",$id);
        $tpl->set_var("date",$date);
        $tpl->set_var("client",$client);
        $tpl->set_var("qt_produit",$qt_produit);
        $tpl->set_var("qt_liv",$qt_liv);
        $qt_reste = $qt_produit - $qt_liv;
        $tpl->set_var("qt_reste",$qt_reste);
        $tpl->set_var("time_depart",$time);
        $tpl->set_var("ref_vehicule",$ref_vehicule);
        $tpl->set_var("telClient",$telClient);
        $tpl->set_var("adresse",$adresse);
      
      $tpl->pparse("print_commandes", false);   

?>
