<?php require 'header.part.php'; ?>

<h2>New File</h2>

<p>
    <form action="/new/upload" method="post" enctype="multipart/form-data">
        <input type="file" name="file" />
        <input type="submit" />
    </form>
</p>

<ol>
    <li><a href="/">Home</a></li>
</ol>

<?php require 'footer.part.php'; ?>
