<?php
 
class ModelException extends Exception{
    public function __construct($message, $code = 0, Exception $previous = null){
        parent::__construct($message, $code, $previous);
    }
 
    public function __toString(){
        return __CLASS__."[{$this->getSpecialCode()}]{$this->getSpecialMessage()}\n";
    }
 
    public function getSpecialCode(){
        if(preg_match('/^\[([a-zA-Z0-9]*)\](.*)/i',$this->message,$matches)){
            return $matches[1];
        }else{
            return $this->code;
        }
    }
 
    public function getSpecialMessage(){
        if(preg_match('/^\[([a-zA-Z0-9]*)\](.*)/i',$this->message,$matches)){
            return $matches[2];
        }else{
            return $this->message;
        }
    }
 
}
 
?>