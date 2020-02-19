<?php

namespace LaraWhale\Cms\Tests;

use Illuminate\Http\Request;
use Collective\Html\FormBuilder;
use Collective\Html\HtmlBuilder;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Routing\RouteCollection;
use Illuminate\Contracts\View\Factory;


trait MocksFormFacade
{
    /**
     * Mocks the form facade.
     */
    public function mockFormFacade(): void
    {
        $urlGenerator = new UrlGenerator(
            new RouteCollection(),
            Request::create('/foo', 'GET'),
        );

        $viewFactory = app(Factory::class);

        $htmlBuilder = new HtmlBuilder($urlGenerator, $viewFactory);

        $request = Request::create('/foo', 'GET', [
            "person" => [
                "name" => "John",
                "surname" => "Doe",
            ],
            "agree" => 1,
            "checkbox_array" => [1, 2, 3],
        ]);

        $request = Request::createFromBase($request);

        $formBuilder = new FormBuilder(
            $htmlBuilder,
            $urlGenerator,
            $viewFactory,
            'abc',
            $request,
        );

        $this->app->bind('form', fn() => $formBuilder);
    }
}
