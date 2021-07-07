<?php

namespace cookieHandler;

session_name('session_id');
session_set_cookie_params(60 * 200);
session_start();
error_reporting(E_ALL);

ini_set('display_errors', '1');

/**
 * функция записывает результат попытки авторизации в сессии, пароль, роль юзера
 * @param массив с данными пользователя
 */
function setSession($data)
{
    if (isset($data['password'])) {
        $_SESSION['password'] = $data['password'];
    } 
    if (isset($data['id'])) {
        $_SESSION['users_id'] = $data['id'];
    } 
    if (isset($data['roles_id'])) {
        $_SESSION['roles_id'] = $data['roles_id'];
    }   
}

/**
 * функция очищает сессию
 */
function deleteSession()
{
    session_unset();
}

/**
 * функция устанавливает и продлевает куки логина и имени
 * @param массив с данными пользователя
 */
function createCookie($data)
{
    if (isset($data['login'])) {
        setcookie('login', $data['login'], time() + 60 * 60 * 24 * 31, "/");
    }
    if (isset($data['name'])) {
        setcookie('name', $data['name'], time() + 60 * 60 * 24 * 31, "/");
    }   
}
/**
 * функция устанавливает и продлевает куки изменений
 * @param строка с названием ид изменяемого элемента
 */
function createCookieAddChange($str)
{
    if (isset($str)) {
        setcookie('add/change', $str, time() + 60 * 60 * 24 * 31, "/");
    }
}

/**
 * функция удаляет куки изменений
 */
function delCookieAddChange()
{
    if (isset($_COOKIE['add/change'])) {
        unset($_COOKIE['add/change']);  
        setcookie('add/change', '', time() - 1, "/");
    }
}

/**
 * функция удаляет куки логина и имени
 */
function delCookie()
{
    if (isset($_COOKIE['login'])) {
        unset($_COOKIE['login']);  
        setcookie('login', '', time() - 1, '/');
    }
    if (isset($_COOKIE['name'])) {
    unset($_COOKIE['name']);  
    setcookie('name', '', time() - 1, '/');
    }
}
