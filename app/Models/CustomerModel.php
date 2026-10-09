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

    // Validation runs automatically inside insert() and update().
    // If it fails, insert()/update() return false and errors() holds the messages.
    protected $validationRules = [
        'full_name' => 'required|max_length[100]',
        'email'     => 'required|valid_email|max_length[100]',
        'phone'     => 'permit_empty|max_length[20]',
    ];

    protected $validationMessages = [
        'full_name' => [
            'required'   => 'Full name is required.',
            'max_length' => 'Full name cannot be longer than 100 characters.',
        ],
        'email' => [
            'required'    => 'Email is required.',
            'valid_email' => 'Please enter a valid email address.',
            'max_length'  => 'Email cannot be longer than 100 characters.',
        ],
        'phone' => [
            'max_length' => 'Phone cannot be longer than 20 characters.',
        ],
    ];
}
