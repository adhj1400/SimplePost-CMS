<?php
// Print a table of posts for the user
function showPostList($post_amount)
{
    $postPrinter = new PostPrinter();

    $postPrinter->displayPosts($post_amount, $GLOBALS['database']);
}

function getPosts($offsetStart, $offsetEnd, $sortType)
{
    $DBTableArchiver = new DBTableArchiver($GLOBALS['database']);

    return $DBTableArchiver->getPostArray($offsetStart, $offsetEnd, $sortType);
}

function getPost($post_id)
{
    $DBTableArchiver = new DBTableArchiver($GLOBALS['database']);

    return $DBTableArchiver->getSinglePost($post_id);
}
?>