
function initCalendarPreferencesUI() {
  // Default Calendar View
  const viewBtn = document.getElementById('calendarViewBtn');
  const viewSelected = document.getElementById('calendarViewSelected');
  const viewDropdown = document.getElementById('calendarViewDropdown');

  if (!viewBtn) return;

  function loadDefaultView() {
    const saved = window.MeditrackRegional?.getDefaultCalendarView() || 'month';
    if (viewSelected) {
      viewSelected.textContent = saved.charAt(0).toUpperCase() + saved.slice(1);
    }
  }

  viewBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    viewDropdown.classList.toggle('hidden');
  });

  document.querySelectorAll('#calendarViewDropdown .select-item').forEach(item => {
    item.addEventListener('click', () => {
      const value = item.dataset.value;
      if (viewSelected) viewSelected.textContent = item.textContent;

      window.MeditrackRegional?.setDefaultCalendarView(value);

      viewDropdown.classList.add('hidden');
      showToast(`Default view changed to ${item.textContent}`);
    });
  });

  document.addEventListener('click', () => viewDropdown.classList.add('hidden'));

  // ==================== Show Weekends Toggle ====================
  const weekendsSwitch = document.getElementById('showWeekendsSwitch');
  if (!weekendsSwitch) return;

  function updateSwitchUI(isChecked) {
    weekendsSwitch.setAttribute('data-state', isChecked ? 'checked' : 'unchecked');
    const thumb = weekendsSwitch.querySelector('.switch-thumb');
    if (thumb) {
      thumb.setAttribute('data-state', isChecked ? 'checked' : 'unchecked');
    }
  }

  function loadWeekendsPreference() {
    const show = window.MeditrackCalendar?.getShowWeekends() ?? true;
    updateSwitchUI(show);
  }

  weekendsSwitch.addEventListener('click', () => {
    const isCurrentlyChecked = weekendsSwitch.getAttribute('data-state') === 'checked';
    const newValue = !isCurrentlyChecked;

    updateSwitchUI(newValue);
    window.MeditrackCalendar?.setShowWeekends(newValue);

    showToast(newValue ? "Weekends are now visible" : "Weekends are now hidden");

    // If you have a calendar on this page, refresh it immediately:
    if (window.currentCalendarInstance && window.currentCalendarType) {
      window.MeditrackCalendar.applyShowWeekendsToCalendar(
        window.currentCalendarInstance,
        window.currentCalendarType
      );
    }
  });

  // Initialize
  loadDefaultView();
  loadWeekendsPreference();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initCalendarPreferencesUI);
} else {
  initCalendarPreferencesUI();
}

