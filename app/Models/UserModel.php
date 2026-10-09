<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * UserModel
 *
 * Handles all database access for the `users` table:
 *   id, username, full_name, avatar, created_at
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
    // `avatar` holds only the image file name; the file itself lives in public/uploads/avatars/
    protected $allowedFields = ['username', 'full_name', 'avatar'];

    // The users table has a created_at column but no updated_at column.
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = '';

    // Validation runs automatically inside insert() and update().
    // {id} is replaced with the record's id when editing, so a user can keep their own
    // username but cannot take someone else's.
    protected $validationRules = [
        // CodeIgniter 4.7 needs a rule for the field behind the {id} placeholder below.
        'id'        => 'permit_empty|is_natural_no_zero',
        'username'  => 'required|max_length[50]|is_unique[users.username,id,{id}]',
        'full_name' => 'required|max_length[100]',
    ];

    protected $validationMessages = [
        'username' => [
            'required'   => 'Username is required.',
            'max_length' => 'Username cannot be longer than 50 characters.',
            'is_unique'  => 'That username is already taken. Please choose another one.',
        ],
        'full_name' => [
            'required'   => 'Full name is required.',
            'max_length' => 'Full name cannot be longer than 100 characters.',
        ],
    ];
}
