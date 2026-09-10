<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Department;
use App\Models\Staff;
use App\Models\User;
use App\Models\Patient;
use App\Models\PatientInsurance;
use App\Models\InsuranceProvider;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InsuranceClaim;
use App\Models\ClaimService;
use App\Models\LabTest;
use App\Models\LabResult;
use App\Models\LabResultItem;
use App\Models\LabEquipment;
use App\Models\TestRequest;
use App\Models\Medicine;
use App\Models\MedicineBatch;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\InventoryItem;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use App\Models\PurchaseOrder;
use App\Models\Ambulance;
use App\Models\AmbulanceCall;
use App\Models\BloodDonor;
use App\Models\BloodUnit;
use App\Models\BloodIssue;
use App\Models\BirthRecord;
use App\Models\DeathRecord;
use App\Models\Room;
use App\Models\RoomAllotment;
use App\Models\Service;
use App\Models\PayrollEntry;
use App\Models\Payslip;
use App\Models\Vaccination;
use App\Models\PhysiotherapySession;
use App\Models\Surgery;
use App\Models\RadiologyOrder;
use App\Models\CalendarEvent;
use App\Models\Notification;
use App\Models\AuditLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            InsuranceProvidersSeeder::class,
            LabTestsSeeder::class,
            EaHospitalSeeder::class,
        ]);
    }
}

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $roles = config('auth.roles', []);
        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(['name' => $role], ['updated_at' => now(), 'created_at' => now()]);
        }
    }
}

class InsuranceProvidersSeeder extends Seeder
{
    public function run(): void
    {
        $providers = [
            ['name' => 'AAR Insurance', 'code' => 'AAR', 'country' => 'Kenya', 'api_provider_key' => 'aar'],
            ['name' => 'Jubilee Insurance', 'code' => 'JUB', 'country' => 'Uganda', 'api_provider_key' => 'jubilee'],
            ['name' => 'UAP Old Mutual', 'code' => 'UAP', 'country' => 'Uganda', 'api_provider_key' => 'uap'],
            ['name' => 'ICEA Lion', 'code' => 'ICEA', 'country' => 'Kenya', 'api_provider_key' => 'icea'],
            ['name' => 'Britam Insurance', 'code' => 'BRIT', 'country' => 'Kenya', 'api_provider_key' => 'britam'],
            ['name' => 'CIC Insurance', 'code' => 'CIC', 'country' => 'Kenya'],
            ['name' => 'APA Insurance', 'code' => 'APA', 'country' => 'Kenya'],
            ['name' => 'GA Insurance', 'code' => 'GA', 'country' => 'Kenya'],
            ['name' => 'Liberty Life', 'code' => 'LIB', 'country' => 'Uganda'],
            ['name' => 'Sanlam Insurance', 'code' => 'SAN', 'country' => 'Kenya', 'api_provider_key' => 'sanlam'],
            ['name' => 'NHIF Kenya', 'code' => 'NHIFKE', 'country' => 'Kenya', 'api_provider_key' => 'nhif_kenya'],
            ['name' => 'NHIF Tanzania', 'code' => 'NHIFTZ', 'country' => 'Tanzania', 'api_provider_key' => 'nhif_tanzania'],
            ['name' => 'RSSB Rwanda', 'code' => 'RSSB', 'country' => 'Rwanda', 'api_provider_key' => 'rssb_rwanda'],
            ['name' => 'SHIF Kenya (Social Health Insurance Fund)', 'code' => 'SHIF', 'country' => 'Kenya'],
        ];

        foreach ($providers as $p) {
            InsuranceProvider::updateOrCreate(['name' => $p['name']], $p);
        }
    }
}

class LabTestsSeeder extends Seeder
{
    public function run(): void
    {
        $tests = [
            ['code' => 'cbc', 'name' => 'Complete Blood Count', 'department' => 'Hematology', 'sample_type' => 'Blood', 'price' => 25000],
            ['code' => 'lipid', 'name' => 'Lipid Profile', 'department' => 'Biochemistry', 'sample_type' => 'Blood', 'price' => 35000],
            ['code' => 'fbs', 'name' => 'Fasting Blood Sugar', 'department' => 'Biochemistry', 'sample_type' => 'Blood', 'price' => 15000],
            ['code' => 'hba1c', 'name' => 'HbA1c (Glycated Hemoglobin)', 'department' => 'Biochemistry', 'sample_type' => 'Blood', 'price' => 45000],
            ['code' => 'lft', 'name' => 'Liver Function Tests', 'department' => 'Biochemistry', 'sample_type' => 'Blood', 'price' => 40000],
            ['code' => 'rft', 'name' => 'Renal Function Tests', 'department' => 'Biochemistry', 'sample_type' => 'Blood', 'price' => 40000],
            ['code' => 'tsh', 'name' => 'Thyroid Stimulating Hormone', 'department' => 'Immunology', 'sample_type' => 'Blood', 'price' => 50000],
            ['code' => 'urinalysis', 'name' => 'Urinalysis', 'department' => 'Microbiology', 'sample_type' => 'Urine', 'price' => 15000],
            ['code' => 'stool', 'name' => 'Stool Analysis', 'department' => 'Microbiology', 'sample_type' => 'Stool', 'price' => 20000],
            ['code' => 'widal', 'name' => 'Widal Test (Typhoid)', 'department' => 'Immunology', 'sample_type' => 'Blood', 'price' => 20000],
            ['code' => 'bsfor_mp', 'name' => 'Blood Smear for Malaria Parasite', 'department' => 'Hematology', 'sample_type' => 'Blood', 'price' => 15000],
            ['code' => 'hiv', 'name' => 'HIV Test', 'department' => 'Immunology', 'sample_type' => 'Blood', 'price' => 15000],
            ['code' => 'hbv', 'name' => 'Hepatitis B Surface Antigen', 'department' => 'Immunology', 'sample_type' => 'Blood', 'price' => 25000],
            ['code' => 'pregnancy', 'name' => 'Pregnancy Test (hCG)', 'department' => 'Immunology', 'sample_type' => 'Urine', 'price' => 10000],
            ['code' => 'blood_group', 'name' => 'Blood Group & Rh', 'department' => 'Hematology', 'sample_type' => 'Blood', 'price' => 15000],
            ['code' => 'esr', 'name' => 'Erythrocyte Sedimentation Rate', 'department' => 'Hematology', 'sample_type' => 'Blood', 'price' => 20000],
            ['code' => 'crp', 'name' => 'C-Reactive Protein', 'department' => 'Immunology', 'sample_type' => 'Blood', 'price' => 30000],
            ['code' => 'psa', 'name' => 'Prostate Specific Antigen', 'department' => 'Biochemistry', 'sample_type' => 'Blood', 'price' => 45000],
        ];

        foreach ($tests as $t) {
            LabTest::updateOrCreate(['code' => $t['code']], array_merge($t, [
                'currency' => 'UGX',
                'target_turnaround_hours' => 4.0,
                'status' => 'Active',
            ]));
        }
    }
}

class EaHospitalSeeder extends Seeder
{
    public function run(): void
    {
        // === Company (SaaS hospital client) ===
        $company = Company::create([
            'code' => 'COM-001',
            'name' => 'Mulago National Referral Hospital',
            'email' => 'admin@mulago.go.ug',
            'url' => 'mulago.meditrack.ea',
            'plan' => 'Enterprise Suite',
            'contact_person' => 'Dr. Ssentongo James',
            'phone' => '+256 414 100 101',
            'country' => 'Uganda',
            'city' => 'Kampala',
            'address' => 'Plot 14, Kampala Road, Kampala, Uganda',
            'beds_count' => 1500,
            'created_on' => '2024-01-15',
            'status' => 'Active',
            'notes' => 'Uganda\'s largest referral hospital',
        ]);

        // === Departments ===
        $departments = [
            ['name' => 'Cardiology', 'icon' => 'heart'],
            ['name' => 'Pediatrics', 'icon' => 'baby'],
            ['name' => 'Obstetrics & Gynecology', 'icon' => 'venus'],
            ['name' => 'Surgery', 'icon' => 'cut'],
            ['name' => 'Internal Medicine', 'icon' => 'stethoscope'],
            ['name' => 'Emergency', 'icon' => 'ambulance'],
            ['name' => 'Radiology', 'icon' => 'x-ray'],
            ['name' => 'Laboratory', 'icon' => 'flask'],
            ['name' => 'Pharmacy', 'icon' => 'pills'],
            ['name' => 'Physiotherapy', 'icon' => 'exercise'],
        ];

        $deptIds = [];
        foreach ($departments as $d) {
            $dept = Department::create(array_merge($d, [
                'company_id' => $company->id,
                'code' => strtoupper(substr($d['name'], 0, 3)),
                'status' => 'Active',
            ]));
            $deptIds[$d['name']] = $dept->id;
        }

        // === Staff (20+) ===
        $staffData = [
            ['Dr. Nakato Sarah', 'Cardiologist', 'Cardiology', 'doctor'],
            ['Dr. Mwangi Peter', 'Neurologist', 'Internal Medicine', 'doctor'],
            ['Dr. Achieng Grace', 'Pediatrician', 'Pediatrics', 'doctor'],
            ['Dr. Okello James', 'Orthopedic Surgeon', 'Surgery', 'surgeon'],
            ['Dr. Wanjiru Emily', 'Obstetrician', 'Obstetrics & Gynecology', 'doctor'],
            ['Dr. Kimera Robert', 'General Physician', 'Internal Medicine', 'doctor'],
            ['Dr. Ssali Michael', 'Cardiothoracic Surgeon', 'Surgery', 'surgeon'],
            ['Dr. Nabwire Emily', 'Radiologist', 'Radiology', 'radiology_technician'],
            ['Dr. Ssentongo James', 'Hospital Director', 'Internal Medicine', 'admin'],
            ['Nurse Nalwoga Sarah', 'Head Nurse', 'Emergency', 'nurse'],
            ['Nurse Byaruhanga Robert', 'Staff Nurse', 'Surgery', 'nurse'],
            ['Nurse Tumusiime Thomas', 'Staff Nurse', 'Pediatrics', 'nurse'],
            ['Nurse Namyalo Maria', 'Midwife', 'Obstetrics & Gynecology', 'nurse'],
            ['Pharm. Ssemwogerere David', 'Chief Pharmacist', 'Pharmacy', 'pharmacist'],
            ['Lab Tech Kibirige John', 'Senior Lab Technician', 'Laboratory', 'lab_technician'],
            ['Lab Tech Nabwire Lisa', 'Lab Technician', 'Laboratory', 'lab_technician'],
            ['Dr. Lumu Peter', 'Anesthesiologist', 'Surgery', 'doctor'],
            ['Physio. Kemigisha Jennifer', 'Physiotherapist', 'Physiotherapy', 'physiotherapist'],
            ['Akampa David', 'Receptionist', 'Internal Medicine', 'receptionist'],
            ['Nabisere Patricia', 'Accountant', 'Internal Medicine', 'accountant'],
            ['Mukasa David', 'Ambulance Driver', 'Emergency', 'ambulance_driver'],
            ['Atim Linda', 'Insurance Officer', 'Internal Medicine', 'insurance_officer'],
        ];

        $staffIds = [];
        foreach ($staffData as $i => $s) {
            $parts = explode(' ', $s[0], 2);
            $firstName = str_replace(['Dr.', 'Nurse', 'Pharm.', 'Lab Tech', 'Physio.'], '', $parts[0]);
            $firstName = trim($firstName);
            $lastName = $parts[1] ?? '';

            $email = strtolower(str_replace(['.', ' '], ['', '.'], $s[0])) . '@meditrack.ea';

            $staff = Staff::create([
                'code' => 'ST-' . str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT),
                'company_id' => $company->id,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'initials' => strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1)),
                'email' => $email,
                'phone' => '+256 712 345 ' . str_pad((string) ($i + 100), 3, '0', STR_PAD_LEFT),
                'gender' => $i % 2 === 0 ? 'Male' : 'Female',
                'address' => 'Plot 14, Kampala Road, Kampala',
                'city' => 'Kampala',
                'country' => 'Uganda',
                'role' => $s[1],
                'position' => $s[1],
                'department_id' => $deptIds[$s[2]],
                'specialization' => in_array($s[3], ['doctor', 'surgeon']) ? $s[1] : null,
                'license_number' => 'UMDPC-' . str_pad((string) ($i + 1000), 5, '0', STR_PAD_LEFT),
                'experience_years' => rand(3, 20),
                'joined_date' => now()->subYears(rand(1, 10))->toDateString(),
                'avatar_initials' => strtoupper(substr($firstName, 0, 1) . substr($lastName, 0, 1)),
                'status' => 'Active',
            ]);
            $staffIds[$s[3]][$i] = $staff->id;

            // Link staff to department head (first staff = head)
            if ($i < count($departments)) {
                Department::where('id', array_values($deptIds)[$i] ?? null)
                    ->update(['head_staff_id' => $staff->id]);
            }
        }

        // === Users (auth) ===
        $demoUsers = [
            ['admin@meditrack.ea', 'admin', 'admin', 'Medi-track Admin'],
            ['doctor@meditrack.ea', 'doctor', 'doctor', 'Dr. Nakato Sarah'],
            ['nurse@meditrack.ea', 'nurse', 'nurse', 'Nurse Nalwoga Sarah'],
            ['receptionist@meditrack.ea', 'receptionist', 'receptionist', 'Akampa David'],
            ['lab@meditrack.ea', 'lab_technician', 'lab', 'Lab Tech Kibirige John'],
            ['pharmacist@meditrack.ea', 'pharmacist', 'pharmacist', 'Pharm. Ssemwogerere David'],
            ['patient@meditrack.ea', 'patient', 'patient', 'Okello David'],
            ['superadmin@meditrack.ea', 'super_admin', 'superadmin', 'Super Admin'],
        ];

        foreach ($demoUsers as $i => $u) {
            $staffId = null;
            $patientId = null;
            if ($u[1] !== 'patient' && $u[1] !== 'super_admin') {
                $expectedStaffEmail = strtolower(str_replace(['.', ' '], ['', '.'], $u[3])) . '@meditrack.ea';
                $staffId = Staff::where('email', $expectedStaffEmail)->value('id');
            }
            if ($u[1] === 'patient') {
                $patient = Patient::firstOrCreate(['email' => $u[0]], [
                    'code' => 'P-10001',
                    'company_id' => $company->id,
                    'first_name' => 'Okello',
                    'last_name' => 'David',
                    'date_of_birth' => '1980-05-15',
                    'gender' => 'Male',
                    'phone' => '+256 712 345 678',
                    'address' => 'Plot 14, Kampala Road, Kampala',
                    'city' => 'Kampala',
                    'country' => 'Uganda',
                    'status' => 'Active',
                ]);
                $patientId = $patient->id;
            }
            User::create([
                'name' => $u[3],
                'email' => $u[0],
                'phone' => '+256 712 345 ' . str_pad((string) ($i + 200), 3, '0', STR_PAD_LEFT),
                'password' => Hash::make('password123'),
                'role' => $u[1],
                'company_id' => $company->id,
                'staff_id' => $staffId,
                'patient_id' => $patientId,
                'email_verified_at' => now(),
            ]);
        }

        // === Patients (50+) ===
        $firstNames = ['Okello', 'Nakato', 'Mwangi', 'Achieng', 'Kimera', 'Wanjiru', 'Mukasa', 'Atim', 'Ochieng', 'Nansubuga',
                       'Ssentongo', 'Nabisere', 'Nalwoga', 'Byaruhanga', 'Tumusiime', 'Namyalo', 'Ssemwogerere', 'Nankya',
                       'Wamala', 'Kibirige', 'Nabwire', 'Ssali', 'Lumu', 'Kato', 'Kakonge', 'Akampa',
                       'Kemigisha', 'Mwesigwa', 'Akello', 'Babirye'];
        $lastNames = ['David', 'Mary', 'Peter', 'Grace', 'John', 'Sarah', 'Robert', 'Linda', 'Kevin', 'Sophia',
                      'James', 'Patricia', 'Emily', 'Michael', 'Thomas', 'Maria', 'Daniel', 'Stephanie',
                      'Andrew', 'Rachel', 'Brian', 'Catherine', 'William', 'Jennifer', 'Noah', 'Olivia',
                      'Emma', 'Robert', 'Sophia', 'Mary'];

        $conditions = ['Hypertension', 'Diabetes Type 2', 'Asthma', 'Arthritis', 'Malaria', 'Pneumonia', 'Anemia', 'HIV (on ART)', 'TB', 'Pregnancy'];
        $cities = ['Kampala', 'Entebbe', 'Jinja', 'Mbarara', 'Gulu', 'Mbale', 'Nairobi', 'Mombasa', 'Dar es Salaam', 'Kigali'];

        for ($i = 0; $i < 60; $i++) {
            Patient::create([
                // P-10001 is reserved for the seeded demo patient account above.
                'code' => 'P-' . str_pad((string) (10002 + $i), 5, '0', STR_PAD_LEFT),
                'company_id' => $company->id,
                'first_name' => $firstNames[$i % count($firstNames)],
                'last_name' => $lastNames[$i % count($lastNames)],
                'date_of_birth' => now()->subYears(rand(1, 85))->subDays(rand(0, 365))->toDateString(),
                'gender' => $i % 2 === 0 ? 'Male' : 'Female',
                'blood_type' => ['A+', 'B+', 'O+', 'AB+', 'O-', 'A-'][$i % 6],
                'phone' => '+256 7' . rand(10, 89) . ' ' . str_pad((string) rand(100, 999), 3, '0', STR_PAD_LEFT) . ' ' . str_pad((string) rand(100, 999), 3, '0', STR_PAD_LEFT),
                'email' => strtolower($firstNames[$i % 30]) . '.' . strtolower($lastNames[$i % 30]) . '@example.com',
                'address' => 'Plot ' . rand(1, 100) . ', Kampala Road, Kampala',
                'city' => $cities[$i % count($cities)],
                'district' => 'Central',
                'country' => 'Uganda',
                'condition' => $conditions[$i % count($conditions)],
                'status' => 'Active',
                'last_visit' => now()->subDays(rand(1, 90))->toDateString(),
            ]);
        }

        // === Appointments ===
        $doctors = Staff::whereNotNull('specialization')->get();
        $patients = Patient::all();
        $apptTypes = ['Check-up', 'Follow-up', 'Consultation', 'Emergency', 'New Patient', 'Procedure'];
        $apptStatuses = ['Confirmed', 'Completed', 'Pending', 'Cancelled', 'No-Show'];

        for ($i = 0; $i < 50; $i++) {
            Appointment::create([
                'company_id' => $company->id,
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'department_id' => $doctors->random()->department_id,
                'date' => now()->addDays(rand(-30, 30))->toDateString(),
                'start_time' => '10:00:00',
                'end_time' => '10:30:00',
                'duration' => '30 min',
                'type' => $apptTypes[array_rand($apptTypes)],
                'status' => $apptStatuses[array_rand($apptStatuses)],
                'notes' => 'Routine appointment',
            ]);
        }

        // === Invoices ===
        $invoiceStatuses = ['Paid', 'Paid', 'Pending', 'Partial', 'Overdue', 'Cancelled'];

        for ($i = 0; $i < 30; $i++) {
            $amount = rand(50000, 2000000);
            $invoiceDate = now()->subDays(rand(1, 60));
            $status = $invoiceStatuses[$i % count($invoiceStatuses)];

            $paidAmount = match ($status) {
                'Paid' => $amount,
                'Partial' => (int) round($amount * 0.5),
                default => 0,
            };

            $invoice = Invoice::create([
                'code' => 'INV-' . str_pad((string) (1001 + $i), 5, '0', STR_PAD_LEFT),
                'company_id' => $company->id,
                'patient_id' => $patients->random()->id,
                'date' => $invoiceDate->toDateString(),
                'due_date' => $status === 'Overdue' ? $invoiceDate->copy()->addDays(14)->toDateString() : now()->addDays(30)->toDateString(),
                'amount' => $amount,
                'paid_amount' => $paidAmount,
                'balance' => $amount - $paidAmount,
                'currency' => 'UGX',
                'status' => $status,
                'payment_date' => $status === 'Paid' ? $invoiceDate->copy()->addDays(rand(0, 5))->toDateString() : null,
                'insurance_status' => $i % 4 === 0 ? 'Approved' : 'Not Submitted',
            ]);
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => 'Consultation — General',
                'qty' => 1,
                'unit_price' => $amount,
                'total' => $amount,
            ]);
        }

        // === Medicines ===
        $medicines = [
            ['Paracetamol 500mg', 'Paracetamol', 'Analgesics', 'Belle\'s Pharmaceuticals (U) Ltd', 500, 2000, 100],
            ['Amoxicillin 500mg', 'Amoxicillin', 'Antibiotics', 'Medicines for Africa', 1500, 5000, 50],
            ['Artemether/Lumefantrine 20/120mg', 'Artemether/Lumefantrine', 'Antimalarials', 'Rocimar Pharmaceuticals', 8000, 12000, 30],
            ['Metformin 500mg', 'Metformin', 'Antidiabetics', 'Laborex Uganda', 1000, 3000, 50],
            ['Amlodipine 5mg', 'Amlodipine', 'Antihypertensives', 'JPIA Uganda', 1500, 4000, 40],
            ['Ciprofloxacin 500mg', 'Ciprofloxacin', 'Antibiotics', 'Mulgi Pharma', 2000, 6000, 30],
            ['Omeprazole 20mg', 'Omeprazole', 'PPI', 'AAR Healthcare Supplies', 1000, 3000, 50],
            ['Coartem (Artemether 20mg + Lumefantrine 120mg)', 'Artemether/Lumefantrine', 'Antimalarials', 'Biopharm Uganda', 10000, 15000, 20],
            ['Cotrimoxazole 480mg', 'Cotrimoxazole', 'Antibiotics', 'Eclipse Medical Supplies', 800, 2500, 100],
            ['Diclofenac 50mg', 'Diclofenac', 'NSAIDs', 'Mediq EA', 500, 1500, 80],
        ];

        foreach ($medicines as $i => $m) {
            $medicine = Medicine::create([
                'code' => 'MED' . str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT),
                'name' => $m[0],
                'generic_name' => $m[1],
                'category' => $m[2],
                'type' => 'prescription',
                'manufacturer' => $m[3],
                'selling_price' => $m[4],
                'currency' => 'UGX',
                'stock' => rand(50, 1000),
                'reorder_level' => $m[6],
                'expiry' => now()->addMonths(rand(6, 24))->toDateString(),
                'status' => 'In Stock',
            ]);

            MedicineBatch::create([
                'medicine_id' => $medicine->id,
                'batch_number' => 'BAT' . date('Y') . str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT),
                'mfg_date' => now()->subMonths(6)->toDateString(),
                'expiry_date' => now()->addMonths(18)->toDateString(),
                'quantity' => rand(100, 500),
                'status' => 'Active',
            ]);
        }

        // === Prescriptions ===
        $allMedicines = Medicine::all();
        $dosages = ['500mg', '250mg', '10mg', '5mg', '20mg'];
        $frequencies = ['Once daily', 'Twice daily', 'Three times daily', 'Every 8 hours'];
        $prescriptionStatuses = ['Active', 'Completed', 'Cancelled'];

        for ($i = 0; $i < 25; $i++) {
            $prescription = Prescription::create([
                'code' => 'RX-' . str_pad((string) (1001 + $i), 5, '0', STR_PAD_LEFT),
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'date' => now()->subDays(rand(0, 30))->toDateString(),
                'status' => $prescriptionStatuses[array_rand($prescriptionStatuses)],
                'refills' => rand(0, 3),
                'notes' => 'Take as directed.',
            ]);

            $medicine = $allMedicines->random();
            PrescriptionItem::create([
                'prescription_id' => $prescription->id,
                'medication' => $medicine->name,
                'medicine_id' => $medicine->id,
                'dosage' => $dosages[array_rand($dosages)],
                'frequency' => $frequencies[array_rand($frequencies)],
                'route' => 'Oral',
                'duration' => rand(3, 14),
                'duration_unit' => 'Days',
                'instructions' => 'Take with food.',
            ]);
        }

        // === Lab: Test Requests & Results ===
        $labTests = LabTest::all();
        $priorities = ['Routine', 'Urgent'];
        $requestStatuses = ['Pending', 'In Progress', 'Completed', 'Cancelled'];
        $resultStatuses = ['Pending', 'Completed', 'Verified'];
        $flags = ['Normal', 'Normal', 'Normal', 'High', 'Low', 'Critical'];

        for ($i = 0; $i < 20; $i++) {
            $labTest = $labTests->random();
            $status = $requestStatuses[array_rand($requestStatuses)];

            $testRequest = TestRequest::create([
                'code' => 'TR-' . str_pad((string) (1001 + $i), 5, '0', STR_PAD_LEFT),
                'patient_id' => $patients->random()->id,
                'doctor_id' => $doctors->random()->id,
                'priority' => $priorities[array_rand($priorities)],
                'status' => $status,
                'requested_date' => now()->subDays(rand(0, 14))->toDateString(),
                'notes' => 'Routine lab work-up.',
            ]);

            if (in_array($status, ['Completed', 'In Progress'], true)) {
                LabResult::create([
                    'code' => 'LR-' . str_pad((string) (1001 + $i), 5, '0', STR_PAD_LEFT),
                    'sample_id' => 'SMP-' . str_pad((string) (1001 + $i), 5, '0', STR_PAD_LEFT),
                    'patient_id' => $testRequest->patient_id,
                    'test_request_id' => $testRequest->id,
                    'lab_test_id' => $labTest->id,
                    'test_name' => $labTest->name,
                    'result_value' => (string) rand(4, 20),
                    'normal_range' => '4-10',
                    'unit' => 'units',
                    'result_date' => now()->subDays(rand(0, 10))->toDateString(),
                    'collection_date' => now()->subDays(rand(1, 12))->toDateString(),
                    'status' => $resultStatuses[array_rand($resultStatuses)],
                    'flag' => $flags[array_rand($flags)],
                    'ordered_by' => $testRequest->doctor_id,
                    'sample_type' => $labTest->sample_type,
                    'department' => $labTest->department,
                ]);
            }
        }

        // === Suppliers (EA) ===
        $suppliers = [
            ['Belle\'s Pharmaceuticals (U) Ltd', 'Pharmaceuticals', 'Kampala', 'Uganda', '+256 414 200 100', true],
            ['Laborex Uganda', 'Lab Supplies', 'Kampala', 'Uganda', '+256 414 200 200', true],
            ['Medicines for Africa', 'Pharmaceuticals', 'Kampala', 'Uganda', '+256 414 200 300', true],
            ['Rocimar Pharma', 'Pharmaceuticals', 'Kampala', 'Uganda', '+256 414 200 400', false],
            ['JPIA Uganda', 'Pharmaceuticals', 'Kampala', 'Uganda', '+256 414 200 500', true],
            ['National Medical Stores (NMS)', 'Government Supply', 'Entebbe', 'Uganda', '+256 414 200 600', true],
            ['KEMSA', 'Government Supply', 'Nairobi', 'Kenya', '+254 712 200 700', false],
            ['AAR Healthcare Supplies', 'Medical Supplies', 'Nairobi', 'Kenya', '+254 712 200 800', true],
        ];

        foreach ($suppliers as $i => $s) {
            Supplier::create([
                'code' => 'SUP' . str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT),
                'name' => $s[0],
                'category' => $s[1],
                'email' => 'info@' . strtolower(str_replace([' ', '(', ')', '\'', '/'], '', $s[0])) . '.com',
                'phone' => $s[4],
                'address' => 'Industrial Area, ' . $s[2],
                'location' => $s[2] . ', ' . $s[3],
                'rating' => rand(3, 5),
                'status' => 'Active',
                'preferred' => $s[5],
                'delivery_rate' => rand(90, 100) . '%',
                'lead_time' => rand(2, 7) . ' days',
                'items_count' => rand(50, 500),
            ]);
        }

        // === Ambulances ===
        $ambulances = [
            ['UAX 123X', 'Toyota HiAce', 2021, 'Basic Life Support', 'Available', 'Kampala'],
            ['UAH 456K', 'Mercedes Sprinter', 2022, 'Advanced Life Support', 'On Call', 'Entebbe'],
            ['UAM 789A', 'Ford Transit', 2020, 'Basic Life Support', 'Available', 'Kampala'],
            ['UG 1234A', 'Toyota Land Cruiser Ambulance', 2023, 'Advanced Life Support', 'Maintenance', 'Kampala'],
            ['KAX 123X', 'Toyota HiAce', 2022, 'Basic Life Support', 'Available', 'Nairobi'],
        ];

        foreach ($ambulances as $i => $a) {
            Ambulance::create([
                'code' => 'AMB-' . str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT),
                'reg_no' => $a[0],
                'model' => $a[1],
                'year' => $a[2],
                'type' => $a[3],
                'status' => $a[4],
                'location' => $a[5],
                'last_maintenance' => now()->subMonths(2)->toDateString(),
                'next_maintenance' => now()->addMonths(4)->toDateString(),
                'mileage' => rand(20000, 80000) . ' km',
                'capacity_stretchers' => 1,
                'capacity_seated' => 4,
            ]);
        }

        // === Blood Donors ===
        for ($i = 0; $i < 15; $i++) {
            BloodDonor::create([
                'code' => 'D-' . str_pad((string) (1001 + $i), 4, '0', STR_PAD_LEFT),
                'name' => $firstNames[$i % 30] . ' ' . $lastNames[$i % 30],
                'blood_type' => ['A+', 'B+', 'O+', 'AB+', 'O-', 'A-'][$i % 6],
                'phone' => '+256 7' . rand(10, 89) . ' ' . str_pad((string) rand(100, 999), 3, '0', STR_PAD_LEFT) . ' ' . str_pad((string) rand(100, 999), 3, '0', STR_PAD_LEFT),
                'email' => strtolower($firstNames[$i % 30]) . '@donor.com',
                'last_donation' => now()->subDays(rand(30, 365))->toDateString(),
                'status' => 'Eligible',
                'total_donations' => rand(1, 10),
                'donor_tier' => ['New', 'Regular', 'Silver Donor', 'Gold Donor'][$i % 4],
            ]);
        }

        // === Rooms ===
        for ($i = 1; $i <= 20; $i++) {
            Room::create([
                'number' => (string) (100 + $i),
                'type' => ['Private', 'General', 'ICU', 'Semi-Private'][$i % 4],
                'status' => $i % 3 === 0 ? 'Occupied' : 'Available',
                'department_id' => array_values($deptIds)[$i % count($deptIds)],
            ]);
        }

        // === Services ===
        $services = [
            ['General Checkup', 'Internal Medicine', 'Preventive', '30 min', 50000],
            ['Cardiac Consultation', 'Cardiology', 'Consultation', '45 min', 100000],
            ['Pediatric Consultation', 'Pediatrics', 'Consultation', '30 min', 75000],
            ['Antenatal Visit', 'Obstetrics & Gynecology', 'Consultation', '30 min', 80000],
            ['X-Ray Chest', 'Radiology', 'Diagnostic', '15 min', 60000],
            ['Ultrasound', 'Radiology', 'Diagnostic', '30 min', 100000],
            ['CT Scan', 'Radiology', 'Diagnostic', '45 min', 500000],
            ['Physiotherapy Session', 'Physiotherapy', 'Treatment', '45 min', 80000],
            ['Minor Surgery', 'Surgery', 'Surgical', '120 min', 1500000],
            ['Major Surgery', 'Surgery', 'Surgical', '240 min', 5000000],
        ];

        foreach ($services as $i => $s) {
            Service::create([
                'name' => $s[0],
                'department_id' => $deptIds[$s[1]] ?? null,
                'department_name' => $s[1],
                'type' => $s[2],
                'duration' => $s[3],
                'price' => $s[4],
                'currency' => 'UGX',
                'popularity' => rand(50, 500),
                'status' => 'Active',
            ]);
        }

        echo "  ✓ Seeded EA hospital data.\n";
        echo "    - 1 company (Mulago National Referral Hospital)\n";
        echo "    - 10 departments, 22 staff, 8 users\n";
        echo "    - 60 patients, 50 appointments, 30 invoices\n";
        echo "    - 25 prescriptions, 20 test requests and lab results\n";
        echo "    - 10 medicines, 8 suppliers, 5 ambulances\n";
        echo "    - 15 blood donors, 20 rooms, 10 services\n";
    }
}
