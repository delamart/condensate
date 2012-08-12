<?php require 'header.part.php'; ?>

<h2>Link</h2>

<p>
    <a href="<?php echo $url; ?>"><?php echo $url; ?></a>
    (<?php echo $name; ?> <a href="/get/<?php echo $key; ?>">dl</a>)
</p>

<ol>
    <li><a href="/">Home</a></li>
</ol>

<?php require 'footer.part.php'; ?>
