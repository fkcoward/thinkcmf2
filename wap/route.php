<?php
use think\Route;

//Route::rule('/','index/Index/index');
Route::rule('web/:controller/:index','web/:controller/:index');
Route::rule('notify/:controller/:index','notify/:controller/:index');
Route::rule('/:myparam','index/Index/index');
