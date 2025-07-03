<?php

namespace UzInfo\LaravelApiGenerator\Traits;

/**
 * Trait API request additional logics
 */
trait ApiRequest
{
    /**
     * @return array
     */
    public function validationData(): array
    {
        $this->merge(['id' => $this->getParameter()]);
        $this->setParameters();

        return $this->all();
    }

    /**
     * @return string|null
     */
    public function getParameter()
    {
        if (isset(self::$route_parameter)){
            return $this->route()->parameter(self::$route_parameter);
        }
        return $this->route()->parameter($this->route_parameter);
    }

    /**
     * @return void
     */
    public function setParameters(): void
    {
        foreach ($this->route_params ?? [] as $route_param => $key) {
            $this->merge([$key => $this->route()->parameter($route_param)]);
        }
    }
}
