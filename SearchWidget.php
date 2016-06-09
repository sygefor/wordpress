<?php
/*
Plugin Name: Rechercher des formations
Description: Permet de faire une rechercher texte dans les formations
Author: Conjecto
Version: 1.0
Author URI: http://www.conjecto.com
*/

/**
 * Class SearchWidget
 */
class SearchWidget extends WP_Widget
{
    /**
     * @param null $id_base
     * @param string $name
     * @param array $widget_options
     * @param array $control_options
     */
    public function __construct($id_base = null, $name = "Rechercher une formation dans Sygefor3", $widget_options = array(), $control_options = array())
    {
        parent::__construct($id_base, $name, $widget_options, $control_options);
    }

    public function createSearchPlugin()
    {
        register_widget('SearchWidget');
    }

    /**
     * @param array $instance
     */
    public function widget($instance)
    {
        $viewer = Sygefor3Viewer::get_instance();
        echo $viewer->getSearch();
    }
}