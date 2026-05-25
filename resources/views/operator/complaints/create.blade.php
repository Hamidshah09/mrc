<x-app-layout>

    <div class="py-6">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-xl">

                <div class="p-6 border-b">

                    <h2 class="text-2xl font-bold text-gray-800">
                        Create Complaint
                    </h2>

                </div>

                <div class="p-6">

                    @if ($errors->any())

                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">

                            <ul class="list-disc pl-5">

                                @foreach ($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif
                    {{-- Leaflet CSS --}}

                    <form action="{{ route('operator.complaints.store') }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        {{-- Sub Division --}}
                        <div class="mb-5">

                            <label class="block mb-2 text-sm font-medium text-gray-700">

                                Sub Division

                            </label>

                            <select name="sub_division_id"
                                    id="sub_division_id"
                                    required
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200">

                                <option value="">
                                    Select Sub Division
                                </option>

                                @foreach($subDivisions as $subDivision)

                                    <option value="{{ $subDivision->id }}">

                                        {{ $subDivision->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- Police Station --}}
                        <div class="mb-5">

                            <label class="block mb-2 text-sm font-medium text-gray-700">

                                Police Station

                            </label>

                            <select name="policestation_id"
                                    id="policestation_id"
                                    required
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200">

                                <option value="">
                                    Select Police Station
                                </option>

                            </select>

                        </div>

                        {{-- Image Upload --}}
                        <div class="mb-5">

                            <label class="block mb-2 text-sm font-medium text-gray-700">

                                Complaint Image

                            </label>

                            <input type="file"
                                   name="before_image"
                                   accept="image/*"
                                   capture="environment"
                                   required
                                   class="w-full border border-gray-300 rounded-lg p-2">

                        </div>

                        {{-- Remarks --}}
                        <div class="mb-5">

                            <label class="block mb-2 text-sm font-medium text-gray-700">

                                Remarks

                            </label>

                            <textarea name="operator_remarks"
                                      rows="4"
                                      class="w-full border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200"></textarea>

                        </div>

                        {{-- Hidden GPS Fields --}}
                        <input type="hidden"
                               name="latitude"
                               id="latitude">

                        <input type="hidden"
                               name="longitude"
                               id="longitude">

                        <input type="hidden"
                               name="google_map_link"
                               id="google_map_link">

                        {{-- GPS Status --}}
                        {{-- Location Picker --}}
                        <div class="mb-5">

                            <label class="block mb-2 text-sm font-medium text-gray-700">
                                Complaint Location
                            </label>

                            <button type="button"
                                    id="openMapBtn"
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">

                                Pick Location

                            </button>

                            <input type="text"
                                id="location_preview"
                                readonly
                                placeholder="No location selected"
                                class="w-full mt-3 border-gray-300 rounded-lg shadow-sm">

                        </div>

                        {{-- Submit Button --}}
                        <div>

                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow">

                                Submit Complaint

                            </button>

                        </div>

                    </form>
                    {{-- Map Modal --}}
                    <div id="mapModal"
                        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

                        <div class="bg-white rounded-xl shadow-xl w-11/12 md:w-3/4 lg:w-1/2 p-4">

                            <div class="flex justify-between items-center mb-4">

                                <h2 class="text-lg font-bold">
                                    Select Complaint Location
                                </h2>

                                <button type="button"
                                        id="closeMapBtn"
                                        class="text-red-600 font-bold text-xl">

                                    ×

                                </button>

                            </div>

                            <div id="map"
                                class="w-full h-[400px] rounded-lg"></div>

                            <div class="mt-4 flex justify-end">

                                <button type="button"
                                        id="confirmLocationBtn"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                                    Confirm Location

                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- jQuery CDN --}}
    <script>

document.addEventListener('DOMContentLoaded', () => {

    /*
    |--------------------------------------------------------------------------
    | Elements
    |--------------------------------------------------------------------------
    */

    const subDivisionSelect =
        document.getElementById('sub_division_id');

    const policeStationSelect =
        document.getElementById('policestation_id');

    const openMapBtn =
        document.getElementById('openMapBtn');

    const closeMapBtn =
        document.getElementById('closeMapBtn');

    const confirmLocationBtn =
        document.getElementById('confirmLocationBtn');

    const mapModal =
        document.getElementById('mapModal');

    const latitudeInput =
        document.getElementById('latitude');

    const longitudeInput =
        document.getElementById('longitude');

    const googleMapLinkInput =
        document.getElementById('google_map_link');

    const locationPreview =
        document.getElementById('location_preview');

    /*
    |--------------------------------------------------------------------------
    | Dynamic Police Stations
    |--------------------------------------------------------------------------
    */

    subDivisionSelect.addEventListener('change', async function () {

        const subDivisionId = this.value;

        policeStationSelect.innerHTML =
            '<option>Loading...</option>';

        try {

            const response = await fetch(
                `/operator/get-police-stations/${subDivisionId}`
            );

            const stations = await response.json();

            let options =
                '<option value="">Select Police Station</option>';

            stations.forEach(station => {

                options += `
                    <option value="${station.id}">
                        ${station.name}
                    </option>
                `;
            });

            policeStationSelect.innerHTML = options;

        } catch (error) {

            console.error(error);

            policeStationSelect.innerHTML =
                '<option>Error loading stations</option>';
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Leaflet Map
    |--------------------------------------------------------------------------
    */

    let map;
    let marker;
    let selectedLat = null;
    let selectedLng = null;

    openMapBtn.addEventListener('click', () => {

        mapModal.classList.remove('hidden');
        mapModal.classList.add('flex');

        /*
        |--------------------------------------------------------------------------
        | Initialize Map Once
        |--------------------------------------------------------------------------
        */

        if (!map) {

            map = L.map('map').setView([33.6844, 73.0479], 13);

            /*
            |--------------------------------------------------------------------------
            | OpenStreetMap Tiles
            |--------------------------------------------------------------------------
            */

            L.tileLayer(
                'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                {
                    attribution:
                        '&copy; OpenStreetMap contributors'
                }
            ).addTo(map);

            /*
            |--------------------------------------------------------------------------
            | Map Click Event
            |--------------------------------------------------------------------------
            */

            map.on('click', function (e) {

                selectedLat = e.latlng.lat;
                selectedLng = e.latlng.lng;

                /*
                |--------------------------------------------------------------------------
                | Remove Existing Marker
                |--------------------------------------------------------------------------
                */

                if (marker) {
                    map.removeLayer(marker);
                }

                /*
                |--------------------------------------------------------------------------
                | Add Marker
                |--------------------------------------------------------------------------
                */

                marker = L.marker([
                    selectedLat,
                    selectedLng
                ]).addTo(map);
            });

            /*
            |--------------------------------------------------------------------------
            | Fix Map Render in Modal
            |--------------------------------------------------------------------------
            */

            setTimeout(() => {
                map.invalidateSize();
            }, 300);
        }
    });

    /*
    |--------------------------------------------------------------------------
    | Close Modal
    |--------------------------------------------------------------------------
    */

    closeMapBtn.addEventListener('click', () => {

        mapModal.classList.add('hidden');
        mapModal.classList.remove('flex');
    });

    /*
    |--------------------------------------------------------------------------
    | Confirm Location
    |--------------------------------------------------------------------------
    */

    confirmLocationBtn.addEventListener('click', () => {

        if (!selectedLat || !selectedLng) {

            alert('Please select a location on the map.');

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Fill Inputs
        |--------------------------------------------------------------------------
        */

        latitudeInput.value = selectedLat;
        longitudeInput.value = selectedLng;

        const googleMapsLink =
            `https://www.google.com/maps?q=${selectedLat},${selectedLng}`;

        googleMapLinkInput.value = googleMapsLink;

        locationPreview.value =
            `Lat: ${selectedLat}, Lng: ${selectedLng}`;

        /*
        |--------------------------------------------------------------------------
        | Close Modal
        |--------------------------------------------------------------------------
        */

        mapModal.classList.add('hidden');
        mapModal.classList.remove('flex');
    });

});

</script>

</x-app-layout>