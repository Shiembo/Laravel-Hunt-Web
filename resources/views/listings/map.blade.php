<x-layout>
  <x-card class="p-10">
   <link rel="stylesheet"href="{{asset('css/main.css')}}">
  
  

    <header>
      <h1 class="text-3xl text-center font-bold my-6 uppercase">
        Map
      </h1>
    </header>
     <div class="container">
	 <div id "map">
	 <body onload="initialize()">
 <div id="map" style="height: 500px; width: auto;">
 </div>

@php
	$address = array();
	foreach($listings as $listing){
		array_push($address, $listing->location);
	}

@endphp


  
				

 
</body>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6a-7tA-dkbTZ9Tro7qw4n8my8shu0y_Q"></script>
<script>

var postCodes = <?php echo json_encode($address)?>;
var geocoder
var map;

  function initialize() {
    infoWindow = new google.maps.InfoWindow;
    geocoder = new google.maps.Geocoder();
    map = new google.maps.Map(document.getElementById('map'),{
       zoom: 7,
       center: { lat: 52.591370, lng: -2.110748 },
    });
    codeAddress()
  }
  
  function codeAddress() {
    for (let i = 0; i < postCodes.length; i++) {
        var address = postCodes[i];
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == 'OK') {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
                  google.maps.event.addListener(marker, 'click', (function (marker, i) {
                    return function () {
                        infowindow.setContent('my name');
                        infowindow.open(map, marker);
                    }
                })(marker, i));
            } else {
                alert('Geocode was not successful for the following reason: ' + status);
            }
            });
  
    }
  }

 
</script>
	 </div>
    
  </x-card>
</x-layout>
