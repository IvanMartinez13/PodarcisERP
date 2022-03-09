<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubtaskChangeMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = "Ha cambaido la subtarea";

    public $user;
    public $task;
    public $project;
    public $open = false;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($task, $project, $user, $data, $open)
    {
        if ($open) {

            $this->subject = $user->name." ha abierto una tarea";
        }else{
            
            $this->subject = $user->name." ha finalizado una tarea";
        }
        
        $this->user = $user->name;
        $this->task = $task;
        $this->project = $project;
        $this->data = $data;
        $this->open = $open;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.subtask_change');
    }
}
