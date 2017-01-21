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

                $this->parseService($request);exit;
                $result = $parser->insert($request);
            }
            return $result;
        }
        else
        {
            return array('code'=>200,'message'=>'Welcome to RAISE!');
        }
    }


    private function generateToken()
    {
       return bin2hex(openssl_random_pseudo_bytes(16));
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

    public function parseService($request)
    {

      if($request->getPath()[2] === "service" && $request->getPath()[3] == "register")
      {
        $request->bucket = "client";

        $parser = new DatabaseParser($request);

        $token = $request->getBody()['token'];
        var_dump($request->getBody());exit;
        $request->string = 'SELECT * FROM `token` WHERE `token` = $token';
        $request->setParameters(array('token'=>$token));
        var_dump($request->getParameters());exit;
        $result = $parser->select($request);
        return $result;

      }
    }

    private function parsePath($request)
    {
        $path = $request->getPath();
        $method = $path[2];
        if (!empty($method))
        {

          if($request->getPath()[2] === "client" && $request->getPath()[3] == "register")
          {
            $request->token = $this->generateToken();
            $tokenIni = round(microtime(true) *1000);
            $tokenFim = $tokenIni + 7200000;
            $request->treatedBody = json_encode(array_merge($request->getBody(),array('token'=>$request->token,'time_ini'=>$tokenIni,'time_fim'=>$tokenFim)));
          }
          else
          {

            $request->treatedBody = $request->getBody();
          }

            return $request;
        }
        else
        {
            return FALSE;
        }
    }
}
