<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        $hierarchy = [
            [
                'name' => 'abhijet',
                'children' => [
                    [
                        'name' => 'aibrito',
                        'children' => [
                            ['name' => 'bala'],
                            ['name' => 'sadashiv'],
                        ],
                    ],
                    [
                        'name' => 'sid',
                        'children' => [
                            [
                                'name' => 'raghven',
                                'children' => [
                                    [
                                        'name' => 'arvwind',
                                        'children' => [
                                            ['name' => 'david'],
                                        ],
                                    ],
                                    ['name' => 'anup'],
                                ],
                            ],
                            ['name' => 'manjiri'],
                        ],
                    ],
                    ['name' => 'vasim kudle'],
                ],
            ],
            [
                'name' => 'sanel',
                'children' => [
                    ['name' => 'mohit'],
                ],
            ],
            ['name' => 'kapil'],
            ['name' => 'adam'],
            [
                'name' => 'test user',
                'children' => [
                    [
                        'name' => 'testuser2',
                        'children' => [
                            ['name' => 'test user2'],
                        ],
                    ],
                ],
            ],
        ];

        // Create records based on the hierarchy
        $this->createHierarchy(null, $hierarchy);
    }

    // recursive function
    private function createHierarchy($parentId, $items) : void
    {
        foreach ($items as $item) {
            $member = Member::create([
                'name' => $item['name'],
                'parent_id' => $parentId,
            ]);

            if (isset($item['children']) && is_array($item['children'])) {
                $this->createHierarchy($member->id, $item['children']);
            }
        }
    }
}
