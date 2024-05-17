<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question View</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/styling/question.css'); ?>">
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
        <?php if (isset($message)): ?>
            <p class="error-message"><?php echo $message; ?></p>
        <?php endif; ?>
        <h2><?php echo $question['title']; ?></h2>
        <p><?php echo $question['content']; ?></p>
        <h3>Answers:</h3>
        <ul>
            <?php foreach ($answers as $answer): ?>
                <li>
                    <p><?php echo $answer['content']; ?></p>
                    <?php if ($this->session->userdata('user_id')): ?>
                        <a href="<?php echo site_url('question/upvote_answer/' . $answer['answer_id'] . '/' . $answer['question_id']); ?>">Upvote</a>
                        <a href="<?php echo site_url('question/downvote_answer/' . $answer['answer_id'] . '/' . $answer['question_id']); ?>">Downvote</a>
                    <?php else: ?>
                        <p>Please <a href="<?php echo site_url('auth/login'); ?>">login</a> to upvote or downvote this answer.</p>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php if ($this->session->userdata('user_id')): ?>
            <a href="<?php echo site_url('savedQuestions/save/' . $question['question_id']) ?> " title="Save question"><button class="savequestion">Save</button></a>
        <?php else: ?>
            <p>Please <a href="<?php echo site_url('auth/login'); ?>">login</a> or <a href="<?php echo site_url('auth/signup'); ?>">sign up</a> to save this question.</p>
        <?php endif; ?>
    </div>
    <div class="container2">
        <form method="post" action="<?php echo site_url('question/submit_answer/' . $question['question_id']); ?>">
            <label for="answer_content">Your Answer:</label>
            <textarea name="answer_content" required></textarea>
            <button type="submit" class="submit_answer">Submit</button>
        </form>
    </div>                              
</body>
</html>
