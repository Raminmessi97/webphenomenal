<!DOCTYPE html>
<html>
    <head>
        {% block head %}
            <link rel="stylesheet" href="resources/css/main.css" />
            <title>{% block title %}{% endblock %} - My Webpage</title>
        {% endblock %}
    </head>
    <body>

        <!-- header -->

        <header class="main_header">
            <div class="logo-of-site">
               <img src="./resources/images/site-icon.png" alt="site-icon" class="icon-site-img"/>
            </div>

            <div class="menu">
                <ul>
                     {% for category in categories %}
                        <li><a href="{{category.route_name}}">{{ category.name|e }}</a></li>
                    {% endfor %}
                </ul>
            </div>

            <div class="search-login">
                <a href="register">Login</a>
                <a href="register">Register</a>
            </div>
        </header>
    
    <!-- end header -->

    <main class="content">
        <article class="all-articles">
              {% block content%}

              {% endblock %}
        </article>
       
        <aside class="right_side">
                <div class="best-articles">
                <h2>Популярное</h2>  
                <ul>
                    <li>1 Статья</li>
                    <li>2 Статья</li>
                    <li>3 Статья</li>

                </ul>
                </div>

                 <div class="best-articles">
                <h2>Популярное</h2>  
                <ul>
                    <li>1 Статья</li>
                    <li>2 Статья</li>
                    <li>3 Статья</li>
                </ul>
                </div>

                 <div class="best-articles">
                <h2>Реклама</h2>  
                <ul>
                    <li>1 Статья</li>
                    <li>2 Статья</li>
                    <li>3 Статья</li>
                </ul>
                </div>
            </aside>
    </main>


       <footer>
            <div class="footer-social-icons">
                <i class="fa fa-youtube social_icons"></i>
                <i class="fa fa-facebook social_icons"></i>
                <i class="fa fa-twitter social_icons"></i>
                <i class="fa fa-github social_icons"></i>
            </div>

            <div class="footer-rules">
                <li><a href="#">Условия использования</a></li>
                <li><a href="#">Конфиденциальность</a></li>
                <li><a href="#">О сайте</a></li>
            </div>

            <div class="contacts-info">
                <p>Ramin LM , 2019-2020</p>
                <p>Email:ramin.hes.97@gmail.com</p>
            </div>
        </footer>
    </body>

    <script src="./resources/bundle.js"></script>
</html>

