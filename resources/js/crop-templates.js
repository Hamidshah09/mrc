import Cropper from 'cropperjs';
import 'cropperjs/dist/cropper.css';

document.addEventListener('DOMContentLoaded', () => {

    const image = document.getElementById('document-image');

    // This script may be loaded on other pages.
    // Do nothing if the crop-template page isn't present.
    if (!image) {
        return;
    }

    const fieldSelect = document.getElementById('field_name');

    const xInput = document.getElementById('crop-x');
    const yInput = document.getElementById('crop-y');
    const widthInput = document.getElementById('crop-width');
    const heightInput = document.getElementById('crop-height');

    let cropper = null;

    image.addEventListener('load', () => {

        cropper = new Cropper(image, {

            viewMode: 1,

            dragMode: 'crop',

            autoCrop: false,

            movable: true,
            zoomable: true,
            scalable: false,
            rotatable: false,

            cropBoxMovable: true,
            cropBoxResizable: true,

            crop(event) {

                const data = event.detail;

                xInput.value = Math.round(data.x);
                yInput.value = Math.round(data.y);

                widthInput.value =
                    Math.round(data.width);

                heightInput.value =
                    Math.round(data.height);
            }

        });
    });


    fieldSelect.addEventListener('change', () => {

        xInput.value = '';
        yInput.value = '';
        widthInput.value = '';
        heightInput.value = '';

        if (cropper) {
            cropper.clear();
            cropper.setDragMode('crop');
        }
    });


    document
        .getElementById('save-template')
        .addEventListener('click', async () => {

            const fieldName = fieldSelect.value;

            if (!fieldName) {
                alert('Please select a field first.');
                return;
            }

            if (!cropper) {
                alert('Cropper has not loaded yet.');
                return;
            }

            const data = cropper.getData(true);

            if (
                data.width <= 0 ||
                data.height <= 0
            ) {
                alert('Please select an area first.');
                return;
            }

            try {

                const response = await fetch(
                    '/crop-templates',
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',

                            'X-CSRF-TOKEN':
                                document.querySelector(
                                    'meta[name="csrf-token"]'
                                ).getAttribute('content')
                        },

                        body: JSON.stringify({
                            field_name: fieldName,

                            x: Math.round(data.x),
                            y: Math.round(data.y),

                            width: Math.round(data.width),
                            height: Math.round(data.height)
                        })
                    }
                );

                const result = await response.json();

                if (!response.ok) {
                    console.error(result);
                    alert('Unable to save template.');
                    return;
                }

                alert('Crop template saved successfully.');

            } catch (error) {

                console.error(error);

                alert('An error occurred while saving.');
            }
        });
});