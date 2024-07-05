<?php
function titleAnimation() {
  ?>
  <div class="title">
      <h1><?= $_ENV['FIRST_NAME'] ?></h1>
      <div class="backgroundText">
        <?php 
          foreach (str_split($_ENV['LAST_NAME']) as $char) {
            echo "<span>$char</span>";
          };
        ?>
      </div>
    </div>
  <?php  
};