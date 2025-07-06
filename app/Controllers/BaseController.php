<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation.
     *
     * @var list<string>
     */
    protected $helpers = ['url', 'form', 'text', 'session'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Load session service globally
        $this->session = \Config\Services::session();
    }

    // Redirect if user not logged in
    protected function requireLogin()
    {
        if (!session()->get('user_id')) {
            return redirect()->to('/login')->with('error', 'You must be logged in.');
        }
    }

    // Role-based access check
    protected function checkRole(string $requiredRole)
    {
        if (session()->get('role') !== $requiredRole) {
            return redirect()->back()->with('error', 'Access denied.');
        }
    }
}
