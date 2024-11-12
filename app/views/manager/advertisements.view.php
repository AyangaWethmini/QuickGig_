<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/manager.css">
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/advertisements.css"> 

<div class="wrapper flex-row">
    <div id="sidebar" style="width: 224px; height : 100vh; background-color : var(--brand-lavender)">
    
    </div>

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

        <div class="create-ad-form from container hidden"  id="create-ad">
        <div class="title flex-row">
        <i class="fa-solid fa-arrow-left"></i> <p class="title">Create Ad</p>
        </div>

            <form action="post">
                <div class="form-field">
                    <lable class="lbl">Name</lable><br>
                    <input type="text" for="name">
                </div>
                <div class="form-field">
                    <lable class="lbl">Advertiser</lable><br>
                    <input type="text" for="name">
                </div>
                <div class="form-field">
                    <lable class="lbl">Advertiser contact no.</lable><br>
                    <input type="text" for="name">
                </div>
                <div class="form-field">
                    <lable class="lbl">Description</lable><br>
                    <textarea id="description" name="description" rows="6" ></textarea>
                </div>
                <div class="form-field">
                    <lable class="lbl">Category</lable><br>
                    <input type="text" for="name">
                </div>
                <div class="form-field">
                    <lable class="lbl">Expiry date</lable><br>
                    <input type="text" for="name">
                </div>
                <div class="form-field">
                    <lable class="lbl">Tages</lable><br>
                    <input type="text" for="name">
                </div>
                <div class="form-field radio-btns">
                    <input type="radio" name="paid"><label for="paid">Paid</label>
                    <input type="radio" name="pending"><label for="pending">Pending</label>
                </div>
                <div class="links flex-col">
                <div class="form-field img-link">
                    <a href="#">Add Image</a>
                </div>
                <button class="btn btn-accent" onclick="postAd()">Post Ad</button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>

const form = document.getElementById("create-ad");

    function showForm() {
        const bg = document.querySelector(".wrapper");
        
        if (form.classList.contains("hidden")) {
            form.classList.remove("hidden");
            setTimeout(() => {
                form.classList.add("show");
            }, 50); // Delay to match the CSS transition
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

</script>

