<div class="col-md-6 col-sm-12 mb-3 form-group">
    <label for="name" class="form-label">Имя:</label>
    <input id="name" type="text" name="name" value="<?php if (isset($row)) {
        echo $row['username'];
    } ?>" class="form-control" / required>
</div>
<div class="col-md-6 col-sm-12 mb-3 form-group">
    <label for="email" class="form-label">Email:</label>
    <input id="email" type="email" name="email" value="<?php if (isset($row)) {
        echo $row['email'];
    } ?>" class="form-control" / required>
</div>
<div class="col-md-6 col-sm-12 mb-3 form-group">
    <label for="phone" class="form-label">Телефон:</label>
    <input id="phone" type="tel" name="phone" value="<?php if (isset($row)) {
        echo $row['phone'];
    } ?>" class="form-control" / required>
</div>
<div class="col-md-6 col-sm-12 mb-3 form-group">
    <label for="subject" class="form-label">Тема:</label>
    <input id="subject" type="text" name="subject" value="<?php if (isset($row)) {
        echo $row['subject'];
    } ?>" class="form-control" / required>
</div>
<div class="col-md-12 col-sm-12 mb-3 form-group">
    <label for="message" class="form-label">Сообщение:</label>
    <textarea id="message" class="form-control" name="message"><?php if (isset($row)) {
            echo $row['message'];
        } ?></textarea>
</div>
