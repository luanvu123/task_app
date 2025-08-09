<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('vi_VN');

        $users = [
            [
                'email' => 'sqflxquai24060507@vnetwork.io.vn',
                'password' => 'Di75W#Z50v',
                'department_id' => 1
            ],
            [
                'email' => 'bcildhadv24061923@vnetwork.io.vn',
                'password' => '$dN1G5FF2E',
                'department_id' => 2
            ],
            [
                'email' => 'ylgsixygl24052505@vnetwork.io.vn',
                'password' => 'Zo8vv59*86',
                'department_id' => 1
            ],
            [
                'email' => 'sidoqobih24052422@vnetwork.io.vn',
                'password' => '9Rv8CD#W2m',
                'department_id' => 2
            ],
            [
                'email' => 'hsuelmdpj24052417@vnetwork.io.vn',
                'password' => '29QA@l8SQ3',
                'department_id' => 1
            ],
            [
                'email' => 'ziomomrja24052501@vnetwork.io.vn',
                'password' => '88vX@9GDXR',
                'department_id' => 2
            ],
            [
                'email' => 'hztjvvhwi24052410@vnetwork.io.vn',
                'password' => 'Ca677#c215',
                'department_id' => 1
            ],
            [
                'email' => 'zfxcqkuvs24052505@vnetwork.io.vn',
                'password' => 'q80t74g#DB',
                'department_id' => 2
            ],
            [
                'email' => 'uyhaaipns24052506@vnetwork.io.vn',
                'password' => '3w#Lq7Kkt8',
                'department_id' => 1
            ],
            [
                'email' => 'spzcnfest24052809@vnetwork.io.vn',
                'password' => '736265dt*Y',
                'department_id' => 2
            ],
            [
                'email' => 'vbhjriwcq24052407@vnetwork.io.vn',
                'password' => 'mx67C$53J5',
                'department_id' => 1
            ]
        ];

        $positions = [
            'Nhân viên',
            'Trưởng phòng',
            'Phó phòng',
            'Giám đốc',
            'Phó giám đốc',
            'Kế toán',
            'Thư ký',
            'Chuyên viên',
            'Tư vấn viên',
            'Kỹ thuật viên'
        ];

        $genders = ['male', 'female'];
        $statuses = ['active', 'inactive'];
        $maritalStatuses = ['single', 'married', 'divorced', 'widowed'];
        $religions = ['Không', 'Phật giáo', 'Công giáo', 'Cao Đài', 'Hòa Hảo', 'Tin Lành'];
        $bankNames = ['Vietcombank', 'VietinBank', 'BIDV', 'Agribank', 'Techcombank', 'MB Bank', 'ACB', 'VPBank', 'Sacombank', 'HDBank'];

        foreach ($users as $index => $userData) {
            $gender = $faker->randomElement($genders);
            $firstName = $gender === 'male' ? $faker->firstNameMale : $faker->firstNameFemale;
            $lastName = $faker->lastName;
            $fullName = $lastName . ' ' . $firstName;

            $phone = '0' . $faker->randomElement(['3', '5', '7', '8', '9']) . $faker->numerify('#########');
            $dob = $faker->dateTimeBetween('-60 years', '-22 years')->format('Y-m-d');

            User::create([
                // Thông tin cơ bản
                'name' => $fullName,
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
                'phone' => $phone,
                'dob' => $dob,
                'address' => $faker->address,
                'description' => $faker->optional(0.7)->sentence(10),
                'image' => $faker->optional(0.3)->imageUrl(200, 200, 'people'),
                'position' => $faker->randomElement($positions),
                'gender' => $gender,
                'status' => $faker->randomElement($statuses),
                'department_id' => $userData['department_id'],

                // Thông tin mở rộng
                'nationality' => 'Việt Nam',
                'religion' => $faker->randomElement($religions),
                'marital_status' => $faker->randomElement($maritalStatuses),
                'passport_no' => $faker->optional(0.4)->regexify('[A-Z]{1}[0-9]{8}'),
                'emergency_contact' => '0' . $faker->randomElement(['3', '5', '7', '8', '9']) . $faker->numerify('#########'),
                'bank_name' => $faker->randomElement($bankNames),
                'account_no' => $faker->numerify('##########'),
                'ifsc_code' => $faker->optional(0.6)->regexify('[A-Z]{4}[0-9]{7}'),
                'pan_no' => $faker->optional(0.5)->regexify('[A-Z]{5}[0-9]{4}[A-Z]{1}'),
                'upi_id' => $faker->optional(0.3)->userName . '@' . strtolower($faker->randomElement($bankNames)),

                // Timestamps
                'email_verified_at' => $faker->optional(0.8)->dateTimeThisYear(),
                'created_at' => Carbon::now()->subDays($faker->numberBetween(0, 30)),
                'updated_at' => Carbon::now()
            ]);
        }

        $this->command->info('Created ' . count($users) . ' users successfully with full information!');
        $this->command->table(
            ['Email', 'Department ID', 'Name', 'Position', 'Status'],
            collect($users)->map(function($user, $index) use ($positions) {
                $name = User::where('email', $user['email'])->first()->name;
                $position = User::where('email', $user['email'])->first()->position;
                $status = User::where('email', $user['email'])->first()->status;
                return [
                    $user['email'],
                    $user['department_id'],
                    $name,
                    $position,
                    $status
                ];
            })->toArray()
        );
    }
}
