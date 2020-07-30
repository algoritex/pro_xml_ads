<?php

/*
Plugin Name: Pro XML Ads Import/Export
Plugin URI: pro-xml-ads
Description: Import large amount of ads or export them easily with customized options
Version: 2.1.0
Author: Algoritex
Author URI: http://www.algoritex.com
Short Name: pro_xml_ads
Plugin update URI: pro-xml-ads
*/

if ( !defined('ABS_PATH') ) {
    exit('ABS_PATH is not loaded. Direct access is not allowed.');
}


function change_parent_options() {
    Preference::newInstance()->replace("selectable_parent_categories", "1");
}

function pro_xml_configure()
{
    osc_admin_render_plugin('pro_xml_ads/import.php');
}


function admin_header()
{
    echo '<link href="' . osc_plugin_url(__FILE__) . 'css/style.min.css'. '" rel="stylesheet" type="text/css">' . PHP_EOL;
}

function admin_footer()
{
    echo '<script src="' . osc_plugin_url(__FILE__) . 'js/functions.js'.'"></script>' . PHP_EOL;
    echo '<script src="' . osc_plugin_url(__FILE__) . 'js/jquery.validate.min.js'.'"></script>' . PHP_EOL;
}


function pro_xml_menu()
{
    $import = osc_admin_render_plugin_url(__DIR__) . "/import.php";
    $export = osc_admin_render_plugin_url(basename(dirname(__FILE__)) . "/export.php");
    $help = osc_admin_render_plugin_url(basename(dirname(__FILE__)) . "/help.php");
    echo '<h3><a href="#">' . __('Pro XML Ads', 'pro_xml_ads') . '</a></h3>';
    echo '<ul>
            <li><a class="admin_menu_proxml" href="' . $import . '"><strong>' . __('>> Import', 'pro_xml_ads') . '</strong></a></li>
             <li><a class="admin_menu_proxml" href="' . $export . '"><strong>' . __('>> Export', 'pro_xml_ads') . '</strong></a></li>
            <li><a class="admin_menu_proxml" href="' . $help . '"><strong>' . __('>> Help', 'pro_xml_ads') . '</strong></a></li>
         </ul>';
}

function pro_xml_menu_bar($active)
{

    $import = osc_admin_render_plugin_url(__DIR__) . "/import.php";
    $export = osc_admin_render_plugin_url(basename(dirname(__FILE__)) . "/export.php");
    $help = osc_admin_render_plugin_url(basename(dirname(__FILE__)) . "/help.php");
    $title =  __('Pro XML Ads', 'pro_xml_ads');
    if ($active == "IMPORT") {
        echo '<ul>
            <li><a class="logo" href="#">' . $title . '</a></li>
            <li><a class="active" href="' . $import . '">' . __('Import', 'pro_xml_ads') . '</a></li>
             <li><a href="' . $export . '">' . __('Export', 'pro_xml_ads') . '</a></li>
            <li><a href="' . $help . '">' . __('Help', 'pro_xml_ads') . '</a></li>
         </ul>';
    } else if ($active == "EXPORT") {
        echo '<ul>
            <li><a class="logo" href="#">' . $title . '</a></li>
            <li><a href="' . $import . '">' . __('Import', 'pro_xml_ads') . '</a></li>
             <li><a class="active" href="' . $export . '">' . __('Export', 'pro_xml_ads') . '</a></li>
            <li><a href="' . $help . '">' . __('Help', 'pro_xml_ads') . '</a></li>
         </ul>';
    } else if ($active == "HELP") {
        echo '<ul>
            <li><a class="logo" href="#">' . $title . '</a></li>
            <li><a href="' . $import . '">' . __('Import', 'pro_xml_ads') . '</a></li>
             <li><a href="' . $export . '">' . __('Export', 'pro_xml_ads') . '</a></li>
            <li><a class="active" href="' .  $help . '">' . __('Help', 'pro_xml_ads') . '</a></li>
         </ul>';
    }
}


function pro_xml_footer()
{
    $link = "http://www.algoritex.com";
    echo '<section>
            <footer class="text-center">
            <br>
                ' . __('Pro XML Ads 2.1.0 | Copyright © 2019 | Created by', 'pro_xml_ads') .'
                    <a class="link_footer" target="_blank"
                            href="' . $link . '"><strong>' . __("Algoritex Web Development") .'</strong></a>
               <br><br>
            </footer>
        </section>';
}

function load_files() {

    if (Params::getParam('page') == 'plugins' && Params::getParam('action') == 'renderplugin' &&
        (Params::getParam('file') == 'pro_xml_ads/export.php' ||
            Params::getParam('file') == 'pro_xml_ads/help.php' ||
            Params::getParam('file') == 'pro_xml_ads/import.php')
    ) {
        osc_add_hook('admin_header', 'admin_header');
        osc_add_hook('admin_footer', 'admin_footer');
    }
}


osc_add_hook('init_admin', 'load_files');
osc_add_hook('admin_menu', 'pro_xml_menu');
osc_add_hook(osc_plugin_path(__FILE__) . "_configure", 'pro_xml_configure');
osc_register_plugin(osc_plugin_path(__FILE__), 'change_parent_options');