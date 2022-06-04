<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Bimbingan Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('vendor/minia') }}/assets/images/favicon.ico">

    <!-- DataTables -->
    <link href="{{ asset('vendor/minia') }}/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendor/minia') }}/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"
        rel="stylesheet" type="text/css" />

    <!-- Sweet Alert-->
    <link href="{{ asset('vendor/minia') }}/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('vendor/minia') }}/assets/css/fontawesome.v5.10.0.css" rel="stylesheet" type="text/css" />

    <!-- plugin css -->
    <link href="{{ asset('vendor/minia') }}/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css"
        rel="stylesheet" type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="{{ asset('vendor/minia') }}/assets/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('vendor/minia') }}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('vendor/minia') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('vendor/minia') }}/assets/css/app.min.css" id="app-style" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('vendor/minia') }}/assets/css/custom.css" id="app-style" rel="stylesheet" type="text/css" />
</head>

{{-- <style>
    @media (min-width:1000px) {
        body.sidebar-enable .vertical-menu {
            display: block
        }
    }

</style> --}}
<style>
    @media (max-width:1070px) {
        .vertical-menu {
            display: none
        }

        .main-content {
            margin-left: 0 !important
        }

        body.sidebar-enable .vertical-menu {
            display: block
        }
    }

    body[data-sidebar-size=sm] {
        min-height: 1000px
    }

    body[data-sidebar-size=sm] .main-content {
        margin-left: 70px
    }

    body[data-sidebar-size=sm] .navbar-brand-box {
        width: 70px !important
    }

    body[data-sidebar-size=sm] .logo span.logo-lg {
        display: none
    }

    body[data-sidebar-size=sm] .logo span.logo-sm {
        display: block
    }

    body[data-sidebar-size=sm] .vertical-menu {
        position: absolute;
        width: 70px !important;
        z-index: 5
    }

    body[data-sidebar-size=sm] .vertical-menu .simplebar-content-wrapper,
    body[data-sidebar-size=sm] .vertical-menu .simplebar-mask {
        overflow: visible !important
    }

    body[data-sidebar-size=sm] .vertical-menu .simplebar-scrollbar {
        display: none !important
    }

    body[data-sidebar-size=sm] .vertical-menu .simplebar-offset {
        bottom: 0 !important
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu .badge,
    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu .menu-title,
    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu .sidebar-alert {
        display: none !important
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu .nav.collapse {
        height: inherit !important
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li {
        position: relative;
        white-space: nowrap
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li>a {
        padding: 15px 20px;
        -webkit-transition: none;
        transition: none
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li>a:active,
    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li>a:focus,
    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li>a:hover {
        color: #5156be
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li>a i {
        font-size: 1.45rem;
        margin-left: 4px
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li>a svg {
        height: 18px;
        width: 18px;
        margin-left: 6px
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li>a span {
        display: none;
        padding-left: 25px
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li>a.has-arrow:after {
        display: none
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li:hover>a {
        position: relative;
        width: calc(190px + 70px);
        color: #5156be;
        background-color: #ebe6ff;
        -webkit-transition: none;
        transition: none
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li:hover>a i {
        color: #5156be
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li:hover>a svg {
        color: #5156be;
        fill: rgba(81, 86, 190, .2)
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li:hover>a span {
        display: inline
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li:hover>ul {
        display: block;
        left: 70px;
        position: absolute;
        width: 190px;
        height: auto !important;
        -webkit-box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .1);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .1)
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li:hover>ul ul {
        -webkit-box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .1);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .1)
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li:hover>ul a {
        -webkit-box-shadow: none;
        box-shadow: none;
        padding: 8px 20px;
        position: relative;
        width: 190px;
        z-index: 6;
        color: #545a6d
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li:hover>ul a:hover {
        color: #5156be
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul ul {
        padding: 5px 0;
        z-index: 9999;
        display: none;
        background-color: #fff
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul ul li:hover>ul {
        display: block;
        left: 190px;
        height: auto !important;
        margin-top: -36px;
        position: absolute;
        width: 190px;
        padding: 5px 0
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul ul li>a span.pull-right {
        position: absolute;
        right: 20px;
        top: 12px;
        -webkit-transform: rotate(270deg);
        transform: rotate(270deg)
    }

    body[data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul ul li.active a {
        color: #f8f9fa
    }

    body[data-sidebar-size=sm] #sidebar-menu .mm-active>.has-arrow:after {
        -webkit-transform: rotate(0);
        transform: rotate(0)
    }

    body[data-sidebar=dark] .navbar-brand-box {
        background: #2c302e;
        -webkit-box-shadow: 0 3px 1px #2c302e;
        box-shadow: 0 3px 1px #2c302e;
        border-color: #2c302e
    }

    body[data-sidebar=dark] .navbar-brand-box .logo {
        color: #fff !important
    }

    body[data-sidebar=dark] .logo-dark {
        display: none
    }

    body[data-sidebar=dark] .logo-light {
        display: block
    }

    body[data-sidebar=dark] .vertical-menu {
        background: #2c302e;
        border-color: #2c302e
    }

    @media (min-width:992px) {
        body[data-sidebar=dark] #vertical-menu-btn {
            color: #e9ecef
        }
    }

    body[data-sidebar=dark] #sidebar-menu ul li a {
        color: #99a4b1
    }

    body[data-sidebar=dark] #sidebar-menu ul li a i {
        color: #858d98
    }

    body[data-sidebar=dark] #sidebar-menu ul li a svg {
        color: #858d98;
        fill: rgba(133, 141, 152, .2)
    }

    body[data-sidebar=dark] #sidebar-menu ul li a:hover {
        color: #fff
    }

    body[data-sidebar=dark] #sidebar-menu ul li a:hover i {
        color: #fff
    }

    body[data-sidebar=dark] #sidebar-menu ul li a:hover svg {
        color: #fff;
        fill: rgba(255, 255, 255, .2)
    }

    body[data-sidebar=dark] #sidebar-menu ul li ul.sub-menu li a {
        color: #858d98
    }

    body[data-sidebar=dark] #sidebar-menu ul li ul.sub-menu li a:hover {
        color: #fff
    }

    body[data-sidebar=dark][data-sidebar-size=sm][data-topbar=dark] #vertical-menu-btn {
        color: #e9ecef
    }

    body[data-sidebar=dark][data-sidebar-size=sm] #vertical-menu-btn {
        color: #555b6d
    }

    body[data-sidebar=dark][data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li:hover>a {
        background: #313533;
        color: #fff
    }

    body[data-sidebar=dark][data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li:hover>a i {
        color: #fff
    }

    body[data-sidebar=dark][data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li:hover>a svg {
        color: #fff;
        fill: rgba(255, 255, 255, .2)
    }

    body[data-sidebar=dark][data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li:hover>ul a {
        color: #858d98
    }

    body[data-sidebar=dark][data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li:hover>ul a:hover {
        color: #fff
    }

    body[data-sidebar=dark][data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul ul {
        background-color: #2c302e
    }

    body[data-sidebar=dark][data-sidebar-size=sm] .vertical-menu #sidebar-menu ul li.mm-active .active {
        color: #fff !important
    }

    body[data-sidebar=dark][data-sidebar-size=sm] .vertical-menu #sidebar-menu ul li.mm-active .active i {
        color: #fff !important
    }

    body[data-sidebar=dark] .mm-active {
        color: #fff !important
    }

    body[data-sidebar=dark] .mm-active>a {
        color: #fff !important
    }

    body[data-sidebar=dark] .mm-active>a i {
        color: #fff !important
    }

    body[data-sidebar=dark] .mm-active>a svg {
        color: #fff !important;
        fill: rgba(255, 255, 255, .2) !important
    }

    body[data-sidebar=dark] .mm-active>i {
        color: #fff !important
    }

    body[data-sidebar=dark] .mm-active .active {
        color: #fff !important
    }

    body[data-sidebar=dark] .mm-active .active i {
        color: #fff !important
    }

    body[data-sidebar=dark] .mm-active .active svg {
        color: #fff !important;
        fill: rgba(255, 255, 255, .2) !important
    }

    body[data-sidebar=dark] .menu-title {
        color: #858d98
    }

    body[data-sidebar=dark][data-sidebar-size=md] #sidebar-menu ul li.menu-title {
        background-color: #313533
    }

    body[data-layout=horizontal] .main-content {
        margin-left: 0 !important
    }

    body[data-sidebar-size=md] .navbar-brand-box {
        width: 160px
    }

    @media (max-width:991.98px) {
        body[data-sidebar-size=md] .navbar-brand-box {
            width: auto
        }
    }

    body[data-sidebar-size=md] .vertical-menu {
        width: 160px;
        text-align: center
    }

    body[data-sidebar-size=md] .vertical-menu .badge,
    body[data-sidebar-size=md] .vertical-menu .has-arrow:after,
    body[data-sidebar-size=md] .vertical-menu .sidebar-alert {
        display: none !important
    }

    body[data-sidebar-size=md] .main-content {
        margin-left: 160px
    }

    body[data-sidebar-size=md] .footer {
        left: 160px
    }

    @media (max-width:991.98px) {
        body[data-sidebar-size=md] .footer {
            left: 0
        }
    }

    body[data-sidebar-size=md] #sidebar-menu ul li a svg {
        display: block;
        margin: 0 auto 4px
    }

    body[data-sidebar-size=md] #sidebar-menu ul li ul.sub-menu li a {
        padding-left: 1.5rem
    }

    body[data-sidebar-size=md] #sidebar-menu ul li ul.sub-menu li ul.sub-menu li a {
        padding-left: 1.5rem
    }

    body[data-sidebar-size=md][data-sidebar-size=sm] .main-content {
        margin-left: 70px
    }

    body[data-sidebar-size=md][data-sidebar-size=sm] .vertical-menu #sidebar-menu {
        text-align: left
    }

    body[data-sidebar-size=md][data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li>a svg {
        display: inline-block
    }

    body[data-sidebar-size=md][data-sidebar-size=sm] .footer {
        left: 70px
    }

    body[data-sidebar=brand] .vertical-menu {
        background-color: #5156be
    }

    body[data-sidebar=brand] .navbar-brand-box {
        background-color: #5156be;
        -webkit-box-shadow: 0 1px 0 #5156be;
        box-shadow: 0 1px 0 #5156be
    }

    body[data-sidebar=brand] .navbar-brand-box .logo-dark {
        display: none
    }

    body[data-sidebar=brand] .navbar-brand-box .logo-light {
        display: block
    }

    body[data-sidebar=brand] .navbar-brand-box .logo {
        color: #fff !important
    }

    body[data-sidebar=brand] .mm-active {
        color: #fff !important
    }

    body[data-sidebar=brand] .mm-active>a {
        color: #fff !important
    }

    body[data-sidebar=brand] .mm-active>a i {
        color: #fff !important
    }

    body[data-sidebar=brand] .mm-active>a svg {
        color: #fff !important;
        fill: rgba(255, 255, 255, .1) !important
    }

    body[data-sidebar=brand] .mm-active .active {
        color: #fff !important
    }

    body[data-sidebar=brand] .mm-active .active svg {
        color: #fff !important;
        fill: rgba(255, 255, 255, .1) !important
    }

    @media (min-width:992px) {
        body[data-sidebar=brand] #vertical-menu-btn {
            color: #e9ecef
        }
    }

    body[data-sidebar=brand] #sidebar-menu ul li.menu-title {
        color: rgba(255, 255, 255, .6)
    }

    body[data-sidebar=brand] #sidebar-menu ul li a {
        color: rgba(255, 255, 255, .6)
    }

    body[data-sidebar=brand] #sidebar-menu ul li a i {
        color: rgba(255, 255, 255, .6)
    }

    body[data-sidebar=brand] #sidebar-menu ul li a svg {
        color: rgba(255, 255, 255, .6);
        fill: rgba(255, 255, 255, .075)
    }

    body[data-sidebar=brand] #sidebar-menu ul li a.waves-effect .waves-ripple {
        background: rgba(255, 255, 255, .1)
    }

    body[data-sidebar=brand] #sidebar-menu ul li a:hover {
        color: #fff
    }

    body[data-sidebar=brand] #sidebar-menu ul li a:hover i {
        color: #fff
    }

    body[data-sidebar=brand] #sidebar-menu ul li ul.sub-menu li a {
        color: rgba(255, 255, 255, .5)
    }

    body[data-sidebar=brand] #sidebar-menu ul li ul.sub-menu li a:hover {
        color: #fff
    }

    body[data-sidebar=brand] .sidebar-alert {
        background-color: rgba(255, 255, 255, .1);
        color: rgba(255, 255, 255, .5)
    }

    body[data-sidebar=brand] .sidebar-alert .alertcard-title {
        color: #fff
    }

    body[data-sidebar=brand][data-sidebar-size=sm][data-topbar=dark] #vertical-menu-btn {
        color: #e9ecef
    }

    body[data-sidebar=brand][data-sidebar-size=sm] #vertical-menu-btn {
        color: #555b6d
    }

    body[data-sidebar=brand][data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li:hover>a {
        background-color: #585dc1;
        color: #fff
    }

    body[data-sidebar=brand][data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li:hover>a i,
    body[data-sidebar=brand][data-sidebar-size=sm] .vertical-menu #sidebar-menu>ul>li:hover>a svg {
        color: #fff
    }

    body[data-sidebar=brand][data-sidebar-size=sm] .vertical-menu #sidebar-menu ul li.mm-active .active {
        color: #fff !important
    }

    body[data-sidebar=brand][data-sidebar-size=sm] .vertical-menu #sidebar-menu ul li ul.sub-menu li a:hover {
        color: #5156be
    }

    body[data-sidebar=brand][data-sidebar-size=sm] .vertical-menu #sidebar-menu ul li ul.sub-menu li.mm-active {
        color: #5156be !important
    }

    body[data-sidebar=brand][data-sidebar-size=sm] .vertical-menu #sidebar-menu ul li ul.sub-menu li.mm-active>a {
        color: #5156be !important
    }

    body[data-layout-mode=dark][data-sidebar=brand] .navbar-brand-box,
    body[data-layout-mode=dark][data-sidebar=brand] .vertical-menu,
    body[data-layout-mode=dark][data-sidebar=dark] .navbar-brand-box,
    body[data-layout-mode=dark][data-sidebar=dark] .vertical-menu {
        border-color: #373c39
    }

    body[data-layout-mode=dark][data-sidebar=light] .sidebar-alert {
        background-color: rgba(81, 86, 190, .1);
        color: #495057
    }

    body[data-layout-mode=dark][data-sidebar=light] .sidebar-alert .alertcard-title {
        color: #5156be
    }

    [dir=rtl] #sidebar-menu .has-arrow:after {
        content: "\F0141"
    }

    .topnav {
        background: #fff;
        padding: 0 calc(20px / 2);
        margin-top: 70px;
        position: fixed;
        left: 0;
        right: 0;
        z-index: 100;
        border-bottom: 1px solid #e9e9ef
    }

    @media (min-width:992px) {
        .topnav {
            background: #fbfaff
        }
    }

    .topnav .topnav-menu {
        margin: 0;
        padding: 0
    }

    .topnav .navbar-nav .nav-link {
        font-size: 14.4px;
        position: relative;
        padding: 1rem 1.3rem;
        color: #545a6d;
        font-weight: 500
    }

    .topnav .navbar-nav .nav-link i {
        font-size: 15px
    }

    .topnav .navbar-nav .nav-link svg {
        height: 16px;
        width: 16px;
        color: #545a6d;
        fill: rgba(84, 90, 109, .2);
        margin-right: 7px;
        margin-top: -3px
    }

    .topnav .navbar-nav .nav-link:focus,
    .topnav .navbar-nav .nav-link:hover {
        color: #5156be;
        background-color: transparent
    }

    .topnav .navbar-nav .nav-link:focus svg,
    .topnav .navbar-nav .nav-link:hover svg {
        color: #5156be;
        fill: rgba(81, 86, 190, .2)
    }

    .topnav .navbar-nav .dropdown-item {
        color: #545a6d
    }

    .topnav .navbar-nav .dropdown-item.active,
    .topnav .navbar-nav .dropdown-item:hover {
        color: #5156be
    }

    .topnav .navbar-nav .nav-item .nav-link.active {
        color: #5156be
    }

    .topnav .navbar-nav .nav-item .nav-link.active svg {
        color: #5156be;
        fill: rgba(81, 86, 190, .2)
    }

    .topnav .navbar-nav .dropdown.active>a {
        color: #5156be;
        background-color: transparent
    }

    .topnav .navbar-nav .dropdown.active>a svg {
        color: #5156be;
        fill: rgba(81, 86, 190, .2)
    }

    .topnav .menu-title {
        padding: 12px 24px !important
    }

    @media (max-width:991.98px) {
        .topnav .menu-title {
            padding: 12px 16px !important
        }
    }

    @media (min-width:1200px) {

        body[data-layout=horizontal] .container-fluid,
        body[data-layout=horizontal] .navbar-header {
            max-width: 85%
        }
    }

    @media (min-width:992px) {
        .topnav .navbar-nav .nav-item:first-of-type .nav-link {
            padding-left: 0
        }

        .topnav .dropdown-item {
            padding: .5rem 1.5rem;
            min-width: 180px
        }

        .topnav .dropdown.mega-dropdown .mega-dropdown-menu {
            left: 0;
            right: auto
        }

        .topnav .dropdown .dropdown-menu {
            margin-top: 0;
            border-radius: 0 0 .25rem .25rem
        }

        .topnav .dropdown .dropdown-menu .arrow-down::after {
            right: 15px;
            -webkit-transform: rotate(-135deg) translateY(-50%);
            transform: rotate(-135deg) translateY(-50%);
            position: absolute
        }

        .topnav .dropdown .dropdown-menu .dropdown .dropdown-menu {
            position: absolute;
            top: 0 !important;
            left: 100%;
            display: none
        }

        .topnav .dropdown:hover>.dropdown-menu {
            display: block
        }

        .topnav .dropdown:hover>.dropdown-menu>.dropdown:hover>.dropdown-menu {
            display: block
        }

        .navbar-toggle {
            display: none
        }
    }

    .arrow-down {
        display: inline-block
    }

    .arrow-down:after {
        border-color: initial;
        border-style: solid;
        border-width: 0 0 1px 1px;
        content: "";
        height: .4em;
        display: inline-block;
        right: 5px;
        top: 50%;
        margin-left: 10px;
        -webkit-transform: rotate(-45deg) translateY(-50%);
        transform: rotate(-45deg) translateY(-50%);
        -webkit-transform-origin: top;
        transform-origin: top;
        -webkit-transition: all .3s ease-out;
        transition: all .3s ease-out;
        width: .4em
    }

    @media (max-width:1199.98px) {
        .topnav-menu .navbar-nav li:last-of-type .dropdown .dropdown-menu {
            right: 100%;
            left: auto
        }
    }

    @media (max-width:991.98px) {
        .navbar-brand-box .logo-dark {
            display: block
        }

        .navbar-brand-box .logo-dark span.logo-sm {
            display: block
        }

        .navbar-brand-box .logo-light {
            display: none
        }

        .topnav {
            max-height: 360px;
            overflow-y: auto;
            padding: 0
        }

        .topnav .navbar-nav .nav-link {
            padding: .75rem 1.1rem
        }

        .topnav .dropdown .dropdown-menu {
            background-color: transparent;
            border: none;
            -webkit-box-shadow: none;
            box-shadow: none;
            padding-left: 24px
        }

        .topnav .dropdown .dropdown-menu.dropdown-mega-menu-xl {
            width: auto
        }

        .topnav .dropdown .dropdown-menu.dropdown-mega-menu-xl .row {
            margin: 0
        }

        .topnav .dropdown .dropdown-item {
            position: relative;
            background-color: transparent
        }

        .topnav .dropdown .dropdown-item.active,
        .topnav .dropdown .dropdown-item:active {
            color: #5156be
        }

        .topnav .arrow-down::after {
            right: 15px;
            position: absolute
        }
    }

    body[data-layout=horizontal][data-topbar=colored] #page-topbar {
        background-color: #5156be;
        -webkit-box-shadow: none;
        box-shadow: none
    }

    body[data-layout=horizontal][data-topbar=colored] .logo-dark {
        display: none
    }

    body[data-layout=horizontal][data-topbar=colored] .logo-light {
        display: block
    }

    body[data-layout=horizontal][data-topbar=colored] .app-search .form-control {
        background-color: rgba(243, 243, 249, .07);
        color: #fff
    }

    body[data-layout=horizontal][data-topbar=colored] .app-search input.form-control::-webkit-input-placeholder,
    body[data-layout=horizontal][data-topbar=colored] .app-search span {
        color: rgba(255, 255, 255, .5)
    }

    body[data-layout=horizontal][data-topbar=colored] .header-item {
        color: #e9ecef
    }

    body[data-layout=horizontal][data-topbar=colored] .header-item:hover {
        color: #e9ecef
    }

    body[data-layout=horizontal][data-topbar=colored] .navbar-header .dropdown .show.header-item {
        background-color: rgba(255, 255, 255, .1)
    }

    body[data-layout=horizontal][data-topbar=colored] .navbar-header .waves-effect .waves-ripple {
        background: rgba(255, 255, 255, .4)
    }

    body[data-layout=horizontal][data-topbar=colored] .noti-icon i {
        color: #e9ecef
    }

    @media (min-width:992px) {
        body[data-layout=horizontal][data-topbar=colored] .topnav {
            background-color: #5156be
        }

        body[data-layout=horizontal][data-topbar=colored] .topnav .navbar-nav .nav-link {
            color: rgba(255, 255, 255, .6)
        }

        body[data-layout=horizontal][data-topbar=colored] .topnav .navbar-nav .nav-link:focus,
        body[data-layout=horizontal][data-topbar=colored] .topnav .navbar-nav .nav-link:hover {
            color: rgba(255, 255, 255, .9)
        }

        body[data-layout=horizontal][data-topbar=colored] .topnav .navbar-nav>.dropdown.active>a {
            color: rgba(255, 255, 255, .9) !important
        }
    }

    body[data-layout-mode=dark] .topnav {
        background-color: #363a38;
        border-color: #3b403d
    }

    body[data-layout-mode=dark] .topnav .navbar-nav .nav-link {
        color: #99a4b1
    }

    body[data-layout-mode=dark] .topnav .navbar-nav .nav-link svg {
        height: 16px;
        width: 16px;
        color: #99a4b1;
        fill: rgba(153, 164, 177, .2);
        margin-right: 7px;
        margin-top: -3px
    }

    body[data-layout-mode=dark] .topnav .navbar-nav .nav-link:focus,
    body[data-layout-mode=dark] .topnav .navbar-nav .nav-link:hover {
        color: #fff;
        background-color: transparent
    }

    body[data-layout-mode=dark] .topnav .navbar-nav .nav-link:focus svg,
    body[data-layout-mode=dark] .topnav .navbar-nav .nav-link:hover svg {
        color: #fff;
        fill: rgba(255, 255, 255, .2)
    }

    body[data-layout-mode=dark] .topnav .navbar-nav .dropdown-item {
        color: #99a4b1
    }

    body[data-layout-mode=dark] .topnav .navbar-nav .dropdown-item.active,
    body[data-layout-mode=dark] .topnav .navbar-nav .dropdown-item:hover {
        color: #fff
    }

    body[data-layout-mode=dark] .topnav .navbar-nav .nav-item .nav-link.active {
        color: #fff
    }

    body[data-layout-mode=dark] .topnav .navbar-nav .dropdown.active>a {
        color: #fff;
        background-color: transparent
    }

    body[data-layout-mode=dark] .topnav .navbar-nav .dropdown.active>a svg {
        color: #fff;
        fill: rgba(255, 255, 255, .2)
    }

    body[data-layout-mode=dark] .topnav .menu-title {
        color: rgba(153, 164, 177, .6)
    }

    body[data-layout-size=boxed] {
        background-color: #f0f0f0
    }

    body[data-layout-size=boxed] #layout-wrapper {
        background-color: #fff;
        max-width: 1300px;
        margin: 0 auto;
        -webkit-box-shadow: 0 .25rem .75rem rgba(18, 38, 63, .08);
        box-shadow: 0 .25rem .75rem rgba(18, 38, 63, .08);
        min-height: 100vh
    }

    body[data-layout-size=boxed] #page-topbar {
        max-width: 1300px;
        margin: 0 auto
    }

    body[data-layout-size=boxed] .footer {
        margin: 0 auto;
        max-width: calc(1300px - 250px)
    }

    @media (min-width:992px) {
        body[data-layout-size=boxed][data-sidebar-size=sm] #layout-wrapper {
            min-height: 1200px
        }
    }

    body[data-layout-size=boxed][data-sidebar-size=sm] .footer {
        max-width: calc(1300px - 70px)
    }

    body[data-layout-size=boxed][data-sidebar-size=md] .footer {
        max-width: calc(1300px - 160px)
    }

    body[data-layout=horizontal][data-layout-size=boxed] #layout-wrapper,
    body[data-layout=horizontal][data-layout-size=boxed] #page-topbar,
    body[data-layout=horizontal][data-layout-size=boxed] .footer {
        max-width: 100%
    }

    body[data-layout=horizontal][data-layout-size=boxed] .container-fluid,
    body[data-layout=horizontal][data-layout-size=boxed] .navbar-header {
        max-width: 1300px
    }

    @media (min-width:992px) {

        body[data-layout-scrollable=true] #page-topbar,
        body[data-layout-scrollable=true] .vertical-menu {
            position: absolute
        }
    }

    @media (min-width:992px) {

        body[data-layout-scrollable=true][data-layout=horizontal] #page-topbar,
        body[data-layout-scrollable=true][data-layout=horizontal] .topnav {
            position: absolute
        }
    }

    body[data-layout-mode=dark][data-layout-size=boxed] {
        background-color: #3b403d
    }

    body[data-layout-mode=dark][data-layout-size=boxed] #layout-wrapper {
        background-color: #313533
    }

</style>

<body data-sidebar-size="lg">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- Topbar -->
        @include('layouts.minia.topbar')
        <!-- END Topbar -->

        <!-- Sidebar -->
        @include('layouts.minia.sidebar')
        <!-- END Sidebar -->

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <!-- ========== Page-content Start ========== -->
            <div class="page-content">
                <!-- Content -->
                @yield('content')
                <!-- End Content -->
            </div>
            <!-- Page-content End -->

            <!-- Footer -->
            @include('layouts.minia.footer')
            <!-- END Footer -->

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Rightbar -->
    @include('layouts.minia.rightbar')
    <!-- END Rightbar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/jquery/jquery.min.js"></script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/node-waves/waves.min.js"></script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/feather-icons/feather.min.js"></script>
    <!-- pace js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/pace-js/pace.min.js"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- Required datatable js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

    <!-- Buttons examples -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('vendor/minia') }}/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js">
    </script>

    <!-- Datatable init js -->
    <script src="{{ asset('vendor/minia') }}/assets/js/pages/datatables.init.js"></script>

    <!-- Plugins js-->
    <script
        src="{{ asset('vendor/minia') }}/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js">
    </script>
    <script
        src="{{ asset('vendor/minia') }}/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js">
    </script>

    <script src="{{ asset('vendor/minia') }}/assets/js/app.js"></script>

    @yield('js')

    <script>
        function loaderNotif() {
            $('#countNotif').load("{{ route('topbar-notif.informasi') }}");
            $('#countNotifPengumuman').load("{{ route('topbar-notif.pengumuman') }}");
            $('#countNotifPeringatan').load("{{ route('topbar-notif.peringatan') }}");
        }

        $(document).ready(function() {
            document.body.setAttribute('data-sidebar-size', 'lg');

            loaderNotif();

            $("#btnReadAll").click(function() {
                $.ajax({
                    url: "{{ route('topbar-notif.readAll') }}"
                }).done(function() {
                    loaderNotif();
                });
            });
        });
    </script>

</body>

</html>
