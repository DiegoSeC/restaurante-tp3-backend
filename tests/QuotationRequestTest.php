<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class QuotationRequestTest extends TestCase
{

    /**
     * Testing correlative number generation
     */
    public function testGenerateDocumentNumber() {
        $instance = new \App\Services\QuotationRequestService();

        $number1 = $this->invokeMethod($instance, 'documentNumberGenerator', [31]);
        $number2 = $this->invokeMethod($instance, 'documentNumberGenerator', [32]);
        $number3 = $this->invokeMethod($instance, 'documentNumberGenerator', [33]);
        $number4 = $this->invokeMethod($instance, 'documentNumberGenerator', [1000]);
        $number5 = $this->invokeMethod($instance, 'documentNumberGenerator', [999999]);


        $this->assertEquals('SC17000031', $number1);
        $this->assertEquals('SC17000032', $number2);
        $this->assertEquals('SC17000033', $number3);
        $this->assertEquals('SC17001000', $number4);
        $this->assertEquals('SC17999999', $number5);
    }

}
