<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Tags</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/styling/taglist.css'); ?>">
</head>
<body>
    <div class="navbar">
        <ul>
            <li><a href="<?php echo site_url('dashboard'); ?>">Home</a></li>
            <li><a href="<?php echo site_url('savedQuestions/index'); ?>">SavedQuestions</a></li>
            <li><a href="<?php echo site_url('tag/list_tags'); ?>">All Tags</a></li>
            <li><a href="<?php echo site_url('profile'); ?>">Profile</a></li>
        </ul>
    </div>
    <h1>All Tags:</h1>        
    <div class="container"> 
        <ul>
            <?php foreach ($tags as $tag): ?>
                <li><a href="<?php echo site_url('tag/view_questions_by_tag/' . $tag['tag_id']); ?>"><?php echo $tag['tag_name']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
