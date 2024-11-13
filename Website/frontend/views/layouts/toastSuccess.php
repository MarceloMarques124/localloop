<div class="wrapper">
    <div id="toast">
        <div class="container-1">
            <i class="fas fa-check-square"></i>
        </div>
        <div class="container-2">
            <p>Success</p>
            <p id="toastMessage"></p>
        </div>
        <!-- <button id="close" onclick="closeToast()">
            &times;
        </button> -->
        <button type="button" class="btn-close" id="close" onclick="closeToast()" aria-label="Close"></button>

    </div>
</div>

<!-- JavaScript para exibir a Toast -->
<script>
    let x;
    let toast = document.getElementById("toast");

    function showToast() {
        clearTimeout(x);
        toast.style.transform = "translateX(0)";
        x = setTimeout(() => {
            toast.style.transform = "translateX(400px)"
        }, 4000);
    }

    function closeToast() {
        toast.style.transform = "translateX(400px)";
    }
</script>