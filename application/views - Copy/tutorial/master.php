<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ventura SOP</title>
    <link rel="icon" href="store/img/favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url(); ?>tutorial/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>tutorial/store/css/icofont.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>tutorial/store/css/uikit.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>tutorial/store/css/jquery-ui.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>tutorial/store/css/jquery.scrollbar.css">
    <!-- <link rel="stylesheet" href="store/css/prism.css"> -->

</head>
<body>
    <nav class="navigation-bar">
        <div class="left-item">
            <a href="#" class="brand-logo">VLMBD</a>
            <a href="#" class="menuCollapse"><i uk-icon="icon:menu"></i></a>
        </div>
       <!--  <ul class="uk-list right-item">
            <li class="uk-margin-remove"><a href="pages/Changelog.html">Changelog</a></li>
            <li class="uk-margin-remove"><a href="pages/support.html">Support</a></li>
        </ul> -->
    </nav>
    <main class="main-container">
        <div class="uk-container-expand content">
            <!-- sidebar start -->
            <div class="primary-nav-menu">
                <form action="" class="uk-margin-small-top uk-width-expand uk-search uk-search-default">
                    <div class="ui search showResult">
                        <div class="ui input uk-width-expand">
                            <label for="search-content" uk-search-icon></label>
                            <input class="prompt uk-search-input" id="search-content" type="text" placeholder="Type SOP">
                        </div>
                    </div>
                </form>
                <ul class="sidebar uk-nav-default uk-nav-parent-icon scrollbar-macosx" uk-nav>
                    <li>
                        <a href="<?php echo base_url(); ?>tutorial/helpdesk"><span uk-icon="icon: home"></span>What is SOP</a>
                    </li>
                    <?php foreach ($mlist as  $value) {  ?>
                    <li>
                        <a href="<?php echo base_url(); ?>tutorial/helpdesk/<?php echo $value->id; ?>">
                        <span uk-icon="icon:database"></span> <?php echo $value->menu; ?></a>
                    </li>
                     <?php } ?>
                </ul>

            </div>
            <!-- sidebar end -->
            
            <?php echo  $this->load->view($display); ?>
        </div>
    </main>
    <script src="<?php echo base_url(); ?>tutorial/store/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>tutorial/store/js/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>tutorial/store/js/jquery.scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>tutorial/store/js/uikit.min.js"></script>
    <script src="<?php echo base_url(); ?>tutorial/store/js/uikit-icons.min.js"></script>
    <script src="<?php echo base_url(); ?>tutorial/main.js"></script>
</body>
</html>