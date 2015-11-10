<?php

include_once ROOT_REST_DIR . "/database/executer.db.php";
include_once ROOT_REST_DIR. "/database/connector.db.php";
include_once ROOT_REST_DIR. "/sql/filter.sql.php";
include_once ROOT_REST_DIR . "/sql/criteria.sql.php";


class ResourceController
{
    var $db_connector;
    var $db_executer;

    public function __construct()
    {
        self::create_db_executer();
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

    public function execute_request($request)
    {
        var_dump($request);
        die();
    }

    private function get_connection()
    {
        return $this->db_connector->get_PDO_object();
    }

}