<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Label;

class LabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'bug',
                'description' => 'Indicates an unexpected problem or unintended behavior',
                ],
            [
                'name' => 'documentation',
                'description' => 'Indicates a need for improvements or additions to documentation',
                ],
            [
                'name' => 'duplicate',
                'description' => 'Indicates similar issues, pull requests, or discussions',
                ],
            [
                'name' => 'enhancement',
                'description' => 'Indicates new feature requests',
                ],
            [
                'name' => 'good first issue',
                'description' => 'Indicates a good issue for first-time contributors',
                ],
            [
                'name' => 'help wanted',
                'description' => 'Indicates that a maintainer wants help on an issue or pull request',
                ],
            [
                'name' => 'invalid',
                'description' => 'Indicates that an issue, pull request, or discussion is no longer relevant',
                ],
            [
                'name' => 'question',
                'description' => 'Indicates that an issue, pull request, or discussion needs more information',
                ],
            [
                'name' => 'wontfix',
                'description' => 'Indicates that work won`t continue on an issue, pull request, or discussion',
                ],
        ];

        foreach ($data as $value) {
            $label = new Label();
            $label->name = $value['name'];
            $label->description = $value['description'];
            $label->save();
        }
    }
}
