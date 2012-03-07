 <?php
      include ("header.php");
      $pWindow = "product";
      $filename = "product.php";
      $template_filename = "product.html";

      $sAction = get_param("FormAction");
      $sForm = get_param("FormName");

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "product");

      $tpl->load_file("../apps/footer.html", "Footer");

      $sheader = $tplheader->return_var("Header");
      $tpl->set_var("Header",$sheader);
      $tpl->parse("Footer", false);

      $tpl->set_var("FileName", $filename);

      $tpl->pparse("product", false);

      $produit = get_param("produit");
      $caracteristique = get_param("caracteristique");
      $ref_product = get_param("ref_product");
      
      $sSQL = "INSERT INTO produits (" . 
                  "libelle," . 
                  "caracteristique," . 
                  "ref_product)" . 
            " VALUES (" . 
                  tosql($produit, "Text") . "," . 
                  tosql($caracteristique, "Text") . "," . 
                  tosql($ref_product, "Text") . 
      ")";
      
      if ($produit && $caracteristique && $ref_product) {
                  $db->query($sSQL);
                  echo '<script>alert("Vous avez ajouté le produit '. $produit .'")</script>';
            }
        
        

?>
