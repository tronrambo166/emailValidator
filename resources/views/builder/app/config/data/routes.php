<?php

$packs = [

    $berevi_collection = [
        "path" => $appPath."/",
        "controller" => "BereviCollectionPack:Main:index",
        "requirements" => "",
        "method" => ""
    ],

    $berevi_collection_login = [
        "path" => $appPath."/login",
        "controller" => "BereviCollectionPack:Main:login",
        "requirements" => "",
        "method" => ""
    ],

    $berevi_collection_login_authentication = [
        "path" => $appPath."/login/authentication",
        "controller" => "BereviCollectionPack:Main:loginAuthentication",
        "requirements" => "{code}:^[a-zA-Z0-9-]+$",
        "method" => "GET"
    ],

    $berevi_collection_login_control = [
        "path" => $appPath."/login/control",
        "controller" => "BereviCollectionPack:Main:loginControl",
        "requirements" => "",
        "method" => "POST"
    ],

    $berevi_collection_admin_panel = [
        "path" => $appPath."/admin/panel",
        "controller" => "BereviCollectionPack:Main:adminPanel",
        "requirements" => "",
        /*"requirements" => "{id}:^[0-9]{1,4}$||{name}:^[a-zA-Z]+$",*/
        "method" => ""
    ],

    $berevi_collection_admin_logout = [
        "path" => $appPath."/admin/logout",
        "controller" => "BereviCollectionPack:Main:adminLogout",
        "requirements" => "",
        "method" => ""
    ],

];
