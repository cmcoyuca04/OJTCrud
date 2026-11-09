<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class EmployeeModel extends Model
{
    protected $table            = 'employees';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['name', 'role'];

    // Fill in created_at automatically on insert; the table has no updated_at.
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function __construct(?ConnectionInterface $db = null, ?ValidationInterface $validation = null)
    {
        // Reuse the host/user/password of the default connection,
        // but point it at the test_database database.
        $config             = config('Database')->default;
        $config['database'] = 'test_database';
        $db                 = db_connect($config);

        parent::__construct($db, $validation);
    }
}
