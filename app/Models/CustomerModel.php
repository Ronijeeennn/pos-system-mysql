<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * CustomerModel
 *
 * Handles all database access for the `customers` table:
 *   id, full_name, email, phone, created_at
 */
class CustomerModel extends Model
{
    protected $table            = 'customers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // Return rows as arrays so the views keep using $customer['full_name'], etc.
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    // Columns that may be written through insert()/update()/save().
    // `id` is auto-generated and `created_at` is filled in by the timestamp feature below.
    protected $protectFields = true;
    protected $allowedFields = ['full_name', 'email', 'phone'];

    // The customers table has a created_at column but no updated_at column.
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';
}
