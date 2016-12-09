<?php
include_once ('Database/DatabaseParser.php');
Class QueryGenerator
{
    public function generate($request)
    {
        $parser = new DatabaseParser();
        if ($request->getMethod() == "GET")
        {
            $request = $this->parseGet($request);
            $result = $parser->select($request);
        }
        elseif ($request->getMethod() == "POST")
        {
            $request = $this->parsePost($request);
            $result = $parser->insert($request);
        }

        return $result;
    }

    private function parsePost($request)
    {
        $path = $request->getpath();
        $method = $path[2];
        $request->bucket = "teste";
        $request->class = $method;
        $request->parameters = $_POST;
        return $request;
    }

    private function parseGet($request)
    {
        $path = $request->getpath();
        $method = $path[2];
        unset($path[0]);
        unset($path[1]);
        unset($path[2]);
        $parameters = array();
        foreach ($path as $param => $value)
        {
            if ($param % 2 !== 0)
            {
                $parameters[$value] = "";
            }
            else
            {
                $parameters[$path[$param - 1]] = $value;
            }
        }
        $request->bucket = "teste";
        $request->class = $method;
        $request->parameters = $parameters;
        return $request;
    }
}
