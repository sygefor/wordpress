<?php

/**
 * Make search on sygefor API
 *
 * Class Sygefor3Requester
 */
class Sygefor3Requester
{
    /**
     * @var string
     */
    protected $urfistCode;

    /**
     * @var string
     */
    protected $apiUrl;

    public function __construct()
    {
        $this->urfistCode = get_option('sygefor3_urfist_code');
        $this->apiUrl = get_option('sygefor3_api_address');
        if (!$this->apiUrl || !$this->urfistCode || !get_option('sygefor3_session_list_page') || !get_option('sygefor3_training_page') || !get_option('sygefor3_calendar_page')) {
            throw new Exception('You have to fill-in Sygefor3 Viewer settings');
        }
    }

	/**
	 * Return sessions
	 *
	 * @param null $search
	 * @param null $theme
	 * @param null $tag
	 * @param      $arguments
	 * @param int  $page
	 *
	 * @return array|mixed|object
	 * @throws Exception
	 */
    public function getSessions($search = null, $theme = null, $tag = null, $arguments, $page = 1)
    {
        $dateBegin = new \DateTime("now", timezone_open('Europe/Paris'));
        date_add($dateBegin, date_interval_create_from_date_string($arguments['dateBegin'] . ' months'));

        $dateEnd = new \DateTime("now", timezone_open('Europe/Paris'));
        date_add($dateEnd, date_interval_create_from_date_string($arguments['dateEnd'] . ' months'));

        if ($page < 1) {
            $page = 1;
        }

        $request = [
            "sort" => ["dateBegin" => "asc"],
            "size" => $arguments['size'],
            "query" => [
                "filtered" => [
                    "filter" => [
                        "and" => [
                            ["term" => ["training.organization.code" => $this->urfistCode]],
                            ["range" => ["dateBegin" => ['gte' => $dateBegin->format('Y-m-d')]]],
                            ["range" => ["dateEnd" => ['lte' => $dateEnd->format('Y-m-d')]]]
                        ]]
                    ]
            ],
            "facets" => [
                "theme" => [ "terms" => ["field" => "training.theme.source", "order" => "term"]],
                "tags" => [ "terms" => ["field" => "training.tags.source"]]
            ],
            "from" => $arguments['size'] * ($page - 1)
        ];
        if ($theme) {
            $request['query']['filtered']['filter']['and'][] = ["term" => ["training.theme.source" => $theme]];
        }
        if ($tag) {
            $request['query']['filtered']['filter']['and'][] = ["term" => ["training.tags.source" => $tag]];
        }
        if ($search) {
            $request['query']["filtered"]["query"]["multi_match"] = ['query' => $search, "fields" => ["training.name", "training.program", "training.tags"]];
        }

        return $this->search("training/session", $request);
    }

    /**
     * Return training
     *
     * @param $id
     *
     * @return mixed
     */
    public function getTraining($id)
    {
        if (!$id) {
            return null;
        }

        return $this->search("training/" . strval($id), array());
    }

    /**
     * Search on API
     *
     * @param $address
     * @param $request
     *
     * @return mixed|
     */
    public function search($address, $request)
    {
        $opts = array(
            'http'=>array(
                'method' => "POST",
                'header'=> "Content-type: application/json;charset=UTF-8",
                'content' => json_encode($request)
            )
        );

        $context = stream_context_create($opts);
        $results = @file_get_contents($this->apiUrl . $address, null, $context);
        return json_decode($results, true);
    }
}