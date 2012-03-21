<?php
      include ("header.php");
      $pWindow = "print_commandes";
      $filename = "print_commandes.php";
      $template_filename = "print_commandes.html";

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "print_commandes");
      
      $id=get_param("id");
      $date=get_param("date");
      $client=get_param("client");
      $qt_produit=get_param("qt_produit");
      $qt_liv=get_param("qt_liv");
      
      $tpl->set_var("id",$id);
      $tpl->set_var("date",$date);
      $tpl->set_var("client",$client);
      $tpl->set_var("qt_produit",$qt_produit);
      $tpl->set_var("qt_liv",$qt_liv);
      
      echo "<pre>";
      var_dump($_GET);
      echo "</pre>";
      
      $tpl->pparse("print_commandes", false);   

?>
