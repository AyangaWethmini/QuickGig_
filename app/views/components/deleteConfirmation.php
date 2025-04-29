<style>
    .confirmation-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        padding-top: 60px;
        display: none;
        justify-content: center;
        align-items: center;
    }

    .confirmation-modal-content {
        background-color: #ffffff;
        padding: 40px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        width: 400px;
        height: 200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .confirmation-modal-btn {
        border: none;
        padding: 15px 30px;
        margin: 10px;
        cursor: pointer;
        border-radius: 5px;
        font-size: 16px;
    }

    .confirmation-modal-btn-confirm {
        background-color: #c11b1b;
        color: white;
    }

    .confirmation-modal-btn-cancel {
        background-color: #4640DE;
        color: white;
    }

    .confirmation-modal-btn-confirm:hover {
        background-color: #a00f0f;
    }

    .confirmation-modal-btn-cancel:hover {
        background-color: #3430bd;
    }
</style>

<div id="confirmation-modal" class="confirmation-modal">
    <div class="confirmation-modal-content">
        <p id="confirmation-message"></p>
        <div>
            <button id="confirmation-confirm" class="confirmation-modal-btn confirmation-modal-btn-confirm">Confirm</button>
            <button id="confirmation-cancel" class="confirmation-modal-btn confirmation-modal-btn-cancel">Cancel</button>
        </div>
    </div>
</div>

<form id="confirmation-form" method="POST" style="display: none;"></form>

<script>
    
    let currentConfirmCallback = null;

    function showConfirmation(message, confirmCallback, cancelCallback = null) {
        const modal = document.getElementById('confirmation-modal');
        const messageElement = document.getElementById('confirmation-message');

        messageElement.textContent = message;

     
        currentConfirmCallback = confirmCallback;

       
        modal.style.display = 'flex';

     
        document.getElementById('confirmation-confirm').onclick = function() {
            modal.style.display = 'none';
            if (currentConfirmCallback) {
                currentConfirmCallback();
            }
        };

        document.getElementById('confirmation-cancel').onclick = function() {
            modal.style.display = 'none';
            if (cancelCallback) {
                cancelCallback();
            }
        };
    }

    function submitForm(action, method = 'POST', data = {}) {
        const form = document.getElementById('confirmation-form');
        form.action = action;
        form.method = method;

      
        while (form.firstChild) {
            form.removeChild(form.firstChild);
        }

      
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
        if (csrfToken) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
        }

        for (const [key, value] of Object.entries(data)) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            form.appendChild(input);
        }

        form.submit();
    }
</script>