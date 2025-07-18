<footer class="mb-5">

    <div class="container">

        <footer class="d-flex flex-wrap justify-content-between align-items-center pt-3 mt-4 border-top">

            <p class="col-md-4 mb-0 text-body-secondary">

                © <?php echo date('Y')?> <?php echo $Config->app->credits->name ?>

            </p>

            <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">

                <img src="<?php echo $Config->app->credits->logo ?>" alt="<?php echo $Config->app->credits->name ?>" width="40px">

            </a>

            <ul class="nav col-md-4 justify-content-end">

                <li class="nav-item">

                    <a href="<?php echo $Config->app->credits->site ?>" class="nav-link px-2 text-body-secondary" target="_blank">

                        Site

                    </a>

                </li>

            </ul>

        </footer>

    </div>

</footer>