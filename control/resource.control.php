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
        $this->db_connector = new DatabaseConnector();
    }

    private function create_db_executer()
    {
        $this->db_executer = new DatabaseExecuter();
    }

    private function create_query_generator()
    {
        $this->query_generator = new QueryGenerator();
    }

    private function create_queryable_controller()
    {
        $this->queryable_controller = new QueryableController();
    }

    public function execute_request($request)
    {
        if ($request->has_parameters())
            return self::by_parameters($request->get_resource(), $request->get_parameters(), $request->get_method());
        else
            return self::by_uri($request->get_uri());
    }

    private function get_query($resource_name, $parameters, $method)
    {
        try {
            return $this->queryable_controller->generate_query($resource_name, $parameters, $method);
        } catch(Exception $e) {
            return new HTTPStatus(405);
        }
    }

    private function by_parameters($resource_name, $parameters, $method)
    {
            $query = self::get_query($resource_name,$parameters, self::method_to_sql($method));
            return $this->db_executer->execute($query, self::get_connection());
    }

    private function by_uri($uri)
    {
        $query = $this->query_generator->get_uri_query($uri);

        if ($query !== NULL)
            return $this->db_executer->execute($query, self::get_connection());

        return new HTTPStatus(404);
    }

    private function get_connection()
    {
        return $this->db_connector->get_PDO_object();
    }

    private function method_to_sql($method)
    {
        switch($method)
        {
            case 'GET'    : return "SELECT";
            case 'POST'   : return "INSERT";
            case 'PUT'    : return "UPDATE";
            case 'DELETE' : return "DELETE";
            default       : return new HTTPStatus(405);
        }

    }
}