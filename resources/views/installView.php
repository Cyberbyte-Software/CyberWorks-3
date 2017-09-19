<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>CyberWorks Installer</title>

        <!-- Bootstrap -->
        <link href="assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!-- NProgress -->
        <link href="assets/vendors/nprogress/nprogress.css" rel="stylesheet">
        <!-- Animate.css -->
        <link href="assets/vendors/animate.css/animate.min.css" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="assets/css/custom.css" rel="stylesheet">
    </head>

    <body class="login">
        <div>
            <div class="login_wrapper">
                <div class="animate form login_form" style="top: 15px;">
                    <section class="login_content">
                        <form action="installer.php" method="post" autocomplete="off">
                            <h1>Installation Form</h1>
                            <div class="separator">
                                <h1>Database Details</h1>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="HOST : 127.0.0.1" name="db_host" id="db_host" required="" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="PORT : DEFAULT = 3306" name="db_port" id="db_port" required="" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="DATABASE" name="db_db" id="db_db" required="" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="DATABASE USER" name="db_user" id="db_user" required="" />
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="DATABASE PASSWORD" name="db_password" id="db_password" required="" />
                                </div>
                        `   </div>

                            <div class="separator">
                                <h1>Email Settings</h1>
                                <p>
                                    In order for password resets to work you need to setup an email address for the password reset email to be sent from.<br/>
                                    I suggest you setup an email just for this purpose.<br/>
                                    If valid details are not provided then password resets will NOT work!
                                </p>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="HOST : smtp.gmail.com" name="email_host" id="email_host" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="PORT : 587" name="email_port" id="email_port" />
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="email_encryption" id="email_encryption">
                                        <option value="tls">TLS</option>
                                        <option value="ssl">SSL</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="USERNAME" name="email_user" id="email_user" />
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="PASSWORD" name="email_password" id="email_password" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="DOMAIN : cyberbyte.org.uk" name="email_domain" id="email_domain" />
                                </div>
                            </div>

                            <div class="separator">
                                <h1>Admin User</h1>
                                <p>
                                    Ensure you provide a valid email address otherwise you will not be able to reset your password should you ever lose it.
                                </p>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="username" name="admin_user" id="admin_user" required="" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="email" name="admin_email" id="admin_email" required="" />
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="password" name="admin_password" id="admin_password" required="" />
                                </div>
                            </div>

                            <div class="separator">
                                <h1>IPB Forum Details</h1>
                                <p>
                                    If you wish to use IPS Connect as your login provider, please fill this section out. Please ensure to have the trailing / on the base url
                                </p>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="IPB BASE URL: http://mydomain.local/" name="ipb_baseURL" id="ipb_baseURL" />
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="IPB MASTER KEY" name="ipb_masterKEY" id="ipb_masterKEY"/>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="IPB API KEY" name="ipb_apiKEY" id="ipb_apiKEY"/>
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-default submit">Submit</button>
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">
                                <div>
                                    <h1><i class="fa fa-database"></i> CyberWorks 3</h1>
                                    <p>&copy;2017 <a href="https://cyberbyte.org.uk">Cyberbyte Studios</a></p>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>