<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $userRole = $session->get('user_type'); // set this at login

        // If not logged in, send to login
        if (!$userRole) {
            return redirect()->to('/login');
        }

        // If roles are defined in routes and user is not allowed
        if ($arguments && !in_array($userRole, $arguments)) {
            return redirect()->to('/dashboard')->with('error', 'Unauthorized access');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nothing needed after
    }
}
