<?php

function enqueue_mce_plugin_scripts($plugin_array) {
    $plugin_array["youtube_button_plugin"] =  plugin_dir_url(__FILE__) . "../js/mce.js";
    return $plugin_array;
}

add_filter("mce_external_plugins", "enqueue_mce_plugin_scripts");

function register_mce_buttons_editor($buttons) {
    array_push($buttons, "youtube");
    return $buttons;
}

add_filter("mce_buttons", "register_mce_buttons_editor");
