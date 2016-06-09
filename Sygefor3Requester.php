<?php

/**
 * Make search on sygefor API
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
     * @param null $theme
     * @param int $size
     * @param null $search
     * @return array|mixed|object
     */
    public function getSessions($theme = null, $size = 999, $search = null)
    {
        $request = [
            "sort" => ["dateBegin" => "asc"],
            "size" => $size,
            "query" => [
                "filtered" => [
                    "filter" => [
                        "and" => [
                            ["term" => ["training.organization.code" => $this->urfistCode]],
                            ["range" => ["dateBegin" => ["gte" => (new \DateTime("now", timezone_open('Europe/Paris')))->format('Y-m-d')]]]
                        ]]
                    ]
            ],
            "facets" => [
                "theme" => [ "terms" => ["field" => "training.theme.source", "order" => "term"]]
            ]
        ];
        if ($theme) {
            $request['query']['filtered']['filter']['and'][] = ["term" => ["training.theme.source" => $theme]];
        }
        if ($search) {
            $request['query']["filtered"]["query"]["multi_match"] = ['query' => $search, "fields" => ["training.name", "training.program"]];
        }

        return $this->search("training/session", $request);
    }

    /**
     * Return training
     * @param $id
     * @return array|mixed|null|object
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
     * @param $address
     * @param $request
     * @return array|mixed|object
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