<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/manager.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/advertisements.css"> 

<div class="wrapper flex-row">

    <?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>

    <div class="main-content container">
        <div class="header flex-row">
            <h3>Current Advertisements</h3>
            <button class="btn btn-accent" onclick="showForm()"> + Post Advertisement</button>
        </div>
        <hr>
        
        <div class="search-container">
            <input type="text" 
                class="search-bar" 
                placeholder="Search advertisements"
                aria-label="Search">
        </div>

        <div class="filter flex-row">
            <span>
                <h3>All Ads</h3>
                <p class="text-grey">Showing 73 results</p>
            </span>

            <div class="filter-container">
                <span>Sort by:</span>
                <select id="sortSelect" onchange="sortContent()">
                    <option value="recent">Most recent</option>
                    <option value="views">Highest views</option>
                </select>
                <button id="gridButton" onclick="toggleView()">☰</button>
                </div>
        </div>
        <br><br>

        <div class="ads">
        <?php foreach ($advertisements as $ad): ?> 
        <div class="ad-card flex-row container">
            <div class="image">
                <img src="<?= htmlspecialchars($ad->img) ?>" alt="ad image">
            </div>
            <div class="details flex-col">
                <p class="ad-title"><?= htmlspecialchars($ad->adTitle) ?></p>
                <p class="advertiser">Advertiser ID: <?= htmlspecialchars($ad->advertiserID) ?></p>
                <p class="description"><?= htmlspecialchars($ad->adDescription) ?></p>
                <p class="contact">Link: <a href="<?= htmlspecialchars($ad->link) ?>"><?= htmlspecialchars($ad->link) ?></a></p>
                <div class="status flex-row">
                    <span class="badge <?= $ad->adStatus == 1 ? 'active' : 'inactive' ?>">
                        <?= $ad->adStatus == 1 ? 'Active' : 'Inactive' ?>
                    </span>
                </div>
            </div>
            <div class="ad-actionbtns flex-col">
                <button class="btn btn-accent" onclick="editAd(<?= htmlspecialchars($ad->advertisementID) ?>)">Edit</button>
                <button class="btn btn-del" onclick="deleteAd(<?= htmlspecialchars($ad->advertisementID) ?>)">Delete</button>
            </div>
        </div>
    <?php endforeach ?>

            </div>

        </div>


        <div class="create-ad-form from container hidden"  id="create-ad">
        <div class="title flex-row">
        <i class="fa-solid fa-arrow-left" onclick="postAd()" style="cursor : pointer;"></i> <p class="title">Create Ad</p>
        </div>

            <form action="post">
                <div class="form-field">
                    <lable class="lbl">Title</lable><br>
                    <input type="text" for="title">
                </div>
                <div class="form-field">
                    <lable class="lbl">Advertiser</lable><br>
                    <input type="text" for="advertiser">
                </div>
                <div class="form-field">
                    <lable class="lbl">Advertiser contact no.</lable><br>
                    <input type="text" for="contact">
                </div>
                <div class="form-field">
                    <lable class="lbl">Description</lable><br>
                    <textarea id="description" name="description" rows="6" ></textarea>
                </div>
                <div class="form-field">
                    <lable class="lbl">Link</lable><br>
                    <input type="text" for="link">
                </div>
                <div class="form-field">
                    <lable class="lbl">Expiry date</lable><br>
                    <input type="text" for="name">
                </div>
                <div class="form-field radio-btns flex-row" style="gap : 10px">
                    <input type="radio" name="paid"><label for="paid">Paid</label>
                    <input type="radio" name="pending"><label for="pending">Pending</label>
                </div>
                <div class="links flex-col">
                <div class="form-field img-link">
                    <a href="#">Add Image</a>
                </div>
                <button class="btn btn-accent" onclick="postAd()" href="#">Post Ad</button>
                </div>
            </form>
        </div>


        
    </div>



<script>

const form = document.getElementById("create-ad");

    function showForm() {
        
        if (form.classList.contains("hidden")) {
            form.classList.remove("hidden");
            setTimeout(() => {
                form.classList.add("show");
            }, 50); 
            
        } else {
            form.classList.remove("show");
            form.classList.add("hidden");
        }
    }

    function postAd(){
        form.classList.remove("show");
        setTimeout(() => {
            form.classList.add("hidden");
        }, 500);
    }


    form.addEventListener("submit", function(event) {
        event.preventDefault(); 
        console.log("Form submission prevented!");
    });

    

</script>

