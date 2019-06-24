<?php

Route::middleware('api')->get('api/falcon', function () {
    return "Hello Falcon";
});
