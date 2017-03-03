<?php

namespace P3in\Seeders;

use Illuminate\Database\Seeder;
use P3in\Builders\FormBuilder;
use P3in\Models\StorageType;
use P3in\Models\Form;
use DB;

class DisksFormsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // @TODO: Form is part of CP, this module is loaded before CP so something to work out.
        // Form::whereIn('forms.name', ['LocalStorage', 'SftpStorage', 'FtpStorage', 'RackspaceStorage', 'S3Storage'])->delete();

        FormBuilder::new('LocalStorage', function (FormBuilder $fb) {
            $fb->string('Name', 'name')->validation(['required']);
            $fb->string('Path', 'root')->validation(['required']);
            $fb->string('Public URL', 'url')->validation(['required']);
        })->setOwner(StorageType::whereName('local')->first());

        FormBuilder::new('SftpStorage', function (FormBuilder $fb) {
            $fb->string('Name', 'name')->validation(['required']);
            $fb->string('Host', 'host')->validation(['required']);
            $fb->string('Port', 'port')->validation(['required']);
            $fb->string('Username', 'username')->validation(['required']);
            $fb->string('Password', 'password')->validation(['required_without:privateKey']);
            $fb->string('Private Key', 'privateKey')->validation(['required_without:password']);
            $fb->string('Path', 'root')->validation(['required']);
            $fb->string('Public URL', 'url')->validation(['required']);
            $fb->boolean('Directory Permissions', 'directoryPerm');
            $fb->string('Timeout', 'timeout');
        })->setOwner(StorageType::whereName('sftp')->first());

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
        })->setOwner(StorageType::whereName('ftp')->first());

        FormBuilder::new('RackspaceStorage', function (FormBuilder $fb) {
            $fb->string('Name', 'name')->validation(['required']);
            $fb->string('Username', 'username')->validation(['required']);
            $fb->string('Key', 'key')->validation(['required']);
            $fb->string('Container', 'container')->validation(['required']);
            $fb->string('Endpoint', 'endpoint')->validation(['required']);
            $fb->string('Region', 'region')->validation(['required']);
            $fb->string('Url Type', 'url_type')->validation(['required']);
        })->setOwner(StorageType::whereName('rackspace')->first());

        FormBuilder::new('S3Storage', function (FormBuilder $fb) {
            $fb->string('Name', 'name')->validation(['required']);
            $fb->string('Key', 'key')->validation(['required']);
            $fb->string('Secret', 'secret')->validation(['required']);
            $fb->string('Region', 'region')->validation(['required']);
            $fb->string('Bucket', 'bucket')->validation(['required']);
        })->setOwner(StorageType::whereName('s3')->first());

    }
}
