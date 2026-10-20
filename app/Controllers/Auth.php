<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    /**
     * A real bcrypt hash of a throw-away value. It is used when the username does not exist,
     * so password_verify() still does the same amount of work and the response time does not
     * reveal which usernames are real.
     */
    private const DUMMY_HASH = '$2y$10$GwA8tUin5F4ggT2jN4vHMOqRHvLv6cFhqlUAwBFc18NQG.PTrLqY6';

    /**
     * Login form ("/login")
     */
    public function login()
    {
        // Already logged in? No need to see the form again.
        if (session()->get('logged_in') === true) {
            return redirect()->to('customers');
        }

        return $this->renderLogin('', []);
    }

    /**
     * Handles the login form (POST "/login").
     * Finds the user, checks the password with password_verify(), then starts the session.
     */
    public function attempt()
    {
        $rules = [
            'username' => [
                'label'  => 'Username',
                'rules'  => 'required',
                'errors' => ['required' => 'Username is required.'],
            ],
            'password' => [
                'label'  => 'Password',
                'rules'  => 'required',
                'errors' => ['required' => 'Password is required.'],
            ],
        ];

        $username = trim((string) $this->request->getPost('username'));

        if (! $this->validate($rules)) {
            return $this->renderLogin($username, $this->validator->getErrors());
        }

        // Passwords are never trimmed or changed: what was typed is what gets checked.
        $password = (string) $this->request->getPost('password');

        $user = (new UserModel())->where('username', $username)->first();

        // Compare against the stored hash (or the dummy hash for unknown usernames).
        $hash  = $user['password'] ?? self::DUMMY_HASH;
        $valid = password_verify($password, $hash) && $user !== null;

        if (! $valid) {
            // One message for both "no such user" and "wrong password".
            return $this->renderLogin($username, ['login' => 'Invalid username or password.']);
        }

        // Success. Read the page the visitor wanted, then start a fresh session:
        // regenerate(true) gives a new session id and deletes the old one (stops session fixation).
        $session = session();
        $goTo    = $session->get('redirect_url');
        $session->regenerate(true);

        $session->set([
            'logged_in' => true,
            'user_id'   => (int) $user['id'],
            'username'  => $user['username'],
            'full_name' => $user['full_name'],
        ]);
        $session->remove('redirect_url');

        // Only send the visitor back to a plain internal path that the filter stored.
        if (! is_string($goTo) || ! preg_match('#^[A-Za-z0-9/_-]+$#', $goTo) || $goTo === 'login') {
            $goTo = 'customers';
        }

        return redirect()->to($goTo)
            ->with('success', 'Welcome back, ' . $user['full_name'] . '!');
    }

    /**
     * Logout (POST "/logout"): destroys the session and goes back to the login page.
     * It is a POST so that another website cannot log a visitor out with a simple link.
     */
    public function logout()
    {
        session()->destroy();

        // The session no longer exists, so a flash message cannot be used. A fixed flag in the URL
        // lets the login page say "logged out".
        return redirect()->to('login?logged_out=1');
    }

    private function renderLogin(string $username, array $errors)
    {
        $data = [
            'title'     => 'Log In',
            'username'  => $username,
            'errors'    => $errors,
            'loggedOut' => $this->request->getGet('logged_out') === '1',
        ];

        return view('templates/header', $data)
            . view('auth/login', $data)
            . view('templates/footer');
    }
}
