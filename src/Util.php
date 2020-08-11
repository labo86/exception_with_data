<?php
declare(strict_types=1);

namespace labo86\exception_with_data;

use Throwable;

/**
 * Utilidades varias
 * @package labo86\exception_with_data
 */
class Util
{

    /**
     * Esta función sirve para obtener una versión serializada en una rray de una excepción.
     * Sirve para pruevas unitarias, logs, etc.
     * Las llaves de estos arreglos son letras simples para evitar bloating.
     * las letras comúnes son las siguientes:
     *  - m : message {@see Throwable::getMessage()}
     *  - d : data {@see ExceptionWithData::getData()}
     *  - f : file el archivo y linea en que se lanzo esta excepción
     *  - p : previous {@see Throwable::getPrevious()} La excepción anterior serializada si aplica
     *  - pl : previous_list {@see ThrowableList::getPreviousList()} Una lista serializada de excepciones anteriores.
     * @param Throwable $throwable
     * @param bool $file_data si se incluye la linea y el archivo en que se lanzo la excepción
     * @return array
     */
    public static function toArray(Throwable $throwable, bool $file_data = true) : array {
        if ( $throwable instanceof ExceptionWithData )
            return $throwable->toArray($file_data);
        else
            return self::toArrayBasic($throwable, $file_data);
    }

    public static function toArrayBasic(Throwable $throwable, bool $file_data = true) : array {
        $array_data = [
            'm' => $throwable->getMessage()
        ];
        if ( $file_data)
            $array_data['f'] = [$throwable->getFile(),$throwable->getLine()];

        if ( !is_null($throwable->getPrevious()) )
            $array_data['p'] = Util::toArray($throwable->getPrevious(), $file_data);

        return $array_data;
    }


    /**
     * Relanza una excepcion.
     * La idea principal de esta excepción es permitir agregar información contextual a una excepción.
     * Generalmente una excepción cuando es lanzada tiene infoamción local que resulta a veces poco util para resolver el problema.
     * También leer el stack trace es mucha información. Se necesita una forma intermedia de poder acceder a dicha información.
     * La idea es que mediante sucesivos retrow se pueda ir agregando información contextual además de modificar el mensaje si fueses necesario
     * Si se deja el mensaje vacio entonces usa el mensaje de la excepcion original.
     * Data se adiciona a la data le excepción anterior.
     * @param string $message
     * @param array $data
     * @param Throwable $previous
     * @return ExceptionWithData
     */
    public static function rethrow(string $message, array $data, Throwable $previous) : ExceptionWithData {
        if ( $previous instanceof ThrowableList ) {
            $new_message = empty($message) ? $previous->getMessage() : $message;
            $new_data = array_merge($previous->getData(), $data);
            return new ThrowableList($new_message, $new_data, $previous->getPreviousList());
        }
        else if ( $previous instanceof ExceptionWithData ) {
            $new_message = empty($message) ? $previous->getMessage() : $message;
            $new_data = array_merge($previous->getData(), $data);
            return new ExceptionWithData($new_message, $new_data, $previous->getPrevious() ?? $previous);
        } else {
            $new_message = empty($message) ? $previous->getMessage() : $message;
            $new_data = $data;
            return new ExceptionWithData($new_message, $new_data, $previous);
        }
    }

    /**
     * Esta funcion sirve para capturar excepciones dentro de un elemento for.
     * El funcionamiento de esta función es el siguiente.
     * Recorre la lista llamando un callback, si un callback lanza una excepcion la captura y la guarda en una lista pero el for continua con el siguiente.
     * Al final si han ocurrido 1 o más excepciones entonces lanza una {@see ThrowableList}, si no hay problemas retorna un array con los resultados.
     * @param $callback
     * @param array $element_list
     * @return array
     * @throws ThrowableList
     */
    public static function foreachTry($callback, array $element_list) : array {
        $result_list = [];
        $exception_list = [];

        foreach ( $element_list as $key => $element ) {
            try {
                $result_list[] = $callback($element);
            } catch ( Throwable $exception ) {
                $exception_list[] = $exception;
            }
        }

        if ( !empty($exception_list) )
            throw new ThrowableList('some exceptions thrown during try execution',
                [
                    'element_list' => $element_list,
                ], $exception_list);

        return $result_list;
    }
}