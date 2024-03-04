<section class="main justify-content-center">
        <div class="container d-flex justify-content-center align-items-center" style="height: 700px; width: 1200px;">
            <div class="container border rounded-2 main-border main-container">
                <div class="row">
                    <div class="col-1 p-0">
                      <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active p-4 text-center" id="list-import-list" data-bs-toggle="list" href="#list-import" role="tab" aria-controls="list-import"><i class="fa-solid fa-file-import fa-lg" style="color: #fafafa;"></i></i>
                            <span class="hover-text">Import image</span>
                            </a>
                            <a class="list-group-item list-group-item-action p-4 text-center" id="list-brightness-list" data-bs-toggle="list" href="#list-brightness" role="tab" aria-controls="list-brightness"><i class="fa-solid fa-sun fa-lg" style="color: #ffffff;"></i>
                            <span class="hover-text">Brightness</span>
                            </a>
                            <a class="list-group-item list-group-item-action p-4 text-center" id="list-grayscale-list" data-bs-toggle="list" href="#list-grayscale" role="tab" aria-controls="list-grayscale"><i class="fa-solid fa-circle-half-stroke fa-lg" style="color: #f7f9fd;"></i>
                            <span class="hover-text">Grayscale</span>
                            </a>
                            <a class="list-group-item list-group-item-action p-4 text-center" id="list-bnw-list" data-bs-toggle="list" href="#list-bnw" role="tab" aria-controls="list-bnw"><i class="fa-solid fa-droplet fa-lg" style="color: #fcfcfd;"></i>
                            <span class="hover-text">Black & White</span>
                            </a>
                            <a class="list-group-item list-group-item-action p-4 text-center" id="list-filters-list" data-bs-toggle="list" href="#list-filters" role="tab" aria-controls="list-filters"><i class="fa-solid fa-filter fa-lg" style="color: #ffffff;"></i>
                            <span class="hover-text">Filters</span>
                            </a>
                            <a class="list-group-item list-group-item-action p-4 text-center" id="list-colors-list" data-bs-toggle="list" href="#list-colors" role="tab" aria-controls="list-colors"><i class="fa-solid fa-palette fa-lg" style="color: #ffffff;"></i>
                            <span class="hover-text">Colors Hue</span>
                            </a>
                            <a class="list-group-item list-group-item-action p-4 text-center" id="list-advance-list" data-bs-toggle="list" href="#list-advance" role="tab" aria-controls="list-advance"><i class="fa-solid fa-sliders fa-lg" style="color: #fafafa;"></i>
                            <span class="hover-text">Adjustments</span>
                            </a>
                            <a class="list-group-item list-group-item-action p-4 text-center" id="list-export-list" data-bs-toggle="list" href="#list-export" role="tab" aria-controls="list-export"><i class="fa-solid fa-file-export fa-lg" style="color: #ffffff;"></i>
                            <span class="hover-text">Export File</span>
                            </a>
                      </div>
                    </div>
                    <div class="col-11">
                      <div class="tab-content h-100" id="nav-tabContent" style="position: relative;">
                        <img src="assets/img/logo.png" alt="" class="top-left-logo">
                        <div class="tab-pane fade show active h-100" id="list-import" role="tabpanel" aria-labelledby="list-import-list">
                            <div class="container h-100 d-flex justify-content-center align-items-center">
                                <div class="upload-border d-flex flex-column justify-content-center align-items-center">
                                    <input type="file" id="fileInput" style="display: none;" accept="image/*"/>
                                    <div id="uploadContainer">
                                        <i class="fa-solid fa-upload fa-2xl" style="color: #ffffff; cursor: pointer;" onclick="document.getElementById('fileInput').click();"></i>
                                        <span style="color: #ffffff; margin-top: 30px;">Upload image from folder</span>
                                    </div>
                                    <img id="imagePreview" src="" alt="">
                                </div>
                            </div>
                        </div>                                               
                        <div class="tab-pane fade show" id="list-brightness" role="tabpanel" aria-labelledby="list-brightness-list">
                            Filters
                        </div>
                        <div class="tab-pane fade" id="list-grayscale" role="tabpanel" aria-labelledby="list-grayscale-list">...</div>
                        <div class="tab-pane fade" id="list-bnw" role="tabpanel" aria-labelledby="list-bnw-list">...</div>
                        <div class="tab-pane fade" id="list-filters" role="tabpanel" aria-labelledby="list-filters-list">...</div>
                        <div class="tab-pane fade" id="list-colors" role="tabpanel" aria-labelledby="list-colors-list">...</div>
                        <div class="tab-pane fade" id="list-advance" role="tabpanel" aria-labelledby="list-advance-list">...</div>
                        <div class="tab-pane fade" id="list-export" role="tabpanel" aria-labelledby="list-export-list">...</div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
</section>