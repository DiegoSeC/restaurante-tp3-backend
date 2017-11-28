<?php
/**
 * Created by PhpStorm.
 * User: andree
 * Date: 28/11/17
 * Time: 16:14
 */

namespace App\Http\Controllers;

use App\Mail\Traits\SendEmailTrait;

class TestController
{

    use SendEmailTrait;

    public function email() {
        $this->sendEmail('Test', 'andree.bit@gmail.com', 'emails.test', []);
    }

}