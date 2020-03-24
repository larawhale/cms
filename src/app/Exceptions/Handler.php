<?php

namespace LaraWhale\Cms\Exceptions;

use Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        $response = parent::render($request, $exception);

        if ($response instanceof RedirectResponse) {
            return $response;
        }

        $status = 500;

        if ($this->isHttpException($exception)) {
            $status = $exception->getStatusCode();

            if ($status === 404 && ! Auth::check()) {
                return redirect()->route('cms.login');
            }
        } elseif (config('app.debug')) {
            return $response;
        }

        return response()->view(
            'cms::pages.error',
            compact('status'),
            $status,
        );
    }
}
