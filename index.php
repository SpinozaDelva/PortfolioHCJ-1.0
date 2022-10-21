<?php
//validation php
  $error= "";
 $successMessage="";

if ($_POST) {

    if (!$_POST["email"]) {

        $error .= "An email address is required. <br>";

    }
    if (!$_POST["content"]) {

        $error .= "Your message is required .<br>";
    }
    if (!$_POST["subject"]) {

        $error .= "The subject is required. <br>";

    }

    if ($_POST['email'] && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false) {

        $error .= "The email address is invalid. <br>";

    }
    if ($error != "") {

        $error = '<div class="alert alert-danger" role="alert"><p>There were error(s) in your form:</p>' . $error . '</div>';

    }else {

        $emailTo = "spinoza@spinosoftbits.com";

        $subject = $_POST ['subject'];

        $content = $_POST['content'];

        $headers = "From: ".$_POST ['email'];

        if (mail($emailTo, $subject,  $content, $headers)) {

            $successMessage= '<div class= "alert alert-success" role="alert"> Your message was sent, I will get back to you ASAP ! </div>';

        } else {

            $error = '<div class="alert alert-danger" role="alert"> <p> <strong> Your message couldn\'t be sent - please try again later </div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css?version=1">
        <title> Spinoza Delva Portfolio </title>
        <script  type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://s.cdpn.io/53148/requestAnimationFrame.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
       
        <!--title-icon-->

        <link rel="shortcut-icon" href="images/icon.png">
        <!--fav icon--->
        <link rel="apple-touch-icon" sizes="180x180" href="./images/Fav/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="./images/Fav/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="./images/Fav/favicon-16x16.png">
        <link rel="manifest" href="./images/Fav/site.webmanifest">

    </head>

    <body>
    <!------------------------------------------------Nav--------------------------------------------->
        <section id="main">
                <!--------logo------->
            
            <nav id="Navbar" style="z-index: 1;">
                <a href="#" class="logo"><img src="./images/logo3.png" alt=""></a>
                <div class="toggle"></div>
                <ul class="menu">
                    <li><a href="#main" class="active">Home</a></li>         
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact-form">Contact</a></li>
                </ul>

                <div class="btn btn-small">
                    <small>Try Demo app</small>
                    <button class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Simple Diary to describe how I use database including queries manipulations"  onclick=" window.open('https://spinosoftbits.com/DiaryApp/index.php','_blank')">
                        DiaryApp
                    </button>   
                 <i  id="#tooltip" data-toggle="tooltip" data-placement="bottom" title="Simple Diary to describe how I use database including queries manipulations"  class="fa fa-info-circle"></i>               
                </div>
                <a href="#" class="lang">En</a>
            </nav>

            <div class="alert-nav">
            <div class="alert alert-success w-100 p-3 popUp" id="alert-success-btn" role="alert">
            <strong>Welcome! -Mobile Friendly-</strong> This is for educational and training purpose, welcome to my portfolio handscripted, your feedback are welcome, try the secret DiaryApp Demo </div>
            </div>
            
    <!-----------------------------------------Main------------------------------------------------------------->

            <div class="name">   

               <!-- <canvas id="canvas"></canvas>-->
                
                <div class="animations"><canvas id="animated" width="200" height="200"></canvas></div>

                <div id="MyClockDisplay" class="clock" onload="showTime()"></div>

                <div class="alert alert-dismissible fade show" role="alert" id="quotes">
                <p style="z-index: 5;" id="quote">.... </p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>  
                
                <h6>Greetings,</h6>
                <h1>My name is <font color="#17d1ac">Spinoza</font> Delva</h1>
                <p class="details"> I am a Computer Programmer, with experience in Software development, Web Apps, and Mobile Applications... I've done my studies at ASA
                college where I graduated with an <a href="./images/ASA.Degree.pdf" class="btn-degree" target="_blank"> Associate degree in Computer Programming & IT. </a> I am pursuing my bachelor's in Computer Engineering, exploring engineering has expanded my knowledge and experiences around software and hardware.
                I am currently employed as a software developer and gaining more knowledge and professional habits for my current employer. However, I am available for freelance projects, contact me with your inquiries... I use HTML5/CSS3, React/Next.Js, C# ASP.NetCore, PHP, Ecom (Shopify...) RestAPIs,Json and databases(SQL, MongoDB). Reach out at spino@spinosoftbits.com </p>
                <a class="cv-btn" href= "/images/SpinozaDelvaresume(Web).pdf" target="_blank" >C.vitae</a>

            </div>

            <div class="main-bg" style="z-index: 0;">
                <img src="./images/TSQPng.png" alt="model">
            </div>

            <!-----------Social--------------->

            <div class="social">
                <a href="https://www.linkedin.com/in/spinozadelva/" target="_blank"><i class="fa fa-linkedin"></i></a>
                <a href="https://github.com/spinoza008" target="_blank"><i class="fa fa-github"></i></a>
                <!--<a href="#"><i class="fa fa-youtube"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
-->
            </div>

                <!--arrow-->

                <div class="console-container">
                    <span id='text'></span>
                <div class="console-underscore" id="console">&#95;
                </div>
                </div>
                

            <div class="arrow"></div>
                
        </section>

    <!-------------------------------------contact--------------------------------->
        
        <section id="contact-btn">

            <h1> What do you want to build? </h1>
                <a class="btn btn-primary" href="#contact-form">Contact me</a>
                
            <p> <i class="fa fa-lightbulb-o" aria-hidden="true"></i> I can work with you... Describe me your business idea... Upgrade to a modern application or better.</p>
        
            <ul class="list-business">
                <li>Entepreneuship</li>
                <li>Start-Up</li>
                <li>Clothings</li>
                <li>Barber Shop</li>
            
            </ul>  
            <ul class="list-plans">
                <li>Products</li>
                <li>Sales</li>
                <li>Organizations</li>
                <li>Real-Estates</li>
            </ul>      

            <ul class="list-organization">
                <li>Photography</li>
                <li>Bloggers</li>
                <li>FB/Insta Personals</li>
                <li>Nails Tech</li>
            </ul>  
            <ul class="list-sm">
                <li>Coffee/Tea Shop</li>
                <li>Shoes Stores</li>
                <li>Hair Salons</li>
                <li>Restaurant/Food</li>
            </ul>   

            
        </section>

    <!---------------------------------------About---------------------------------->

        <section id="about">

            <div class="about-text">
                <h1>About Me</h1>
                <h2> Software, Web App, API's, Security</h2>
            <p>  I am proficient in building Static, Dynamic, Web Applications using C# ASP.NET Core for back-end, React/Next.js, Vanilla js and Jquery for the front end... 5 years+ building software and gaining experience  in the IT industry, I can implement techniques for Micro SAAS services, API services on an enterprise level, as well as newer WEB3.0 cloud services for start-ups and entrepreneurs. I can bring your E-commerce alive doesn't matter the platform you're using (Shopify, BigCommerce, Wix, Squarespace),  or simple static websites. 
            <br/>
            <br/>
           /* I am open to help you as well as keep on growing in the software industry.</p> */
                    <button href="#contact-form">More details </button>
            </div>
            <div class="about-model">
                <img src="./images/ProfessionalPic.JPG" alt="model">
            </div>
                
            <div class="cloth">
            <p><i class="fa fa-smile-o" aria-hidden="true"></i></i> Reap Cloth <i class="fa fa-smile-o" aria-hidden="true"></i></p>
            <canvas id="c"></canvas>

            <div id="top">
                <a id="close"></a>
            </div>
            <p></p>
            </div>
        </section>


        <div class="line-bar"></div> 
    <!-----------------------------------------services----------------------------------->

        <section id="services">
            <div class="s-heading">
                <h1>Services</h1>
                <p>Here some services I can provide you </p> 
            </div>

            <div class="s-b-container">
                <div class="s-box">
                    <div class="s-b-img">
                        <div class="s-type">Font-end</div>
                        <img src="./images/Front-end.png">
                    </div>
                    <div class="s-b-text">
                    <ul style="color: white;">
                        <li>React/Next.JS, JQuery, bootstrap  </li> 
                        <li>Dynamic, Static Or Mobile  </li>
                        <li>The perfect user experience</li>
                    </ul>   
                    </div>
                    </div>

                    <div class="s-box">
                        <div class="s-b-img">
                            <div class="s-type">Back-end</div>
                            <img src="./images/s2.png" alt="">
                        </div>
                        <div class="s-b-text">
                            <ul style="color: white;">
                                <li>C# with ASP.Net.Core</li> 
                                <li>Web Applications, Window forms</li>
                                <li>API's</li>
                            </ul>
                            <ul style="float:right;color: white;">
                                <li>SQL database</li>
                                <li>Entity Framework</li>
                                <li>Worked over 50TB storage</li>
                            </ul>
                        </div>
                    </div>

                    <div class="s-box">
                        <div class="s-b-img">
                            <div class="s-type">IT</div>
                            <img src="./images/s6.png" alt="">
                        </div>
                        <div class="s-b-text">
                        <ul style="color: white;">
                            <li>Servers, Network </li> 
                            <li>Scripts Linux,DHCP,LAN,WAN's,VOIP, TCP/IP,Active Directory</li> 
                        </div>
                    </div>
            </div>
                    
        </section>

    <!-------------------------------Contact ------------------------------->

        <section id="contact-form">
            <div class="container">
                <h1 class="blink">Get a quote!!</h1>
                <h6>For you inquiries and feedback, Please send me a message. </h6>
                <div id="error"><? echo $error .$successMessage; ?></div>

                <form method="post">
                    <div  class="contact-left">
                        <h2 class="c-l-heading"> <font style="border-bottom:3px solid #1eb98b; ">Writ</font>e ME </h2>

                        <div class="f-name">

                            <label for="subject">Name </label>
                            <input type="text" id="subject" name="subject" placeholder="Enter your name">

                        </div>
                        <div class="f-email">

                            <label for="email" style="color: #bfbfbf; font-size: 22px;">Email address</label>
                            <input type="email"  id="email" name="email" placeholder="Enter email">
                            <small class="text-muted"> I'll never share your email with anyone else.</small>

                        </div>
                    </div>

                    <div class="contact-right">
                        <div class="message">
                            <label for="content" style="color: #bfbfbf; font-size: 22px;">What would you like to ask me?</label>
                            <textarea  id="content" name="content" cols="20" rows="5"></textarea>
                        </div>
                    <button type="submit" id="submit" name="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </section>

            <!--footer starts from here-->
        <footer class="footer">
            <div class="container bottom_border">
            <div class="row">
            <div class=" col-sm-4 col-md col-sm-4  col-12 col">
            <h5 class="headin5_amrc col_white_amrc pt2">Reach out</h5>
            <!--headin5_amrc-->
            <p class="mb10"> Providing alternate availability to provide legal software, webpages, and products by helping your E-commerce, Enterprise, your Businesses, Servers, and your desires..  <br> Free software demo and projects look up<br> <br> <br>Recent IOS Iphone/Ipad, Android/Tablet viewport are available. <br> For better user experience use a computer desktop there are tons of cool features to use. </p>

            <ul class="b">
            <li>Send an e-mail about your inquiries <ul class="b">
                    <li>1-2 days reponse</li>
                <li>Inapropriate e-mails will be reported</li>
                </ul></li>
            <li>Clear project plan <ul class="b">
                    <li>Layout plan/Flowchart will be provided</li>
                </ul> </li>
            <li>Pricing are available after layout plan</li>
            </ul>

            <p><i class="fa fa-location-arrow"></i> New York, USA </p>
            <p><i class="fa fa-phone"></i>  No yet available  </p>
            <p><i class="fa fa fa-envelope"></i><a href="mailto:spinoza@spinosoftbits.com">spinoza@spinosoftbits.com</a>  </p>


            </div>


            <div class="col-sm-4 col-md  col-6 col">
            <h5 class="headin5_amrc col_white_amrc pt2"></h5>
            </br>

            <div class="btn btn-Support">
                                <small style="color:white;">Support this project</small> 
                                <br>
                            <button class="btn btn-primary" onclick=" window.open('https://paypal.me/spinozadelva','_blank')">
                                    <i class="fa fa-paypal"></i>
                                </button>   
                            <button class="btn btn-success"><a href="/images/Cashapp.jpeg" target="_blank"> <i class="fa fa-money"></i> </a> </button>
                                </button>    
                        </div>
            </div>

            <a class="neon" href="#">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    Evualtion at no cost
                </a>   
                <a class="neon" href="#">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                More updates coming soon
                </a> 

            <div id="f-links"class=" col-sm-4 col-md  col-12 col">


            <h5 class="headin5_amrc col_white_amrc pt2">Links</h5>
            <!--headin5_amrc ends here-->
                    

            <div class="container">
            <ul class="foote_bottom_ul_amrc">
            <li><a href="#main" class="active">Home</a></li>         
                            <li><a href="#about">About</a></li>

                            <li><a href="#services">Services</a></li>

            <li><a href="#contact-form">Contact</a></li>
            </ul>
            <!--foote_bottom_ul_amrc ends here-->
            <p class="text-center"> Copyright @2022 | Designed With by <a href="#">Spinoza Delva</a></p>

            <ul class="social_footer_ul">
            <li><a href="https://www.linkedin.com/in/spinozadelva/"><i class="fa fa-linkedin"></i></a></li>
            <li><a href="https://github.com/spinoza008"><i class="fa fa-github"></i></a></li>

            </ul>
            <!--social_footer_ul ends here-->
            </div>
            </div>

        </footer>
            <script type="text/javascript" src="index.js"></script>
            <script  type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script  type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
            <script  type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

            <!-- Crédit to https://bootsnipp.com/snippets/bxDBA -->
           
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
           
             
    </body>
</html>
