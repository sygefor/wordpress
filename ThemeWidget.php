<?php
/*
Plugin Name: Affiche les axes de formations de Sygefor3
Description: Affiche les axes de formations de Sygefor3 et retourne les résultats d'un axe spécifique quand l'un est sélectionné par l'utilisateur
Author: Conjecto
Version: 1.0
Author URI: http://www.conjecto.com
*/

/**
 * Class ThemeWidget
 */
class ThemeWidget extends WP_Widget
{
    /**
     * @param null $id_base
     * @param string $name
     * @param array $widget_options
     * @param array $control_options
     */
    public function __construct($id_base = null, $name = "Axes de formation de Sygefor3", $widget_options = array(), $control_options = array())
    {
        parent::__construct($id_base, $name, $widget_options, $control_options);
    }

    public function createThemePlugin()
    {
        register_widget('ThemeWidget');
    }

	/**
	 * @param array $args
	 * @param array $instance
	 *
	 * @throws Exception
	 */
	public function widget($args, $instance)
    {
        $viewer = Sygefor3Viewer::get_instance();
        echo $viewer->getThemes();
    }
}