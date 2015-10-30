<?php

include_once ROOT_REST_DIR . "/database/connector.db.php";
include_once ROOT_REST_DIR . "/database/executer.db.php";
include_once ROOT_REST_DIR . "/properties/sql.properties.php";
include_once ROOT_REST_DIR . "/model/queryable.model.php";

class QueryableController
{
    var $db_connector;
    var $db_executer;

    public function __construct()
    {
        self::create_db_controller();
        self::create_db_executer();
    }

    private function create_db_controller()
    {
        $this->db_connector = new DatabaseConnector();
    }

    private function create_db_executer()
    {
        $this->db_executer = new DatabaseExecuter();
    }

    public function generate_query($resource_name, $parameters, $method)
    {
        return self::resource_to_query(self::create_resource($resource_name, $parameters, $method));

    }

    public function create_resource($resource_name, $parameters, $method)
    {
        try {
            $resource =  new QueryableResource($resource_name, $parameters, $method);
            return $resource;
        } catch (Exception $e) {
            return new HTTPStatus(400, "Bad request: it was not possible to create/find a resource named: $resource_name
                                        with parameters: $parameters.");
        }
    }

    //PADRONIZAR NO BANCO NOME DE TABELAS E CAMPOS
    //INSERIR TODOS OS ATRIBUTOS NA TABELA META PROPERTIES


    private function resource_to_query($resource)
    {
       return call_user_func('self::'.$resource->get_method(), $resource);
    }

    private function SELECT($resource)
    {
        return SQL::SELECT.SQL::BLANK.
               $resource->get_all_resource_columns().SQL::BLANK.
               SQL::FROM.SQL::BLANK.
               $resource->get_table_name().SQL::BLANK.
               SQL::WHERE.SQL::BLANK.
               $resource->get_resource_columns();
    }

    private function INSERT($resource)
    {
        return SQL::INSERT_INTO.SQL::BLANK.
               $resource->get_table_name().SQL::BLANK.
               $resource->get_all_resource_columns().SQL::BLANK.
               SQL::VALUES.SQL::BLANK.
               $resource->get_parameters_values();
    }

    private function UPDATE($resource)
    {
        return SQL::UPDATE.SQL::BLANK.
               $resource->get_table_name().SQL::BLANK.
               SQL::SET.SQL::BLANK.
               $resource->get_parameters_without_id().SQL::BLANK.
               SQL::WHERE.SQL::BLANK.
               $resource->get_id_value();
    }

    private function DELETE($resource)
    {
        return SQL::DELETE.SQL::BLANK.
               SQL::FROM.SQL::BLANK.
               $resource->get_table_name().SQL::BLANK.
               SQL::WHERE.SQL::BLANK.
               $resource->get_id_value();
    }




}