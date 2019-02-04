<div class="wrap">
    <h2>Sygefor3 Viewer</h2>
    <form method="post" action="options.php">
        <?php settings_fields('sygefor3-viewer-settings-group'); ?>
        <?php do_settings_sections('sygefor3-viewer-settings-group'); ?>
        <?php $code = get_option('sygefor3_urfist_code'); ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Sélectionner l'URFIST</th>
                <td>
                    <select name="sygefor3_urfist_code">
                        <option <?php if ($code === null ) echo 'selected' ; ?> value=null>Aucun</option>
                        <option <?php if ($code === "bordeaux" ) echo 'selected' ; ?> value="bordeaux">Bordeaux</option>
                        <option <?php if ($code === "lyon" ) echo 'selected' ; ?> value="lyon">Lyon</option>
                        <option <?php if ($code === "nice" ) echo 'selected' ; ?> value="nice">Méditerranée</option>
                        <option <?php if ($code === "paris" ) echo 'selected' ; ?> value="paris">Paris</option>
                        <option <?php if ($code === "rennes" ) echo 'selected' ; ?> value="rennes">Rennes</option>
                        <option <?php if ($code === "strasbourg" ) echo 'selected' ; ?> value="strasbourg">Strasbourg</option>
                        <option <?php if ($code === "toulouse" ) echo 'selected' ; ?> value="toulouse">Toulouse</option>
                    </select>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">URL de l'API</th>
                <td><input type="text" size="50" name="sygefor3_api_address" value="<?php echo esc_attr(get_option('sygefor3_api_address'));?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Identifiant de la page listant les sessions</th>
                <td><input type="number" name="sygefor3_session_list_page" value="<?php echo esc_attr(get_option('sygefor3_session_list_page'));?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Identifiant de la page détaillant une formation</th>
                <td><input type="number" name="sygefor3_training_page" value="<?php echo esc_attr(get_option('sygefor3_training_page'));?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row">Identifiant de la page agenda des sessions</th>
                <td><input type="number" name="sygefor3_calendar_page" value="<?php echo esc_attr(get_option('sygefor3_calendar_page'));?>" /></td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>