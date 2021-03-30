<h2>Sign Up to Get Notified About New Books</h2>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<fieldset>
    <label>First Name</label>
        <input type="text" name="first_name" value="<?php if (isset($_POST['first_name'])) echo (htmlspecialchars($_POST['first_name'])) ?>">
        <span class="error"><?php echo $first_name_err?></span>
    <label>Last Name</label>
        <input type="text" name="last_name" value="<?php if (isset($_POST['last_name'])) echo (htmlspecialchars($_POST['last_name'])) ?>">
        <span class="error"><?php echo $last_name_err?></span>
    <label>Phone number</label>
        <input type="tel" name="phone" placeholder="xxx-xxx-xxxx" value="<?php if (isset($_POST['phone'])) echo (htmlspecialchars($_POST['phone'])) ?>">
        <span class="error"><?php echo $phone_err?></span>
    <label>Email</label>
        <input type="email" name="email" value="<?php if (isset($_POST['email'])) echo (htmlspecialchars($_POST['email'])) ?>">
        <span class="error"><?php echo $email_err?></span>
    <label>Geographic Areas of Interest</label>
        <ul>
            <li><input type='checkbox' name="regions[]" value="Portland, Oregon" <?php echo defaultUnchecked("Portland, Oregon") ?>>  Portland, Oregon</li>

            <li><input type='checkbox'  name="regions[]" value="Western Oregon" <?php echo defaultUnchecked("Western Oregon") ?>>  Western Oregon</li>
            
            <li><input type='checkbox' name="regions[]" value="Eastern Oregon" <?php echo defaultUnchecked("Eastern Oregon") ?>>  Eastern Oregon</li>
            
            <li><input type='checkbox' name="regions[]" value="Seattle, Washington" <?php echo defaultUnchecked("Seattle, Washington") ?>>  Seattle, Washington</li>

            <li><input type='checkbox' name="regions[]" value="Western Washington" <?php echo defaultUnchecked("Western Washington") ?>>  Western Washington</li>

            <li><input type='checkbox' name="regions[]" value="Eastern Washington" <?php echo defaultUnchecked("Eastern Washington") ?>>  Eastern Washington</li>

            <li><input type='checkbox' name="regions[]" value="Vancouver, British Columbia" <?php echo defaultUnchecked("Vancouver, British Columbia") ?>>  Vancouver, British Columbia</li>

            <li><input type='checkbox' name="regions[]" value="British Colubmia" <?php echo defaultUnchecked("British Colubmia") ?>>  British Columbia</li>
            <li><input type='checkbox' name="regions[]" value="Idaho" <?php echo defaultUnchecked("Idaho") ?>>  Idaho</li>
        </ul>
        <span class="error"><?php echo $region_error; ?></span>
        <label>Email frequency</label>
            <select name="frequency">
                <option value="NULL">Select one</option>
                <option value="weekly" <?php if (isset($_POST['frequency']) && $_POST['frequency'] == 'weekly') echo "selected='selected'" ?>>Weekly</option>
                <option value="monthly" <?php if (isset($_POST['frequency']) && $_POST['frequency'] == 'monthly') echo "selected='selected'" ?>>Monthly</option>
                <option value="bimonthly" <?php if (isset($_POST['frequency']) && $_POST['frequency'] == 'bimonthly') echo "selected='selected'" ?>>Bimonthly</option>
            </select>
            <span class="error"><?php echo $frequency_err ?></span>
        <label>Privacy policy</label>
            <ul>
                <li><input type="radio" name="agree" value="agree" <?php if (isset($_POST['agree'])) echo "checked='checked'" ?>>Agree</li>
            </ul>
            <span class="error"><?php echo $agree_err?></span>
        <button type="submit" name="submit_contact_form">Submit</button>
        <p class="reset"><a href="">Reset</a></p>
        </fieldset>
    </form>
    