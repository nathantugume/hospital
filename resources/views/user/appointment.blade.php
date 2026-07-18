<section class="hospital-section appointment-section" id="appointment">
  @include('sweetalert::alert')
  <div class="container">
    <div class="appointment-layout">
      <div class="appointment-intro">
        <p class="eyebrow">Your next step</p>
        <h2>Make time for your health.</h2>
        <p>Share a few details and we will have your appointment request ready for review.</p>
        <div class="appointment-points">
          <span><i class="mai-checkmark" aria-hidden="true"></i> Choose your preferred doctor</span>
          <span><i class="mai-checkmark" aria-hidden="true"></i> Tell us what you need help with</span>
          <span><i class="mai-checkmark" aria-hidden="true"></i> Keep your request in one place</span>
        </div>
      </div>

      <form class="hospital-form" action="{{ url('add_appointment') }}" method="POST">
        @csrf
        <div class="form-heading"><span>Appointment request</span><small>Required fields are marked by the form</small></div>
        <div class="form-grid">
          <label>Full name<input type="text" name="name" required placeholder="Your name"></label>
          <label>Email address<input type="email" name="email" placeholder="you@example.com"></label>
          <label>Preferred date<input type="date" name="date"></label>
          <label>Doctor<select name="doctor" id="departement"><option value="general">Select a doctor</option>@foreach($doctor as $doctors)<option value="{{ $doctors->id }}">{{ $doctors->name }} - {{ $doctors->speciality }}</option>@endforeach</select></label>
          <label class="form-field-full">Phone number<input type="text" name="phone" placeholder="Your phone number"></label>
          <label class="form-field-full">Reason for visit<textarea name="reason" id="message" rows="4" placeholder="How can we help?"></textarea></label>
        </div>
        <button type="submit" class="hospital-button">Send appointment request <span class="mai-arrow-forward" aria-hidden="true"></span></button>
      </form>
    </div>
  </div>
</section>
