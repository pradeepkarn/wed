<?php
class Lang_ctrl extends Main_ctrl
{
    function set_lang($req=null) {
        $req = obj($req);
        if (isset($req->lang)) {
            $rules = [
                'lang' => 'required|string'
            ];
            $pass = validateData(data: arr($req), rules: $rules);
            if (!$pass) {
                echo js_alert(msg_ssn("msg", true));
                return;
            }
            if (!in_array($req->lang,LANG_ARR)) {
                msg_set("Invalid language");
                echo js_alert(msg_ssn("msg", true));
                return;
            }
            // echo $req->lang;
            (setcookie('lang', $req->lang, time() + (86400 * 30 * 12), "/"));
            echo RELOAD;
            return;
        }
    }
}
