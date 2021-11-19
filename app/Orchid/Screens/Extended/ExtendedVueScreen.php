<?php


namespace App\Orchid\Screens\Extended;

use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Orchid\Screen\LayoutFactory;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;
use Throwable;

abstract class ExtendedVueScreen extends Screen
{
    /**
     * @var Repository
     */
    protected $source;

    /**
     * @param string $method
     * @param array  $parameters
     *
     * @throws ReflectionException
     *
     * @return mixed
     */
    private function callMethod(string $method, array $parameters = [])
    {
        return call_user_func_array([$this, $method],
            $this->reflectionParams($method, $parameters)
        );
    }


    /**
     * @param string $method
     * @param array  $httpQueryArguments
     *
     * @throws ReflectionException
     *
     * @return array
     */
    private function reflectionParams(string $method, array $httpQueryArguments = []): array
    {
        $class = new ReflectionClass($this);

        if (! is_string($method)) {
            return [];
        }

        if (! $class->hasMethod($method)) {
            return [];
        }

        $parameters = $class->getMethod($method)->getParameters();

        return collect($parameters)
            ->map(function ($parameter, $key) use ($httpQueryArguments) {
                return $this->bind($key, $parameter, $httpQueryArguments);
            })->all();
    }

    /**
     * It takes the serial number of the argument and the required parameter.
     * To convert to object.
     *
     * @param int $key
     * @param ReflectionParameter $parameter
     * @param array $httpQueryArguments
     *
     * @return mixed
     * @throws Throwable
     */
    private function bind(int $key, ReflectionParameter $parameter, array $httpQueryArguments)
    {
        $class = $parameter->getType() && ! $parameter->getType()->isBuiltin()
            ? $parameter->getType()->getName()
            : null;

        $original = array_values($httpQueryArguments)[$key] ?? null;

        if ($class === null || is_object($original)) {
            return $original;
        }

        $instance = resolve($class);

        if ($original === null || ! is_a($instance, UrlRoutable::class)) {
            return $instance;
        }

        $model = $instance->resolveRouteBinding($original);

        throw_if(
            $model === null && ! $parameter->isDefaultValueAvailable(),
            (new ModelNotFoundException())->setModel($class, [$original])
        );

        optional(Route::current())->setParameter($parameter->getName(), $model);

        return $model;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     * @throws Throwable
     *
     */
    public function build(): \Illuminate\Contracts\View\View
    {
        return LayoutFactory::blank([
            $this->layout(),
        ])->build($this->source);
    }

    /**
     * @param array $httpQueryArguments
     *
     * @return Factory|View
     * @throws ReflectionException
     * @throws Throwable
     *
     */
    public function view(array $httpQueryArguments = [])
    {
        $query = $this->callMethod('query', $httpQueryArguments);
        $this->source = new Repository($query);
        $commandBar = $this->buildCommandBar($this->source);

        return view('orchid.layouts.vue-layout', [
            'name'                => $this->name,
            'description'         => $this->description,
            'commandBar'          => $commandBar,
            'layouts'             => $this->build(),
            'formValidateMessage' => $this->formValidateMessage(),
        ]);
    }
}
