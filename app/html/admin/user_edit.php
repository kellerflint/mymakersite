<?php require_once '../../private/initialize.php';
require_permission(ADM);

$style = "/style/user_edit.css";

$id = 0;
$username = "";
$nickname = "";
$password = "";

if (request_is_post() && $_POST['add'] == "add") {
    $nickname = $_POST['nickname'];
    $id = add_user($nickname, $_SESSION['session_id']);
    $user = find_user_by_id($id);
    $nickname = $user["user_nickname"];
    $password = $user["user_password"];
    $username = $user["user_name"];
} else if (request_is_post() && isset($_POST["user_id"])) {
    $id = $_POST["user_id"];
    $user = find_user_by_id($id);
    $nickname = $user["user_nickname"];
    $password = $user["user_password"];
    $username = $user["user_name"];
} else if (request_is_post() && $_POST['apply'] == "apply") {
    update_user($_POST["id"], $_POST["name"], $_POST["nickname"], $_POST["password"]);
} else if (request_is_post() && $_POST["remove"] == "remove") {
    remove_user($_POST["id"]);
}

include_once '../../private/shared/default_header.php'; ?>


    <div class="container">
        <h2 id="add-user-h2">Add User</h2>
        <form action="user_edit.php" method="POST" id="add-user">
            <div class="form-group">
                <label for="nickname-add">Name</label>
                <input type="text" class="form-control" id="nickname-add" name="nickname" placeholder="First L">
            </div>
            <button type="submit" class="btn btn-primary" name="add" value="add">Add User</button>
        </form>

        <h2 id="edit-user-h2">Edit User</h2>
        <div>
            <div class="form-group">
                <form action="user_edit.php" method="POST" id="get-user">
                    <label for="user-select">Select User</label>
                    <select class="form-control" id="user-select" name="user_id">
                        <option value="0">select user</option>
                        <?php
                        $user_set = find_users_by_session($_SESSION["session_id"]);

                        while ($user = mysqli_fetch_assoc($user_set)) {
                            ?>
                            <option value="<?php echo $user['user_id']; ?>" <?php if ($user['user_id'] == $id) echo "selected"; ?>>
                                <?php echo $user['user_name']; ?> (<?php echo $user['user_nickname']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </form>
            </div>
        </div>
        <?php if ($id > 0) { ?>
            <form action="user_edit.php" method="POST" id="edit-user">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-group">
                    <label for="name">Username</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $username; ?>">
                </div>
                <div class="form-group">
                    <label for="nickname">Nickname</label>
                    <input type="text" class="form-control" id="nickname" name="nickname"
                           value="<?php echo $nickname; ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" class="form-control" id="password" name="password"
                           value="<?php echo $password; ?>">
                </div>
                <button type="submit" class="btn btn-primary" name="apply" value="apply">Apply Changes</button>
                <button type="submit" class="btn btn-danger" name="remove" value="remove">Remove User</button>
                <button type="button" class="btn btn-secondary" id="copy-info">Copy User Info</button>
            </form>
        <?php } ?>
    </div>

    <script src="<?php echo url_for('scripts/user_events.js'); ?>"></script>
<?php include_once '../../private/shared/default_footer.php'; ?>