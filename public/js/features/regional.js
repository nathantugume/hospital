// ============================================
// REGIONAL MODULE - Date, Time, Calendar & Currency
// Depends on: settings-manager.js
// ============================================
(function (window, document) {
    'use strict';

    // ----------------------------------------
    // PREFERENCE HELPERS (Strict string/bool conversion)
    // ----------------------------------------
    function getPref(key, fallback) {
        var v;
        if (window.MeditrackSettings) {
            v = window.MeditrackSettings.get(key);
        } else {
            v = localStorage.getItem('meditrack_' + key);
        }
        if (v === 'true' || v === true) return true;
        if (v === 'false' || v === false) return false;
        return (v !== undefined && v !== null && v !== 'null') ? v : fallback;
    }

    function setPref(key, value) {
        if (window.MeditrackSettings) {
            window.MeditrackSettings.set(key, value);
        } else {
            localStorage.setItem('meditrack_' + key, value);
        }
    }

    // ----------------------------------------
    // DATE FORMATTING & INTERCEPTION
    // ----------------------------------------
    var MONTH_SHORT = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

    function parseDate(str) {
        if (!str) return null;
        str = String(str).trim();
        var iso = str.match(/^(\d{4})[-\/](\d{1,2})[-\/](\d{1,2})/);
        if (iso) return new Date(+iso[1], +iso[2] - 1, +iso[3]);
        var mdy = str.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})/);
        if (mdy) return new Date(+mdy[3], +mdy[1] - 1, +mdy[2]);
        var dmy = str.match(/^(\d{1,2})-(\d{1,2})-(\d{4})/);
        if (dmy) return new Date(+dmy[3], +dmy[2] - 1, +dmy[1]);
        var txt = str.match(/^([A-Za-z]+)\.?\s+(\d{1,2}),?\s+(\d{4})/);
        if (txt) {
            var mon = MONTH_SHORT.findIndex(function(m) {
                return txt[1].toLowerCase().startsWith(m.toLowerCase());
            });
            if (mon !== -1) return new Date(+txt[3], mon, +txt[2]);
        }
        var d = new Date(str);
        return isNaN(d.getTime()) ? null : d;
    }

    function formatDateByPref(d) {
        if (!d || isNaN(d.getTime())) return '';
        var fmt = getPref('date_format', 'MM/DD/YYYY');
        var dd = String(d.getDate()).padStart(2, '0');
        var mm = String(d.getMonth() + 1).padStart(2, '0');
        var yy = d.getFullYear();
        if (fmt === 'DD/MM/YYYY') return dd + '/' + mm + '/' + yy;
        if (fmt === 'YYYY-MM-DD') return yy + '-' + mm + '-' + dd;
        return mm + '/' + dd + '/' + yy;
    }

    Object.defineProperty(window, 'formatDate', {
        get: function() {
            return function(input) {
                var d = (input instanceof Date) ? input : parseDate(String(input));
                return d ? formatDateByPref(d) : String(input);
            };
        },
        set: function() {},
        configurable: true
    });

    // ----------------------------------------
    // TIME FORMATTING
    // ----------------------------------------
    function parseTime(str) {
        if (!str) return null;
        str = String(str).trim();
        var ampm = str.match(/^(\d{1,2}):(\d{2})(?::\d{2})?\s*(AM|PM)$/i);
        if (ampm) {
            var h = +ampm[1], m = +ampm[2], ap = ampm[3].toUpperCase();
            if (ap === 'PM' && h < 12) h += 12;
            if (ap === 'AM' && h === 12) h = 0;
            return { h: h, m: m };
        }
        var h24 = str.match(/^(\d{1,2}):(\d{2})(?::\d{2})?$/);
        if (h24) return { h: +h24[1], m: +h24[2] };
        return null;
    }

    function formatTimeByPref(t) {
        if (!t) return null;
        var fmt = getPref('time_format', '12-hour (AM/PM)');
        var m = String(t.m).padStart(2, '0');
        if (fmt === '24-hour') return String(t.h).padStart(2, '0') + ':' + m;
        var ap = t.h >= 12 ? 'PM' : 'AM';
        var h12 = t.h % 12 || 12;
        return h12 + ':' + m + ' ' + ap;
    }

    Object.defineProperty(window, 'formatTime', {
        get: function() {
            return function(input) {
                if (input instanceof Date) return formatTimeByPref({ h: input.getHours(), m: input.getMinutes() });
                var t = parseTime(String(input));
                return t ? formatTimeByPref(t) : String(input);
            };
        },
        set: function() {},
        configurable: true
    });

    // ----------------------------------------
    // FIRST DAY OF WEEK (With Week View Column Reordering)
    // ----------------------------------------
    var DAY_NAMES_FULL  = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    var DAY_NAMES_SHORT = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
    var DAY_NAMES_2     = ['Su','Mo','Tu','We','Th','Fr','Sa'];
    var DAY_INDEX_MAP = {
        'Sunday':0,'Monday':1,'Tuesday':2,'Wednesday':3,'Thursday':4,'Friday':5,'Saturday':6,
        'Sun':0,'Mon':1,'Tue':2,'Wed':3,'Thu':4,'Fri':5,'Sat':6,
        'Su':0,'Mo':1,'Tu':2,'We':3,'Th':4,'Fr':5,'Sa':6
    };

    function getFirstDayIndex() {
        var pref = getPref('first_day', 'Sunday');
        if (pref === 'Monday') return 1;
        if (pref === 'Saturday') return 6;
        return 0; // Sunday default
    }

    function getOrderedDays(format) {
        var first = getFirstDayIndex();
        var names = format === 'full' ? DAY_NAMES_FULL
                  : format === '2'   ? DAY_NAMES_2
                  :                    DAY_NAMES_SHORT;
        return names.slice(first).concat(names.slice(0, first));
    }

    function detectDayFormat(text) {
        text = (text || '').trim();
        if (DAY_NAMES_FULL.indexOf(text)  !== -1) return 'full';
        if (DAY_NAMES_SHORT.indexOf(text) !== -1) return 'short';
        if (DAY_NAMES_2.indexOf(text)     !== -1) return '2';
        return null;
    }

    function getDayIndexFromName(text) {
        text = (text || '').trim();
        return (DAY_INDEX_MAP[text] !== undefined) ? DAY_INDEX_MAP[text] : -1;
    }

    function isInsideSkipContainer(el) {
        var p = el;
        while (p) {
            if (p.getAttribute && p.getAttribute('data-regional-skip') === 'true') return true;
            p = p.parentElement;
        }
        return false;
    }

    function applyFirstDayOfWeek() {
        var firstIdx     = getFirstDayIndex();
        var ordered2     = getOrderedDays('2');
        var orderedShort = getOrderedDays('short');
        var orderedFull  = getOrderedDays('full');

        // 1) Reorder day-name header rows (text rewrite only)
        document.querySelectorAll('.grid.grid-cols-7, table thead tr').forEach(function(row) {
            if (isInsideSkipContainer(row)) return;
            var cells = Array.from(row.children);
            if (cells.length !== 7) return;
            var fmt = null;
            var allDay = cells.every(function(cell) {
                var t = (cell.textContent || '').trim().split(/\n/)[0];
                var f = detectDayFormat(t);
                if (f && !fmt) fmt = f;
                return f !== null;
            });
            if (!allDay || !fmt) return;
            var ordered = fmt === 'full' ? orderedFull
                        : fmt === '2'   ? ordered2
                        :                 orderedShort;
            cells.forEach(function(cell, i) {
                var divs = cell.querySelectorAll('div');
                if (divs.length >= 1 && cell.children.length > 0) {
                    divs[0].textContent = ordered[i];
                } else {
                    cell.textContent = ordered[i];
                }
            });
        });

        // 2) Reorder Month Grid Spacers
        document.querySelectorAll('.grid.grid-cols-7').forEach(function(grid) {
            if (isInsideSkipContainer(grid)) return;
            var dateBtns = grid.querySelectorAll('[data-date]');
            if (dateBtns.length === 0) return;
            var raw = dateBtns[0].getAttribute('data-date');
            var parts = raw.split('-');
            if (parts.length < 3) return;
            var year  = parseInt(parts[0], 10);
            var month = parseInt(parts[1], 10);
            var firstOfMonth   = new Date(year, month - 1, 1).getDay();
            var leadingSpacers = (firstOfMonth - firstIdx + 7) % 7;
            var allChildren    = Array.from(grid.children);
            var spacers = allChildren.filter(function(el) {
                return el.tagName === 'DIV' && !el.hasAttribute('data-date');
            });
            var buttons = allChildren.filter(function(el) {
                return el.hasAttribute('data-date');
            });
            if (spacers.length === 0 || buttons.length === 0) return;
            var spacerTpl    = spacers[0].cloneNode(true);
            var totalCells   = leadingSpacers + buttons.length;
            var trailingCnt  = (7 - (totalCells % 7)) % 7;
            while (grid.firstChild) grid.removeChild(grid.firstChild);
            for (var i = 0; i < leadingSpacers; i++) grid.appendChild(spacerTpl.cloneNode(true));
            buttons.forEach(function(btn) { grid.appendChild(btn); });
            for (var j = 0; j < trailingCnt; j++) grid.appendChild(spacerTpl.cloneNode(true));
        });

        // 3) Generic column reordering
        applyWeekViewColumnReordering();
    }

    function applyWeekViewColumnReordering() {
        var firstIdx = getFirstDayIndex();

        var targets = document.querySelectorAll(
            '.grid-cols-7, .grid-cols-8, #weekGrid, #monthGrid'
        );

        targets.forEach(function(grid) {
            if (grid.closest('aside, header, #sidebar, #profileDropdown, #notificationsDropdown')) return;
            if (isInsideSkipContainer(grid)) return;
            if (grid.querySelector('[data-date]')) return;

            var children = Array.from(grid.children);
            if (children.length === 0) return;

            if (children.length === 7) {
                var allDayNames = children.every(function(c) {
                    var t = (c.textContent || '').trim().split(/\n/)[0];
                    return detectDayFormat(t) !== null;
                });
                if (allDayNames) return;
            }

            var rowSize;
            if (children.length === 8) {
                rowSize = 8;
            } else if (children.length % 7 === 0) {
                rowSize = 7;
            } else {
                return;
            }

            var cached = grid.__mtOriginalOrder;
            var needsCapture = !cached
                || cached.length !== children.length
                || !grid.contains(cached[0]);
            if (needsCapture) {
                grid.__mtOriginalOrder = children.slice();
                cached = grid.__mtOriginalOrder;
            }

            var reordered = [];
            var numRows = children.length / rowSize;
            for (var r = 0; r < numRows; r++) {
                var rowStart = r * rowSize;
                if (rowSize === 8) {
                    reordered.push(cached[rowStart]);
                    for (var i = 0; i < 7; i++) {
                        reordered.push(cached[rowStart + 1 + ((firstIdx + i) % 7)]);
                    }
                } else {
                    for (var k = 0; k < 7; k++) {
                        reordered.push(cached[rowStart + ((firstIdx + k) % 7)]);
                    }
                }
            }

            reordered.forEach(function(child) {
                if (child) grid.appendChild(child);
            });
        });
    }

    // ----------------------------------------
    // SHOW / HIDE WEEKENDS
    // ----------------------------------------
    function getShowWeekends() {
        return getPref('show_weekends', true);
    }

    function setShowWeekends(show) {
        setPref('show_weekends', show);
        applyShowWeekends();
        window.dispatchEvent(new CustomEvent('meditrack-weekends-changed', { detail: { show: show } }));
    }

    function applyShowWeekends() {
        var show = getShowWeekends();
        var firstIdx = getFirstDayIndex();

        var sw = document.getElementById('showWeekendsSwitch');
        if (sw) {
            var state = show ? 'checked' : 'unchecked';
            sw.setAttribute('data-state', state);
            var thumb = sw.querySelector('.switch-thumb');
            if (thumb) thumb.setAttribute('data-state', state);
        }

        var weekendColPositions = [];
        for (var col = 0; col < 7; col++) {
            var dayIdx = (firstIdx + col) % 7;
            if (dayIdx === 0 || dayIdx === 6) {
                weekendColPositions.push(col);
            }
        }

        var sevenColSelectors = '.grid.grid-cols-7, #monthView .grid, #calendarTab .grid, #monthGrid, .flatpickr-days';
        document.querySelectorAll(sevenColSelectors).forEach(function(grid) {
            if (isInsideSkipContainer(grid)) return;
            if (Array.from(grid.children).length === 8) return;

            if (!show) {
                grid.style.gridTemplateColumns = 'repeat(5, minmax(0, 1fr))';
                grid.classList.remove('grid-cols-7');
                grid.classList.add('grid-cols-5');
            } else {
                grid.style.gridTemplateColumns = '';
                grid.classList.remove('grid-cols-5');
                grid.classList.add('grid-cols-7');
            }

            Array.from(grid.children).forEach(function(cell, idx) {
                var isWeekend = false;
                var dateAttr = cell.getAttribute('data-date');
                if (dateAttr) {
                    var parts = dateAttr.split('-');
                    var dateObj = new Date(
                        parseInt(parts[0], 10),
                        parseInt(parts[1], 10) - 1,
                        parseInt(parts[2], 10)
                    );
                    isWeekend = (dateObj.getDay() === 0 || dateObj.getDay() === 6);
                } else {
                    var colPos = idx % 7;
                    isWeekend = weekendColPositions.indexOf(colPos) !== -1;
                }
                cell.style.display = (!show && isWeekend) ? 'none' : '';
            });
        });

        var eightColSelectors = '#weekView .grid, #weekGrid, .grid.grid-cols-8';
        document.querySelectorAll(eightColSelectors).forEach(function(grid) {
            if (isInsideSkipContainer(grid)) return;
            var children = Array.from(grid.children);
            if (children.length !== 8) return;

            if (!show) {
                grid.style.gridTemplateColumns = 'auto repeat(5, minmax(0, 1fr))';
                grid.classList.remove('grid-cols-8');
                grid.classList.add('grid-cols-6');
            } else {
                grid.style.gridTemplateColumns = '';
                grid.classList.remove('grid-cols-6');
                grid.classList.add('grid-cols-8');
            }

            children.forEach(function(cell, idx) {
                if (idx === 0) {
                    cell.style.display = '';
                    return;
                }
                var daySlot = idx - 1;
                var dayOfWeek = (firstIdx + daySlot) % 7;

                var isWeekend = false;
                var dateAttr = cell.getAttribute('data-date');
                if (dateAttr) {
                    var parts = dateAttr.split('-');
                    var dateObj = new Date(
                        parseInt(parts[0], 10),
                        parseInt(parts[1], 10) - 1,
                        parseInt(parts[2], 10)
                    );
                    isWeekend = (dateObj.getDay() === 0 || dateObj.getDay() === 6);
                } else {
                    var cellText = cell.textContent.trim();
                    var firstWord = cellText.split(/[\s\n]/)[0];
                    var namedDay = getDayIndexFromName(firstWord);
                    if (namedDay !== -1) {
                        isWeekend = (namedDay === 0 || namedDay === 6);
                    } else {
                        isWeekend = (dayOfWeek === 0 || dayOfWeek === 6);
                    }
                }

                cell.style.display = (!show && isWeekend) ? 'none' : '';
            });
        });

        document.querySelectorAll('table').forEach(function(table) {
            var ths = Array.from(table.querySelectorAll('thead th'));
            var weekendThIndices = [];

            ths.forEach(function(th, i) {
                var t = th.textContent.trim();
                var dayIdx = getDayIndexFromName(t);
                var isWeekendTh = (dayIdx === 0 || dayIdx === 6);
                if (isWeekendTh) {
                    weekendThIndices.push(i);
                }
                th.style.display = (!show && isWeekendTh) ? 'none' : '';
            });

            if (weekendThIndices.length > 0) {
                table.querySelectorAll('tbody tr').forEach(function(row) {
                    Array.from(row.children).forEach(function(td, i) {
                        var isWeekendCol = weekendThIndices.indexOf(i) !== -1;
                        td.style.display = (!show && isWeekendCol) ? 'none' : '';
                    });
                });
            }
        });

        document.querySelectorAll('[data-day]').forEach(function(col) {
            var day = col.getAttribute('data-day');
            var isSat = /^sat/i.test(day) || day === '6';
            var isSun = /^sun/i.test(day) || day === '0';
            col.style.display = (!show && (isSat || isSun)) ? 'none' : '';
        });

        document.querySelectorAll('#weekView .day-column, .week-day-col').forEach(function(col) {
            var heading = col.querySelector('h3, h4, .day-header');
            if (!heading) return;
            var t = heading.textContent.trim();
            var isSat = /^sat/i.test(t);
            var isSun = /^sun/i.test(t);
            col.style.display = (!show && (isSat || isSun)) ? 'none' : '';
        });

        if (!show) {
            var WEEKDAY_ORDER_FULL  = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
            var WEEKDAY_ORDER_SHORT = ['Mon','Tue','Wed','Thu','Fri'];
            var WEEKDAY_ORDER_2     = ['Mo','Tu','We','Th','Fr'];

            document.querySelectorAll('.grid.grid-cols-5, .grid.grid-cols-7').forEach(function(row) {
                if (Array.from(row.children).length === 8) return;
                var cells = Array.from(row.children).filter(function(c) {
                    return c.style.display !== 'none';
                });
                if (cells.length !== 5) return;
                var fmt = null;
                var allDay = cells.every(function(cell) {
                    var t = cell.textContent.trim();
                    var f = detectDayFormat(t);
                    if (f && !fmt) fmt = f;
                    return f !== null;
                });
                if (!allDay || !fmt) return;
                var ordered = fmt === 'full'  ? WEEKDAY_ORDER_FULL
                            : fmt === 'short' ? WEEKDAY_ORDER_SHORT
                            :                   WEEKDAY_ORDER_2;
                cells.forEach(function(cell, i) { cell.textContent = ordered[i]; });
            });

            document.querySelectorAll('#weekView .grid.grid-cols-6, #weekView .grid.grid-cols-8, #weekGrid').forEach(function(row) {
                var children = Array.from(row.children);
                if (children.length !== 8) return;
                var dayCells = children.slice(1).filter(function(c) {
                    return c.style.display !== 'none';
                });
                if (dayCells.length !== 5) return;
                var isHeaderRow = dayCells.every(function(cell) {
                    var firstWord = cell.textContent.trim().split(/[\s\n\/]/)[0];
                    return detectDayFormat(firstWord) !== null;
                });
                if (!isHeaderRow) return;
                dayCells.forEach(function(cell, i) {
                    var fullText = cell.textContent.trim();
                    var lines = fullText.split(/\n/);
                    if (lines.length > 1) {
                        lines[0] = WEEKDAY_ORDER_SHORT[i];
                        var divs = cell.querySelectorAll('div');
                        if (divs.length >= 1) {
                            divs[0].textContent = WEEKDAY_ORDER_SHORT[i];
                            return;
                        }
                        cell.textContent = lines.join('\n');
                    } else {
                        var fmt2 = detectDayFormat(fullText.split(/[\s\n\/]/)[0]);
                        var ordered2 = fmt2 === 'full'  ? WEEKDAY_ORDER_FULL
                                     : fmt2 === '2'    ? WEEKDAY_ORDER_2
                                     :                   WEEKDAY_ORDER_SHORT;
                        var divs2 = cell.querySelectorAll('div');
                        if (divs2.length >= 1) {
                            divs2[0].textContent = ordered2[i];
                        } else {
                            cell.textContent = ordered2[i];
                        }
                    }
                });
            });
        }
    }

    // ----------------------------------------
    // AGGRESSIVE DOM PARSER - DATES
    // ----------------------------------------
    var MONTH_NAMES_FULL  = ['january','february','march','april','may','june','july','august','september','october','november','december'];
    var MONTH_NAMES_SHORT = ['jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec'];

    function monthNameToIndex(name) {
        var n = (name || '').toLowerCase().slice(0, 3);
        var idx = MONTH_NAMES_SHORT.indexOf(n);
        return idx;
    }

    function formatDateRange(d1, d2) {
        return formatDateByPref(d1) + ' - ' + formatDateByPref(d2);
    }

    function formatAllDatesInNode(node) {
        if (!node) return;
        var walker = document.createTreeWalker(node, NodeFilter.SHOW_TEXT, null, false);
        var textNode;
        while (textNode = walker.nextNode()) {
            var parent = textNode.parentElement;
            if (parent) {
                var tag = parent.tagName.toLowerCase();
                if (tag === 'script' || tag === 'style' || tag === 'textarea' ||
                    parent.closest('select, option, input, button, #filterPopover, #timezoneDropdown, #dateFormatDropdown')) {
                    continue;
                }
            }

            var text = textNode.nodeValue;
            var original = text;

            // ISO date: 2023-06-12
            text = text.replace(/\b(\d{4})-(\d{2})-(\d{2})\b/g, function(match, y, m, d) {
                var dateObj = new Date(parseInt(y, 10), parseInt(m, 10) - 1, parseInt(d, 10));
                if (isNaN(dateObj.getTime())) return match;
                return formatDateByPref(dateObj);
            });

            // Slash date: 12/06/2023 or 06/12/2023
            text = text.replace(/\b(\d{1,2})\/(\d{1,2})\/(\d{4})\b/g, function(match, p1, p2, y) {
                var year = parseInt(y, 10);
                var num1 = parseInt(p1, 10);
                var num2 = parseInt(p2, 10);
                var d, m;
                if (num1 > 12) { d = num1; m = num2 - 1; }
                else if (num2 > 12) { m = num1 - 1; d = num2; }
                else { m = num1 - 1; d = num2; }
                var dateObj = new Date(year, m, d);
                if (isNaN(dateObj.getTime())) return match;
                return formatDateByPref(dateObj);
            });

            // Full month name RANGE with shared year
            text = text.replace(
                /\b(January|February|March|April|May|June|July|August|September|October|November|December)\s+(\d{1,2})\s*[-–]\s*(January|February|March|April|May|June|July|August|September|October|November|December)\s+(\d{1,2}),?\s+(\d{4})\b/gi,
                function(match, m1, d1, m2, d2, year) {
                    var mi1 = monthNameToIndex(m1), mi2 = monthNameToIndex(m2);
                    if (mi1 === -1 || mi2 === -1) return match;
                    var yr = parseInt(year, 10);
                    var date1 = new Date(yr, mi1, parseInt(d1, 10));
                    var date2 = new Date(yr, mi2, parseInt(d2, 10));
                    if (isNaN(date1.getTime()) || isNaN(date2.getTime())) return match;
                    return formatDateRange(date1, date2);
                }
            );

            // Abbreviated month RANGE with shared year
            text = text.replace(
                /\b(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s+(\d{1,2})\s*[-–]\s*(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s+(\d{1,2}),?\s+(\d{4})\b/gi,
                function(match, m1, d1, m2, d2, year) {
                    var mi1 = monthNameToIndex(m1), mi2 = monthNameToIndex(m2);
                    if (mi1 === -1 || mi2 === -1) return match;
                    var yr = parseInt(year, 10);
                    var date1 = new Date(yr, mi1, parseInt(d1, 10));
                    var date2 = new Date(yr, mi2, parseInt(d2, 10));
                    if (isNaN(date1.getTime()) || isNaN(date2.getTime())) return match;
                    return formatDateRange(date1, date2);
                }
            );

            // Full month name + day + year
            text = text.replace(
                /\b(January|February|March|April|May|June|July|August|September|October|November|December)\s+(\d{1,2}),?\s+(\d{4})\b/gi,
                function(match, monthName, day, year) {
                    var mi = monthNameToIndex(monthName);
                    if (mi === -1) return match;
                    var dateObj = new Date(parseInt(year, 10), mi, parseInt(day, 10));
                    if (isNaN(dateObj.getTime())) return match;
                    return formatDateByPref(dateObj);
                }
            );

            // Abbreviated month + day + year
            text = text.replace(
                /\b(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s+(\d{1,2}),?\s+(\d{4})\b/gi,
                function(match, monthName, day, year) {
                    var mi = monthNameToIndex(monthName);
                    if (mi === -1) return match;
                    var dateObj = new Date(parseInt(year, 10), mi, parseInt(day, 10));
                    if (isNaN(dateObj.getTime())) return match;
                    return formatDateByPref(dateObj);
                }
            );

            // Weekday prefix: "Monday, June 12, 2023"
            text = text.replace(
                /\b(Monday|Tuesday|Wednesday|Thursday|Friday|Saturday|Sunday),\s+((?:January|February|March|April|May|June|July|August|September|October|November|December|Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s+\d{1,2},?\s+\d{4})\b/gi,
                function(match, weekday, datePart) {
                    var reformatted = datePart.replace(
                        /\b(January|February|March|April|May|June|July|August|September|October|November|December|Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)\s+(\d{1,2}),?\s+(\d{4})\b/gi,
                        function(m2, monthName, day, year) {
                            var mi = monthNameToIndex(monthName);
                            if (mi === -1) return m2;
                            var dateObj = new Date(parseInt(year, 10), mi, parseInt(day, 10));
                            if (isNaN(dateObj.getTime())) return m2;
                            return formatDateByPref(dateObj);
                        }
                    );
                    return weekday + ', ' + reformatted;
                }
            );

            if (text !== original) {
                textNode.nodeValue = text;
            }
        }
    }

    // ----------------------------------------
    // AGGRESSIVE DOM PARSER - TIMES
    // ----------------------------------------
    function formatAllTimesInNode(node) {
        if (!node) return;
        var fmt = getPref('time_format', '12-hour (AM/PM)');
        var is24 = (fmt === '24-hour');
        var walker = document.createTreeWalker(node, NodeFilter.SHOW_TEXT, null, false);
        var textNode;
        while (textNode = walker.nextNode()) {
            var parent = textNode.parentElement;
            if (parent) {
                var tag = parent.tagName.toLowerCase();
                if (tag === 'script' || tag === 'style' || parent.closest('select, option, input, textarea, #timeFormatDropdown')) {
                    continue;
                }
            }

            var text = textNode.nodeValue;
            var original = text;

            // Standard AM/PM times: "9:30 AM", "10:15 PM"
            text = text.replace(/\b(\d{1,2}):(\d{2})\s*(AM|PM)\b/gi, function(match, h, m, ap) {
                var hour = parseInt(h, 10), min = parseInt(m, 10);
                ap = ap.toUpperCase();
                if (is24) {
                    if (ap === 'PM' && hour < 12) hour += 12;
                    if (ap === 'AM' && hour === 12) hour = 0;
                    return String(hour).padStart(2, '0') + ':' + String(min).padStart(2, '0');
                } else {
                    return hour + ':' + String(min).padStart(2, '0') + ' ' + ap;
                }
            });

            // Compact shift times: "7AM", "3PM", "11PM"
            text = text.replace(/\b(\d{1,2})(AM|PM)\b/gi, function(match, h, ap) {
                var hour = parseInt(h, 10);
                ap = ap.toUpperCase();
                if (is24) {
                    if (ap === 'PM' && hour < 12) hour += 12;
                    if (ap === 'AM' && hour === 12) hour = 0;
                    return String(hour).padStart(2, '0') + ':00';
                } else {
                    return hour + ':00 ' + ap;
                }
            });

            // Shift range: "7AM-3PM" or "3PM-11PM"
            text = text.replace(/\b(\d{1,2})(AM|PM)\s*[-–]\s*(\d{1,2})(AM|PM)\b/gi, function(match, h1, ap1, h2, ap2) {
                var hour1 = parseInt(h1, 10), hour2 = parseInt(h2, 10);
                ap1 = ap1.toUpperCase(); ap2 = ap2.toUpperCase();
                if (is24) {
                    if (ap1 === 'PM' && hour1 < 12) hour1 += 12;
                    if (ap1 === 'AM' && hour1 === 12) hour1 = 0;
                    if (ap2 === 'PM' && hour2 < 12) hour2 += 12;
                    if (ap2 === 'AM' && hour2 === 12) hour2 = 0;
                    return String(hour1).padStart(2, '0') + ':00 - ' + String(hour2).padStart(2, '0') + ':00';
                } else {
                    return hour1 + ':00 ' + ap1 + ' - ' + hour2 + ':00 ' + ap2;
                }
            });

            if (text !== original) {
                textNode.nodeValue = text;
            }
        }
    }

    // ============================================
    // CURRENCY FORMATTING - Aggressive DOM Parser
    // ============================================
    function getCurrencyPrefs() {
        var currency = getPref('currency', 'USD ($)');
        var symbol = '$';
        if (currency.indexOf('€') !== -1) symbol = '€';
        else if (currency.indexOf('£') !== -1) symbol = '£';
        else if (currency.indexOf('¥') !== -1) symbol = '¥';
        else if (currency.indexOf('USh') !== -1) symbol = 'UGX';
        else if (currency.indexOf('KSh') !== -1) symbol = 'KSH';
        else if (currency.indexOf('TSh') !== -1) symbol = 'TSH';
        else if (currency.indexOf('FRw') !== -1) symbol = 'FRw';
        else if (currency.indexOf('₦') !== -1) symbol = '₦';
        else if (currency.indexOf('GH₵') !== -1) symbol = 'GH₵';
        else if (currency.indexOf('R') !== -1 && currency.indexOf('RWF') === -1) symbol = 'R';
        else if (currency.indexOf('Br') !== -1) symbol = 'Br';
        
        var decimals = getPref('currency_decimals', 'auto');
        var numDecimals = 2;
        if (decimals === '0' || (typeof decimals === 'string' && decimals.indexOf('0 decimals') !== -1)) numDecimals = 0;
        else if (decimals === '2' || (typeof decimals === 'string' && decimals.indexOf('2 decimals') !== -1)) numDecimals = 2;
        else if (decimals === '4' || (typeof decimals === 'string' && decimals.indexOf('4 decimals') !== -1)) numDecimals = 4;
        
        var position = getPref('currency_position', 'before');
        var numberFormat = getPref('number_format', 'us');
        var negativeFormat = getPref('negative_format', 'minus');
        
        return {
            symbol: symbol,
            decimals: numDecimals,
            position: position,
            numberFormat: numberFormat,
            negativeFormat: negativeFormat
        };
    }

    function formatCurrencyAmount(amountStr, prefs) {
        var cleaned = String(amountStr).replace(/[^\d.\-]/g, '');
        var num = parseFloat(cleaned);
        if (isNaN(num)) return amountStr;
        
        var isNegative = num < 0;
        var absNum = Math.abs(num);
        var formatted;
        
        var fixed = absNum.toFixed(prefs.decimals);
        var parts = fixed.split('.');
        var intPart = parts[0];
        var decPart = parts[1];
        
        switch (prefs.numberFormat) {
            case 'eu':
                intPart = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                formatted = intPart + (decPart ? ',' + decPart : '');
                break;
            case 'fr':
                intPart = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
                formatted = intPart + (decPart ? ',' + decPart : '');
                break;
            case 'in':
                var lastThree = intPart.slice(-3);
                var otherDigits = intPart.slice(0, -3);
                if (otherDigits.length > 0) {
                    otherDigits = otherDigits.replace(/\B(?=(\d{2})+(?!\d))/g, ',');
                    intPart = otherDigits + ',' + lastThree;
                }
                formatted = intPart + (decPart ? '.' + decPart : '');
                break;
            case 'ch':
                intPart = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, "'");
                formatted = intPart + (decPart ? '.' + decPart : '');
                break;
            default:
                intPart = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                formatted = intPart + (decPart ? '.' + decPart : '');
        }
        
        var result;
        switch (prefs.position) {
            case 'after':
                result = formatted + prefs.symbol;
                break;
            case 'before-space':
                result = prefs.symbol + ' ' + formatted;
                break;
            case 'after-space':
                result = formatted + ' ' + prefs.symbol;
                break;
            default:
                result = prefs.symbol + formatted;
        }
        
        if (isNegative) {
            switch (prefs.negativeFormat) {
                case 'parens':
                    result = '(' + result + ')';
                    break;
                case 'minus-space':
                    result = '- ' + result;
                    break;
                default:
                    result = '-' + result;
            }
        }
        
        return result;
    }

    function formatAllCurrenciesInNode(node) {
        if (!node) return;
        
        var prefs = getCurrencyPrefs();
        var walker = document.createTreeWalker(node, NodeFilter.SHOW_TEXT, null, false);
        var textNode;
        
        while (textNode = walker.nextNode()) {
            var parent = textNode.parentElement;
            if (parent) {
                var tag = parent.tagName.toLowerCase();
                if (tag === 'script' || tag === 'style' || tag === 'textarea' ||
                    parent.closest('select, option, input, #currencyDropdown, #currencyDecimalsDropdown, #numberFormatDropdown, #currencyPositionDropdown, #negativeFormatDropdown, #currencyPreviewPos, #currencyPreviewNeg, #currencyPreviewZero, #previewSymbolDisplay, #previewFormatDisplay')) {
                    continue;
                }
            }
            
            var text = textNode.nodeValue;
            var original = text;
            
            // $1,234.56
            text = text.replace(/\$\s*([\d,]+(?:\.\d{1,4})?)\b/g, function(match, num) {
                return formatCurrencyAmount(num, prefs);
            });
            
            // €1.234,56
            text = text.replace(/€\s*([\d.]+(?:,\d{1,4})?)\b/g, function(match, num) {
                return formatCurrencyAmount(num.replace(/\./g, '').replace(',', '.'), prefs);
            });
            
            // £1,234.56
            text = text.replace(/£\s*([\d,]+(?:\.\d{1,4})?)\b/g, function(match, num) {
                return formatCurrencyAmount(num, prefs);
            });
            
            // ¥1,234
            text = text.replace(/¥\s*([\d,]+)\b/g, function(match, num) {
                return formatCurrencyAmount(num, prefs);
            });
            
            // ₦1,234.56
            text = text.replace(/₦\s*([\d,]+(?:\.\d{1,4})?)\b/g, function(match, num) {
                return formatCurrencyAmount(num, prefs);
            });
            
            // USh 1,234
            text = text.replace(/USh\s*([\d,]+(?:\.\d{1,4})?)\b/g, function(match, num) {
                return formatCurrencyAmount(num, prefs);
            });
            
            // KSh 1,234
            text = text.replace(/KSh\s*([\d,]+(?:\.\d{1,4})?)\b/g, function(match, num) {
                return formatCurrencyAmount(num, prefs);
            });
            
            // TSh 1,234
            text = text.replace(/TSh\s*([\d,]+(?:\.\d{1,4})?)\b/g, function(match, num) {
                return formatCurrencyAmount(num, prefs);
            });
            
            // FRw 1,234
            text = text.replace(/FRw\s*([\d,]+(?:\.\d{1,4})?)\b/g, function(match, num) {
                return formatCurrencyAmount(num, prefs);
            });
            
            // GH₵ 1,234.56
            text = text.replace(/GH₵\s*([\d,]+(?:\.\d{1,4})?)\b/g, function(match, num) {
                return formatCurrencyAmount(num, prefs);
            });
            
            // R 1,234.56 (South African Rand)
            text = text.replace(/\bR\s*([\d,]+(?:\.\d{1,4})?)\b/g, function(match, num) {
                return formatCurrencyAmount(num, prefs);
            });
            
            // Br 1,234.56 (Ethiopian Birr)
            text = text.replace(/\bBr\s*([\d,]+(?:\.\d{1,4})?)\b/g, function(match, num) {
                return formatCurrencyAmount(num, prefs);
            });
            
            if (text !== original) {
                textNode.nodeValue = text;
            }
        }
    }

    // ----------------------------------------
    // MASTER DOM FORMATTER
    // ----------------------------------------
    var isFormatting = false;
    function formatAllDatesTimesAndCurrenciesInDOM() {
        if (isFormatting) return;
        isFormatting = true;
        if (mo) mo.disconnect();

        try {
            formatAllDatesInNode(document.body);
            formatAllTimesInNode(document.body);
            formatAllCurrenciesInNode(document.body);
        } catch (e) {
            console.error('[Regional] Conversion Error:', e);
        }

        if (mo && document.body) {
            mo.observe(document.body, { childList: true, subtree: true });
        }
        isFormatting = false;
    }

    // ----------------------------------------
    // NOTIFICATIONS - MARK AS READ / DISMISS
    // ----------------------------------------
    function initNotificationDismissal() {
        document.addEventListener('click', function(e) {
            var markBtn = e.target.closest('button');
            if (!markBtn) return;

            var checkIcon = markBtn.querySelector('.lucide-check');
            if (!checkIcon) return;

            var notificationItem = markBtn.closest('[role="menuitem"]');
            if (!notificationItem) return;

            var notifDropdown = notificationItem.closest('#notificationsDropdown');
            if (!notifDropdown) return;

            e.preventDefault();
            e.stopPropagation();

            notificationItem.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            notificationItem.style.opacity = '0';
            notificationItem.style.transform = 'translateX(20px)';

            setTimeout(function() {
                notificationItem.remove();
                updateNotificationCount();
                updateNotificationBadge();
            }, 300);
        });

        var markAllBtn = document.getElementById('markAllReadBtn');
        if (markAllBtn) {
            markAllBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                var dropdown = document.getElementById('notificationsDropdown');
                if (!dropdown) return;

                var allNotifications = dropdown.querySelectorAll('[role="menuitem"]');

                allNotifications.forEach(function(item, index) {
                    setTimeout(function() {
                        item.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                        item.style.opacity = '0';
                        item.style.transform = 'translateX(20px)';

                        setTimeout(function() {
                            item.remove();
                            updateNotificationCount();
                            updateNotificationBadge();
                        }, 300);
                    }, index * 100);
                });
            });
        }

        function updateNotificationCount() {
            var dropdown = document.getElementById('notificationsDropdown');
            if (!dropdown) return;

            var remaining = dropdown.querySelectorAll('[role="menuitem"]');
            var count = remaining.length;

            var header = dropdown.querySelector('.px-3.py-2.text-sm.font-semibold span');
            if (header) {
                header.textContent = count > 0 ? 'Notifications (' + count + ')' : 'Notifications';
            }

            if (count === 0) {
                var group = dropdown.querySelector('[role="group"]');
                if (group) {
                    group.innerHTML = '<div class="p-6 text-center text-sm text-gray-500">' +
                        '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mx-auto mb-3 text-gray-300"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>' +
                        'All caught up!<br>No new notifications</div>';
                }

                if (markAllBtn) {
                    markAllBtn.style.display = 'none';
                }
            }
        }

        function updateNotificationBadge() {
            var dropdown = document.getElementById('notificationsDropdown');
            if (!dropdown) return;

            var remaining = dropdown.querySelectorAll('[role="menuitem"]');
            var count = remaining.length;

            var badge = document.querySelector('#notificationsBtn .bg-red-500');
            if (!badge) {
                badge = document.querySelector('#notificationsBtn .rounded-full.bg-red-500');
            }

            if (badge) {
                if (count === 0) {
                    badge.style.display = 'none';
                } else {
                    badge.style.display = '';
                    var pingSpan = badge.querySelector('.animate-ping');
                    if (!pingSpan && count > 0) {
                        badge.innerHTML = '<span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span>';
                    }
                }
            }
        }

        console.log('✅ Notification dismissal initialized');
    }

    // ----------------------------------------
    // CALENDAR VIEW SWITCHING & TAB DISPATCHER
    // ----------------------------------------
    var VALID_VIEWS = ['day', 'week', 'month', 'list'];

    function getDefaultCalendarView() {
        var saved = getPref('calendar_view', 'Month');
        var n = saved.toLowerCase();
        return VALID_VIEWS.indexOf(n) !== -1 ? n : 'month';
    }

    function setDefaultCalendarView(view) {
        var n = view.toLowerCase();
        if (VALID_VIEWS.indexOf(n) !== -1) {
            setPref('calendar_view', n.charAt(0).toUpperCase() + n.slice(1));
            window.dispatchEvent(new CustomEvent('meditrack-calendar-view-changed', { detail: { view: n } }));
        }
    }

    function applyCalendarView() {
        var targetView = getDefaultCalendarView();

        var allBtns = Array.from(document.querySelectorAll(
            '[data-tab].schedule-tab, [data-tab].calendar-tab, ' +
            '[data-tab].tab-btn, [data-tab].view-trigger, [data-view].view-trigger, ' +
            '.calendar-tab, [data-view]'
        ));
        if (allBtns.length === 0) return;

        var targetBtn = allBtns.find(function(btn) {
            var v = (btn.getAttribute('data-tab') || btn.getAttribute('data-view') || '').toLowerCase();
            return v === targetView;
        });

        if (targetBtn) {
            targetBtn.dispatchEvent(new MouseEvent('click', { bubbles: true, cancelable: true }));
        }
    }

    function applyLanguage() {
        var lang = getPref('language', 'English');
        var map = { 'English':'en','Spanish':'es','French':'fr','German':'de','Chinese':'zh' };
        var code = map[lang] || 'en';
        if (document.documentElement.lang !== code) document.documentElement.lang = code;
    }

    function applyTimezone() {
        var saved = getPref('timezone', '');
        if (!saved) return;
        document.querySelectorAll('[data-show-tz]').forEach(function(el) { el.textContent = saved; });
    }

    // ----------------------------------------
    // MUTATION OBSERVER & INITS
    // ----------------------------------------
    var moTimer;
    var mo = new MutationObserver(function(mutations) {
        var added = false;
        mutations.forEach(function(m) {
            if (m.type === 'childList' && m.addedNodes.length) added = true;
        });
        if (added) {
            clearTimeout(moTimer);
            moTimer = setTimeout(function() {
                applyFirstDayOfWeek();
                applyShowWeekends();
                formatAllDatesTimesAndCurrenciesInDOM();
            }, 100);
        }
    });

    function init() {
        applyLanguage();
        applyTimezone();
        applyFirstDayOfWeek();
        applyShowWeekends();
        formatAllDatesTimesAndCurrenciesInDOM();
        initNotificationDismissal();

        // Listen for currency/regional setting changes
        window.addEventListener('meditrack-setting-changed', function(e) {
            if (e.detail) {
                var key = e.detail.key;
                if (key === 'currency' || key === 'currency_decimals' || 
                    key === 'number_format' || key === 'currency_position' || 
                    key === 'negative_format') {
                    formatAllCurrenciesInNode(document.body);
                }
            }
        });

        // Listen for storage events from other tabs
        window.addEventListener('storage', function(e) {
            if (e.key && e.key.indexOf('meditrack_') === 0) {
                var settingKey = e.key.replace('meditrack_', '');
                if (settingKey === 'currency' || settingKey === 'currency_decimals' || 
                    settingKey === 'number_format' || settingKey === 'currency_position' || 
                    settingKey === 'negative_format') {
                    formatAllCurrenciesInNode(document.body);
                }
            }
        });

        setTimeout(applyCalendarView, 100);
        setTimeout(applyCalendarView, 600);

        if (document.body) {
            mo.observe(document.body, { childList: true, subtree: true });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // ----------------------------------------
    // PUBLIC API
    // ----------------------------------------
    window.MeditrackRegional = {
        refresh: function() {
            applyFirstDayOfWeek();
            applyShowWeekends();
            formatAllDatesTimesAndCurrenciesInDOM();
            applyCalendarView();
            if (window.refreshAllCurrencyDisplays) {
                window.refreshAllCurrencyDisplays();
            }
        },
        formatDate: window.formatDate,
        formatTime: window.formatTime,
        getOrderedDays: getOrderedDays,
        getFirstDayIndex: getFirstDayIndex,
        getDefaultCalendarView: getDefaultCalendarView,
        setDefaultCalendarView: setDefaultCalendarView,
        applyCalendarView: applyCalendarView,
        getShowWeekends: getShowWeekends,
        setShowWeekends: setShowWeekends,
        applyShowWeekends: applyShowWeekends,
        applyFirstDayOfWeek: applyFirstDayOfWeek,
        initNotificationDismissal: initNotificationDismissal
    };

})(window, document);