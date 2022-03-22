<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Bootstrap Example</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" integrity="sha512-10/jx2EXwxxWqCLX/hHth/vu2KY3jCF70dCQB8TSgNjbCVAC/8vai53GfMDrO2Emgwccf2pJqxct9ehpzG+MTw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="{{ asset("assets/css/admin.css") }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="{{ asset("assets/js/dist/image-uploader.min.css") }}">
        <script type="text/javascript" src="{{ asset("assets/js/dist/image-uploader.min.js") }}"></script>
    </head>
    <body>
        <div style="height:1200px">
            <main class="h-100">
                <div class="wrapper d-flex justify-content-between h-100">
                @include("admin.layout.sidebar")
                    <div class="content w-100">
                        <div class="mb-3">
                            <ul class="nav justify-content-end bg-secondary">
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="#"><i class="fa-solid fa-bell mr-1"></i>Notification</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-white" href="{{ route("admin.logout") }}"><i class="fa-solid fa-arrow-right-from-bracket mr-1"></i>Logout</a>
                                </li>
                            </ul>
                        </div>
                        <div class="px-3">
                        @yield("main")
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
@stack('scripts')
