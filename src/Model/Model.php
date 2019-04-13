<?php

namespace MatthijsThoolen\Slacky\Model;

use MatthijsThoolen\Slacky\Slacky;

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
     * @return Model
     */
    function loadData(array $data)
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

        return $this;
    }

}
