<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['web'])->group(function () {
    Route::post('__blade-protect', function () {
        $data = explode(':', json_decode(request()->getContent()));

        $protected = \Jaybizzle\BladeProtect\Models\Protect::where(['name' => $data[0], 'identifier' => $data[1]])->where('updated_at', '>=', now()->subSeconds(20))->first();

        if (! $protected) {
            \Jaybizzle\BladeProtect\Models\Protect::create([
                'name' => $data[0],
                'user_id' => auth()->user()->getKey() ?? null,
                'identifier' => $data[1],
            ]);
        } elseif ($protected->user_id == auth()->user()->getKey()) {
            $protected->updated_at = now();
            $protected->save();
        }
    });
});