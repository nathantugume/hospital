<section class="hospital-section doctors-section" id="doctors">
  <div class="container">
    <div class="section-heading section-heading-wide">
      <div>
        <p class="eyebrow">Your care team</p>
        <h2>People who make time for you.</h2>
      </div>
      <p>Meet the doctors available through Hospital and choose the right place to begin.</p>
    </div>

    @if ($doctor->count())
      <div class="doctor-grid">
        @foreach ($doctor as $doctors)
          <article class="doctor-card">
            <div class="doctor-avatar">
              <img src="{{ asset('doctorimage/' . $doctors->image) }}" alt="{{ $doctors->name }}">
            </div>
            <div class="doctor-info">
              <p class="doctor-label">Care specialist</p>
              <h3>Dr. {{ $doctors->name }}</h3>
              <p>{{ $doctors->speciality }}</p>
            </div>
            <span class="doctor-arrow mai-arrow-forward" aria-hidden="true"></span>
          </article>
        @endforeach
      </div>
    @else
      <div class="empty-care-state">Our care team is being updated. Please check back soon.</div>
    @endif
  </div>
</section>
