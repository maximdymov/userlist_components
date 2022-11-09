<?php use Tamtamchik\SimpleFlash\Flash;

$this->layout('template', ['title' => 'Создание пользователя']) ?>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-primary-gradient">
    <a class="navbar-brand d-flex align-items-center fw-500" href="users"><img alt="logo"
                                                                               class="d-inline-block align-top mr-2"
                                                                               src="/img/logo.png"> Учебный
        проект</a>
    <button aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"
            data-target="#navbarColor02" data-toggle="collapse" type="button"><span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/">Главная <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="auth">Войти</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout">Выйти</a>
            </li>
        </ul>
    </div>
</nav>
<main id="js-page-content" role="main" class="page-content mt-3">
    <div class="subheader">
        <h1 class="subheader-title">
            <i class='subheader-icon fal fa-plus-circle'></i> Добавить пользователя
        </h1>

    </div>
    <?= Flash::display() ?>
    <form action="create_user" method="post">
        <div class="row">
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Общая информация</h2>
                        </div>
                        <div class="panel-content">
                            <!-- username -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Имя</label>
                                <input type="text" id="simpleinput" class="form-control" name="name">
                            </div>

                            <!-- tel -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Номер телефона</label>
                                <input type="text" id="simpleinput" class="form-control" name="phone">
                            </div>

                            <!-- address -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Адрес</label>
                                <input type="text" id="simpleinput" class="form-control" name="address">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-6">
                <div id="panel-1" class="panel">
                    <div class="panel-container">
                        <div class="panel-hdr">
                            <h2>Безопасность и Медиа</h2>
                        </div>
                        <div class="panel-content">
                            <!-- email -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Email</label>
                                <input type="text" id="simpleinput" class="form-control" name="email">
                            </div>

                            <!-- password -->
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">Пароль</label>
                                <input type="password" id="simpleinput" class="form-control" name="password">
                            </div>


                            <!-- status -->
                            <div class="form-group">
                                <label class="form-label" for="example-select">Выберите статус</label>
                                <select class="form-control" id="example-select" name="status">
                                    <option>Онлайн</option>
                                    <option>Отошел</option>
                                    <option>Не беспокоить</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="example-fileinput">Загрузить аватар</label>
                                <input type="file" id="example-fileinput" class="form-control-file" name="img">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-12 mt-3 d-flex flex-row-reverse">
                <button class="btn btn-success">Добавить</button>
            </div>

        </div>
    </form>
</main>

<script src="/js/vendors.bundle.js"></script>
<script src="/js/app.bundle.js"></script>
<script>

    $(document).ready(function () {


    });

</script>
</body>