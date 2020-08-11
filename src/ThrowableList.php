<?php
declare(strict_types=1);

namespace labo86\exception_with_data;


use Throwable;

class ThrowableList extends ExceptionWithData
{
    /**
     * @var Throwable[]
     */
    protected array $previous_list;

    public function __construct(string $message, array $data, array $previous_list) {
        parent::__construct($message, $data, $previous_list[0] ?? null);
        $this->previous_list = $previous_list;
    }

    /**
     * @return Throwable[]
     */
    public function getPreviousList() : array {
        return $this->previous_list;
    }

    public function toArray(bool $file_data = true) : array {
        $array_data = parent::toArray($file_data);

        foreach ( $this->getPreviousList() as $previous ) {
            $array_data['pl'][] = Util::toArray($previous, $file_data);
        }

        return $array_data;
    }
}