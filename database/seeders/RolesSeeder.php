<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = \Otoszroto\Enums\Role::casesToSelect();

        foreach ($roles as $role) {
            Role::query()->firstOrCreate(["name" => $role["label"]]);
        }
    }
}
