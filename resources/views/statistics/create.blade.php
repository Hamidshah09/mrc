<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Daily Statistics') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900 d">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li style="color:red;">{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('statistics.store')}}" method="Post">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-4">
                            
                            <div class="form-control">
                                <x-input-label for="center" :value="__('Center')" />
                                <select name="center_id" id="center_id" class="w-full border-gray-600  focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" :value="old('center_id')" required autofocus autocomplete="center_id">
                                    @foreach ($centers as $center)
                                        <option value="{{$center->id}}">{{$center->location}}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('center_id')" class="mt-2" />
                            </div>
                            
                            <div class="form-control">
                                <x-input-label for="arms" :value="__('Arms')" />
                                <x-text-input id="arms" class="block mt-1 w-full p-2" type="text" name="arms" maxlength="13" :value="old('arms')" required autofocus autocomplete="arms" />
                                <x-input-error :messages="$errors->get('arms')" class="mt-2" />
                            </div>
        

                            <div class="form-control">
                                <x-input-label for="idp" :value="__('IDP')" />
                                <x-text-input id="idp" class="block mt-1 w-full p-2" type="text" name="idp" :value="old('idp')" required autofocus autocomplete="idp" />
                                <x-input-error :messages="$errors->get('idp')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="domicile" :value="__('domicile')" />
                                <x-text-input id="domicile" class="block mt-1 w-full p-2" type="text" name="domicile" :value="old('domicile')" required autofocus autocomplete="domicile" />
                                <x-input-error :messages="$errors->get('domicile')" class="mt-2" />
                            </div>

                            <div class="form-control">
                                <x-input-label for="birth" :value="__('Birth')" />
                                <x-text-input id="birth" class="block mt-1 w-full p-2" type="text" name="birth" :value="old('birth')" required autofocus autocomplete="birth" />
                                <x-input-error :messages="$errors->get('birth')" class="mt-2" />
                            </div>

                            
                            <div class="form-control">
                                <x-input-label for="mrc" :value="__('MRC/DRC')" />
                                <x-text-input id="mrc" class="block mt-1 w-full p-2" type="text" name="mrc" :value="old('mrc')" max="45" required autofocus autocomplete="mrc" />
                                <x-input-error :messages="$errors->get('mrc')" class="mt-2" />
                            </div>

                            
                            <div class="form-control">
                                <x-input-label for="police" :value="__('Police')" />
                                <x-text-input id="police" class="block mt-1 w-full p-2" type="text" max="45" name="police" :value="old('police', 'Islam')" required autofocus autocomplete="police" />
                                <x-input-error :messages="$errors->get('police')" class="mt-2" />
                            </div>
                        </div>
                        <div class="flex flex-row justify-center mt-3">
                            <button class="p-2 text-center text-white w-full bg-blue-400 rounded-lg" type="submit">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
