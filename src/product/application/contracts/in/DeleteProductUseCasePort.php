<?php

namespace Src\product\application\contracts\in;

interface DeleteProductUseCasePort
{
    public function execute(string $id): void;
}
