document.getElementById('fileInput').addEventListener('change', function(event) {
    var file = event.target.files[0];
    if (file) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var uploadContainer = document.getElementById('uploadContainer');
            var imagePreview = document.getElementById('imagePreview');
            var uploadBorder = document.querySelector('.upload-border');
            var arrowButton = document.getElementById('arrowButton');
            var uploadMsg = document.getElementById('uploadMsg');
            var progressPercentage = document.getElementById('progressPercentage');

            uploadContainer.style.display = 'none';
            uploadBorder.style.cssText = 'border: none !important;';
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
            uploadMsg.style.display = 'block';
            progressPercentage.textContent = '0%';

            var progress = 0;
            var interval = setInterval(function() {
                progress += 1; 
                progressPercentage.textContent = progress + '%';
                if (progress >= 100) {
                    clearInterval(interval); 
                }
            }, 100);

            var formData = new FormData();
            formData.append('fileToUpload', file);

            fetch('./upload.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); 
                clearInterval(interval);
                progressPercentage.textContent = '100%';
                arrowButton.style.display = 'block';
                uploadMsg.style.display = 'none';
            })
            .catch(error => {
                console.error('Error:', error);
                clearInterval(interval); 
            });
        };

        reader.readAsDataURL(file);
    }
});


function reloadPage() {
    window.location.href = 'index.php'; 
    // window.location.href = 'grayscale.php'; 
}

document.addEventListener('DOMContentLoaded', function() {
    // Attach a click event listener to the carousel's container
    var carousel = document.querySelector('.owl-carousel');

    if (carousel) {
        carousel.addEventListener('click', function(e) {
            // Check if the clicked element is an item
            var item = e.target.closest('.item');

            if (item) {
                // Retrieve the thumbnail path from the clicked item's data attribute
                var thumbnailPath = item.getAttribute('data-thumbnail-path');

                if (thumbnailPath) {
                    // Update the main image's src attribute
                    document.getElementById('mainImage').src = thumbnailPath;
                }
            }
        });
    }
});



// document.addEventListener('DOMContentLoaded', function() {
//     const hash = window.location.hash;
//     if (hash === '#brightness') {
//         document.querySelector('#list-brightness-list').classList.add('active');
//         document.querySelector('#list-brightness').classList.add('show', 'active');
//     }
// });

// For slider

const slider = document.getElementById("brightnessRange");
const output = document.getElementById("brightnessValue");
output.innerHTML = slider.value + '%';

slider.oninput = function() {
  output.innerHTML = this.value + '%';
}


// reset buttons
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.reset-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const rangeId = this.getAttribute('data-for');
            const rangeInput = document.getElementById(rangeId);
            if (rangeInput) {
                if (rangeId === 'thresholdingRange') {
                    rangeInput.value = 127;
                    console.log("Nigana koooo");
                } else {
                    rangeInput.value = 0; 
                }
                rangeInput.dispatchEvent(new Event('input'));
            }

            const rgbValueInput = document.getElementById('rgbValue');
            if (rgbValueInput) {
                rgbValueInput.value = "Reseting...."; 
            }
        });
    });
});

// document.querySelector('.threshold-reset-btn').addEventListener('click', function() {
//     // Reset the value of the range slider to 127
//     document.getElementById('thresholdingRange').value = 127;
// });
