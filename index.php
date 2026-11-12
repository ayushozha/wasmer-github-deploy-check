<?php
require __DIR__ . '/vendor/autoload.php';
use Carbon\Carbon;
echo "<h1>03 PHP + Composer works</h1><p>" . Carbon::now()->toDayDateTimeString() . "</p>";
