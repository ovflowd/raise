<?php

include_once ('Database/DatabaseParser.php');

Class QueryGenerator
{

    public function generate($request)
    {
        if ($this->parsePath($request) !== FALSE)
        {
<<<<<<< HEAD
            $parser = new DatabaseParser($this->parseGet($request));
            $request = $this->buildQuery($request);
            vr_dump($request);exit;
            $result = $parser->select($this->parseGet($request));
        } elseif ($request->getMethod() == "POST")
=======

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
>>>>>>> refs/remotes/origin/development
        {
            return array('code'=>200,'message'=>'Welcome to RAISE!');
        }

    }

    private function buildQuery($request)
    {

        if(count($request->getParameters())>0)
        {
          $queryStr = "SELECT * FROM `".$request->bucket."` WHERE";
          foreach ($request->getParameters() as $key => $parameter)
          {
              $queryStr = $queryStr . " " . $key . " LIKE \$$key" . "AND ";
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
        $path = $request->getPath();
        $method = $path[2];
<<<<<<< HEAD
        $request->bucket = "metadata";
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
=======
        if (!empty($method))
>>>>>>> refs/remotes/origin/development
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
