<?php

Route::group(['middleware' => ['auth:api']], function () {
    Route::resource('/teams', 'TeamController')->only(['store', 'show']);
    Route::resource('/teams/{team}/players', 'PlayerController')->only(['store', 'update']);
});
