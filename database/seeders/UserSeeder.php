<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      DB::table('users')->insert([
        [
            'nama' => 'Super Admin',
            'roles' => 'admin',
            'username' => 'superadmin',
            'email' => 'superadmin@mail.com',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
            'email_verified_at' => now(),
            'password' => Hash::make('admin123')
        ],
        [
          'nama' => 'Editor',
          'roles' => 'editor',
          'username' => 'editorweb',
          'email' => 'editorweb@mail.com',
          'email_verified_at' => now(),
          'created_at' => now(),
          'updated_at' => now(),
          'email_verified_at' => now(),
          'password' => Hash::make('editor123')
        ],
        [
          'nama' => 'Guru',
          'roles' => 'guru',
          'username' => 'tyara',
          'email' => 'tyara@gmail.com',
          'email_verified_at' => now(),
          'created_at' => now(),
          'updated_at' => now(),
          'email_verified_at' => now(),
          'password' => Hash::make('guru123')
        ]
    ]);
    }
}
