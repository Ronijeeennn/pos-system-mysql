<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Gives every user that has no password yet a HASHED starting password.
 *
 * Run it from the project folder after adding the `password` column:
 *     php spark db:seed UserPasswordSeeder
 *
 * It produces the same result as database/tfa4_add_password.sql, but from code, using
 * password_hash(). Users that already have a password are left alone, so it is safe to run twice.
 */
class UserPasswordSeeder extends Seeder
{
    /** Starting password for the sample accounts. Change it after the first login. */
    private const DEFAULT_PASSWORD = 'Welcome123!';

    public function run()
    {
        $users = $this->db->table('users')
            ->select('id, username')
            ->groupStart()
                ->where('password', null)
                ->orWhere('password', '')
            ->groupEnd()
            ->get()
            ->getResultArray();

        foreach ($users as $user) {
            // A new random salt is created for every call, so no two hashes look alike.
            $this->db->table('users')
                ->where('id', $user['id'])
                ->update(['password' => password_hash(self::DEFAULT_PASSWORD, PASSWORD_DEFAULT)]);

            echo "Password set for {$user['username']}\n";
        }

        echo count($users) . " user(s) updated.\n";
    }
}
