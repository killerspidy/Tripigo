 <!-- footer starts -->
    <footer class="pt-20 pb-4" style="background-image: url({{ asset('images/background_pattern.png') }})">
      <div class="section-shape top-0" style="background-image: url({{ asset('images/shape8.png') }})"></div>

      
      <div class="footer-upper pb-4">
        <div class="container">
          <div class="row">
           <div class="col-lg-8 col-md-6 col-sm-12 mb-4 pe-4">
              <div class="footer-about">
                <img src="{{ asset('images/logo.jpg') }}" alt="" />
             <p class="mt-3 mb-3 white" align="justify">
                Tripigo Tales – Tours & Travels is a trusted travel partner specializing in customized domestic tour packages. From family holidays and honeymoons to adventure and spiritual journeys, we design memorable travel experiences with transparent pricing, reliable service, and personalized support.
                </p>
                <ul>
                  <li class="white"><strong>Contact:</strong> +91 7743963339</li><br>
               
                  <li class="white"><strong>Email:</strong> info@tripigotales.com</li>
                
                </ul>
              </div>
            </div>
      <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
              <div class="footer-links">
                <h3 class="white">Quick links</h3>
                <ul>
             
       <li><a href="{{ route('frontend.faq') }}">FAQ's</a></li>
                  
       <li><a href="{{ route('frontend.blogs') }}">Blogs</a></li>
                  <li><a href="{{ route('frontend.privacy.policy') }}">Privacy Policy</a></li>
                  <li><a href="{{ route('frontend.terms.and.conditions') }}">Terms &amp; Conditions</a></li>
                  <li><a href="{{ route('frontend.cancellation.policy') }}">Cancellation Policy</a></li>
               
                </ul>
              </div>
            </div>
      
      
          </div>
        </div>
      </div>



      <div class="footer-copyright">
        <div class="container">
          <div class="copyright-inner rounded p-3 d-md-flex align-items-center justify-content-between">
            <div class="copyright-text">
              <p class="m-0 white">© 2026 Tripigo Tales. All rights reserved.</p>
                   <p class="m-0 white">Crafted with passion for travel experiences by <a href="https://www.webfifi.com">Webfifi Solutions</a>.</p>
            </div>
            <div class="social-links">
              <ul>
                   <li>
                <a href="https://www.facebook.com/profile.php?id=61586111814953" class="white"><i class="fab fa-facebook" aria-hidden="true"></i></a>
              </li>
             
              <li>
                <a href="https://www.instagram.com/tripigotales" class="white"><i class="fab fa-instagram" aria-hidden="true"></i></a>
              </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div id="particles-js"></div>
      <script>
      document.addEventListener('submit', function (e) {

    // sirf contact form ke liye
    if (e.target && e.target.classList.contains('no-prevent-default')) {
        e.stopImmediatePropagation(); // 🔥 sab JS listeners ko rok dega
        return true; // allow normal submit
    }

}, true); // 👈 CAPTURE PHASE (important)
</script>
    </footer>
    <!-- footer ends -->