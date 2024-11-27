document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector(".complain-form");
    const complainInfo = document.getElementById("complainInfo");
    const errorMessage = document.createElement("div");
    errorMessage.style.color = "red";
    errorMessage.style.marginTop = "5px";
    errorMessage.style.display = "none";
    complainInfo.parentNode.appendChild(errorMessage);

    form.addEventListener("submit", (e) => {
        const complaintText = complainInfo.value.trim();
        if (complaintText.length === 0) {
            e.preventDefault();
            errorMessage.textContent = "Complaint cannot be empty or contain only spaces.";
            errorMessage.style.display = "block";
        } else {
            errorMessage.style.display = "none";
        }
    });
});
