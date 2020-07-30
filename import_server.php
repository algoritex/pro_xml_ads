<?php

/**
 * Created by Algoritex.com
 * algoritex@gmail.com
 * 30/30/2019
 */

if (!defined('OC_ADMIN') || OC_ADMIN !== true) exit('Access is not allowed.');


if (Params::getParam('xml_feed') == "")
    $xml_feed = $_FILES['uploaded_xml']['tmp_name'];
else
    $xml_feed = trim(Params::getParam('xml_feed'));

if (Params::getParam('create_category') == "true")
    $create_categories = true;
else
    $create_categories = false;


$xml = loadXML($xml_feed);


if (!$xml) {
    osc_add_flash_error_message(__("Error, XML not found or wrong", 'admin'), 'admin');
    header('Location: ' . osc_admin_render_plugin_url(__DIR__) . "/import.php");
    exit;
}


doImport($xml, $create_categories);


/**
 * Main function which imports all ads from the xml feed
 *
 * @param string $xml
 * @param string $create_categories
 */
function doImport($xml, $create_categories)
{

    if (isset($xml)) {
        $current_ad = 1;
        $line_item = 3;
        $error = [];
        $totalads = countAds($xml);
        $success = 0;
        $data = Params::getParamsAsArray();

        foreach ($xml as $key) {

            $item = getAd($key, $data);

            $check = checkRequired($item);

            if ($check == "OK") {
                $item['catId'] = getCategoryByName($item['category']);

                if ($item['catId'] == null) {
                    if ($create_categories) {
                        $item['catId'] = createCategory($item['category']);
                        $save_result = saveAd($item);
                        if ($save_result == 2)
                            $success++;
                        else
                            $error[] = addError($line_item, $current_ad, $save_result);
                    } else {
                        $error[] = addError($line_item, $current_ad, "Category doesn't exists");
                    }
                } else {
                    $save_result = saveAd($item);
                    if ($save_result == 2)
                        $success++;
                    else
                        $error[] = addError($line_item, $current_ad, $save_result);
                }
            } else {
                $error[] = addError($line_item, $current_ad, $check);
            }
            $line_item += $key->count() + 2;
            $current_ad++;
            unset($item);
        }

        $results = array(
            'total_ads' => $totalads,
            'num_success' => $success,
            'num_failed' => $xml->count() - $success,
            'list_errors' => $error,
        );
        $message = "<strong>" . __('Total Ads:', 'pro_xml_ads') . "</strong> " . " " . $results['total_ads'] . "<br><strong> " . __('Success:', 'pro_xml_ads') . "</strong>" .
            " " . $results['num_success'] . "<br> <strong>" . __('Failed:', 'pro_xml_ads') . " </strong>" . " " . $results['num_failed'];
        $message_error = "<br><br><h3>" . __('Errors:', 'pro_xml_ads') . " <h3/>";

        if ($results["list_errors"] != "") {
            $message_error .= "<ul>";
            foreach ($results["list_errors"] as $error_item) {
                $message_error .= "<li>" . __('Item:', 'pro_xml_ads') . " " . $error_item['xml_item_error'] . __('Line:', 'pro_xml_ads') . " " .
                    $error_item['xml_line_error'] . "    " . $error_item['error'] . "</li>";
            }
            $message_error .= "</ul>";
        }


        if ($results['total_ads'] == $results['num_success'])
            osc_add_flash_ok_message(__($message), 'admin');
        else if ($results['total_ads'] == $results['num_failed'])
            osc_add_flash_error_message(__($message) . $message_error, 'admin');
        else
            osc_add_flash_info_message(__($message . $message_error), 'admin');

        header('Location: ' . osc_admin_render_plugin_url(__DIR__) . "/import.php");

    } else {
        osc_add_flash_error_message(__("Error, XML not found or wrong", 'pro_xml_ads'), 'admin');
        header('Location: ' . osc_admin_render_plugin_url(__DIR__) . "/import.php");
    }
}


/**
 * Add error to errors list
 *
 * @param string $line_item
 * @param string $current_ad
 * @param string $save_result
 * @return array
 */
function addError($line_item, $current_ad, $save_result)
{
    return array(
        'xml_line_error' => $line_item,
        'xml_item_error' => $current_ad,
        'error' => $save_result
    );
}


/**
 * Work out the right values for the ads regarding the tags provided
 *
 * @param string $key
 * @param string $tags
 * @return array
 */

function getAd($key, $tags)
{

    $item = array();

    $description[osc_current_user_locale()] = htmlspecialchars(strval($key->{$tags['description_tag']}));
    $title[osc_current_user_locale()] = strval($key->{$tags['title_tag']});

    $item['category'] = isset($key->{$tags['category_tag']}) ? strval($key->{$tags['category_tag']}) : strval($tags['category']);
    $item['contactName'] = isset($key->{$tags['name_tag']}) ? strval($key->{$tags['name_tag']}) : $tags['name'];
    $item['contactEmail'] = isset($key->{$tags['email_tag']}) ? strval($key->{$tags['email_tag']}) : $tags['email'];
    $item['title'] = $title;
    $item['description'] = $description;
    $item['price'] = isset($key->{$tags['price_tag']}) ? strval($key->{$tags['price_tag']}) : $tags['price'];
    $item['region'] = isset($key->{$tags['region_tag']}) ? strval($key->{$tags['region_tag']}) : $tags['region'];
    $item['city'] = isset($key->{$tags['city_tag']}) ? strval($key->{$tags['city_tag']}) : $tags['city'];
    $item['cityArea'] = isset($key->{$tags['area_tag']}) ? strval($key->{$tags['city_tag']}) : $tags['area'];
    $item['address'] = strval($key->{$tags['address_tag']});
    $item['zip'] = strval($key->{$tags['zip_tag']});
    $item['user_id'] = ($tags['user_id'] != "") ? strval($tags['user_id']) : null;


    $country_name = isset($key->{$tags['country_tag']}) ? strval($key->{$tags['country_tag']}) : $tags['country'];
    $country = Country::newInstance()->findByName($country_name);
    if (!empty($country)) {
        $item['countryId'] = $country['pk_c_code'];
        $item['country'] = $country['s_name'];
    }

    $region_name = isset($key->{$tags['region_tag']}) ? strval($key->{$tags['region_tag']}) : $tags['region'];
    $region = Region::newInstance()->findByName($region_name);
    if (!empty($country)) {
        $item['regionId'] = $region['pk_i_id'];
        $item['region'] = $region['s_name'];
    } else {
        $item['region'] = $region_name;
    }

    $city_name = isset($key->{$tags['city_tag']}) ? strval($key->{$tags['city_tag']}) : $tags['city'];
    $city = City::newInstance()->findByName($city_name);
    if (!empty($country)) {
        $item['cityId'] = $city['pk_i_id'];
        $item['city'] = $city['s_name'];
    } else {
        $item['city'] = $city_name;
    }

    if (isset($tags['custom_field'])) {
        foreach ($tags['custom_field'] as $custom_field) {

            $input_name = strval($custom_field);
            $value = strval($key->$custom_field);
            if ($input_name !== "" && $value !== "") {
                $field = Field::newInstance()->findByName($input_name);
                if (empty($field)) {
                    $dao = new DAO();
                    $query = "SELECT pk_i_id FROM " . $dao->getTablePrefix() . 't_category';
                    $categories = $dao->dao->query($query)->result();
                    $array_cat = null;
                    foreach ($categories as $c)
                        $array_cat[] = $c['pk_i_id'];
                    Field::newInstance()->insertField(strval($custom_field), "TEXT", strval($custom_field), "", "", $array_cat);
                    $field = Field::newInstance()->findByName($input_name);
                    $item['meta'][$field['pk_i_id']] = $value;
                } else {
                    $item['meta'][$field['pk_i_id']] = $value;
                }
            }
        }
    }

    if (isset($tags['expire']) && $tags['expire'] !== "" && $tags['expire'] !== "0")
        $item['dt_expiration'] = date('Y-m-d H:i:s', strtotime("+" . strval($tags['expire']) . " days"));

    if (isset($key->{$tags['currency_tag']}))
        $item['currency'] = strval($key->{$tags['currency_tag']});
    else if ($tags['currency'] == "0")
        $item['currency'] = null;
    else
        $item['currency'] = $tags['currency'];

    $item['active'] = "ACTIVE";

    $item['photos'] = array();

    if (isset($tags['picture_tag'])) {
        for ($i = 1; $i < 21; $i++) {
            $k = $tags['picture_tag'] . $i;
            $value = strval($key->$k);
            if ($value !== "")
                $item['photos'][] = $value;
        }
    }

    return $item;
}


function check_currency($currency)
{
    return Currency::newInstance()->findByPrimaryKey($currency);
}

/**
 * Verify if all the item madatory tags are set for the item
 *
 * @param array $item
 * @return string
 */
function checkRequired($item)
{
    if ($item['category'] == "") {
        return __("Error, category tag not found", 'pro_xml_ads');
    } else if ($item['contactEmail'] == "") {
        return __("Error, email tag not found", 'pro_xml_ads');
    } else if ($item['title'][osc_current_user_locale()] == "") {
        return __("Error, title tag not found", 'pro_xml_ads');
    } else if ($item['description'][osc_current_user_locale()] == "") {
        return __("Error, description tag not found", 'pro_xml_ads');
    } /*
    else if ( isset($item['currency']) && !check_currency($item['currency'])) {
        return __("Error, Currency " .$item['currency']. " not found",'pro_xml_ads');
    }*/
    else {
        return __("OK", 'pro_xml_ads');
    }
}


/**
 * Get the category id
 *
 * @param string $name
 * @return string
 */
function getCategoryByName($name)
{

    $name = trim($name);
    $dao = new DAO();
    $dao->dao->select('fk_i_category_id');
    $dao->dao->from($dao->getTablePrefix() . 't_category_description');
    $dao->dao->where('s_name', $name);
    $dao->dao->orderBy('fk_c_locale_code');
    $results = $dao->dao->get();
    if (isset($results))
        return $results->result()[0]['fk_i_category_id'];

    return null;
}


/**
 * Check and load the XML if exits otherwise retun null
 *
 * @param $xml
 * @return string
 */

function loadXML($xml)
{
    if (@fopen($xml, 'r')) {
        @fclose($xml);
        return simplexml_load_file($xml);
    } else {
        return FALSE;
    }
}

/**
 * Counts the total items for the XML input file
 *
 * @param string $XML
 * @return int
 */
function countAds($XML)
{
    return count($XML);
}

/**
 * Create a new category
 *
 * @param string $category_name
 * @return int
 */
function createCategory($category_name)
{
    $category = array(
        "fk_i_parent_id" => NULL,
        "b_enabled" => 1,
        "b_price_enabled" => 1,
        "i_expiration_days" => 0,
        "i_position" => 0
    );

    $category_description = array(osc_current_user_locale() => (array('s_name' => $category_name)));
    return Category::newInstance()->insert($category, $category_description);
}


/**
 * Create a new subcategory
 *
 * @param int $parent_id
 * @param string $sub_cat_name
 * @return int
 */
function createSubCategory($parent_id, $sub_cat_name)
{
    $category = array(
        "fk_i_parent_id" => $parent_id,
        "b_enabled" => 1,
        "b_price_enabled" => 1,
        "i_expiration_days" => 0,
        "i_position" => 0
    );

    $category_description = array(osc_current_user_locale() => (array('s_name' => $sub_cat_name)));

    return Category::newInstance()->insert($category, $category_description);
}


/**
 * Insert the item ad into the system
 *
 * @param array $item
 * @return int
 */
function saveAd($item)
{
    $list_items = new ItemActions(true);
    Params::setParam('userId', $item['user_id']);
    Params::setParam('catId', $item['catId']);
    Params::setParam('contactName', $item['contactName']);
    Params::setParam('contactEmail', $item['contactEmail']);
    Params::setParam('title', $item['title']);
    Params::setParam('description', $item['description']);
    Params::setParam('price', $item['price']);
    Params::setParam('countryId', $item['countryId']);
    Params::setParam('country', $item['country']);
    Params::setParam('region', $item['region']);
    Params::setParam('regionId', $item['regionId']);
    Params::setParam('city', $item['city']);
    Params::setParam('cityId', $item['cityId']);
    Params::setParam('cityArea', $item['cityArea']);
    Params::setParam('address', $item['address']);
    Params::setParam('currency', $item['currency']);
    Params::setParam('zip', $item['zip']);
    Params::setParam('dt_expiration', $item['dt_expiration']);
    Params::setParam('meta', $item['meta']);
    Params::setParam('showEmail', 1);

    $image_list = $item['photos'];

    foreach ($image_list as $image) {

        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $tmp_name = "proxml_" . rand(0, 99999) . "." . $ext;
        $image_ok = osc_downloadFile($image, $tmp_name);

        if ($image_ok) {
            $photos['error'][] = UPLOAD_ERR_OK;
            $photos['size'][] = 0;
            $photos['type'][] = 'image/*';
            $photos['tmp_name'][] = osc_content_path() . "downloads/" . $tmp_name;
        }
    }
    $_FILES['photos'] = $photos;


    $list_items->prepareData(true);

    $list_items->data['userId'] = $item['user_id'];

    $result = $list_items->add();
    if (isset($photos['tmp_name'])) {
        foreach ($photos['tmp_name'] as $photo)
            @unlink(osc_content_path() . "downloads/" . $photo);
    }

    return $result;
}
