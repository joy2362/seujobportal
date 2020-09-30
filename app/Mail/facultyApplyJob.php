<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class facultyApplyJob extends Mailable
{
    use Queueable, SerializesModels;
    public $user, $job,$cv;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($job,$user,$cv)
    {
        $this->user=  $user;
        $this->job=$job;
        $this->cv=$cv;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $job=$this->job;
        $user=$this->user;
        $date =date('d-m-Y', strtotime(now()));

        return $this->markdown('emails.job.apply')->with(compact('job','user','date'))
            ->attachData($this->cv, $user->name.'.pdf', [
            'mime' => 'application/pdf',
        ])->subject('Application for the post of '.$job->name);
    }
}
