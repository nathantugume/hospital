/**
 * Meditrack HMS — Action Menu Popover System
 * ============================================================
 * Wires all 3-dot action-menu-btn buttons (rendered by clinical-sync.js
 * and admin-sync.js) to show the original action-menu popover dropdown
 * with entity-specific actions — exactly like the original doctors.html pattern.
 *
 * When a user clicks the 3-dot button:
 *   1. A popover menu appears (positioned near the button)
 *   2. The menu shows entity-specific actions (View, Edit, History, Delete, etc.)
 *   3. Clicking an action navigates or performs the action
 *   4. Clicking outside closes the menu
 *
 * Entity-specific action menus:
 *   - patients: View Profile, Medical History, Prescriptions, Delete
 *   - appointments: View Details, Reschedule, Cancel
 *   - invoices: View Invoice, Print, Mark Paid, Void
 *   - labResults: View Results, Print Report, Verify
 *   - medicines: View Details, Edit, Adjust Stock
 *   - prescriptions: View, Dispense, Renew
 *   - inventory: View Details, Adjust Stock, Order
 *   - suppliers: View Details, Contact, Edit
 *   - ambulances: View Details, Track, Edit
 *   - ambulanceCalls: View Details, Complete, Cancel
 *   - bloodDonors: View Details, Edit, Delete
 *   - radiologyOrders: View Details, View Image (PACS), Edit Report
 *   - surgeries: View Details, Edit, Cancel
 *   - rooms: View Allotment, Discharge, Edit
 *   - staff: View Profile, Schedule, Edit, Deactivate
 *   - departments: View Details, Edit, Manage Staff
 *   - roleAssignments: Edit Roles, Remove
 *   - roles: Edit, Delete
 */

(function(window, document) {
    'use strict';

    let activeMenu = null;

    // ============================================================
    // CLOSE ACTIVE MENU
    // ============================================================
    function closeAllMenus() {
        if (activeMenu) {
            activeMenu.remove();
            activeMenu = null;
        }
    }

    // ============================================================
    // ENTITY-SPECIFIC ACTION MENUS
    // ============================================================
    function getMenuItems(entity, item) {
        const id = item.id || item.code || '';
        const name = item.name || item.patientName || item.patient || item.staffName || `#${id}`;

        switch (entity) {
            case 'patients':
                return [
                    { action: 'view', label: 'View Profile', icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>', href: `patient-profile.html?id=${id}` },
                    { action: 'history', label: 'Medical History', icon: '<path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" x2="8" y1="13" y2="13"></line><line x1="16" x2="8" y1="17" y2="17"></line>', href: `history.html?id=${id}` },
                    { action: 'prescriptions', label: 'Prescriptions', icon: '<path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"></path><path d="m8.5 8.5 7 7"></path>', href: `patient-prescription.html?id=${id}` },
                    { divider: true },
                    { action: 'delete', label: 'Delete Patient', icon: '<path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line>', danger: true },
                ];

            case 'appointments':
                return [
                    { action: 'view', label: 'View Details', icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>', href: `appointment-details.html?id=${id}` },
                    { action: 'reschedule', label: 'Reschedule', icon: '<rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path><path d="M8 2v4"></path><path d="M16 2v4"></path>', href: `appointment-reschedule.html?id=${id}` },
                    { action: 'edit', label: 'Edit', icon: '<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>', href: `edit-appointment.html?id=${id}` },
                    { divider: true },
                    { action: 'cancel', label: 'Cancel Appointment', icon: '<circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line>', danger: true },
                ];

            case 'invoices':
                return [
                    { action: 'view', label: 'View Invoice', icon: '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline>', href: `invoice.html?id=${id}` },
                    { action: 'print', label: 'Print Invoice', icon: '<polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect width="12" height="8" x="6" y="14"></rect>' },
                    { action: 'payment', label: 'Process Payment', icon: '<rect width="20" height="14" x="2" y="5" rx="2"></rect><line x1="2" x2="22" y1="10" y2="10"></line>', href: `process-payments.html?ref=${id}` },
                    { divider: true },
                    { action: 'void', label: 'Void Invoice', icon: '<circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line>', danger: true },
                ];

            case 'labResults':
                return [
                    { action: 'view', label: 'View Results', icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>', href: `lab-results.html?id=${id}` },
                    { action: 'print', label: 'Print Report', icon: '<polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect width="12" height="8" x="6" y="14"></rect>' },
                    { action: 'verify', label: 'Verify Result', icon: '<path d="M9 12l2 2 4-4"></path><circle cx="12" cy="12" r="10"></circle>' },
                ];

            case 'medicines':
                return [
                    { action: 'view', label: 'View Details', icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>', href: `medicine-details.html?id=${id}` },
                    { action: 'edit', label: 'Edit Medicine', icon: '<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>', href: `edit-medicine.html?id=${id}` },
                    { action: 'stock', label: 'Adjust Stock', icon: '<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>' },
                ];

            case 'prescriptions':
                return [
                    { action: 'view', label: 'View Prescription', icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>', href: `prescriptions-details.html?id=${id}` },
                    { action: 'dispense', label: 'Dispense', icon: '<path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"></path><path d="m8.5 8.5 7 7"></path>' },
                    { action: 'renew', label: 'Renew Prescription', icon: '<path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path>', href: `renew-prescription.html?id=${id}` },
                ];

            case 'inventory':
                return [
                    { action: 'view', label: 'View Details', icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>', href: `inventory-details.html?id=${id}` },
                    { action: 'edit', label: 'Edit Item', icon: '<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>', href: `edit-inventory.html?id=${id}` },
                    { action: 'order', label: 'Place Order', icon: '<circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path>' },
                ];

            case 'suppliers':
                return [
                    { action: 'view', label: 'View Details', icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>', href: `supplier-details.html?id=${id}` },
                    { action: 'contact', label: 'Contact Supplier', icon: '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>' },
                    { action: 'edit', label: 'Edit Supplier', icon: '<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>', href: `edit-supplier.html?id=${id}` },
                ];

            case 'ambulances':
                return [
                    { action: 'view', label: 'View Details', icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>', href: `ambulance-details.html?id=${id}` },
                    { action: 'track', label: 'Track GPS', icon: '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle>' },
                    { action: 'edit', label: 'Edit Details', icon: '<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>', href: `edit-ambulance-details.html?id=${id}` },
                ];

            case 'ambulanceCalls':
                return [
                    { action: 'view', label: 'View Details', icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>', href: `ambulance-calls-details.html?id=${id}` },
                    { action: 'complete', label: 'Mark Complete', icon: '<polyline points="20 6 9 17 4 12"></polyline>' },
                    { divider: true },
                    { action: 'cancel', label: 'Cancel Call', icon: '<circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line>', danger: true },
                ];

            case 'bloodDonors':
                return [
                    { action: 'view', label: 'View Details', icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>', href: `donor-details.html?id=${id}` },
                    { action: 'edit', label: 'Edit Donor', icon: '<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>', href: `edit-donor.html?id=${id}` },
                    { divider: true },
                    { action: 'delete', label: 'Delete Donor', icon: '<path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>', danger: true },
                ];

            case 'radiologyOrders':
                return [
                    { action: 'view', label: 'View Details', icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>', href: `radiology-details.html?id=${id}` },
                    { action: 'view-image', label: 'View Image (PACS)', icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>' },
                    { action: 'edit', label: 'Edit Report', icon: '<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>', href: `edit-radiology.html?id=${id}` },
                ];

            case 'surgeries':
                return [
                    { action: 'view', label: 'View Details', icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>', href: `surgery-details.html?id=${id}` },
                    { action: 'edit', label: 'Edit Surgery', icon: '<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>', href: `edit-surgery.html?id=${id}` },
                    { divider: true },
                    { action: 'cancel', label: 'Cancel Surgery', icon: '<circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line>', danger: true },
                ];

            case 'rooms':
                return [
                    { action: 'view', label: 'View Allotment', icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>', href: `rooms-alloted-details.html?id=${id}` },
                    { action: 'discharge', label: 'Discharge Patient', icon: '<path d="M9 21H5a2 2 0 0 0-2-2V5a2 2 0 0 0 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" x2="9" y1="12" y2="12"></line>' },
                    { action: 'edit', label: 'Edit Allotment', icon: '<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>', href: `edit-room-allotment.html?id=${id}` },
                ];

            // Admin entities
            case 'staff':
                return [
                    { action: 'view', label: 'View Profile', icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>', href: `staff-profile.html?id=${id}` },
                    { action: 'schedule', label: 'View Schedule', icon: '<rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path><path d="M8 2v4"></path><path d="M16 2v4"></path>', href: `staff-schedule.html?id=${id}` },
                    { action: 'edit', label: 'Edit Details', icon: '<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>', href: `edit-staff-profile.html?id=${id}` },
                    { divider: true },
                    { action: 'deactivate', label: 'Deactivate', icon: '<circle cx="12" cy="12" r="10"></circle><line x1="18" y1="6" x2="6" y2="18"></line>', danger: true },
                ];

            case 'departments':
                return [
                    { action: 'view', label: 'View Details', icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>', href: `department-details.html?id=${id}` },
                    { action: 'staff', label: 'Manage Staff', icon: '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path>', href: `department-staff.html?id=${id}` },
                    { action: 'edit', label: 'Edit Department', icon: '<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>', href: `edit-department.html?id=${id}` },
                ];

            case 'roleAssignments':
                return [
                    { action: 'edit', label: 'Edit Roles', icon: '<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>', href: `edit-admin-role.html?id=${id}` },
                    { divider: true },
                    { action: 'remove', label: 'Remove Assignment', icon: '<path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>', danger: true },
                ];

            case 'roles':
                return [
                    { action: 'edit', label: 'Edit Role', icon: '<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path>', href: `edit-admin-role.html?id=${id}` },
                    { action: 'users', label: 'View Users', icon: '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle>', href: `role-users.html?id=${id}` },
                    { divider: true },
                    { action: 'delete', label: 'Delete Role', icon: '<path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>', danger: true },
                ];

            default:
                return [
                    { action: 'view', label: 'View Details', icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle>', href: '#' },
                ];
        }
    }

    // ============================================================
    // SHOW ACTION MENU POPOVER
    // ============================================================
    function showActionMenu(btn) {
        closeAllMenus();

        const id = btn.getAttribute('data-id');
        const entity = btn.getAttribute('data-entity') || '';

        // Try to get the item from the store
        let item = { id };
        if (window.MeditrackStore) {
            const page = (window.location.pathname.split('/').pop() || '').toLowerCase();
            const entityMap = {
                'patients.html': 'patients', 'appointments.html': 'appointments',
                'billing.html': 'invoices', 'lab-results.html': 'labResults',
                'medicine.html': 'medicines', 'prescriptions.html': 'prescriptions',
                'inventory.html': 'inventory', 'suppliers.html': 'suppliers',
                'ambulance-list.html': 'ambulances', 'ambulance-calls.html': 'ambulanceCalls',
                'blood-donors.html': 'bloodDonors', 'radiology-list.html': 'radiologyOrders',
                'ot-schedule.html': 'surgeries', 'rooms-alloted.html': 'rooms',
                'staff-management.html': 'staff', 'departments.html': 'departments',
            };
            const storeEntity = entityMap[page] || entity;
            if (storeEntity) {
                const stored = window.MeditrackStore.get(storeEntity, id);
                if (stored) item = stored;
            }
        }

        const menuItems = getMenuItems(entity, item);
        const entityLabels = {
            patients: 'Patient Actions', appointments: 'Appointment Actions',
            invoices: 'Invoice Actions', labResults: 'Lab Result Actions',
            medicines: 'Medicine Actions', prescriptions: 'Prescription Actions',
            inventory: 'Inventory Actions', suppliers: 'Supplier Actions',
            ambulances: 'Ambulance Actions', ambulanceCalls: 'Call Actions',
            bloodDonors: 'Donor Actions', radiologyOrders: 'Radiology Actions',
            surgeries: 'Surgery Actions', rooms: 'Room Actions',
            staff: 'Staff Actions', departments: 'Department Actions',
            roleAssignments: 'Role Actions', roles: 'Role Actions',
        };

        const rect = btn.getBoundingClientRect();
        const menu = document.createElement('div');
        menu.className = 'action-menu';
        let left = rect.left;
        let top = rect.bottom + 6;
        if (left + 210 > window.innerWidth) left = window.innerWidth - 220;
        if (top + 250 > window.innerHeight) top = rect.top - 260;
        menu.style.top = `${top}px`;
        menu.style.left = `${left}px`;

        let html = `<div class="action-menu-header">${entityLabels[entity] || 'Actions'}</div>`;
        menuItems.forEach(mi => {
            if (mi.divider) {
                html += '<div class="action-divider"></div>';
            } else {
                const dangerClass = mi.danger ? ' text-red-600' : '';
                html += `<button data-action="${mi.action}" data-id="${id}" data-entity="${entity}" class="action-item${dangerClass}">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">${mi.icon}</svg>
                    ${mi.label}
                </button>`;
            }
        });
        menu.innerHTML = html;
        document.body.appendChild(menu);
        activeMenu = menu;

        // Wire action buttons
        menu.querySelectorAll('.action-item').forEach(actionBtn => {
            actionBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                const action = actionBtn.getAttribute('data-action');
                const actionId = actionBtn.getAttribute('data-id');
                const actionEntity = actionBtn.getAttribute('data-entity');

                // Find the matching menu item
                const menuItem = menuItems.find(mi => mi.action === action);
                closeAllMenus();

                // Handle the action
                handleAction(action, actionId, actionEntity, menuItem, item);
            });
        });
    }

    // ============================================================
    // HANDLE ACTION CLICK
    // ============================================================
    function handleAction(action, id, entity, menuItem, item) {
        const Toast = window.Meditrack?.Toast;

        switch (action) {
            case 'view':
            case 'edit':
            case 'schedule':
            case 'staff':
            case 'users':
            case 'reschedule':
            case 'renew':
            case 'order':
            case 'track':
                if (menuItem?.href && menuItem.href !== '#') {
                    Toast?.info('Navigating...');
                    setTimeout(() => window.location.href = menuItem.href, 200);
                }
                break;

            case 'view-image':
                // Trigger PACS viewer modal
                if (window.MeditrackPDF) {
                    // If PACS modal exists on the page, open it
                    const pacsModal = document.getElementById('viewImageModal');
                    if (pacsModal) {
                        pacsModal.style.display = 'flex';
                        pacsModal.classList.add('show');
                        // Try to call the existing openImageViewer function
                        if (typeof window.openImageViewer === 'function') {
                            window.openImageViewer({ id: id, fileName: `IMG_${id}.DCM`, patientName: item.patientName || item.patient || 'Patient', view: 'Axial', modality: 'CT', uploadDate: new Date().toISOString().slice(0, 10) });
                        }
                    } else {
                        Toast?.info('Opening PACS viewer...');
                        setTimeout(() => window.location.href = `radiology-details.html?id=${id}`, 300);
                    }
                }
                break;

            case 'print':
                if (entity === 'invoices' && window.MeditrackPDF) {
                    window.MeditrackPDF.generateInvoice(id);
                } else if (entity === 'labResults' && window.MeditrackPDF) {
                    window.MeditrackPDF.generateLabReport(id);
                } else {
                    window.print();
                }
                break;

            case 'payment':
                if (menuItem?.href) {
                    setTimeout(() => window.location.href = menuItem.href, 200);
                }
                break;

            case 'contact':
                const name = item.name || 'Supplier';
                const phone = item.phone || '';
                const email = item.email || '';
                Toast?.info(`Contact: ${name}${phone ? ' • ' + phone : ''}${email ? ' • ' + email : ''}`, { duration: 6000 });
                break;

            case 'dispense':
                Toast?.success(`Prescription #${id} marked for dispensing.`);
                if (window.MeditrackStore) {
                    window.MeditrackStore.update('prescriptions', id, { status: 'Dispensed' });
                }
                break;

            case 'verify':
                Toast?.success(`Lab result ${id} verified.`);
                if (window.MeditrackStore) {
                    window.MeditrackStore.update('labResults', id, { status: 'Verified' });
                }
                break;

            case 'complete':
                Toast?.success(`Call ${id} marked as completed.`);
                if (window.MeditrackStore) {
                    window.MeditrackStore.update('ambulanceCalls', id, { status: 'Completed' });
                }
                break;

            case 'discharge':
                if (window.Meditrack?.confirm) {
                    window.Meditrack.confirm(
                        `Discharge patient from room allotment ${id}?`,
                        () => {
                            Toast?.success('Patient discharged successfully.');
                            if (window.MeditrackStore) {
                                window.MeditrackStore.update('rooms', id, { status: 'Discharged', dischargeDate: new Date().toISOString().slice(0, 10) });
                            }
                        },
                        { danger: false, title: 'Discharge Patient', okText: 'Discharge' }
                    );
                }
                break;

            case 'stock':
                Toast?.info('Opening stock adjustment...');
                break;

            case 'cancel':
            case 'delete':
            case 'remove':
            case 'void':
            case 'deactivate':
                const labels = {
                    cancel: 'cancel', delete: 'delete', remove: 'remove',
                    void: 'void', deactivate: 'deactivate',
                };
                const label = labels[action] || 'delete';
                const itemName = item.name || item.patient || item.patientName || `#${id}`;
                if (window.Meditrack?.confirm) {
                    window.Meditrack.confirm(
                        `Are you sure you want to ${label} "${itemName}"? This action cannot be undone.`,
                        () => {
                            if (window.MeditrackStore) {
                                const entityMap = {
                                    patients: 'patients', appointments: 'appointments',
                                    invoices: 'invoices', bloodDonors: 'bloodDonors',
                                    surgeries: 'surgeries', ambulanceCalls: 'ambulanceCalls',
                                    rooms: 'rooms',
                                };
                                const storeEntity = entityMap[entity];
                                if (storeEntity) {
                                    if (action === 'void' || action === 'cancel') {
                                        window.MeditrackStore.update(storeEntity, id, { status: action === 'void' ? 'Void' : 'Cancelled' });
                                    } else if (action === 'deactivate') {
                                        window.MeditrackStore.update(storeEntity, id, { status: 'Inactive' });
                                    } else {
                                        window.MeditrackStore.delete(storeEntity, id);
                                    }
                                }
                            }
                            Toast?.success(`"${itemName}" ${action === 'deactivate' ? 'deactivated' : label + 'd'} successfully.`);
                        },
                        { danger: true, title: `Confirm ${label.charAt(0).toUpperCase() + label.slice(1)}`, okText: label.charAt(0).toUpperCase() + label.slice(1) }
                    );
                }
                break;
        }
    }

    // ============================================================
    // WIRE ALL ACTION-MENU-BTN BUTTONS
    // ============================================================
    function wireActionMenuButtons() {
        document.querySelectorAll('.action-menu-btn').forEach(btn => {
            if (btn.dataset.actionMenuWired) return;
            btn.dataset.actionMenuWired = '1';

            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                if (activeMenu && activeMenu._triggerBtn === btn) {
                    closeAllMenus();
                    return;
                }
                activeMenu = null;
                showActionMenu(btn);
                if (activeMenu) activeMenu._triggerBtn = btn;
            });
        });
    }

    // ============================================================
    // CLOSE MENU ON OUTSIDE CLICK + ESCAPE
    // ============================================================
    document.addEventListener('click', (e) => {
        if (activeMenu && !activeMenu.contains(e.target) && !e.target.closest('.action-menu-btn')) {
            closeAllMenus();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeAllMenus();
    });

    // Re-position menu on scroll/resize
    window.addEventListener('scroll', closeAllMenus, true);
    window.addEventListener('resize', closeAllMenus);

    // ============================================================
    // INIT
    // ============================================================
    function init() {
        wireActionMenuButtons();
        // Re-wire after dynamic content renders
        setTimeout(wireActionMenuButtons, 1000);
        setTimeout(wireActionMenuButtons, 2500);

        // Watch for new buttons
        const observer = new MutationObserver(() => {
            clearTimeout(window._actionMenuTimer);
            window._actionMenuTimer = setTimeout(wireActionMenuButtons, 200);
        });
        observer.observe(document.body, { childList: true, subtree: true });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expose for other modules
    window.MeditrackActionMenu = {
        show: showActionMenu,
        close: closeAllMenus,
        wire: wireActionMenuButtons,
    };

})(window, document);
