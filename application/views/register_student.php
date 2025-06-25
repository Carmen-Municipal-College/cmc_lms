<!DOCTYPE html>
<html>

<head>
    <title>Register Student</title>
</head>

<body>
    <h2>Register Student</h2>
    <?php if ($this->session->flashdata('error')): ?>
        <p style="color:red;"><?php echo $this->session->flashdata('error'); ?></p>
    <?php endif; ?>
    <form method="post" action="<?php echo site_url('register_student'); ?>">
        <label>Lastname:</label>
        <input type="text" name="lastname" required><br>
        <label>Firstname:</label>
        <input type="text" name="firstname" required><br>
        <label>Middlename:</label>
        <input type="text" name="middlename" required><br>
        <button type="submit">Register</button>
    </form>
</body>

</html>