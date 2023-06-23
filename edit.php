<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
            integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
            crossorigin="anonymous"></script>
    <title>Редактирование</title>
</head>
<body>
<div class="col-md-12 text-center">
    <h1>Редактировать</h1>
</div>
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            <div class="row">
                <?php
                include 'database.php';

                $id = $_GET['id'];

                $db = new Database();
                $row = $db->select("messages",
                    [
                        "select" => "*",
                        "where" => [
                            'id' => $id
                        ],
                        'return_type' => 'single'
                    ]);
                ?>
                <div class="col-md-12" id="hide">
                    <form class="row form" action="update.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <?php include 'form.php'; ?>
                        <div class="col-12 form-group">
                            <input type="submit" class="btn btn-dark" name="submit" value="Обновить">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>