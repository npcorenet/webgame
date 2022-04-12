<?php

namespace App\Interface;

use App\ConfigProvider;

interface ControllerInterface
{

    public function __construct(ConfigProvider $configProvider);

    public function handle();

    public function get();

    public function post();

}