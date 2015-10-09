<?php

include_once ROOT_REST_DIR . "/database/executer.db.php";
include_once ROOT_REST_DIR . "/database/query_generator.db.php";


class ResourceController
{

    var $db_executer;
    var $query_generator;

    public function __construct()
    {
        self::create_db_executer();
        self::create_query_generator();
    }

    private function create_db_executer()
    {
        $this->db_executer = new DBExecuter();
    }

    private function create_query_generator()
    {
        $this->query_generator = new QueryGenerator();
    }

    public function execute_request($request, $connection)
    {
        switch ($request->get_method()) {
            case "GET":
                return self::execute_get_request($request, $connection);
            case "POST":
                return self::execute_post_request($request, $connection);
            case "PUT":
                return self::execute_put_request($request, $connection);
            case "DELETE":
                return self::execute_delete_request($request, $connection);
            default:
                return json_encode(new HTTPStatus(405), JSON_PRETTY_PRINT);
        }
    }

    public function execute_get_request($request, $connection)
    {
        if ($request->has_parameters() && $request->has_composed_uri()) {
            return json_encode(new HTTPStatus(400), JSON_PRETTY_PRINT);
        } else if ($request->has_parameters()) {
            return self::get_by_parameters($request->get_parameters(), $request->get_resource(), $connection);
        } else
            return self::get_by_uri($request->get_uri(), $connection);
    }

    private function get_by_parameters($parameters, $resource)
    {
        //TODO
    }

    private function get_by_uri($uri, $connection)
    {
        $query = $this->query_generator->get_uri_query($uri);

        if ($query !== NULL)
            return $this->db_executer->select($query, $connection);

        return json_encode(new HTTPStatus(404), JSON_PRETTY_PRINT);
    }

    public function execute_post_request($request, $connection)
    {
        //TODO
    }

    public function execute_put_request($request, $connection)
    {
        //TODO	
    }

    public function execute_delete_request($request, $connection)
    {
        //TODO
    }
}