<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require_once APPROOT . '/views/inc/protectedRoute.php';
protectRoute([2]); ?>
<?php require APPROOT . '/views/components/navbar.php'; ?>

<link rel="stylesheet" href="<?= ROOT ?>/assets/css/jobProvider/post_job.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/popUpJobForm.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/mapModal.css">
<link rel="stylesheet" href="<?= ROOT ?>/assets/css/components/errorPopUp.css">

<div class="wrapper flex-row">
    <?php require APPROOT . '/views/seeker/seeker_sidebar.php'; ?>

    <div class="main-content container post-job-form">
        <p class="heading">
            Availability
        </p>

        <form id="postJobForm" class="form-section container" action="<?php echo ROOT ?>/seeker/availability" method="POST">
            <hr>
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">
                        Description
                    </p>
                </div>
                <div class="user-input" style="align-items: center; margin-top: 10px;">
                    <textarea name="description" rows="5" cols="30" required></textarea>
                </div>
            </div>
            <hr>
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">
                        Type of Employment
                    </p>
                    <p class="text-grey desc">
                        Select One
                    </p>
                </div>
                <div class="user-input" style=" margin-top:10px;">
                    <p class="lbl flex-row" style="gap:10px;justify-content: space-between;">Day time <input type="radio" name="shift" value="Day"> </p><br>
                    <p class="lbl flex-row" style="gap:10px;justify-content: space-between;">Night time<input type="radio" name="shift" value="Night"> </p> <br>
                </div>
            </div>
            <hr>
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">
                        Salary (Per hour)
                    </p>
                    <p class="text-grey desc">
                        Please set the estimated salary range for the role.
                    </p>
                </div>
                <div class="user-input">
                    <div class="salary-ph flex-row">
                        <input type="text" name="salary" id="salary-per-hr" required>
                        <select id="currency-select" class="currency-select" name="currency">
                            <option value="LKR">LKR</option>
                            <option value="USD">USD</option>
                            <option value="EUR">EUR</option>
                            <option value="GBP">GBP</option>
                            <option value="AUD">AUD</option>
                            <option value="CAD">CAD</option>
                            <option value="JPY">JPY</option>
                            <option value="CNY">CNY</option>
                            <option value="INR">INR</option>
                            <option value="NZD">NZD</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">
                        Duration
                    </p>
                    <p class="text-grey desc">
                        Specify the start and end time for the job.
                    </p>
                </div>
                <div class="user-input duration flex-row">
                    <div class="start-time flex-col">
                        <div class="label">
                            <label for="start-time-select">
                                <p class="lbl">Start Time</p>
                            </label>
                        </div>
                        <div class="input-boxes">
                            <input type="time" id="timeInput" name="timeFrom" required>
                        </div>
                    </div>
                    <div class="end-time flex-col">
                        <div class="label">
                            <label for="end-time-select">
                                <p class="lbl">End Time</p>
                            </label>
                        </div>
                        <div class="input-boxes">
                            <input type="time" id="timeInput" name="timeTo" required>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">
                        Date
                    </p>
                    <p class="text-grey desc">
                        Specify the Date for the Job
                    </p>
                </div>
                <div class="user-input flex-col ">
                    <p class="lbl">Date</p>
                    <input type="date" id="dateInput" name="availableDate" required>
                </div>
            </div>
            <hr>
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">
                        Tags
                    </p>
                    <p class="text-grey desc">You can add skills, jobs and more</p>
                </div>
                <div class="user-input">
                    <div class="user-input flex-col">
                        <div class="flex-row" style="gap: 20px;">
                            <div class="btn btn-trans" onclick="showAddTagPopup('job')" name="categories">+ Add Categories</div>
                        </div>
                        <div id="tags-container" class="tags-container"></div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-section flex-row container">
                <div class="container right-container">
                    <p class="title">Add Location</p>
                    <p class="text-grey desc">Add the location where the employee should attend</p>
                </div>

                <div class="user-input">
                    <button type="button" class="btn btn-trans" onclick="openMapModal()">Add your Location</button>
                    <p>Or</p>
                    <input type="text" name="location" id="locationInput" placeholder="Type your location here" required>
                </div>
            </div>
            <hr>
            <div class="post-job-buttons flex-row">
                <button class="btn btn-accent" type="button" onclick="window.location.href='<?= ROOT ?>/seeker/jobListing_myJobs'">Discard</button>
                <button class="btn btn-accent" type="submit">Finish</button>
            </div>

            <div id="tag-limit-popup" class="modal" style="display: none;">
                <div class="modal-content">
                    <p>You can only add up to five categories.</p>
                    <button id="popup-ok" class="popup-btn-ok" type="button">Ok</button>
                </div>
            </div>

            <div id="add-tag-popup" class="modal" style="display: none;">
                <div class="modal-content">
                    <p>Enter job category:</p>
                    <input type="text" id="tag-input" class="popup-input">
                    <button id="add-tag-btn" class="popup-btn-add" type="button">Add</button>
                    <button id="cancel-tag-btn" class="popup-btn-cancel" type="button">Cancel</button>
                </div>
            </div>

            <div id="mapModal" class="map-modal" style="display:none;">
                <div id="map"></div>
                <div class="mapBtns">
                    <button type="button" class="mapBtn" onclick="saveLocation()">Save Location</button>
                    <button type="button" class="mapBtn" onclick="closeMapModal()">Cancel</button>
                </div>
            </div>

            <div id="error-popup"></div>

        </form>

    </div>

</div>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyByhOqNUkNdVh5JDlawmbh-fxmgbVvE2Cg&libraries=places&callback=initMap"></script>

<script>
    let map;
    let marker;
    let selectedLocation = '';
    let mapInitialized = false;

    function showAddTagPopup(type) {
        const tagContainer = document.getElementById('tags-container');
        if (tagContainer.children.length >= 5) {
            showTagLimitPopup();
            return;
        }

        var modal = document.getElementById('add-tag-popup');
        modal.style.display = 'flex';

        document.getElementById('add-tag-btn').onclick = function() {
            const tagText = document.getElementById('tag-input').value;
            if (tagText) {
                addTag(tagText);
                modal.style.display = 'none';
                document.getElementById('tag-input').value = '';
            }
        };

        document.getElementById('cancel-tag-btn').onclick = function() {
            modal.style.display = 'none';
            document.getElementById('tag-input').value = '';
        };
    }

    function addTag(tagText) {
        const tagContainer = document.getElementById('tags-container');

       
        const tag = document.createElement('div');
        tag.className = 'tag';
        tag.textContent = tagText;

        
        const removeBtn = document.createElement('span');
        removeBtn.className = 'remove-btn';
        removeBtn.textContent = '×';
        removeBtn.onclick = () => tag.remove();

       
        tag.appendChild(removeBtn);

        
        tagContainer.appendChild(tag);

       
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'categories[]';
        hiddenInput.value = tagText;
        tag.appendChild(hiddenInput);
    }

    function showTagLimitPopup() {
        var modal = document.getElementById('tag-limit-popup');
        modal.style.display = 'flex';

        document.getElementById('popup-ok').onclick = function() {
            modal.style.display = 'none';
        };
    }

    
    const today = new Date().toISOString().split("T")[0];
    document.getElementById('dateInput').setAttribute('min', today);

    function submitDate() {
        const selectedDate = document.getElementById('availableDate').value;
        if (selectedDate) {
            alert(`You selected: ${selectedDate}`);
           
        } else {
            alert("Please select a date.");
        }
    }

    function initAutocomplete() {
        const locationInput = document.getElementById('locationInput');

       
        autocomplete = new google.maps.places.Autocomplete(locationInput, {
           
            componentRestrictions: {
                country: "lk"
            } 
        });

        
        autocomplete.addListener('place_changed', () => {
            const place = autocomplete.getPlace();
            if (place.geometry) {
                
                selectedLocation = `${place.geometry.location.lat()},${place.geometry.location.lng()}`;
            }
        });
    }

    function initMap() {
        const defaultLatLng = {
            lat: 6.9271,
            lng: 79.8612
        }; 

        map = new google.maps.Map(document.getElementById("map"), {
            center: defaultLatLng,
            zoom: 13,
            clickableIcons: false,
        });

        map.addListener("click", (e) => {
            placeMarkerAndPanTo(e.latLng, map);
        });

        initAutocomplete();
    }

    function openMapModal() {
        const modal = document.getElementById('mapModal');
        modal.style.display = 'block';

       
        setTimeout(() => {
            if (!mapInitialized) {
                initMap();
                mapInitialized = true;
            } else {
                google.maps.event.trigger(map, "resize");
                map.setCenter(marker ? marker.getPosition() : {
                    lat: 6.9271,
                    lng: 79.8612
                });
            }
        }, 200); 
    }

    function closeMapModal() {
        document.getElementById('mapModal').style.display = 'none';
    }

    function saveLocation() {
        const geocoder = new google.maps.Geocoder();
        const latlng = {
            lat: parseFloat(selectedLocation.split(',')[0]),
            lng: parseFloat(selectedLocation.split(',')[1])
        };

        geocoder.geocode({
            location: latlng
        }, function(results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    document.getElementById('locationInput').value = results[0].formatted_address;
                } else {
                    document.getElementById('locationInput').value = selectedLocation; 
                }
            } else {
                document.getElementById('locationInput').value = selectedLocation; 
            }

            closeMapModal();
        });
    }


    function placeMarkerAndPanTo(latLng, map) {
        if (marker) {
            marker.setMap(null);
        }

        marker = new google.maps.Marker({
            position: latLng,
            map: map,
        });

        map.panTo(latLng);

        selectedLocation = `${latLng.lat()},${latLng.lng()}`;
    }

    document.getElementById('locationInput').value = selectedLocation; 
    closeMapModal(); 
    mapInitialized = true; 
    document.getElementById('mapModal').style.display = 'none'; 

    const form = document.getElementById("postJobForm");
    const popup = document.getElementById("error-popup");

    form.addEventListener("submit", function(e) {
        
        e.preventDefault();

        const description = document.querySelector("textarea[name='description']").value.trim();
        const salary = document.getElementById("salary-per-hr").value.trim();

        let errors = [];

     
        if (!description || description.replace(/\s+/g, '') === '') {
            errors.push("Description is required and cannot be just spaces.");
        }

      
        if (!salary || salary.replace(/\s+/g, '') === '') {
            errors.push("Salary is required and cannot be just spaces.");
        } else if (!/^\d+(\.\d{1,2})?$/.test(salary)) {
            errors.push("Salary must be a valid number (e.g., 500, 500.75).");
        } else if (salary.length > 8) {
            errors.push("Salary must not exceed 8 characters in total.");
        }

        if (errors.length > 0) {
            showPopup(errors.join("<br>"));
            return false; 
        } else {
            
            this.submit();
        }
    });

    function showPopup(message) {
        popup.innerHTML = message;
        popup.style.display = "block";

        setTimeout(() => {
            popup.style.display = "none";
        }, 3000); 
    }
</script>