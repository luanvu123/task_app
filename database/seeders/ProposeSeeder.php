<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Propose;
use App\Models\ProposeItem;
use App\Models\Project;
use App\Models\Department;
use App\Models\User;
use App\Models\Vendor;
use App\Models\ItemCategory;
use Illuminate\Support\Facades\DB;

class ProposeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have required data
        $this->ensureRequiredData();

        DB::transaction(function () {
            // Create sample proposes
            $this->createSampleProposes();
        });
    }

    /**
     * Ensure required data exists
     */
    private function ensureRequiredData(): void
    {
        // Create sample departments if they don't exist
        if (Department::count() === 0) {
            Department::create(['name' => 'IT Department', 'code' => 'IT']);
            Department::create(['name' => 'HR Department', 'code' => 'HR']);
            Department::create(['name' => 'Finance Department', 'code' => 'FIN']);
            Department::create(['name' => 'Operations', 'code' => 'OPS']);
        }

        // Create sample projects if they don't exist
        if (Project::count() === 0) {
            Project::create([
                'name' => 'Digital Transformation Project',
                'code' => 'DTP-2024',
                'description' => 'Company-wide digital transformation initiative'
            ]);
            Project::create([
                'name' => 'Office Renovation',
                'code' => 'OR-2024',
                'description' => 'Renovation of main office building'
            ]);
            Project::create([
                'name' => 'System Upgrade',
                'code' => 'SU-2024',
                'description' => 'IT infrastructure upgrade'
            ]);
        }

        // Create sample users if they don't exist
        if (User::count() === 0) {
            User::create([
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => bcrypt('password'),
                'department_id' => Department::first()->id
            ]);
            User::create([
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => bcrypt('password'),
                'department_id' => Department::skip(1)->first()->id
            ]);
            User::create([
                'name' => 'Mike Johnson',
                'email' => 'mike@example.com',
                'password' => bcrypt('password'),
                'department_id' => Department::skip(2)->first()->id
            ]);
        }

        // Create sample vendors if they don't exist
        if (Vendor::count() === 0) {
            Vendor::create([
                'name' => 'TechCorp Solutions',
                'contact_person' => 'David Wilson',
                'email' => 'contact@techcorp.com',
                'phone' => '0123456789',
                'address' => '123 Tech Street, Ho Chi Minh City',
                'tax_code' => '0123456789',
                'status' => 'active',
                'specialties' => ['IT Equipment', 'Software', 'Hardware'],
                'rating' => 4.5
            ]);

            Vendor::create([
                'name' => 'Office Supply Co',
                'contact_person' => 'Sarah Brown',
                'email' => 'sales@officesupply.com',
                'phone' => '0987654321',
                'address' => '456 Supply Avenue, Ho Chi Minh City',
                'tax_code' => '0987654321',
                'status' => 'active',
                'specialties' => ['Office Supplies', 'Furniture', 'Stationery'],
                'rating' => 4.2
            ]);

            Vendor::create([
                'name' => 'Construction Materials Ltd',
                'contact_person' => 'Tom Anderson',
                'email' => 'info@constructionmat.com',
                'phone' => '0555666777',
                'address' => '789 Build Road, Ho Chi Minh City',
                'tax_code' => '0555666777',
                'status' => 'active',
                'specialties' => ['Construction', 'Materials', 'Tools'],
                'rating' => 4.0
            ]);
        }

        // Create sample item categories if they don't exist
        if (ItemCategory::count() === 0) {
            $itCategory = ItemCategory::create([
                'name' => 'IT Equipment',
                'code' => 'IT',
                'description' => 'Information Technology Equipment',
                'is_active' => true
            ]);

            ItemCategory::create([
                'name' => 'Laptops',
                'code' => 'IT-LAP',
                'description' => 'Laptop computers',
                'parent_id' => $itCategory->id,
                'is_active' => true
            ]);

            ItemCategory::create([
                'name' => 'Servers',
                'code' => 'IT-SRV',
                'description' => 'Server hardware',
                'parent_id' => $itCategory->id,
                'is_active' => true
            ]);

            $officeCategory = ItemCategory::create([
                'name' => 'Office Supplies',
                'code' => 'OFF',
                'description' => 'Office supplies and furniture',
                'is_active' => true
            ]);

            ItemCategory::create([
                'name' => 'Furniture',
                'code' => 'OFF-FUR',
                'description' => 'Office furniture',
                'parent_id' => $officeCategory->id,
                'is_active' => true
            ]);

            ItemCategory::create([
                'name' => 'Stationery',
                'code' => 'OFF-STA',
                'description' => 'Office stationery items',
                'parent_id' => $officeCategory->id,
                'is_active' => true
            ]);
        }
    }

    /**
     * Create sample proposes with items
     */
    private function createSampleProposes(): void
    {
        $users = User::all();
        $projects = Project::all();
        $departments = Department::all();
        $vendors = Vendor::all();
        $categories = ItemCategory::whereNotNull('parent_id')->get(); // Only child categories

        // Sample propose 1: IT Equipment for Digital Transformation
        $propose1 = Propose::create([
            'project_id' => $projects->where('code', 'DTP-2024')->first()->id,
            'proposed_by' => $users->first()->id,
            'department_id' => $departments->where('code', 'IT')->first()->id,
            'title' => 'IT Equipment Upgrade for Digital Transformation',
            'description' => 'Purchase of new laptops, servers, and network equipment to support the digital transformation initiative.',
            'justification' => 'Current equipment is outdated and cannot support new digital workflows. Upgrade is critical for project success.',
            'expected_benefit' => 'Improved productivity, faster processing times, better system reliability.',
            'propose_type' => Propose::TYPE_EQUIPMENT,
            'priority' => Propose::PRIORITY_HIGH,
            'is_urgent' => true,
            'needed_by_date' => now()->addDays(30),
            'budget_source' => 'project_budget',
            'vendor_id' => $vendors->where('name', 'TechCorp Solutions')->first()->id,
            'expected_delivery_date' => now()->addDays(45),
            'status' => Propose::STATUS_APPROVED,
            'reviewed_by' => $users->skip(1)->first()->id,
            'reviewed_at' => now()->subDays(5),
            'review_comments' => 'Equipment specifications approved. Proceed with procurement.',
            'approved_by' => $users->skip(2)->first()->id,
            'approved_at' => now()->subDays(2),
            'approved_amount' => 245000000, // Will be calculated
            'approval_comments' => 'Approved for full amount. Critical for project timeline.'
        ]);

        // Items for propose 1
        $laptopCategory = $categories->where('code', 'IT-LAP')->first();
        $serverCategory = $categories->where('code', 'IT-SRV')->first();

        ProposeItem::create([
            'propose_id' => $propose1->id,
            'name' => 'Dell Latitude 7420 Business Laptop',
            'description' => 'Intel Core i7, 16GB RAM, 512GB SSD, 14" FHD Display',
            'specifications' => 'Intel Core i7-1165G7, 16GB DDR4, 512GB NVMe SSD, Windows 11 Pro',
            'brand' => 'Dell',
            'model' => 'Latitude 7420',
            'category_id' => $laptopCategory?->id,
            'unit' => 'chiếc',
            'quantity' => 15,
            'unit_price' => 28000000,
            'discount_percent' => 5,
            'tax_percent' => 10,
            'priority' => 'high',
            'is_essential' => true,
            'needed_by_date' => now()->addDays(30),
            'quality_requirements' => 'Business grade laptop with minimum 3-year warranty',
            'warranty_period' => '3 years',
            'approval_status' => ProposeItem::APPROVAL_STATUS_APPROVED,
            'procurement_status' => ProposeItem::PROCUREMENT_ORDER_PLACED,
            'preferred_vendor_id' => $vendors->where('name', 'TechCorp Solutions')->first()->id
        ]);

        ProposeItem::create([
            'propose_id' => $propose1->id,
            'name' => 'HPE ProLiant DL380 Gen10 Server',
            'description' => 'Rack server with dual processors, 64GB RAM, redundant power supplies',
            'specifications' => 'Intel Xeon Silver 4208, 64GB DDR4 ECC, 2x 1TB SSD, Redundant PSU',
            'brand' => 'HPE',
            'model' => 'ProLiant DL380 Gen10',
            'category_id' => $serverCategory?->id,
            'unit' => 'chiếc',
            'quantity' => 2,
            'unit_price' => 85000000,
            'discount_percent' => 8,
            'tax_percent' => 10,
            'priority' => 'critical',
            'is_essential' => true,
            'needed_by_date' => now()->addDays(35),
            'quality_requirements' => 'Enterprise grade server with 24/7 support',
            'warranty_period' => '5 years',
            'approval_status' => ProposeItem::APPROVAL_STATUS_APPROVED,
            'procurement_status' => ProposeItem::PROCUREMENT_QUOTATION_RECEIVED,
            'preferred_vendor_id' => $vendors->where('name', 'TechCorp Solutions')->first()->id
        ]);

        // Sample propose 2: Office Renovation Supplies
        $propose2 = Propose::create([
            'project_id' => $projects->where('code', 'OR-2024')->first()->id,
            'proposed_by' => $users->skip(1)->first()->id,
            'department_id' => $departments->where('code', 'OPS')->first()->id,
            'title' => 'Office Furniture and Supplies for Renovation',
            'description' => 'Purchase of new desks, chairs, and office supplies for the office renovation project.',
            'justification' => 'Current furniture is worn out and does not match the new office design standards.',
            'expected_benefit' => 'Improved employee comfort, modern workspace, better productivity.',
            'propose_type' => Propose::TYPE_SUPPLIES,
            'priority' => Propose::PRIORITY_MEDIUM,
            'is_urgent' => false,
            'needed_by_date' => now()->addDays(60),
            'budget_source' => 'project_budget',
            'vendor_id' => $vendors->where('name', 'Office Supply Co')->first()->id,
            'expected_delivery_date' => now()->addDays(75),
            'status' => Propose::STATUS_PENDING_APPROVAL,
            'reviewed_by' => $users->skip(2)->first()->id,
            'reviewed_at' => now()->subDays(1),
            'review_comments' => 'Specifications look good. Recommended for approval.'
        ]);

        // Items for propose 2
        $furnitureCategory = $categories->where('code', 'OFF-FUR')->first();

        ProposeItem::create([
            'propose_id' => $propose2->id,
            'name' => 'Ergonomic Office Desk',
            'description' => 'Height adjustable desk with cable management',
            'specifications' => '160cm x 80cm, Electric height adjustment 70-120cm, Oak veneer top',
            'brand' => 'IKEA',
            'model' => 'BEKANT',
            'category_id' => $furnitureCategory?->id,
            'unit' => 'chiếc',
            'quantity' => 25,
            'unit_price' => 8500000,
            'discount_percent' => 10,
            'tax_percent' => 10,
            'priority' => 'medium',
            'is_essential' => true,
            'needed_by_date' => now()->addDays(60),
            'quality_requirements' => 'Ergonomic design, height adjustable',
            'warranty_period' => '2 years',
            'approval_status' => ProposeItem::APPROVAL_STATUS_PENDING,
            'procurement_status' => ProposeItem::PROCUREMENT_NOT_STARTED,
            'preferred_vendor_id' => $vendors->where('name', 'Office Supply Co')->first()->id
        ]);

        ProposeItem::create([
            'propose_id' => $propose2->id,
            'name' => 'Ergonomic Office Chair',
            'description' => 'High-back office chair with lumbar support',
            'specifications' => 'Mesh back, adjustable armrests, 5-point base with casters',
            'brand' => 'Herman Miller',
            'model' => 'Aeron',
            'category_id' => $furnitureCategory?->id,
            'unit' => 'chiếc',
            'quantity' => 25,
            'unit_price' => 15000000,
            'discount_percent' => 5,
            'tax_percent' => 10,
            'priority' => 'high',
            'is_essential' => true,
            'needed_by_date' => now()->addDays(60),
            'quality_requirements' => 'Ergonomic, breathable mesh, adjustable',
            'warranty_period' => '12 years',
            'approval_status' => ProposeItem::APPROVAL_STATUS_PENDING,
            'procurement_status' => ProposeItem::PROCUREMENT_NOT_STARTED,
            'preferred_vendor_id' => $vendors->where('name', 'Office Supply Co')->first()->id
        ]);

        // Sample propose 3: Software Licenses
        $propose3 = Propose::create([
            'project_id' => $projects->where('code', 'SU-2024')->first()->id,
            'proposed_by' => $users->first()->id,
            'department_id' => $departments->where('code', 'IT')->first()->id,
            'title' => 'Software Licenses for System Upgrade',
            'description' => 'Purchase of software licenses required for the system upgrade project.',
            'justification' => 'New software licenses are required to support upgraded hardware and new functionality.',
            'expected_benefit' => 'Enhanced security, better performance, compliance with latest standards.',
            'propose_type' => Propose::TYPE_SOFTWARE,
            'priority' => Propose::PRIORITY_HIGH,
            'is_urgent' => false,
            'needed_by_date' => now()->addDays(45),
            'budget_source' => 'department_budget',
            'expected_delivery_date' => now()->addDays(7), // Software delivery is fast
            'status' => Propose::STATUS_DRAFT
        ]);

        ProposeItem::create([
            'propose_id' => $propose3->id,
            'name' => 'Microsoft Office 365 Business Premium',
            'description' => 'Cloud-based office suite with advanced collaboration tools',
            'specifications' => 'Word, Excel, PowerPoint, Outlook, Teams, SharePoint, OneDrive',
            'brand' => 'Microsoft',
            'model' => 'Office 365 Business Premium',
            'unit' => 'license/năm',
            'quantity' => 50,
            'unit_price' => 2640000, // ~$110/year
            'discount_percent' => 15,
            'tax_percent' => 10,
            'priority' => 'high',
            'is_essential' => true,
            'needed_by_date' => now()->addDays(45),
            'quality_requirements' => 'Latest version with full feature access',
            'warranty_period' => '1 year support included',
            'approval_status' => ProposeItem::APPROVAL_STATUS_PENDING,
            'procurement_status' => ProposeItem::PROCUREMENT_NOT_STARTED
        ]);

        ProposeItem::create([
            'propose_id' => $propose3->id,
            'name' => 'VMware vSphere Standard',
            'description' => 'Virtualization platform for server consolidation',
            'specifications' => 'vSphere Standard edition with vCenter Server',
            'brand' => 'VMware',
            'model' => 'vSphere Standard',
            'unit' => 'license',
            'quantity' => 4,
            'unit_price' => 35000000,
            'discount_percent' => 0,
            'tax_percent' => 10,
            'priority' => 'critical',
            'is_essential' => true,
            'needed_by_date' => now()->addDays(45),
            'quality_requirements' => 'Standard edition with HA and vMotion',
            'warranty_period' => '1 year support',
            'approval_status' => ProposeItem::APPROVAL_STATUS_PENDING,
            'procurement_status' => ProposeItem::PROCUREMENT_NOT_STARTED
        ]);

        // Sample propose 4: Training Services (Rejected example)
        $propose4 = Propose::create([
            'project_id' => $projects->first()->id,
            'proposed_by' => $users->skip(1)->first()->id,
            'department_id' => $departments->where('code', 'HR')->first()->id,
            'title' => 'Advanced Leadership Training Program',
            'description' => 'Executive leadership training for senior management team.',
            'justification' => 'Leadership skills enhancement to drive digital transformation.',
            'expected_benefit' => 'Improved leadership capabilities, better change management.',
            'propose_type' => Propose::TYPE_TRAINING,
            'priority' => Propose::PRIORITY_LOW,
            'is_urgent' => false,
            'needed_by_date' => now()->addDays(90),
            'budget_source' => 'department_budget',
            'status' => Propose::STATUS_REJECTED,
            'reviewed_by' => $users->skip(2)->first()->id,
            'reviewed_at' => now()->subDays(7),
            'review_comments' => 'Budget constraints this quarter.',
            'approved_by' => $users->skip(2)->first()->id,
            'approved_at' => now()->subDays(5),
            'approved_amount' => 0,
            'approval_comments' => 'Rejected due to budget limitations. Reconsider next quarter.'
        ]);

        ProposeItem::create([
            'propose_id' => $propose4->id,
            'name' => 'Executive Leadership Workshop',
            'description' => '3-day intensive leadership development program',
            'specifications' => 'On-site training for 10 participants, materials included',
            'unit' => 'khóa học',
            'quantity' => 1,
            'unit_price' => 75000000,
            'discount_percent' => 0,
            'tax_percent' => 10,
            'priority' => 'low',
            'is_essential' => false,
            'needed_by_date' => now()->addDays(90),
            'quality_requirements' => 'Certified trainer with 10+ years experience',
            'approval_status' => ProposeItem::APPROVAL_STATUS_REJECTED,
            'procurement_status' => ProposeItem::PROCUREMENT_CANCELLED
        ]);

        // Calculate totals for all proposes
        foreach ([$propose1, $propose2, $propose3, $propose4] as $propose) {
            $propose->calculateTotalAmount();
        }

        echo "Created " . Propose::count() . " sample proposes with " . ProposeItem::count() . " items.\n";
    }
}
