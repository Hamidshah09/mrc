<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bulk Upload Nikkahnama Documents
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6">

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded">

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif

        <div class="bg-white shadow rounded p-6">

            <form
                id="bulk-upload-form"
                method="POST"
                action="{{ route('mrc.bulk-upload.store') }}"
                enctype="multipart/form-data"
            >

                @csrf

                <label class="block font-medium mb-2">
                    Select document images
                </label>

                <input
                    type="file"
                    id="images-input"
                    name="images[]"
                    multiple
                    accept="image/jpeg,image/png"
                    class="w-full border rounded p-2"
                >

                <p class="text-sm text-gray-500 mt-2">
                    You can select multiple document images.
                    Files are uploaded automatically in batches of 10.
                </p>

                <div id="upload-progress-wrapper" class="hidden mt-4">
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span id="upload-status-text">Uploading...</span>
                        <span id="upload-progress-text">0 / 0</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded h-3 overflow-hidden">
                        <div
                            id="upload-progress-bar"
                            class="bg-blue-600 h-3 rounded transition-all duration-300"
                            style="width: 0%"
                        ></div>
                    </div>
                </div>

                <div
                    id="upload-messages"
                    class="mt-4 space-y-2"
                ></div>

                <button
                    type="submit"
                    id="upload-button"
                    class="mt-6 bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    Upload Documents
                </button>

            </form>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const form = document.getElementById('bulk-upload-form');
            const input = document.getElementById('images-input');
            const button = document.getElementById('upload-button');
            const progressWrapper = document.getElementById('upload-progress-wrapper');
            const progressBar = document.getElementById('upload-progress-bar');
            const progressText = document.getElementById('upload-progress-text');
            const statusText = document.getElementById('upload-status-text');
            const messages = document.getElementById('upload-messages');

            const BATCH_SIZE = 10;

            form.addEventListener('submit', function (event) {

                event.preventDefault();

                const files = Array.from(input.files || []);

                if (files.length === 0) {
                    showMessage('Please select at least one image.', 'error');
                    return;
                }

                button.disabled = true;
                messages.innerHTML = '';
                progressWrapper.classList.remove('hidden');

                uploadBatches(files);
            });

            async function uploadBatches(files) {

                const total = files.length;
                let uploaded = 0;
                let failed = 0;

                updateProgress(uploaded, total, 'Uploading...');

                for (let start = 0; start < total; start += BATCH_SIZE) {

                    const batch = files.slice(start, start + BATCH_SIZE);
                    const batchNumber = (start / BATCH_SIZE) + 1;

                    statusText.textContent =
                        `Uploading batch ${batchNumber} (${batch.length} files)...`;

                    const formData = new FormData();

                    batch.forEach(function (file) {
                        formData.append('images[]', file);
                    });

                    try {

                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': form
                                    .querySelector('input[name="_token"]')
                                    ?.value,
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                            },
                            body: formData,
                        });

                        const result = await response.json().catch(() => null);

                        if (!response.ok) {

                            failed += batch.length;

                            const serverMessage =
                                result?.message ||
                                `Batch ${batchNumber} failed (HTTP ${response.status}).`;

                            showMessage(serverMessage, 'error');
                        } else {

                            uploaded += result.uploaded || batch.length;
                            updateProgress(uploaded, total, 'Uploading...');
                        }

                    } catch (networkError) {

                        failed += batch.length;
                        showMessage(
                            `Batch ${batchNumber} failed: network error.`,
                            'error'
                        );
                    }
                }

                if (failed === 0) {

                    updateProgress(uploaded, total, 'Completed');

                    showMessage(
                        `${uploaded} document(s) uploaded successfully.`,
                        'success'
                    );

                    input.value = '';

                    setTimeout(function () {
                        window.location.reload();
                    }, 1500);

                } else {

                    updateProgress(uploaded, total, 'Finished with errors');

                    showMessage(
                        `${uploaded} uploaded, ${failed} failed. ` +
                        'Please retry the failed files.',
                        'error'
                    );

                    button.disabled = false;
                }
            }

            function updateProgress(done, total, label) {

                const percent = total > 0
                    ? Math.round((done / total) * 100)
                    : 0;

                progressBar.style.width = `${percent}%`;
                progressText.textContent = `${done} / ${total}`;
                statusText.textContent = label;
            }

            function showMessage(text, type) {

                const div = document.createElement('div');

                div.className = type === 'success'
                    ? 'p-3 bg-green-100 text-green-700 rounded'
                    : 'p-3 bg-red-100 text-red-700 rounded';

                div.textContent = text;
                messages.appendChild(div);
            }
        });
    </script>

</x-app-layout>