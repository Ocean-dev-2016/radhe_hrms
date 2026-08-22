<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
  href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap"
  rel="stylesheet" />

<link rel="stylesheet" href="assets/vendor/fonts/tabler-icons.css" />
<!-- <link rel="stylesheet" href="assets/vendor/fonts/fontawesome.css" /> -->
<!-- <link rel="stylesheet" href="assets/vendor/fonts/flag-icons.css" /> -->

<!-- Core CSS -->
<link rel="stylesheet" href="assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="assets/css/demo.css" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="assets/vendor/libs/node-waves/node-waves.css" />
<link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

<!-- Page CSS -->

<!-- Helpers -->
<script src="assets/vendor/js/helpers.js"></script>
<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
<!-- <script src="assets/vendor/js/template-customizer.js"></script> -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="assets/js/config.js"></script>

<style>
  /* Global Page Background Image */
  body {
    background-image: url('bg.png') !important;
    background-size: cover !important;
    background-position: center !important;
    background-repeat: no-repeat !important;
    background-attachment: fixed !important;
  }

  /* Make sure all draggable cards hover ON TOP of menus and status bars */
  #draggableCard,
  #branchCard,
  #employerCard,
  #searchCard {
    z-index: 1100 !important;
  }

  .layout-wrapper,
  .layout-container,
  .content-wrapper {
    background: transparent !important;
  }

  /* Layout Navbar overrides */
  .layout-navbar {
    height: 28px !important;
    min-height: 28px !important;
    padding-top: 0px !important;
    padding-bottom: 0px !important;
    background: linear-gradient(90deg, #135ca3 0%, #00a2e8 100%) !important;
    border-bottom: none !important;
  }

  .layout-navbar-full .layout-page {
    padding-top: 0px !important;
  }

  .app-brand {
    height: 28px !important;
    min-height: 28px !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
  }

  /* App Brand Logo / Text Styles */
  .app-brand-link {
    display: flex !important;
    align-items: center !important;
    gap: 6px !important;
    height: 28px !important;
  }

  .app-brand-logo.demo img {
    height: 16px !important;
    width: auto !important;
  }

  .app-brand-text {
    font-size: 14px !important;
    font-weight: 600 !important;
    text-transform: none !important;
    white-space: nowrap !important;
    line-height: 1 !important;
    display: flex !important;
    align-items: center !important;
    color: #fff !important;
  }

  /* Custom Menu Button Styles (Applies to all screens) */
  #layout-menu .menu-item .menu-link {
    background-color: #f8f7fa !important;
    border: 1px solid #dbdade !important;
    border-radius: 6px !important;
    color: #5d596c !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    transition: all 0.2s ease-in-out !important;
    height: auto !important;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
  }

  /* Hover and Active State for Menu Buttons */
  #layout-menu .menu-item.active .menu-link,
  #layout-menu .menu-item .menu-link:hover {
    background: linear-gradient(135deg, #135ca3 0%, #00a2e8 100%) !important;
    border-color: transparent !important;
    color: #fff !important;
    box-shadow: 0 2px 6px rgba(19, 92, 163, 0.3) !important;
  }

  /* Underline for active, open or hovered main menu links */
  #layout-menu .menu-inner > .menu-item.active > .menu-link,
  #layout-menu .menu-inner > .menu-item.open > .menu-link,
  #layout-menu .menu-inner > .menu-item > .menu-link:hover {
    text-decoration: underline !important;
    text-underline-offset: 4px !important;
    text-decoration-thickness: 2px !important;
  }

  #layout-menu .menu-item .menu-icon {
    font-size: 1.1rem !important;
    margin-right: 0.4rem !important;
  }

  /* Horizontal Layout overrides (Desktop/Laptop - >= 1200px) */
  @media (min-width: 1200px) {
    #layout-menu.menu-horizontal {
      height: auto !important;
      min-height: auto !important;
      top: 28px !important;
      z-index: 1200 !important;
    }

    #layout-menu.menu-horizontal .container-fluid {
      height: auto !important;
    }

    #layout-menu .menu-inner {
      display: flex !important;
      width: 100% !important;
      justify-content: space-between !important;
      padding: 0 !important;
    }

    #layout-menu .menu-item {
      flex-grow: 1 !important;
      text-align: center !important;
    }

    #layout-menu .menu-item .menu-link {
      justify-content: center !important;
      margin: 6px 4px !important;
      padding: 6px 12px !important;
    }
  }

  /* Vertical / Sidebar Layout overrides (Mobile/Tablet - < 1200px) */
  @media (max-width: 1199.98px) {
    #layout-menu .menu-item .menu-link {
      margin: 6px 15px !important;
      padding: 10px 16px !important;
      justify-content: flex-start !important;
    }

    #layout-menu .menu-inner {
      padding: 10px 0 !important;
    }
  }

  /* Submenu (Dropdown lists) Styling */
  #layout-menu .menu-sub {
    padding: 4px !important;
    background-color: #ffffff !important;
    border: 1px solid #dbdade !important;
    border-radius: 6px !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
    margin-top: -4px !important;
    min-width: 260px !important;
    z-index: 99999 !important;
    overflow: visible !important;
  }

  /* Prevent submenu items from inheriting flex-grow / centering */
  #layout-menu .menu-sub .menu-item {
    flex-grow: 0 !important;
    margin: 0 !important;
    padding: 0 !important;
    text-align: left !important;
    width: 100% !important;
  }

  /* Nested sub-submenus (e.g. Compliance submenu) offsets */
  #layout-menu .menu-sub .menu-sub {
    margin-top: -6px !important;
    margin-left: -6px !important;
  }

  /* Submenu links (sav nana style) */
  #layout-menu .menu-sub .menu-item .menu-link {
    background: transparent !important;
    border: none !important;
    border-radius: 4px !important;
    padding: 4px 8px !important;
    margin: 0 !important;
    line-height: 1.3 !important;
    color: #5d596c !important;
    font-size: 12px !important;
    font-weight: 400 !important;
    box-shadow: none !important;
    height: auto !important;
    justify-content: flex-start !important;
    width: 100% !important;
    position: relative !important;
  }

  /* Hide the default overlapping bullet point/dots */
  #layout-menu .menu-sub .menu-link::before {
    display: none !important;
    content: none !important;
  }

  #layout-menu .menu-sub .menu-item.active>.menu-link,
  #layout-menu .menu-sub .menu-item .menu-link:hover,
  #layout-menu .menu-sub .menu-item .menu-link:focus {
    background-color: rgba(19, 92, 163, 0.08) !important;
    color: #135ca3 !important;
    outline: none !important;
  }

  /* Thin horizontal divider below specific items */
  #layout-menu .menu-sub .menu-divider-bottom {
    border-bottom: 1px solid #dbdade !important;
    padding-bottom: 4px !important;
    margin-bottom: 4px !important;
  }
</style>