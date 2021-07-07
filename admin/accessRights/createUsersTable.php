<?php
/**
 * функция  возвращает массив с товарами
 * @return массив с товарами либо пустой массив
 */
function createUsersArray ()
{
    include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
    $usersList = [];

    $line = "SELECT users.*, r.name AS role, roles_id  FROM users
    LEFT JOIN role_user AS ru ON ru.users_id=users.id
    LEFT JOIN roles AS r ON r.id=roles_id ORDER BY roles_id ASC, users.id ASC";
    
    $connect = connectSQL();
    
    if (mysqli_connect_errno()) {
        mysqli_close($connect);
        return $usersList;
    } else {
        $result = mysqli_query($connect, $line);
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($usersList, $row);
        }
        mysqli_close($connect);
        return $usersList;
    }
}
/**
 * функция  возвращает таблицу с товарами
 * @param массив с товарами
 */
function createUsersTable (array $array)
{
    if (empty($array)) {
        echo "<h3 class='red'>Возникла ошибка</h3>";
    } elseif (isset($_COOKIE['login']) && isset($_SESSION['roles_id']) && $_SESSION['roles_id'] == '1') {
        echo '
        <div class="page-products__header">
            <span class="page-products__header-field product-item__field__name">Имя</span>
            <span class="page-products__header-field product-item__field__id">ID</span>
            <span class="page-products__header-field">Фамилия</span>
            <span class="page-products__header-field">Отчество</span>
            <span class="page-products__header-field">Телефон</span>
            <span class="page-products__header-field product-item__field__login">Email</span>
            <span class="page-products__header-field">Право доступа</span>
        </div>
        <ul class="page-products__list" style="position:relative;"">';
        foreach($array as $key => $val) {
            echo         '
            <li class="product-item page-products__item " id="id_' . $val['id'] . '">    
                <b class="product-item__name product-item__field__name">' . $val['name'] . '</b>
                <span class="product-item__field product-item__field__id">' . $val['id'] . '</span>
                <span class="product-item__field">' . $val['surname'] . '</span>
                <span class="product-item__field">' . $val['patronymic'] . '</span>
                <span class="product-item__field">' . $val['phone'] . '</span>
                <span class="product-item__field product-item__field__login">' . $val['login'] . '</span>
                <span class="product-item__field" id="role_' . $val['id'] . '">' . $val['role'] . '</span>
                <select class="product-item__field custom-form__select order" style="width:200px" name="role_id" id="change_' . $val['id'] . '" onchange="change(' . $val['id'] . ')" hidden="">
                    <option hidden="">Права доступа</option>
                    <option value="1">Admin</option>
                    <option value="2">Operator</option>
                    <option value="3">Buyer</option>
                </select>
                <button style="outline:none; border: 0px;cursor:pointer;" id=change_role_' . $val['id'] .'" class="product-item__edit" aria-label="Редактировать" onclick="changeUserRole(' . $val['id']. ')"></button>
            </li>';
        }
        echo '</ul>';
    } else {
        echo "<h3 class='red'>Ошибка прав доступа</h3>
        <div><button class='page-delivery__button button' OnClick='history.back();'>Назад</и></div>
        ";
    }
}
