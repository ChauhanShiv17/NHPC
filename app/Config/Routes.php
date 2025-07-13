<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ✅ Homepage & Home related
$routes->get('blog/search-suggest', 'BlogController::searchSuggest');
$routes->get('/', 'HomeController::index');                   // Homepage (shows recent blogs, categories, etc.)
$routes->get('/home', 'HomeController::index');                // Also /home
$routes->get('/search', 'BlogController::search');            // Search blogs
$routes->get('category/(:any)', 'BlogController::category/$1'); // View blogs by category
$routes->get('blog/load-more', 'BlogController::loadMore');
$routes->get('/admin/home', 'Admin\Dashboard::index');  



// ✅ Blog related
$routes->get('/blog', 'BlogController::index');               // All published blogs
$routes->get('/blog/create', 'BlogController::create');       // Author create blog page
$routes->post('/blog/store', 'BlogController::store');        // Store new blog
$routes->get('blog/(:num)', 'BlogController::view/$1');       // View single blog post


// ✅ Auth: Login / Register / Logout
$routes->get('/login', 'AuthController::login');              // Login page
$routes->post('/do-login', 'AuthController::doLogin');        // Process login
$routes->get('/logout', 'AuthController::logout');            // Logout
$routes->get('/register', 'AuthController::register');        // Register page
$routes->post('/register', 'AuthController::doRegister');     // Process register

// ✅ Profile (My Profile)
$routes->get('/my-profile', 'ProfileController::index');      // My profile page
$routes->get('/profile', 'UserController::profile');          // (Optional) profile alias

// ✅ Author Panel
$routes->get('author/dashboard', 'Author\Dashboard::index');  // Author dashboard
$routes->get('author/blogs', 'AuthorController::index');      // List of author's own blogs
$routes->get('/author/rejected-blogs', 'Author\Dashboard::rejectedBlogs');


// ✅ Admin Panel - Dashboard & analytics
$routes->get('/admin/dashboard', 'AdminController::dashboard');     // Admin dashboard
$routes->get('/admin/analytics', 'Admin\Analytics::index');         // (Optional) analytics page

// ✅ Admin Panel - Blogs moderation
$routes->get('admin/pending-blogs', 'AdminController::pendingBlogs'); // Pending blogs list
$routes->get('admin/approve/(:num)', 'AdminController::approve/$1');  // Approve a blog
$routes->get('admin/reject/(:num)', 'AdminController::reject/$1');    // Reject/delete a blog
$routes->get('admin/all-blogs', 'AdminController::allBlogs');        // View all approved blogs
$routes->get('/admin/rejected-blogs', 'AdminController::rejectedBlogs');


// ✅ Admin Panel - Admins moderation
$routes->get('admin/pending-admins', 'AdminController::pendingAdmins');           // Pending admin users
$routes->get('admin/approve-admin/(:num)', 'AdminController::approveAdmin/$1');   // Approve admin
$routes->get('admin/reject-admin/(:num)', 'AdminController::rejectAdmin/$1');     // Reject admin

// ✅ Admin Panel - Users management
$routes->get('admin/all-users', 'AdminController::allUsers');         // View all users
$routes->get('admin/remove-user/(:num)', 'AdminController::removeUser/$1'); // Block/remove user

// ✅ Fallback old optional admin index (not usually needed)
$routes->get('/admin', 'AdminController::index');                     // Old moderation list (optional)

// ✅ (Optional) home page fallback
$routes->get('/home', function() {
    return view('home');
});
