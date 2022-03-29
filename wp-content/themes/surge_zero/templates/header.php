<header>
  <!--HAMBURGER-->
  <input id="hamburger_input" type="checkbox" />
  <label for="hamburger_input" class="hamburger" aria-label="Show and hide the navigation menu.">
    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 250 160">
      <path class="line_1" stroke="#000" stroke-width="20" stroke-linecap="round" d="M20 10 L230 10" />
      <path class="line_2" stroke="#000" stroke-width="20" stroke-linecap="round" d="M20 80 L230 80" />
      <path class="line_3" stroke="#000" stroke-width="20" stroke-linecap="round" d="M20 150 L230 150" />
    </svg>
  </label>

  <!--LOGO FOR MOBILE NAV-->
  <div class="kne-logo">
    <a href="/"><?php get_template_part('/templates/icons/kne-logo'); ?></a>
  </div>

  <!--BOOK NOW BUTTON-->
  <?php
  $booking_class = ( is_page(array('booking','booking-start')) ) ? 'booking' : '' ;
  ?>
  
  <!--CALL NOW BUTTON-->
  <a href="tel:01915214050" class="call-now <?= $booking_class; ?>" aria-label="Call KNE now button." onclick="_gaq.push(['_trackEvent', 'Phone Call Tracking', 'Click to Call', '0191 521 4050']);">
    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 51.413 51.413" style="enable-background:new 0 0 51.413 51.413;" xml:space="preserve">
      <g>
        <g>
          <path style="fill:#010002;" d="M25.989,12.274c8.663,0.085,14.09-0.454,14.823,9.148h10.564c0-14.875-12.973-16.88-25.662-16.88 c-12.69,0-25.662,2.005-25.662,16.88h10.482C11.345,11.637,17.398,12.19,25.989,12.274z"/>
          <path style="fill:#010002;" d="M5.291,26.204c2.573,0,4.714,0.154,5.19-2.377c0.064-0.344,0.101-0.734,0.101-1.185H10.46H0 C0,26.407,2.369,26.204,5.291,26.204z"/>
          <path style="fill:#010002;" d="M40.88,22.642h-0.099c0,0.454,0.039,0.845,0.112,1.185c0.502,2.334,2.64,2.189,5.204,2.189 c2.936,0,5.316,0.193,5.316-3.374H40.88z"/>
          <path style="fill:#010002;" d="M35.719,20.078v-1.496c0-0.669-0.771-0.711-1.723-0.711h-1.555c-0.951,0-1.722,0.042-1.722,0.711 v1.289v1h-11v-1v-1.289c0-0.669-0.771-0.711-1.722-0.711h-1.556c-0.951,0-1.722,0.042-1.722,0.711v1.496v1.306 C12.213,23.988,4.013,35.073,3.715,36.415l0.004,8.955c0,0.827,0.673,1.5,1.5,1.5h40c0.827,0,1.5-0.673,1.5-1.5v-9 c-0.295-1.303-8.493-12.383-11-14.987V20.078z M19.177,37.62c-0.805,0-1.458-0.652-1.458-1.458s0.653-1.458,1.458-1.458 s1.458,0.652,1.458,1.458S19.982,37.62,19.177,37.62z M19.177,32.62c-0.805,0-1.458-0.652-1.458-1.458s0.653-1.458,1.458-1.458 s1.458,0.652,1.458,1.458S19.982,32.62,19.177,32.62z M19.177,27.621c-0.805,0-1.458-0.652-1.458-1.458 c0-0.805,0.653-1.458,1.458-1.458s1.458,0.653,1.458,1.458C20.635,26.969,19.982,27.621,19.177,27.621z M25.177,37.62 c-0.805,0-1.458-0.652-1.458-1.458s0.653-1.458,1.458-1.458c0.806,0,1.458,0.652,1.458,1.458S25.983,37.62,25.177,37.62z M25.177,32.62c-0.805,0-1.458-0.652-1.458-1.458s0.653-1.458,1.458-1.458c0.806,0,1.458,0.652,1.458,1.458 S25.983,32.62,25.177,32.62z M25.177,27.621c-0.805,0-1.458-0.652-1.458-1.458c0-0.805,0.653-1.458,1.458-1.458 c0.806,0,1.458,0.653,1.458,1.458C26.635,26.969,25.983,27.621,25.177,27.621z M31.177,37.62c-0.806,0-1.458-0.652-1.458-1.458 s0.652-1.458,1.458-1.458s1.458,0.652,1.458,1.458S31.983,37.62,31.177,37.62z M31.177,32.62c-0.806,0-1.458-0.652-1.458-1.458 s0.652-1.458,1.458-1.458s1.458,0.652,1.458,1.458S31.983,32.62,31.177,32.62z M31.177,27.621c-0.806,0-1.458-0.652-1.458-1.458 c0-0.805,0.652-1.458,1.458-1.458s1.458,0.653,1.458,1.458C32.635,26.969,31.983,27.621,31.177,27.621z"/>
        </g>
      </g>
    </svg>
  </a>

  <nav>
    <div>
      <!--LOGO FOR DESKTOP NAV-->
      <div class="kne-logo">
        <a href="/"><?php get_template_part('/templates/icons/kne-logo-vertical'); ?></a>
      </div>

      <!--MENU-->
      <?php
        get_template_part('/templates/menu/nav');
      ?>
      <!--BLOCK LINKS-->
      <div class="block_links">
        <!--LOGIN-->
        <a class="block_link" href="/my-account" aria-label="My account link">
          <?php get_template_part('/templates/icons/person'); ?>
          My account
        </a>
        <!--CART-->
        <a class="block_link" href="/cart" aria-label="Shopping cart link">
          <?php get_template_part('/templates/icons/cart'); ?>
          View cart
        </a>
      </div>

      <!--SOCIAL-->
      <div class="social-links">
        <a class="facebook" href="https://en-gb.facebook.com/knekartingnortheast/" target="_blank" >
          <?php get_template_part('/templates/icons/social/facebook'); ?>
        </a>

        <a class="twitter" href="https://twitter.com/KNE_Official" target="_blank" >
          <?php get_template_part('/templates/icons/social/twitter'); ?>
        </a>

        <a class="instagram" href="https://www.instagram.com/kne_official/" target="_blank" >
          <?php get_template_part('/templates/icons/social/instagram'); ?>
        </a>
      </div>
    </div>
  </nav>

  <!--ICONS BLOCKS-->
  <?php
  if( ! (is_page('booking') || (is_page('booking-start') && isset($_GET['event_category']))) ){
    get_template_part('/templates/menu/activity-icons');
  }
  ?>
</header>
