<?php
declare(strict_types=1);

namespace test\labo86\exception_with_data;

use Exception;
use labo86\exception_with_data\ExceptionForFrontEnd;
use labo86\exception_with_data\ExceptionWithData;
use labo86\exception_with_data\MessageMapperArray;
use PHPUnit\Framework\TestCase;

class ExceptionForFrontEndTest extends TestCase
{
    public function testNormalizeOther() {
        $exception = new Exception("exception");

        $mapper = new MessageMapperArray([]);
        $exp_for_front_end = ExceptionForFrontEnd::normalize($exception, $mapper);

        $this->assertEquals("GENERIC_ERROR", $exp_for_front_end->getMessage());
        $this->assertSame($exception, $exp_for_front_end->getPrevious());
        $this->assertNotEquals($exception, $exp_for_front_end);

    }

    public function testNormalizeOtherWithMessage() {
        $exception = new Exception("exception");

        $mapper = new MessageMapperArray(['exception' => 'OTHER_ERROR']);
        $exp_for_front_end = ExceptionForFrontEnd::normalize($exception, $mapper);

        $this->assertEquals("OTHER_ERROR", $exp_for_front_end->getMessage());
        $this->assertSame($exception, $exp_for_front_end->getPrevious());
        $this->assertNotEquals($exception, $exp_for_front_end);

    }

    public function testNormalizeSame() {
        $exception = new ExceptionForFrontEnd("exception");

        $mapper = new MessageMapperArray(['exception' => 'OTHER_ERROR']);
        $exp_for_front_end = ExceptionForFrontEnd::normalize($exception, $mapper);

        $this->assertEquals("exception", $exp_for_front_end->getMessage());
        $this->assertSame($exception, $exp_for_front_end);
    }

    public function testToArray() {
        $exception = new ExceptionWithData("backend message", ['key' => 'value']);

        $exp_for_front_end = new ExceptionForFrontEnd("user message", ['key2' => 'value_2'], $exception);

        $id = $exp_for_front_end->getId();
        $this->assertEquals(
            [
                'm' => 'user message',
                'd' => ['key2' => 'value_2'],
                'i' => $id,
                'p' => [
                    'm' => 'backend message',
                    'd' => ['key' => 'value']
                ]
            ]
        , $exp_for_front_end->toArray(false));
    }

    public function testGetDataForUser() {
        $exception = new ExceptionWithData("backend message", ['key' => 'value']);

        $exp_for_front_end = new ExceptionForFrontEnd("user message", ['key2' => 'value_2'], $exception);

        $id = $exp_for_front_end->getId();
        $this->assertEquals(
            [
                'm' => 'user message',
                'd' => ['key2' => 'value_2'],
                'i' => $id
            ]
            , $exp_for_front_end->getDataForUser());
    }
}
