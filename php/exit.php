<?

include $_SERVER['DOCUMENT_ROOT'] . '/php/cookieHandler.php';

cookieHandler\delCookie();

if (isset($_SESSION)) {
    cookieHandler\deleteSession();
}



echo json_encode(true);