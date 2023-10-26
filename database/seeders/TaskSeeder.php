<?php

namespace Database\Seeders;

use App\Models\Priority;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Phase;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Task::factory()
            ->count(3)
            ->sequence(
                [
                    'name' => 'Try not to lose your lightsaber this time.',
                    'priority_id' => Priority::query()->whereName('Low')->first()->id,
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
                    'due_date' => Carbon::now()->format('Y-m-d'),

                ],
                [
                    'name' => 'Attend a rebel strategy meeting and avoid dozing off.',
                    'priority_id' => Priority::query()->whereName('Low')->first()->id,
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
                    'due_date' => Carbon::now()->format('Y-m-d'),
                ],
                [
                    'name' => 'Convince Yoda to give you a day off from Jedi training.',
                    'priority_id' => Priority::query()->whereName('Low')->first()->id,
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
                    'due_date' => Carbon::now()->format('Y-m-d'),
                ],
            )
            ->state(new Sequence(
                fn(Sequence $sequence) => [
                    'user_id' => User::whereName('John Doe')->first()->id,
                    'phase_id' => Phase::all()->random()
                ],
            ))
            ->create();

        \App\Models\Task::factory()
            ->count(3)
            ->sequence(
                [
                    'name' => 'Negotiate with potential allies without rolling your eyes.',
                    'priority_id' => Priority::query()->whereName('Low')->first()->id,
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
                    'due_date' => Carbon::now()->format('Y-m-d'),
                ],
                [
                    'name' => 'Brief Rebel spies without revealing your secret crush on Han.',
                    'priority_id' => Priority::query()->whereName('Low')->first()->id,
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
                    'due_date' => Carbon::now()->format('Y-m-d'),
                ],
                [
                    'name' => 'Try diplomacy with planets that still think Jar Jar is funny.',
                    'priority_id' => Priority::query()->whereName('Low')->first()->id,
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
                    'due_date' => Carbon::now()->format('Y-m-d'),
                ],
            )
            ->state(new Sequence(
                fn(Sequence $sequence) => [
                    'user_id' => User::whereName('Jane Smith')->first()->id,
                    'phase_id' => Phase::all()->random()
                ],
            ))
            ->create();

        \App\Models\Task::factory()
            ->count(3)
            ->sequence(
                [
                    'name' => 'Fix the Falcon\'s hyperdrive (again).',
                    'priority_id' => Priority::query()->whereName('Low')->first()->id,
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
                    'due_date' => Carbon::now()->format('Y-m-d'),
                ],
                [
                    'name' => 'Outsmart Imperial patrols while smuggling space \'stuff.\'',
                    'priority_id' => Priority::query()->whereName('Low')->first()->id,
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
                    'due_date' => Carbon::now()->format('Y-m-d'),
                ],
                [
                    'name' => 'Remind Chewie to lower the ship\'s thermostat – It\'s not Hoth in here!',
                    'priority_id' => Priority::query()->whereName('Low')->first()->id,
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
                    'due_date' => Carbon::now()->format('Y-m-d'),
                ],
            )
            ->state(new Sequence(
                fn(Sequence $sequence) => [
                    'user_id' => User::whereName('Alex Johnson')->first()->id,
                    'phase_id' => Phase::all()->random()
                ],
            ))
            ->create();

        \App\Models\Task::factory()
            ->count(3)
            ->sequence(
                [
                    'name' => 'Hunt Rebel spies and resist force-choking them.',
                    'priority_id' => Priority::query()->whereName('Low')->first()->id,
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
                    'due_date' => Carbon::now()->format('Y-m-d'),
                ],
                [
                    'name' => 'Attend a meeting with Palpatine without yawning audibly.',
                    'priority_id' => Priority::query()->whereName('Low')->first()->id,
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
                    'due_date' => Carbon::now()->format('Y-m-d'),
                ],
                [
                    'name' => 'Attend Sith sensitivity training session to work on your anger management.',
                    'priority_id' => Priority::query()->whereName('Low')->first()->id,
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
                    'due_date' => Carbon::now()->format('Y-m-d'),
                ],
            )
            ->state(new Sequence(
                fn(Sequence $sequence) => [
                    'user_id' => User::whereName('Emily Brown')->first()->id,
                    'phase_id' => Phase::all()->random()
                ],
            ))
            ->create();

        \App\Models\Task::factory()
            ->count(3)
            ->sequence(
                [
                    'name' => 'Keep the Falcon from falling apart mid-hyperspace jump.',
                    'priority_id' => Priority::query()->whereName('Low')->first()->id,
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
                    'due_date' => Carbon::now()->format('Y-m-d'),
                ],
                [
                    'name' => 'Help Han escape a bounty hunter ambush without roaring too much.',
                    'priority_id' => Priority::query()->whereName('Low')->first()->id,
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
                    'due_date' => Carbon::now()->format('Y-m-d'),
                ],
                [
                    'name' => 'Book Wookiee vocal lessons – surprise opera performance for Han.',
                    'priority_id' => Priority::query()->whereName('Low')->first()->id,
                    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
                    'due_date' => Carbon::now()->format('Y-m-d'),
                ],
            )
            ->state(new Sequence(
                fn(Sequence $sequence) => [
                    'user_id' => User::whereName('David Wilson')->first()->id,
                    'phase_id' => Phase::all()->random()
                ],
            ))
            ->create();
    }
}
