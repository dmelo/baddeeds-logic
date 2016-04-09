<?php

namespace BadDeeds\Model;

/**
 * Model that represens a (Bad)Deed.
 */
class Deed
{
    /**
     * ID of the deed on the database.
     */
    public $id;

    /**
     * Subject of the deed.
     */
    public $subject;

    /**
     * Description of the deed.
     */
    public $description;

    public function __construct(int $id, string $subject, string $description)
    {
        $this->id = $id;
        $this->subject = $subject;
        $this->description = $description;
    }
}
