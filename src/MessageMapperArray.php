<?php
declare(strict_types=1);

namespace labo86\exception_with_data;

/**
 * Class MessageMapper
 * @package labo86\exception_with_data
 * Esta función traduce un mensaje de error a otro incluyendo un mensaje de error generico.
 * Es solo un mapa por el momento pero puede servir como interfaz a futuro.
 */
class MessageMapperArray extends MessageMapper
{
    protected array $message_map;

    public function __construct(array $map) {
        $this->message_map = $map;
    }

    public function getMessage(string $message) : string {
        return $this->message_map[$message] ?? self::DEFAULT_MESSAGE;
    }
}