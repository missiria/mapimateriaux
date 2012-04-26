<?php
        include ("../libs/common.php");
		if (strlen(trim(get_session("capid_user"))) == 0){
			header("Location: " . "login.php");
			exit;
		}
        $template_filename = "../apps/header.html";
        $tplheader = new Template($app_path);
        $tplheader->load_file($template_filename, "Header");
        $IDUser = get_session("capid_user");
        $UserLastName = dlookup("users","nom","id=".tosql($IDUser, "Number"));
        $UserFisrtName = dlookup("users","prenom","id=".tosql($IDUser, "Number"));
        $UserName= $UserFisrtName." ".$UserLastName;
        $tplheader->parse("Header", false);

?>
