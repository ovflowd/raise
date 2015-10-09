<?php

class QueryableController
{

    public function generate_query($resource_name, $method, $parameters)
    {
        return resource_to_query(self::create_resource($resource_name, $method, $parameters));

    }

    public function create_resource($resource_name, $method, $parameters)
    {
        try{
            $resource =  new QueryableResource($resource_name, $parameters, $method);
            return $resource;
        }catch (Exception $e) {
            return json_encode(new HTTPStatus(400), JSON_PRETTY_PRINT);
        }
    }

    private function resource_to_query($resource)
    {
        //TODO
    }
}