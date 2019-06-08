<?php

namespace MatthijsThoolen\Slacky\Model;

use Exception;
use MatthijsThoolen\Slacky\Slacky;
use MatthijsThoolen\Slacky\SlackyFactory;

// TODO: add annotations functionality with https://github.com/doctrine/annotations
abstract class Model
{
    /** @var bool */
    private $isOk = false;

    /** @var string */
    private $error;

    /** @var string */
    protected $objectName;

    /** @var array */
    protected $allowedProperties = array();

    /** @var bool */
    protected $initialized = false;

    /** @var string */
    protected $endpointName;

    /** @var Slacky */
    protected $slacky;

    /**
     * Model constructor.
     * @param Slacky $slacky
     */
    public function __construct(Slacky $slacky = null)
    {
        $this->slacky = $slacky;
    }

    /**
     * @return bool
     */
    public function isOk()
    {
        return $this->isOk;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Load the data into the model by using the setters
     *
     * @param array $data
     * @return self
     */
    public function loadData(array $data)
    {
        if (isset($data['ok']) === true) {
            $this->isOk = $data['ok'];
        }

        if (isset($data['error']) === true) {
            $this->error = $data['error'];
        }

        // Loop through a child array if their is data for this specific object
        if ($this->objectName !== null && isset($data[$this->objectName]) === true) {
            $data = $data[$this->objectName];
        }

        foreach ($data as $key => $value) {
            // Check if the value is allowed to be set
            if (in_array($key, $this->allowedProperties, true) === false) {
                continue;
            }

            // Function calls should be in camelcase
            $setter = 'set' . str_replace('_', '', ucwords($key, '_'));

            $this->{$setter}($value);
        }

        $this->initialized = true;

        return $this;
    }

    /**
     * @throws Exception
     */
    protected function get()
    {
        // Quick return if model is already initialized or no endpoint set
        if ($this->initialized === true || $this->endpointName === null) {
            return;
        }

        // Else doLoad
        $this->doLoad();

    }

    /**
     * @throws Exception
     */
    private function doLoad()
    {
        try {
            $endpoint = SlackyFactory::buildEndpoint($this->endpointName);
        } catch (Exception $e) {
            throw new Exception('Unable to load model', 0, $e);
        }

        $endpoint->setModel($this);

        try {
            $response = $endpoint->sendExpectArray();
        } catch (Exception $e) {
            throw new Exception('Unable to load model', 0, $e);
        }

        $this->loadData($response);
    }

}
