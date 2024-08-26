<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Option;
use App\Models\Question;
use App\Models\Exam;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->command->warn(PHP_EOL . 'Creating Super Admin user...');
        $sadminUser = User::factory()->create([
            'email' => 'admin@example.com',
            'name'  =>  'Super Admin',
            'password' => bcrypt( 'admin123' ),
        ]);
        $this->command->info('Super Admin user created.');

        $this->command->warn(PHP_EOL . 'Creating some fake users...');
        $users = User::factory(19)->create();
        $this->command->info('Fake users created.');

        $this->command->warn(PHP_EOL . 'Creating New Role...');
        $sadminRole = Role::create(['name' => 'Superadmin']);
        $userRole = Role::create(['name' => 'User']);
        $this->command->info('Role created.');

        $this->command->warn(PHP_EOL . 'Assigning Roles...');
        $sadminUser->assignRole($sadminRole);
        foreach($users as $user){
            $user->assignRole($userRole);
        }
        $this->command->info('Role Assigned.');

        $this->command->warn(PHP_EOL . 'Adding some Exams...');
        $options = Option::factory(1)->create();
        $exam = Exam::factory(6)->hasAttached(Question::factory()->count(10)->hasAttached(Option::factory()->count(4)))->create();
        $questions = Question::all();
        foreach($questions as $question){
            $corrects = $question->options;
            foreach($corrects as $correct){
                $q = Question::find($question->id);
                $q->correct_option_id = $correct->id;    
                $q->save();
            }
        }
        $this->command->info('Exams created.');

    }
}
