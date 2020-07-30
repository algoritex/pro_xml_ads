<?php if (!defined('OC_ADMIN') || OC_ADMIN!==true) exit('Access is not allowed.');
admin_header();
?>

<div class="proheader ui-rounded-corners">
    <?php pro_xml_menu_bar("EXPORT") ?>
</div>

<div class="form-wrapper ui-rounded-corners">

    <form id="export_form" class="form-horizontal" action="<?php
    echo osc_admin_render_plugin_url( basename(dirname(__FILE__)) . "/export_server.php"); ?>" method="post">

        <div class="export_options ui-rounded-corners">
            <div class="form-row">
                <div class="form-label"><?php echo __('Default tag names', 'pro_xml_ads'); ?></div>
                <div class="form-controls">
                    <input class="checkbox_custom_tag" name="default_tags" value="1" type="checkbox">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input class="btn btn-submit" value="<?php echo osc_esc_html (__('Do Export', 'pro_xml_ads')); ?>" type="submit">
                </div>

            </div>
            <div class="custom_tags">
                <h5> <?php echo __('Custom tags', 'pro_xml_ads'); ?> </h5>

                <hr>
                <br>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Category', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="category_tag" name="category_tag" type="text" placeholder="category"/>
                        >
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-label"><?php echo __('Title', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="title_tag" name="title_tag" type="text" placeholder="title"/>
                        >
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-label"><?php echo __('Description', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="description_tag" name="description_tag" type="text"
                               placeholder="description"/>
                        >
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-label"> <?php echo __('Price', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="price_tag" name="price_tag" type="text" placeholder="price"/>
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Currency', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="currency_tag" name="currency_tag" type="text" placeholder="currency"/>
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Country', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="country_tag" name="country_tag" type="text" placeholder="country"/>
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Region', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="region_tag" name="region_tag" type="text" placeholder="region"/>
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('City', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="city_tag" name="city_tag" type="text" placeholder="city"/>
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('City Area', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="area_tag" name="area_tag" type="text" placeholder="city_area"/>
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Address', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="address_tag" name="address_tag" type="text" placeholder="address"/>
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Zip', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="zip_tag" name="zip_tag" type="text" placeholder="zip"/>
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Name', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="name_tag" name="name_tag" type="text" placeholder="contactname"/>
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-label"><?php echo __('Email', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="email_tag" name="email_tag" type="text" placeholder="contactemail"/>
                        >
                    </div>
                </div>

                <!-- Tag image -->
                <div class="form-row">
                    <div class="form-label"><?php echo __('Photos', 'pro_xml_ads'); ?></div>
                    <div class="form-controls">
                        <
                        <input id="photo_tag" name="photo_tag" type="text" placeholder="photo"/>
                        >
                    </div>
                </div>
            </div>

        </div>

    </form>
</div>

<?php
pro_xml_footer() ?>