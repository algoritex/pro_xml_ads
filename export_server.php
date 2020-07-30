<?php
/**
 * Created by Algoritex.
 * User: Kike
 * Date: 05/10/2016
 * Time: 11:32
 */
if (!defined('OC_ADMIN') || OC_ADMIN !== true) exit('Access is not allowed.');


//ini_set('output_buffering','on');
//ini_set('zlib.output_compression', 0);



Preference::newInstance()->replace("selectable_parent_categories", "1");
$default_tags = Params::getParam('default_tags') == "1" ? true : false;
$tags = getTags($default_tags);
$data = retrieveAds();

doExport($data, $tags);


/**
 * Get all the ads from de bbdd
 *
 * @return array
 */
function retrieveAds()
{
    $dao = new DAO();
    $select = $dao->getTablePrefix() . 't_category_description.s_name, ' . $dao->getTablePrefix() . 't_item_description.s_title, ' .
        $dao->getTablePrefix() . 't_item_description.s_description, ' . $dao->getTablePrefix() . 't_item_location.s_country, ' .
        $dao->getTablePrefix() . 't_item_location.s_address, ' . $dao->getTablePrefix() . 't_item_location.s_zip, ' .
        $dao->getTablePrefix() . 't_item_location.s_region, ' . $dao->getTablePrefix() . 't_item_location.s_city, ' .
        $dao->getTablePrefix() . 't_item_location.s_city_area, ' . $dao->getTablePrefix() . 't_item.i_price, ' .
        $dao->getTablePrefix() . 't_item.fk_c_currency_code, ' . $dao->getTablePrefix() . 't_item.s_contact_name, ' .
        $dao->getTablePrefix() . 't_item.pk_i_id, ' . $dao->getTablePrefix() . 't_item.s_contact_email';

    $from = $dao->getTablePrefix() . 't_category_description, ' . $dao->getTablePrefix() . 't_item_description, ' .
        $dao->getTablePrefix() . 't_item_location, ' . $dao->getTablePrefix() . 't_item';

    $where = $dao->getTablePrefix() . 't_category_description.fk_i_category_id =' . $dao->getTablePrefix() . 't_item.fk_i_category_id AND ' .
        $dao->getTablePrefix() . 't_item.pk_i_id  =' . $dao->getTablePrefix() . 't_item_description.fk_i_item_id AND ' .
        $dao->getTablePrefix() . 't_item.pk_i_id  =' . $dao->getTablePrefix() . 't_item_location.fk_i_item_id';

    $query = "SELECT " . $select . " FROM " . $from . " WHERE " . $where;

    $results = $dao->dao->query($query);
    return $results->result();
}



function getCustomFields($item_id) {
    $dao = new DAO();
    $select = $dao->getTablePrefix() . 't_meta_fields.s_name, ' . $dao->getTablePrefix() . 't_item_meta.s_value';

    $from =  $dao->getTablePrefix() . 't_meta_fields, ' . $dao->getTablePrefix() . 't_item_meta';

    $where = $dao->getTablePrefix() . 't_item_meta.fk_i_item_id  =' . $item_id . ' AND ' .
        $dao->getTablePrefix() . 't_meta_fields.pk_i_id  =' . $dao->getTablePrefix() . 't_item_meta.fk_i_field_id';

    $query = "SELECT " . $select . " FROM " . $from . " WHERE " . $where;

    $results = $dao->dao->query($query);
    return $results->result();
}
/**
 * Export the ads tp the xml output file
 *
 * @param array $data
 * @param array $tags
 */
function doExport($data, $tags)
{

    if (count($data) > 0) {
        $xml_output = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><listings></listings>');

        foreach ($data as $item) {

            $xml_item = $xml_output->addChild("listing");

            $xml_item->addChild($tags['title'] == "" ? "title" : $tags['title'], $item['s_title'] == null ? "" : $item['s_title']);
            $xml_item->addChild($tags['description'] == "" ? "description" : $tags['description'], $item['s_description'] == null ? "" : $item['s_description']);
            $xml_item->addChild($tags['category'] == "" ? "category" : $tags['category'], $item['s_name'] == null ? "" : $item['s_name']);
            $xml_item->addChild($tags['price'] == "" ? "price" : $tags['price'], $item['i_price'] == null ? "" : $item['i_price']/1000000);
            $xml_item->addChild($tags['currency'] == "" ? "currency" : $tags['currency'], $item['fk_c_currency_code'] == null ? "" : $item['fk_c_currency_code']);
            $xml_item->addChild($tags['country'] == "" ? "country" : $tags['country'], $item['s_country'] == null ? "" : $item['s_country']);
            $xml_item->addChild($tags['region'] == "" ? "region" : $tags['region'], $item['s_region'] == null ? "" : $item['s_region']);
            $xml_item->addChild($tags['city'] == "" ? "city" : $tags['city'], $item['s_city'] == null ? "" : $item['s_city']);
            $xml_item->addChild($tags['area'] == "" ? "area" : $tags['area'], $item['s_city_area'] == null ? null : $item['s_city_area']);
            $xml_item->addChild($tags['zip'] == "" ? "zip" : $tags['zip'], $item['zip'] == null ? "" : $item['zip']);
            $xml_item->addChild($tags['address'] == "" ? "address" : $tags['address'], $item['s_address'] == null ? "" : $item['s_address']);
            $xml_item->addChild($tags['name'] == "" ? "name" : $tags['name'], $item['s_contact_name'] == null ? "" : $item['s_contact_name']);
            $xml_item->addChild($tags['email'] == "" ? "email" : $tags['email'], $item['s_contact_email'] == null ? "" : $item['s_contact_email']);


            // PHOTOS
            $dao = new DAO();
            $dao->dao->select('pk_i_id, s_extension, s_path');
            $dao->dao->from($dao->getTablePrefix() . 't_item_resource');
            $dao->dao->where('fk_i_item_id', $item['pk_i_id']);
            $results = $dao->dao->get()->result();
            $i = 1;
            foreach ($results as $result) {
                $url_image = osc_resource_path() . $result['s_path'] . $result['pk_i_id'] . "." . $result['s_extension'];
                $xml_item->addChild($tags['photo'] == "" ? "photo" . $i : $tags['photo'] . $i, $url_image);
                $i++;
            }

            // CUSTOM FIELDS
            $custom_fields = getCustomFields($item['pk_i_id']);

            foreach ($custom_fields as $field) {
                if ( $field['s_value']!== "")
                    $xml_item->addChild($field['s_name'], $field['s_value']);
            }
        }

        $name = osc_plugin_path(__DIR__) ."/exported_files/os_export.xml";
        $download_name = osc_plugin_url(__FILE__) . "exported_files/os_export.xml";
        $res = file_put_contents($name, $xml_output->asXML());
        if ( $res === FALSE) {
            $message = "<strong>". __("Error happened generating XML file", 'pro_xml_ads'). "</strong>";
            osc_add_flash_error_message(__($message, 'pro_xml_ads'), 'admin');
        }
        else {
            $message = "<strong>". __("XML Generated successfully:", 'pro_xml_ads'). " " ."</strong><a href='$download_name' target='_blank'>" . basename($name) . "</a>";
            osc_add_flash_ok_message(__($message, 'pro_xml_ads'), 'admin');
        }

    }
    else {
        osc_add_flash_error_message(__("No ads in the system", 'pro_xml_ads'), 'admin');
    }
    header('Location: ' . osc_admin_render_plugin_url(__DIR__) . "/export.php");
    exit;
}


/**
 * Add error to errors list
 *
 * @param string $default_tags
 * @return array
 */
function getTags($default_tags)
{
    return array(
        "category" => $default_tags ? "category" : Params::getParam('category_tag'),
        "title" => $default_tags ? "title" : Params::getParam('title_tag'),
        "description" => $default_tags ? "description" : Params::getParam('description_tag'),
        "price" => $default_tags ? "price" : Params::getParam('price_tag'),
        "currency" => $default_tags ? "currency" : Params::getParam('currency_tag'),
        "country" => $default_tags ? "country" : Params::getParam('country_tag'),
        "region" => $default_tags ? "region" : Params::getParam('region_tag'),
        "city" => $default_tags ? "city" : Params::getParam('city_tag'),
        "area" => $default_tags ? "area" : Params::getParam('area_tag'),
        "zip" => $default_tags ? "zip" : Params::getParam('zip_tag'),
        "address" => $default_tags ? "address" : Params::getParam('address_tag'),
        "name" => $default_tags ? "contactname" : Params::getParam('name_tag'),
        "email" => $default_tags ? "contactemail" : Params::getParam('email_tag'),
        "photo" => $default_tags ? "photo" : Params::getParam('photo_tag')
    );
}