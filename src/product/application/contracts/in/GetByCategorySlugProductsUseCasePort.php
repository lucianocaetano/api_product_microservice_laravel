<?php

namespace Src\product\application\contracts\in;

interface GetByCategorySlugProductsUseCasePort
{
    public function execute(string $slug): array;
}
