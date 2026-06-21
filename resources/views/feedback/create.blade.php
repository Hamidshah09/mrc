<x-guest-layout>
<div class="min-h-screen bg-gray-100 flex items-center justify-center p-4 sm:p-8">
    <div class="w-full max-w-3xl bg-white rounded-lg shadow-md p-4 sm:p-10">
        <h1 class="text-2xl sm:text-3xl font-semibold mb-4">We value your feedback</h1>
        <form method="POST" action="{{ route('feedback.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Service (optional)</label>
                <select name="service_type_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 px-3 text-lg">
                    <option value="">-- Select (optional) --</option>
                    @if(isset($services) && $services->count())
                        @foreach($services as $s)
                            <option value="{{ $s->id }}">{{ $s->service }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Document No (optional)</label>
                <input type="text" name="document_no" placeholder="Document number or reference" class="block w-full rounded-md border-gray-300 py-2 px-3 text-lg" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Your name (optional)</label>
                <input type="text" name="citizen_name" placeholder="Citizen name" class="block w-full rounded-md border-gray-300 py-2 px-3 text-lg" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                <div class="flex items-center space-x-3" id="rating-stars">
                    @for($i=1;$i<=5;$i++)
                        <button type="button" data-value="{{ $i }}" class="star text-3xl text-gray-300 hover:text-yellow-400 focus:outline-none">★</button>
                    @endfor
                </div>
                <input type="hidden" id="rating" name="rating" value="5">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Suggestions / Complaint</label>
                <textarea name="suggestions" required placeholder="Write your suggestion or complaint here" class="block w-full rounded-md border-gray-300 py-3 px-3 text-lg min-h-[160px]"></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="reset" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700">Clear</button>
                <button type="submit" class="px-6 py-2 rounded-md bg-indigo-600 text-white">Submit</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function(){
        const stars = Array.from(document.querySelectorAll('#rating-stars .star'));
        const ratingInput = document.getElementById('rating');
        function setStars(n){
            stars.forEach((s, i) => {
                s.classList.toggle('text-yellow-400', i < n);
                s.classList.toggle('text-gray-300', i >= n);
            });
        }
        setStars(5);
        stars.forEach((el, idx) => {
            el.addEventListener('click', () => {
                const val = idx + 1;
                ratingInput.value = val;
                setStars(val);
            });
        });
    });
</script>
</x-guest-layout>