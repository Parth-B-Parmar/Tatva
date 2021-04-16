<?php
include "db.php";
session_start();

if (isset($_SESSION['email'])) {

    //for Pubhlish purpose define all variables as null
    $title = "";
    $categories = "";
    $type = "";
    $note_pages = "";
    $description = "";
    $country = "";
    $institute_name = "";
    $course_name = "";
    $course_code = "";
    $professor_name = "";
    $sell_type = "";
    $sell_price = "";
    $category = "";

    //session to get seller id
    $email = $_SESSION['email'];
    $query = "SELECT userid,lastname,firstname FROM users WHERE emailid='$email'";
    $userid = mysqli_query($con, $query);

    while ($row = mysqli_fetch_assoc($userid)) {
        $seller_id = $row['userid'];
        $full_name = $row['firstname'] . " " . $row['lastname'];
    }
    $valid_format_1 = true;
    $valid_format_2 = true;
    $valid_format_3 = true;

    if (isset($_POST['save'])) {

        $title = $_POST['title'];
        $category = $_POST['category'];
        $type = $_POST['type'];
        $note_pages = $_POST['no_of_page'];
        $description = $_POST['description'];
        $country = $_POST['country'];
        $institute_name = $_POST['institute_name'];
        $course_name = $_POST['course_name'];
        $course_code = $_POST['course_code'];
        $professor_name = $_POST['professor_name'];
        $sell_type = $_POST['Sell-for'];
        $sell_price = $_POST['sell_price'];
        $default_display_pic = "../Members/default/DP_default.jpg";

        $query_insert = "INSERT INTO sellernotes( sellerid, status, title, category,displaypic,
                     notetype,page_no, description,university_name, country, course, 
                     course_code, proffesor,ispaid, selling_price, createddate,createdby,modifieddate,isactive) VALUES 
                     ($seller_id,3,'$title',$category,'$default_display_pic',$type,$note_pages,
                     '$description', '$institute_name',$country,'$course_name','$course_code',
                     '$professor_name',$sell_type,'$sell_price',NOW(),$seller_id,NOW(),1)";

        $result_insert = mysqli_query($con, $query_insert);


        //to get above note id
        $note_id = mysqli_insert_id($con);


        //display picture
        $display_pic = $_FILES['display_picture'];
        $filename = $display_pic['name'];
        $filetmp = $display_pic['tmp_name'];
        $extention = explode('.', $filename);
        $filecheck = strtolower(end($extention));
        $fileextstored = array('jpg', 'png', 'jpeg');

        if (in_array($filecheck, $fileextstored)) {
            if (!is_dir("../Members/")) {
                mkdir('../Members/');
            }
            if (!is_dir("../Members/" . $seller_id)) {
                mkdir("../Members/" . $seller_id);
            }
            if (!is_dir("../Members/" . $seller_id . "/" . $note_id)) {
                mkdir('../Members/' . $seller_id . '/' . $note_id);
            }
            $destinationfile = '../Members/' . $seller_id . '/' . $note_id . '/' . "DP_" . time() . '.' . $filecheck;
            move_uploaded_file($filetmp, $destinationfile);
            $query_pic = "UPDATE sellernotes SET displaypic='$destinationfile' WHERE noteid=$note_id";
            $result_pic = mysqli_query($con, $query_pic);
        } else {
            $valid_format_1 = false;
        }


        //Note Preview
        $note_preview = $_FILES['note_preview'];
        $filename2 = $note_preview['name'];
        $filetmp2 = $note_preview['tmp_name'];
        $extention2 = explode('.', $filename2);
        $filecheck2 = strtolower(end($extention2));
        $fileextstored2 = array('pdf');

        if (in_array($filecheck2, $fileextstored2)) {
            if (!is_dir("../Members/")) {
                mkdir('../Members/');
            }
            if (!is_dir("../Members/" . $seller_id)) {
                mkdir("../Members/" . $seller_id);
            }
            if (!is_dir("../Members/" . $seller_id . "/" . $note_id)) {
                mkdir('../Members/' . $seller_id . '/' . $note_id);
            }
            $destinationfile2 = '../Members/' . $seller_id . '/' . $note_id . '/' . "Preview_" . time() . '.' . $filecheck2;
            move_uploaded_file($filetmp2, $destinationfile2);
            $query_preview = "UPDATE sellernotes SET notespreview='$destinationfile2' WHERE noteid=$note_id";
            $result_preview = mysqli_query($con, $query_preview);
        } else {
            $valid_format_3 = false;
        }


        //multiple files
        $upload_note = count($_FILES['upload_note']['name']);

        // Looping all files
        for ($i = 0; $i < $upload_note; $i++) {


            $filename3 = $_FILES['upload_note']['name'][$i];
            $extention3 = explode('.', $filename3);
            $filecheck3 = strtolower(end($extention3));
            $fileextstored3 = array('pdf');

            if (in_array($filecheck3, $fileextstored3)) {
                $query_multiple_path = "INSERT INTO sellernotesattachements (noteid,createddate,createdby,isactive) 
                                    VALUES ($note_id,NOW(),$seller_id,1)";
                $result_multiple_path = mysqli_query($con, $query_multiple_path);

                $attach_id = mysqli_insert_id($con);

                // Upload file
                if (!is_dir("../Members/")) {
                    mkdir('../Members/');
                }
                if (!is_dir("../Members/" . $seller_id)) {
                    mkdir("../Members/" . $seller_id);
                }
                if (!is_dir("../Members/" . $seller_id . "/" . $note_id)) {
                    mkdir('../Members/' . $seller_id . '/' . $note_id);
                }
                if (!is_dir("../Members/" . $seller_id . "/" . $note_id . "/" . "Attachements")) {
                    mkdir('../Members/' . $seller_id . '/' . $note_id . '/' . 'Attachements');
                }

                $multiple_file_name = '../Members/' . $seller_id . '/' . $note_id . '/' . 'Attachements/' . $attach_id . '_' . time() . '.' . $filecheck3;
                move_uploaded_file($_FILES['upload_note']['tmp_name'][$i], $multiple_file_name);

                $attached_name = $attach_id . "_" . time() . $filecheck3;
                $query_multiple_final = "UPDATE sellernotesattachements SET filename='$attached_name',filepath='$multiple_file_name' WHERE note_attach_id =$attach_id";
                $result_multiple_final = mysqli_query($con, $query_multiple_final);
            } else {
                $valid_format_2 = false;
            }
        }
        header('Location:dashboard-page.php');
    } else if (isset($_GET['id'])) {
        $publish_note_id = $_GET['id'];
        $fetch_detail = mysqli_query($con, "SELECT * FROM sellernotes WHERE noteid=$publish_note_id");

        while ($row = mysqli_fetch_assoc($fetch_detail)) {

            $categories_id = "";
            $countries_id = "";
            $sell_type_new = "";
            $title = $row['title'];
            $categories_id = $row['category'];
            $type = $row['notetype'];
            $note_pages = $row['page_no'];
            $description = $row['description'];
            $countries_id = $row['country'];
            $institute_name = $row['university_name'];
            $course_name = $row['course'];
            $course_code = $row['course_code'];
            $professor_name = $row['proffesor'];
            $sell_type_new = $row['ispaid'];
            $sell_price = $row['selling_price'];
        }

        $fetch_category = mysqli_query($con, "SELECT name FROM notecategories WHERE categoryid=$categories_id");
        while ($row = mysqli_fetch_assoc($fetch_category)) {
            $category_name = $row['name'];
        }

        $fetch_type = mysqli_query($con, "SELECT name FROM notetypes WHERE typeid =$type");
        while ($row = mysqli_fetch_assoc($fetch_type)) {
            $type_name = $row['name'];
        }

        $fetch_country = mysqli_query($con, "SELECT name FROM countries WHERE countryid=$countries_id");
        while ($row = mysqli_fetch_assoc($fetch_country)) {
            $country_name = $row['name'];
        }
    }

    if (isset($_POST['save2'])) {

        $dashboard_noteid = $_POST['id_getter'];
        $title = $_POST['title'];
        $category = $_POST['category'];
        $type = $_POST['type'];
        $note_pages = $_POST['no_of_page'];
        $description = $_POST['description'];
        $country = $_POST['country'];
        $institute_name = $_POST['institute_name'];
        $course_name = $_POST['course_name'];
        $course_code = $_POST['course_code'];
        $professor_name = $_POST['professor_name'];
        $sell_type = $_POST['Sell-for'];
        $sell_price = $_POST['sell_price'];

        $query_insert_save = "UPDATE sellernotes SET title='$title',category=$category,
                                  notetype=$type,page_no=$note_pages,description='$description',
                                  university_name='$institute_name',country=$country,course='$course_name',
                                  course_code='$course_code',proffesor='$professor_name',ispaid=$sell_type,
                                  selling_price='$sell_price',modifieddate=NOW(),modifiedby=$seller_id 
                                  WHERE noteid=$dashboard_noteid";

        $result_insert_save = mysqli_query($con, $query_insert_save);

        //display picture
        $display_pic = $_FILES['display_picture'];
        $filename = $display_pic['name'];
        $filetmp = $display_pic['tmp_name'];
        $extention = explode('.', $filename);
        $filecheck = strtolower(end($extention));
        $fileextstored = array('jpg', 'png', 'jpeg');

        if (in_array($filecheck, $fileextstored)) {
            if (!is_dir("../Members/")) {
                mkdir('../Members/');
            }
            if (!is_dir("../Members/" . $seller_id)) {
                mkdir("../Members/" . $seller_id);
            }
            if (!is_dir("../Members/" . $seller_id . "/" . $dashboard_noteid)) {
                mkdir('../Members/' . $seller_id . '/' . $dashboard_noteid);
            }
            $destinationfile = '../Members/' . $seller_id . '/' . $dashboard_noteid . '/' . "DP_" . time() . '.' . $filecheck;
            move_uploaded_file($filetmp, $destinationfile);
            $query_pic = "UPDATE sellernotes SET displaypic='$destinationfile' WHERE noteid=$dashboard_noteid";
            $result_pic = mysqli_query($con, $query_pic);
        } else {
            $valid_format_1 = false;
        }

        //Note Preview
        $note_preview = $_FILES['note_preview'];
        $filename2 = $note_preview['name'];
        $filetmp2 = $note_preview['tmp_name'];
        $extention2 = explode('.', $filename2);
        $filecheck2 = strtolower(end($extention2));
        $fileextstored2 = array('pdf');

        if (in_array($filecheck2, $fileextstored2)) {
            if (!is_dir("../Members/")) {
                mkdir('../Members/');
            }
            if (!is_dir("../Members/" . $seller_id)) {
                mkdir("../Members/" . $seller_id);
            }
            if (!is_dir("../Members/" . $seller_id . "/" . $dashboard_noteid)) {
                mkdir('../Members/' . $seller_id . '/' . $dashboard_noteid);
            }
            $destinationfile2 = '../Members/' . $seller_id . '/' . $dashboard_noteid . '/' . "Preview_" . time() . '.' . $filecheck2;
            move_uploaded_file($filetmp2, $destinationfile2);
            $query_preview = "UPDATE sellernotes SET notespreview='$destinationfile2' WHERE noteid=$dashboard_noteid";
            $result_preview = mysqli_query($con, $query_preview);
        } else {
            $valid_format_3 = false;
        }

        //multiple files
        $upload_note = count($_FILES['upload_note']['name']);

        // Looping all files
        for ($i = 0; $i < $upload_note; $i++) {


            $filename3 = $_FILES['upload_note']['name'][$i];
            $extention3 = explode('.', $filename3);
            $filecheck3 = strtolower(end($extention3));
            $fileextstored3 = array('pdf');

            if (in_array($filecheck3, $fileextstored3)) {
                $query_multiple_path = "INSERT INTO sellernotesattachements (noteid,createddate,createdby,isactive) 
                             VALUES ($dashboard_noteid,NOW(),$seller_id,1)";
                $result_multiple_path = mysqli_query($con, $query_multiple_path);

                $attach_id = mysqli_insert_id($con);

                // Upload file
                if (!is_dir("../Members/")) {
                    mkdir('../Members/');
                }
                if (!is_dir("../Members/" . $seller_id)) {
                    mkdir("../Members/" . $seller_id);
                }
                if (!is_dir("../Members/" . $seller_id . "/" . $dashboard_noteid)) {
                    mkdir('../Members/' . $seller_id . '/' . $dashboard_noteid);
                }
                if (!is_dir("../Members/" . $seller_id . "/" . $dashboard_noteid . "/" . "Attachements")) {
                    mkdir('../Members/' . $seller_id . '/' . $dashboard_noteid . '/' . 'Attachements');
                }

                $multiple_file_name = '../Members/' . $seller_id . '/' . $dashboard_noteid . '/' . 'Attachements/' . $attach_id . '_' . time() . '.' . $filecheck3;
                move_uploaded_file($_FILES['upload_note']['tmp_name'][$i], $multiple_file_name);

                $attached_name = $attach_id . "_" . time() . $filecheck3;
                $query_multiple_final = "UPDATE sellernotesattachements SET filename='$attached_name',filepath='$multiple_file_name' WHERE note_attach_id =$attach_id";
                $result_multiple_final = mysqli_query($con, $query_multiple_final);
            } else {
                $valid_format_2 = false;
            }
        }

        header('Location:dashboard-page.php');
    }
    if (isset($_POST['publish'])) {

        $dashboard_noteid = $_POST['id_getter'];
        $title = $_POST['title'];
        $category = $_POST['category'];
        $type = $_POST['type'];
        $note_pages = $_POST['no_of_page'];
        $description = $_POST['description'];
        $country = $_POST['country'];
        $institute_name = $_POST['institute_name'];
        $course_name = $_POST['course_name'];
        $course_code = $_POST['course_code'];
        $professor_name = $_POST['professor_name'];
        $sell_type = $_POST['Sell-for'];
        $sell_price = $_POST['sell_price'];

        $query_insert_publish = "UPDATE sellernotes SET status=4,publisheddate=NOW(),title='$title',category=$category,
                                  notetype=$type,page_no=$note_pages,description='$description',
                                  university_name='$institute_name',country=$country,course='$course_name',
                                  course_code='$course_code',proffesor='$professor_name',ispaid=$sell_type,
                                  selling_price='$sell_price',modifieddate=NOW(),modifiedby=$seller_id 
                                  WHERE noteid=$dashboard_noteid";

        $result_insert_pubhlish = mysqli_query($con, $query_insert_publish);

        //display picture
        $display_pic = $_FILES['display_picture'];
        $filename = $display_pic['name'];
        $filetmp = $display_pic['tmp_name'];
        $extention = explode('.', $filename);
        $filecheck = strtolower(end($extention));
        $fileextstored = array('jpg', 'png', 'jpeg');

        if (in_array($filecheck, $fileextstored)) {
            if (!is_dir("../Members/")) {
                mkdir('../Members/');
            }
            if (!is_dir("../Members/" . $seller_id)) {
                mkdir("../Members/" . $seller_id);
            }
            if (!is_dir("../Members/" . $seller_id . "/" . $dashboard_noteid)) {
                mkdir('../Members/' . $seller_id . '/' . $dashboard_noteid);
            }

            $destinationfile = '../Members/' . $seller_id . '/' . $dashboard_noteid . '/' . "DP_" . time() . '.' . $filecheck;
            move_uploaded_file($filetmp, $destinationfile);
            $query_pic = "UPDATE sellernotes SET displaypic='$destinationfile' WHERE noteid=$dashboard_noteid";
            $result_pic = mysqli_query($con, $query_pic);
        } else {
            $valid_format_1 = false;
        }

        //Note Preview
        $note_preview = $_FILES['note_preview'];
        $filename2 = $note_preview['name'];
        $filetmp2 = $note_preview['tmp_name'];
        $extention2 = explode('.', $filename2);
        $filecheck2 = strtolower(end($extention2));
        $fileextstored2 = array('pdf');

        if (in_array($filecheck2, $fileextstored2)) {
            if (!is_dir("../Members/")) {
                mkdir('../Members/');
            }
            if (!is_dir("../Members/" . $seller_id)) {
                mkdir("../Members/" . $seller_id);
            }
            if (!is_dir("../Members/" . $seller_id . "/" . $dashboard_noteid)) {
                mkdir('../Members/' . $seller_id . '/' . $dashboard_noteid);
            }
            $destinationfile2 = '../Members/' . $seller_id . '/' . $dashboard_noteid . '/' . "Preview_" . time() . '.' . $filecheck2;
            move_uploaded_file($filetmp2, $destinationfile2);
            $query_preview = "UPDATE sellernotes SET notespreview='$destinationfile2' WHERE noteid=$dashboard_noteid";
            $result_preview = mysqli_query($con, $query_preview);
        } else {
            $valid_format_3 = false;
        }

        //multiple files
        $upload_note = count($_FILES['upload_note']['name']);

        // Looping all files
        for ($i = 0; $i < $upload_note; $i++) {


            $filename3 = $_FILES['upload_note']['name'][$i];
            $extention3 = explode('.', $filename3);
            $filecheck3 = strtolower(end($extention3));
            $fileextstored3 = array('pdf');

            if (in_array($filecheck3, $fileextstored3)) {
                $query_multiple_path = "INSERT INTO sellernotesattachements (noteid,createddate,createdby,isactive) 
                      VALUES ($dashboard_noteid,NOW(),$seller_id,1)";
                $result_multiple_path = mysqli_query($con, $query_multiple_path);

                $attach_id = mysqli_insert_id($con);

                // Upload file
                if (!is_dir("../Members/")) {
                    mkdir('../Members/');
                }
                if (!is_dir("../Members/" . $seller_id)) {
                    mkdir("../Members/" . $seller_id);
                }
                if (!is_dir("../Members/" . $seller_id . "/" . $dashboard_noteid)) {
                    mkdir('../Members/' . $seller_id . '/' . $dashboard_noteid);
                }
                if (!is_dir("../Members/" . $seller_id . "/" . $dashboard_noteid . "/" . "Attachements")) {
                    mkdir('../Members/' . $seller_id . '/' . $dashboard_noteid . '/' . 'Attachements');
                }

                $multiple_file_name = '../Members/' . $seller_id . '/' . $dashboard_noteid . '/' . 'Attachements/' . $attach_id . '_' . time() . '.' . $filecheck3;
                move_uploaded_file($_FILES['upload_note']['tmp_name'][$i], $multiple_file_name);

                $attached_name = $attach_id . "_" . time() . $filecheck3;
                $query_multiple_final = "UPDATE sellernotesattachements SET filename='$attached_name',filepath='$multiple_file_name' WHERE note_attach_id =$attach_id";
                $result_multiple_final = mysqli_query($con, $query_multiple_final);
            } else {
                $valid_format_2 = false;
            }
        }
        
        $to = "pp895131@gmail.com";
        $subject =  $full_name . " sent his note for review";
        $body = "Hello Admins,<br><br> ";
        $body.= "We want to inform you that,<b>$full_name</b> sent his note<b>$title</b> for review. Please look at the notes and take required actions. <br><br>";
        $body.= "Regards, <br> ";
        $body.= "Notes Marketplace";

        $headers = "From: pp895131@gmail.com" ;
        $headers .= "MIME-Version: 1.0" . "\r\n" ;
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n" ;
        if(mail($to, $subject, $body, $headers))  {
            echo "Sent";
        } else {
            echo "failed";
        }
        header('Location:dashboard-page.php');
    }
} else {
    echo '<script>alert("if you want to add notes then you have to sign-up first! \nPress OK to redirect to log-in page");</script>';
    echo "<script>window.location.replace('log-in-page.php');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!--Meta tags-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0 ,user-scalable=no">

    <!--Title-->
    <title>Notes Marketplace</title>

    <!--Fevicon-->
    <link rel="icon" href="images/favicon.ico">

    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!--Font-Awesome-->
    <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">

    <!--bootstrap css-->
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">

    <!--Custom css-->
    <link rel="stylesheet" href="css/style.css">

    <!--Responsive css-->
    <link rel="stylesheet" href="css/responsive.css">

</head>

<body class="sticky-header">

    <!--header -->
    <?php include "header.php" ?>
    <!--header end-->

    <div id="search-all-font">
        <div id="search-top-img">
            <img src="images/banner-with-overlay-user-profile.jpg" alt="Banner image" class="img-fluid">
            <div id="search-home-heading" class="text-center">
                <h3 class="heading-margin">Add Notes</h3>
            </div>
        </div>
        <div id="add-notes-heading">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="blue-font-34">Basic Note Details</h4>
                    </div>
                </div>
            </div>
        </div>
        <form action="add-notes-page.php" method="POST" enctype="multipart/form-data">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Title *</label>
                                <input type="text" value="<?php echo $title ?>" name="title"
                                    class="form-control input-light-color" required
                                    placeholder="Enter your notes title">
                            </div>
                            <div class="form-group col-md-6 add-notes-length-restorer">
                                <label class="right-content">Category *</label>
                                <select name="category"
                                    class="form-control input-light-color options-arrow-down right-content" required>
                                    <?php
                                    if (isset($_GET['id'])) {
                                        echo "<option selected value='$categories_id'>$category_name</option>";

                                        $query_category = "SELECT name,categoryid FROM notecategories";
                                        $result_category = mysqli_query($con, $query_category);

                                        while ($raw = mysqli_fetch_assoc($result_category)) {
                                            $categories = $raw['name'];
                                            $category_id = $raw['categoryid'];
                                            if ($category_id == $categories_id)
                                                echo "";
                                            else
                                                echo "<option value='$category_id'>$categories</option>";
                                        }
                                    } else {
                                        $query_category = "SELECT name,categoryid FROM notecategories";
                                        $result_category = mysqli_query($con, $query_category);
                                        echo "<option value='' selected disabled>Select your Category</option>";

                                        while ($raw = mysqli_fetch_assoc($result_category)) {
                                            $categories = $raw['name'];
                                            $category_id = $raw['categoryid'];
                                            echo "<option value='$category_id'>$categories</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Display Picture</label>
                                <div class="user-profile-photo-uploader">
                                    <label for="upload-file"><img src="images/upload-file.png"
                                            title="Click here to Display your note Picture"
                                            alt="Upload your photo here"></label>
                                    <input id="upload-file" name="display_picture"
                                        class="form-control input-light-color" type="file">
                                    <div style="margin-top: 22px;font-weight: 600;font-size: 15px"
                                        id="file-upload-filename"></div>
                                </div>
                                <div class="alert-msg">
                                    <?php
                                    if (empty($display_pic)) {
                                        echo "";
                                    } else if ($valid_format_1 == false) {
                                        echo "Only JPEG,JPG,PNG file formats are supported!";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="right-content">Upload Notes *</label>
                                <div class="user-profile-photo-uploader right-content">
                                    <label for="upload-note"><img style="height: 46px;" src="images/upload-note.png"
                                            class="right-content" title="Click here to upload your Notes"
                                            alt="Upload your photo here"></label>
                                    <input id="upload-note" name="upload_note[]" <?php if (isset($_GET['id'])) echo "";
                                                                                    else echo "required"; ?>
                                        class="form-control right-content input-light-color" type="file" multiple>
                                </div>
                                <div class="right-content alert-msg">
                                    <?php
                                    if ($valid_format_2 == false)
                                        echo "Only Pdf Files can be uploaded";
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Type *</label>
                                <select name="type" class="form-control options-arrow-down input-light-color" required>
                                    <?php
                                    if (isset($_GET['id'])) {
                                        echo "<option selected value='$type'>$type_name</option>";
                                        $query_type = "SELECT name,typeid FROM notetypes";
                                        $result_type = mysqli_query($con, $query_type);

                                        while ($raw = mysqli_fetch_assoc($result_type)) {
                                            $types = $raw['name'];
                                            $type_id = $raw['typeid'];
                                            if ($type_id == $type) {
                                                echo "";
                                            } else
                                                echo " <option value='$type_id'>$types</option>";
                                        }
                                    } else {
                                        echo "<option value='' selected disabled>Select your note type</option>";
                                        $query_type = "SELECT name,typeid FROM notetypes";
                                        $result_type = mysqli_query($con, $query_type);

                                        while ($raw = mysqli_fetch_assoc($result_type)) {
                                            $types = $raw['name'];
                                            $type_id = $raw['typeid'];
                                            echo " <option value='$type_id'>$types</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6 add-notes-length-restorer">
                                <label class="right-content">Number of Pages *</label>
                                <input name="no_of_page" type="number" value="<?php echo $note_pages ?>"
                                    class="form-control right-content input-light-color"
                                    placeholder="Enter number of note pages" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Description *</label>
                                <textarea name="description" id="add-notes-des-form"
                                    placeholder="Enter your description" required
                                    class="form-control input-light-color"><?php echo $description ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="form-heading-4">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            Institution Information
                        </div>
                    </div>
                </div>
            </div>

            <!-- Institution Information form -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Country</label>
                                <select name="country" class="form-control options-arrow-down input-light-color"
                                    required>
                                    <?php
                                    if (isset($_GET['id'])) {
                                        echo "<option selected value='$countries_id'>$country_name</option>";
                                        $query_country = "SELECT name,countryid FROM countries";
                                        $result_country = mysqli_query($con, $query_country);

                                        while ($raw = mysqli_fetch_assoc($result_country)) {
                                            $countries = $raw['name'];
                                            $country_id = $raw['countryid'];
                                            if ($countries_id == $country_id)
                                                echo "";
                                            else
                                                echo "<option value='$country_id'>$countries</option>";
                                        }
                                    } else {
                                        echo "<option value='' selected disabled>Select your country</option>";
                                        $query_country = "SELECT name,countryid FROM countries";
                                        $result_country = mysqli_query($con, $query_country);

                                        while ($raw = mysqli_fetch_assoc($result_country)) {
                                            $countries = $raw['name'];
                                            $country_id = $raw['countryid'];
                                            echo "<option value='$country_id'>$countries</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6 add-notes-length-restorer">
                                <label class="right-content">Institution Name</label>
                                <input name="institute_name" type="text" value="<?php echo $institute_name ?>"
                                    class="form-control right-content input-light-color"
                                    placeholder="Enter your Institution Name">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="form-heading-2">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            Course Details
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Details form -->
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Course Name</label>
                                <input type="text" name="course_name" class="form-control input-light-color"
                                    value="<?php echo $course_name ?>" placeholder="Enter your Course Name">
                            </div>
                            <div class="form-group col-md-6 add-notes-length-restorer">
                                <label class="right-content">Course Code</label>
                                <input type="text" name="course_code" value="<?php echo $course_code ?>"
                                    class="form-control right-content input-light-color"
                                    placeholder="Enter your Course Code">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Professor / Lecturer Name</label>
                                <input type="text" name="professor_name" class="form-control input-light-color"
                                    value="<?php echo $professor_name ?>" placeholder="Enter your Professor Name">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="form-heading-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            Selling Information
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selling Information form -->
            <div id="add-note-sell-info">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Sell For *</label>
                                    <div id="add-notes-radio-merger">
                                        <div class="form-check">
                                            <?php
                                            if (isset($_GET['id'])) { ?>
                                            <input class='form-check-input'
                                                <?php if ($sell_type_new == 2) echo "checked"; ?> type='radio'
                                                name='Sell-for' id='exampleRadios1' onclick="disablePrice()" value='2'>
                                            <?php } else {
                                                $query_note_mode = "SELECT refdataid FROM referencedata WHERE value='Free'";
                                                $result_note_mode = mysqli_query($con, $query_note_mode);
                                                while ($row = mysqli_fetch_assoc($result_note_mode)) {
                                                    $note_type = $row['refdataid'];
                                                    echo "<input class='form-check-input' type='radio' name='Sell-for'
                                                id='exampleRadios1' onclick=" . "disablePrice()" . " value='$note_type' checked>";
                                                }
                                            }
                                            ?>
                                            <label class="form-check-label" for="exampleRadios1">Free</label>
                                        </div>
                                        <div class="form-check">
                                            <?php
                                            if (isset($_GET['id'])) { ?>

                                            <input class='form-check-input'
                                                <?php if ($sell_type_new == 1) echo "checked"; ?> type='radio'
                                                name='Sell-for' id='exampleRadios2' onclick="enablePrice()" value='1'>
                                            <?php } else {
                                                $query_note_mode = "SELECT refdataid FROM referencedata WHERE value='Paid'";
                                                $result_note_mode = mysqli_query($con, $query_note_mode);
                                                while ($row = mysqli_fetch_assoc($result_note_mode)) {
                                                    $note_type = $row['refdataid'];
                                                    echo "<input class='form-check-input' type='radio' name='Sell-for'
                                                      id='exampleRadios2' onclick=" . "enablePrice()" . " value='$note_type'>";
                                                }
                                            }
                                            ?>
                                            <label class="form-check-label" for="exampleRadios2">Paid</label>
                                        </div>
                                    </div>
                                    <div id="add-note-sell-price">
                                        <label>Sell price *</label>
                                        <input type="number" step=".01" name="sell_price" id="price-box"
                                            value="<?php echo $sell_price ?>" class="form-control input-light-color"
                                            placeholder="Enter your Price" disabled>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="right-content">Note Preview</label>
                                    <div id="note-preview-res"
                                        class="user-profile-photo-uploader right-content notes-preview-uploader">
                                        <label for="note-preview"><img src="images/upload-file.png"
                                                title="Click here to upload your photo"
                                                alt="Upload your Preview here"></label>
                                        <input id="note-preview" name="note_preview"
                                            class="form-control input-light-color" type="file">
                                        <div style="font-size: 15px;margin-top:70px;font-weight: 600;"
                                            id="file-upload-filename2"></div>
                                    </div>
                                    <div class="alert-msg right-content">
                                        <?php
                                        if (empty($note_preview)) {
                                            echo "";
                                        } else if ($valid_format_3 == false) {
                                            echo "Only JPEG,JPG,PNG file formats are supported!";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <?php if (isset($_GET['id'])) {
                    $temp_id = $_GET['id']; ?>
                <input name="id_getter" <?php echo "value='$temp_id'"; ?> type="hidden"> <?php } ?>
            </div>
            <div id="add-notes-buttons">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <?php

                            //when redirected from dashboard 
                            if (isset($_GET['id']) && !isset($_GET['clone'])) { ?>
                            <button type="submit" name="save2"
                                class="btn-primary btn blue-button-hover-white">save</button>
                            <a data-target="#publish-popup" data-toggle="modal"
                                class="btn-primary btn blue-button-hover-white">publish</a>


                            <!-- publish Pop up -->
                            <div style="margin-top: 150px;" id="publish-popup" class="modal fade" tabindex="-1"
                                role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <button type="button" class="close text-right popup-close-btn"
                                            data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <div class="modal-body">
                                            <h4 class="title_for_publish blue-font-20">Publishing
                                                '<span class="note-dark-font"><?php echo $title ?></span>' will
                                                send note to administrator for review, once administrator review and
                                                approve then this note will be published to portal.
                                            </h4>
                                            <h4 class="blue-font-20 title-setter">
                                                Please press yes to continue.
                                            </h4>
                                            <button type="submit" name="publish"
                                                class="btn btn-primary blue-button-hover-white review-btn">yes</button>
                                            <button class="btn btn-primary red-button-hover-white btn-upper"
                                                data-dismiss="modal">no</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- publish Pop up end-->

                            <!-- for cloning -->
                            <?php
                            } else if (isset($_GET['clone']) && isset($_GET['id'])) { ?>
                            <button type="submit" name="save"
                                class="btn-primary btn blue-button-hover-white">save</button>
                            <button disabled class="btn-primary btn blue-button-hover-white-disabled">publish</button>
                            <?php }

                            //when adding notes for the first time
                            else { ?>
                            <button type="submit" name="save"
                                class="btn-primary btn blue-button-hover-white">save</button>
                            <button disabled class="btn-primary btn blue-button-hover-white-disabled">publish</button>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!--footer-->
        <?php include "footer.php"; ?>
        <!--footer end-->

    </div>

    <!--popper js-->
    <script src="js/popper/popper.min.js"></script>

    <!--jquery js-->
    <script src="js/jquery/jquery.min.js"></script>

    <!--bootstrap js-->
    <script src="js/bootstrap/bootstrap.min.js"></script>

    <!--Custom Script-->
    <script src="js/script.js"></script>

    <script>
    //enable and disable price input
    function disablePrice() {
        $("#price-box").attr("disabled", true);
        $("#price-box").attr("required", false);
    }

    function enablePrice() {
        $("#price-box").attr("disabled", false);
        $("#price-box").attr("required", true);
    }

    //show file name
    var input = document.getElementById("upload-file");
    var infoArea = document.getElementById("file-upload-filename");
    input.addEventListener("change", showFileName);

    function showFileName(event) {
        var input = event.srcElement;
        var fileName = input.files[0].name;
        infoArea.textContent = "File name: " + fileName;
    }

    var input2 = document.getElementById("note-preview");
    var infoArea2 = document.getElementById("file-upload-filename2");
    input2.addEventListener("change", showFileName2);

    function showFileName2(event) {
        var input2 = event.srcElement;
        var fileName2 = input2.files[0].name;
        infoArea2.textContent = "File name: " + fileName2;
    }

    // if note is paid
    <?php if (isset($_GET['id']) && ($sell_type_new == 1)) { ?>
    $("#price-box").attr("disabled", false);
    $("#price-box").attr("required", true);
    <?php }  ?>
    </script>

</body>

</html>