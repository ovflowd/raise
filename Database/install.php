<?php
class Install
{
    private $memory;

    private $postfields = array(
        'authType' => 'sasl',
        'bucketType' => 'membase',
        'flushEnabled' => 0,
        'name' => '',
        'ramQuotaMB' => '',
        'replicaIndex' => 0,
        'replicaNumber' => 1,
        'threadsNumber' => 3
    );

    private $buckets = array(
        'Metadata' => 0,
        'Registration' => 0,
        'Services' => 0,
        'Token' => 0,
        'Update' => 0,
        'Responses  => 0'
    );

    public function setFields($name, $quota)
    {
        $this->postfields['name'] = $name;
        $this->postfields['ramQuotaMB'] = $quota;
    }

    public function getFields()
    {
        return $this->postfields;
    }

    public function getBuckets()
    {
        return $this->buckets;
    }

    public function setBuckets($memory)
    {
        $buckets = $this->getBuckets();
        $buckets['Metadata'] = floor((($memory / 100) * 2.5));
        $buckets['Registration'] = floor((($memory / 100) * 17.5));
        $buckets['Services'] = floor((($memory / 100) * 17.5));
        $buckets['Token'] = floor((($memory / 100) * 12.5));
        $buckets['Update'] = floor((($memory / 100) * 25));
        $buckets['Responses'] = floor((($memory / 100) * 25));
        $this->buckets = $buckets;
    }

    public function getServerInfo()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERPWD, "admin:123456"); // your couchbase username and password here.
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8091/pools/default");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_close($ch);
        $this->setBuckets(JSON_decode($server_output)->memoryQuota);
        $this->createBuckets();
    }

    private function createBuckets()
    {
        $buckets = $this->getBuckets();
        foreach ($buckets as $key => $bucket)
        {
            $this->setFields($key, $bucket);
            $this->createBucket($this->getFields());
        }
        echo "Buckets created successfully";
    }

    private function createBucket($postfields)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERPWD, "admin:123456");
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_URL, "http://localhost:8091/pools/default/buckets");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_close($ch);
    }

}

$install = new Install;
$install->getServerInfo();
