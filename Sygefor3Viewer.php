<?php

include_once('Sygefor3Requester.php');
include_once('SearchWidget.php');
include_once('ThemeWidget.php');
include_once('TagWidget.php');

/**
 * Class Sygefor3Viewer
 */
class Sygefor3Viewer
{
    /**
     * A reference to an instance of this class.
     */
    private static $instance;

    /**
     * Returns an instance of this class.
     */
    public static function get_instance()
    {
        if (null == self::$instance) {
            self::$instance = new Sygefor3Viewer();
        }

        return self::$instance;
    }

    /**
     * Initializes the plugin by setting filters and administration functions.
     */
    private function __construct()
    {
        $file = __FILE__;
        $file = str_replace("Sygefor3Viewer.php", "sygefor3-viewer.php", $file);

        // remove plugin datas
        register_deactivation_hook($file, array($this, 'deleteDatas'));

        // add admin menu item to fill-in plugin settings
        add_action('admin_menu', array($this, 'createMenuItem'));

        // add shortcodes
        add_shortcode('sygefor.recherche', array($this, 'getSearch'));
        add_shortcode('sygefor.theme_filters', array($this, 'getThemes'));
        add_shortcode('sygefor.tag_filters', array($this, 'getTags'));
        add_shortcode('sygefor.sessions', array($this, 'getSessions'));
        add_shortcode('sygefor.formation', array($this, 'getTraining'));
        add_shortcode('sygefor.agenda_sessions', array($this, 'getCalendar'));

        // add search and theme widgets
        add_action('widgets_init', array((new SearchWidget()), 'createSearchPlugin'));
        add_action('widgets_init', array((new ThemeWidget()), 'createThemePlugin'));
        add_action('widgets_init', array((new TagWidget()), 'createTagPlugin'));
    }

    /**
     * remove options from db when disable the plugin
     */
    public function deleteDatas()
    {
        delete_option("sygefor3_api_address");
        delete_option("sygefor3_urfist_code");
        delete_option("sygefor3_session_list_page");
        delete_option("sygefor3_training_page");
        delete_option("sygefor3_calendar_page");
    }

    /**
     * Sygefor3 Viewer menu item accessible for administrator only
     */
    public function createMenuItem()
    {
        //create new top-level menu
        add_menu_page('Sygefor3 Viewer Settings', 'Sygefor3 Viewer', 'administrator', __FILE__, array($this, 'getSettingsTemplate'));

        //call register settings function
        add_action('admin_init', array($this, 'registerSettings'));
    }

    /**
     * Return settings view
     */
    public function getSettingsTemplate()
    {
        echo $this->render('settings.php');
    }

    /**
     * register our settings
     */
    public function registerSettings()
    {
        register_setting('sygefor3-viewer-settings-group', 'sygefor3_urfist_code');
        register_setting('sygefor3-viewer-settings-group', 'sygefor3_api_address');
        register_setting('sygefor3-viewer-settings-group', 'sygefor3_session_list_page');
        register_setting('sygefor3-viewer-settings-group', 'sygefor3_training_page');
        register_setting('sygefor3-viewer-settings-group', 'sygefor3_calendar_page');
    }

    /**
     * Return training search form view
     *
     * @return string
     */
    public function getSearch()
    {
        return $this->render('search.php');
    }

	/**
	 * Return theme list view
	 *
	 * @return string
	 * @throws Exception
	 */
    public function getThemes()
    {
        $arguments = $this->defaultArguments();

        if (isset($_POST['search'])) {
            $_GET['search'] = $_POST['search'];
        }
	    $_GET['search'] = isset($_GET['search']) ? $_GET['search'] : null;
	    $_GET['theme'] = isset($_GET['theme']) ? $_GET['theme'] : null;
	    $_GET['tag'] = isset($_GET['tag']) ? $_GET['tag'] : null;

        $request = new Sygefor3Requester();
        $sessions = $request->getSessions($_GET['search'], NULL, NULL, $arguments);
        return $this->render('themes.php', array('sessions' => $sessions));
    }

	/**
	 *
	 * Return tag list view
	 *
	 * @return string
	 * @throws Exception
	 */
    public function getTags()
    {
        $arguments = $this->defaultArguments();

        if (isset($_POST['search'])) {
            $_GET['search'] = $_POST['search'];
        }
	    $_GET['search'] = isset($_GET['search']) ? $_GET['search'] : null;
	    $_GET['theme'] = isset($_GET['theme']) ? $_GET['theme'] : null;
	    $_GET['tag'] = isset($_GET['tag']) ? $_GET['tag'] : null;

        $request = new Sygefor3Requester();
        $sessions = $request->getSessions($_GET['search'], NULL, NULL, $arguments);;
        return $this->render('tags.php', array('sessions' => $sessions));
    }

	/**
	 * Return session list view
	 * Accessible via shortcode
	 *
	 * @param $arguments
	 *
	 * @return string
	 * @throws Exception
	 */
    public function getSessions($arguments)
    {
        $arguments = $this->reformatArguments($arguments);
        if (isset($_POST['search'])) {
            $_GET['search'] = $_POST['search'];
        }
        $request = new Sygefor3Requester();
        $_GET['search'] = isset($_GET['search']) ? $_GET['search'] : null;
        $_GET['theme'] = isset($_GET['theme']) ? $_GET['theme'] : null;
        $_GET['tag'] = isset($_GET['tag']) ? $_GET['tag'] : null;
        $_GET['num'] = isset($_GET['num']) ? $_GET['num'] : null;

        $sessions = $request->getSessions(
        	stripslashes($_GET['search']),
	        stripslashes($_GET['theme']),
	        stripslashes($_GET['tag']),
	        $arguments,
	        $_GET['num']
        );
        return $this->render('sessions.php', array('sessions' => $sessions));
    }

	/**
	 * Return training view
	 * Accessible via shortcode
	 *
	 * @return string
	 * @throws Exception
	 */
    public function getTraining()
    {
        $request = new Sygefor3Requester();
	    $_GET['search'] = isset($_GET['search']) ? $_GET['search'] : null;
	    $_GET['theme'] = isset($_GET['theme']) ? $_GET['theme'] : null;
	    $_GET['tag'] = isset($_GET['tag']) ? $_GET['tag'] : null;
	    $_GET['num'] = isset($_GET['num']) ? $_GET['num'] : null;
        $training = $request->getTraining($_GET['stage']);
        if ($training) {
            $training['sessions'] = $this->filterSessionsByDate($training['sessions']);
            $session = isset($training['sessions'][0]) ? $training['sessions'][0] : null;
        }

        return $this->render('training.php', array('training' => $training, 'session' => $session));
    }

	/**
	 * Return calendar view with session events
	 * Accessible via shortcode
	 *
	 * @param $arguments
	 *
	 * @return string
	 * @throws Exception
	 */
    public function getCalendar($arguments)
    {
        $arguments = $this->reformatArguments($arguments);

        // insert fullcalendar script and styles
        wp_enqueue_style('fullcalendar', plugin_dir_url(__FILE__) . '/fullcalendar-2.4.0/fullcalendar.min.css');
        wp_enqueue_style('qtip', plugin_dir_url(__FILE__) . '/jquery.qtip.custom/jquery.qtip.min.css');
        wp_enqueue_script('sessionsCalendar', plugin_dir_url(__FILE__) . '/templates/sessionCalendar.js', array('fullcalendar', 'fullcalendarLang'));

	    wp_register_script('moment', plugin_dir_url(__FILE__) . '/fullcalendar-2.4.0/moment.min.js');
	    wp_register_script('qtip', plugin_dir_url(__FILE__) . '/jquery.qtip.custom/jquery.qtip.min.js');
	    wp_register_script('fullcalendarLang', plugin_dir_url(__FILE__) . '/fullcalendar-2.4.0/fr.js');
	    wp_register_script('fullcalendar', plugin_dir_url(__FILE__) . '/fullcalendar-2.4.0/fullcalendar.min.js', array('jquery', 'moment', 'qtip'));

        $request = new Sygefor3Requester();
        $_GET['search'] = isset($_GET['search']) ? stripslashes($_GET['search']) : null;
        $_GET['theme'] = isset($_GET['theme']) ? stripslashes($_GET['theme']) : null;
        $_GET['tag'] = isset($_GET['tag']) ? stripslashes($_GET['tag']) : null;
        $sessions = $request->getSessions($_GET['search'], $_GET['theme'], $_GET['tag'], $arguments);

        return $this->render('calendar.php', array('sessions' => $sessions));
    }

    /**
     * @param $arguments
     *
     * @return array
     */
    protected function reformatArguments($arguments)
    {
        $size = 999;
        $dateBegin = 0;
        $dateEnd = 1000;

        if (isset($arguments['pagination']) && intval($arguments['pagination']) > 0) {
            $size = intval($arguments['pagination']);
        }
        if (isset($arguments['datedebut'])) {
            $dateBegin = intval($arguments['datedebut']);
        }
        if (isset($arguments['datefin'])) {
            $dateEnd = intval($arguments['datefin']);
        }

        return array(
            'size' => $size,
            'dateBegin' => $dateBegin,
            'dateEnd' => $dateEnd
        );
    }

    /**
     * @return array
     */
    protected function defaultArguments()
    {
        return array(
            'size' => 999,
            'dateBegin' => 0,
            'dateEnd' => 1000
        );
    }

    /**
     * Render template, search if templateFile exists in current theme
     *
     * @param $templateName
     * @param array $params
     *
     * @return string
     */
    public function render($templateName, $params = array())
    {
        // if folder sygefor and file $templateName exists in used theme folder, so this file will be used instead of default file
        $templateFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . $templateName;
        if (file_exists(get_template_directory() . DIRECTORY_SEPARATOR . "sygefor" . DIRECTORY_SEPARATOR . $templateName)) {
            $templateFile = get_template_directory() . DIRECTORY_SEPARATOR . "sygefor" . DIRECTORY_SEPARATOR . $templateName;
        }

        ob_start();
        extract($params);
        include($templateFile);
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

	/**
	 * Return only sessions with a date superior to now
	 *
	 * @param $sessions
	 *
	 * @return array
	 * @throws Exception
	 */
    protected function filterSessionsByDate($sessions)
    {
        $arraySessions = array();
        foreach ($sessions as $session) {
            if ((new \Datetime($session['dateBegin'])) >= (new \Datetime("now"))) {
                $arraySessions[] = $session;
            }
        }
        return $arraySessions;
    }
}

// call class when plugin is loaded
add_action('plugins_loaded', array('Sygefor3Viewer', 'get_instance'));