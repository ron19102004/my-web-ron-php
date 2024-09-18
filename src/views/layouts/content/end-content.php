<?php if (isset($_METADATA["footer-path"]) && !empty($_METADATA["footer-path"])) {
    require Import::view_layout_path($_METADATA["footer-path"]);
} ?>
</body>
<script>
    AOS.init({
        duration: 1000,
        once: true
    })
</script>

</html>