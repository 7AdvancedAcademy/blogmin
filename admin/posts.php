<?php include __DIR__ . "/RouteGuard.php";  ?>
<?php require_once __DIR__ . "/../config/database.php"; ?>
<?php require __DIR__ . "/components/header.php"; ?>


<?php

try {
  $statement = $db->prepare("SELECT * FROM posts");
  $res_succeed = $statement->execute();
} catch (\Exception $err) {
  $error_message .= "<li> Unable to store posts. </li>";
  print_r($err);
}

?>


<main class="container">
  <h1>Posts</h1>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">ID</th>
        <th scope="col">Title</th>
        <th scope="col">Cover</th>
        <th scope="col">Excerpt</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($res_succeed) { ?>
      <?php while ($row = $statement->fetch()) {
        $excerpt = strip_tags($row['content']);
        if(strlen($excerpt) > 100) $excerpt = substr($excerpt, 0, 100)."...";
          echo <<<ROW
        <tr>
        <th scope="row">$row[id]</th>
        <td>$row[title]</td>
        <td>$row[img]</td>
        <td>$excerpt</td>
        <td>
        <button>edit</button>
        <button>delete</button>
        </td>
      </tr>
      ROW;
        }
      } else {

        echo "<tr><td colspan='5'>No posts yet</td></tr>";
      }
      ?>



    </tbody>
  </table>
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