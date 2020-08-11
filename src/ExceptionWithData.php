<?php
declare(strict_types=1);

namespace labo86\exception_with_data;

use Exception;
use Throwable;

/**
 * @package labo86\exception_with_data
 */
class ExceptionWithData extends Exception
{
    protected array $data;

    /**
     * Está es una excepción que maneja agregarle información estructurada adicional a la excepción.
     * <h2>Creación</h2>
     * <code>
     * throw = new ExceptionWithData(
     *     "division by zero",
     *     [
     *       "dividend" : 100,
     *       "divisor" : 0
     *     ]
     * );
     * </code>
     * Usar {@see getData()} para obtener la información registrada.
     * @see https://stackoverflow.com/questions/22113541/using-additional-data-in-php-exceptions
     * @param string $message
     * @param array $data
     * @param Throwable|null $previous
     */
    public function __construct(string $message, array $data, Throwable $previous = null) {
        parent::__construct($message, 0, $previous);
        $this->data = $data;
    }

    /**
     * Obtener información adicional de la excepción.
     * @return array
     */
    public function getData() : array {
        return $this->data;
    }

    public function toArray(bool $file_data = true) : array {
        $array_data = Util::toArrayBasic($this, $file_data);

        $array_data['d'] = $this->getData();

        return $array_data;
    }

}