const form = document.getElementById("create-ad");
const updateForm = document.getElementById("update-ad");

function showUpdateForm(ad) {
    updateForm.classList.remove("hidden");
    updateForm.classList.add("show");
}

// Ensure this function is defined before it's called
function showForm() {
    if (form.classList.contains("hidden")) {
        form.classList.remove("hidden");
        setTimeout(() => {
            form.classList.add("show");
        }, 50);
    }
}

function hideForm(formId) {
    const selectedForm = document.getElementById(formId);
    selectedForm.classList.remove("show");
    setTimeout(() => {
        selectedForm.classList.add("hidden");
    }, 500);
}



function deleteAd(adId) {
    if (confirm('Are you sure you want to delete this advertisement?')) {
        // Using POST instead of DELETE
        fetch(`<?= ROOT ?>/manager/deleteAdvertisement/${adId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => {
                if (response.ok) {
                    alert('Advertisement deleted successfully');
                    window.location.reload();
                } else {
                    alert('Failed to delete advertisement');
                }
            })
    }
}