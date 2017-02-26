<?php

namespace P3in\Seeders;

use DB;
use Illuminate\Database\Seeder;
use P3in\Models\StorageConfig;
use P3in\Models\StorageType;

class DisksModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StorageType::whereIn('name', ['local', 'sftp', 'ftp', 'rackspace', 's3'])->delete();

        // set the default supported storage types and their forms.
        $local = StorageType::create(['name' => 'local', ]);
        $sftp = StorageType::create(['name' => 'sftp', ]);
        $ftp = StorageType::create(['name' => 'ftp', ]);
        $rackspace = StorageType::create(['name' => 'rackspace', ]);
        $s3 = StorageType::create(['name' => 's3', ]);

        $cp_root = (config('app.cp_root'));

        $local->createDrive('cp_root', ['driver' => 'local', 'root' => $cp_root, ]);
        $local->createDrive('cp_components', ['driver' => 'local', 'root' => $cp_root.'/src/components', ]);
        $local->createDrive('cp_layout_types', ['driver' => 'local', 'root' => $cp_root.'/src/components/LayoutTypes', ]);
        $local->createDrive('cp_form_fields', ['driver' => 'local', 'root' => $cp_root.'/src/components/FormBuilder', ]);

        // @NOTE form seeders moved to cp
    }
}
