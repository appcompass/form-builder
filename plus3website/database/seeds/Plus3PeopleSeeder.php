<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use P3in\Models\Plus3Person;
use P3in\Models\User;


class Plus3PeopleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('TRUNCATE TABLE plus3_people RESTART IDENTITY CASCADE');
        DB::statement('TRUNCATE TABLE users RESTART IDENTITY CASCADE');
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
            'title' => 'Co-Founder & Client Relations',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'imene\'s Bio',
            'bio_summary' => '',
            'cover_photo' => '/assets/images/content/team_imene.jpg',
            'full_photo' => '/assets/images/content/team_imene_popup.jpg',
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
            'title' => 'Co-Founder & Development Lead',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'Jubair\'s Bio',
            'bio_summary' => '',
            'cover_photo' => '/assets/images/content/team_jubair.jpg',
            'full_photo' => '/assets/images/content/team_jubair.jpg',
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
            'bio_summary' => '',
            'cover_photo' => '/assets/images/content/team_aisha.jpg',
            'full_photo' => '/assets/images/content/team_aisha.jpg',
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
            'bio_summary' => '',
            'cover_photo' => '/assets/images/content/team_federico.jpg',
            'full_photo' => '/assets/images/content/team_federico.jpg',
            'instagram' => '',
            'twitter' => '',
            'facebook' => '',
            'linkedin' => '',
        ]))
            ->user()
            ->associate($federico)
            ->save();

        // Michael
        $michael = User::create([
            'first_name' => 'Michael',
            'last_name' => 'Farrell',
            'email' => 'michael@p3in.com',
            'phone' => '',

            'password' => 'd3velopment',
            'active' => true,
        ]);

        (new Plus3Person([
            'title' => 'Web Designer & Front-End Developer',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'Michael Farrell\'s Bio',
            'bio_summary' => '',
            'cover_photo' => '/assets/images/content/team_michael.jpg',
            'full_photo' => '/assets/images/content/team_michael.jpg',
            'instagram' => '',
            'twitter' => '',
            'facebook' => '',
            'linkedin' => '',
        ]))
            ->user()
            ->associate($michael)
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
            'bio_summary' => '',
            'cover_photo' => '/assets/images/content/team_lazarus.jpg',
            'full_photo' => '/assets/images/content/team_lazarus.jpg',
            'instagram' => '',
            'twitter' => '',
            'facebook' => '',
            'linkedin' => '',
        ]))
            ->user()
            ->associate($lazarus)
            ->save();

        // Justin
        $justin = User::create([
            'first_name' => 'Justin',
            'last_name' => 'Varberakis',
            'email' => 'justin@p3in.com',
            'phone' => '',

            'password' => 'd3velopment',
            'active' => true,
        ]);

        (new Plus3Person([
            'title' => 'Graphic & Web Designer',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'Justin\'s Bio',
            'bio_summary' => '',
            'cover_photo' => '/assets/images/content/team_justin.jpg',
            'full_photo' => '/assets/images/content/team_justin.jpg',
            'instagram' => '',
            'twitter' => '',
            'facebook' => '',
            'linkedin' => '',
        ]))
            ->user()
            ->associate($justin)
            ->save();

        // Mike Duffy
        $mike_duffy = User::create([
            'first_name' => 'Mike',
            'last_name' => 'Duffy',
            'email' => 'mike.duffy@p3in.com',
            'phone' => '',
            'password' => 'd3velopment',
            'active' => true,
        ]);

        (new Plus3Person([
            'title' => 'Web Developer',
            'meta_keywords' => 'words',
            'meta_description' => 'desc',
            'bio' => 'Michael Duffy\'s Bio',
            'bio_summary' => '',
            'cover_photo' => '/assets/images/content/team_duffy.jpg',
            'full_photo' => '/assets/images/content/team_duffy.jpg',
            'instagram' => '',
            'twitter' => '',
            'facebook' => '',
            'linkedin' => '',
        ]))
            ->user()
            ->associate($mike_duffy)
            ->save();

    }
}
