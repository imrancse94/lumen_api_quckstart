<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Module;
use App\Models\Setting;
use App\Models\Submodule;
use App\Models\Company;
use App\Models\Page;
use App\Models\Role;
use App\Models\RolePage;
use App\Models\UserUsergroup;
use App\Models\Usergroup;
use App\Models\UsergroupRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class UsersTableDataSeeder extends Seeder {

    /**
     * Run the database seeds/
     *
     * @return void
     */
    public function run() {

        // Truncate DB
        DB::statement("SET foreign_key_checks=0");
        $databaseName = DB::getDatabaseName();
        $tables = DB::select("SELECT * FROM information_schema.tables WHERE table_schema = '$databaseName'");
        foreach ($tables as $table) {
            $name = $table->TABLE_NAME;
            //if you don't want to truncate migrations
            if ($name == 'migrations') {
                continue;
            }
            DB::table($name)->truncate();
        }
        DB::statement("SET foreign_key_checks=1");


        // Raw data insertion start from here/////

        $userTable[] = [
            'name' => "ssadmin",
            'company_id'=>1,
            'email' => "ssadmin@admin.com",
            'permission_version' => 0,
            'password' => app('hash')->make('123456'),
            'created_at'=>\Carbon\Carbon::now()
        ];
        $userTable[] = [
            'name' => "Imran Hossain",
            'company_id'=>2,
            'email' => "imrancse94@gmail.com",
            'permission_version' => 0,
            'password' => app('hash')->make('123456'),
            'created_at'=>\Carbon\Carbon::now()
        ];
        $modules = "INSERT INTO `modules` (`id`, `name`, `icon`, `sequence`, `created_at`, `updated_at`) VALUES
                    (1001, 'Company', '<i class=\"fa fa-list-ul\"></i>', 6, '2015-12-09 22:10:46', '2019-03-21 06:52:50'),
                    (1002, 'Master Data', '<i class=\"fa fa-list-ul\"></i>', 2, '2015-12-09 22:10:46', '2019-03-27 23:03:33'),
                    (1003, 'Access Control', '<i class=\"fa fa-list-ul\"></i>', 3, '2015-12-09 22:10:47', '2016-08-07 01:24:34'),
                    (1004, 'Configuration', '<i class=\"fa fa-list-ul\"></i>', 4, '2015-12-09 22:10:47', '2015-12-09 22:10:47');";



        $submoduleSql = "INSERT INTO `submodules` (`id`, `module_id`, `name`, `controller_name`, `icon`, `sequence`, `created_at`, `updated_at`, `default_method`) VALUES
                        (2001, 1001, 'Company Management', 'CompanyController', '<i class=\"fa  fa-angle-double-right\"></i>', 1, '2015-12-09 22:10:47', '2019-03-27 23:50:07', 'index'),
                        (2020, 1002, 'Module Management', 'ModuleController', '<i class=\"fa  fa-angle-double-right\"></i>', 1, '2015-12-09 22:10:48', '2015-12-09 22:10:48', 'index'),
                        (2021, 1002, 'Sub Module Management', 'SubModuleController', '<i class=\"fa  fa-angle-double-right\"></i>', 2, '2015-12-09 22:10:48', '2015-12-09 22:10:48', 'index'),
                        (2022, 1002, 'Page Management', 'PageController', '<i class=\"fa  fa-angle-double-right\"></i>', 3, '2015-12-09 22:10:48', '2015-12-09 22:10:48', 'index'),
                        (2050, 1003, 'User Management', 'UserController', '<i class=\"fa  fa-angle-double-right\"></i>', 1, '2015-12-09 22:10:49', '2015-12-09 22:10:49', 'index'),
                        (2051, 1003, 'Role Management', 'RoleController', '<i class=\"fa  fa-angle-double-right\"></i>', 2, '2015-12-09 22:10:49', '2015-12-24 00:35:45', 'index'),
                        (2052, 1003, 'User Group Management', 'UsergroupController', '<i class=\"fa  fa-angle-double-right\"></i>', 3, '2015-12-09 22:10:49', '2015-12-09 22:10:49', 'index'),
                        (2053, 1003, 'Group & Role Association', 'UsergroupRoleController', '<i class=\"fa  fa-angle-double-right\"></i>', 4, '2015-12-09 22:10:49', '2015-12-09 22:10:49', 'index'),
                        (2054, 1003, 'Role & Page Association', 'RolePageController', '<i class=\"fa  fa-angle-double-right\"></i>', 5, '2015-12-09 22:10:50', '2015-12-09 22:10:50', 'index'),
                        (2070, 1004, 'Site Settings', 'SettingController', '<i class=\"fa  fa-angle-double-right\"></i>', 1, '2015-12-09 22:10:50', '2015-12-09 22:10:50', 'index');";

        $companies = "INSERT INTO `companies` (`id`, `name`, `email`, `created_at`, `updated_at`) VALUES
                        (1, 'default', '','2015-11-04 10:52:01', '2015-11-04 10:52:01'),
                        (2, 'Imran Hossain','imrancse94@gmail.com','2019-03-28 00:47:10', '2019-03-28 00:47:10');";

        $pages = "INSERT INTO `pages` (`id`, `module_id`, `submodule_id`, `name`, `route_name`, `is_default_method`, `created_at`, `updated_at`) VALUES
                    (3001, 1001, 2001, 'Company List', '/company', 1, '2015-12-09 22:10:51', '2019-03-27 06:03:41'),
                    (3002, 1001, 2001, 'Add New Company', '/company/create', 0, '2015-12-09 22:10:52', '2015-12-09 22:10:52'),
                    (3003, 1001, 2001, 'Modify Company', '/company/edit', 0, '2015-12-09 22:10:52', '2015-12-09 22:10:52'),
                    (3004, 1001, 2001, 'Delete Company', '/company/destroy', 0, '2015-12-09 22:10:52', '2015-12-09 22:10:52'),
                    (3005, 1001, 2001, 'View Company', '/company/show', 0, '2015-12-09 22:10:52', '2015-12-09 22:10:52'),
                    (3015, 1002, 2020, 'Module List', '/module', 1, '2015-12-09 22:10:53', '2015-12-09 22:10:53'),
                    (3016, 1002, 2020, 'Add New Module', '/module/create', 0, '2015-12-09 22:10:53', '2015-12-09 22:10:53'),
                    (3017, 1002, 2020, 'Modify Module', '/module/edit', 0, '2015-12-09 22:10:53', '2015-12-09 22:10:53'),
                    (3018, 1002, 2020, 'Delete Module', '/module/destroy', 0, '2015-12-09 22:10:54', '2015-12-09 22:10:54'),
                    (3025, 1002, 2021, 'Submodule List', '/submodule', 1, '2015-12-09 22:10:54', '2015-12-09 22:10:54'),
                    (3026, 1002, 2021, 'Add New Submodule', '/submodule/create', 0, '2015-12-09 22:10:54', '2015-12-09 22:10:54'),
                    (3027, 1002, 2021, 'Modify Submodule', '/submodule/edit', 0, '2015-12-09 22:10:54', '2015-12-09 22:10:54'),
                    (3028, 1002, 2021, 'Delete Submodule', '/submodule/destroy', 0, '2015-12-09 22:10:55', '2015-12-09 22:10:55'),
                    (3035, 1002, 2022, 'Page List', '/page', 1, '2015-12-09 22:10:55', '2015-12-09 22:10:55'),
                    (3036, 1002, 2022, 'Add New Page', '/page/create', 0, '2015-12-09 22:10:55', '2016-01-21 20:44:25'),
                    (3037, 1002, 2022, 'Modify Page', '/page/edit', 0, '2015-12-09 22:10:56', '2015-12-09 22:10:56'),
                    (3038, 1002, 2022, 'Delete Page', '/page/destroy', 0, '2015-12-09 22:10:56', '2015-12-09 22:10:56'),
                    (3045, 1003, 2050, 'User List', '/user', 1, '2015-12-09 22:10:56', '2015-12-09 22:10:56'),
                    (3046, 1003, 2050, 'Add New User', '/user/create', 0, '2015-12-09 22:10:57', '2015-12-09 22:10:57'),
                    (3047, 1003, 2050, 'Modify User', '/user/edit', 0, '2015-12-09 22:10:57', '2015-12-09 22:10:57'),
                    (3048, 1003, 2050, 'Delete User', '/user/destroy', 0, '2015-12-09 22:10:57', '2015-12-09 22:10:57'),
                    (3049, 1003, 2050, 'View User', '/user/view', 0, '2015-11-23 09:13:47', '2015-11-23 09:13:47'),
                    (3055, 1003, 2051, 'Role List', '/role', 1, '2015-12-09 22:12:02', '2015-12-09 22:12:02'),
                    (3056, 1003, 2051, 'Add New Role', '/role/create', 0, '2015-12-09 22:12:02', '2015-12-09 22:12:02'),
                    (3057, 1003, 2051, 'Modify Role', '/role/edit', 0, '2015-12-09 22:12:03', '2015-12-09 22:12:03'),
                    (3058, 1003, 2051, 'Delete Role', '/role/destroy', 0, '2015-12-09 22:12:03', '2015-12-09 22:12:03'),
                    (3065, 1003, 2052, 'Usergroup List', '/usergroup', 1, '2015-12-09 22:12:03', '2015-12-09 22:12:03'),
                    (3066, 1003, 2052, 'Add New Usergroup', '/usergroup/create', 0, '2015-12-09 22:12:04', '2015-12-09 22:12:04'),
                    (3067, 1003, 2052, 'Modify Usergroup', '/usergroup/edit', 0, '2015-12-09 22:12:04', '2015-12-09 22:12:04'),
                    (3068, 1003, 2052, 'Delete Usergroup', '/usergroup/destroy', 0, '2015-12-09 22:12:04', '2015-12-09 22:12:04'),
                    (3075, 1003, 2053, 'Group & Role Association', '/usergrouprole', 1, '2015-12-09 22:12:05', '2015-12-09 22:12:05'),
                    (3078, 1003, 2054, 'Role & Page Association', '/rolepageassoc', 1, '2015-12-09 22:12:05', '2015-12-09 22:12:05'),
                    (3081, 1004, 2070, 'Site Settings', '/sitesettings', 1, '2015-12-09 22:12:05', '2015-12-09 22:12:05'),
                    (5977, 1001, 2001, 'Imran', '/imranmanageprice', 1, '2019-03-27 05:48:45', '2019-03-27 05:48:45'),
                    (3079, 1003, 2050, 'Get Auth token', '/getauthtoken-authCheck', 0, '2015-12-09 22:12:05', '2015-12-09 22:12:05');";
        //$pages = stripcslashes($pages);
        $roles = "INSERT INTO `roles` (`id`, `title`, `status`, `company_id`, `created_at`, `updated_at`) VALUES
                    (1, 'super-super-admin', 1, 1, '2019-03-28 07:37:17', '2019-03-28 01:37:17'),
                    (2, 'ADMIN_ROLE', 1, 2, '2019-03-28 00:47:11', '2019-03-28 00:47:11');";

        $role_pages = "INSERT INTO `role_pages` (`id`, `role_id`, `page_id`) VALUES
                        (1, 1, 3001),
                        (2, 1, 3002),
                        (3, 1, 3003),
                        (4, 1, 3004),
                        (5, 1, 3005),
                        (6, 1, 3015),
                        (7, 1, 3016),
                        (8, 1, 3017),
                        (9, 1, 3018),
                        (10, 1, 3025),
                        (11, 1, 3026),
                        (12, 1, 3027),
                        (13, 1, 3028),
                        (14, 1, 3035),
                        (15, 1, 3036),
                        (16, 1, 3037),
                        (17, 1, 3038),
                        (18, 1, 3081),
                        (211, 2, 3045),
                        (212, 2, 3046),
                        (213, 2, 3047),
                        (214, 2, 3048),
                        (215, 2, 3049),
                        (216, 2, 3055),
                        (217, 2, 3056),
                        (218, 2, 3057),
                        (219, 2, 3058),
                        (220, 2, 3065),
                        (221, 2, 3066),
                        (222, 2, 3067),
                        (223, 2, 3068),
                        (224, 2, 3075),
                        (225, 2, 3078),
                        (226, 2, 3081),
                        (227, 2, 3079);";

        $usergroups = "INSERT INTO `usergroups` (`id`, `name`, `status`, `company_id`, `created_at`, `updated_at`) VALUES
                        (1, 'super-super-admin-group', 1, 1, '2019-03-22 11:38:12', '2015-11-09 23:17:00'),
                        (2, 'ADMIN_USERGROUP', 1, 2, '2019-03-28 00:47:11', '2019-03-28 00:47:11');";

        $usergroupRole = "INSERT INTO `usergroup_roles` (`id`, `usergroup_id`, `role_id`, `company_id`) VALUES
                            (1, 1, 1, 1),
                            (2, 2, 2, 2);";

        $userUserGroup = "INSERT INTO `user_usergroups` (`id`, `usergroup_id`, `user_id`, `company_id`, `created_at`, `updated_at`) VALUES
                            (4, 2, 1, 2, '2019-03-28 00:47:11', '2019-03-28 00:47:11'),
                            (5, 1, 1, 2, '2019-03-28 02:56:23', '2019-03-28 02:56:23'),
                            (6, 1, 1, 2, '2019-03-28 03:12:13', '2019-03-28 03:12:13'),
                            (7, 1, 1, 2, '2019-03-28 03:13:20', '2019-03-28 03:13:20'),
                            (8, 2, 1, 2, '2019-03-30 03:11:57', '2019-03-30 03:11:57'),
                            (9, 2, 1, 2, '2019-03-30 03:13:42', '2019-03-30 03:13:42'),
                            (10, 2, 1, 2, '2019-03-30 05:39:26', '2019-03-30 05:39:26');";

        DB::insert($companies);
        User::insert($userTable);
        DB::insert($modules);
        DB::insert($submoduleSql);
        DB::insert($pages);
        DB::insert($roles);
        DB::insert($usergroups);
        DB::insert($usergroupRole);
        DB::insert($role_pages);
        DB::insert($userUserGroup);

    }




}
