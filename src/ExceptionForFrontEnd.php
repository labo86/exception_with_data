<?php
declare(strict_types=1);

namespace labo86\exception_with_data;

use Throwable;

class ExceptionForFrontEnd extends ExceptionWithData
{
    protected string $id;

    /**
     * Lo que hace de esta excepción unica es que permite esconder los datos del backend del usuario del front end.
     * Para eso crea un {@see getId() identificador único} que permite enlanzar los datos internos generador con {@see toArray()}  y los que se muestran al usuario que se obtienen con {@see getDataForUser()}
     * La función {@see normalize} sirve para transformar cualquier Throwable en una ExpectionForFrontEnd y aso permitir usar los métodos para extraer la data.
     * @param string $message
     * @param array $data
     * @param Throwable|null $previous
     */
    public function __construct(string $message, array $data = [], Throwable $previous = null) {
        parent::__construct($message, $data, $previous);
        $this->id = uniqid();
    }

    /**
     * Obtener identificador.
     * Con este identificador el desarrollador peude asociar un error de front end con lo que paso en el back end.
     * @return string
     */
    public function getId() : string {
        return $this->id;
    }

    /**
     * Ver {@see Util::toArray()} para el detalle del contenido del arreglo
     * Se agrega el siguiente campo
     *  - i : identificador {@see ThrowableList::getPreviousList()} El identificador de ésta excepción
     * @param bool $file_data
     * @return array
     */
    public function toArray(bool $file_data = true) : array {
        $array_data = parent::toArray($file_data);

        $array_data['i'] = $this->id;
        return $array_data;
    }

    /**
     * Genera la data que es para la visualización del usuario.
     * Ver {@see ExceptionForFrontEnd::toArray()} para el detalle del contenido del arreglo
     * @return array
     */
    public function getDataForUser() : array {
        return [
            'm' => $this->getMessage(),
            'd' => $this->getData(),
            'i' => $this->getId()
        ];
    }

    /**
     * Convierte un Throwable en una ExceptionForFrontEnd.
     * Si el throwable ya es una ExceptionForFronEnd entonces la devuelve.
     * Esta función es util para esconder los mensajes críticos de la aplicación al usuario final
     * @param Throwable $throwable
     * @return ExceptionForFrontEnd
     */
    public static function normalize(Throwable $throwable, string $message = "GENERIC_ERROR") : ExceptionForFrontEnd {
        if ( $throwable instanceof ExceptionForFrontEnd ) {
            return $throwable;
        } else {
            return new ExceptionForFrontEnd($message , [], $throwable);
        }
    }


}