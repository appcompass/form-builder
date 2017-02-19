<?php

namespace P3in\Seeders;

use DB;
use Illuminate\Database\Seeder;
use P3in\Builders\FormBuilder;
use P3in\Models\StorageConfig;
use P3in\Models\StorageType;
use P3in\Models\Form;

class CpStoragesSeeder extends Seeder
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
        $local = StorageType::create([
            'name' => 'local',
        ]);

        $sftp = StorageType::create([
            'name' => 'sftp',
        ]);

        $ftp = StorageType::create([
            'name' => 'ftp',
        ]);

        $rackspace = StorageType::create([
            'name' => 'rackspace',
        ]);

        $s3 = StorageType::create([
            'name' => 's3',
        ]);

        $cp_root = (config('app.cp_root'));

        $local->createDrive('cp_root', [
            'driver' => 'local',
            'root' => $cp_root,
        ]);
        $local->createDrive('cp_components', [
            'driver' => 'local',
            'root' => $cp_root.'/src/components',
        ]);
        $local->createDrive('cp_layout_types', [
            'driver' => 'local',
            'root' => $cp_root.'/src/components/LayoutTypes',
        ]);
        $local->createDrive('cp_form_fields', [
            'driver' => 'local',
            'root' => $cp_root.'/src/components/FormBuilder',
        ]);

        Form::whereIn('forms.name', ['LocalStorage', 'SftpStorage', 'FtpStorage', 'RackspaceStorage', 'S3Storage'])->delete();

        FormBuilder::new('LocalStorage', function (FormBuilder $fb) {
            $fb->string('Name', 'name')->validation(['required']);
            $fb->string('Path', 'root')->validation(['required']);
        })->setOwner($local);

        FormBuilder::new('SftpStorage', function (FormBuilder $fb) {
            $fb->string('Name', 'name')->validation(['required']);
            $fb->string('Host', 'host')->validation(['required']);
            $fb->string('Port', 'port')->validation(['required']);
            $fb->string('Username', 'username')->validation(['required']);
            $fb->string('Password', 'password')->validation(['required_without:privateKey']);
            $fb->string('Private Key', 'privateKey')->validation(['required_without:password']);
            $fb->string('Path', 'root')->validation(['required']);
            $fb->boolean('Directory Permissions', 'directoryPerm');
            $fb->string('Timeout', 'timeout');
        })->setOwner($sftp);

        FormBuilder::new('FtpStorage', function (FormBuilder $fb) {
            $fb->string('Name', 'name')->validation(['required']);
            $fb->string('Host', 'host')->validation(['required']);
            $fb->string('Port', 'port');
            $fb->string('Username', 'username')->validation(['required']);
            $fb->string('Password', 'password')->validation(['required']);
            $fb->string('Path', 'root')->validation(['required']);
            $fb->boolean('Passive', 'passive');
            $fb->boolean('SSL', 'ssl');
            $fb->string('Timeout', 'timeout');
        })->setOwner($ftp);

        FormBuilder::new('RackspaceStorage', function (FormBuilder $fb) {
            $fb->string('Name', 'name')->validation(['required']);
            $fb->string('Username', 'username')->validation(['required']);
            $fb->string('Key', 'key')->validation(['required']);
            $fb->string('Container', 'container')->validation(['required']);
            $fb->string('Endpoint', 'endpoint')->validation(['required']);
            $fb->string('Region', 'region')->validation(['required']);
            $fb->string('Url Type', 'url_type')->validation(['required']);
        })->setOwner($rackspace);

        FormBuilder::new('S3Storage', function (FormBuilder $fb) {
            $fb->string('Name', 'name')->validation(['required']);
            $fb->string('Key', 'key')->validation(['required']);
            $fb->string('Secret', 'secret')->validation(['required']);
            $fb->string('Region', 'region')->validation(['required']);
            $fb->string('Bucket', 'bucket')->validation(['required']);
        })->setOwner($s3);
    }
}
