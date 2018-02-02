<?php

header('Content-Type: text/html; charset=utf-8');

require_once(__DIR__ . '/api/Util.php');

session_start();


$langs = ['ru' => ['Русский', 'ru_RU', 'RUSSIAN'], 'kz' => ['Қазақша', 'kk_KZ', 'KAZAKH']/*, 'en' => ['English', 'en_US']*/];


$lang = (isset($_GET['lang']) && array_key_exists($_GET['lang'], $langs)) ? $_GET['lang'] : 'ru';
$apiLang = $lang == 'kz' ? 'kk' : $lang;

$_SESSION['apiLang'] = $apiLang;

putenv("LC_ALL=".$langs[$lang][1]);
setlocale(LC_ALL, $langs[$lang][1]);

bindtextdomain("$lang", "./i18n");
textdomain("$lang");
bind_textdomain_codeset($lang, 'utf-8');



$_SESSION['initMain'] = 1;

$timestamp = time();

$tsstring = gmdate('D, d M Y H:i:s ', $timestamp) . 'GMT';
$etag = $lang . $timestamp;

$if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false;
$if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? $_SERVER['HTTP_IF_NONE_MATCH'] : false;
if ((($if_none_match && $if_none_match == $etag) || (!$if_none_match)) &&
    ($if_modified_since && $if_modified_since == $tsstring)) {

    header('HTTP/1.1 304 Not Modified');
    exit();
} else {
    header("Last-Modified: $tsstring");
    header("ETag: \"{$etag}\"");
}

?>
<!DOCTYPE html>
<html lang="ru">
    <head>
	<?php include './__GTM-head.php'; ?>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <meta name="description" content="" />
        <meta name="keywords" content="" />
        <link rel="icon" type="image/png" href="/favicon.png" />
        <link rel="apple-touch-icon" href="/apple-touch-favicon.png" />

        <title><?= _("Обязательная страховка автомобиля (ОГПО) с бесплатной доставкой — страховая компания \"Евразия\"") ?></title>

        <!-- Bootstrap core CSS -->
        <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="/css/styles.css?<?= filemtime(__DIR__ .'/css/styles.css') ?>" rel="stylesheet"/>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <script src='https://www.google.com/recaptcha/api.js'></script>

        <?php include './__GA.php'; ?>
        <?php include './__YM.php'; ?>
    </head>

    <body>
	<?php include './__GTM-body.php'; ?>
        <header>
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <span class="navbar-brand"><img src="/i/logo-<?= $lang ?>.svg" alt="Евразия" class="navbar-brand__logo" /></span>

<!--                        <div class="dropdown langs">
                            <button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <?= $langs[$lang][0] ?>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <?php foreach($langs as $key => $l): ?>
                                <?php if($key != $lang): ?>
                                <li><a href="/<?= $key != 'ru' ? $key : '' ?>"><?= $l[0] ?></a></li>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>-->
                    </div>
                    <div id="navbar" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li><span><a href="tel:88000800099" class="header-tel">8 800 080-00-99</a> <br class="visible-sm-inline"/><?= _("или") ?> <a href="tel:5678" class="header-tel">5678</a><br/><small><?= _("звонок бесплатный") ?></small></span></li>
                            <li><a href="#info" data-toggle="modal" data-target="#delivery"><?= _("Доставка и оплата") ?></a></li>
                            <li><a href="/contacts.php<?= $lang != 'ru' ? Util::passParameters($lang) : Util::passParameters() ?>"><?= _("Адреса и телефоны") ?></a></li>
                            <li class="lang-li first-lang-li"><?php if($lang == 'ru'): ?><span class="current-lang">RU</span><?php else: ?><a href="/<?= Util::passParameters() ?>">RU</a><?php endif; ?></li>
                            <li class="lang-li"><?php if($lang == 'kz'): ?><span class="current-lang">KZ</span><?php else: ?><a href="/kz<?= Util::passParameters() ?>">KZ</a><?php endif; ?></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </nav>

            <div class="container">
                <!--
                <span class="ogpo-vts"><?= _("ОГПО ВТС") ?></span> <a href="/order/casco/index.html" class="avto-kasko">Авто Каско</a>
                -->
                <h1><?= _("Обязательная автостраховка с&nbsp;бесплатной доставкой") ?></h1>

                <div class="row pluses">
                    <div class="col-sm-4"><img src="/i/check.svg" alt="✓" /> <?= _("Быстрое оформление полиса") ?></div>
                    <div class="col-sm-4"><img src="/i/check.svg" alt="✓" /> <?= _("Минимальная цена + скидка") ?></div>
                    <div class="col-sm-4"><img src="/i/check.svg" alt="✓" /> <?= _("Работаем c 1995 года") ?></div>
                </div>
            </div>
        </header>

        <div class="container">

            <div class="row">
                <div class="col-sm-8">
                    <?php require('./__form.php') ?>
                </div>
                <div class="col-sm-4 hidden-xs">
                    <div class="rating">
                        <img src="/i/rating.png" alt="" />
                        <?= _("У нас наивысший рейтинг среди частных финансовых компаний Казахстана: BB+/kzAA- (S&P, 2017).") ?>
                    </div>
                </div>
            </div>

            <div class="row about-company">
                <div class="col-sm-8 about-company__text">
                    <h2><?= _("О страховой компании «Евразия»") ?></h2>

                    <p><?= _("«Евразия» основана в 1995 году, и работает в 75 странах мира.") ?></p>

                    <p><?= _("Мы предлагаем все виды страхования для компаний и частных лиц.") ?></p>

                    <div class="about-company__payments visible-xs">
                        <h2><?= _("10 000 тенге  в&nbsp;минуту") ?></h2>
                        <?= _("или 5,9 млн. тенге в день выплачивает «Евразия» своим клиентам") ?>
                    </div>

                    <p><?= _("Компании страхуют у нас сотрудников, транспорт, имущество и гражданско-правовую ответственность. Частные лица — автомобили (КАСКО и ОГПО ВТС), имущество и здоровье при выезде за рубеж.") ?></p>

                    <p><?= _("Офисы компании работают в Алматы, Астане, Караганде и других крупных городах Казахстана.") ?></p>

                    <p><?= _("В октябре 2017 года Standard & Poor’s присвоил «Евразии» наивысший среди частных финансовых компаний Казахстана рейтинг «ВВ+/kzAA-» (прогноз позитивный).") ?></p>

                    <p><a href="http://theeurasia.kz" target="_blank">theeurasia.kz</a></p>

                    <p class="about-company__links"><a href="#main-form" class="btn btn-blue"><?= _("Узнать стоимость страховки") ?></a> <span class="ili"><?= _("или") ?></span> <a href="" data-toggle="modal" data-target="#callback"><?= _("заказать звонок") ?></a></p>
                </div>
                <div class="col-sm-4 about-company__right-col hidden-xs">
                    <h2><?= _("10 000 тенге  в&nbsp;минуту") ?></h2>
                    <?= _("или 5,9 млн. тенге в день выплачивает «Евразия» своим клиентам") ?>
                </div>
            </div>

        </div><!-- /.container -->

        <footer>
            <div class="container footer">
                <div class="row">
                    <div class="col-sm-4 col-xs-12 footer__copyright">
                        <?= _("© АО «Страховая компания «Евразия»") ?>
                    </div>
                    <div class="col-sm-3 col-xs-12 footer__box">
                        <a href="https://box.eurasia36.kz"><?= _("Отправить нам документы") ?></a>
                        <?php
                        /**
                        <br/>
                        <a href="https://creditpolis.theeurasia.kz/"><?= _("Страховка в рассрочку") ?></a>
                         */
                        ?>
                    </div>
                    <div class="col-sm-5 col-xs-12">
                        <div class="footer__grafica <?= $lang ?>-footer__grafica">
                            <a href="http://grafica.kz">
                                <img src="/i/grafica.svg" alt="Grafica" />
                                <?= _("Сайт сделан<br/>в&nbsp;<span>студии&nbsp;«Графика»") ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>


        <!-- Доставка и оплата -->
        <div class="modal fade modal-transparent" id="delivery" tabindex="-1" role="dialog" aria-labelledby="delivery">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&nbsp;</button>
                        <h4 class="modal-title" id="myModalLabel"><?= _("Доставка и оплата") ?></h4>
                    </div>
                    <div class="modal-body">
                        <p class="delivery-time"><?= _("Доставляем полисы только по г. Алматы<br/>с 9:00 до 19:00 в будние дни.") ?></p>

                        <p><?= _("Самовывоз возможен в Алматы, Астане, Караганде, Усть-Каменогорске, Костанае, Актау, Павлодаре, Атырау и Актобе.") ?></p>

                        <p><?= _("Принимаем заказы круглосуточно, без выходных и праздничных дней.") ?></p>

                        <p class="delivery-time"><?= _("Оплата наличными курьеру при получении.") ?></p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Заказ звонка -->
        <div class="modal fade modal-transparent" id="callback" tabindex="-1" role="dialog" aria-labelledby="delivery">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&nbsp;</button>
                        <h4 class="modal-title" id="myModalLabel"><?= _("Заказ звонка") ?></h4>
                    </div>
                    <div class="modal-body">

                        <form method="post" action="callback.php" id="callback-form">
                            <?php if(isset($_GET['utm_source']) && trim($_GET['utm_source']) != ''): ?>
                            <input type="hidden" name="utm[source]" value="<?= isset($_GET['utm_source']) ? urldecode($_GET['utm_source']) : '' ?>" />
                            <input type="hidden" name="utm[medium]" value="<?= isset($_GET['utm_medium']) ? urldecode($_GET['utm_medium']) : '' ?>" />
                            <input type="hidden" name="utm[campaign]" value="<?= isset($_GET['utm_campaign']) ? urldecode($_GET['utm_campaign']) : '' ?>" />
                            <input type="hidden" name="utm[content]" value="<?= isset($_GET['utm_content']) ? urldecode($_GET['utm_content']) : '' ?>" />
                            <input type="hidden" name="utm[term]" value="<?= isset($_GET['utm_term']) ? urldecode($_GET['utm_term']) : '' ?>" />
                            <?php elseif(isset($_GET['gclid'])) : ?>
                            <input type="hidden" name="utm[source]" value="google" />
                            <input type="hidden" name="utm[medium]" value="cpc" />
                            <input type="hidden" name="utm[campaign]" value="undefined" />
                            <input type="hidden" name="utm[content]" value="gclid-<?= isset($_GET['gclid']) ? urldecode($_GET['gclid']) : '' ?>" />
                            <?php elseif(isset($_GET['yclid'])) : ?>
                            <input type="hidden" name="utm[source]" value="yandex" />
                            <input type="hidden" name="utm[medium]" value="cpc" />
                            <input type="hidden" name="utm[campaign]" value="undefined" />
                            <input type="hidden" name="utm[content]" value="yclid-<?= isset($_GET['yclid']) ? urldecode($_GET['yclid']) : '' ?>" />
                            <?php endif; ?>
                            <input type="hidden" name="requester[language]" value="<?= $langs[$lang][2] ?>" />
                            <input type="hidden" name="requester[name]" value="Не указано" />
                            <input type="tel" name="requester[phone]" class="form-control" placeholder="Телефон" />
                            <button type="submit" class="btn btn-blue goal-callback-request <?= $lang ?>-btn"><?= _("Заказать") ?></button>
                            <div class="help-block" style="display: none"><span class="text-danger"></span></div>
                        </form>

                        <p><?= _("Перезвоним в течение 10 минут.") ?><br/><?= _("Спросите менеджера о действующих скидках.") ?></p>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="/bootstrap/js/bootstrap.min.js"></script>
        <script src="/js/jquery.maskedinput.min.js"></script>
        <script>
            <?php require('./__form.js.php') ?>
        </script>

        <?php include './__jivosite.php'; ?>

    </body>
</html>
