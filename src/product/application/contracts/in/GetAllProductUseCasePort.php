<?php

namespace Src\product\application\contracts\in;

interface GetAllProductUseCasePort {

    /**
     * @return [
     *   "items" => Product[],
     *   "meta" => array
     * ]
     */
    public function execute(array $filter): array;
}

