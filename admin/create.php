<?php include __DIR__ . "/RouteGuard.php";  ?>
<?php require_once __DIR__ . "/../config/database.php"; ?>
<?php require __DIR__ . "/components/header.php"; ?>

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

    if (!$errors) {
        $cover_image_path = NULL;
        if (is_uploaded_file($_FILES['cover']['tmp_name'])) {
            $name = strtolower(str_replace(' ', '_', $_FILES['cover']['name']));
            $cover_image_path = "/uploads/$name";
            move_uploaded_file($_FILES['cover']['tmp_name'], $cover_image_path);
        }

        try {
            $statement = $db->prepare("INSERT INTO posts (title, content, img) VALUES(:title, :content, :img)");
            $res = $statement->execute([
                "title" => $post_title,
                "content" => $post_content,
                "img" => $cover_image_path
            ]);
            header("Location: /admin/posts.php");
        } catch (\Exception $err) {
            $error_message .= "<li> Unable to store posts. </li>";
            print_r($err);
        }
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/5.10.0/tinymce.min.js" integrity="sha512-XNYSOn0laKYg55QGFv1r3sIlQWCAyNKjCa+XXF5uliZH+8ohn327Ewr2bpEnssV9Zw3pB3pmVvPQNrnCTRZtCg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    tinymce.init({
        selector: '#editor', // change this value according to your HTML
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table paste code help wordcount"
            // "mediaembed"
        ],
        toolbar: "undo redo | formatselect | bold italic backcolor | \
alignleft aligncenter alignright alignjustify | \
bullist numlist checklist outdent indent | removeformat link | image media | table pageembed | code searchreplace |help",
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement("input");
            input.setAttribute("type", "file");
            input.setAttribute("accept", "image/*");
            input.onchange = function() {
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = function() {
                    /*
Note: Now we need to register the blob in TinyMCEs image blob
registry. In the next release this part hopefully won't be
necessary, as we are looking to handle it internally.
*/
                    var id = "blobid" + new Date().getTime();
                    var blobCache =
                        tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(",")[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    /* call the callback and populate the Title field with the file name */
                    cb(blobInfo.blobUri(), {
                        title: file.name
                    });
                };
                reader.readAsDataURL(file);
            };

            input.click();
        }
    });
</script>

<style>
    .ck-editor__editable_inline {
        min-height: 400px;
    }
</style>


<?php require "components/footer.php" ?>