<?php
// Template Name: Home
get_header();
?>

<form id="create_post_form" method="post">
    <input type="text" id="title" name="title" placeholder="Post Title" />
    <textarea id="post_content" name="content" placeholder="Post Content"></textarea>
    <input type="submit" value="Submit">
</form>

<?php
get_footer();
