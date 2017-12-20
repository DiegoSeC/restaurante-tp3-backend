<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class OrderTest extends TestCase
{
    /**
     * Testing correlative number generation
     */
    public function testGenerateDocumentNumber() {
        $instance = new \App\Services\OrderService();

        $number1 = $this->invokeMethod($instance, 'documentNumberGenerator', [31]);
        $number2 = $this->invokeMethod($instance, 'documentNumberGenerator', [32]);
        $number3 = $this->invokeMethod($instance, 'documentNumberGenerator', [33]);
        $number4 = $this->invokeMethod($instance, 'documentNumberGenerator', [1000]);
        $number5 = $this->invokeMethod($instance, 'documentNumberGenerator', [999999]);
        $number6 = $this->invokeMethod($instance, 'documentNumberGenerator', [8]);


        $this->assertEquals('NP17000031', $number1);
        $this->assertEquals('NP17000032', $number2);
        $this->assertEquals('NP17000033', $number3);
        $this->assertEquals('NP17001000', $number4);
        $this->assertEquals('NP17999999', $number5);
        #$this->assertEquals('NP17000009', $number6);
    }

}
