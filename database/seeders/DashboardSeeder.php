<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Agent;
use App\Models\Vendor;
use App\Models\Branch;
use App\Models\VendorVisit;
use App\Models\Package;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DashboardSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $superadminRole = Role::firstOrCreate(['name' => 'superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $moderatorRole = Role::firstOrCreate(['name' => 'moderator']);

        // Create superadmin user
        $superadmin = User::firstOrCreate(
            ['email' => 'superadmin@goldenstation.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );
        $superadmin->assignRole($superadminRole);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@goldenstation.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole($adminRole);

        // Create moderator user
        $moderator = User::firstOrCreate(
            ['email' => 'moderator@goldenstation.com'],
            [
                'name' => 'Moderator User',
                'password' => Hash::make('password'),
            ]
        );
        $moderator->assignRole($moderatorRole);

        // // Create sample agents
        // $agents = [
        //     ['name' => 'Ahmed Ali', 'email' => 'ahmed.ali@example.com', 'phone' => '+966501234567'],
        //     ['name' => 'Sarah Mohammed', 'email' => 'sarah.m@example.com', 'phone' => '+966502345678'],
        //     ['name' => 'Omar Hassan', 'email' => 'omar.h@example.com', 'phone' => '+966503456789'],
        //     ['name' => 'Fatima Al-Zahra', 'email' => 'fatima.z@example.com', 'phone' => '+966504567890'],
        //     ['name' => 'Khalid Abdullah', 'email' => 'khalid.a@example.com', 'phone' => '+966505678901'],
        // ];

        // foreach ($agents as $agentData) {
        //     Agent::create([
        //         'name' => $agentData['name'],
        //         'email' => $agentData['email'],
        //         'phone' => $agentData['phone'],
        //         'password' => Hash::make('password'),
        //         'last_latitude' => 24.7136 + (rand(-10, 10) / 100),
        //         'last_longitude' => 46.6753 + (rand(-10, 10) / 100),
        //     ]);
        // }

        // // Create sample vendors
        // $vendors = [
        //     [
        //         'owner_name' => 'Abdullah Al-Rashid',
        //         'commercial_name' => 'Al-Noor Trading Company',
        //         'commercial_registration_number' => 'CR123456789',
        //         'mobile' => '+966501111111',
        //         'whatsapp' => '+966501111111',
        //         'email' => 'info@alnoor.com',
        //         'city' => 'Riyadh',
        //         'district' => 'Al-Olaya',
        //         'activity_type' => 'retail',
        //         'has_commercial_registration' => 'yes',
        //         'has_online_platform' => true,
        //     ],
        //     [
        //         'owner_name' => 'Mariam Al-Sayed',
        //         'commercial_name' => 'Golden Fashion House',
        //         'commercial_registration_number' => 'CR987654321',
        //         'mobile' => '+966502222222',
        //         'whatsapp' => '+966502222222',
        //         'email' => 'contact@goldenfashion.com',
        //         'city' => 'Jeddah',
        //         'district' => 'Al-Balad',
        //         'activity_type' => 'retail',
        //         'has_commercial_registration' => 'yes',
        //         'has_online_platform' => false,
        //     ],
        //     [
        //         'owner_name' => 'Hassan Al-Mansouri',
        //         'commercial_name' => 'Desert Spices & Herbs',
        //         'commercial_registration_number' => 'CR456789123',
        //         'mobile' => '+966503333333',
        //         'whatsapp' => '+966503333333',
        //         'email' => 'sales@desertspices.com',
        //         'city' => 'Dammam',
        //         'district' => 'Al-Khobar',
        //         'activity_type' => 'wholesale',
        //         'has_commercial_registration' => 'yes',
        //         'has_online_platform' => true,
        //     ],
        // ];

        // foreach ($vendors as $vendorData) {
        //     Vendor::create($vendorData);
        // }

        // // Create sample branches
        // $branches = [
        //     ['vendor_id' => 1, 'name' => 'Al-Noor Main Branch', 'mobile' => '+966501111111', 'city' => 'Riyadh', 'district' => 'Al-Olaya', 'agent_id' => 1],
        //     ['vendor_id' => 1, 'name' => 'Al-Noor North Branch', 'mobile' => '+966501111112', 'city' => 'Riyadh', 'district' => 'Al-Naseem', 'agent_id' => 2],
        //     ['vendor_id' => 2, 'name' => 'Golden Fashion Jeddah', 'mobile' => '+966502222222', 'city' => 'Jeddah', 'district' => 'Al-Balad', 'agent_id' => 3],
        //     ['vendor_id' => 3, 'name' => 'Desert Spices Dammam', 'mobile' => '+966503333333', 'city' => 'Dammam', 'district' => 'Al-Khobar', 'agent_id' => 4],
        //     ['vendor_id' => 3, 'name' => 'Desert Spices Riyadh', 'mobile' => '+966503333334', 'city' => 'Riyadh', 'district' => 'Al-Malaz', 'agent_id' => 5],
        // ];

        // foreach ($branches as $branchData) {
        //     Branch::create($branchData);
        // }

        // // Create sample packages
        // $packages = [
        //     ['name' => 'Basic Package', 'description' => 'Essential features for small businesses', 'price' => 299.00],
        //     ['name' => 'Premium Package', 'description' => 'Advanced features for growing businesses', 'price' => 599.00],
        //     ['name' => 'Enterprise Package', 'description' => 'Full features for large enterprises', 'price' => 999.00],
        // ];

        // foreach ($packages as $packageData) {
        //     Package::create($packageData);
        // }

        // // Create sample vendor visits
        // $visitStatuses = ['visited', 'closed', 'not_found', 'refused'];
        // $agents = Agent::all();
        // $branches = Branch::all();

        // for ($i = 0; $i < 50; $i++) {
        //     $visitDate = now()->subDays(rand(0, 30));
        //     $branch = $branches->random();
        //     VendorVisit::create([
        //         'agent_id' => $agents->random()->id,
        //         'branch_id' => $branch->id,
        //         'vendor_id' => $branch->vendor_id,
        //         'visit_date' => $visitDate,
        //         'visit_status' => $visitStatuses[array_rand($visitStatuses)],
        //         'notes' => 'Sample visit notes for demonstration purposes.',
        //         'created_at' => $visitDate,
        //         'updated_at' => $visitDate,
        //     ]);
        // }

        $this->command->info('Dashboard sample data created successfully!');
    }
}