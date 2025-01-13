<?php
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'username' => $faker->username,
        'slug' => "admin",
        'first_name' => "Admin",
        'last_name' => "User",
        'email' => $faker->email,
        'phone' => '918876458',
        'password' => Illuminate\Support\Facades\Hash::make('password'),
        'status' => '1',
        'company' => 'Admin',
        'ip_address' => "127.0.0.1",
        'last_login_at' => \Carbon\Carbon::now()->toDateTimeString(),
    ];
});