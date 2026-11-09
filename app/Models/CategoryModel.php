<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $useTimestamps    = false;
    protected $allowedFields    = ['name', 'type'];

    public function __construct(?ConnectionInterface $db = null, ?ValidationInterface $validation = null)
    {
        // Reuse the host/user/password of your default connection,
        // but point it at the finance_app database instead of hrweb_db.
        $config             = config('Database')->default;
        $config['database'] = 'finance_app';
        $db                 = db_connect($config);

        parent::__construct($db, $validation);
    }

    /**
     * Reads the allowed values of the `type` ENUM column from the database
     * (e.g. Income, Expense) so the dropdown always matches the table.
     */
    public function typeOptions(): array
    {
        $row = $this->db->query("SHOW COLUMNS FROM `categories` LIKE 'type'")->getRowArray();

        if ($row && isset($row['Type']) && preg_match_all("/'((?:[^']|'')*)'/", $row['Type'], $m)) {
            return array_map(static fn ($v) => str_replace("''", "'", $v), $m[1]);
        }

        return ['Income', 'Expense'];
    }
}
