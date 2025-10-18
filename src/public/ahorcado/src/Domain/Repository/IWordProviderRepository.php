<?php

namespace App\Domain\Repository;

interface IWordProviderRepository
{
    public function randomWord(): string;
}

?>