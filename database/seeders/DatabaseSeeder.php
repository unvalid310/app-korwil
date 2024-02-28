<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'dashboard']);

        Permission::create(['name' => 'view sekolah']);
        Permission::create(['name' => 'profil sekolah']);
        Permission::create(['name' => 'create sekolah']);
        Permission::create(['name' => 'update sekolah']);
        Permission::create(['name' => 'delete sekolah']);

        Permission::create(['name' => 'view operator']);
        Permission::create(['name' => 'update operator']);
        Permission::create(['name' => 'delete operator']);

        Permission::create(['name' => 'rekap absen']);
        Permission::create(['name' => 'rekap sarpras']);
        Permission::create(['name' => 'rekap siswa']);

        Permission::create(['name' => 'view absen harian']);
        Permission::create(['name' => 'view absen bulanan']);
        Permission::create(['name' => 'tambah absen']);
        Permission::create(['name' => 'update absen']);
        Permission::create(['name' => 'delete absen']);

        Permission::create(['name' => 'view sarpras']);
        Permission::create(['name' => 'tambah sarpras']);
        Permission::create(['name' => 'update sarpras']);
        Permission::create(['name' => 'delete sarpras']);

        Permission::create(['name' => 'view siswa']);
        Permission::create(['name' => 'tambah siswa']);
        Permission::create(['name' => 'update siswa']);
        Permission::create(['name' => 'delete siswa']);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('dashboard');

        $adminRole->givePermissionTo('view sekolah');
        $adminRole->givePermissionTo('create sekolah');
        $adminRole->givePermissionTo('update sekolah');
        $adminRole->givePermissionTo('delete sekolah');

        $adminRole->givePermissionTo('view operator');
        $adminRole->givePermissionTo('update operator');
        $adminRole->givePermissionTo('delete operator');

        $adminRole->givePermissionTo('rekap absen');
        $adminRole->givePermissionTo('rekap sarpras');
        $adminRole->givePermissionTo('rekap siswa');

        $operatorRole = Role::create(['name' => 'operator']);
        $operatorRole->givePermissionTo('profil sekolah');

        $operatorRole->givePermissionTo('view absen harian');
        $operatorRole->givePermissionTo('view absen bulanan');
        $operatorRole->givePermissionTo('tambah absen');
        $operatorRole->givePermissionTo('update absen');
        $operatorRole->givePermissionTo('delete absen');

        $operatorRole->givePermissionTo('view sarpras');
        $operatorRole->givePermissionTo('tambah sarpras');
        $operatorRole->givePermissionTo('update sarpras');
        $operatorRole->givePermissionTo('delete sarpras');

        $operatorRole->givePermissionTo('view siswa');
        $operatorRole->givePermissionTo('tambah siswa');
        $operatorRole->givePermissionTo('update siswa');
        $operatorRole->givePermissionTo('delete siswa');

        $user = User::factory()->create([
            "name" => "Jhon Doe",
            "email" => "jhondoe@gmail.com",
            'password' => bcrypt('12345678')
        ]);
        $user->assignRole($operatorRole);

        $user = User::factory()->create([
            'name' => 'Example admin user',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        $user->assignRole($adminRole);
    }
}
