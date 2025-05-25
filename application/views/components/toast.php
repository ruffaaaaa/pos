<?php if ($this->session->flashdata('success')) : ?>
    <div id="toast-success" class="toast toast-success">
        <?= $this->session->flashdata('success'); ?>
    </div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')) : ?>
    <div id="toast-error" class="toast toast-error">
        <?= $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

<style>
    .toast {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 20px 30px;
        color: #fff;
        border-radius: 6px;
        font-family: Arial, sans-serif;
        font-size: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        opacity: 0;
        transform: translateX(100%);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }

    .toast-success {
        background-color: #28a745;
    }

    .toast-error {
        background-color: #dc3545;
    }

    .toast.show {
        opacity: 1;
        transform: translateX(0);
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const successToast = document.getElementById("toast-success");
        const errorToast = document.getElementById("toast-error");

        // Function to show toast
        const showToast = (toast) => {
            if (toast) {
                toast.classList.add("show");
                setTimeout(() => {
                    toast.classList.remove("show");
                    setTimeout(() => {
                        toast.remove();
                    }, 300); // Smooth fade out
                }, 3000); // Toast display time
            }
        };

        // Show the toasts
        showToast(successToast);
        showToast(errorToast);
    });
</script>
