<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include($_SERVER['DOCUMENT_ROOT'].'/component/'.'h_links.html'); ?>
    <link rel="canonical" href="https://aiwallpaper.online/contact">
    <title>Contact us || AI Wallpapers</title>
    <style>
        .contact-form {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            height: auto;
        }
        .contact-form .cf-inside {
            width: 100%;
            max-width: 800px;
            height: auto;
            padding: 10px 0px 0px 0px;
            box-shadow: 0px 0px 5px 0px black;
            border-radius: 15px;
            overflow: hidden;
        }
        .contact-form .cf-inside form {
            width: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }
        .contact-form .cf-inside form input, .contact-form .cf-inside form textarea, .contact-form .cf-inside form button {
            margin: 10px 0px;
            transition: all 0.3s ease-in-out;
        }
        .contact-form .cf-inside form input, .contact-form .cf-inside form textarea {
            width: 100%;
            padding: 10px;
            background: var(--back-clr);
            font-size: 18px;
            border: none;
            outline: none;
            color: var(--s-text-clr);
            border-top: 1px solid lime;
            border-bottom: 1px solid lime;
        }
        .contact-form .cf-inside form input:focus, .contact-form .cf-inside form textarea:focus {
            border-color: var(--border);   
        }
        .contact-form .cf-inside form button {
            padding: 10px;
            background: lime;
            border: none;
            outline: none;
            font-weight: bold;
            font-size: 15px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="ai-container">
        <?php include($_SERVER['DOCUMENT_ROOT'].'/component/header.html'); ?>
        <main class="ai-main" id="main-content">
            <h1>Contact us</h1>
            <section class="text-container">
            <h2 class="highlight-heading">Contact US</h2>
<h3>If you want to report about any broken link, you also fill this form.</h2>
<p style="font-size: 18px;">Please contact us, If you have any query about <span class="highlight-text-y">Site, Content, Anything Else.</span> For contact us you have two ways.
<ol>
<li>
First you simply Email us on <a href="mailto:contact@aiwallpaper.online">Click Here to E-mail</a>
</li>
<li>
And Second you can fill the below form, Please <span class="highlight-text-y">use only valid E-mail</span> Otherwise we can't connect with you. After fill the form we connect with you as soon as possible.
</li>
</ol>
</p>
<div class="contact-form">
<div class="cf-inside">
<h3 class="highlight-heading">Contact Form</h3>
<form action="/join" enctype="multipart/form-data" role="form" aria-roledescription="contact form">
<input type="text" name="personName" placeholder="Enter your name" required>
<input type="email" name="personEmail" placeholder="Enter your email address" required>
<textarea name="personMessage" required cols="20" rows="10" placeholder="Enter your message"></textarea>
<h4 class="contactRes"></h4>
<button type="button" id="contactBtn" style="color : black;">Send</button>
</form>
</div>
</div>
 </section>
</main>
</div>
</div>
            </section>
        </main>
        <?php include($_SERVER['DOCUMENT_ROOT'].'/component/footer.html'); ?>
    </div>
    <script type="text/javascript">
        function xhfg(url, locreturn, flag = 'ac' ){
            var xhttp = new XMLHttpRequest();
            xhttp.onload = () => {
                if(flag == 'ov'){
                    locreturn.innerHTML = xhttp.responseText;  
                } else if(flag == 'ac'){
                    locreturn.innerHTML += xhttp.responseText;  
                }
                lazyloadImg();
            }
            xhttp.open('GET', url, true);
            xhttp.send();
        }
        document.querySelector('#contactBtn').addEventListener("click", function(e){
            e.preventDefault();
            xhfg(`/join?personName=${document.querySelector('input[name="personName"]').value}&personEmail=${document.querySelector('input[name="personEmail"]').value}&personMessage=${document.querySelector('textarea[name="personMessage"]').value}`, document.querySelector('.contactRes'), 'ov');
        })  
    </script>
</body>
</html>