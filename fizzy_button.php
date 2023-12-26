<!-- fizzy_button.php -->
<div class="button">
    <input type="checkbox" id="button">
    <label for="button" class="button_inner q">
        <i class="l ion-log-in"></i>
        <span class="t">Login</span>
        <span>
            <i class="tick ion-checkmark-round"></i>
        </span>
        <div class="b_l_quad">
            <?php
            for ($i = 1; $i <= 52; $i++) {
                echo '<div class="button_spots"></div>';
            }
            ?>
        </div>
    </label>
</div>
