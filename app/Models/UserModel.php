<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * UserModel
 *
 * Handles all database access for the `users` table:
 *   id, username, full_name, created_at
 */
class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    // Return rows as arrays so the views keep using $user['username'], etc.
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    // Columns that may be written through insert()/update()/save().
    // `id` is auto-generated and `created_at` is filled in by the timestamp feature below.
    protected $protectFields = true;
    protected $allowedFields = ['username', 'full_name'];

    // The users table has a created_at column but no updated_at column.
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';
}
