<?php
include "db.php";

//if systemconfiguration table has null entry
$fb_url = "https://www.facebook.com/TatvaSoft/";
$twitter_url = "https://twitter.com/tatvasoft?s=20";
$linkedin_url = "https://www.linkedin.com/company/tatvasoft";

//fb_url getter
$url_getter = mysqli_query($con, "SELECT value FROM systemconfiguration WHERE key_info='fb_url'");
while ($row = mysqli_fetch_assoc($url_getter))
    $fb_url =  $row['value'];

//twitter_url getter
$url_getter = mysqli_query($con, "SELECT value FROM systemconfiguration WHERE key_info='twitter_url'");
while ($row = mysqli_fetch_assoc($url_getter))
    $twitter_url =  $row['value'];


//linkedin_url getter
$url_getter = mysqli_query($con, "SELECT value FROM systemconfiguration WHERE key_info='linkedin_url'");
while ($row = mysqli_fetch_assoc($url_getter))
    $linkedin_url = $row['value'];

?>

<!--footer-->
<footer>
    <div id="footer">
        <hr>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h3>Copyright &#169; TatvaSoft  All rights reserved.
                    </h3>
                </div>
                <div class="col-md-6">
                    <ul class="footer-social-list">
                        <li><a href="<?php echo $fb_url ?>"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li><a href="<?php echo $twitter_url ?>"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li><a href="<?php echo $linkedin_url ?>"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--footer end-->