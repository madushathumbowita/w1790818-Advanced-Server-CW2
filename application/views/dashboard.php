<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/styling/dashboard.css'); ?>">
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
    <div class="container">
        <h1>Welcome to the Stack4U ! </h1>
        <form action="<?php echo site_url('dashboard/search'); ?>" method="post" class="search-form">
            <input type="text" name="keyword" placeholder="Search...">
            <button type="submit" class="button_search">Search</button>
        </form>        
        <div class="addquestion">
            <a href="<?php echo site_url('dashboard/add_question'); ?>"><button>Add Question</button></a>
        </div>
        <h2>Questions:</h2>
        <ul>
            <?php foreach ($questions as $question): ?>
                <li class="question-container">
                    <a href="<?php echo site_url('question/view/' . $question['question_id']); ?>">
                        <h3><?php echo $question['title']; ?></h3>
                    </a>
                    <p><?php echo $question['content']; ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
