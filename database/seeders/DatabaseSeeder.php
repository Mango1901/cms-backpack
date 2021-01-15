<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Role::create([
           [
           "name"=>"Admin",
            "created_at"=>date("Y-m-d H:i:s"),
            "updated_at"=>date("Y-m-d H:i:s")
           ],
            [
                "name"=>"User",
                "created_at"=>date("Y-m-d H:i:s"),
                "updated_at"=>date("Y-m-d H:i:s")
            ],
            [
                "name"=>"Author",
                "created_at"=>date("Y-m-d H:i:s"),
                "updated_at"=>date("Y-m-d H:i:s")
            ]
        ]);
        Permission::create([
           [
               "name"=>"All Privileges",
               "created_at"=>date("Y-m-d H:i:s"),
               "updated_at"=>date("Y-m-d H:i:s")
           ],
            [
                "name"=>"show",
                "created_at"=>date("Y-m-d H:i:s"),
                "updated_at"=>date("Y-m-d H:i:s")
            ],
            [
                "name"=>"edit",
                "created_at"=>date("Y-m-d H:i:s"),
                "updated_at"=>date("Y-m-d H:i:s")
            ]

        ]);
        \DB::table("model_has_roles")->insert([
           [
               "role_id"=>1,
               "model_type"=>"App\Models\User",
               "model_id"=>1
           ],
            [
                "role_id"=>2,
                "model_type"=>"App\Models\User",
                "model_id"=>2
            ],
            [
                "role_id"=>3,
                "model_type"=>"App\Models\User",
                "model_id"=>3
            ],
        ]);
        User::create([
           [
             "name"=>"Nguyễn Thị Huyền",
             "email"=>"hieu.tuhai2001@gmail.com",
             "password"=>bcrypt("huyenbon")
           ],
            [
                "name"=>"Từ Hải Hiếu",
                "email"=>"huyenbon99@gmail.com",
                "password"=>bcrypt("huyenbon")
            ],
            [
                "name"=>"Jkai",
                "email"=>"deagleka1@gmail.com",
                "password"=>bcrypt("huyenbon")
            ]
        ]);
    }
}
