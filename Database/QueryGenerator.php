<?php
include_once ('Database/DatabaseParser.php');
Class QueryGenerator
{
    public function generate($request)
    {

        $parsedPath = $this->parsePath($request);
        if ($parsedPath !== FALSE)
        {

            $parser = new DatabaseParser($parsedPath);
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

    private function parsePath($request)
    {
        $path = $request->getPath();
        $method = $path[2];
        if (!empty($method))
        {

          if($request->getPath()[2] === "client" && $request->getPath()[3] == "register")
          {

            $request->bucket = "token";
            $request->token = $this->generateToken();
            $tokenIni = round(microtime(true) *1000);
            $tokenFim = $tokenIni + 7200000;
            $request->treatedBody = json_encode(array_merge($request->getBody(),array('tokenId'=>$request->token,'time_ini'=>$tokenIni,'time_fim'=>$tokenFim)));
            $parser = new DatabaseParser($request);
            $parser->insert($request);
            $request->bucket = "client";
            $request->treatedBody = $request->getBody();

          }
          elseif ($request->getPath()[2] === "service" && $request->getPath()[3] == "register")
          {
            $request->bucket = "token";
            $parser = new DatabaseParser($request);
            $token = $request->getBody()['tokenId'];
            $request->string = 'SELECT * FROM `token` WHERE tokenId = $token';
            $request->setParameters(array('token'=>$token));
            $result = $parser->select($request);
            unset($request->string);
            $requestBody = json_decode(json_encode($result['values'][0]),true);
            $request->bucket = "client";
            $request->treatedBody = json_encode(array_merge($request->getBody(),$requestBody));
            $request->token = $requestBody['tokenId'];
            unset($requestBody['tokenId']);
            return $request;
          }
          else
          {
            $request->token = $this->generateToken();
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
