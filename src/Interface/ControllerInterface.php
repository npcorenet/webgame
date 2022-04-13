<?php

namespace App\Interface;

use App\ConfigProvider;
use App\Container;

interface ControllerInterface
{

    public function __construct(Container $container);

    public function handle();

    public function get(): void;

    public function post(): void;

}