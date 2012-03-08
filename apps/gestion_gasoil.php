 <?php
      include ("header.php");
      $pWindow = "gestion_gasoil";
      $filename = "gestion_gasoil.php";
      $template_filename = "gestion_gasoil.html";

      $sAction = get_param("FormAction");
      $sForm = get_param("FormName");

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "gestion_gasoil");

      $tpl->load_file("../apps/footer.html", "Footer");

      $sheader = $tplheader->return_var("Header");
      $tpl->set_var("Header",$sheader);
      $tpl->parse("Footer", false);

      $tpl->set_var("FileName", $filename);
      
      $lookup_vehicule = db_fill_array("SELECT * FROM  vehicules");
      
      if(is_array($lookup_vehicule)) {
      reset($lookup_vehicule);
            while(list($value, $key) = each($lookup_vehicule)) {
              $tpl->set_var("Value_vehicule", $value);
              $tpl->set_var("id_vehicule", $key);
              $tpl->parse("select_vehicule", true);
            }
      }
      
      $num_bon = get_param("num_bon");
      $ref_vehicule = get_param('ref_vehicule');
      $date = get_param("date");
      $qt_littre = get_param("qt_littre");
      $km = get_param("km");
      
      //var_dump($_POST);

      $sSQL = "INSERT INTO suivi_gasoil (" . 
                  "num_bon," . 
                  "ref_vehicule," . 
                  "date," . 
                  "qt_littre," . 
                  "km)" . 
            " VALUES (" . 
                  tosql($num_bon, "Number") . "," .
                  tosql($ref_vehicule, "Number") . "," .
                  tosql($date, "Text") . "," .
                  tosql($qt_littre, "Number") . "," .
                  tosql($km, "Number") . 
      ")";
      
      if ($num_bon && $ref_vehicule && $date && $qt_littre && $km) {
                  $db->query($sSQL);
                  echo '<script>alert("Vous avez saisie le bon numéro : '. $num_bon .'")</script>';
            }
      $keyword = get_param("keyword");
      
      if (!$keyword) {
            //echo '<script>alert("il faut saisie qq chose pour cherche !");</script>';
            //echo '<script>$("table").addClass("hide");</script>';
            //$tpl->pparse("block_Search", false);      
      }
      
      if ($keyword){
            $tpl->set_var("keyword", $keyword);
            $sql = "SELECT * 
                    FROM  suivi_gasoil 
                    WHERE  num_bon LIKE " . tosql("%".trim($keyword) ."%", "Text");
            
            db_fill_array($sql);
            $Ssql = $db->query($sql);
            if(is_array($Ssql)) {
                  reset($Ssql);
                  while(list($value, $key) = each($Ssql)) {
                    $fldnum_bon = $db->f("s_num_bon");
                    $fldid = $db->f("s_id");
                    $tpl->set_var("Value", $fldnum_bon);
                    $tpl->set_var("id", $fldid);
                    $tpl->parse("block_search", false);
                  }
            }

      }
      
   $tpl->pparse("gestion_gasoil", false);      

?>
