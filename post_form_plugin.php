<?php

/**
 *Plugin Name: Post Form Plugin
* Description: This is a plugin for a form which takes input and then emails it to a predefined email in wp-config.php, This was developed as an assignment given to me during the selection process of an internship at Wingify.
* Version: 0.1.0
* Author: Varad Katkalambekar
* Author URI: https://varadkatkalambekar.github.io/resume/
 */

function post_form_plugin()
{
    $content = '';
    $content .= '<!doctype html>
    <html lang="en">
    
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    </head>
    
    <body>
        <h1>This is the form I made as a part of my assignment for the Wingify Internship. The tech stack used over here involves PHP for the backend, along with HTML and Bootstrap for the frontend. It uses a few inbuilt functions for cleaning of inputs provided by wordpress php. </h1>
        <form method="POST" action="http://localhost/wingify_internship/wordpress/?page_id=53" >
            <div class="mb-3">
                <label class="form-label">Enter your Name</label>
                <input type="text" class="form-control" name="contact_name" placeholder="Firstname Lastname" id="name" aria-describedby="emailHelp" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" class="form-control" name="contact_email" placeholder="email@domain" id="email" aria-describedby="emailHelp" required>
                <div id="emailHelp" class="form-text">We will never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label class="form-label">Post Title</label>
                <input type="text" maxlength="100" class="form-control" name="title" placeholder="Enter Title ( Less than 100 characters )" id="title" aria-describedby="emailHelp" required>
                <div id="emailHelp" class="form-text">Enter a crisp subject with less than 100 characters or in 15 to 20 words.</div>
                </div>
            <div class="mb-3">
              <label for="exampleFormControlTextarea1" class="form-label">Post Content</label>
              <textarea class="form-control" maxlength="300" name="content" placeholder="Enter Content ( Less than 300 characters ) " id="content" rows="3" required></textarea>
              <div id="emailHelp" class="form-text">Describe the content in less than 300 characters or 40 to 50 words.</div>  
            </div>           
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    
        <!-- Optional JavaScript; choose one of the two! -->
    
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
        -->
    </body>
    
    </html>';


    return $content;
}
add_shortcode('post_form', 'post_form_plugin');

function post_form_capture()
{
    if(isset($_POST['submit']))
    {
        if(filter_var($_POST['contact_email'], FILTER_VALIDATE_EMAIL))
            {   //first of all verify if an appropriate email is entered and then and only then allow the form to be sent!!!!
                //echo "<pre>";print_r($_POST);echo "</pre>";
                $name = sanitize_text_field($_POST['contact_name']);
                $email = sanitize_text_field($_POST['contact_email']);
                $title = sanitize_text_field($_POST['title']);
                $content = sanitize_textarea_field($_POST['content']);
                
                $to = predefined_email;
                $subject = 'Post Request Form Submission';
                $message = 'Hello. This form was submitted by '.$name.' whose email is '.$email.'. The topic of concern is '.$title.' and the concern is '.$content.'. Have a nice day!';

                wp_mail($to,$subject, $message);
            }
        else{
            echo "Invalid Email!!! Please Re enter the email";
        }
}
}
add_action('wp_head','post_form_capture');
?>
