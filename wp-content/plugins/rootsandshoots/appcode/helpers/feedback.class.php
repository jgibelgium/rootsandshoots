<?php
    
class Feedback
{
    protected $feedback;
    protected $errorMessage;
    protected $errorCode;
    protected $isError;
    protected $messages;

    public function __construct()
    {
        $this->errorReset();
    }

    public function errorReset()
    {
        $this->feedback = 'none';
        $this->errorMessage = 'none';
        $this->errorCode = 'none';
        $this->isError = FALSE;
        $this->messages = array();
    }

    public function getFeedback()
    {
        return $this->feedback;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function getIsError()
    {
        return $this->isError;
    }

    public function getMessages()
    {
        return $this->messages;
    }

}
?>


