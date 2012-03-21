<?php
      include ("header.php");
      $pWindow = "print_facture";
      $filename = "print_facture.php";
      $template_filename = "print_facture.html";

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "print_facture");
      
      $id=get_param("id");
      $date=get_param("date");
      $client=get_param("client");
      $qt_produit=get_param("qt_prod");
      $qt_liv=get_param("qt_liv");
      $montant=get_param("montant");
      $prix_uni=get_param("prix_uni");
      $tva=get_param("tva");
      $ttc=get_param("ttc");
      $libreferences=get_param("refprod");
      $libproduits=get_param("prod");
      
      $tpl->set_var("id",$id);
      $tpl->set_var("date",$date);
      $tpl->set_var("client",$client);
      $tpl->set_var("qt_produit",$qt_produit);
      $tpl->set_var("qt_liv",$qt_liv);
      $tpl->set_var("montant",$montant);
      $tpl->set_var("prix_uni",$prix_uni);
      $tpl->set_var("tva",$tva);
      $tpl->set_var("ttc",$ttc);
      $tpl->set_var("libreferences",$libreferences);
      $tpl->set_var("libproduits",$libproduits);
      
      echo "<pre>";
      var_dump($_GET);
      echo "</pre>";
      
      $tpl->pparse("print_facture", false);   

?>
