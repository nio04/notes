<?php

namespace Framework;

use App\Controllers\HomeController;
use App\Controllers\RegisterController;
use App\Controllers\LoginController;
use App\Controllers\LogoutController;
use App\Controllers\NoteController;
use App\Controllers\NoteCreateController;
use App\Controllers\NoteDeleteController;
use App\Controllers\NoteSearchController;
use App\Controllers\NoteUpdateController;
use App\Controllers\NoteViewController;

/**
 * The `Router` class is responsible for handling and dispatching HTTP requests to the appropriate
 * controller actions based on the registered routes. It maps URIs to specific controllers and actions,
 * processes the request URI, and invokes the corresponding method in the controller.
 */
class Router {

  /**
   * @var array $routes
   * An associative array that stores all registered routes. Each route is associated with a controller,
   * an action method, and an HTTP method.
   */
  protected static array $routes = [];

  /**
   * @var string $uri
   * Stores the processed URI from the incoming HTTP request. This is used to determine which route
   * should be matched and handled.
   */
  protected static string $uri;

  /**
   * @var mixed $params
   * Stores any extracted parameters from the URI. These parameters can be passed to controller actions
   * when needed.
   */
  protected static $params;

  /**
   * Automatically registers routes by mapping specific URIs to corresponding controllers and actions.
   * This method defines the available routes in the application, such as home, authentication, blogs,
   * dashboard, and category routes.
   */
  public static function autoRegisterRoute(): void {
    // Home routes
    self::$routes['/'] = [
      'controller' => HomeController::class,
      'action' => 'index',
      'httpMethod' => 'get'
    ];

    // Authentication routes [login]
    self::$routes['/login'] = [
      'controller' => LoginController::class,
      'action' => 'index',
      'httpMethod' => 'get'
    ];
    // Authentication routes
    self::$routes['/login/submit'] = [
      'controller' => LoginController::class,
      'action' => 'submit',
      'httpMethod' => 'post'
    ];
    self::$routes['/logout'] = [
      'controller' => LogoutController::class,
      'action' => 'index',
      'httpMethod' => 'get'
    ];
    self::$routes['/logout/submit'] = [
      'controller' => LogoutController::class,
      'action' => 'logout',
      'httpMethod' => 'post'
    ];

    // Authentication routes [register]
    self::$routes['/register'] = [
      'controller' => RegisterController::class,
      'action' => 'index',
      'httpMethod' => 'get'
    ];
    // Authentication routes
    self::$routes['/register/submit'] = [
      'controller' => RegisterController::class,
      'action' => 'submit',
      'httpMethod' => 'post'
    ];

    // notes
    self::$routes['/notes'] = [
      'controller' => NoteController::class,
      'action' => 'index',
      'httpMethod' => 'get'
    ];
    self::$routes['/notes/create'] = [
      'controller' => NoteCreateController::class,
      'action' => 'index',
      'httpMethod' => 'get'
    ];
    self::$routes['/notes/save'] = [
      'controller' => NoteCreateController::class,
      'action' => 'save',
      'httpMethod' => 'post'
    ];
    self::$routes['/notes/view'] = [
      'controller' => NoteViewController::class,
      'action' => 'index',
      'httpMethod' => 'get'
    ];
    // old note view
    self::$routes['/notes/viewOld'] = [
      'controller' => NoteViewController::class,
      'action' => 'viewOldNotes',
      'httpMethod' => 'post'
    ];
    self::$routes['/notes/delete'] = [
      'controller' => NoteDeleteController::class,
      'action' => 'index',
      'httpMethod' => 'get'
    ];
    self::$routes['/notes/update'] = [
      'controller' => NoteUpdateController::class,
      'action' => 'index',
      'httpMethod' => 'get'
    ];
    self::$routes['/notes/upload'] = [
      'controller' => NoteUpdateController::class,
      'action' => 'upload',
      'httpMethod' => 'post'
    ];

    self::$routes['/notes/search'] = [
      'controller' => NoteSearchController::class,
      'action' => 'search',
      'httpMethod' => 'get'
    ];
  }

  /**
   * Dispatches the incoming HTTP request to the appropriate controller and action based on the URI.
   * The method first processes the URI and checks if it matches any registered route. If a match is found,
   * it checks the HTTP method and then calls the specified action in the controller. If no match is found,
   * or if the HTTP method does not match, an exception is thrown.
   *
   * @throws \Exception if the route is not found or if the HTTP method is not allowed.
   */
  public static function dispatch(): void {
    $uri = parse_url(rtrim($_SERVER['REQUEST_URI'], '/'), PHP_URL_PATH);
    $httpMethod = strtolower($_SERVER['REQUEST_METHOD'] ?? 'get');

    // Extract parameters from the URI if any
    self::extractParams($uri);

    foreach (self::$routes as $routeUri => $routeDetails) {

      if (self::matchUri($routeUri, self::$uri)) {
        if ($httpMethod !== $routeDetails['httpMethod']) {
          throw new \Exception("HTTP method not allowed for this route.");
        }

        $controller = new $routeDetails['controller'];
        $action = $routeDetails['action'] ?? 'index';

        if (method_exists($controller, $action)) {
          call_user_func_array([$controller, $action], [self::$params]);
        } else {
          throw new \Exception("Action $action not found in controller.");
        }

        return;
      }
    }

    throw new \Exception("Route not found.");
  }

  /**
   * Extracts any parameters from the URI and updates the internal state of the URI.
   * This method processes the URI segments, isolating any parameters that may be needed
   * by the controller's action.
   *
   * @param string $uri The URI string from the HTTP request.
   */
  private static function extractParams(string $uri): void {
    $uriSegments = explode('/', trim($uri, '/'));

    if (isset($uriSegments[2])) {
      self::$params = $uriSegments[2];
      unset($uriSegments[2]);
      $uriSegments = array_values($uriSegments);
    }

    $uri = implode('/', $uriSegments) ?: '/';
    self::$uri = "/$uri";
  }

  /**
   * Compares the request URI with a registered route URI to determine if they match.
   *
   * @param string $routeUri The registered route URI.
   * @param string $requestUri The URI from the HTTP request.
   * @return bool Returns true if the URIs match, otherwise false.
   */
  private static function matchUri(string $routeUri, string $requestUri): bool {
    return rtrim($routeUri, '/') === rtrim($requestUri, '/');
  }
}
