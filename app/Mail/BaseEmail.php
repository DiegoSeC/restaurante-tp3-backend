<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BaseEmail extends Mailable
{
    use Queueable, SerializesModels;


    private $data = [];

    /**
     * BaseEmail constructor.
     * @param array $data
     */
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function build()
    {
        if (!isset($this->data['template'])) {
            throw new \Exception('template is required');
        }
        $template = $this->data['template'];
        unset($this->data['template']);

        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->to($this->data['to'])
            ->subject($this->data['subject'])
            ->view($template, $this->data['data']);
    }
}
