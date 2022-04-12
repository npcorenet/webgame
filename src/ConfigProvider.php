<?php

namespace App;

use App\Http\Paths;
use \Exception;
use Envms\FluentPDO\Query;
use Twig\Environment;

class ConfigProvider
{

    private array $options = [];
    public Query $database;
    public Paths $paths;
    public Environment $twig;

    public function add(string $name, mixed $value): void
    {

        $this->options[$name] = $value;

    }

    public function get(string $name): mixed
    {

        if(array_key_exists($name, $this->options)) {

            return $this->options[$name];

        }

        throw new Exception('Config value "' . $name . '" not defined');

    }

    public function remove(string $name): void
    {

        if(array_key_exists($name, $this->options)) {

            unset($this->options[$name]);
            return;

        }

        throw new Exception('Config value "' . $name . '" not defined');

    }

    public function getConfigArray(): array
    {

        return $this->options;

    }

    public function mergeConfigArray(array $configArray): void
    {

        $this->options = array_merge($this->options, $configArray);

    }

}