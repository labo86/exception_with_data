<?php
declare(strict_types=1);

namespace test\labo86\exception_with_data;

use labo86\exception_with_data\ExceptionWithData;
use labo86\exception_with_data\TestingUtil;
use PHPUnit\Framework\TestCase;

class ExceptionWithDataTest extends TestCase
{
    public function testToArray() {

        $line = __LINE__;
        $exp_1 = new ExceptionWithData("a", ['key_1' => "value_1"]);
        $exp_2 = new ExceptionWithData("b", ['key_2' => "value_2"], $exp_1);

        $this->assertEquals([
            'm' => 'b',
            'd' => ['key_2' => 'value_2'],
            'f' => [__FILE__, $line + 2],
            'p' => [
                'm' => 'a',
                'd' => ['key_1' => 'value_1'],
                'f' => [__FILE__, $line + 1]
            ]
        ],$exp_2->toArray());
    }

    public function testGetDataBasic()
    {
        try {
            throw new ExceptionWithData("message", [
                "param_1" => "a",
                "param_2" => "b"
            ]);
            $this->fail("should throw");

        } catch (ExceptionWithData $exception) {
            $this->assertEquals([
                'm' => 'message',
                'd' => [
                    "param_1" => "a",
                    "param_2" => "b"
                ]], $exception->toArray(false));
        }

    }
}
