<?php

namespace Yadakhov;

/**
 * A wrapper class for the Jsend specifications.
 *
 * @see http://labs.omniti.com/labs/jsend
 */
class Jsend
{
    const SUCCESS = 'success';
    const FAIL = 'fail';
    const ERROR = 'error';

    /**
     * @var string
     */
    protected $status;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var integer
     */
    protected $code;


    /**
     * Jsend constructor.
     *
     * @param string $status
     * @param null $data
     * @param null $message
     * @param null $code
     */
    public function __construct($status = 'success', $data = null, $message = null, $code = null)
    {
        $this->setStatus($status);
        $this->setData($data);
        $this->setMessage($message);
        $this->setCode($code);
    }

    /**
     * Get an instance of the object.
     * A short cut for doing $jsend = new Json(); or $jsend = Jsend::getInstance();
     *
     * @param string $status
     * @param null $data
     *
     * @return Jsend
     */
    public static function getInstance($status = 'success', $data = null, $message = null, $code = null)
    {
        return new Jsend($status, $data, $message, $code);
    }

    /**
     * @param mixed|null $data
     *
     * @return Jsend
     */
    public static function getFailInstance($data = null)
    {
        return new Jsend('fail', $data);
    }

    /**
     * @param mixed|null $data
     *
     * @return Jsend
     */
    public static function getErrorInstance($message = null, $code = null, $data = null)
    {
        return new Jsend('error', $data, $message, $code);
    }


    /**
     * Returns true if the status is success.
     *
     * @return bool true if the status is success.
     */
    public function isSuccess()
    {
        return $this->status === self::SUCCESS;
    }

    /**
     * Returns true if the status is fail.
     *
     * @return bool true if the status is fail.
     */
    public function isFail()
    {
        return $this->status === self::FAIL;
    }

    /**
     * Returns true if the status is error.
     *
     * @return bool true if the status is error.
     */
    public function isError()
    {
        return $this->status === self::ERROR;
    }

    /**
     * Returns the array representation of the object.
     *
     * @return array the array representation of the object.
     */
    public function toArray()
    {
        $jsend = [
            'status' => $this->getStatus()
        ];

        switch ($this->status) {
            case self::SUCCESS:
            case self::FAIL:
            default:
                $jsend['data'] = $this->getData();
                break;
            case self::ERROR:
                $jsend['message'] = $this->getMessage();
                if (isset($this->code)) {
                    $jsend['code'] = $this->getCode();
                }
                if (isset($this->data)) {
                    $jsend['data'] = $this->getData();
                }
                break;
        }

        return $jsend;
    }

    /**
     * Returns the encoded Jsend object.
     *
     * @return string the encoded Jsend object.
     */
    public function toString()
    {
        return json_encode($this->toArray());
    }

    /**
     * Auto to string method.
     *
     * @return string the string representation of the object.
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Alias for toString()
     *
     * @return string the string representation of the object.
     */
    public function toJson()
    {
        return $this->toString();
    }

    /**
     * Returns the status.
     *
     * @return string the status.
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the status.
     *
     * @param string $status
     *
     * @throws \UnexpectedValueException
     *
     * @return Jsend $this
     */
    public function setStatus($status)
    {
        if ($status !== self::SUCCESS && $status !== self::FAIL && $status !== self::ERROR) {
            throw new \InvalidArgumentException($status . ' is not a valid Jsend status.');
        }

        $this->status = $status;

        return $this;
    }

    /**
     * Returns the data.
     *
     * @return array the data.
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the data.
     *
     * @param mixed|array $data
     *
     * @return $this
     */
    public function setData(array $data = null)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Returns the message.
     *
     * @return string|null the message.
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set the message.
     *
     * @param string|null $message = null
     *
     * @return Jsend $this
     */
    public function setMessage($message = null)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Returns the code.
     *
     * @return string|null the message.
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the code.
     *
     * @param null $code
     *
     * @return $this
     */
    public function setCode($code = null)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Add to the data array.
     *
     * @param $key
     * @param $value
     *
     * @return Jsend $this
     */
    public function addData($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }
}
