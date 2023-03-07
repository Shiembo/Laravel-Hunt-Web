<x-layout>
  @include('partials._search')
  @php
	$address = $listing->location
  @endphp
  <a href="/~2120687/hunt/public" class="inline-block text-black ml-4 mb-4"><i class="fa-solid fa-arrow-left"></i> Back</a>
  <div class="mx-4">
    <x-card class="p-10">
      <div class="flex flex-col items-center justify-center text-center">
        <img class="hidden w-48 mr-6 md:block" src="{{$listing->logo ? asset('storage/' . $listing->logo) : asset('/images/no-image.png')}}" alt="" />
        <h3 class="text-2xl mb-2">{{$listing['title']}}</h3>
        <div class="text-xl font-bold mb-4">{{$listing['company']}}</div>
        <x-listing-tags :tagsCsv="$listing->tags" />
        <div class="text-lg my-4">
          <i class="fa-solid fa-location-dot"></i> {{$address}}
        </div>
        <div class="border border-gray-200 w-full mb-6"></div>
        <div>
          <h3 class="text-3xl font-bold mb-4">Job Description</h3>
          <div class="text-lg space-y-6">
            {{$listing['description']}}
            <a href="mailto:{{$listing['email']}}" class="block bg-laravel text-white mt-6 py-2 rounded-xl hover:opacity-80"><i class="fa-solid fa-envelope"></i> Contact Employer</a>
            <a href={{$listing['website']}} target="_blank" class="block bg-black text-white py-2 rounded-xl hover:opacity-80"><i class="fa-solid fa-globe"></i> Visit Website</a>
          </div>
        </div>
      </div>
    </x-card>
	
	 <div class="container">
		 <div id "map">
		 <body onload="initialize()">
		 <div id="map" style="height: 500px; width: auto;">
	 </div>
		
	 <x-card class="mt-4 p-2 flex space-x-6">
      <a href="/~2120687/hunt/public/listings/{{$listing->id}}/edit">
        <i class="fa-solid fa-pencil"></i> Edit
      </a>
	  
	  
	  <form method="POST" action="/~2120687/hunt/public/listings/{{$listing->id}}">
        @csrf
        @method('DELETE')
        <button class="text-red-500"><i class="fa-solid fa-trash"></i> Delete</button>
      </form>
	  
	  
    </x-card>
  </div>
</x-layout>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD6a-7tA-dkbTZ9Tro7qw4n8my8shu0y_Q"></script>
<script>
var geocoder;
var map;
var address = <?php echo json_encode($address)?>;
  function initialize() {
    infoWindow = new google.maps.InfoWindow;
    geocoder = new google.maps.Geocoder();
    map = new google.maps.Map(document.getElementById('map'),{
       zoom: 15,
       center: { lat: 52.591370, lng: -2.110748 },
    });
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
 
  
 
  </script>