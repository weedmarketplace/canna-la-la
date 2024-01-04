<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DefaultMail extends Mailable
{
    use Queueable, SerializesModels;

    private $template;
    private $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->template = $event->type;
        $this->data = $event->payload;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        if(isset($this->data['subject_data'])){
            $subject = $this->data['subject_data'];
        }else{
            $subject = env('APP_NAME');
        }
        return $this->view('emails.'.$this->template)->with($this->data)->subject($subject);
    }
}