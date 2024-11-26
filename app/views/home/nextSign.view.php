<form action="<?php echo ROOT; ?>/signup/registerMore" method="POST">
    <input type="hidden" name="accountID" value="<?php echo $_SESSION['accountID']; ?>">

    <label for="userType">User Type:</label>
    <select name="userType" id="userType" required>
        <option value="individual">Individual</option>
        <option value="organization">Organization</option>
    </select>

    <div id="individualFields" style="display: none;">
        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" id="firstName">

        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" id="lastName">

        <label for="dob">Date of Birth:</label>
        <input type="date" name="dob" id="dob">

        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone">
    </div>

    <div id="organizationFields" style="display: none;">
        <label for="orgName">Organization Name:</label>
        <input type="text" name="orgName" id="orgName">

        <label for="contactPerson">Contact Person:</label>
        <input type="text" name="contactPerson" id="contactPerson">

        <label for="contactPhone">Contact Phone:</label>
        <input type="text" name="contactPhone" id="contactPhone">

        <label for="address">Address:</label>
        <input type="text" name="address" id="address">
    </div>

    <button type="submit">Submit</button>
</form>

<script>
    const userType = document.getElementById('userType');
    const individualFields = document.getElementById('individualFields');
    const organizationFields = document.getElementById('organizationFields');

    userType.addEventListener('change', () => {
        if (userType.value === 'individual') {
            individualFields.style.display = 'block';
            organizationFields.style.display = 'none';
        } else if (userType.value === 'organization') {
            organizationFields.style.display = 'block';
            individualFields.style.display = 'none';
        }
    });
</script>