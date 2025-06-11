<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('ApplicationSettingsSeeder');
        $this->call('AssetTypeSeeder');
        $this->call('CitiesSeeder');
        $this->call('StatesSeeder');
        $this->call('AttendancesSeeder');
        $this->call('ClientSeeder');
        $this->call('CountriesSeeder');
        $this->call('DepartmentSeeder');
        $this->call('EcommPagesSeeder');
        $this->call('EffortTypeSeeder');
        $this->call('GeneralSettingsSeeder');
        $this->call('OfficeLocationsSeeder');
        $this->call('PermissionFunctionSeeder');
        $this->call('PermissionModulesSeeder');
        $this->call('PermissionModuleFunctionsSeeder');
        $this->call('PermissionRolesSeeder');
        $this->call('PermissionRoleModuleFunctionSeeder');
        $this->call('ProjectSeeder');
        $this->call('ProjectCostSeeder');
        $this->call('ProjectStatusSeeder');
        $this->call('SettingSeeder');
        $this->call('TeamSeeder');
        $this->call('UserSeeder');
        $this->call('UserCategorySeeder');
        $this->call('UserExtraSeeder');
        $this->call('WorkStatusSeeder');
    }
}
