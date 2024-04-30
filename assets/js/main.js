document.getElementById('fileInput').addEventListener('change', function(event) {
    var file = event.target.files[0];
    if (file) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var uploadContainer = document.getElementById('uploadContainer');
            var imagePreview = document.getElementById('imagePreview');
            var uploadBorder = document.querySelector('.upload-border');
            var arrowButton = document.getElementById('arrowButton');
            // var arrowButton2 = document.getElementById('arrowButton2');
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
                // arrowButton2.style.display = 'block';
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
    var carousel = document.querySelector('.owl-carousel');

    if (carousel) {
        carousel.addEventListener('click', function(e) {
            var item = e.target.closest('.item');

            if (item) {
                var thumbnailPath = item.getAttribute('data-thumbnail-path');

                if (thumbnailPath) {
                    document.getElementById('mainImage').src = thumbnailPath;
                }
            }
        });
    }
});



// // document.addEventListener('DOMContentLoaded', function() {
// //     const hash = window.location.hash;
// //     if (hash === '#brightness') {
// //         document.querySelector('#list-brightness-list').classList.add('active');
// //         document.querySelector('#list-brightness').classList.add('show', 'active');
// //     }
// // });

// // For slider

// const slider = document.getElementById("brightnessRange");
// // const output = document.getElementById("brightnessValue");
// // output.innerHTML = slider.value + '%';

// // slider.oninput = function() {
// //   output.innerHTML = this.value + '%';
// // }


// reset buttons
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.reset-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const rangeId = this.getAttribute('data-for');
            const rangeInput = document.getElementById(rangeId);
            if (rangeInput) {
                if (rangeId === 'thresholdingRanges') {
                    rangeInput.value = 127;
                    // console.log("Nigana koooo");
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

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('list-tab').addEventListener('click', function(e) {
        const importTabIsActive = e.target.id === 'list-import-list' || e.target.closest('#list-import-list');
        
        document.getElementById('topLeftLogo').style.display = importTabIsActive ? '' : 'none';
        document.getElementById('resetForm').style.display = importTabIsActive ? '' : 'none';
    });
});

document.addEventListener('DOMContentLoaded', function() {
    if(window.location.hash === '#list-edit') {
        // Open the edit tab
        document.getElementById('list-edit-list').click();
    }

    document.getElementById('editImagesBtn').addEventListener('click', function() {
        document.getElementById('list-import-list').click();
    });

    document.getElementById('arrowButton').addEventListener('click', function() {
        window.location.hash = '#list-edit';
        window.location.reload(true);
    });
    // document.getElementById('arrowButtones').addEventListener('click', function() {
    //     window.location.hash = '#list-edit';
    //     window.location.reload(true);
    // });
});

document.addEventListener('DOMContentLoaded', function () {
    const boxesInput = document.getElementById('showObjectBoxes');
    const centerInput = document.getElementById('showImageCenter');
    const imageToChange = document.getElementById('switchImage');

    boxesInput.addEventListener('change', function() {
        if (this.checked) {
            imageToChange.src = 'boxes.jpg';
        } else {
            imageToChange.src = targetFileValue;
        }
    });

    centerInput.addEventListener('change', function(){
        if (this.checked) {
            imageToChange.src = 'centroid.jpg';
        } else {
            imageToChange.src = targetFileValue; 
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const rotateRange = document.getElementById('rotateRange');
    const rotateValue = document.getElementById('rotateValue');

    rotateRange.addEventListener('input', function() {
        const value = rotateRange.value === '' ? 0 : rotateRange.value;
        rotateValue.textContent = value;
        rotateRangeValue(value);
    });

    rotateValue.addEventListener('input', function() {
        const value = rotateValue.textContent === '' ? 0 : rotateValue.textContent;
        rotateRange.value = value;
        rotateRangeValue(value);
    });

    function rotateRangeValue(value) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'rotate.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (this.status === 200) {
                console.log(this.responseText);
                document.getElementById('switchImage').src = '../assets/img/rotated/' + this.responseText + '?t=' + new Date().getTime();
            }
        };

        xhr.send(`rotateRange=${value}`);
    }
});


const rotateRange = document.getElementById('rotateRange');
const rotateValue = document.getElementById('rotateValue');

function updateRotateValue() {
    rotateValue.textContent = rotateRange.value;
}

rotateRange.addEventListener('input', updateRotateValue);

updateRotateValue();

//translate input
// document.addEventListener('DOMContentLoaded', function() {
//     document.getElementById('xtranslate').addEventListener('input', translationxy);
//     document.getElementById('ytranslate').addEventListener('input', translationxy);

//     function translationxy(){
//         var xtranslate = document.getElementById('xtranslate').value;
//         var ytranslate = document.getElementById('ytranslate').value;

//         var xhr = new XMLHttpRequest();
//         xhr.open('POST', 'rotate.php', true);
//         xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

//         xhr.onload = function() {
//             if (this.status == 200) {
//                 console.log(this.responseText);
//             }
//         };
//         xhr.send(`xtranslate=${xtranslate}&ytranslate=${ytranslate}`);
//     }
// });
