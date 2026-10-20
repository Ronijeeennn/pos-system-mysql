<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * AuthFilter: lets a request through only when the visitor is logged in.
 *
 * Registered under the alias "auth" in app/Config/Filters.php and attached to the
 * Customer Accounts and User Accounts routes in app/Config/Routes.php.
 */
class AuthFilter implements FilterInterface
{
    /**
     * Runs BEFORE the controller. Returning a response here stops the request,
     * so the protected controller method never runs for a visitor who is not logged in.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Logged in = the login action stored both the flag and the user's id in the session.
        if ($session->get('logged_in') === true && $session->get('user_id')) {
            return; // allowed: continue to the controller
        }

        // Remember which page was asked for (GET only) so login can send the visitor back to it.
        if ($request->is('get')) {
            $session->set('redirect_url', uri_string());
        }

        return redirect()->to('login')
            ->with('error', 'Please log in to continue.');
    }

    /**
     * Runs AFTER the controller. Pages behind the login must not be stored by the browser,
     * otherwise the Back button could show them again after logging out.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        return $response
            ->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->setHeader('Pragma', 'no-cache');
    }
}
