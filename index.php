<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="author" content="Luzinama"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Test CRUD</title>
</head>
<body>
<div>
    <?php
    include 'database.php';
    $db = new Database();
    if ($db->isDbExists() === false) { ?>
        <div class="col-md-12 text-center">
            <h1>Создание базы данных</h1>
        </div>
        <section id="content" class="text-center">
            <p>База данных 'test_crud_app' не найдена. Создайте базу данных, наажав на кнопку ниже.</p>
            <a href="database_create.php" type="button" class="btn btn-primary btn-lg">Создать</a>
        </section>
    <?php } else {
        $result = $db->select("messages", ['select' => "*"]); ?>
        <div class="col-md-12 text-center">
            <h1>Сообщения</h1>
        </div>
        <section id="content">
            <div class="content-wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12" id="hide">
                            <form class="row form" action="insert.php" method="post">
                                <?php include 'form.php'; ?>
                                <div class="col-12 form-group">
                                    <input type="submit" class="btn btn-dark mb-5" name="submit" value="Добавить">
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12 p-0">
                            <table class="table table-dark">
                                <thead>
                                <tr>
                                    <th scope="col">Id</th>
                                    <th scope="col">Имя</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Телефон</th>
                                    <th scope="col">Тема</th>
                                    <th scope="col">Сообщение</th>
                                    <th scope="col">Создано</th>
                                    <th scope="col">Обновлено</th>
                                    <th scope="col" colspan="2">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (!empty($result)) {
                                    foreach ($result as $row) { ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['username']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['phone']; ?></td>
                                            <td><?php echo $row['subject']; ?></td>
                                            <td><?php echo $row['message']; ?></td>
                                            <td><?php echo $row['created']; ?></td>
                                            <td><?php echo $row['updated']; ?></td>
                                            <td>
                                                <a href="edit.php?id=<?php echo $row['id']; ?>" type="button"
                                                   class="btn btn-primary btn-sm">Редактировать</a>
                                            </td>
                                            <td>
                                                <a href="delete.php?id=<?php echo $row['id']; ?>" type="button"
                                                   class="btn btn-danger btn-sm">Удалить</a>
                                            </td>
                                        </tr>
                                    <?php }
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>
</div>
</body>
</html>