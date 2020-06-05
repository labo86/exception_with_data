<?php
declare(strict_types=1);

namespace test\labo86\exception_with_data;

use labo86\exception_with_data\ExceptionWithData;
use PHPUnit\Framework\TestCase;

class ExceptionWithDataTest extends TestCase
{

    public function testGetDataBasic()
    {
        try {
            throw new ExceptionWithData("message", [
                "param_1" => "a",
                "param_2" => "b"
            ]);
            $this->fail("should throw");

        } catch (ExceptionWithData $exception) {
            $this->assertEquals("message", $exception->getMessage());
            $this->assertEquals([
                "param_1" => "a",
                "param_2" => "b"
            ], $exception->getData());
        }

    }
}
