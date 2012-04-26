<?php
      include ("header.php");
      $pWindow = "commandes";
      $filename = "traitement_commandes.php";
      $template_filename = "traitement_commandes.html";

      $tpl = new Template($app_path);
      $tpl->load_file($template_filename, "traitement_commandes");

      $tpl->load_file("../apps/footer.html", "Footer");

      $sheader = $tplheader->return_var("Header");
      $tpl->set_var("Header",$sheader);
      $tpl->parse("Footer", false);

      $tpl->set_var("FileName", $filename);

      // INTERNE VEHICULE
      $lookup_vehiculeIn = db_fill_array("SELECT * FROM  vehicule_externe");

      if(is_array($lookup_vehiculeIn)) {
      reset($lookup_vehiculeIn);
            while(list($value, $key) = each($lookup_vehiculeIn)) {
              $tpl->set_var("Value_vehiculeIn", $key);
              $tpl->set_var("id_vehiculeIn", $key);
              $tpl->parse("select_vehiculeIn", true);
            }
      }
      // EXTERNE VEHICULE
      $lookup_vehiculeEx = db_fill_array("SELECT * FROM  vehicules");

      if(is_array($lookup_vehiculeEx)) {
      reset($lookup_vehiculeEx);
            while(list($value, $key) = each($lookup_vehiculeEx)) {
              $tpl->set_var("Value_vehiculeEx", $key);
              $tpl->set_var("id_vehiculeEx", $key);
              $tpl->parse("select_vehiculeEx", true);
            }
      }

      global $db;
      global $db2;
      global $tpl;
      global $sForm;
      $sActionFileName = "traitement_commandes.php";
      $tpl->set_var("ActionPage", $sActionFileName);
      $id = $_GET["id"];

	$sSQL = "SELECT * FROM commandes";
	$db->query($sSQL);
	$next_record = $db->next_record();

	//var_dump($_GET);

      $i = 1;
      while($next_record){

      	//WE DISPLAY THE RESULTS
       	$id = $db->f("id");
       	$date = $db->f("date");
        $ref_client = $db->f("ref_client");
       	$qt_produit = $db->f("qt_produit");
       	$qt_liv = $db->f("qt_liv");
       	$ref_prod = $db->f("ref_produit");
       	$ref_prod_ref = $db->f("ref_reference");
       	$facutShow = $db->f("facutShow");

		$db2->query("SELECT adresse, adresse2, adresse3, adresse4, adresse5 FROM  clients WHERE id=".tosql($db->f("ref_client"), "NUMBER"));
		$next_record2 = $db2->next_record();
		$tpl->set_var("select_adresse", "");
		while($next_record2){
			if (strlen(trim($db2->f("adresse"))) > 0){
				$tpl->set_var("Value_adresse", $db2->f("adresse"));
				$tpl->set_var("id_adresse", $db2->f("adresse"));
				$tpl->parse("select_adresse", true);
			}
			if (strlen(trim($db2->f("adresse2"))) > 0){
				$tpl->set_var("Value_adresse", $db2->f("adresse2"));
				$tpl->set_var("id_adresse", $db2->f("adresse2"));
				$tpl->parse("select_adresse", true);
			}
			if (strlen(trim($db2->f("adresse3"))) > 0){
				$tpl->set_var("Value_adresse", $db2->f("adresse3"));
				$tpl->set_var("id_adresse", $db2->f("adresse3"));
				$tpl->parse("select_adresse", true);
			}
			if (strlen(trim($db2->f("adresse4"))) > 0){
				$tpl->set_var("Value_adresse", $db2->f("adresse4"));
				$tpl->set_var("id_adresse", $db2->f("adresse4"));
				$tpl->parse("select_adresse", true);
			}
			if (strlen(trim($db2->f("adresse5"))) > 0){
				$tpl->set_var("Value_adresse", $db2->f("adresse5"));
				$tpl->set_var("id_adresse", $db2->f("adresse5"));
				$tpl->parse("select_adresse", true);
			}
			$next_record2 = $db2->next_record();
		}

	// WE GET THE RELATION WITH THE OTHER FIELDS
       	$libclients = dlookup("clients", "nom_resp", "id=".tosql($db->f("ref_client"), "NUMBER"));
       	$produit = dlookup("produits", "libelle", "id=".tosql($db->f("ref_produit"), "Text"));
       	$produit_ref = dlookup("produits", "libelle", "id=".tosql($db->f("ref_reference"), "Text"));
       	$telClient = dlookup("clients", "tel", "id=".tosql($db->f("ref_client"), "NUMBER"));
       	$adresseClient = dlookup("clients", "adresse", "id=".tosql($db->f("ref_client"), "Text"));

       	// WE RECORD THE SQL
       	$next_record = $db->next_record();

       	// SET A VARIABLE IN TEMPLATE
       	$tpl->set_var("id",$id);
       	$tpl->set_var("date",$date);
	$tpl->set_var("ref_client",$libclients);
	$tpl->set_var("produit",$produit);
	$tpl->set_var("ref_reference",$produit_ref);
	$tpl->set_var("telClient",$telClient);
	$tpl->set_var("adresseClient",$adresseClient);
	$tpl->set_var("qt_liv",$qt_liv);
	$tpl->set_var("qt_produit",$qt_produit);
	$tpl->set_var("consommation",$consommation);
	$tpl->set_var("ref_vehicule",$libVehicule);
	$tpl->set_var("ref_prod",$ref_prod_ref);
	$tpl->set_var("ordrRow",$i);

		if ($qt_liv < $qt_produit){
			$tpl->parse("EstCloturable", false);
			$tpl->set_var("EstNonCloturable","");
		} else {
			$tpl->parse("EstNonCloturable", false);
			$tpl->set_var("EstCloturable","");
		}

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

      function verifie() {
		$verfie = get_param('prd');
		$somme_qt = (int)dlookup("operation_produit", "sum(qt_operation)", "ref_produit=".tosql($verfie, "NUMBER"). " Group by ref_produit");
		echo '{"sumqt" : '. $somme_qt .'}';
		exit;
      }

	function send() {
	        global $db;
		$send = get_param('id');
		$send_qt = get_param('qt');
		//echo "<h2>teeeeeest issam : $send_qt</h2>";
		$prod = get_param('prd');
		$adr = get_param('ard');
		$hor = get_param('h');
		$trans = get_param('trans');
		$qt_commande = dlookup("commandes", "qt_produit", "id=".tosql($send, "NUMBER"));
		$qt_liv_old = dlookup("commandes", "qt_liv", "id=".tosql($send, "NUMBER"));
		//echo "<h1>test younes : $send</h1>";
		$qt_liv_new = $qt_liv_old + $send_qt;

		$somme_qt = (int)dlookup("operation_produit", "sum(qt_operation)", "ref_produit=".tosql($prod, "NUMBER"). " Group by ref_produit");
		if ($send_qt > $somme_qt){
			echo '{"success" : -2, "stresp" : '. $somme_qt .'}';
			exit;
		}

		if ($qt_liv_new > $qt_commande){
			echo '{"success" : 0, "stresp" : '. $qt_liv_new .'}';
			exit;
		}
		if ((strlen(trim($send)) > 0) && ($qt_liv_new < $qt_commande)) {
			$sql = sprintf("UPDATE commandes SET qt_liv = " .tosql($qt_liv_new, "NUMBER").", adresse_derniere_liv = ".tosql($adr, "TEXT").", time_depart = ".tosql($hor, "TEXT").", ref_vehicule = ".tosql($trans, "TEXT")."  WHERE id = '".$send."'");
			$db->query($sql);
			$sql = "INSERT INTO operation_produit (ref_produit, ref_commande, qt_operation, ref_user) values (";
			$sql .= tosql($prod, "NUMBER") . ", ";
			$sql .= tosql($send, "NUMBER") . ", ";
			$sql .= tosql('-'.$send_qt, "NUMBER") . ", ";
			$sql .= "1)";
			$db->query($sql);
			echo '{"success" : 1, "stresp" : '. $qt_liv_new .'}';
			exit;
		}
		if ((strlen(trim($send)) > 0) && ($qt_liv_new == $qt_commande)){
			$sql = sprintf("update commandes set qt_liv = " .tosql($qt_liv_new, "NUMBER").", adresse_derniere_liv = ".tosql($adr, "TEXT").", time_depart = ".tosql($hor, "TEXT").", ref_vehicule = ".tosql($trans, "TEXT").", etat_commande = 1 WHERE id = '".$send."'");
			$db->query($sql);
			$sql = "insert into operation_produit (ref_produit, ref_commande, qt_operation, ref_user) values (";
			$sql .= tosql($prod, "NUMBER") . ", ";
			$sql .= tosql($send, "NUMBER") . ", ";
			$sql .= tosql('-'.$send_qt, "NUMBER") . ", ";
			$sql .= "1)";
			$db->query($sql);
			echo '{"success" : 2, "stresp" : '. $qt_liv_new .'}';
			exit;
		}
		echo '{"success" : -1, "stresp" : '. $qt_liv_new .'}';
		exit;
	}
        
        function facturation() {
                global $db;
                $id = $_GET['facturation'];
                //echo "<h1>test younes : $id</h1>";
                
        }
        
        // ALL CHOOSE OF THE COSTUMER !
        switch (get_param("action")) {
		case "send":
			send();
			break;
		case "verif":
			verifie();
			break;
	        case "facturation":
			facturation();
			break;
	}
        $tpl->pparse("traitement_commandes", false);

?>
