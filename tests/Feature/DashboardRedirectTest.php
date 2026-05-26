<?php

use App\Models\User;
use Spatie\Permission\Models\Role;

test('admin is redirected to admin dashboard', function () {
    Role::findOrCreate('ADMIN', 'web');
    $user = User::factory()->create();
    $user->assignRole('ADMIN');

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertRedirect(route('admin.dashboard'));
});

test('sdm is redirected to sdm pengajuan index', function () {
    Role::findOrCreate('SDM', 'web');
    $user = User::factory()->create();
    $user->assignRole('SDM');

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertRedirect(route('sdm.pengajuan.index'));
});

test('pegawai is redirected to pegawai perdin index', function () {
    Role::findOrCreate('PEGAWAI', 'web');
    $user = User::factory()->create();
    $user->assignRole('PEGAWAI');

    $response = $this->actingAs($user)->get('/dashboard');

    $response->assertRedirect(route('pegawai.perdin.index'));
});
