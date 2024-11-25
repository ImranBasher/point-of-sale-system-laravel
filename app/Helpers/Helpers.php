<?php
use App\Utils\AppStatic;

    if(!function_exists("userId")){
        function userId(){
            return auth()->id();
        }
    }

    if(!function_exists("user")){
        function user(){
            return auth()->user();
        }
    }

    if(!function_exists('appStatic')){
        function appStatic(){
            return new AppStatic();
        }
    }

    if(!function_exists("isAdmin")){
        function isAdmin(){
            $user  = user();
            return $user->role == appStatic()::USER_TYPE_ADMIN;
        }
    }

    if(!function_exists("isUser")){
        function isUser(){
            $user  = user();
            return $user->role == appStatic()::USER_TYPE_USER;
        }
    }

    if(!function_exists("show_Error_In_An_Array")){
        function showErrorInAnArray($exception){
            return [
                $exception->getMessage(),
                $exception->getFile(),
                $exception->getLine(),
                $exception->getTraceAsString()
            ];
        }
    }

    if(!function_exists("dump_And_Die")){
        function dumpAndDie($exception){
            dd(showErrorInAnArray($exception));
        }
    }

    if(!function_exists("showError")){
        function showError($name){
            return view('common.validation-error')->with(["name"=>$name])->render();

        }
    }

    if(!function_exists("showError1")){
        function showError1($name){
            return view('common.validation-error')->with(["name"=>$name])->render();
        }
    }


