<?php

class InitTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
             ->see('Laravel')
             ->see('Login')
             ->see('Register');
    }
}
