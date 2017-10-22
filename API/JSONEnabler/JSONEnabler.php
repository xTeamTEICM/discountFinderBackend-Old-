<?php

class JSONEnabler
{

    private $type;
    private $charset;
    private $object;

    /**
     * JSONEnabler constructor.
     * @param $type
     * @param $charset
     */
    public function __construct($type = "application/json", $charset = "utf-8")
    {
        $this->type = $type;
        $this->charset = $charset;
        header('Content-type:' . $this->type . ';charset=' . $this->charset . ';');
        $this->object = new stdClass();
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getCharset(): string
    {
        return $this->charset;
    }


    /**
     * @return stdClass
     */
    public function getObject(): stdClass
    {
        return $this->object;
    }

    /**
     * @param stdClass $object
     */
    public function setObject(stdClass $object)
    {
        $this->object = $object;
    }


    public function printJSON()
    {
        echo json_encode($this->object, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

}