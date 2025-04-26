<?php require APPROOT . '/views/inc/header.php'; ?>

<link rel="stylesheet" href="<?php echo ROOT; ?>/assets/css/home/signup.css">

<div class="signin-signup flex-row">

    <div class="carousel">
        <div class="slides">
            <div class="slide active" style="background-image: url('<?= ROOT ?>/assets/images/logincarousel1.jpg');">
                <div class="overlay">
                    <h2>Welcome Aboard!</h2>
                    <p>Start your journey with us and explore job opportunities that fit your schedule.</p>
                </div>
            </div>
            <div class="slide" style="background-image: url('<?= ROOT ?>/assets/images/logincarousel2.jpg');">
                <div class="overlay">
                    <h2>Flexible Opportunities</h2>
                    <p>Get access to a wide range of jobs with flexible hours. Work when and where you want!</p>
                </div>
            </div>
            <div class="slide" style="background-image: url('<?= ROOT ?>/assets/images/logincarousel3.jpg');">
                <div class="overlay">
                    <h2>Build Your Future</h2>
                    <p>Join a platform that helps you gain valuable experience while studying. Secure your future today!</p>
                </div>
            </div>
        </div>
        <div class="dots">
            <span class="dot active"></span>
            <span class="dot"></span>
            <span class="dot"></span>
        </div>
    </div>

    <div class="form-section">

        <div class="signup-form-wrapper">
            <!-- Display errors -->
            <?php if (isset($_SESSION['signup_errors']) && !empty($_SESSION['signup_errors'])): ?>
                <div class="error-messages">
                    <?php foreach ($_SESSION['signup_errors'] as $error): ?>
                        <p class="error"><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
                <?php unset($_SESSION['signup_errors']); ?>
            <?php endif; ?>

            <form action="<?php echo ROOT; ?>/signup/registerMore" method="POST" class="signup-form">
                <input type="hidden" name="accountID" value="<?php echo $_SESSION['accountID']; ?>">
                <div class="form-field flex-col" style="">
                    <label for="userType" class="lbl">User Role:</label>
                    <select name="userType" id="userType" placeholder="User Type" class="userType">

                        <option value="individual" selected>Individual</option>
                        <option value="organization">Organization</option>
                    </select>
                </div>
                <div id="individualFields">
                    <div class="form-field flex-col">
                        <label for="fname" class="lbl">First Name:</label>
                        <input type="text" name="fname" id="fname" placeholder="John">
                    </div>
                    <div class="form-field flex-col">
                        <label for="lname" class="lbl">Last Name:</label>
                        <input type="text" name="lname" id="lname" placeholder="Doe">
                    </div>
                    <div class="form-field flex-col">
                        <label for="nic" class="lbl">NIC:</label>
                        <input type="text" name="nic" id="nic" placeholder="2001*********">
                    </div>
                    <div class="form-field flex-col">
                        <label for="gender" class="lbl">Gender:</label>
                        <select name="gender" placeholder="Gender" class="userType">
                            <option value="Male" selected>Male</option>
                            <option value="Female">Female</option>

                        </select>
                    </div>

                    <div class="form-field flex-col">
                        <label for="Phone" class="lbl">Contact Number:</label>
                        <div class="phone-container">
                            <select name="countryCode" id="countryCode" class="country-code">
                            </select>
                            <input type="text" name="Phone" id="Phone" placeholder="7700000000">
                        </div>
                    </div>

                </div>

                <div id="organizationFields" style="display: none;">
                    <div class="form-field flex-col">
                        <label for="orgName" class="lbl">Organization Name:</label>
                        <input type="text" name="orgName" id="orgName">
                    </div>
                    <div class="form-field flex-col">
                        <label for="brn" class="lbl">Business Registration Number:</label>
                        <input type="text" name="brn" id="brn">
                    </div>
                    <div class="form-field flex-col">
                        <label for="Phone" class="lbl">Contact Number:</label>
                        <div class="phone-container">
                            <select name="countryCode" id="countryCode" class="country-code">
                            </select>
                            <input type="text" name="Phone" id="Phone" placeholder="7700000000">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-accent signup-btn">Finish</button>
            </form>
        </div>
    </div>




    <?php require APPROOT . '/views/inc/footer.php'; ?>


    <script>
        const userType = document.getElementById('userType');
        const individualFields = document.getElementById('individualFields');
        const organizationFields = document.getElementById('organizationFields');

        // Function to handle field display
        function handleFieldDisplay() {
            if (userType.value === 'individual') {
                individualFields.style.display = 'block';
                organizationFields.style.display = 'none';
            } else if (userType.value === 'organization') {
                organizationFields.style.display = 'block';
                individualFields.style.display = 'none';
            }
        }

        // Event listener for dropdown change
        userType.addEventListener('change', handleFieldDisplay);

        // Initialize the form on page load with "Individual" fields
        document.addEventListener('DOMContentLoaded', handleFieldDisplay);
    </script>
    <script>
        fetch('https://restcountries.com/v3.1/all')
            .then(response => response.json())
            .then(data => {

                const countryCodeSelect = document.getElementById('countryCode');

                // Check if there's data
                if (!data || data.length === 0) {
                    console.error('No data fetched from API');
                    return;
                }

                // Sort countries by name (alphabetically)
                data.sort((a, b) => {
                    const nameA = a.name.common.toUpperCase(); // Make the comparison case-insensitive
                    const nameB = b.name.common.toUpperCase(); // Make the comparison case-insensitive
                    if (nameA < nameB) return -1;
                    if (nameA > nameB) return 1;
                    return 0;
                });

                // Loop through the sorted country data and populate the dropdown with country codes
                data.forEach(country => {
                    const countryName = country.name.common; // Get the country name
                    let countryCode = '';

                    // Check if the country has a valid 'idd' field and 'suffixes' array
                    if (country.idd && Array.isArray(country.idd.suffixes) && country.idd.suffixes.length > 0) {
                        countryCode = country.idd.root + country.idd.suffixes[0]; // Get the full country code
                    }

                    // If country code exists, create an option element
                    if (countryCode) {
                        const option = document.createElement('option');
                        option.value = countryCode; // Set the country code (without the + sign)
                        option.textContent = `${countryCode} (${countryName})`; // Show the country code and name
                        countryCodeSelect.appendChild(option);
                    }
                });

                // Log the updated dropdown options
            })
            .catch(error => {
                console.error('Error fetching country data:', error);
            });
    </script>