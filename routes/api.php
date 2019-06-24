<?php

Route::middleware('auth:api')->get('falcon', function () {
    return "Hello Falcon";
});
