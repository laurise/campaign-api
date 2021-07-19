<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function all(): array
    {
        return json_decode(DB::connection('mysql2')
            ->table('users')
            ->get()
            ->toJson(), true);
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

        return json_decode($query->get()->toJson(), true);
    }

    public function findById(int $id): array
    {
        return json_decode(DB::connection('mysql2')
            ->table('users')
            ->where('id', $id)
            ->get()
            ->toJson(), true)[0] ?? [];
    }

    public function random(): array
    {
        return json_decode(DB::connection('mysql2')
            ->table('users')
            ->inRandomOrder()
            ->take(1)
            ->get()
            ->toJson(), true)[0] ?? [];
    }
}
