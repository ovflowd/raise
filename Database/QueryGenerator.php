<?php

include_once ('Database/DatabaseParser.php');

Class QueryGenerator
{

    public function generate($request)
    {
        if ($this->parsePath($request) !== FALSE)
        {

            $parser = new DatabaseParser($this->parsePath($request));

            if ($request->getMethod() == "GET")
            {

                $request = $this->buildQuery($request);
                $result = $parser->select($request);

            } elseif ($request->getMethod() == "POST")
            {
                $result = $parser->insert($request);
            }

            return $result;
        }
        else
        {
            return json_encode(array('code'=>200,'message'=>'Welcome to RAISE!'));
        }

    }

    private function buildQuery($request)
    {

        if(count($request->getParameters())>0)
        {
            $queryStr = "SELECT * FROM `".$request->bucket."` WHERE";
            foreach ($request->getParameters() as $key => $parameter)
            {
                $queryStr = $queryStr . " " . $key . "=\$$key" . "AND ";
            }
            $request->string = substr($queryStr, 0, -4);
        }
        else
        {
        $request->string = "SELECT * FROM `".$request->bucket."`";
        }

        return $request;
    }

    private function parsePath($request)
    {
        $path = $request->getpath();
        $method = $path[2];
        if (!empty($method))
        {
            $request->bucket = $method;
            return $request;
        }
        else
        {
            return FALSE;
        }


    }


}
