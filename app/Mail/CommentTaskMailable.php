<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommentTaskMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = "Comentario en la tarea";

    public $user;
    public $task;
    public $project;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($task, $project, $user, $data)
    {
        $this->subject = "Comentario en la tarea: ".$task->name;
        $this->user = $user->name;
        $this->task = $task;
        $this->project = $project;
        $this->data = $data;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.comment');
    }
}
