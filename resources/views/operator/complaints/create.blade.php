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
                        <div class="mb-5">

                            <div id="gps-status"
                                 class="text-sm text-blue-600 font-medium">

                                Detecting GPS location...

                            </div>

                        </div>

                        {{-- Submit Button --}}
                        <div>

                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow">

                                Submit Complaint

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

    {{-- jQuery CDN --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        /*
        |--------------------------------------------------------------------------
        | GPS Auto Capture
        |--------------------------------------------------------------------------
        */

        navigator.geolocation.getCurrentPosition(

            function(position) {

                let latitude = position.coords.latitude;
                let longitude = position.coords.longitude;

                document.getElementById('latitude').value = latitude;

                document.getElementById('longitude').value = longitude;

                document.getElementById('google_map_link').value =
                    `https://maps.google.com/?q=${latitude},${longitude}`;

                document.getElementById('gps-status').innerHTML =
                    'GPS location detected successfully';

            },

            function(error) {

                console.log(error);

                document.getElementById('gps-status').innerHTML =
                    'Unable to detect GPS location';

            }

        );

        /*
        |--------------------------------------------------------------------------
        | Dynamic Police Station Dropdown
        |--------------------------------------------------------------------------
        */

        $('#sub_division_id').on('change', function () {

            let subDivisionId = $(this).val();

            $('#policestation_id').html(
                '<option>Loading...</option>'
            );

            $.ajax({

                url: '/operator/get-police-stations/' + subDivisionId,

                type: 'GET',

                success: function (response) {

                    let options =
                        '<option value="">Select Police Station</option>';

                    response.forEach(function (station) {

                        options += `
                            <option value="${station.id}">
                                ${station.name}
                            </option>
                        `;
                    });

                    $('#policestation_id').html(options);

                }

            });

        });

    </script>

</x-app-layout>