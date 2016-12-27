<?php

namespace App\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;

/**
 * Class AbstractController
 *
 * @package App\Http\Controllers
 */
abstract class AbstractController
{
    private $request;
    private $response;

    /**
     * AbstractController constructor.
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     */
    public function __construct(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Get the request (get/post) param from the request handler
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function getRequestParam($key, $default = null)
    {
        $params = $this->request->getQueryParams();
        if (array_key_exists($key, $params)) {
            return $params[$key];
        }

        return $default;
    }

    /**
     * Verify the existence of a request param
     *
     * @param string $key
     * @return bool
     */
    protected function hasRequestParam($key)
    {
        $params = $this->request->getQueryParams();

        return array_key_exists($key, $params);
    }

    /**
     * Allow a controllers actions to be called statically be invoking a new instance of the controller
     *
     * @param string $method
     * @param array $params
     * @return string|array|ResponseInterface
     * @todo Invoke action through container for DI in controller::action*()
     */
    public static function __callStatic($method, $params)
    {
        $methodName = 'action'.ucfirst($method);

        if (method_exists(static::class, $methodName)) {
            $callback = [new static(array_shift($params), array_shift($params)), $methodName];

            return call_user_func_array($callback, $params[0] ?: []);
        }
        throw new RuntimeException(sprintf("Unknown static method %s::%s()", static::class, $method));
    }

    /**
     * Load the requested view add write it to the body
     *
     * @param string $path
     * @param array  $params
     * @return \Psr\Http\Message\StreamInterface
     */
    protected function view($path, array $params = [])
    {
        $view     = \App\app()->get('view')->view();
        $rendered = $view->make($path, $params)->render();
        $this->response->getBody()->write($rendered);
        return $this->response;
    }
}
