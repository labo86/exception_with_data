<?php
declare(strict_types=1);

namespace test\labo86\exception_with_data;

use Exception;
use labo86\exception_with_data\ExceptionWithData;
use labo86\exception_with_data\TestingUtil;
use labo86\exception_with_data\ThrowableList;
use labo86\exception_with_data\Util;
use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase
{
    public function testTryExecute()
    {
        try {
            Util::foreachTry(function(string $value) {
                throw new Exception($value);
            },
            ["hello", "world"]);

            $this->fail("should throw");

        } catch (ThrowableList $exception) {
            $this->assertEquals([
                'm' => "GENERIC_ERROR_LIST",
                'd' => [
                    "element_list" => ["hello", "world"]
                ],
                'p' => ['m' => 'hello'],
                'pl' => [
                    ['m' => 'hello'],
                    ['m' => 'world']
                ]
            ], $exception->toArray(false));

            $previous_list = $exception->getPreviousList();
            $this->assertEquals("hello", $previous_list[0]->getMessage());
            $this->assertEquals("world", $previous_list[1]->getMessage());

        }

    }

    public function testTryExecuteWithMessage()
    {
        try {
            Util::foreachTry(function(string $value) {
                throw new Exception($value);
            },
                ["hello", "world"], "RANDOM_MESSAGE");

            $this->fail("should throw");

        } catch (ThrowableList $exception) {
            $this->assertEquals([
                'm' => "RANDOM_MESSAGE",
                'd' => [
                    "element_list" => ["hello", "world"]
                ],
                'p' => ['m' => 'hello'],
                'pl' => [
                    ['m' => 'hello'],
                    ['m' => 'world']
                ]
            ], $exception->toArray(false));

            $previous_list = $exception->getPreviousList();
            $this->assertEquals("hello", $previous_list[0]->getMessage());
            $this->assertEquals("world", $previous_list[1]->getMessage());

        }

    }

    public function testRethrow() {

        $exp_1 = new ExceptionWithData("a", ['key_1' => "value_1"]);
        $exp_2 = Util::rethrow("b", ['key_2' => "value_2"], $exp_1);

        $this->assertEquals([
            'm' => 'b',
            'd' => ['key_1' => 'value_1', 'key_2' => 'value_2'],
            'p' => [
                'm' => 'a',
                'd' => ['key_1' => 'value_1']
            ]
        ],$exp_2->toArray(false));
    }

    public function testRethrow3Levels() {

        $exp_1 = new ExceptionWithData("a", ['key_1' => "value_1"]);
        $exp_2 = Util::rethrow("b", ['key_2' => "value_2"], $exp_1);
        $exp_3 = Util::rethrow("c", ['key_3' => "value_3"], $exp_2);

        $this->assertEquals([
            'm' => 'c',
            'd' => ['key_1' => 'value_1', 'key_2' => 'value_2', 'key_3' => 'value_3'],
            'p' => [
                'm' => 'a',
                'd' => ['key_1' => 'value_1']
            ]
        ],$exp_3->toArray(false));
    }

    public function testRethrow3LevelsNoMessage() {

        $exp_1 = new ExceptionWithData("a", ['key_1' => "value_1"]);
        $exp_2 = Util::rethrow("", ['key_2' => "value_2"], $exp_1);
        $exp_3 = Util::rethrow("", ['key_3' => "value_3"], $exp_2);

        $this->assertEquals([
            'm' => 'a',
            'd' => ['key_1' => 'value_1', 'key_2' => 'value_2', 'key_3' => 'value_3'],
            'p' => [
                'm' => 'a',
                'd' => ['key_1' => 'value_1']
            ]
        ],$exp_3->toArray(false));
    }
}
