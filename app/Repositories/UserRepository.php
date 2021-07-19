<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function all(): array
    {
        return DB::connection('mysql2')
            ->table('users')
            ->get()
            ->toArray();
    }

    public function search(Request $request): array
    {
        $query = DB::connection('mysql2')
            ->table('users');

        if ($email = $request->get('email')) {
            $query->where('email', $email);
        }

        if ($name = $request->get('name')) {
            $query->where('name', 'LIKE', "%{$name}%");
        }

        return $query
            ->get()
            ->toArray();
    }

    public function findById(int $id): ?object
    {
        return DB::connection('mysql2')
            ->table('users')
            ->where('id', $id)
            ->first();
    }
}
