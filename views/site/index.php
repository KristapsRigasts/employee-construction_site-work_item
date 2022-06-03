<?php

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent">
        <h4 class="display-5 mb-5">Employee, Construction Sites and Work Items</h4>

<?php if(Yii::$app->user->isGuest): ?>
        <p><a class="btn btn-lg btn-success" href="/site/login">Log in to continue</a></p>
        <?php endif; ?>
    </div>

</div>
