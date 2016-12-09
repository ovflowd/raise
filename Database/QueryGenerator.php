<?php

include_once ('Database/DatabaseParser.php');

Class QueryGenerator
{
    public function generate($request)
    {
        if ($request->getMethod() == "GET")
        {
            $parser = new DatabaseParser($this->parseGet($request));
            $this->buildQuery($request);
            $result = $parser->select($this->parseGet($request));
        }
        elseif ($request->getMethod() == "POST")
        {
            $parser = new DatabaseParser($this->parseGet($request));
            $result = $parser->insert($this->parseGet($request));
        }

        return $result;
    }

    private function buildQuery($request)
    {
        $queryStr = "SELECT * FROM `teste` WHERE";
        foreach ($request->parameters as $key => $parameter)
        {
            $queryStr = $queryStr . " " . $key . "=\$$key" . "AND ";
        }
        $request->string = substr($queryStr, 0, -4);
        return $request;
    }

    private function parsePath($request)
    {
      $path = $request->getpath();
      $method = $path[2];
      $request->bucket = "teste";
      $request->class = $method;
      $request->parsedPath = $path;
      return $request;
    }

    private function parsePost($request)
    {
        $this->parsePath($request);
        $request->parameters = $_POST;
        return $request;
    }

    private function parseGet($request)
    {
        $this->parsePath($request);
        $parameters = array();
        foreach ($request->parsedPath as $param => $value)
        {
            if ($param % 2 !== 0 && !in_array($param,array(0,1,2)))
            {
                $parameters[$value] = "";
            }
            elseif(!in_array($param,array(0,1,2)))
            {
                $parameters[$request->parsedPath[$param - 1]] = $value;
            }
        }
        $request->parameters = $parameters;
        return $request;
    }
}
