<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        foreach ($this->datas() as $key => $value) {
            $this->createPermission($value);
        }
    }

    private function createPermission($data, $parent_id = null)
    {
        $permission = new Permission([
            'name' => $data['name'],
            'guard_name' => 'admin', // Assuming you have 'admin' guard
            'parent_id' => $parent_id,
            'created_at' => now(),
        ]);

        $permission->save();

        if (isset($data['children']) && is_array($data['children'])) {
            foreach ($data['children'] as $child) {
                $this->createPermission($child, $permission->id);
            }
        }
    }

    private function datas()
    {
        return [
            [
                'name' => 'dashboard',
            ],
            [
                'name' => 'permission-management',
                'children' => [
                    [
                        'name' => 'permission-add',
                        'children' => [
                            ['name' => 'permission-create']
                        ]
                    ],
                    [
                        'name' => 'permission-list',
                        'children' => [
                            ['name' => 'permission-edit'],
                            ['name' => 'permission-update'],
                            ['name' => 'permission-delete']
                        ]
                    ],
                ],
            ],
            [
                'name' => 'role-management',
                'children' => [
                    [
                        'name' => 'role-add',
                        'children' => [
                            ['name' => 'role-create']
                        ]
                    ],
                    [
                        'name' => 'role-list',
                        'children' => [
                            ['name' => 'role-edit'],
                            ['name' => 'role-update'],
                            ['name' => 'role-delete']
                        ]
                    ],
                ],
            ],
            [
                'name' => 'user-management',
                'children' => [
                    [
                        'name' => 'user-add',
                        'children' => [
                            ['name' => 'user-create']
                        ]
                    ],
                    [
                        'name' => 'user-list',
                        'children' => [
                            ['name' => 'user-status-change'],
                            ['name' => 'user-edit'],
                            ['name' => 'user-update'],
                            ['name' => 'user-delete']
                        ]
                    ],
                ],
            ],
        ];
    }
}
