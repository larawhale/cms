<?php

namespace LaraWhale\Cms\Http\Controllers;

use LaraWhale\Cms\Exceptions\Handler;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Controller extends BaseController
{
    /**
     * The Controller constructor.
     * 
     * @param  \Illuminate\Foundation\Application  $app
     */
    public function __construct(Application $app)
    {
        $app->singleton(ExceptionHandler::class, Handler::class);
    }

    /**
     * The fallback route method.
     * 
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function fallback()
    {
        throw new NotFoundHttpException;
    }
}
