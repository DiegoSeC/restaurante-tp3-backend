<?php

namespace App\Mail\Traits;

use App\Mail\BaseEmail;
use Illuminate\Support\Facades\Mail;

trait SendEmailTrait
{
    /**
     * @param $subject
     * @param $to
     * @param $template
     * @param array $data
     */
    public function sendEmail($subject, $to, $template, $data = [])
    {
        $dataEmail['template'] = $template;
        $dataEmail['subject'] = $subject;
        $dataEmail['to'] = $to;
        $dataEmail['data'] = $data;

        Mail::queue(new BaseEmail($dataEmail));
    }

}