<?php
declare(strict_types=1);

namespace App;

use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

// Auth Namespaces
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Psr\Http\Message\ServerRequestInterface;

class Application extends BaseApplication implements AuthenticationServiceProviderInterface
{
    public function bootstrap(): void
    {
        parent::bootstrap();
        if (PHP_SAPI !== 'cli') {
            FactoryLocator::add('Table', (new TableLocator())->allowFallbackClass(false));
        }
        $this->addPlugin('Authentication');
        $this->addPlugin('DebugKit');
    }

    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))
            ->add(new AssetMiddleware())
            ->add(new RoutingMiddleware($this))
            ->add(new BodyParserMiddleware())
            ->add(new AuthenticationMiddleware($this))
            ->add(function ($request, $handler) {
                $controller = $request->getParam('controller');
                $action = $request->getParam('action');
                
                // KEMASKINI: Kecualikan CSRF untuk Login, Register, DAN aksi Admin Programs
                $bypassActions = [
                    'Users' => ['login', 'register'],
                    'Programs' => ['add', 'edit', 'delete']
                ];

                if (isset($bypassActions[$controller]) && in_array($action, $bypassActions[$controller])) {
                    return $handler->handle($request);
                }
                
                // Gunakan tetapan kuki yang lebih longgar untuk local development
                $csrf = new CsrfProtectionMiddleware([
                    'httponly' => true,
                    'checkNoCache' => false,
                ]);
                return $csrf->process($request, $handler);
            });

        return $middlewareQueue;
    }

    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $path = $request->getUri()->getPath();

        // Skip unauthenticated redirect for DebugKit routes
        if (strpos($path, '/debug-kit') !== false) {
            $service = new AuthenticationService();
        } else {
            $service = new AuthenticationService([
                'unauthenticatedRedirect' => \Cake\Routing\Router::url(['controller' => 'Users', 'action' => 'login']),
                'queryParam' => 'redirect',
            ]);
        }

        $service->loadIdentifier('Authentication.Password', [
            'fields' => ['username' => 'matric_no', 'password' => 'password']
        ]);

        $service->loadAuthenticator('Authentication.Session');
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => ['username' => 'matric_no', 'password' => 'password'],
            'loginUrl' => \Cake\Routing\Router::url(['controller' => 'Users', 'action' => 'login']),
        ]);

        return $service;
    }

    public function services(ContainerInterface $container): void {}
}