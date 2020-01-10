<?php
    $LANG           = $module->lang;
    $product        = isset($product) && $product ? $product : [];
    $module_data    = isset($product["module_data"]) ? Utility::jdecode($product["module_data"],true) : [];

    if(method_exists($module,"config_options") && $config_options = $module->config_options($module_data)) return $module->config_options_output($config_options,'module_data');
?>