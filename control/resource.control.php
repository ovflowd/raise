<?php

include_once ROOT_REST_DIR . "/database/executer.db.php";
include_once ROOT_REST_DIR. "/database/connector.db.php";
include_once ROOT_REST_DIR . "/control/queryable.control.php";
include_once ROOT_REST_DIR . "/database/query_generator.db.php";


class ResourceController
{

    var $db_connector;
    var $db_executer;
    var $queryable_controller;
    var $query_generator;

    public function __construct()
    {
        self::create_db_executer();
        self::create_query_generator();
        self::create_queryable_controller();
        self::create_db_connector();
    }

    private function create_db_connector()
    {
        $this->db_connector = new DatabaseController();
    }

    private function create_db_executer()
    {
        $this->db_executer = new DBExecuter();
    }

    private function create_query_generator()
    {
        $this->query_generator = new QueryGenerator();
    }

    private function create_queryable_controller()
    {
        $this->queryable_controller = new QueryableController();
    }

    public function execute_get_request($request)
    {
        if ($request->has_parameters()) {
            return self::get_by_parameters(self::create_resource($request->get_parameters(), $request->get_resource()));
        } else
            return self::get_by_uri($request->get_uri());
    }

    public function execute_post_request($request)
    {
        //TODO
    }

    public function execute_put_request($request)
    {
        //TODO
    }

    public function execute_delete_request($request)
    {
        //TODO
    }

    private function get_query($parameters, $resource_name, $method)
    {
        try {
            return $this->queryable_controller->genarate_query($resource_name, $parameters, $method);
        } catch(Exception $e) {
            return new json_encode(new HTTPStatus(405), JSON_PRETTY_PRINT);
        }
    }

    private function get_by_parameters($parameters, $resource_name)
    {
        return self::get_query($resource_name,$parameters,"SELECT");
    }

    private function get_by_uri($uri)
    {
        $query = $this->query_generator->get_uri_query($uri);

        if ($query !== NULL)
            return $this->db_executer->select($query, self::get_connection());

        return json_encode(new HTTPStatus(404), JSON_PRETTY_PRINT);
    }

    private function get_connection()
    {
        return $this->db_connector->get_PDO_object();
    }
}