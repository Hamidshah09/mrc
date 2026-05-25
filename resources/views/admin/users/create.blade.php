<x-app-layout>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-xl p-6">

                <h2 class="text-3xl font-bold text-gray-800 mb-8">

                    Create User

                </h2>

                @if ($errors->any())

                    <div class="mb-5 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">

                        <ul class="list-disc pl-5">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <form method="POST"
                      action="{{ route('admin.users.store') }}"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                        {{-- Name --}}
                        <div>

                            <label class="block mb-2 text-sm font-medium text-gray-700">

                                Full Name

                            </label>

                            <input type="text"
                                   name="name"
                                   required
                                   class="w-full border-gray-300 rounded-lg shadow-sm">

                        </div>

                        {{-- Mobile --}}
                        <div>

                            <label class="block mb-2 text-sm font-medium text-gray-700">

                                Mobile

                            </label>

                            <input type="text"
                                   name="mobile"
                                   required
                                   class="w-full border-gray-300 rounded-lg shadow-sm">

                        </div>

                        {{-- Email --}}
                        <div>

                            <label class="block mb-2 text-sm font-medium text-gray-700">

                                Email

                            </label>

                            <input type="email"
                                   name="email"
                                   required
                                   class="w-full border-gray-300 rounded-lg shadow-sm">

                        </div>

                        {{-- Password --}}
                        <div>

                            <label class="block mb-2 text-sm font-medium text-gray-700">

                                Password

                            </label>

                            <input type="password"
                                   name="password"
                                   required
                                   class="w-full border-gray-300 rounded-lg shadow-sm">

                        </div>

                        {{-- Confirm Password --}}
                        <div>

                            <label class="block mb-2 text-sm font-medium text-gray-700">

                                Confirm Password

                            </label>

                            <input type="password"
                                   name="password_confirmation"
                                   required
                                   class="w-full border-gray-300 rounded-lg shadow-sm">

                        </div>

                        {{-- Role --}}
                        <div>

                            <label class="block mb-2 text-sm font-medium text-gray-700">

                                Role

                            </label>

                            <select name="role_id"
                                    required
                                    class="w-full border-gray-300 rounded-lg shadow-sm">

                                <option value="">
                                    Select Role
                                </option>

                                @foreach($roles as $role)

                                    <option value="{{ $role->id }}">

                                        {{ $role->role }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- Status --}}
                        <div>

                            <label class="block mb-2 text-sm font-medium text-gray-700">

                                Status

                            </label>

                            <select name="status"
                                    required
                                    class="w-full border-gray-300 rounded-lg shadow-sm">

                                <option value="Not Active">
                                    Not Active
                                </option>

                                <option value="Active">
                                    Active
                                </option>

                            </select>

                        </div>

                        {{-- Sub Division --}}
                        <div>

                            <label class="block mb-2 text-sm font-medium text-gray-700">

                                Sub Division

                            </label>

                            <select name="sub_division_id"
                                    class="w-full border-gray-300 rounded-lg shadow-sm">

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

                        {{-- Profile Image --}}
                        <div>

                            <label class="block mb-2 text-sm font-medium text-gray-700">

                                Profile Image

                            </label>

                            <input type="file"
                                   name="profile_image"
                                   class="w-full border border-gray-300 rounded-lg p-2">

                        </div>

                    </div>

                    {{-- Submit --}}
                    <div class="mt-8">

                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">

                            Create User

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>