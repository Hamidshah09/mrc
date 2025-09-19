<x-guest-layout>
    <x-navbar/>
    <!-- Hero Section -->
    <section class="mt-20">
        <div class="flex items-center justify-center">
             <h1 class="text-3xl text-center md:text-4xl font-bold bg-clip-text blue-400 drop-shadow-lg">
            Pending Questions
        </h1>
        </div>
    </section>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto sm:px-6 mt-5 mt-3 bg-white/50 backdrop-blur-md border border-white/30 rounded-xl py-8 shadow p-16">
        <!-- Left: Info -->

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Question</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @foreach ($questions as $question)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 text-sm text-gray-800">{{ $question->created_at }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">{{ $question->question }}</td>
                        <td class="px-6 py-4 text-sm">
                            <a href="#" onclick="openVerifyModal({{ $question->id }})">
                                <x-icons.check-circle class="text-green-500 hover:text-green-700" />
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
    <!-- Reusable Verification Modal -->
    <div id="answearModal" class="fixed inset-0 z-50 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded shadow-md w-full max-w-md">
            <h2 class="text-lg font-semibold mb-4">Submit Answear</h2>
            <form id="answearForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="answer" class="block text-sm font-medium text-gray-700">Answer</label>
                    <textarea name="answer" id="answer" class="mt-1 block w-full border border-gray-300 rounded-md" rows="3" required></textarea>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeVerifyModal()" class="px-4 py-2 text-sm bg-gray-300 rounded hover:bg-gray-400">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-sm bg-green-900 text-white rounded hover:bg-green-700">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function openVerifyModal(id) {
            const modal = document.getElementById('answearModal');
            const form = document.getElementById('answearForm');
            // Construct dynamic route URL
            form.action = `/chatbot/pending-answers/${id}`;

            // Show the modal
            modal.classList.remove('hidden');
        }

        function closeVerifyModal() {
            document.getElementById('answearModal').classList.add('hidden');
            document.getElementById('answearForm').reset();
        }
    </script>


</x-guest-layout>