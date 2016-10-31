<?php


$ope_name = "YouTube Player";

function ope_code_add_admin() {
    global $ope_name;
    add_options_page(__('Settings').': '.$ope_name, $ope_name, 'edit_themes', basename(__FILE__), 'ope_code_to_admin');
}


function ope_code_to_admin() {
    global $ope_name;
?>

    <div class="wrap">
        <?php
        echo '<h2>'.__('Settings').': '.$ope_name.'</h2>';

        if (isset($_POST['save'])) {
            update_option('ops_api_key_youtube', stripslashes($_POST['api_key']));
            update_option('ops_channel_id_youtube', stripslashes($_POST['channel_id_youtube']));

            echo '<div id="setting-error-settings_updated" class="updated settings-error"><p><b>'.__('Settings saved.').'</b></p></div>';
        }

        ?>
        <form method="post">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Api secret key:</th>
                    <td>
                        <input name="api_key" class="regular-text" type="text" value="<?php echo get_option('ops_api_key_youtube'); ?>" >
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Channel id:</th>
                    <td>
                        <input name="channel_id_youtube" class="regular-text" type="text" value="<?php echo get_option('ops_channel_id_youtube'); ?>" >
                    </td>
                </tr>
            </table>
            <div class="submit">
                <input name="save" type="submit" class="button-primary" value="<?php echo __('Save'); ?>" />
            </div>
        </form>

    </div>
    <?php
}

add_action('admin_menu', 'ope_code_add_admin');

