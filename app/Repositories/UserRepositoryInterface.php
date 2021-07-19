<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    public function all(): array;

    public function search(Request $request): array;

    public function findById(int $id): array;

    public function random(): array;
}
