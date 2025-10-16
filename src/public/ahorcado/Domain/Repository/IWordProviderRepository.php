<?php

namespace Domain\Repository;

interface IWordProviderRepository
{
    public function randomWord(): string;
}

?>