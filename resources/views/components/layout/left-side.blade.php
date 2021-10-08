<div class="side-content-wrap">
    <div class="sidebar-left open rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
        <ul class="navigation-left">
            <li class="nav-item" data-item="dashboard"><a class="nav-item-hold" href="#">
                    <i class="nav-icon i-Shop-4"></i><span class="nav-text">Products</span>
                </a>
                <div class="triangle"></div>
            </li>
        </ul>
    </div>
    <div class="sidebar-left-secondary rtl-ps-none" data-perfect-scrollbar="" data-suppress-scroll-x="true">
        <!-- Submenu Dashboards-->
        <ul class="childNav" data-parent="dashboard">
            <li class="nav-item"><a href="{{route('products.index')}}"><i class="nav-icon i-Folder"></i> <span class="item-name">Products</span></a>
            <li class="nav-item"><a href="{{route('products_categories.index')}}"><i class="nav-icon i-Folder"></i> <span class="item-name">Categories</span></a>
            </li>
        </ul>

    </div>
    <div class="sidebar-overlay"></div>
</div>
