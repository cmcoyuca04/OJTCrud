<?php

namespace App\Models;

use CodeIgniter\Model;

class AnalyticsModel extends Model
{
    protected $table            = 'analytics';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $useTimestamps    = false;
    protected $allowedFields    = ['client_id', 'type', 'ip_address', 'session_id', 'created_at'];

    /**
     * Reads the allowed values of the `type` ENUM column straight from the database,
     * so the dropdown always matches the table definition.
     */
    public function typeOptions(): array
    {
        $row = $this->db->query("SHOW COLUMNS FROM `{$this->table}` LIKE 'type'")->getRowArray();

        if ($row && isset($row['Type']) && preg_match_all("/'((?:[^']|'')*)'/", $row['Type'], $m)) {
            return array_map(static fn ($v) => str_replace("''", "'", $v), $m[1]);
        }

        return ['page_view', 'visitor'];
    }
}
