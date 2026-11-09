<?php
namespace App\Controllers;

class DbTest extends BaseController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $db->initialize();
            $count = $db->table('analytics')->countAllResults();
            return "Connected! Rows in analytics: $count";
        } catch (\Throwable $e) {
            return 'Connection failed: ' . esc($e->getMessage());
        }
    }
}
