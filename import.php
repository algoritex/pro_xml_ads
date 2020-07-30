<?php if (!defined('OC_ADMIN') || OC_ADMIN !== true) exit('Access is not allowed.');
?>

    <div class="proheader ui-rounded-corners">
        <?php pro_xml_menu_bar("IMPORT");
        ?>
    </div>

    <div class="form-wrapper">

        <form id="xml_form" enctype="multipart/form-data" class="form-horizontal" action="<?php
        echo osc_admin_render_plugin_url(basename(dirname(__FILE__)) . "/import_server.php"); ?>" method="post">
            <div class="xml_tags ui-rounded-corners">

                <h5 class="text-center"><?php echo __('Insert XML Tags', 'pro_xml_ads'); ?></h5>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Tag Category', 'pro_xml_ads'); ?></div>
                    <div class="form-controls"><
                        <input id="category_tag" name="category_tag" type="text" placeholder="category"/>> *
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-label"><?php echo __('Tag Title', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="title_tag" name="title_tag" type="text" placeholder="title"/>
                        >*
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-label"><?php echo __('Tag Description', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="description_tag" name="description_tag" type="text"
                               placeholder="description"/>
                        >*
                    </div>

                </div>


                <div class="form-row">
                    <div class="form-label"><?php echo __('Tag Price', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="price_tag" name="price_tag" type="text" placeholder="price"/>
                        >
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Tag Currency', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="currency_tag" name="currency_tag" type="text" placeholder="currency"/>
                        >
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Tag Country', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="country_tag" name="country_tag" type="text" placeholder="country"/>
                        >
                    </div>

                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Tag Region', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="region_tag" name="region_tag" type="text" placeholder="region"/>
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Tag City', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="city_tag" name="city_tag" type="text" placeholder="city"/>
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Tag City Area', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="area_tag" name="area_tag" type="text" placeholder="city_area"/>
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Tag Address', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="address_tag" name="address_tag" type="text" placeholder="address"/>
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Tag Zip', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="zip_tag" name="zip_tag" type="text" placeholder="zip"/>
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Tag Name', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="name_tag" name="name_tag" type="text" placeholder="contactname"/>
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Tag Email', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="email_tag" name="email_tag" type="text" placeholder="contactemail"/>
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Tag Fotos', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="picture_tag" name="picture_tag" type="text" placeholder="photo"/>
                        >
                    </div>
                    <br>

                </div>
                <small>
                    <strong> <?php echo __('TextPhotosTag', 'pro_xml_ads'); ?>
                    </strong>

                </small>
                <div class="form-row">
                    <div class="form-label"><?php echo __('AddCustomField', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <a class="btn btn-green ico ico-32 ico-add-white" id="custom_field_button"></a>
                    </div>
                </div>
                <br>
                <br>
                <br>

                <div id="custom_fields">
                </div>
            </div>


            <div class="xml_options ui-rounded-corners">
                <h5 class="text-center"><?php echo __('File Options', 'pro_xml_ads'); ?>  </h5>

                <div class="form-row">
                    <div class="form-label"><?php echo __('XML URL', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <input id="xml_feed" name="xml_feed" class="input-large" type="text"
                               placeholder="XML url"/>*
                    </div>
                </div>
              <small>
                    <a href="http://proxml-demo.algoritex.com/oc-content/plugins/pro_xml_ads/examples/example.xml"
                       target="_blank">
                        http://proxml-demo.algoritex.com/oc-content/plugins/pro_xml_ads/examples/example.xml
                    </a>
                </small>
                <br>
                <small>
                    <a href="http://proxml-demo.algoritex.com/oc-content/plugins/pro_xml_ads/examples/example100.xml"
                       target="_blank">
                        http://proxml-demo.algoritex.com/oc-content/plugins/pro_xml_ads/examples/example100.xml
                    </a>
                </small>
                <br>
                <small>
                    <a href="http://proxml-demo.algoritex.com/oc-content/plugins/pro_xml_ads/examples/example_custom_fields.xml"
                       target="_blank">
                        http://proxml-demo.algoritex.com/oc-content/plugins/pro_xml_ads/examples/example_custom_fields.xml
                    </a>
                </small>

                <br>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Upload XML File', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <input name="uploaded_xml" id="uploaded_xml" type="file"> *
                    </div>
                </div>

                <br>
                <hr class="hr_proxml">
                <h5 class="text-center"><?php echo __('Default Data', 'pro_xml_ads'); ?>  </h5>

                <div class="form-row">
                    <div class="form-label">
                        <strong><?php echo __('Create non existent categories', 'pro_xml_ads'); ?></strong></div>
                    <div class="form-controls">
                        <input name="create_category" id="create_category" value="true" type="checkbox">
                    </div>
                </div>

                <br>

                <div id="default_category">
                    <div class="form-row">
                        <div class="form-label"><?php echo __('Default Category', 'pro_xml_ads'); ?></div>
                        <div class="form-controls">
                            <select class="" id="category" name="category">
                                <option value="0"><?php echo __('Select Default Category', 'pro_xml_ads'); ?></option>
                                <?php
                                $result = Category::newInstance()->findRootCategories();
                                foreach ($result as $row) {
                                    echo "<option value='" . osc_esc_html($row['s_name']) . "'>" . strtoupper($row['s_name']) . "</option>";
                                    $subcategories = Category::newInstance()->findSubcategories($row['fk_i_category_id']);
                                    foreach ($subcategories as $subcategory)
                                        echo "<option value='" . osc_esc_html($subcategory['s_name']) . "'>" . $subcategory['s_name'] . "</option>";
                                }
                                ?>
                            </select> *
                        </div>
                    </div>
                </div>

                <div id="default_name">
                    <div class="form-row">
                        <div class="form-label"><?php echo __('Default Contact Name', 'pro_xml_ads'); ?></div>
                        <div class="form-controls">
                            <input id="name" name="name" type="text"/>
                        </div>
                    </div>
                </div>

                <div id="default_email">
                    <div class="form-row">
                        <div class="form-label"><?php echo __('Default Contact Email', 'pro_xml_ads'); ?></div>
                        <div class="form-controls">
                            <input id="email" name="email" type="text"/> *
                        </div>
                    </div>
                </div>

                <div id="default_currency">
                    <div class="form-row">
                        <div class="form-label"><?php echo __('Default Currency', 'pro_xml_ads'); ?></div>
                        <div class="form-controls">
                            <select class="" id="currency" name="currency">
                                <option value="0"><?php echo __('Select Default Currency', 'pro_xml_ads'); ?></option>
                                <?php
                                $result = Currency::newInstance()->listAll();
                                foreach ($result as $row)
                                    echo "<option value='" . $row['pk_c_code'] . "'>" . strtoupper(utf8_encode($row['pk_c_code'])) . "</option>";
                                ?>
                            </select>
                        </div>
                    </div>
                </div>


                <div id="default_country">
                    <div class="form-row">
                        <div class="form-label"><?php echo __('Default Country', 'pro_xml_ads'); ?></div>
                        <div class="form-controls">
                            <input id="country" name="country" type="text"/>
                        </div>
                    </div>
                </div>

                <div id="default_region">
                    <div class="form-row">
                        <div class="form-label"><?php echo __('Default Region', 'pro_xml_ads'); ?></div>
                        <div class="form-controls">
                            <input id="region" name="region" type="text"/>
                        </div>
                    </div>
                </div>
                <div id="default_city">
                    <div class="form-row">
                        <div class="form-label"><?php echo __('Default City', 'pro_xml_ads'); ?></div>
                        <div class="form-controls">
                            <input id="city" name="city" type="text"/>
                        </div>
                    </div>
                </div>
                <div id="default_area">
                    <div class="form-row">
                        <div class="form-label"><?php echo __('Default City Area', 'pro_xml_ads'); ?></div>
                        <div class="form-controls">
                            <input id="area" name="area" type="text"/>
                        </div>
                    </div>
                </div>

                <div id="default_area">
                    <div class="form-row">
                        <div class="form-label"><?php echo __('Default Expiration Days', 'pro_xml_ads'); ?></div>
                        <div class="form-controls">
                            <input id="expire" name="expire" type="text"/>
                            <?php echo __('Empty or 0, never expires', 'pro_xml_ads'); ?>
                        </div>
                    </div>
                </div>

                <div id="default_currency">
                    <div class="form-row">
                        <div class="form-label"><?php echo __('Userads', 'pro_xml_ads'); ?></div>
                        <div class="form-controls">
                            <select class="" id="user_id" name="user_id">
                                <option value=""><?php echo __('Default User', 'pro_xml_ads'); ?></option>
                                <?php
                                $result = User::newInstance()->listAll();
                                foreach ($result as $row)
                                    echo "<option value='" . $row['pk_i_id'] . "'>" . strtoupper(utf8_encode($row['s_username'])) . "</option>";
                                ?>
                            </select>
                        </div>

                    </div>
                    <small>
                        <strong> <?php echo __('TextChooseUser', 'pro_xml_ads'); ?>
                        </strong>

                    </small>
                </div>
                <div class="submit_div">
                    <div class="form-controls">
                        <input class="btn btn-submit" value="<?php echo osc_esc_html(__('Load XML', 'pro_xml_ads')); ?>"
                               type="submit">
                    </div>
                </div>

            </div>


        </form>
    </div>

<?php

pro_xml_footer() ?>