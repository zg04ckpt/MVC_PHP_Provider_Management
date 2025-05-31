<!-- Notify -->
<style>
    .toast.info {
        background-color: #e7f1ff;
        color:rgb(31, 159, 199);
    }
    .toast.error {
        background-color: #fee2e2;
        color: #b91c1c;
    }
    .toast.success {
        background-color: #e6f4ea;
        color:rgb(33, 184, 73);
    }
    @keyframes slideInFromRight {
        from {
            transform: translateX(90%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    .toast.show {
        animation: slideInFromRight 0.2s linear; 
    }
    .toast.hide {
        display: none; 
    }
</style>
<div id="mess" class="toast <?= !empty($message)? 'show':'hide' ?> align-items-center top-0 position-fixed end-0 m-3 shadow-sm" role="alert" style="z-index: 1000;">
    <div class="d-flex">
        <div class="toast-body">
            <?= htmlspecialchars($message) ?>
        </div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
</div>

