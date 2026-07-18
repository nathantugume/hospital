@include('user.header')

<main class="hospital-home">
  <section class="hospital-hero">
    <div class="container">
      <div class="hospital-hero-grid">
        <div class="hero-copy">
          <p class="eyebrow"><span class="eyebrow-dot"></span> Personal care, every day</p>
          <h1>Healthcare that feels <em>human.</em></h1>
          <p class="hero-lede">Simple access to trusted doctors, clear appointment times, and support that keeps your wellbeing moving forward.</p>
          <div class="hero-actions">
            <a class="hospital-button" href="#appointment">Book an appointment <span class="mai-arrow-forward" aria-hidden="true"></span></a>
            <a class="hospital-button hospital-button-quiet" href="#doctors">Meet the care team</a>
          </div>
          <div class="hero-assurance">
            <span class="assurance-icon" aria-hidden="true"><span class="mai-shield-check"></span></span>
            <span><strong>Care you can count on</strong><small>Thoughtful support from first visit to follow-up.</small></span>
          </div>
        </div>

        <div class="hero-console" aria-label="Hospital care overview">
          <div class="console-header">
            <span class="console-kicker">Your care, in one place</span>
            <span class="status-pill"><span></span> Open today</span>
          </div>
          <div class="console-feature">
            <div class="feature-icon" aria-hidden="true"><span class="mai-calendar"></span></div>
            <div>
              <span class="console-label">Next step</span>
              <h2>Find the right time to be seen.</h2>
              <p>Choose a doctor and send an appointment request in a few moments.</p>
            </div>
          </div>
          <div class="console-list">
            <div class="console-list-item"><span class="list-icon" aria-hidden="true"><span class="mai-stethoscope"></span></span><span><strong>Experienced doctors</strong><small>Care matched to your needs</small></span><span class="mai-checkmark" aria-hidden="true"></span></div>
            <div class="console-list-item"><span class="list-icon" aria-hidden="true"><span class="mai-clock"></span></span><span><strong>Clear appointment requests</strong><small>Choose a time that works for you</small></span><span class="mai-checkmark" aria-hidden="true"></span></div>
          </div>
          <a class="console-link" href="#appointment">Start your request <span class="mai-arrow-forward" aria-hidden="true"></span></a>
        </div>
      </div>
    </div>
  </section>

  <section class="hospital-proof" aria-label="Hospital highlights">
    <div class="container proof-grid">
      <div><strong>01</strong><span>One clear place<br>for your care</span></div>
      <div><strong>02</strong><span>Doctors chosen<br>around your needs</span></div>
      <div><strong>03</strong><span>Appointments<br>without the guesswork</span></div>
    </div>
  </section>

  <section class="hospital-section services-section" id="services">
    <div class="container">
      <div class="section-heading section-heading-wide">
        <div>
          <p class="eyebrow">A better way to begin</p>
          <h2>Support for the moments that matter.</h2>
        </div>
        <p>From finding a doctor to planning your next visit, Hospital keeps the important details close and easy to follow.</p>
      </div>

      <div class="service-grid">
        <article class="service-card service-card-featured">
          <span class="service-number">01</span>
          <span class="service-icon" aria-hidden="true"><span class="mai-calendar"></span></span>
          <h3>Book a visit</h3>
          <p>Send an appointment request with the doctor, date, and reason for your visit.</p>
          <a href="#appointment" class="service-link">Make a request <span class="mai-arrow-forward" aria-hidden="true"></span></a>
        </article>
        <article class="service-card">
          <span class="service-number">02</span>
          <span class="service-icon service-icon-blue" aria-hidden="true"><span class="mai-stethoscope"></span></span>
          <h3>Meet your doctor</h3>
          <p>Browse the care team and find a specialist who fits your needs.</p>
          <a href="#doctors" class="service-link">View the team <span class="mai-arrow-forward" aria-hidden="true"></span></a>
        </article>
        <article class="service-card">
          <span class="service-number">03</span>
          <span class="service-icon service-icon-orange" aria-hidden="true"><span class="mai-chatbubbles"></span></span>
          <h3>Stay connected</h3>
          <p>Keep your appointment details together and return when you need support.</p>
          @auth
            <a href="{{ url('myappointment') }}" class="service-link">View appointments <span class="mai-arrow-forward" aria-hidden="true"></span></a>
          @else
            <a href="{{ route('login') }}" class="service-link">Sign in to continue <span class="mai-arrow-forward" aria-hidden="true"></span></a>
          @endauth
        </article>
      </div>
    </div>
  </section>

  <section class="care-note">
    <div class="container care-note-inner">
      <div class="care-note-mark" aria-hidden="true"><span class="mai-heart"></span></div>
      <div>
        <p class="eyebrow">A calmer care experience</p>
        <h2>Good care starts with being heard.</h2>
        <p>Tell us what you need, choose a doctor, and take the next step with confidence.</p>
      </div>
      <a class="hospital-button hospital-button-dark" href="#appointment">Get started <span class="mai-arrow-forward" aria-hidden="true"></span></a>
    </div>
  </section>

  @include('user.doctor')

  @include('user.appointment')
</main>

@include('user.footer')
