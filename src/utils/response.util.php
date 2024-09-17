<?php
class Response{
    /**
     * @var string message
     * @var bool status
     * @var mixed data
     */
    private $status,$data,$message;
    public function __construct($status,$data,$message){
        $this->status = $status;
        $this->data = $data;
        $this->message = $message;
    }
    public function toJson(){
        return json_encode([
            "status" => $this->status,
            "data" => $this->data,
            "message" => $this->message
        ]);
    }
}