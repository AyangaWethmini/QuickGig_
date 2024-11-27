<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="<?=ROOT?>/assets/css/manager/helpCenter.css">
<?php include APPROOT . '/views/components/navbar.php'; ?>

<div class="wrapper flex-row">
<?php require APPROOT . '/views/manager/manager_sidebar.php'; ?>
    <div class="main-content container flex-col" style="margin-left: 300px;">
        <div class="header container flex-row">
            <h3>Help Center</h3>
        </div>
        <hr>
        <div class="help-overview container flex-col">
            <div class="card flex-row">
                <h1>12</h1>
                <p>Questions to be answered</p>
            </div>
        </div>

        <div class="help-questions container flex-col">
            <div class="question flex-col">
                <h3>Question Title</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nobis optio necessitatibus voluptatem ullam ut tempore sunt architecto? Voluptate cum assumenda, est omnis a animi doloremque ratione iusto laborum rerum. Sed.</p>
                <div class="date-time flex-row text-grey" style="font-size: 12px; gap: 10px;">
                    <p>2024-01-01</p>
                    <p> at 12:00:00</p>
                </div>
                <textarea placeholder="send a reply"></textarea>
                <button class="btn btn-accent">Reply</button>
            </div>


            <div class="question flex-col">
                <h3>Question Title</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nobis optio necessitatibus voluptatem ullam ut tempore sunt architecto? Voluptate cum assumenda, est omnis a animi doloremque ratione iusto laborum rerum. Sed.</p>
                <div class="date-time flex-row text-grey" style="font-size: 12px; gap: 10px;">
                    <p>2024-01-01</p>
                    <p> at 12:00:00</p>
                </div>
                <textarea placeholder="send a reply"></textarea>
                <button class="btn btn-accent">Reply</button>
            </div>


            <div class="question flex-col">
                <h3>Question Title</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nobis optio necessitatibus voluptatem ullam ut tempore sunt architecto? Voluptate cum assumenda, est omnis a animi doloremque ratione iusto laborum rerum. Sed.</p>
                <div class="date-time flex-row text-grey" style="font-size: 12px; gap: 10px;">
                    <p>2024-01-01</p>
                    <p> at 12:00:00</p>
                </div>
                <textarea placeholder="send a reply"></textarea>
                <button class="btn btn-accent">Reply</button>
            </div>


            <div class="question flex-col">
                <h3>Question Title</h3>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nobis optio necessitatibus voluptatem ullam ut tempore sunt architecto? Voluptate cum assumenda, est omnis a animi doloremque ratione iusto laborum rerum. Sed.</p>
                <div class="date-time flex-row text-grey" style="font-size: 12px; gap: 10px;">
                    <p>2024-01-01</p>
                    <p> at 12:00:00</p>
                </div>
                <textarea placeholder="send a reply"></textarea>
                <button class="btn btn-accent">Reply</button>
            </div>
        </div>

        
    </div>

</div>




<?php require APPROOT . '/views/inc/footer.php'; ?>