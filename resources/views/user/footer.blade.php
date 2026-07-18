<footer class="hospital-footer">
  <div class="container">
    <div class="footer-main">
      <div>
        <a class="hospital-brand footer-brand" href="{{ url('/') }}">
          <span class="brand-mark" aria-hidden="true"><span class="mai-pulse"></span></span>
          <span class="brand-copy"><strong>Hospital</strong><small>care center</small></span>
        </a>
        <p class="footer-summary">Clearer appointments. Thoughtful care. A better way to stay connected to your health.</p>
      </div>
      <div class="footer-links">
        <div><span class="footer-label">Explore</span><a href="#services">Services</a><a href="#doctors">Care team</a><a href="#appointment">Appointments</a></div>
        <div><span class="footer-label">Contact</span><a href="mailto:healthcare@temporary.net">healthcare@temporary.net</a><a href="tel:+00012344556666">+00 123 4455 6666</a><span>351 Willow Street<br>Franklin, MA 02038</span></div>
      </div>
    </div>
    <div class="footer-bottom"><span>© {{ date('Y') }} Hospital Care Center</span><span>Here when you need us.</span></div>
  </div>
</footer>

<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
