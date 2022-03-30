<?php
function render_block_google_map( $attributes ) {

  $latitude = (float) $attributes[ 'latitude' ];
  $longitude = (float) $attributes[ 'longitude' ];
  $zoom = (int) $attributes[ 'zoom' ];

  return '
    <script>
      var map;
      var center = {lat: '.$latitude.', lng: '.$longitude.'}
      function initMap() {
        map = new google.maps.Map(document.getElementById(\'map-container\'), {
          center: center,
          zoom: '.$zoom.'
        });
        var marker = new google.maps.Marker({position: center, map: map});
      }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAR0gY4p3oPKu-MKcjnREpc--Sb00kYNzQ&callback=initMap"
    async defer></script>
    <div id="map-container"style="height: 400px" data-lat="'.$latitude.'" data-lng="'.$longitude.'"></div>';

}

register_block_type( 'kne/google-map-block', array(
    'render_callback' => 'render_block_google_map',
    'attributes' => array(
      'latitude' => array(
        'type' => 'float',
        'default' => 54.4342
      ),
      'longitude' => array(
        'type' => 'float',
        'default' => -3.0377
      ),
      'zoom' => array(
        'type' => 'integer',
        'default' => 8
      )
    )
  )
);

?>
