<?php

namespace Swatty007\LaravelVersioningHelper\Tests;

use Illuminate\Support\Str;
use Orchestra\Testbench\TestCase;
use ReflectionClass;

abstract class ComponentTestCase extends TestCase
{
    public function rendered(string $component, array $data = []): string
    {
        [$data, $attributes] = $this->partitionDataAndAttributes($component, $data);

        $component = $this->app->make($component, $data->all());

        $component->withAttributes($attributes->all());

        $view = $component->resolveView();

        $view->with($component->data());

        return trim($view->render());
    }

    protected function partitionDataAndAttributes($class, array $attributes): \Illuminate\Support\Collection
    {
        $constructor = (new ReflectionClass($class))->getConstructor();

        $parameterNames = $constructor
            ? collect($constructor->getParameters())->map->getName()->all()
            : [];

        return collect($attributes)->partition(fn ($value, $key) => in_array(Str::camel($key), $parameterNames));
    }
}
