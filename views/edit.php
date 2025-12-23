<h2>Edit User</h2>

<form action="update.php?id=<?= $user['id'] ?>" method="POST">
    Name: <input type="text" name="name" value="<?= $user['name'] ?>"><br><br>
    Email: <input type="text" name="email" value="<?= $user['email'] ?>"><br><br>
    <button type="submit">Update</button>
</form>
