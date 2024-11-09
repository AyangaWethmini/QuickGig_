<?php require APPROOT . '/views/inc/header.php'; ?>

<style>
    /* Basic Sidebar Styles */
.admin-sidebar {
    background-color: #2c3e50; /* Dark blue-gray */
    color: #ecf0f1; /* Light gray */
    width: 250px;
    height: 100vh;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* .signup_logo img {
    width: 150px;
    margin: 0 auto 20px;
    display: block;
} */

/* Anchor List */
.admin-anchor-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.admin-anchor-list a {
    display: flex;
    align-items: center;
    padding: 10px;
    text-decoration: none;
    color: #ecf0f1;
    font-size: 16px;
    border-radius: 8px;
    transition: background 0.3s, color 0.3s;
}

.admin-anchor-list a .fa-solid {
    font-size: 18px;
    margin-right: 8px;
}

/* Active Link Styling */
.admin-anchor-list a.active,
.admin-anchor-list a:hover {
    background-color: #34495e; /* Slightly lighter blue-gray */
    color: #ffffff;
}

/* Divider Styles */
.admin-anchor-list hr {
    border: 0;
    border-top: 1px solid #7f8c8d;
    margin: 10px 0;
}

/* Profile Section */
.admin-sidebar .profile {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: auto;
    padding-top: 20px;
    border-top: 1px solid #7f8c8d;
}

.admin-sidebar .profile img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.profile-info {
    font-size: 14px;
    color: #bdc3c7;
}

.profile-info .name {
    font-weight: bold;
    color: #ecf0f1;
}

.profile-info .email {
    font-size: 12px;
    color: #7f8c8d;
}

/* Settings Section */
.settings ul {
    list-style: none;
    padding: 0;
}

.settings a {
    display: flex;
    align-items: center;
    padding: 10px;
    color: #ecf0f1;
    font-size: 16px;
    border-radius: 8px;
    transition: background 0.3s, color 0.3s;
}

.settings a .icon {
    margin-right: 8px;
}

.settings a:hover {
    background-color: #34495e;
    color: #ffffff;
}

</style>

<div class="flex-row">
<div id="sidebar">
    
    </div>
    
    <div class="main-content  container">
        <div class="header flex-row">
            <span class="greeting">
            <h3>Good morning! Maria</h3>
            <p class="text-grey">Here is the statistics from 12th July - 12th August</p>
            </span>
            <span class="date">
                <p>Jul12-Aug12</p>
            </span>
        </div>
        <div class="overview flex-row">
            <div class="flex-row">
                <h1>23</h1>
                <p>Ads posted</p>    
            </div>
            <div class="flex-row">
                <h1>23</h1>
                <p>Ads posted</p> 
            </div>
            <div class="flex-row">
                <h1>23</h1>
                <p>Ads posted</p> 
            </div>
            <div class="flex-row">
                <h1>23</h1>
                <p>Ads posted</p> 
            </div>
        </div>
        <hr>
        <div class="manager-sections">
            <div class="chart-overview">

            </div>
            <div class="messages">

            </div>
        </div>
        <div class="flex-row">
            <button class="btn btn-accent">Post Advertisement</button>
            <button class="btn btn-accent">Review Ads</button>
        </div>
    </div>
</div>


<script src="<?=ROOT?>/assets/js/sidebar.js">
   
    createSidebar(
        [
            {
                "href" : "#",
                "icon" : "#",
                "text" : "home"
            },
            {
                "href" : "#",
                "icon" : "#",
                "text" : "home"
            },
            

        ]
    )
</script>


<?php require APPROOT . '/views/inc/footer.php'; ?>

 
    