<?php
session_destroy();
$_SESSION = array();

?>
<html>
    <body>
        <script language="javascript">
        window.parent.location.href="../index.htm";
        </script>
    </body>
</html>