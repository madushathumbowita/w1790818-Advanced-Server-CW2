<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions by Tag</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/styling/tagquestion.css'); ?>">
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
    <h1>Questions by Tag</h1>
    <div class="container">
        <ul>
            <?php foreach ($questions as $question): ?>
                <li>
                <a href="<?php echo site_url('question/view/' . $question['question_id']); ?>">
                    <h3><?php echo $question['title']; ?></h3>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
</body>
</html>