<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('ApplicationSettingsSeeder');
        $this->call('CitiesSeeder');
        $this->call('StatesSeeder');
        $this->call('CountriesSeeder');
        $this->call('DepartmentSeeder');
        $this->call('EffortTypeSeeder');
        $this->call('GeneralSettingsSeeder');
        $this->call('OfficeLocationsSeeder');
        $this->call('PermissionFunctionSeeder');
        $this->call('PermissionModulesSeeder');
        $this->call('PermissionModuleFunctionsSeeder');
        $this->call('PermissionRolesSeeder');
        $this->call('PermissionRoleModuleFunctionSeeder');
        $this->call('SettingSeeder');
        $this->call('UserSeeder');
        $this->call('UserCategorySeeder');
        $this->call('UserExtraSeeder');
        $this->call('WorkStatusSeeder');
        $this->call('ScreenshotSettingsSeeder');
    }
}
