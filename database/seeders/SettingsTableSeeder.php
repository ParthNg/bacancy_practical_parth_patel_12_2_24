<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::updateOrCreate(
            ['name' => 'app_name'],
            ['value' => 'Inventory System',
            'status' => 'active']
        );

        Setting::updateOrCreate(
            ['name' => 'email_username'],
            ['value' => 'parthpatel5510@gmail.com',
            'status' => 'active']
        );

        Setting::updateOrCreate(
            ['name' => 'email_password'],
            ['value' => 'cwvfnxuvicykamsm',
            'status' => 'active']
        );

        Setting::updateOrCreate(
            ['name' => 'email_host'],
            ['value' => 'smtp.gmail.com',
            'status' => 'active']
        );

        Setting::updateOrCreate(
            ['name' => 'email_port'],
            ['value' => '587',
            'status' => 'active']
        );

        Setting::updateOrCreate(
            ['name' => 'email_encryption'],
            ['value' => 'tls',
            'status' => 'active']
        );

        Setting::updateOrCreate(
            ['name' => 'email_from_address'],
            ['value' => 'parthpatel5510@gmail.com',
            'status' => 'active']
        );

        Setting::updateOrCreate(
            ['name' => 'email_from_name'],
            ['value' => 'Inventory System',
            'status' => 'active']
        );

        Setting::updateOrCreate(
            ['name' => 'short_quantity'],
            ['value' => '10',
            'status' => 'active'],
        );

        Setting::updateOrCreate(
            ['name' => 'days_before_notify_expiry'],
            ['value' => '20',
            'status' => 'active'],
        );


    }
}
