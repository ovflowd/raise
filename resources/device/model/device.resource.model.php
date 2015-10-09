<?php

/**
 * Created by Caio Melo.
 * User: caio
 */
class Device
{
    //Unique Product Name UPnP
    var $UDN;
    //Universal Product Code
    var $UDP;
    var $serial_number;
    var $name;
    var $device_type;
    var $manufacture;
    var $manufacture_url;
    var $spec_version_minor;
    var $spec_version_major;
    var $xml_uri;

    /**
     * Device constructor.
     * @param $UDN
     * @param $UDP
     * @param $serial_number
     * @param $name
     * @param $device_type
     * @param $manufacture
     * @param $manufacture_url
     * @param $spec_version_minor
     * @param $spec_version_major
     * @param $xml_uri
     */
    public function __construct($UDN, $UDP, $serial_number, $name, $device_type, $manufacture, $manufacture_url, $spec_version_minor, $spec_version_major, $xml_uri)
    {
        $this->UDN = $UDN;
        $this->UDP = $UDP;
        $this->serial_number = $serial_number;
        $this->name = $name;
        $this->device_type = $device_type;
        $this->manufacture = $manufacture;
        $this->manufacture_url = $manufacture_url;
        $this->spec_version_minor = $spec_version_minor;
        $this->spec_version_major = $spec_version_major;
        $this->xml_uri = $xml_uri;
    }

    /**
     * @return mixed
     */
    public function getUDN()
    {
        return $this->UDN;
    }

    /**
     * @return mixed
     */
    public function getSerialNumber()
    {
        return $this->serial_number;
    }

    /**
     * @param mixed $serial_number
     */
    public function setSerialNumber($serial_number)
    {
        $this->serial_number = $serial_number;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDeviceType()
    {
        return $this->device_type;
    }

    /**
     * @param mixed $device_type
     */
    public function setDeviceType($device_type)
    {
        $this->device_type = $device_type;
    }

    /**
     * @return mixed
     */
    public function getManufacture()
    {
        return $this->manufacture;
    }

    /**
     * @param mixed $manufacture
     */
    public function setManufacture($manufacture)
    {
        $this->manufacture = $manufacture;
    }

    /**
     * @return mixed
     */
    public function getManufactureUrl()
    {
        return $this->manufacture_url;
    }

    /**
     * @param mixed $manufacture_url
     */
    public function setManufactureUrl($manufacture_url)
    {
        $this->manufacture_url = $manufacture_url;
    }

    /**
     * @return mixed
     */
    public function getSpecVersionMinor()
    {
        return $this->spec_version_minor;
    }

    /**
     * @param mixed $spec_version_minor
     */
    public function setSpecVersionMinor($spec_version_minor)
    {
        $this->spec_version_minor = $spec_version_minor;
    }

    /**
     * @return mixed
     */
    public function getSpecVersionMajor()
    {
        return $this->spec_version_major;
    }

    /**
     * @param mixed $spec_version_major
     */
    public function setSpecVersionMajor($spec_version_major)
    {
        $this->spec_version_major = $spec_version_major;
    }

    /**
     * @param mixed $UDN
     */
    public function setUDN($UDN)
    {
        $this->UDN = $UDN;
    }




}