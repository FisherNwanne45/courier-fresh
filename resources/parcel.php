<?php
// This page's parcel list was a duplicate of the one already shown on the
// dashboard (index.php), maintained separately and missing the access
// control / CSRF protections applied there. Redirect instead of keeping two
// copies of the same table in sync.
header('Location: index.php');
exit();
