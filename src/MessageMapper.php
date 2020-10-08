<?php
declare(strict_types=1);

namespace labo86\exception_with_data;

/**
 * Class MessageMapper
 * @package labo86\exception_with_data
 * Esta función traduce un mensaje de error a otro incluyendo un mensaje de error generico.
 * Es solo un mapa por el momento pero puede servir como interfaz a futuro.
 * Por
 */
abstract class MessageMapper
{
    const DEFAULT_MESSAGE = 'GENERIC_ERROR';

    /**
     * Debe retornar el mensaje de rror asociacio, en caso contrario debe lanzar el erro por defecto
     * @param string $message
     * @return string
     */

    abstract public function getMessage(string $message) : string;
}