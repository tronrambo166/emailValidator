<?php

$packs = [

    $optimail_cleaner_index = [
        "path" => $appPath."/admin/panel/optimail",
        "controller" => "OptimailCleanerPack:Main:ocIndex",
        "requirements" => "",
        "method" => ""
    ],

    $optimail_cleaner_advanced = [
        "path" => $appPath."/admin/panel/optimail/advanced",
        "controller" => "OptimailCleanerPack:Main:ocAdvanced",
        "requirements" => "",
        "method" => ""
    ],

    $optimail_cleaner_runtime = [
        "path" => $appPath."/admin/panel/optimail/runtime",
        "controller" => "OptimailCleanerPack:Main:ocRuntime",
        "requirements" => "",
        "method" => ""
    ],

    $optimail_cleaner_timer = [
        "path" => $appPath."/admin/panel/optimail/timer",
        "controller" => "OptimailCleanerPack:Main:ocTimer",
        "requirements" => "",
        "method" => ""
    ],

    $optimail_cleaner_tables = [
        "path" => $appPath."/admin/panel/optimail/tables",
        "controller" => "OptimailCleanerPack:Main:ocTables",
        "requirements" => "",
        "method" => ""
    ],

    $optimail_cleaner_tables_objects = [
        "path" => $appPath."/admin/panel/optimail/tables/objects",
        "controller" => "OptimailCleanerPack:Main:ocTablesObjects",
        "requirements" => "",
        "method" => ""
    ],

    $optimail_cleaner_tables_download_good = [
        "path" => $appPath."/admin/panel/optimail/tables/download/good",
        "controller" => "OptimailCleanerPack:Main:ocTablesDownloadGood",
        "requirements" => "{file}:^[0-9]+$",
        "method" => "GET"
    ],

    $optimail_cleaner_tables_download_bad = [
        "path" => $appPath."/admin/panel/optimail/tables/download/bad",
        "controller" => "OptimailCleanerPack:Main:ocTablesDownloadBad",
        "requirements" => "{file}:^[0-9]+$",
        "method" => "GET"
    ],

    $optimail_cleaner_tables_delete_files = [
        "path" => $appPath."/admin/panel/optimail/tables/delete/files",
        "controller" => "OptimailCleanerPack:Main:ocTablesDeleteFiles",
        "requirements" => "{file}:^[0-9]+$",
        "method" => "GET"
    ],

    $optimail_cleaner_bounce_mail = [
        "path" => $appPath."/admin/panel/optimail/bounce/mail",
        "controller" => "OptimailCleanerPack:Main:ocBounceMail",
        "requirements" => "",
        "method" => ""
    ],

    $optimail_cleaner_tables_bounce = [
        "path" => $appPath."/admin/panel/optimail/tables/bounce",
        "controller" => "OptimailCleanerPack:Main:ocTablesBounce",
        "requirements" => "",
        "method" => ""
    ],

    $optimail_cleaner_tables_bounce_objects = [
        "path" => $appPath."/admin/panel/optimail/tables/bounce/objects",
        "controller" => "OptimailCleanerPack:Main:ocTablesBounceObjects",
        "requirements" => "",
        "method" => ""
    ],

    $optimail_cleaner_tables_bounce_download_bad = [
        "path" => $appPath."/admin/panel/optimail/tables/bounce/download/bad",
        "controller" => "OptimailCleanerPack:Main:ocTablesBounceDownloadBad",
        "requirements" => "{file}:^[0-9]+$",
        "method" => "GET"
    ],

    $optimail_cleaner_tables_bounce_delete_files = [
        "path" => $appPath."/admin/panel/optimail/tables/bounce/delete/files",
        "controller" => "OptimailCleanerPack:Main:ocTablesBounceDeleteFiles",
        "requirements" => "{file}:^[0-9]+$",
        "method" => "GET"
    ],

];
