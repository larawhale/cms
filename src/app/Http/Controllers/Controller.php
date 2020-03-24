<?php

namespace LaraWhale\Cms\Http\Controllers;

use Illuminate\Pagination\Paginator;
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
        // Overwrite the exception handler to display custom error pages when
        // a request to one of the cms routes throws an exception. Doing this
        // here prevents the default exception handler to be overwritten for
        // every request, including the ones the user of this package has
        // defined.
        $app->singleton(ExceptionHandler::class, Handler::class);

        // Overwrite the paginator views with custom ones. Doing this here
        // prevents the paginator to overwrite the configuration the user of
        // this package has provided.
        Paginator::defaultView('cms::components.pagination.default');

        Paginator::defaultSimpleView('cms::components.pagination.simple');
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
