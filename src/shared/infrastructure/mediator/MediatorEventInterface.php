<?php

namespace Src\shared\infrastructure\mediator;

interface MediatorEventInterface
{
    public function dispatch(object $event): void;
}

