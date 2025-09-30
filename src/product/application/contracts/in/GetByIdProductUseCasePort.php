<?php

namespace Src\product\application\contracts\in;

interface GetByIdProductUseCasePort {

    public function execute(string $id);
}
