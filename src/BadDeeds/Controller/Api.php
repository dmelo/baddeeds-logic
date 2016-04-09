<?php

namespace BadDeeds\Controller;

use BadDeeds\Model\Deed;

/**
 * Handles the business logic.
 */
class Api
{
    private $db;

    /*
     * Index of the first page.
     */
    const FIRST_PAGE = 0;

    /**
     * Default size of the page.
     */
    const DEFAULT_SIZE = 10;

    /**
     * Default constructor.
     *
     * @param \PDO $db Database connection
     */
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Produce a list of deeds.
     */
    public function list(
        int $page = self::FIRST_PAGE,
        int $size = self::DEFAULT_SIZE
    ) : array
    {
        $offset = $page * $size;
        $sql = "select id, subject, description from deed order by id desc " .
            "limit $offset, $size";
        $ret = [];
        foreach ($this->db->query($sql) as $row) {
            $ret[] = new Deed($row['id'], $row['subject'], $row['description']);
        }

        return $ret;
    }

    /**
     * Insert a deed.
     */
    public function insert(string $subject, string $description) : int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO deed (subject, description) VALUES(:subject, ' .
            ':description)'
        );
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':description', $description);
        return $stmt->execute() ? $this->db->lastInsertId('deed') : 0;
    }
}
