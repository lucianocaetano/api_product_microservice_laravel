<?php

namespace Src\shared\infrastructure\mediator;

class Mediator implements MediatorEventInterface
{
    protected array $handlers = [];

    public function register(string $eventClass, string $handlerClass): void
    {
        $this->handlers[$eventClass] = $handlerClass;
    }

    public function dispatch(object $event): void
    {
        $eventClass = get_class($event);
        if (!isset($this->handlers[$eventClass])) {
            return;
        }

        $handlerClass = $this->handlers[$eventClass];
        $handler = app($handlerClass);
        $handler->handle($event);
    }
}
