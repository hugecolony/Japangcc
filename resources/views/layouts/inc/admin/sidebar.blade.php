<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="/admin/dashboard">
          <i class="mdi mdi-view-dashboard menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <i class="mdi mdi-shape-outline menu-icon"></i>
          <span class="menu-title">Main Category</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="/admin/category/create">Add Main Category</a></li>
            <li class="nav-item"><a class="nav-link" href="/admin/category">View Category</a></li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#products" aria-expanded="false" aria-controls="products">
          <i class="mdi mdi-car-multiple menu-icon"></i>
          <span class="menu-title">Products</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="products">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="/admin/product/create">Add Products</a></li>
            <li class="nav-item"><a class="nav-link" href="/admin/product">View Products</a></li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#brands" aria-expanded="false" aria-controls="brands">
          <i class="mdi mdi-tag-outline menu-icon"></i>
          <span class="menu-title">Brands </span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="brands">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="/admin/brand/create">Add Brands</a></li>
            <li class="nav-item"><a class="nav-link" href="/admin/brand">View Brands</a></li>
          </ul>
        </div>
      </li>

    </ul>
</nav>