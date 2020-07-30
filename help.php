<?php if (!defined('OC_ADMIN') || OC_ADMIN!==true) exit('Access is not allowed.');

?>

<div class="proheader">
    <?php pro_xml_menu_bar("HELP") ?>
</div>

<div class="form-wrapper ui-rounded-corners">

    <div class="import">
        <h2><?php echo __('Import', 'pro_xml_ads'); ?></h2>

        <p>
            <?php echo __('The import feature allows you to import ads from a XML file to your system.', 'pro_xml_ads'); ?>
        </p>

        <p>
        <h4><?php echo __('Steps:', 'pro_xml_ads'); ?> </h4>
        <table>
            <tr>
                <td>
                    <ul>
                        <li> <?php echo __('1) Load from an url or from your HD', 'pro_xml_ads'); ?></li>
                        <li> <?php echo __('2) Set the corresponding xml tags from your file', 'pro_xml_ads'); ?></li>
                        <li> <?php echo __('3) Make sure the tags name you set match with the ones of the XML file', 'pro_xml_ads'); ?></li>
                        <li> <?php echo __('4) Execute the import', 'pro_xml_ads'); ?></li>
                    </ul>
                </td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td>
                    <img src="<?php echo osc_esc_html(osc_plugin_url(__FILE__))?>/images/help1.jpg">
                </td>
            </tr>
        </table>


        </p>
        <h4><?php echo __('Notes:', 'pro_xml_ads'); ?></h4>
        <ul>
            <li> <?php echo __("- Categories that do not exist in the system will be skipped by default. To create non existent categories mark, the checkbox Create non existent categories", 'pro_xml_ads'); ?></li>
            <li> <?php echo __('- When executing the import, in case mandatory tag is not found or found with a wrong value, the ad will be skiped from the importation', 'pro_xml_ads'); ?>
            </li>
            <li> <?php echo __('- Default Data: Lets you to assign default values for all the ad. In case both default data and tags are define, the tag value will have preference', 'pro_xml_ads'); ?></li>
            <li> <?php echo __('- Mandatories attributes are [ XML url, Category, Email, Title, Description ]. These  values need to be set via default values or the corresponding XML tag', 'pro_xml_ads'); ?>
            <li> <?php echo __('fotoHelp', 'pro_xml_ads'); ?>
            <li> <?php echo __('- Custom fields that do not exist will be created will be created automatically in the system', 'pro_xml_ads'); ?>
            </li>
        </ul>
    </div>

    <div class="export">
        <h2><?php echo __('Export', 'pro_xml_ads'); ?></h2>

        <p>
            <?php echo __('Export feature allows you to export all ads of your system into a single XML file', 'pro_xml_ads'); ?>
        </p>
        <h4><?php echo __('Notes:', 'pro_xml_ads'); ?></h4>
        <ul>
            <li> <?php echo __('- Default tags are: [ category, title, description, price, currency country, region, city, area, zip, address, name, email ]', 'pro_xml_ads'); ?></li>
            <li> <?php echo __('- Default Tag Photo is: [ photo ]. It will be added to xml followed by the position: &lt;photo1&gt;&lt;photo1/&gt;&lt;photo2&gt;&lt;photo2/&gt;&lt;photo3&gt;&lt;photo3/&gt;&lt;photo4&gt;&lt;photo4/&gt; ...', 'pro_xml_ads'); ?>
            </li>
            <li> <?php echo __('- Tags not defined by the user will use its corresponding default tag', 'pro_xml_ads'); ?></li>
        </ul>

    </div>

</div>


<?php pro_xml_footer() ?>


