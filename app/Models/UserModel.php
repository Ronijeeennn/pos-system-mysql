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
    // `password` always holds a password_hash() value, never plain text (see hashPassword() below).
    protected $allowedFields = ['username', 'password', 'full_name', 'avatar'];

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
        // Optional by default (an empty box on the Edit form means "keep the current password").
        // The New User form makes it required. bcrypt only uses the first 72 characters.
        'password'  => 'permit_empty|min_length[8]|max_length[72]',
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
        'password' => [
            'required'   => 'Password is required.',
            'min_length' => 'Password must be at least 8 characters long.',
            'max_length' => 'Password cannot be longer than 72 characters.',
        ],
    ];

    // Runs automatically right before every insert() and update(), after validation has passed.
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /**
     * Turns a plain password into a password_hash() value before it is saved.
     * If no password was given (Edit form left empty), the column is left out of the query
     * so the existing hash is kept.
     */
    protected function hashPassword(array $data): array
    {
        if (! isset($data['data']['password']) || $data['data']['password'] === '') {
            unset($data['data']['password']);

            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

        return $data;
    }
}
