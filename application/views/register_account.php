<!DOCTYPE html>
<html>

<head>
    <title>Register Account</title>
</head>

<body>
    <h2>Register Account</h2>
    <?php if ($this->session->flashdata('error')): ?>
        <p style="color:red;"><?php echo $this->session->flashdata('error'); ?></p>
    <?php endif; ?>
    <form method="post" action="<?= base_url('save_account_registration'); ?>">
        <input type="text" name="student_id" value="<?= $this->session->tmp_student_id ?>" required hidden><br>
        <label>Student NO:</label>
        <input type="text" name="student_no" value="<?= $this->session->tmp_student_no ?>" required><br>
        <label>Username:</label>
        <input type="text" name="username" value="<?= $this->session->tmp_student_no ?>" required><br>
        <label>Password:</label>
        <input type="password" name="password" value="<?= $this->session->tmp_student_no ?>" required><br>
        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" value="<?= $this->session->tmp_student_no ?>" required><br>
        <label>Class:</label>
        <select name="class_id" required>
            <option value="">Select Class</option>
            <?php foreach ($classes as $class): ?>
                <option value="<?php echo $class->id; ?>"><?php echo $class->class_name; ?></option>
            <?php endforeach; ?>
        </select><br>
        <button type="submit">Register</button>
    </form>
</body>

</html>