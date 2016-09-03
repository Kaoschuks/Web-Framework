<?php

class Email_Generator 
{

    private $senderName;
    private $senderEmail;
    private $receiverEmail;
    private $subject;
    private $message;

    //constructor
    public function EmailGenerator($senderName = null, $senderEmail = null, $receiverEmail = null, $subject = null, $msg = null) {
        //initializing variables
        $this->senderEmail = $senderEmail;
        $this->senderName = $senderName;
        $this->receiverEmail = $receiverEmail;
        $this->subject = $subject;
        $this->message = $msg;
    }

    //getters and setters
    public function setSenderName($name) {
        $this->senderName = $name;
    }

    public function setSenderEmail($email) {
        $this->senderEmail = $email;
    }

    public function setReceiverEmail($email) {
        $this->receiverEmail = $email;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

    public function setMessage($msg) {
        $this->message = $msg;
    }

    public function getSenderName() {
        return $this->senderName;
    }

    public function getSenderEmail() {
        return $this->senderEmail;
    }

    public function getReceiverEmail() {
        return $this->receiverEmail;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function getMessage() {
        return $this->message;
    }

    public function composeMessage($message,$senderName,$senderEmail,$subject){
                $body = 'Name: ' . $senderName . "\n\n" . 'Email: ' . $senderEmail . "\n\n" . 'Subject: ' . $subject . "\n\n" . 'Message: ' . $message;
   
                return $body;
    }
    
    //returning json encoded message
    public function send() {
        header('Content-type: application/json');
        $status = array(
            'type' => 'success',
            'message' => 'Email sent!'
        );

        $body= $this->composeMessage(
                @trim(stripslashes($this->message)),
                @trim(stripslashes($this->senderName)),
                @trim(stripslashes($this->senderEmail)),
                @trim(stripslashes($this->subject)));

        $success = @mail(@trim(stripslashes($this->receiverEmail)), @trim(stripslashes($this->subject)), $body, 'From: <' . @trim(stripslashes($this->senderEmail)) . '>');

        //echo json_encode($status);
        
        return json_encode($status);
    }

}

//default class 
//$emailgenerator = new EmailGenerator();
