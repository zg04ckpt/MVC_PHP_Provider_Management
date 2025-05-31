<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống QLNCC</title>
    <link rel="stylesheet" href="/public/css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="/public/js/main.js"></script>
</head>
<body>
    <?php require_once 'client_header.php' ?>
    <?= $content ?>

    <!-- Foooter -->
    <?php include_once 'footer.php' ?>

    <?php include_once '../partial/toast.php' ?>

    <!-- Bubble -->
    <span class="position-fixed end-0 bottom-0 text-center align-content-center rounded-pill bg-color-2 m-4 shadow-lg" 
        style="height: 50px; width: 50px;" title="Cuộn về đầu trang" onclick="scrollToBegin()">
        <i class="fas fa-chevron-up fs-4 text-white"></i>
    </span>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js" integrity="sha512-b+nQTCdtTBIRIbraqNEwsjB6UvL3UEMkXnhzd8awtCYh0Kcsjl9uEgwVFVbhoj3uu1DO1ZMacNvLoyJJiNfcvg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(() => {
            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);
            const mess = params.get('message');
            const messType = params.get('message_type');
            if (mess) {
                showToast(mess, messType ?? 'success');
            }
        })
    </script>
</body>
</html>