/**
 * Meditrack HMS — Centralized Data Store
 * ============================================
 *
 * Implements a "single source of truth" architecture across all HMS pages.
 * Every page reads from and writes to this shared store, which is persisted
 * to localStorage. When any page modifies data, all other open pages are
 * notified via the `meditrack-store-changed` event and can re-render.
 *
 * Supported entities (each stored as an array under `meditrack_<entity>`):
 *   - departments
 *   - staff          (staff + doctors)
 *   - roles          (role assignments + permission matrix)
 *   - patients
 *   - appointments
 *   - appointmentRequests
 *   - invoices
 *   - labResults
 *   - labTests
 *   - prescriptions
 *   - medicines
 *   - inventory
 *   - suppliers
 *   - ambulances
 *   - ambulanceCalls
 *   - bloodDonors
 *   - bloodUnits
 *   - bloodIssues
 *   - radiologyOrders
 *   - surgeries
 *   - rooms
 *   - roomAllotments
 *   - services
 *   - vaccinations
 *   - birthRecords
 *   - deathRecords
 *   - messages      (email.html)
 *   - chatThreads   (chat.html)
 *   - notifications (system-wide)
 *
 * Usage:
 *   // List
 *   const staff = MeditrackStore.list('staff');
 *   // Get one
 *   const s = MeditrackStore.get('staff', 123);
 *   // Create (auto-assigns id + createdAt)
 *   const newDept = MeditrackStore.create('departments', { name: 'Cardiology', head: 'Dr. Nakato' });
 *   // Update
 *   MeditrackStore.update('staff', 123, { status: 'On Leave' });
 *   // Delete
 *   MeditrackStore.delete('staff', 123);
 *   // Listen for changes from other pages/tabs
 *   window.addEventListener('meditrack-store-changed', (e) => {
 *     if (e.detail.entity === 'staff') renderStaffTable();
 *   });
 */

(function(window) {
    'use strict';

    const STORAGE_PREFIX = 'meditrack_';
    const EVENT_NAME = 'meditrack-store-changed';

    // ============================================================
    // SEED DATA — used the first time the store is initialized.
    // Mirrors the dummy data in the frontend pages, but with
    // East African names and UGX currency.
    // ============================================================
    const SEED = {
        departments: [
            { id: 1, code: 'DEP-001', name: 'Cardiology', head: 'Dr. Nakato Sarah', staffCount: 8, servicesCount: 12, status: 'Active', icon: 'heart', description: 'Heart and cardiovascular care' },
            { id: 2, code: 'DEP-002', name: 'Pediatrics', head: 'Dr. Achieng Grace', staffCount: 12, servicesCount: 15, status: 'Active', icon: 'baby', description: 'Child healthcare' },
            { id: 3, code: 'DEP-003', name: 'Obstetrics & Gynecology', head: 'Dr. Wanjiru Emily', staffCount: 10, servicesCount: 14, status: 'Active', icon: 'venus', description: 'Maternal health' },
            { id: 4, code: 'DEP-004', name: 'Surgery', head: 'Dr. Okello James', staffCount: 15, servicesCount: 20, status: 'Active', icon: 'cut', description: 'General and specialist surgery' },
            { id: 5, code: 'DEP-005', name: 'Internal Medicine', head: 'Dr. Mwangi Peter', staffCount: 14, servicesCount: 18, status: 'Active', icon: 'stethoscope', description: 'Adult medicine' },
            { id: 6, code: 'DEP-006', name: 'Emergency', head: 'Dr. Ssali Michael', staffCount: 20, servicesCount: 10, status: 'Active', icon: 'ambulance', description: '24/7 emergency care' },
            { id: 7, code: 'DEP-007', name: 'Radiology', head: 'Dr. Nabwire Emily', staffCount: 6, servicesCount: 8, status: 'Active', icon: 'x-ray', description: 'Diagnostic imaging' },
            { id: 8, code: 'DEP-008', name: 'Laboratory', head: 'Kibirige John', staffCount: 9, servicesCount: 25, status: 'Active', icon: 'flask', description: 'Clinical lab tests' },
            { id: 9, code: 'DEP-009', name: 'Pharmacy', head: 'Ssemwogerere David', staffCount: 7, servicesCount: 30, status: 'Active', icon: 'pills', description: 'Medication dispensing' },
            { id: 10, code: 'DEP-010', name: 'Physiotherapy', head: 'Kemigisha Jennifer', staffCount: 5, servicesCount: 8, status: 'Active', icon: 'exercise', description: 'Rehabilitation' },
        ],
        staff: [
            { id: 1, code: 'ST-001', name: 'Dr. Nakato Sarah', initials: 'NS', role: 'Cardiologist', department: 'Cardiology', email: 'doctor@meditrack.com', phone: '+256 712 345 100', joined: '2015-05-15', status: 'Active', ward: 'Cardiology Wing', wardPatients: 12 },
            { id: 2, code: 'ST-002', name: 'Dr. Mwangi Peter', initials: 'MP', role: 'Neurologist', department: 'Internal Medicine', email: 'doctor@meditrack.com', phone: '+256 712 345 101', joined: '2012-03-20', status: 'Active', ward: 'Neurology Unit', wardPatients: 8 },
            { id: 3, code: 'ST-003', name: 'Dr. Achieng Grace', initials: 'AG', role: 'Pediatrician', department: 'Pediatrics', email: 'doctor@meditrack.com', phone: '+256 712 345 102', joined: '2017-08-10', status: 'Active', ward: 'Pediatrics', wardPatients: 15 },
            { id: 4, code: 'ST-004', name: 'Dr. Okello James', initials: 'OJ', role: 'Orthopedic Surgeon', department: 'Surgery', email: 'surgeon@meditrack.com', phone: '+256 712 345 103', joined: '2010-01-15', status: 'Active', ward: 'OT-1', wardPatients: 6 },
            { id: 5, code: 'ST-005', name: 'Dr. Wanjiru Emily', initials: 'WE', role: 'Obstetrician', department: 'Obstetrics & Gynecology', email: 'doctor@meditrack.com', phone: '+256 712 345 104', joined: '2014-09-05', status: 'Active', ward: 'Maternity Wing', wardPatients: 18 },
            { id: 6, code: 'ST-006', name: 'Dr. Ssali Michael', initials: 'SM', role: 'Cardiothoracic Surgeon', department: 'Surgery', email: 'surgeon@meditrack.com', phone: '+256 712 345 105', joined: '2008-11-22', status: 'Active', ward: 'OT-2', wardPatients: 4 },
            { id: 7, code: 'ST-007', name: 'Dr. Nabwire Emily', initials: 'NE', role: 'Radiologist', department: 'Radiology', email: 'radiology@meditrack.com', phone: '+256 712 345 106', joined: '2016-04-18', status: 'Active', ward: 'Radiology Unit', wardPatients: 0 },
            { id: 8, code: 'ST-008', name: 'Ssentongo James', initials: 'SJ', role: 'Hospital Director', department: 'Internal Medicine', email: 'superadmin@meditrack.com', phone: '+256 712 345 107', joined: '2005-02-01', status: 'Active', ward: 'Front Office', wardPatients: 0 },
            { id: 9, code: 'ST-009', name: 'Nalwoga Sarah', initials: 'NS', role: 'Head Nurse', department: 'Emergency', email: 'nurse@meditrack.com', phone: '+256 712 345 108', joined: '2013-06-12', status: 'Active', ward: 'Emergency', wardPatients: 20 },
            { id: 10, code: 'ST-010', name: 'Byaruhanga Robert', initials: 'BR', role: 'Staff Nurse', department: 'Surgery', email: 'nurse@meditrack.com', phone: '+256 712 345 109', joined: '2016-07-25', status: 'Active', ward: 'OT-1', wardPatients: 6 },
            { id: 11, code: 'ST-011', name: 'Ssemwogerere David', initials: 'SD', role: 'Chief Pharmacist', department: 'Pharmacy', email: 'pharmacist@meditrack.com', phone: '+256 712 345 110', joined: '2011-03-30', status: 'Active', ward: 'Pharmacy Dispensary', wardPatients: 0 },
            { id: 12, code: 'ST-012', name: 'Kibirige John', initials: 'KJ', role: 'Senior Lab Technician', department: 'Laboratory', email: 'lab@meditrack.com', phone: '+256 712 345 111', joined: '2014-10-08', status: 'Active', ward: 'Laboratory', wardPatients: 0 },
            { id: 13, code: 'ST-013', name: 'Akampa David', initials: 'AD', role: 'Receptionist', department: 'Internal Medicine', email: 'receptionist@meditrack.com', phone: '+256 712 345 112', joined: '2018-02-14', status: 'Active', ward: 'Front Desk', wardPatients: 0 },
            { id: 14, code: 'ST-014', name: 'Nabisere Patricia', initials: 'NP', role: 'Accountant', department: 'Internal Medicine', email: 'accountant@meditrack.com', phone: '+256 712 345 113', joined: '2013-09-19', status: 'Active', ward: 'Finance Office', wardPatients: 0 },
            { id: 15, code: 'ST-015', name: 'Atim Linda', initials: 'AL', role: 'Insurance Officer', department: 'Internal Medicine', email: 'insurance@meditrack.com', phone: '+256 712 345 114', joined: '2017-05-22', status: 'Active', ward: 'Insurance Desk', wardPatients: 0 },
            { id: 16, code: 'ST-016', name: 'Mukasa David', initials: 'MD', role: 'Ambulance Driver', department: 'Emergency', email: 'driver@meditrack.com', phone: '+256 712 345 115', joined: '2019-01-10', status: 'Active', ward: 'Ambulance Bay', wardPatients: 0 },
            { id: 17, code: 'ST-017', name: 'Kemigisha Jennifer', initials: 'KJ', role: 'Physiotherapist', department: 'Physiotherapy', email: 'physio@meditrack.com', phone: '+256 712 345 116', joined: '2015-11-03', status: 'Active', ward: 'Therapy Room A', wardPatients: 5 },
            { id: 18, code: 'ST-018', name: 'Tumusiime Thomas', initials: 'TT', role: 'Ambulance Dispatcher', department: 'Emergency', email: 'dispatcher@meditrack.com', phone: '+256 712 345 117', joined: '2018-08-17', status: 'Active', ward: 'Dispatch Office', wardPatients: 0 },
        ],
        roles: [
            { id: 1, name: 'Super Admin', description: 'Full system access including SaaS management', usersCount: 2, permissions: ['all'], color: 'red' },
            { id: 2, name: 'Admin', description: 'Hospital administration', usersCount: 1, permissions: ['manage_staff', 'manage_departments', 'view_reports', 'manage_settings'], color: 'orange' },
            { id: 3, name: 'Doctor', description: 'Clinical care', usersCount: 4, permissions: ['view_patients', 'create_prescriptions', 'order_lab', 'order_radiology'], color: 'blue' },
            { id: 4, name: 'Nurse', description: 'Patient care', usersCount: 2, permissions: ['view_patients', 'administer_meds', 'collect_samples'], color: 'green' },
            { id: 5, name: 'Receptionist', description: 'Front desk', usersCount: 1, permissions: ['register_patients', 'book_appointments', 'create_invoices'], color: 'gray' },
            { id: 6, name: 'Lab Technician', description: 'Lab operations', usersCount: 1, permissions: ['view_lab_requests', 'enter_results'], color: 'purple' },
            { id: 7, name: 'Pharmacist', description: 'Pharmacy operations', usersCount: 1, permissions: ['dispense_meds', 'manage_inventory'], color: 'indigo' },
            { id: 8, name: 'Patient', description: 'Self-service portal', usersCount: 1, permissions: ['view_own_records', 'book_appointments'], color: 'teal' },
            { id: 9, name: 'Accountant', description: 'Billing & payroll', usersCount: 1, permissions: ['manage_billing', 'manage_payroll', 'view_reports'], color: 'amber' },
            { id: 10, name: 'Insurance Officer', description: 'Insurance claims', usersCount: 1, permissions: ['manage_claims', 'verify_insurance'], color: 'rose' },
        ],
        roleAssignments: [
            { id: 1, staffId: 8, staffName: 'Ssentongo James', email: 'superadmin@meditrack.com', department: 'Internal Medicine', roles: ['Super Admin', 'Admin'], assignedBy: 'System', lastUpdated: '2026-05-10', status: 'Active' },
            { id: 2, staffId: 1, staffName: 'Dr. Nakato Sarah', email: 'doctor@meditrack.com', department: 'Cardiology', roles: ['Doctor', 'Admin'], assignedBy: 'Ssentongo James', lastUpdated: '2026-04-15', status: 'Active' },
            { id: 3, staffId: 9, staffName: 'Nalwoga Sarah', email: 'nurse@meditrack.com', department: 'Emergency', roles: ['Nurse'], assignedBy: 'Ssentongo James', lastUpdated: '2026-03-22', status: 'Active' },
            { id: 4, staffId: 11, staffName: 'Ssemwogerere David', email: 'pharmacist@meditrack.com', department: 'Pharmacy', roles: ['Pharmacist'], assignedBy: 'Ssentongo James', lastUpdated: '2026-02-18', status: 'Active' },
            { id: 5, staffId: 12, staffName: 'Kibirige John', email: 'lab@meditrack.com', department: 'Laboratory', roles: ['Lab Technician'], assignedBy: 'Ssentongo James', lastUpdated: '2026-01-30', status: 'Active' },
        ],
        patients: [
            { id: 1, code: 'P-10001', name: 'Okello David', age: 45, gender: 'Male', phone: '+256 712 345 678', email: 'patient@meditrack.com', address: 'Plot 14, Kampala Road, Kampala', bloodType: 'O+', status: 'Active', lastVisit: '2026-06-15', condition: 'Hypertension', doctor: 'Dr. Nakato Sarah' },
            { id: 2, code: 'P-10002', name: 'Nakato Mary', age: 32, gender: 'Female', phone: '+256 712 345 679', email: 'nakato.mary@meditrack.com', address: 'Plot 12, Ntinda Road, Kampala', bloodType: 'A+', status: 'Active', lastVisit: '2026-07-02', condition: 'Diabetes Type 2', doctor: 'Dr. Mwangi Peter' },
            { id: 3, code: 'P-10003', name: 'Mwangi Peter', age: 58, gender: 'Male', phone: '+256 712 345 680', email: 'mwangi.peter@meditrack.com', address: 'Plot 23, Kololo Hill Drive, Kampala', bloodType: 'B+', status: 'Inactive', lastVisit: '2026-05-20', condition: 'Arthritis', doctor: 'Dr. Achieng Grace' },
            { id: 4, code: 'P-10004', name: 'Achieng Grace', age: 27, gender: 'Female', phone: '+256 712 345 681', email: 'achieng.grace@meditrack.com', address: 'Plot 5, Buganda Road, Kampala', bloodType: 'AB+', status: 'Active', lastVisit: '2026-07-10', condition: 'Asthma', doctor: 'Dr. Okello James' },
            { id: 5, code: 'P-10005', name: 'Kimera John', age: 50, gender: 'Male', phone: '+256 712 345 682', email: 'kimera.john@meditrack.com', address: 'Plot 19, Naguru, Kampala', bloodType: 'O-', status: 'Active', lastVisit: '2026-06-28', condition: 'Pneumonia', doctor: 'Dr. Wanjiru Emily' },
        ],
        appointments: [
            { id: 1, patient: 'Okello David', doctor: 'Dr. Nakato Sarah', date: '2026-07-15', time: '10:00 AM', status: 'Confirmed', type: 'Check-up', duration: '30 min' },
            { id: 2, patient: 'Nakato Mary', doctor: 'Dr. Mwangi Peter', date: '2026-07-15', time: '11:00 AM', status: 'Confirmed', type: 'Follow-up', duration: '30 min' },
            { id: 3, patient: 'Mwangi Peter', doctor: 'Dr. Achieng Grace', date: '2026-07-16', time: '09:00 AM', status: 'Pending', type: 'Consultation', duration: '45 min' },
            { id: 4, patient: 'Achieng Grace', doctor: 'Dr. Okello James', date: '2026-07-16', time: '02:00 PM', status: 'Completed', type: 'Procedure', duration: '60 min' },
            { id: 5, patient: 'Kimera John', doctor: 'Dr. Wanjiru Emily', date: '2026-07-17', time: '08:30 AM', status: 'Cancelled', type: 'Check-up', duration: '30 min' },
        ],
        invoices: [
            { id: 'INV-1001', patient: 'Okello David', patientId: 'P-10001', date: '2026-06-15', dueDate: '2026-07-15', amount: 250000, balance: 0, status: 'Paid', insuranceStatus: 'Approved', paymentMethod: 'MTN MoMo', paymentDate: '2026-06-15' },
            { id: 'INV-1002', patient: 'Nakato Mary', patientId: 'P-10002', date: '2026-06-20', dueDate: '2026-07-20', amount: 500000, balance: 500000, status: 'Unpaid', insuranceStatus: 'Pending', paymentMethod: null, paymentDate: null },
            { id: 'INV-1003', patient: 'Mwangi Peter', patientId: 'P-10003', date: '2026-05-20', dueDate: '2026-06-20', amount: 1200000, balance: 700000, status: 'Partially Paid', insuranceStatus: 'Approved', paymentMethod: 'Airtel Money', paymentDate: '2026-05-25' },
        ],
        labResults: [
            { id: 'RES-001', sampleId: 'SMP-001', patientName: 'Okello David', patientId: 'P-10001', testName: 'Complete Blood Count', resultValue: '8.5', normalRange: '4.5-11.0', unit: 'K/uL', resultDate: '2026-06-16', status: 'Normal', flag: 'Normal', orderedBy: 'Dr. Nakato Sarah', verifiedBy: 'Dr. Nakato Sarah', department: 'Hematology' },
            { id: 'RES-002', sampleId: 'SMP-002', patientName: 'Nakato Mary', patientId: 'P-10002', testName: 'Fasting Blood Sugar', resultValue: '8.2', normalRange: '3.9-5.5', unit: 'mmol/L', resultDate: '2026-06-21', status: 'Abnormal', flag: 'High', orderedBy: 'Dr. Mwangi Peter', verifiedBy: 'Dr. Mwangi Peter', department: 'Biochemistry' },
            { id: 'RES-003', sampleId: 'SMP-003', patientName: 'Mwangi Peter', patientId: 'P-10003', testName: 'Lipid Profile', resultValue: '5.8', normalRange: '<5.2', unit: 'mmol/L', resultDate: '2026-05-21', status: 'Abnormal', flag: 'High', orderedBy: 'Dr. Achieng Grace', verifiedBy: 'Dr. Achieng Grace', department: 'Biochemistry' },
        ],
        prescriptions: [
            { id: 1, patient: 'Okello David', doctor: 'Dr. Nakato Sarah', date: '2026-06-15', status: 'Active', medications: 'Lisinopril 10mg (Once daily), Metformin 500mg (Twice daily)', refills: 2 },
            { id: 2, patient: 'Nakato Mary', doctor: 'Dr. Mwangi Peter', date: '2026-06-20', status: 'Active', medications: 'Insulin Glargine 20 units (Bedtime)', refills: 1 },
            { id: 3, patient: 'Achieng Grace', doctor: 'Dr. Okello James', date: '2026-06-25', status: 'Completed', medications: 'Amoxicillin 500mg (TID)', refills: 0 },
        ],
        medicines: [
            { id: 'MED001', name: 'Paracetamol 500mg', generic: 'Paracetamol', category: 'Analgesics', type: 'prescription', manufacturer: "Belle's Pharmaceuticals (U) Ltd", sellingPrice: 500, stock: 2000, expiry: '2027-06-15', status: 'In Stock' },
            { id: 'MED002', name: 'Amoxicillin 500mg', generic: 'Amoxicillin', category: 'Antibiotics', type: 'prescription', manufacturer: 'Medicines for Africa', sellingPrice: 1500, stock: 5000, expiry: '2027-03-20', status: 'In Stock' },
            { id: 'MED003', name: 'Artemether/Lumefantrine 20/120mg', generic: 'Artemether/Lumefantrine', category: 'Antimalarials', type: 'prescription', manufacturer: 'Rocimar Pharmaceuticals', sellingPrice: 8000, stock: 800, expiry: '2026-12-15', status: 'In Stock' },
            { id: 'MED004', name: 'Metformin 500mg', generic: 'Metformin', category: 'Antidiabetics', type: 'prescription', manufacturer: 'Laborex Uganda', sellingPrice: 1000, stock: 50, expiry: '2027-04-30', status: 'Low Stock' },
        ],
        inventory: [
            { id: 'INV001', name: 'Disposable Gloves (Box)', category: 'Medical Supplies', stockCurrent: 45, minLevel: 20, status: 'In Stock', lastUpdated: '2026-06-15' },
            { id: 'INV002', name: 'Surgical Masks (Box of 50)', category: 'PPE', stockCurrent: 12, minLevel: 30, status: 'Critical', lastUpdated: '2026-06-20' },
            { id: 'INV003', name: 'Syringes 5ml (Pack of 100)', category: 'Medical Supplies', stockCurrent: 200, minLevel: 50, status: 'In Stock', lastUpdated: '2026-06-18' },
            { id: 'INV004', name: 'IV Drip Sets', category: 'Medical Supplies', stockCurrent: 0, minLevel: 25, status: 'Out of Stock', lastUpdated: '2026-06-22' },
        ],
        suppliers: [
            { id: 'SUP001', name: "Belle's Pharmaceuticals (U) Ltd", category: 'Pharmaceuticals', email: 'info@bellespharma.co.ug', phone: '+256 414 200 100', rating: 5, status: 'Active', preferred: true },
            { id: 'SUP002', name: 'Laborex Uganda', category: 'Lab Supplies', email: 'info@laborex.co.ug', phone: '+256 414 200 200', rating: 4, status: 'Active', preferred: true },
            { id: 'SUP003', name: 'National Medical Stores (NMS)', category: 'Government Supply', email: 'info@nms.go.ug', phone: '+256 414 200 600', rating: 5, status: 'Active', preferred: true },
        ],
        ambulances: [
            { id: 1, regNo: 'UAX 123X', model: 'Toyota HiAce', year: 2021, type: 'Basic Life Support', status: 'Available', driver: 'Mukasa David', location: 'Main Hospital', lastMaintenance: '2026-03-15', nextMaintenance: '2026-09-15', mileage: '45,230 km' },
            { id: 2, regNo: 'UAH 456K', model: 'Mercedes Sprinter', year: 2022, type: 'Advanced Life Support', status: 'On Call', driver: 'Tumusiime Thomas', location: 'OPD Wing', lastMaintenance: '2026-04-01', nextMaintenance: '2026-10-01', mileage: '32,150 km' },
            { id: 3, regNo: 'UAM 789A', model: 'Ford Transit', year: 2020, type: 'Basic Life Support', status: 'Available', driver: 'Mukasa David', location: 'Casualty Block', lastMaintenance: '2026-02-10', nextMaintenance: '2026-08-10', mileage: '78,900 km' },
        ],
        ambulanceCalls: [
            { id: 'CALL-001', caller: 'Akampa David', patient: 'Okello David', pickup: 'Plot 14, Kampala Road', destination: 'Mulago Hospital', callTime: '2026-06-28 10:15', status: 'Completed', priority: 'Emergency', severity: 'Red', ambulance: 'UAX 123X' },
            { id: 'CALL-002', caller: 'Nalwoga Sarah', patient: 'Nakato Mary', pickup: 'Plot 12, Ntinda Road', destination: 'Mulago Hospital', callTime: '2026-06-28 11:30', status: 'En Route', priority: 'Urgent', severity: 'Orange', ambulance: 'UAH 456K' },
        ],
        bloodDonors: [
            { id: 'D-1001', name: 'Okello David', bloodType: 'O+', phone: '+256 712 345 678', lastDonation: '2026-03-15', status: 'Eligible', totalDonations: 8, donorTier: 'Silver Donor' },
            { id: 'D-1002', name: 'Nakato Mary', bloodType: 'A+', phone: '+256 712 345 679', lastDonation: '2026-04-20', status: 'Eligible', totalDonations: 5, donorTier: 'Regular' },
            { id: 'D-1003', name: 'Mwangi Peter', bloodType: 'B+', phone: '+256 712 345 680', lastDonation: '2026-02-10', status: 'Eligible', totalDonations: 12, donorTier: 'Gold Donor' },
        ],
        bloodUnits: [
            { id: 'BS-001', bloodType: 'A+', units: 12, collectionDate: '2026-04-15', expiryDate: '2026-05-15', status: 'Available', location: 'Refrigerator 1', donor: 'Nakato Mary' },
            { id: 'BS-002', bloodType: 'O+', units: 8, collectionDate: '2026-04-20', expiryDate: '2026-05-20', status: 'Available', location: 'Refrigerator 1', donor: 'Okello David' },
            { id: 'BS-003', bloodType: 'B+', units: 5, collectionDate: '2026-02-10', expiryDate: '2026-03-10', status: 'Expired', location: 'Refrigerator 2', donor: 'Mwangi Peter' },
        ],
        radiologyOrders: [
            { id: 'ORD-001', patient: 'Okello David', modality: 'CT', bodyPart: 'Chest', priority: 'Routine', status: 'Completed', referringDoctor: 'Dr. Nakato Sarah', radiologist: 'Dr. Nabwire Emily', orderDate: '2026-05-10', scheduledDate: '2026-05-11', completedDate: '2026-05-11', reportStatus: 'Final', findings: 'No acute cardiopulmonary findings.' },
            { id: 'ORD-002', patient: 'Nakato Mary', modality: 'MRI', bodyPart: 'Brain', priority: 'Urgent', status: 'In Progress', referringDoctor: 'Dr. Mwangi Peter', radiologist: 'Dr. Nabwire Emily', orderDate: '2026-06-15', scheduledDate: '2026-06-16', completedDate: null, reportStatus: 'Pending', findings: null },
            { id: 'ORD-003', patient: 'Mwangi Peter', modality: 'X-Ray', bodyPart: 'Knee', priority: 'Routine', status: 'Completed', referringDoctor: 'Dr. Achieng Grace', radiologist: 'Dr. Nabwire Emily', orderDate: '2026-05-20', scheduledDate: '2026-05-21', completedDate: '2026-05-21', reportStatus: 'Final', findings: 'Mild osteoarthritis of the right knee.' },
        ],
        surgeries: [
            { id: 'SURG001', patient: 'Mwangi Peter', procedure: 'CABG - Triple Bypass', otRoom: 'OT-1', surgeon: 'Dr. Ssali Michael', anesthesiologist: 'Dr. Lumu Peter', date: '2026-06-13', startTime: '08:30', endTime: '13:30', status: 'In Progress', priority: 'High' },
            { id: 'SURG002', patient: 'Okello David', procedure: 'Appendectomy', otRoom: 'OT-2', surgeon: 'Dr. Okello James', anesthesiologist: 'Dr. Lumu Peter', date: '2026-06-14', startTime: '10:00', endTime: '11:30', status: 'Scheduled', priority: 'Normal' },
        ],
        rooms: [
            { id: 'RA-001', patient: 'Okello David', patientId: 'P-10001', room: '301', roomType: 'Private', department: 'Cardiology', allotmentDate: '2026-06-15', status: 'Occupied', doctor: 'Dr. Nakato Sarah' },
            { id: 'RA-002', patient: 'Nakato Mary', patientId: 'P-10002', room: '205', roomType: 'General', department: 'Pediatrics', allotmentDate: '2026-06-20', status: 'Occupied', doctor: 'Dr. Achieng Grace' },
            { id: 'RA-003', patient: 'Mwangi Peter', patientId: 'P-10003', room: '101', roomType: 'ICU', department: 'Emergency', allotmentDate: '2026-05-20', status: 'Discharged', doctor: 'Dr. Ssali Michael' },
        ],
        messages: [
            { id: 'MSG-001', from: 'Dr. Nakato Sarah', fromEmail: 'doctor@meditrack.com', to: 'Okello David', subject: 'Lab Results Ready', body: 'Your CBC results are now available. Please review them at your earliest convenience.', date: '2026-06-16 14:30', read: false, folder: 'inbox', starred: false },
            { id: 'MSG-002', from: 'Pharmacy', fromEmail: 'pharmacist@meditrack.com', to: 'Dr. Nakato Sarah', subject: 'Prescription Ready for Okello David', body: 'Prescription for Lisinopril 10mg is ready for pickup.', date: '2026-06-16 15:00', read: false, folder: 'inbox', starred: true },
            { id: 'MSG-003', from: 'Dr. Mwangi Peter', fromEmail: 'doctor@meditrack.com', to: 'Dr. Nakato Sarah', subject: 'Patient Referral', body: 'Referring patient Nakato Mary for cardiology consult.', date: '2026-06-15 10:00', read: true, folder: 'inbox', starred: false },
            { id: 'MSG-004', from: 'Dr. Nakato Sarah', fromEmail: 'doctor@meditrack.com', to: 'Nalwoga Sarah', subject: 'Medication Administration', body: 'Please administer Lisinopril 10mg to patient Okello David at 18:00.', date: '2026-06-15 17:30', read: true, folder: 'sent', starred: false },
        ],
        chatThreads: [
            { id: 1, name: 'Dr. Nakato Sarah', role: 'Cardiologist', avatar: 'NS', unread: 2, lastMsg: "I'll check the patient's records", time: '10:42 AM', status: 'online', blocked: false, group: false },
            { id: 2, name: 'Dr. Mwangi Peter', role: 'Neurologist', avatar: 'MP', unread: 0, lastMsg: 'Patient referral received', time: '09:15 AM', status: 'online', blocked: false, group: false },
            { id: 3, name: 'Nalwoga Sarah', role: 'Head Nurse', avatar: 'NS', unread: 1, lastMsg: 'Medication administered', time: 'Yesterday', status: 'offline', blocked: false, group: false },
            { id: 4, name: 'Cardiology Team', role: 'Group', avatar: 'CT', unread: 5, lastMsg: 'Conference call at 3 PM', time: 'Yesterday', status: 'group', blocked: false, group: true },
        ],
        chatMessages: {
            '1': [
                { sender: 'them', text: 'Hello Dr. Nakato, I need to consult on a case', time: '10:30 AM' },
                { sender: 'me', text: 'Of course, what is the case about?', time: '10:32 AM' },
                { sender: 'them', text: "Patient P-10002 has elevated blood sugar", time: '10:35 AM' },
                { sender: 'me', text: "I'll check the patient's records", time: '10:42 AM' },
            ],
            '2': [
                { sender: 'them', text: 'Patient referral received', time: '09:15 AM' },
            ],
            '3': [
                { sender: 'them', text: 'Medication administered to patient P-10001', time: 'Yesterday 18:05' },
            ],
            '4': [
                { sender: 'them', text: 'Conference call at 3 PM', time: 'Yesterday 14:00' },
            ],
        },
        notifications: [],
    };

    // ============================================================
    // CORE STORE IMPLEMENTATION
    // ============================================================
    function storageKey(entity) {
        return STORAGE_PREFIX + entity;
    }

    function readRaw(entity) {
        try {
            const raw = localStorage.getItem(storageKey(entity));
            if (raw === null) return null;
            return JSON.parse(raw);
        } catch (e) {
            console.warn('[MeditrackStore] Failed to read', entity, e);
            return null;
        }
    }

    function writeRaw(entity, data) {
        try {
            localStorage.setItem(storageKey(entity), JSON.stringify(data));
            // Broadcast change event
            window.dispatchEvent(new CustomEvent(EVENT_NAME, { detail: { entity, action: 'write' } }));
            // Also broadcast to other tabs via storage event (handled automatically)
            return true;
        } catch (e) {
            console.error('[MeditrackStore] Failed to write', entity, e);
            return false;
        }
    }

    function ensureSeeded(entity) {
        const existing = readRaw(entity);
        if (existing === null) {
            if (SEED[entity]) {
                writeRaw(entity, SEED[entity]);
                return SEED[entity];
            }
            // Initialize empty array for entities without seed
            writeRaw(entity, []);
            return [];
        }
        return existing;
    }

    function list(entity, filterFn = null) {
        const data = ensureSeeded(entity);
        if (filterFn && Array.isArray(data)) {
            return data.filter(filterFn);
        }
        return data;
    }

    function get(entity, id) {
        const data = ensureSeeded(entity);
        if (Array.isArray(data)) {
            return data.find(item => item.id == id) || null;
        }
        if (typeof data === 'object' && data !== null) {
            return data[id] || null;
        }
        return null;
    }

    function create(entity, payload) {
        const data = ensureSeeded(entity);
        if (Array.isArray(data)) {
            // Auto-assign id
            const maxId = data.reduce((max, item) => {
                const id = typeof item.id === 'number' ? item.id : parseInt(String(item.id).replace(/\D/g, ''), 10) || 0;
                return Math.max(max, id);
            }, 0);
            const newId = maxId + 1;
            const newItem = { id: newId, ...payload, createdAt: new Date().toISOString() };
            data.push(newItem);
            writeRaw(entity, data);
            return newItem;
        }
        if (typeof data === 'object' && data !== null) {
            // Object-style entities (e.g., chatMessages)
            const newId = String(Object.keys(data).length + 1);
            data[newId] = Array.isArray(payload) ? payload : [payload];
            writeRaw(entity, data);
            return data[newId];
        }
        return null;
    }

    function update(entity, id, updates) {
        const data = ensureSeeded(entity);
        if (Array.isArray(data)) {
            const idx = data.findIndex(item => item.id == id);
            if (idx === -1) return null;
            data[idx] = { ...data[idx], ...updates, updatedAt: new Date().toISOString() };
            writeRaw(entity, data);
            return data[idx];
        }
        if (typeof data === 'object' && data !== null) {
            if (data[id]) {
                data[id] = Array.isArray(data[id]) && Array.isArray(updates)
                    ? updates
                    : { ...data[id], ...updates };
                writeRaw(entity, data);
                return data[id];
            }
        }
        return null;
    }

    function remove(entity, id) {
        const data = ensureSeeded(entity);
        if (Array.isArray(data)) {
            const filtered = data.filter(item => item.id != id);
            writeRaw(entity, filtered);
            return true;
        }
        if (typeof data === 'object' && data !== null) {
            if (data[id]) {
                delete data[id];
                writeRaw(entity, data);
                return true;
            }
        }
        return false;
    }

    function count(entity) {
        const data = ensureSeeded(entity);
        if (Array.isArray(data)) return data.length;
        if (typeof data === 'object' && data !== null) return Object.keys(data).length;
        return 0;
    }

    function reset(entity = null) {
        if (entity) {
            localStorage.removeItem(storageKey(entity));
            ensureSeeded(entity);
        } else {
            // Reset all
            Object.keys(SEED).forEach(e => {
                localStorage.removeItem(storageKey(e));
                ensureSeeded(e);
            });
        }
        window.dispatchEvent(new CustomEvent(EVENT_NAME, { detail: { entity: entity || 'all', action: 'reset' } }));
    }

    function onChange(callback) {
        window.addEventListener(EVENT_NAME, (e) => callback(e.detail.entity, e.detail.action, e));
        // Also listen to storage events from other tabs
        window.addEventListener('storage', (e) => {
            if (e.key && e.key.startsWith(STORAGE_PREFIX)) {
                const entity = e.key.substring(STORAGE_PREFIX.length);
                callback(entity, 'cross-tab', e);
            }
        });
    }

    // ============================================================
    // EXPORT
    // ============================================================
    window.MeditrackStore = {
        list,
        get,
        create,
        update,
        delete: remove,
        count,
        reset,
        onChange,
        // Convenience: check if entity has data
        isSeeded: (entity) => readRaw(entity) !== null,
        // Get all entity names
        entities: () => Object.keys(SEED),
        // Storage key helper (for direct localStorage access if needed)
        storageKey,
    };

    // Auto-seed on first load
    Object.keys(SEED).forEach(entity => ensureSeeded(entity));

})(window);
