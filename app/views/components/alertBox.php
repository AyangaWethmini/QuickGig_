<link rel="stylesheet" href="<?=ROOT?>/assets/css/components/alerts.css">

<div id="alert-container" class="alert-container"></div>

<script>
    function showAlert(message, type = 'error', duration = 5000) {
        if (type === 'js') {
            alert(message);
            return;
        }

        const alertContainer = document.getElementById('alert-container');

        const alertBox = document.createElement('div');
        alertBox.classList.add('alert-box', `alert-${type}`);

        const messageSpan = document.createElement('span');
        messageSpan.textContent = message;

        const closeButton = document.createElement('button');
        closeButton.innerHTML = '&times;';
        closeButton.classList.add('alert-close');
        closeButton.onclick = () => alertBox.remove();

        alertBox.appendChild(messageSpan);
        alertBox.appendChild(closeButton);
        alertContainer.appendChild(alertBox);

        if (duration > 0) {
            setTimeout(() => {
                alertBox.remove();
            }, duration);
        }
    }

    function hideAllAlerts() {
        const container = document.getElementById('alert-container');
        container.innerHTML = '';
    }
</script>
