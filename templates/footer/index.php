<?php
    /**
     * @var array $menu
     */
    require_once $_SERVER['DOCUMENT_ROOT'] . '/templates/menu/createLi.php';
?>
<footer class="page-footer">
    <div class="container" style='padding-bottom:20px'>
        <a class="page-footer__logo" href="/"><img src="/img/logo--footer.svg" alt="Fashion"></a>
        <nav class="page-footer__menu">
            <?php createMenu($menu, 'footer'); ?>
        </nav>
    </div>
    <address class="page-footer__copyright">© Все права защищены</address>
</footer>
</body>
</html>
