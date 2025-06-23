<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Marshall;
use App\Models\Inspector;
use App\Models\Client;
use App\Models\Establishment;
use App\Models\Application;
use App\Models\ApplicationStatus;
use App\Models\Schedule;
use App\Models\Fsic;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        DB::transaction(function () use ($faker) {
            // Create Users
            $users = [];
            $roles = ['Admin', 'Marshall', 'Inspector', 'Client', 'Chief'];

            // Create 10 users (2 per role)
            foreach ($roles as $role) {
                for ($i = 0; $i < 2; $i++) {
                    $users[] = User::create([
                        'email' => $faker->unique()->safeEmail,
                        'email_verified_at' => now(),
                        'password' => bcrypt('password123'),
                        'role' => $role,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // Create Marshalls
            $marshallUsers = array_filter($users, fn($user) => $user->role === 'Marshall');
            foreach ($marshallUsers as $user) {
                Marshall::create([
                    'first_name' => $faker->firstName,
                    'middle_name' => $faker->optional()->firstName,
                    'last_name' => $faker->lastName,
                    'extension_name' => $faker->optional(0.2)->suffix,
                    'contact_number' => $faker->unique(15)->phoneNumber,
                    'email' => $user->email,
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Create Inspectors
            $inspectorUsers = array_filter($users, fn($user) => $user->role === 'Inspector');
            foreach ($inspectorUsers as $user) {
                Inspector::create([
                    'first_name' => $faker->firstName,
                    'middle_name' => $faker->optional()->firstName,
                    'last_name' => $faker->lastName,
                    'extension_name' => $faker->optional(0.2)->suffix,
                    'contact_number' => $faker->unique(15)->phoneNumber,
                    'email' => $user->email,
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Create Clients
            $clientUsers = array_filter($users, fn($user) => $user->role === 'Client');
            $clients = [];
            foreach ($clientUsers as $user) {
                $clients[] = Client::create([
                    'first_name' => $faker->firstName,
                    'middle_name' => $faker->optional()->firstName,
                    'last_name' => $faker->lastName,
                    'extension_name' => $faker->optional(0.2)->suffix,
                    'contact_number' => $faker->unique(15)->phoneNumber,
                    'email' => $user->email,
                    'user_id' => $user->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Create Establishments
            $establishments = [];
            foreach ($clients as $client) {
                for ($i = 0; $i < 2; $i++) { // 2 establishments per client
                    $establishments[] = Establishment::create([
                        'name' => $faker->company,
                        'client_id' => $client->id,
                        'representative_name' => $faker->optional()->name,
                        'trade_name' => $faker->optional()->company,
                        'total_building_area' => $faker->numberBetween(100, 10000) . ' SQM',
                        'number_of_occupant' => $faker->numberBetween(1, 500),
                        'type_of_occupancy' => $faker->randomElement(['Residential', 'Commercial', 'Industrial']),
                        'type_of_building' => $faker->randomElement(['Concrete', 'Steel', 'Wood']),
                        'nature_of_business' => $faker->bs,
                        'BIN' => $faker->unique()->numerify('#####-#####'),
                        'TIN' => $faker->optional()->numerify('###-###-###-#####'),
                        'DTI' => $faker->unique()->numerify('########'),
                        'SEC' => $faker->optional()->numerify('PG-#########'),
                        'high_rise' => $faker->boolean(20),
                        'eminent_danger' => $faker->boolean(10),
                        'address_brgy' => $faker->streetName,
                        'address_ex' => $faker->optional()->streetAddress,
                        'location_latitude' => $faker->latitude,
                        'location_longitude' => $faker->longitude,
                        'email' => $faker->unique()->companyEmail,
                        'landline' => $faker->optional()->phoneNumber,
                        'contact_number' => $faker->unique(15)->phoneNumber,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            // // Create Applications
            // $applications = [];
            // $fsicTypes = ['New', 'Renewal']; // Replace with Application::FSIC_TYPE if defined
            // foreach ($establishments as $establishment) {
            //     $applications[] = Application::create([
            //         'application_number' => $faker->unique()->numerify('APP-#####'),
            //         'establishment_id' => $establishment->id,
            //         'fsic_type' => $faker->randomElement($fsicTypes),
            //         'application_date' => $faker->dateTimeThisYear,
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //     ]);
            // }

            // // Create Application Statuses
            // foreach ($applications as $application) {
            //     ApplicationStatus::create([
            //         'application_id' => $application->id,
            //         'status' => $faker->randomElement(['Pending', 'Approved', 'Rejected']),
            //         'remarks' => $faker->optional()->sentence,
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //     ]);
            // }

            // // Create Schedules
            // $inspectors = Inspector::all();
            // foreach ($applications as $application) {
            //     Schedule::create([
            //         'application_id' => $application->id,
            //         'inspector_id' => $inspectors->random()->id,
            //         'schedule_date' => $faker->dateTimeThisMonth,
            //         'status' => $faker->randomElement(['Ongoing', 'Completed']),
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //     ]);
            // }

            // // Create FSICs
            // $marshalls = Marshall::all();
            // foreach ($applications as $application) {
            //     Fsic::create([
            //         'fsic_no' => $faker->unique()->numerify('FSIC-#####'),
            //         'application_id' => $application->id,
            //         'issue_date' => $faker->dateTimeThisYear,
            //         'expiration_date' => $faker->dateTimeBetween('now', '+1 year'),
            //         'amount' => $faker->randomFloat(2, 1000, 10000),
            //         'or_number' => $faker->unique()->numerify('OR-#####'),
            //         'payment_date' => $faker->dateTimeThisYear,
            //         'inspector_id' => $inspectors->random()->id,
            //         'marshall_id' => $marshalls->random()->id,
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //     ]);
            // }
        });
    }
}
