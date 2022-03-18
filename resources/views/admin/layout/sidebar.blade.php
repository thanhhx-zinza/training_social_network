<div class="sidebar h-100 bg-info">
    <ul class="list-unstyled components h-100">
        <div class="p-3 text-white">
            <h4>Welcome: Adminstrator</h4>
        </div>
        <li class="border-bottom border-top">
            <a class="collapsed d-block dropdown-toggle p-3 text-white text-decoration-none" href="#"><i class="fa-solid fa-users mx-1"></i>Dashboard</a>
        </li>
        <li class="active border-bottom border-top">
            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="collapsed d-block dropdown-toggle p-3 text-white text-decoration-none"><i class="fa-solid fa-house mx-1"></i>Home</a>
            <ul class="collapse list-unstyled text-white" id="homeSubmenu">
                <li class="bg-light border-bottom p-3">
                    <a href="#">Home 1</a>
                </li>
                <li class="bg-light border-bottom p-3">
                    <a href="#">Home 1</a>
                </li>
                <li class="bg-light border-bottom p-3">
                    <a href="#">Home 1</a>
                </li>
            </ul>
        </li>
        <li class="border-bottom border-top">
            <a class="collapsed d-block dropdown-toggle p-3 text-white text-decoration-none" href="{{ route("customers.index") }}"><i class="fa-solid fa-users mx-1"></i>Customers</a>
        </li>
        <li class="active border-bottom border-top">
            <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="collapsed text-decoration-none d-block dropdown-toggle p-3 text-white"><i class="fa-solid fa-users mx-1"></i>Pages</a>
            <ul class="collapse list-unstyled" id="pageSubmenu">
                <li class="bg-light border-bottom p-3">
                    <a href="#">Home 1</a>
                </li>
                <li class="bg-light border-bottom p-3">
                    <a href="#">Home 1</a>
                </li>
                <li class="bg-light border-bottom p-3">
                    <a href="#">Home 1</a>
                </li>
            </ul>
        </li>
        <li class="active border-bottom border-top">
            <a class="collapsed d-block dropdown-toggle p-3 text-white text-decoration-none" href="#"><i class="fa-solid fa-users mx-1"></i>Portfolio</a>
        </li>
        <li class="active border-bottom border-top">
            <a class="collapsed d-block dropdown-toggle p-3 text-white text-decoration-none" href="#"><i class="fa-solid fa-users mx-1"></i>Contact</a>
        </li>
    </ul>
</div>
