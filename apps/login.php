<?php
        include ("../libs/common.php");
        $cryptinstall="../libs/crypt/cryptographp.fct.php";
        include $cryptinstall;

        $filename = "login.php";
        $template_filename = "login.html";
        $sAction = get_param("FormAction");
        $sForm = get_param("FormName");
        $sLoginErr = "";

        //redirection vers la page errorsession.php dans le cas où nombre tentative est sup&eacute;rieur de 2****** 
        if($_SESSION['counter'] > 2) {
                header("Location: " . "errorsession.php");
                exit;
        }
        //fin redirction
                        
        switch ($sForm) {
                case "Login":
                        Login_action($sAction);
                break;
                case "Logout":
                        Login_action($sAction);
                break;
        }

        $tpl = new Template($app_path);
        $tpl->load_file($template_filename, "main");
        $tpl->set_var("FileName", $filename);
        Login_show();
        $tpl->pparse("main", false);


function Login_action($sAction) {
        global $db;
        global $tpl;
        global $sLoginErr;
        global $filename;
        
        if(strlen($sLoginErr)) return;
                
        switch(strtolower($sAction)) {
                case "login":
                        $sLogin = get_param("Login");
                        $sPassword = get_param("Password");
                        $fldcode = get_param("code");
                        $db->query("SELECT id FROM users WHERE nom =" . tosql($sLogin, "Text") . " AND password =" . tosql(md5($sPassword), "Text"). " AND est_actif=1");
                        $is_passed = $db->next_record();
                        
        
                        
                        if($is_passed) {
                                
                                
                                if (strlen($fldcode)) {
                                        if (chk_crypt($fldcode)) {

                                        } else {
                                                $sLoginErr .= "Code de s&eacute;curit&eacute; incorrect<br>";
                                                return;
                                        }
                                        
                                } else {
                                        $sLoginErr .= "Code de s&eacute;curit&eacute; obligatoire<br>";
                                        return;
                                }
                                                                
                                set_session("capid_user", $is_passed);
                                
                                $_SESSION['counter']=0;
								header("Location:" . "traitement_commandes.php");
                                exit;
                        }else {
                                $sLoginErr .= "Login ou mot de passe incorrect.<br>";
                                
                                if (strlen($fldcode)) {
                                        if (chk_crypt($fldcode)) {
                                        } else {
                                                $sLoginErr .= "Code de s&eacute;curit&eacute; incorrect<br>";
                                                return;
                                        }
                                        
                                } else {
                                        $sLoginErr .= "Code de s&eacute;curit&eacute; obligatoire<br>";
                                }
                        }
                
                break;
                
                case "logout":
						unset($_SESSION["capid_user"]);
						unset($_SESSION["ref_role"]);
                        header("Location:" . "login.php");
                        exit;
                break;
        }
}


function Login_show()
{
        global $tpl;
        global $sLoginErr;
        global $db;
        $sFormTitle = "";
        $tpl->set_var("FormTitle", $sFormTitle);
        $tpl->set_var("sLoginErr", $sLoginErr);
        $tpl->set_var("querystring", get_param("querystring"));
        $tpl->set_var("ret_page", get_param("ret_page"));
        $code = dsp_crypt(1,2);
        $tpl->set_var("code", $code);
        if(get_session("capid_user") == "") {
                $tpl->set_var("LogoutAct", "");
                $tpl->set_var("UserInd", "");
                $tpl->set_var("Login", strip(tohtml(get_param("Login"))));
                if($sLoginErr == "") 
                        $tpl->set_var("LoginError", "");
                else {
                        $tpl->set_var("sLoginErr", $sLoginErr);
                        $tpl->parse("LoginError", false);
                }
                $tpl->parse("LoginAct", false);
        } else {
                $db->query("SELECT nom FROM users WHERE id =". tosql(get_session("capid_user"), "Number"));
                $db->next_record();
                $tpl->set_var("LoginError", "");
                $tpl->set_var("LoginAct", "");
                $tpl->set_var("AdminID", $db->f("nom"));
                $tpl->parse("UserInd", false);
        }
        $tpl->parse("FormLogin", false);
}

?>
