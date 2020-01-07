<?php

namespace App\Core;

use App\Core\Controller;
use App\Core\Singleton;
use App\Helper\Exceptions\AdminErrorException;
use PDO;

/**
 * Class App
 * defines the router
 */
class App extends Singleton
{
    /**
     * Singleton App
     */
    private static $instance;

    /**
     * Singleton database
     */
    private $database;

    /**
     * by default, home controller called
     * @var string
     */
    protected $controller = 'home';

    /**
     * by default, index method called
     * @var string
     */
    protected $method = 'index';

    /**
     * @var array params
     */
    protected $params = [];

    /**
     * get the controller in $this->controller from the url
     * @param array : parsed url
     * @return array : parsed url : unset controller, method and params remain if exist
     */
    public function getController()
    {
        $url = $this->parseUrl();
        if (file_exists('../src/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        }

        $this->controller = ucfirst($this->controller);
        require_once '../src/controllers/' . $this->controller . '.php';
        return $url;
    }

    /**
     * call method of the controller passing the params
     * @param array $par first $_GET parameter
     * @return html from twig
     */
    public function getMethod($url)
    {
        $object = 'App\\controllers\\' . $this->controller;
        $this->controller = new $object();

        if (isset($url[1])) {
            $this->method = $url[1];
            $this->method = strtolower($this->method);
            unset($url[1]);
        }

        $this->params = $url ? array_values($url) : [];

        if (method_exists($this->controller, $this->method) === false) {
            $backController = new Controller();
            if ($object === 'App\\controllers\\Admin') {
                $backController->notFoundAdmin();
            } else {
                $backController->notFound();
            }
        }

        /*
        if ($object === 'App\\controllers\\Admin') {

            set_error_handler(function($errno, $errstr, $errfile, $errline ){
                throw new AdminErrorException($errstr, $errno, 0, $errfile, $errline);
            });

            try {
                $response = call_user_func_array(array($this->controller, $this->method), $this->params);
            } catch (AdminErrorException $e) {
                $backController->notFoundAdmin();
            }
        } else {
         */
            $response = call_user_func_array(array($this->controller, $this->method), $this->params);
        // }

        return $response;
    }

    /**
     * parse the url
     */
    private function parseUrl()
    {
        if (isset($_GET['url'])) {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }

    /**
     * Repository Factory
     * @return Object Repository
     */
    public function getRepository($name)
    {
        $class_name = '\\App\\Repository\\' . ucfirst($name) . 'Repository';
        return $class_name::getInstanceRepo($this->getDb());
    }

    /**
     * AjaxRequest Factory
     * @return Object AjaxRequest
     */
    public function getAjaxRequest($name)
    {
        $className = '\\App\\Helper\\Ajax\\' . ucfirst($name) . 'AjaxRequest';
        return $className::getInstance();
    }

    /**
     * Database Factory
     * @return Object Database
     */
    public function getDb()
    {
        if ($this->database === null) {
            try {
                $database = include '../src/Application/database.php';
                $this->database = new PDO('mysql:host=' . $database['host'] . ';dbname=' . $database['db'] . ';charset=utf8', $database['username'], $database['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            } catch (PDOException $e) {
                    echo $e->getMessage();
            }
        }

        return $this->database;
    }

    /**
     * Singleton
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new App
        }

        return self::$instance;
    }
     */
}
