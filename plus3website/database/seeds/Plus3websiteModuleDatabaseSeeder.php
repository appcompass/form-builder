<?php

namespace P3in\Seeders;

use DB;
use Illuminate\Database\Seeder;
use P3in\Models\Plus3Person;
use P3in\Models\User;
use P3in\Models\ResourceBuilder;

class Plus3websiteModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement("TRUNCATE TABLE plus3_people RESTART IDENTITY CASCADE");
        DB::statement("TRUNCATE TABLE users RESTART IDENTITY CASCADE");

        // Imene
        $imene = User::create([
            'first_name' => 'Imene',
            'last_name' => 'Saidi',
            'email' => 'imene.saidi@p3in.com',
            'phone' => '617-470-6003',
            'password' => 'd3velopment',
            'active' => true,
        ]);

        (new Plus3Person([
            'title' => 'Co-Founder and CEO',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'imene\'s Bio',
            'instagram' => 'imenebsaidi',
            'twitter' => 'imenesaidi',
            'facebook' => 'Imene.Saidi',
            'linkedin' => 'imenesaidi',
        ]))
            ->user()
            ->associate($imene)
            ->save();

        // Jubair
        $jubair = User::create([
            'first_name' => 'Jubair',
            'last_name' => 'Saidi',
            'email' => 'jubair.saidi@p3in.com',
            'phone' => '617-755-7012',
            'password' => 'd3velopment',
            'active' => true,
        ]);

        (new Plus3Person([
            'title' => 'Co-Founder and CTO',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'Jubair\'s Bio',
            'instagram' => 'jubairsaidi',
            'twitter' => 'jubairsaidi',
            'facebook' => 'jubairsaidi',
            'linkedin' => 'jsaidi',
        ]))
            ->user()
            ->associate($jubair)
            ->save();

        // Aisha
        $aisha = User::create([
            'first_name' => 'Aisha',
            'last_name' => 'Saidi',
            'email' => 'aisha.saidi@p3in.com',
            'phone' => '',
            'password' => 'd3velopment',
            'active' => true,
        ]);

        (new Plus3Person([
            'title' => 'Information Architect',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'aisha\'s Bio',
            'instagram' => '',
            'twitter' => '',
            'facebook' => '',
            'linkedin' => '',
        ]))
            ->user()
            ->associate($aisha)
            ->save();

        // Federico
        $federico = User::create([
            'first_name' => 'Federico',
            'last_name' => 'Francescato',
            'email' => 'federico@p3in.com',
            'phone' => '',
            'password' => 'd3velopment',
            'active' => true,
        ]);

        (new Plus3Person([
            'title' => 'Application Developer',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'federico\'s Bio',
            'instagram' => '',
            'twitter' => '',
            'facebook' => '',
            'linkedin' => '',
        ]))
            ->user()
            ->associate($federico)
            ->save();


        // Lazarus
        $lazarus = User::create([
            'first_name' => 'Lazarus',
            'last_name' => 'Morrison',
            'email' => 'lazarus@p3in.com',
            'phone' => '',
            'password' => 'd3velopment',
            'active' => true,
        ]);

        (new Plus3Person([
            'title' => 'Web Developer',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'lazarus\'s Bio',
            'instagram' => '',
            'twitter' => '',
            'facebook' => '',
            'linkedin' => '',
        ]))
            ->user()
            ->associate($lazarus)
            ->save();
    }
}
