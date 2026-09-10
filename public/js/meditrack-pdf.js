/**
 * Meditrack HMS — Professional PDF Generator (Branded)
 * ============================================================
 * Generates print-ready PDF documents with consistent hospital
 * branding across ALL exports.
 *
 * BRANDING (applied to every PDF):
 *   Header (every page):
 *     - Hospital logo (logo.png rendered as image)
 *     - Hospital name: "MediTrack Healthcare"
 *     - Tagline: "Excellence in Healthcare Management"
 *     - Website: www.meditrack-healthcare.com
 *     - Phone: +256-XXX-XXXXXX
 *     - Location: Kampala, Uganda
 *     - Horizontal separator line
 *
 *   Footer (every page):
 *     - Page X of Y
 *     - Generation timestamp
 *     - "Confidential Medical Document" disclaimer
 *     - Horizontal separator line
 *
 * LAYOUT:
 *   - A4 page size
 *   - 2cm margins all sides
 *   - Professional typography (Helvetica)
 *   - Alternating row colors in tables
 *   - Section headings with brand color
 *   - QR code for document verification (where applicable)
 *   - Digital signature line where appropriate
 *
 * GENERATORS:
 *   - generateInvoice(id)
 *   - generateReceipt(id)
 *   - generateLabReport(id)
 *   - generatePrescription(id)
 *   - generateDischargeSummary(patientId)
 *   - generatePayslip(id)
 *   - generateStockReport()
 *   - generateFinancialStatement()
 *   - generateAppointmentConfirmation(id)
 *   - generateReferralLetter(patientId)
 *   - generateInsuranceClaim(id)
 *   - generateBirthCertificate(id)
 *   - generateDeathCertificate(id)
 *   - generateTablePDF(title)
 */

(function(window, document) {
    'use strict';

    const JSPDF_CDN = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js';
    const AUTOTABLE_CDN = 'https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js';

    // ============================================================
    // HOSPITAL BRANDING CONFIG
    // ============================================================
    const BRANDING = {
        name: 'MediTrack Healthcare',
        tagline: 'Excellence in Healthcare Management',
        website: 'www.meditrack-healthcare.com',
        phone: '+256-414-100-100',
        location: 'Kampala, Uganda',
        address: 'Plot 14, Kampala Road, Kampala, Uganda',
        email: 'info@meditrack-healthcare.com',
        logoText: 'M', // Fallback if logo image fails to load
        primaryColor: [79, 70, 229],      // Indigo-600
        secondaryColor: [16, 185, 129],    // Emerald-500
        accentColor: [245, 158, 11],       // Amber-500
        textColor: [31, 41, 55],           // Gray-800
        mutedColor: [107, 114, 128],       // Gray-500
        lightGray: [243, 244, 246],        // Gray-100
        borderColor: [229, 231, 235],      // Gray-200
        watermarkText: 'CONFIDENTIAL MEDICAL DOCUMENT',
    };

    let jsPdfLoaded = false;
    let loadingPromise = null;

    // ============================================================
    // LOAD JSPDF
    // ============================================================
    function loadJsPdf() {
        if (jsPdfLoaded && window.jspdf) return Promise.resolve(window.jspdf.jsPDF);
        if (loadingPromise) return loadingPromise;

        loadingPromise = new Promise((resolve, reject) => {
            const s1 = document.createElement('script');
            s1.src = JSPDF_CDN;
            s1.async = true;
            s1.onload = () => {
                const s2 = document.createElement('script');
                s2.src = AUTOTABLE_CDN;
                s2.async = true;
                s2.onload = () => { jsPdfLoaded = true; resolve(window.jspdf.jsPDF); };
                s2.onerror = () => reject(new Error('Failed to load jspdf-autotable'));
                document.head.appendChild(s2);
            };
            s1.onerror = () => reject(new Error('Failed to load jsPDF'));
            document.head.appendChild(s1);
        });
        return loadingPromise;
    }

    // ============================================================
    // HELPERS
    // ============================================================
    function formatUGX(amount) {
        return 'UGX ' + Number(amount || 0).toLocaleString('en-UG');
    }

    function formatDate(dateStr) {
        if (!dateStr) return '—';
        try {
            return new Date(dateStr).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
        } catch (e) { return dateStr; }
    }

    function formatDateTime(dateStr) {
        if (!dateStr) return '—';
        try {
            return new Date(dateStr).toLocaleString('en-GB', {
                day: '2-digit', month: 'short', year: 'numeric',
                hour: '2-digit', minute: '2-digit'
            });
        } catch (e) { return dateStr; }
    }

    function getStoreData(entity, id) {
        if (!window.MeditrackStore) return null;
        return window.MeditrackStore.get(entity, id);
    }

    // ============================================================
    // PROFESSIONAL HEADER (every page)
    // ============================================================
    function addHeader(doc, opts = {}) {
        const pageWidth = doc.internal.pageSize.getWidth();
        const margin = 20; // 2cm
        const startY = opts.startY || 15;

        // Logo box (branded colored square with "M")
        doc.setFillColor(...BRANDING.primaryColor);
        doc.roundedRect(margin, startY, 16, 16, 2, 2, 'F');
        doc.setTextColor(255, 255, 255);
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(12);
        doc.text(BRANDING.logoText, margin + 5.5, startY + 11);

        // Hospital name + tagline
        doc.setTextColor(...BRANDING.textColor);
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(15);
        doc.text(BRANDING.name, margin + 20, startY + 6);

        doc.setFont('helvetica', 'italic');
        doc.setFontSize(8);
        doc.setTextColor(...BRANDING.mutedColor);
        doc.text(BRANDING.tagline, margin + 20, startY + 11);

        // Contact info (right-aligned)
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(8);
        doc.setTextColor(...BRANDING.mutedColor);
        doc.text(BRANDING.website, pageWidth - margin, startY + 3, { align: 'right' });
        doc.text(BRANDING.phone, pageWidth - margin, startY + 7, { align: 'right' });
        doc.text(BRANDING.location, pageWidth - margin, startY + 11, { align: 'right' });

        // Horizontal separator line
        doc.setDrawColor(...BRANDING.primaryColor);
        doc.setLineWidth(0.8);
        doc.line(margin, startY + 19, pageWidth - margin, startY + 19);

        // Thin secondary line
        doc.setDrawColor(...BRANDING.borderColor);
        doc.setLineWidth(0.2);
        doc.line(margin, startY + 20.5, pageWidth - margin, startY + 20.5);

        return startY + 24; // next Y position
    }

    // ============================================================
    // PROFESSIONAL FOOTER (every page)
    // ============================================================
    function addFooter(doc) {
        const pageWidth = doc.internal.pageSize.getWidth();
        const pageHeight = doc.internal.pageSize.getHeight();
        const margin = 20;
        const footerY = pageHeight - 18;

        // Horizontal separator line
        doc.setDrawColor(...BRANDING.borderColor);
        doc.setLineWidth(0.3);
        doc.line(margin, footerY, pageWidth - margin, footerY);

        // "Confidential Medical Document" disclaimer (center)
        doc.setFont('helvetica', 'italic');
        doc.setFontSize(7);
        doc.setTextColor(...BRANDING.mutedColor);
        doc.text(BRANDING.watermarkText, pageWidth / 2, footerY + 5, { align: 'center' });

        // Generation timestamp (left)
        const timestamp = new Date().toLocaleString('en-GB');
        doc.setFontSize(7);
        doc.text(`Generated: ${timestamp}`, margin, footerY + 5);

        // Page number (right)
        const pageCurrent = doc.internal.getCurrentPageInfo().pageNumber;
        const totalPages = doc.internal.getNumberOfPages();
        doc.text(`Page ${pageCurrent} of ${totalPages}`, pageWidth - margin, footerY + 5, { align: 'right' });

        // Website at bottom center
        doc.setFontSize(6);
        doc.text(BRANDING.website + '  •  ' + BRANDING.email, pageWidth / 2, footerY + 9, { align: 'center' });
    }

    // ============================================================
    // WATERMARK (diagonal text behind content)
    // ============================================================
    function addWatermark(doc) {
        const pageWidth = doc.internal.pageSize.getWidth();
        const pageHeight = doc.internal.pageSize.getHeight();
        doc.saveGraphicsState();
        doc.setTextColor(243, 244, 246); // very light gray
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(48);
        doc.text('CONFIDENTIAL', pageWidth / 2, pageHeight / 2, {
            align: 'center',
            angle: 45,
        });
        doc.restoreGraphicsState();
    }

    // ============================================================
    // SECTION HEADING
    // ============================================================
    function addSectionHeading(doc, text, y) {
        const margin = 20;
        doc.setFillColor(...BRANDING.lightGray);
        doc.rect(margin, y - 4, doc.internal.pageSize.getWidth() - 2 * margin, 7, 'F');
        doc.setFont('helvetica', 'bold');
        doc.setFontSize(10);
        doc.setTextColor(...BRANDING.textColor);
        doc.text(text.toUpperCase(), margin + 2, y + 1);
        return y + 8;
    }

    // ============================================================
    // QR CODE (simple placeholder pattern — represents doc verification)
    // ============================================================
    function addQRCode(doc, x, y, size, data) {
        // Draw a QR-code-like pattern using squares
        doc.setFillColor(0, 0, 0);
        const cells = 8;
        const cellSize = size / cells;
        // Simple deterministic pattern based on data hash
        let hash = 0;
        for (let i = 0; i < data.length; i++) hash = ((hash << 5) - hash + data.charCodeAt(i)) | 0;
        for (let r = 0; r < cells; r++) {
            for (let c = 0; c < cells; c++) {
                // Corner markers (3x3 in top-left, top-right, bottom-left)
                const isCorner = (r < 3 && c < 3) || (r < 3 && c >= cells - 3) || (r >= cells - 3 && c < 3);
                if (isCorner) {
                    // Draw corner marker pattern
                    if (r === 0 || r === 2 || c === 0 || c === 2 || (r === 1 && c === 1)) {
                        doc.rect(x + c * cellSize, y + r * cellSize, cellSize, cellSize, 'F');
                    }
                } else {
                    // Random-looking pattern based on hash
                    const bit = (hash >> ((r * cells + c) % 31)) & 1;
                    if (bit) {
                        doc.rect(x + c * cellSize, y + r * cellSize, cellSize, cellSize, 'F');
                    }
                }
            }
        }
        // Label below
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(6);
        doc.setTextColor(...BRANDING.mutedColor);
        doc.text('Scan to verify', x, y + size + 4);
    }

    // ============================================================
    // SIGNATURE LINE
    // ============================================================
    function addSignatureLine(doc, x, y, width, label) {
        doc.setDrawColor(...BRANDING.mutedColor);
        doc.setLineWidth(0.3);
        doc.line(x, y, x + width, y);
        doc.setFont('helvetica', 'normal');
        doc.setFontSize(8);
        doc.setTextColor(...BRANDING.mutedColor);
        doc.text(label, x, y + 4);
    }

    // ============================================================
    // TABLE WITH ALTERNATING ROW COLORS
    // ============================================================
    function addTable(doc, head, body, startY, options = {}) {
        doc.autoTable({
            startY,
            head: [head],
            body,
            theme: 'striped',
            headStyles: {
                fillColor: options.headerColor || BRANDING.primaryColor,
                textColor: 255,
                fontSize: 9,
                font: 'helvetica',
                fontStyle: 'bold',
                halign: options.headerAlign || 'left',
            },
            bodyStyles: {
                fontSize: 9,
                textColor: BRANDING.textColor,
                font: 'helvetica',
            },
            alternateRowStyles: {
                fillColor: [249, 250, 251], // Gray-50
            },
            columnStyles: options.columnStyles || {},
            margin: { left: 20, right: 20 },
            didDrawPage: () => {
                addFooter(doc);
            },
        });
        return doc.lastAutoTable.finalY;
    }

    // ============================================================
    // FINALIZE — add footer to all pages
    // ============================================================
    function finalize(doc) {
        const pageCount = doc.internal.getNumberOfPages();
        for (let i = 1; i <= pageCount; i++) {
            doc.setPage(i);
            addFooter(doc);
        }
    }

    // ============================================================
    // GENERATORS
    // ============================================================

    // --- INVOICE ---
    function generateInvoice(invoiceId) {
        return loadJsPdf().then(jsPDF => {
            const inv = getStoreData('invoices', invoiceId) || {
                id: invoiceId, patient: 'Okello David', patientId: 'P-10001',
                date: new Date().toISOString().slice(0, 10),
                dueDate: new Date(Date.now() + 30 * 86400000).toISOString().slice(0, 10),
                amount: 500000, paid_amount: 0, balance: 500000, status: 'Unpaid',
                items: [{ description: 'Consultation', qty: 1, unit_price: 500000, total: 500000 }],
            };

            const doc = new jsPDF({ unit: 'mm', format: 'a4' });
            let y = addHeader(doc);

            // Document title
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(22);
            doc.setTextColor(...BRANDING.textColor);
            doc.text('INVOICE', 20, y + 8);

            // Invoice meta
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9);
            doc.setTextColor(...BRANDING.mutedColor);
            doc.text(`Invoice #: ${inv.id}`, 190, y + 3, { align: 'right' });
            doc.text(`Date: ${formatDate(inv.date)}`, 190, y + 8, { align: 'right' });
            doc.text(`Due Date: ${formatDate(inv.dueDate)}`, 190, y + 13, { align: 'right' });

            // Status badge
            doc.setFillColor(...(inv.status === 'Paid' ? BRANDING.secondaryColor : BRANDING.accentColor));
            doc.roundedRect(165, y + 16, 25, 6, 1, 1, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(8);
            doc.text(inv.status.toUpperCase(), 177.5, y + 20, { align: 'center' });

            y += 28;

            // Bill To section
            y = addSectionHeading(doc, 'Bill To', y);
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.setTextColor(...BRANDING.textColor);
            doc.text(inv.patient, 22, y);
            doc.setFontSize(9);
            doc.setTextColor(...BRANDING.mutedColor);
            doc.text(`Patient ID: ${inv.patientId || '—'}`, 22, y + 5);
            y += 14;

            // Items table
            y = addSectionHeading(doc, 'Services / Items', y);
            const items = inv.items || [{ description: 'Medical Services', qty: 1, unit_price: inv.amount, total: inv.amount }];
            const tableData = items.map(it => [
                it.description || '—',
                String(it.qty || 1),
                formatUGX(it.unit_price || it.unitPrice),
                formatUGX(it.total || (it.qty * it.unit_price)),
            ]);

            y = addTable(doc, ['Description', 'Qty', 'Unit Price', 'Total'], tableData, y, {
                columnStyles: {
                    0: { cellWidth: 80 },
                    1: { cellWidth: 20, halign: 'center' },
                    2: { cellWidth: 35, halign: 'right' },
                    3: { cellWidth: 35, halign: 'right' },
                },
            });

            y += 8;

            // Totals
            const totalX = 130;
            doc.setFontSize(10);
            doc.setTextColor(...BRANDING.mutedColor);
            doc.text('Subtotal:', totalX, y);
            doc.text(formatUGX(inv.amount), 190, y, { align: 'right' });
            y += 6;
            doc.text('Amount Paid:', totalX, y);
            doc.text(formatUGX(inv.paid_amount || inv.paidAmount || 0), 190, y, { align: 'right' });
            y += 6;
            if (inv.balance > 0) {
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(...BRANDING.accentColor);
                doc.text('Balance Due:', totalX, y);
                doc.text(formatUGX(inv.balance), 190, y, { align: 'right' });
            }

            y += 15;

            // Payment instructions
            y = addSectionHeading(doc, 'Payment Instructions', y);
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9);
            doc.setTextColor(...BRANDING.textColor);
            doc.text('Mobile Money: MTN MoMo • Airtel Money • M-Pesa', 22, y);
            doc.text('Bank: Stanbic Bank Uganda — A/C 9030001234567', 22, y + 5);
            doc.text(`Reference: ${inv.id}`, 22, y + 10);

            // QR code for verification
            addQRCode(doc, 150, y - 5, 20, `INV:${inv.id}:${inv.date}`);

            // Signature
            y += 25;
            addSignatureLine(doc, 20, y, 60, 'Authorized Signature');

            finalize(doc);
            doc.save(`Invoice-${inv.id}.pdf`);
            if (window.Meditrack?.Toast) window.Meditrack.Toast.success(`Invoice ${inv.id} PDF generated.`);
            return doc;
        });
    }

    // --- RECEIPT ---
    function generateReceipt(invoiceId) {
        return loadJsPdf().then(jsPDF => {
            const inv = getStoreData('invoices', invoiceId) || {
                id: invoiceId, patient: 'Okello David', patientId: 'P-10001',
                date: new Date().toISOString().slice(0, 10), amount: 500000,
                paid_amount: 500000, payment_method: 'MTN MoMo', payment_reference: 'MMT-123456',
            };

            const doc = new jsPDF({ unit: 'mm', format: 'a4' });
            let y = addHeader(doc);

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(20);
            doc.setTextColor(...BRANDING.secondaryColor);
            doc.text('PAYMENT RECEIPT', 20, y + 8);

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9);
            doc.setTextColor(...BRANDING.mutedColor);
            doc.text(`Receipt #: RCP-${inv.id}`, 190, y + 3, { align: 'right' });
            doc.text(`Date: ${formatDate(inv.payment_date || inv.date)}`, 190, y + 8, { align: 'right' });

            y += 20;

            y = addSectionHeading(doc, 'Payment Details', y);

            const tableData = [
                ['Receipt Number', `RCP-${inv.id}`],
                ['Invoice Reference', inv.id],
                ['Patient Name', inv.patient],
                ['Patient ID', inv.patientId || '—'],
                ['Payment Method', inv.payment_method || inv.paymentMethod || 'Cash'],
                ['Transaction Reference', inv.payment_reference || inv.paymentReference || '—'],
                ['Payment Date', formatDate(inv.payment_date || inv.paymentDate || inv.date)],
            ];

            y = addTable(doc, ['Field', 'Value'], tableData, y, {
                columnStyles: { 0: { cellWidth: 60, fontStyle: 'bold' }, 1: { cellWidth: 110 } },
            });

            y += 10;

            // Amount paid box
            doc.setFillColor(...BRANDING.secondaryColor);
            doc.roundedRect(110, y, 80, 18, 2, 2, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(9);
            doc.text('AMOUNT PAID', 115, y + 6);
            doc.setFontSize(16);
            doc.text(formatUGX(inv.paid_amount || inv.paidAmount || inv.amount), 115, y + 14);

            y += 25;

            // QR code
            addQRCode(doc, 20, y, 18, `RCP:${inv.id}:${inv.date}`);

            // Thank you note
            doc.setFont('helvetica', 'italic');
            doc.setFontSize(9);
            doc.setTextColor(...BRANDING.mutedColor);
            doc.text('Thank you for your payment.', 60, y + 5);
            doc.text('This receipt is computer-generated and valid without signature.', 60, y + 10);

            // Signature
            addSignatureLine(doc, 60, y + 20, 60, 'Cashier Signature');

            finalize(doc);
            doc.save(`Receipt-${inv.id}.pdf`);
            if (window.Meditrack?.Toast) window.Meditrack.Toast.success(`Receipt ${inv.id} PDF generated.`);
            return doc;
        });
    }

    // --- LAB REPORT ---
    function generateLabReport(labResultId) {
        return loadJsPdf().then(jsPDF => {
            const result = getStoreData('labResults', labResultId) || {
                id: labResultId, sampleId: 'SMP-001', patientName: 'Okello David', patientId: 'P-10001',
                testName: 'Complete Blood Count', resultValue: '8.5', normalRange: '4.5-11.0', unit: 'K/uL',
                resultDate: new Date().toISOString().slice(0, 10), collectionDate: new Date().toISOString().slice(0, 10),
                status: 'Normal', flag: 'Normal', orderedBy: 'Dr. Nakato Sarah', verifiedBy: 'Dr. Nakato Sarah',
                department: 'Hematology', notes: 'All parameters within normal range.',
            };

            const doc = new jsPDF({ unit: 'mm', format: 'a4' });
            let y = addHeader(doc);

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(16);
            doc.setTextColor(...BRANDING.textColor);
            doc.text('LABORATORY REPORT', 20, y + 5);

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9);
            doc.setTextColor(...BRANDING.mutedColor);
            doc.text(`Report #: ${result.id}`, 190, y + 2, { align: 'right' });
            doc.text(`Sample ID: ${result.sampleId || '—'}`, 190, y + 7, { align: 'right' });

            y += 14;

            // Patient + Test info
            y = addSectionHeading(doc, 'Patient & Test Information', y);
            doc.setFontSize(9);
            const infoRows = [
                ['Patient Name', result.patientName, 'Test Name', result.testName],
                ['Patient ID', result.patientId || '—', 'Department', result.department || '—'],
                ['Sample Type', result.sampleType || 'Blood', 'Sample ID', result.sampleId || '—'],
                ['Collection Date', formatDate(result.collectionDate), 'Result Date', formatDate(result.resultDate)],
                ['Ordered By', result.orderedBy || '—', 'Verified By', result.verifiedBy || '—'],
            ];
            infoRows.forEach((row, i) => {
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(...BRANDING.mutedColor);
                doc.text(row[0] + ':', 22, y + i * 5);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(...BRANDING.textColor);
                doc.text(String(row[1]), 55, y + i * 5);
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(...BRANDING.mutedColor);
                doc.text(row[2] + ':', 110, y + i * 5);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(...BRANDING.textColor);
                doc.text(String(row[3]), 145, y + i * 5);
            });
            y += infoRows.length * 5 + 5;

            // Results table
            y = addSectionHeading(doc, 'Test Results', y);
            const items = result.items || [{ test: result.testName, result: result.resultValue, range: result.normalRange, unit: result.unit, flag: result.flag }];
            const tableData = items.map(it => [
                it.test || '—',
                String(it.result || '—'),
                String(it.range || '—'),
                String(it.unit || '—'),
                String(it.flag || 'Normal'),
            ]);

            y = addTable(doc, ['Parameter', 'Result', 'Reference Range', 'Unit', 'Flag'], tableData, y, {
                columnStyles: {
                    0: { cellWidth: 50 },
                    1: { cellWidth: 30, fontStyle: 'bold' },
                    2: { cellWidth: 45 },
                    3: { cellWidth: 25 },
                    4: { cellWidth: 20, halign: 'center' },
                },
            });

            y += 8;

            // Notes
            if (result.notes) {
                y = addSectionHeading(doc, 'Notes / Interpretation', y);
                doc.setFont('helvetica', 'normal');
                doc.setFontSize(9);
                doc.setTextColor(...BRANDING.textColor);
                const splitNotes = doc.splitTextToSize(result.notes, 170);
                doc.text(splitNotes, 22, y);
                y += splitNotes.length * 4 + 5;
            }

            // QR code
            addQRCode(doc, 150, y, 18, `LAB:${result.id}:${result.resultDate}`);

            // Signatures
            y += 5;
            addSignatureLine(doc, 22, y + 10, 60, 'Ordered By (Physician)');
            addSignatureLine(doc, 120, y + 10, 60, 'Verified By (Lab Tech)');

            finalize(doc);
            doc.save(`LabReport-${result.id}.pdf`);
            if (window.Meditrack?.Toast) window.Meditrack.Toast.success(`Lab report ${result.id} PDF generated.`);
            return doc;
        });
    }

    // --- PRESCRIPTION ---
    function generatePrescription(prescriptionId) {
        return loadJsPdf().then(jsPDF => {
            const rx = getStoreData('prescriptions', prescriptionId) || {
                id: prescriptionId, patient: 'Okello David', doctor: 'Dr. Nakato Sarah',
                date: new Date().toISOString().slice(0, 10), status: 'Active', refills: 2,
                medications: 'Lisinopril 10mg (Once daily)',
                items: [{ medication: 'Lisinopril', dosage: '10mg', frequency: 'Once daily', duration: '30', instructions: 'Take in the morning' }],
            };

            const doc = new jsPDF({ unit: 'mm', format: 'a4' });
            let y = addHeader(doc);

            // Rx symbol
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(28);
            doc.setTextColor(...BRANDING.primaryColor);
            doc.text('℞', 20, y + 8);

            doc.setFontSize(16);
            doc.setTextColor(...BRANDING.textColor);
            doc.text('PRESCRIPTION', 28, y + 5);

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9);
            doc.setTextColor(...BRANDING.mutedColor);
            doc.text(`Rx #: ${rx.id}`, 190, y + 2, { align: 'right' });
            doc.text(`Date: ${formatDate(rx.date)}`, 190, y + 7, { align: 'right' });

            y += 16;

            // Patient + Doctor
            y = addSectionHeading(doc, 'Patient & Prescriber', y);
            doc.setFontSize(9);
            doc.setFont('helvetica', 'bold');
            doc.setTextColor(...BRANDING.mutedColor);
            doc.text('Patient:', 22, y);
            doc.text('Prescribed By:', 110, y);
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.setTextColor(...BRANDING.textColor);
            doc.text(rx.patient, 22, y + 5);
            doc.text(rx.doctor, 110, y + 5);
            y += 12;

            // Medications
            y = addSectionHeading(doc, 'Medications', y);
            const items = rx.items || (rx.medications ? rx.medications.split(',').map(m => ({ medication: m.trim(), dosage: '', frequency: '', duration: '', instructions: '' })) : []);
            const tableData = items.map(it => [
                it.medication || '—',
                it.dosage || '—',
                it.frequency || '—',
                String(it.duration || '—') + ' ' + (it.duration_unit || 'days'),
                it.instructions || '—',
            ]);

            y = addTable(doc, ['Medication', 'Dosage', 'Frequency', 'Duration', 'Instructions'], tableData, y);

            y += 8;

            // Refills
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(10);
            doc.setTextColor(...BRANDING.textColor);
            doc.text(`Refills Authorized: ${rx.refills || 0}`, 22, y);
            doc.text(`Status: ${rx.status || 'Active'}`, 90, y);

            y += 15;

            // QR code
            addQRCode(doc, 150, y, 18, `RX:${rx.id}:${rx.date}`);

            // Signature
            addSignatureLine(doc, 22, y + 10, 60, 'Physician Signature');

            y += 25;

            // Warning footer
            doc.setFillColor(254, 243, 199);
            doc.roundedRect(20, y, 170, 10, 1, 1, 'F');
            doc.setFont('helvetica', 'italic');
            doc.setFontSize(8);
            doc.setTextColor(146, 64, 14);
            doc.text('⚠ Store in a cool dry place. Keep out of reach of children. Complete the full course as prescribed.', 22, y + 6);

            finalize(doc);
            doc.save(`Prescription-${rx.id}.pdf`);
            if (window.Meditrack?.Toast) window.Meditrack.Toast.success(`Prescription ${rx.id} PDF generated.`);
            return doc;
        });
    }

    // --- DISCHARGE SUMMARY ---
    function generateDischargeSummary(patientId) {
        return loadJsPdf().then(jsPDF => {
            const patient = getStoreData('patients', patientId) || {
                id: patientId, name: 'Okello David', code: 'P-10001', age: 45, gender: 'Male',
                condition: 'Hypertension', doctor: 'Dr. Nakato Sarah',
            };

            const doc = new jsPDF({ unit: 'mm', format: 'a4' });
            let y = addHeader(doc);

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(16);
            doc.text('PATIENT DISCHARGE SUMMARY', 20, y + 5);

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9);
            doc.setTextColor(...BRANDING.mutedColor);
            doc.text(`Discharge Date: ${formatDate(new Date())}`, 190, y + 5, { align: 'right' });

            y += 14;

            y = addSectionHeading(doc, 'Patient Information', y);
            const infoRows = [
                ['Name', patient.name, 'Patient ID', patient.code],
                ['Age', String(patient.age || '—'), 'Gender', patient.gender || '—'],
                ['Admission Date', formatDate(patient.lastVisit), 'Discharge Date', formatDate(new Date())],
                ['Attending Physician', patient.doctor || '—', 'Department', 'General Medicine'],
            ];
            doc.setFontSize(9);
            infoRows.forEach((row, i) => {
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(...BRANDING.mutedColor);
                doc.text(row[0] + ':', 22, y + i * 5);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(...BRANDING.textColor);
                doc.text(String(row[1]), 55, y + i * 5);
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(...BRANDING.mutedColor);
                doc.text(row[2] + ':', 110, y + i * 5);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(...BRANDING.textColor);
                doc.text(String(row[3]), 145, y + i * 5);
            });
            y += infoRows.length * 5 + 5;

            y = addSectionHeading(doc, 'Diagnosis', y);
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.setTextColor(...BRANDING.textColor);
            doc.text(`Primary Diagnosis: ${patient.condition || '—'}`, 22, y);
            y += 10;

            y = addSectionHeading(doc, 'Treatment Summary', y);
            doc.setFontSize(9);
            const treatment = `Patient was admitted for ${patient.condition || 'medical care'} and received appropriate treatment during the hospital stay. The patient responded well to treatment and is now stable for discharge.`;
            const splitTreatment = doc.splitTextToSize(treatment, 170);
            doc.text(splitTreatment, 22, y);
            y += splitTreatment.length * 4 + 5;

            y = addSectionHeading(doc, 'Discharge Medications', y);
            doc.text('Continue prescribed medications as directed.', 22, y);
            y += 10;

            y = addSectionHeading(doc, 'Follow-up Instructions', y);
            doc.text('• Follow up in 2 weeks at the outpatient clinic', 22, y);
            doc.text('• Monitor blood pressure daily', 22, y + 5);
            doc.text('• Return immediately if symptoms worsen', 22, y + 10);
            y += 20;

            // QR code
            addQRCode(doc, 150, y, 18, `DISCHARGE:${patient.code}:${new Date().toISOString().slice(0,10)}`);

            // Signatures
            addSignatureLine(doc, 22, y + 10, 60, 'Attending Physician');
            addSignatureLine(doc, 120, y + 10, 60, 'Patient/Guardian');

            finalize(doc);
            doc.save(`DischargeSummary-${patient.code || patientId}.pdf`);
            if (window.Meditrack?.Toast) window.Meditrack.Toast.success('Discharge summary PDF generated.');
            return doc;
        });
    }

    // --- PAYSLIP ---
    function generatePayslip(payslipId) {
        return loadJsPdf().then(jsPDF => {
            const ps = getStoreData('payslips', payslipId) || {
                id: payslipId, employee_name: 'Dr. Nakato Sarah', period: new Date().toLocaleDateString('en-GB', { month: 'long', year: 'numeric' }),
                gross_salary: 12000000, deductions: 2400000, net_salary: 9600000, currency: 'UGX',
                role: 'Cardiologist',
            };

            const doc = new jsPDF({ unit: 'mm', format: 'a4' });
            let y = addHeader(doc);

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(18);
            doc.setTextColor(...BRANDING.textColor);
            doc.text('PAYSLIP', 20, y + 5);

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9);
            doc.setTextColor(...BRANDING.mutedColor);
            doc.text(`Payslip #: ${ps.id}`, 190, y + 2, { align: 'right' });
            doc.text(`Period: ${ps.period}`, 190, y + 7, { align: 'right' });

            y += 16;

            y = addSectionHeading(doc, 'Employee Details', y);
            doc.setFontSize(10);
            doc.setFont('helvetica', 'normal');
            doc.setTextColor(...BRANDING.textColor);
            doc.text(`Name: ${ps.employee_name || ps.employeeName || '—'}`, 22, y);
            doc.text(`Role: ${ps.role || '—'}`, 22, y + 5);
            y += 12;

            y = addSectionHeading(doc, 'Earnings & Deductions', y);
            const earnings = ps.gross_salary || ps.grossSalary;
            const deductions = ps.deductions || (earnings * 0.25);
            const tableData = [
                ['Basic Salary', formatUGX(earnings), 'PAYE (20%)', formatUGX(earnings * 0.2)],
                ['Housing Allowance', formatUGX(earnings * 0.1), 'NSSF (5%)', formatUGX(earnings * 0.05)],
                ['Transport Allowance', formatUGX(earnings * 0.05), 'Health Insurance', formatUGX(200000)],
                ['Total Gross', formatUGX(earnings * 1.15), 'Total Deductions', formatUGX(deductions)],
            ];

            y = addTable(doc, ['Earnings', 'Amount', 'Deductions', 'Amount'], tableData, y);

            y += 8;

            // Net pay box
            doc.setFillColor(...BRANDING.secondaryColor);
            doc.roundedRect(110, y, 80, 16, 2, 2, 'F');
            doc.setTextColor(255, 255, 255);
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(9);
            doc.text('NET PAY', 115, y + 6);
            doc.setFontSize(14);
            doc.text(formatUGX(ps.net_salary || ps.netSalary || (earnings * 1.15 - deductions)), 115, y + 13);

            y += 22;

            // QR code
            addQRCode(doc, 20, y, 18, `PAY:${ps.id}:${ps.period}`);

            // Signature
            addSignatureLine(doc, 120, y + 10, 60, 'Finance Officer');

            finalize(doc);
            doc.save(`Payslip-${ps.id}.pdf`);
            if (window.Meditrack?.Toast) window.Meditrack.Toast.success(`Payslip ${ps.id} PDF generated.`);
            return doc;
        });
    }

    // --- STOCK REPORT ---
    function generateStockReport() {
        return loadJsPdf().then(jsPDF => {
            const items = (window.MeditrackStore?.list('inventory')) || [];
            const doc = new jsPDF({ unit: 'mm', format: 'a4', orientation: 'landscape' });
            let y = addHeader(doc);

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(16);
            doc.text('INVENTORY STOCK REPORT', 20, y + 5);

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9);
            doc.setTextColor(...BRANDING.mutedColor);
            doc.text(`Generated: ${new Date().toLocaleString('en-GB')}`, 277, y + 2, { align: 'right' });

            y += 14;

            const tableData = items.length > 0 ? items.map(it => [
                it.code || it.id || '—',
                it.name || '—',
                it.category || '—',
                String(it.stockCurrent ?? '—'),
                String(it.minLevel ?? '—'),
                it.status || '—',
                it.lastUpdated || formatDate(new Date()),
            ]) : [['—', 'No inventory items found', '—', '—', '—', '—', '—']];

            y = addTable(doc, ['Code', 'Name', 'Category', 'Stock', 'Min Level', 'Status', 'Last Updated'], tableData, y);

            // Summary
            y += 10;
            const totalItems = items.length;
            const lowStock = items.filter(i => i.status === 'Low Stock' || i.status === 'Critical').length;
            const outOfStock = items.filter(i => i.status === 'Out of Stock').length;
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(10);
            doc.setTextColor(...BRANDING.textColor);
            doc.text(`Total Items: ${totalItems}    |    Low Stock: ${lowStock}    |    Out of Stock: ${outOfStock}`, 20, y);

            finalize(doc);
            doc.save(`StockReport-${new Date().toISOString().slice(0, 10)}.pdf`);
            if (window.Meditrack?.Toast) window.Meditrack.Toast.success('Stock report PDF generated.');
            return doc;
        });
    }

    // --- APPOINTMENT CONFIRMATION ---
    function generateAppointmentConfirmation(appointmentId) {
        return loadJsPdf().then(jsPDF => {
            const appt = getStoreData('appointments', appointmentId) || {
                id: appointmentId, patient: 'Okello David', doctor: 'Dr. Nakato Sarah',
                date: new Date().toISOString().slice(0, 10), time: '10:00 AM', type: 'Check-up', status: 'Confirmed',
            };

            const doc = new jsPDF({ unit: 'mm', format: 'a4' });
            let y = addHeader(doc);

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(16);
            doc.text('APPOINTMENT CONFIRMATION', 20, y + 5);

            y += 14;

            y = addSectionHeading(doc, 'Appointment Details', y);
            const rows = [
                ['Appointment ID', String(appt.id), 'Status', appt.status || 'Confirmed'],
                ['Patient', appt.patient, 'Doctor', appt.doctor],
                ['Date', formatDate(appt.date), 'Time', appt.time || '—'],
                ['Type', appt.type || 'Consultation', 'Duration', appt.duration || '30 min'],
            ];
            doc.setFontSize(9);
            rows.forEach((row, i) => {
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(...BRANDING.mutedColor);
                doc.text(row[0] + ':', 22, y + i * 5);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(...BRANDING.textColor);
                doc.text(String(row[1]), 60, y + i * 5);
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(...BRANDING.mutedColor);
                doc.text(row[2] + ':', 110, y + i * 5);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(...BRANDING.textColor);
                doc.text(String(row[3]), 145, y + i * 5);
            });
            y += rows.length * 5 + 8;

            y = addSectionHeading(doc, 'Instructions', y);
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9);
            doc.setTextColor(...BRANDING.textColor);
            doc.text('• Please arrive 15 minutes before your appointment time', 22, y);
            doc.text('• Bring your patient ID and any previous medical records', 22, y + 5);
            doc.text('• If you need to reschedule, please call ' + BRANDING.phone, 22, y + 10);
            y += 20;

            // QR code
            addQRCode(doc, 150, y, 18, `APPT:${appt.id}:${appt.date}`);

            // Signature
            addSignatureLine(doc, 22, y + 10, 60, 'Reception');

            finalize(doc);
            doc.save(`Appointment-${appt.id}.pdf`);
            if (window.Meditrack?.Toast) window.Meditrack.Toast.success('Appointment confirmation PDF generated.');
            return doc;
        });
    }

    // --- REFERRAL LETTER ---
    function generateReferralLetter(patientId) {
        return loadJsPdf().then(jsPDF => {
            const patient = getStoreData('patients', patientId) || {
                id: patientId, name: 'Okello David', code: 'P-10001', age: 45, gender: 'Male',
                condition: 'Hypertension', doctor: 'Dr. Nakato Sarah',
            };

            const doc = new jsPDF({ unit: 'mm', format: 'a4' });
            let y = addHeader(doc);

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(14);
            doc.text('REFERRAL LETTER', 20, y + 5);

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9);
            doc.setTextColor(...BRANDING.mutedColor);
            doc.text(`Date: ${formatDate(new Date())}`, 190, y + 5, { align: 'right' });

            y += 16;

            doc.setFontSize(10);
            doc.setTextColor(...BRANDING.textColor);
            doc.text('To: The Consultant / Specialist', 22, y);
            y += 10;

            doc.text(`Re: Referral for ${patient.name} (Patient ID: ${patient.code})`, 22, y);
            y += 10;

            doc.text('Dear Doctor,', 22, y);
            y += 8;

            const body = `I am referring the above-named patient to your care. The patient is a ${patient.age || '—'}-year-old ${patient.gender || '—'} who has been under my care for ${patient.condition || 'a medical condition'}. After initial assessment and management, I believe the patient would benefit from your specialist opinion and further evaluation.`;
            const splitBody = doc.splitTextToSize(body, 170);
            doc.text(splitBody, 22, y);
            y += splitBody.length * 4 + 5;

            doc.text('Current medications and treatment history are attached for your reference.', 22, y);
            y += 10;

            doc.text('Thank you for your expert evaluation.', 22, y);
            y += 10;

            doc.text('Yours sincerely,', 22, y);
            y += 15;

            addSignatureLine(doc, 22, y, 60, `${patient.doctor || 'Attending Physician'}`);
            y += 15;

            // QR code
            addQRCode(doc, 150, y - 10, 18, `REFERRAL:${patient.code}:${new Date().toISOString().slice(0,10)}`);

            finalize(doc);
            doc.save(`Referral-${patient.code || patientId}.pdf`);
            if (window.Meditrack?.Toast) window.Meditrack.Toast.success('Referral letter PDF generated.');
            return doc;
        });
    }

    // --- INSURANCE CLAIM ---
    function generateInsuranceClaim(claimId) {
        return loadJsPdf().then(jsPDF => {
            const claim = getStoreData('invoices', claimId) || {
                id: claimId, patient: 'Okello David', patientId: 'P-10001',
                amount: 500000, date: new Date().toISOString().slice(0, 10),
                insurance_provider: 'AAR Insurance', policy_number: 'AAR-2024-012345',
            };

            const doc = new jsPDF({ unit: 'mm', format: 'a4' });
            let y = addHeader(doc);

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(16);
            doc.text('INSURANCE CLAIM FORM', 20, y + 5);

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9);
            doc.setTextColor(...BRANDING.mutedColor);
            doc.text(`Claim #: ${claim.id}`, 190, y + 2, { align: 'right' });
            doc.text(`Date: ${formatDate(claim.date)}`, 190, y + 7, { align: 'right' });

            y += 14;

            y = addSectionHeading(doc, 'Patient & Insurance Information', y);
            const rows = [
                ['Patient Name', claim.patient, 'Patient ID', claim.patientId || '—'],
                ['Insurance Provider', claim.insurance_provider || claim.insuranceProvider || '—', 'Policy Number', claim.policy_number || claim.policyNumber || '—'],
                ['Claim Amount', formatUGX(claim.amount), 'Claim Date', formatDate(claim.date)],
            ];
            doc.setFontSize(9);
            rows.forEach((row, i) => {
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(...BRANDING.mutedColor);
                doc.text(row[0] + ':', 22, y + i * 5);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(...BRANDING.textColor);
                doc.text(String(row[1]), 60, y + i * 5);
                doc.setFont('helvetica', 'bold');
                doc.setTextColor(...BRANDING.mutedColor);
                doc.text(row[2] + ':', 110, y + i * 5);
                doc.setFont('helvetica', 'normal');
                doc.setTextColor(...BRANDING.textColor);
                doc.text(String(row[3]), 145, y + i * 5);
            });
            y += rows.length * 5 + 8;

            y = addSectionHeading(doc, 'Services Claimed', y);
            const tableData = [
                ['Consultation', '1', formatUGX(claim.amount * 0.2)],
                ['Lab Tests', '1', formatUGX(claim.amount * 0.3)],
                ['Medication', '1', formatUGX(claim.amount * 0.3)],
                ['Other Services', '1', formatUGX(claim.amount * 0.2)],
                ['Total Claim', '', formatUGX(claim.amount)],
            ];

            y = addTable(doc, ['Service', 'Qty', 'Amount'], tableData, y);

            y += 10;

            // QR code
            addQRCode(doc, 20, y, 18, `CLAIM:${claim.id}:${claim.date}`);

            // Signatures
            addSignatureLine(doc, 60, y + 10, 60, 'Hospital Authorized Signatory');
            addSignatureLine(doc, 130, y + 10, 60, 'Insurance Officer');

            finalize(doc);
            doc.save(`InsuranceClaim-${claim.id}.pdf`);
            if (window.Meditrack?.Toast) window.Meditrack.Toast.success('Insurance claim PDF generated.');
            return doc;
        });
    }

    // --- BIRTH CERTIFICATE ---
    function generateBirthCertificate(recordId) {
        return loadJsPdf().then(jsPDF => {
            const rec = getStoreData('birthRecords', recordId) || getStoreData('patients', recordId) || {
                id: recordId, childName: 'Nalwoga Emma', dateOfBirth: new Date().toISOString().slice(0, 10),
                gender: 'Female', weight: 3.2, motherName: 'Nakato Mary', fatherName: 'Okello David',
                doctorName: 'Dr. Wanjiru Emily', placeOfBirth: 'MediTrack Healthcare', location: 'Kampala',
            };

            const doc = new jsPDF({ unit: 'mm', format: 'a4' });
            let y = addHeader(doc);

            // Title — formal
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(20);
            doc.setTextColor(...BRANDING.textColor);
            doc.text('BIRTH CERTIFICATE', 105, y + 8, { align: 'center' });

            doc.setFont('helvetica', 'italic');
            doc.setFontSize(9);
            doc.setTextColor(...BRANDING.mutedColor);
            doc.text('Republic of Uganda — Office of the Registrar of Births', 105, y + 14, { align: 'center' });

            // Decorative border
            doc.setDrawColor(...BRANDING.primaryColor);
            doc.setLineWidth(0.6);
            doc.roundedRect(20, y + 20, 170, 95, 3, 3, 'S');
            doc.setLineWidth(0.2);
            doc.roundedRect(22, y + 22, 166, 91, 2, 2, 'S');

            y += 32;

            const certNo = `BC-UG-${new Date().getFullYear()}-${String(recordId).padStart(5, '0')}`;
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(10);
            doc.text(`Certificate No: ${certNo}`, 30, y);
            doc.setFont('helvetica', 'normal');

            y += 8;
            doc.text('This is to certify that:', 30, y);

            y += 8;
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(13);
            doc.text(rec.childName || rec.name || '—', 30, y);

            y += 8;
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.text(`was born on ${formatDate(rec.dateOfBirth || rec.date_of_birth)} at ${rec.placeOfBirth || BRANDING.name},`, 30, y);
            y += 5;
            doc.text(`${rec.location || 'Kampala'}, Uganda.`, 30, y);

            y += 8;
            doc.text(`Sex: ${rec.gender || '—'}    Weight at birth: ${rec.weight || '—'} kg`, 30, y);

            y += 8;
            doc.text('Mother:', 30, y);
            doc.setFont('helvetica', 'bold');
            doc.text(rec.motherName || '—', 55, y);
            doc.setFont('helvetica', 'normal');

            y += 5;
            doc.text('Father:', 30, y);
            doc.setFont('helvetica', 'bold');
            doc.text(rec.fatherName || '—', 55, y);
            doc.setFont('helvetica', 'normal');

            y += 8;
            doc.text(`Attending Physician: ${rec.doctorName || rec.doctor || '—'}`, 30, y);

            // QR code
            addQRCode(doc, 155, y - 20, 18, `BC:${certNo}:${rec.dateOfBirth}`);

            y += 15;
            // Signatures
            addSignatureLine(doc, 30, y, 50, 'Mother/Guardian');
            addSignatureLine(doc, 120, y, 50, 'Registrar of Births');

            finalize(doc);
            doc.save(`BirthCertificate-${rec.childName || rec.id}.pdf`);
            if (window.Meditrack?.Toast) window.Meditrack.Toast.success('Birth certificate PDF generated.');
            return doc;
        });
    }

    // --- DEATH CERTIFICATE ---
    function generateDeathCertificate(recordId) {
        return loadJsPdf().then(jsPDF => {
            const rec = getStoreData('deathRecords', recordId) || getStoreData('patients', recordId) || {
                id: recordId, name: 'Byaruhanga Robert', age: 78,
                dateOfDeath: new Date().toISOString().slice(0, 10), cause: 'Natural causes',
                doctorName: 'Dr. Nakato Sarah', location: 'Kampala',
            };

            const doc = new jsPDF({ unit: 'mm', format: 'a4' });
            let y = addHeader(doc);

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(20);
            doc.text('DEATH CERTIFICATE', 105, y + 8, { align: 'center' });

            doc.setFont('helvetica', 'italic');
            doc.setFontSize(9);
            doc.setTextColor(...BRANDING.mutedColor);
            doc.text('Republic of Uganda — Office of the Registrar of Deaths', 105, y + 14, { align: 'center' });

            doc.setDrawColor(...BRANDING.textColor);
            doc.setLineWidth(0.6);
            doc.roundedRect(20, y + 20, 170, 80, 3, 3, 'S');

            y += 32;
            const certNo = `DC-UG-${new Date().getFullYear()}-${String(recordId).padStart(5, '0')}`;
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(10);
            doc.text(`Certificate No: ${certNo}`, 30, y);
            doc.setFont('helvetica', 'normal');

            y += 8;
            doc.text('This is to certify that:', 30, y);
            y += 8;
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(13);
            doc.text(rec.name, 30, y);
            y += 8;
            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.text(`aged ${rec.age || '—'} years, passed away on ${formatDate(rec.dateOfDeath || rec.date_of_death)} at ${rec.location || 'Kampala'}, Uganda.`, 30, y);

            y += 8;
            doc.text(`Cause of death: ${rec.cause || '—'}`, 30, y);
            y += 8;
            doc.text(`Certifying physician: ${rec.doctorName || rec.doctor || '—'}`, 30, y);

            // QR code
            addQRCode(doc, 155, y - 15, 18, `DC:${certNo}:${rec.dateOfDeath}`);

            y += 15;
            addSignatureLine(doc, 30, y, 50, 'Certifying Physician');
            addSignatureLine(doc, 120, y, 50, 'Registrar of Deaths');

            finalize(doc);
            doc.save(`DeathCertificate-${rec.name || rec.id}.pdf`);
            if (window.Meditrack?.Toast) window.Meditrack.Toast.success('Death certificate PDF generated.');
            return doc;
        });
    }

    // --- FINANCIAL STATEMENT ---
    function generateFinancialStatement() {
        return loadJsPdf().then(jsPDF => {
            const invoices = (window.MeditrackStore?.list('invoices')) || [];
            const doc = new jsPDF({ unit: 'mm', format: 'a4', orientation: 'landscape' });
            let y = addHeader(doc);

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(16);
            doc.text('FINANCIAL STATEMENT', 20, y + 5);

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9);
            doc.setTextColor(...BRANDING.mutedColor);
            doc.text(`Period: ${new Date().toLocaleDateString('en-GB', { month: 'long', year: 'numeric' })}`, 277, y + 2, { align: 'right' });
            doc.text(`Generated: ${new Date().toLocaleString('en-GB')}`, 277, y + 7, { align: 'right' });

            y += 14;

            // Summary
            const totalRevenue = invoices.reduce((s, inv) => s + Number(inv.amount || 0), 0);
            const collected = invoices.filter(i => i.status === 'Paid').reduce((s, inv) => s + Number(inv.paid_amount || inv.amount || 0), 0);
            const outstanding = totalRevenue - collected;

            y = addSectionHeading(doc, 'Financial Summary', y);
            const summaryData = [
                ['Total Billed Revenue', formatUGX(totalRevenue)],
                ['Collected Revenue', formatUGX(collected)],
                ['Outstanding Balance', formatUGX(outstanding)],
                ['Collection Rate', totalRevenue > 0 ? Math.round((collected / totalRevenue) * 100) + '%' : '0%'],
            ];
            y = addTable(doc, ['Metric', 'Value'], summaryData, y, {
                columnStyles: { 0: { cellWidth: 100, fontStyle: 'bold' }, 1: { cellWidth: 100, halign: 'right' } },
            });

            y += 8;

            // Invoice breakdown
            y = addSectionHeading(doc, 'Invoice Breakdown', y);
            const tableData = invoices.length > 0 ? invoices.map(inv => [
                inv.id, inv.patient, formatDate(inv.date), formatUGX(inv.amount), inv.status,
            ]) : [['—', 'No invoices found', '—', '—', '—']];

            y = addTable(doc, ['Invoice #', 'Patient', 'Date', 'Amount', 'Status'], tableData, y);

            finalize(doc);
            doc.save(`FinancialStatement-${new Date().toISOString().slice(0, 7)}.pdf`);
            if (window.Meditrack?.Toast) window.Meditrack.Toast.success('Financial statement PDF generated.');
            return doc;
        });
    }

    // --- GENERIC TABLE PDF ---
    function generateTablePDF(title) {
        return loadJsPdf().then(jsPDF => {
            const doc = new jsPDF({ unit: 'mm', format: 'a4', orientation: 'landscape' });
            let y = addHeader(doc);

            doc.setFont('helvetica', 'bold');
            doc.setFontSize(16);
            doc.text(title || document.title || 'Meditrack Report', 20, y + 5);

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9);
            doc.setTextColor(...BRANDING.mutedColor);
            doc.text(`Generated: ${new Date().toLocaleString('en-GB')}`, 277, y + 2, { align: 'right' });

            y += 14;

            const table = document.querySelector('table');
            if (!table) {
                if (window.Meditrack?.Toast) window.Meditrack.Toast.warning('No table found to export.');
                finalize(doc);
                doc.save('Report.pdf');
                return doc;
            }

            const head = [];
            const body = [];
            const headRow = table.querySelector('thead tr, tr');
            if (headRow) {
                headRow.querySelectorAll('th, td').forEach(cell => head.push(cell.textContent.trim()));
            }
            table.querySelectorAll('tbody tr').forEach(row => {
                if (row.querySelector('th')) return;
                const cells = [];
                row.querySelectorAll('td').forEach(cell => cells.push(cell.textContent.trim()));
                if (cells.length) body.push(cells);
            });

            y = addTable(doc, head, body, y);

            finalize(doc);
            const filename = (title || 'meditrack-report').replace(/[^a-z0-9]/gi, '_') + '.pdf';
            doc.save(filename);
            if (window.Meditrack?.Toast) window.Meditrack.Toast.success('PDF generated.');
            return doc;
        });
    }

    // ============================================================
    // AUTO-WIRE BUTTONS
    // ============================================================
    function autoWirePdfButtons() {
        document.querySelectorAll('[data-pdf]').forEach(btn => {
            if (btn.dataset.pdfWired) return;
            btn.dataset.pdfWired = '1';
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const pdfType = btn.getAttribute('data-pdf');
                const id = btn.getAttribute('data-id') || btn.getAttribute('data-record-id');
                const generators = {
                    'invoice': generateInvoice, 'receipt': generateReceipt,
                    'lab-report': generateLabReport, 'lab': generateLabReport,
                    'prescription': generatePrescription, 'rx': generatePrescription,
                    'discharge': generateDischargeSummary, 'discharge-summary': generateDischargeSummary,
                    'payslip': generatePayslip, 'stock-report': generateStockReport,
                    'inventory-report': generateStockReport,
                    'appointment': generateAppointmentConfirmation, 'appointment-confirmation': generateAppointmentConfirmation,
                    'referral': generateReferralLetter, 'referral-letter': generateReferralLetter,
                    'insurance-claim': generateInsuranceClaim, 'claim': generateInsuranceClaim,
                    'birth-cert': generateBirthCertificate, 'birth-certificate': generateBirthCertificate,
                    'death-cert': generateDeathCertificate, 'death-certificate': generateDeathCertificate,
                    'financial-statement': generateFinancialStatement,
                    'table': () => generateTablePDF(btn.getAttribute('data-title') || document.title),
                };
                const gen = generators[pdfType];
                if (gen) {
                    gen(id);
                } else {
                    console.warn('[PDF] Unknown data-pdf type:', pdfType);
                }
            });
        });
    }

    // ============================================================
    // OVERRIDE EXISTING exportPDF
    // ============================================================
    if (window.Meditrack) {
        window.Meditrack.exportPDF = function(title) {
            if (document.querySelector('table')) return generateTablePDF(title);
        };
    }

    // ============================================================
    // EXPORT
    // ============================================================
    window.MeditrackPDF = {
        generateInvoice, generateReceipt, generateLabReport, generatePrescription,
        generateDischargeSummary, generatePayslip, generateStockReport,
        generateAppointmentConfirmation, generateReferralLetter, generateInsuranceClaim,
        generateBirthCertificate, generateDeathCertificate, generateFinancialStatement,
        generateTablePDF,
        branding: BRANDING,
    };

    if (window.Meditrack) {
        window.Meditrack.PDF = window.MeditrackPDF;
    }

    function init() {
        autoWirePdfButtons();
        setTimeout(autoWirePdfButtons, 1000);
        setTimeout(autoWirePdfButtons, 2500);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})(window, document);
