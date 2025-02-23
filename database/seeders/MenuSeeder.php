<?php

namespace Database\Seeders;

use App\Models\Menu; // Correct import
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->datas() as $key => $value) {
            $this->createMenu($value);
        }
    }

    private function createMenu($data, $parent_id = null)
    {
        $menu = new Menu([
            'name' => $data['name'],
            'icon' => $data['icon'],
            'route' => $data['route'],
            'description' => $data['description'],
            'sorting' => $data['sorting'],
            'parent_id' => $parent_id,
            'permission_name' => $data['permission_name'],
            'status' => $data['status'],
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ]);

        $menu->save();

        if (isset($data['children']) && is_array($data['children'])) {
            foreach ($data['children'] as $child) {
                $this->createMenu($child, $menu->id);
            }
        }
    }

    private function datas()
    {
        return [
            [
                'name' => 'Dashboard',
                'icon' => 'home',
                'route' => 'backend.dashboard',
                'description' => null,
                'sorting' => 1,
                'permission_name' => 'dashboard',
                'status' => 'Active',
            ],
            [
                'name' => 'Module Make',
                'icon' => 'slack',
                'route' => 'backend.moduleMaker',
                'description' => null,
                'sorting' => 1,
                'permission_name' => 'module maker',
                'status' => 'Active',
            ],
            [
                'name' => 'User Manage',
                'icon' => 'user',
                'route' => null,
                'description' => null,
                'sorting' => 1,
                'permission_name' => 'user-management',
                'status' => 'Active',
                'children' => [
                    [
                        'name' => 'User Add',
                        'icon' => 'plus-circle',
                        'route' => 'backend.admin.create',
                        'description' => null,
                        'sorting' => 1,
                        'permission_name' => 'Admin-add',
                        'status' => 'Active',
                    ],
                    [
                        'name' => 'User List',
                        'icon' => 'list',
                        'route' => 'backend.admin.index',
                        'description' => null,
                        'sorting' => 1,
                        'permission_name' => 'Admin-list',
                        'status' => 'Active',
                    ],
                ],
            ],
            [
                'name' => 'Permission Manage',
                'icon' => 'unlock',
                'route' => null,
                'description' => null,
                'sorting' => 1,
                'permission_name' => 'permission-management',
                'status' => 'Active',
                'children' => [
                    [
                        'name' => 'Permission Add',
                        'icon' => 'plus-circle',
                        'route' => 'backend.permission.create',
                        'description' => null,
                        'sorting' => 1,
                        'permission_name' => 'permission-add',
                        'status' => 'Active',
                    ],
                    [
                        'name' => 'Permission List',
                        'icon' => 'list',
                        'route' => 'backend.permission.index',
                        'description' => null,
                        'sorting' => 1,
                        'permission_name' => 'permission-list',
                        'status' => 'Active',
                    ],
                ],
            ],
            [
                'name' => 'Role Manage',
                'icon' => 'layers',
                'route' => null,
                'description' => null,
                'sorting' => 1,
                'permission_name' => 'role-management',
                'status' => 'Active',
                'children' => [
                    [
                        'name' => 'Role Add',
                        'icon' => 'plus-circle',
                        'route' => 'backend.role.create',
                        'description' => null,
                        'sorting' => 1,
                        'permission_name' => 'role-add',
                        'status' => 'Active',
                    ],
                    [
                        'name' => 'Role List',
                        'icon' => 'list',
                        'route' => 'backend.role.index',
                        'description' => null,
                        'sorting' => 1,
                        'permission_name' => 'role-list',
                        'status' => 'Active',
                    ],
                ],
            ],
            [
                'name' => 'Department Management',
                'icon' => 'aperture',
                'route' => null,
                'description' => null,
                'sorting' => 6,
                'permission_name' => 'department-management',
                'status' => 'Active',
                'children' => [
                    [
                        'name' => 'Department',
                        'icon' => 'plus-circle',
                        'route' => 'backend.department.create',
                        'description' => null,
                        'sorting' => 1,
                        'permission_name' => 'department-add',
                        'status' => 'Active',
                    ],
                    [
                        'name' => 'Department List',
                        'icon' => 'list',
                        'route' => 'backend.department.index',
                        'description' => null,
                        'sorting' => 2,
                        'permission_name' => 'department-list',
                        'status' => 'Active',
                    ],
                ],
            ],
            [
                'name' => 'Designation Management',
                'icon' => 'aperture',
                'route' => null,
                'description' => null,
                'sorting' => 6,
                'permission_name' => 'designation-management',
                'status' => 'Active',
                'children' => [
                    [
                        'name' => 'Designation',
                        'icon' => 'plus-circle',
                        'route' => 'backend.designation.create',
                        'description' => null,
                        'sorting' => 1,
                        'permission_name' => 'designation-add',
                        'status' => 'Active',
                    ],
                    [
                        'name' => 'Designation List',
                        'icon' => 'list',
                        'route' => 'backend.designation.index',
                        'description' => null,
                        'sorting' => 2,
                        'permission_name' => 'designation-list',
                        'status' => 'Active',
                    ],
                ],
            ],


    //don't remove this comment from menu seeder
        ];
    }
}