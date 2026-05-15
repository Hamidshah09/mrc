<div class="space-y-1 text-xs">

    @foreach($statuses as $status)

        <div class="flex items-center justify-between gap-2">

            {{-- LABEL --}}
            <span class="font-medium text-gray-600 whitespace-nowrap">
                {{ $status['label'] }}
            </span>

            {{-- VALUE --}}
            <span>
                @if($status['type'] === 'boolean')

                    @if($status['value'] == 1)

                        <x-solar-danger-triangle-line-duotone
                            class="h-4 w-4 text-red-500"
                            title="Found"/>

                    @elseif($status['value'] == 0)

                        <x-heroicon-o-check-circle
                            class="h-4 w-4 text-green-500"
                            title="Not Found"/>

                    @else

                        <x-solar-question-circle-linear
                            class="h-4 w-4 text-gray-400"
                            title="Not Checked"/>

                    @endif

                @elseif($status['type'] === 'file')

                    @if($status['value'])

                        <x-heroicon-o-document-check
                            class="h-4 w-4 text-green-500"
                            title="Uploaded"/>

                    @else

                        <x-heroicon-o-x-circle
                            class="h-4 w-4 text-red-400"
                            title="Missing"/>

                    @endif

                @endif
            </span>

        </div>

    @endforeach

</div>