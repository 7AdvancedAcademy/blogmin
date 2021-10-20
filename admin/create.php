
<?php require_once "../config/database.php"; ?>
<?php require "components/header.php"; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = false;
    $error_message = "<ul class='text-danger'>";
    if (empty($_POST['title'])) {
        $error_message .= "<li> Invalid post title. </li>";
        $errors = true;
    }
    if (empty($_POST['content'])) {
        $error_message .= "<li> Invalid content body. </li>";
        $errors = true;
    }


    $post_title = $_POST['title'];
    $post_content = $_POST['content'];

    try {
        $statement = $db->prepare("INSERT INTO posts (title, content) VALUES(:title, :content)");
        $res = $statement->execute([
           "title" => $post_title,
           "content" => $post_content
        ]);
        echo $res;
        //header("Location: /admin/posts.php");
    } catch (\Exception $err) {
        $error_message .= "<li> Unable to store posts. </li>";
        print_r($err);
    }

    $error_message .= "</ul>";

    if ($errors) {
        echo "<br> $error_message <br>";
    }
}


?>

<main class="container">
    <form enctype="multipart/form-data" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="create-form">
        <legend>
            <h1>Create Blog Post</h1>
        </legend>
        <div class="form-group">
            <label for="titleInput">Post title</label>
            <input type="text" name="title" class="form-control" id="titleInput" placeholder="The collapse of Cameroon">
        </div>
        <div class="d-flex">
            <div class="form-group">
                <label for="coverInput">Cover images</label>
                <input type="file" name="cover" for="coverInput">
            </div>
            <div class="form-group">
                <label for="catInput">Categories</label>
                <select name="category" class="form-control" id="catInput">
                    <option>Politics</option>
                    <option>Musics</option>
                    <option>Regigion</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="editor">Post Content</label>
            <textarea name="content" class="form-control" rows="10" id="editor"></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success mt-2">
                Create Post
            </button>
        </div>
    </form>
</main>


<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .then(editor => {
            console.log(editor);
        })
        .catch(error => {
            console.error(error);
        });
</script>

<style>
    .ck-editor__editable_inline {
        min-height: 400px;
    }
</style>


<?php require "components/footer.php" ?>
