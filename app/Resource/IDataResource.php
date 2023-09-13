<?php

namespace App\Resource;

interface IDataResource {

    public function getData(): string;

    public function getImagePath(): string;
}