<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `roles` ( `name`, `slug`,`guard_name`, `created_at`, `updated_at`) VALUES
        ('admin','admin','web', now(), now()),
        ('client','client','web', now(), now())");

        DB::insert("INSERT INTO `users_roles` ( `user_id`, `role_id`) VALUES (1,1)");
    }
}
