 <?php
        include ("header.php");
        $pWindow = "main";
        $filename = "config.php";
        $template_filename = "config.html";

        $sAction = get_param("FormAction");
        $sForm = get_param("FormName");

        $tpl = new Template($app_path);
        $tpl->load_file($template_filename, "config");

        $tpl->load_file("../apps/footer.html", "Footer");
        
        $sheader = $tplheader->return_var("Header");
        $tpl->set_var("Header",$sheader);
        $tpl->parse("Footer", false);

        $tpl->set_var("FileName", $filename);

        $tpl->pparse("config", false);

?>
