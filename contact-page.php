<?php
// Functions to filter user inputs
function filterName($field){
    // Sanitize user name
    $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
    
    // Validate user name
    if(filter_var($field, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        return $field;
    } else{
        return FALSE;
    }
}    
function filterEmail($field){
    // Sanitize e-mail address
    $field = filter_var(trim($field), FILTER_SANITIZE_EMAIL);
    
    // Validate e-mail address
    if(filter_var($field, FILTER_VALIDATE_EMAIL)){
        return $field;
    } else{
        return FALSE;
    }
}
function filterString($field){
    // Sanitize string
    $field = filter_var(trim($field), FILTER_SANITIZE_STRING);
    if(!empty($field)){
        return $field;
    } else{
        return FALSE;
    }
}
 
// Define variables and initialize with empty values
$nameErr = $emailErr = $messageErr = "";
$name = $email = $subject = $message = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate user name
    if(empty($_POST["name"])){
        $nameErr = "Please enter your name.";
    } else{
        $name = filterName($_POST["name"]);
        if($name == FALSE){
            $nameErr = "Please enter a valid name.";
        }
    }
    
    // Validate email address
    if(empty($_POST["email"])){
        $emailErr = "Please enter your email address.";     
    } else{
        $email = filterEmail($_POST["email"]);
        if($email == FALSE){
            $emailErr = "Please enter a valid email address.";
        }
    }
    
    // Validate message subject
    if(empty($_POST["subject"])){
        $subject = "";
    } else{
        $subject = filterString($_POST["subject"]);
    }
    
    // Validate user comment
    if(empty($_POST["message"])){
        $messageErr = "Please enter your comment.";     
    } else{
        $message = filterString($_POST["message"]);
        if($message == FALSE){
            $messageErr = "Please enter a valid comment.";
        }
    }
    
    // Check input errors before sending email
    if(empty($nameErr) && empty($emailErr) && empty($messageErr)){
        // Recipient email address
        $to = 'abdullahakinwumi@gmail.com';
        
        // Create email headers
        $headers = 'From: '. $email . "\r\n" .
        'Reply-To: '. $email . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        $headers2 = 'From: '. $to . "\r\n" .
        'Reply-To: '. $to . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
        
        // Sending email
        // ini_set('SMTP','myserver');
        // ini_set('smtp_port',25);
        $subject2 = "confirmation";
        $message2 = "Your message has been received, we will get back to you soonest";
        if(mail($to, $subject, $message, $headers)){
            mail($email, $subject2, $message2, $headers2);
            echo '<p class="success">Your message has been sent successfully!</p>';
        } else{
            echo '<p class="error">Unable to send email. Please try again!</p>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
​
       <!--Bootstrap-->
   <!-- <link rel="stylesheet" href="Boostrap/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">  -->
    <link rel="stylesheet" href="style.css">
​
    <title>Contact page</title>
    <style type="text/css">
        .error{ color: red; }
        .success{ color: green; }
    </style>
</head>
<body>
    <div class="container">
​
​
        <div class="page-header">
           <h1>CONTACT US</h1>
           <p class="lead"><i> We are one mail away and we would love to hear from you.</i></p>
        </div>
        <br> <br> <hr>
​
​
        <div class="row">
            <div class="col-sm-6">
        <form action="index.php" method="post">
        
        <div class="form-group">
           
          <label for="inputName">Name:<sup>*</sup></label>
          <input type="text" name="name" class="form-control"  id="inputName" placeholder="enter your name"  value="<?php echo $name; ?>"> 
          <span class="error"><?php echo $nameErr; ?></span>
        </div>
        <div class="form-group">
        
          <label for="inputEmail">Email:<sup>*</sup></label>
          <input type="email" name="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="your@email.com" value="<?php echo $email; ?>">
          <div class="emailNote"> <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small></div>
          <span class="error"><?php echo $emailErr; ?></span>
        </div>
        <div class="form-group">
           
          <label for="inputSubject">Subject:</label>
          <input type="text" name="subject" class="form-control"  id="inputName" id="inputSubject" value="<?php echo $subject; ?>">
        </div>
        <div class="form-group">
        
          <label for="inputComment">Message:<sup>*</sup></label>
            <textarea class="form-control" name="message" id="inputComment" rows="5" cols="30"><?php echo $message; ?></textarea>
            <span class="error"><?php echo $messageErr; ?></span>
        </div>
        
        <button type="submit" name="submit" class="btn btn-primary">Send message</button>
      </form>
    </div>
​
    </div>
​
​
</div>
</body>
</html>