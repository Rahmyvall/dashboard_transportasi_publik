@extends('layouts.app')


@section('content')
     <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">


     <style>
          body {

               background: #f1f5f9;

          }



          .page-wrapper {

               padding: 30px;

          }



          .card-track {

               background: white;

               padding: 30px;

               border-radius: 25px;

               box-shadow: 0 10px 30px rgba(160, 192, 151, 0.884);

          }



          .header {

               background: linear-gradient(135deg, #6886ce, #b1bfdd);

               color: white;

               padding: 30px;

               border-radius: 25px;

               margin-bottom: 25px;

          }



          #map {

               height: 600px;

               border-radius: 25px;

          }
     </style>





     <div class="page-wrapper">



          <div class="header">


               <h2>

                    <i class="bi bi-pin-map"></i>

                    Tracking

                    {{ $vehicle->vehicle_code }}

               </h2>


               <p class="mb-0">

                    Riwayat perjalanan kendaraan

               </p>


          </div>







          <div class="card-track">


               <div id="map"></div>


          </div>



     </div>







     <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>





     <script>
          let positions = @json($positions);



          let first = positions[0];




          let map = L.map('map')

               .setView(

                    [

                         first.latitude,

                         first.longitude

                    ],

                    13

               );



          L.tileLayer(

                    'https://tile.openstreetmap.org/{z}/{x}/{y}.png'

               )

               .addTo(map);





          let route = [];




          positions.forEach(function(pos) {



               let lat =
                    parseFloat(pos.latitude);



               let lng =
                    parseFloat(pos.longitude);



               route.push(
                    [
                         lat,
                         lng
                    ]
               );



               L.marker(

                         [
                              lat,
                              lng
                         ]

                    )

                    .addTo(map)

                    .bindPopup(

                         `

<b>

${pos.recorded_at}

</b>

<br>

Speed:

${pos.speed_kmh ?? 0}

KM/H

<br>

Lat:

${lat}

<br>

Lng:

${lng}

`

                    );



          });







          L.polyline(

                    route,

                    {

                         color: 'blue',

                         weight: 5

                    }

               )

               .addTo(map);



          map.fitBounds(route);
     </script>
@endsection
