<?php

namespace App\Interface;

interface ControllerInterface
{

    public function handle();

    public function get();

    public function post();

}