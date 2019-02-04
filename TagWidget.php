<?php
/*
Plugin Name: Affiche les tags de Sygefor3
Description: Affiche les tags de Sygefor3 et retourne les résultats d'un axe spécifique quand l'un est sélectionné par l'utilisateur
Author: Conjecto
Version: 1.0
Author URI: http://www.conjecto.com
*/

/**
 * Class TagWidget
 */
class TagWidget extends WP_Widget
{
    /**
     * @param null $id_base
     * @param string $name
     * @param array $widget_options
     * @param array $control_options
     */
    public function __construct($id_base = null, $name = "Tags de Sygefor3", $widget_options = array(), $control_options = array())
    {
        parent::__construct($id_base, $name, $widget_options, $control_options);
    }

    public function createTagPlugin()
    {
        register_widget('TagWidget');
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
        echo $viewer->getTags();
    }
}