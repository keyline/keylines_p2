<?php
$baseUrl    = base_url();
if ($baseUrl == 'https://tracker2.keylines.net/') {
    $currentLink    = current_url();
    $uri            = new \CodeIgniter\HTTP\URI($currentLink);
    $pageSegment    = $uri->getSegment(2);
} else {
    $currentLink    = current_url();
    $uri            = new \CodeIgniter\HTTP\URI($currentLink);
    $pageSegment    = $uri->getSegment(3);
}
$paramerId = '';
if ($baseUrl == 'https://tracker2.keylines.net/') {
    $segmentCount = $uri->getTotalSegments();
    if ($segmentCount > 2) {
        $paramerId = $uri->getSegment(3);
    } else {
        $paramerId = '';
    }
} else {
    $segmentCount = $uri->getTotalSegments();
    if ($segmentCount > 3) {
        $paramerId = $uri->getSegment(4);
    } else {
        $paramerId = '';
    }
}
$userType           = $session->user_type;
$userId             = $session->user_id;
?>
<style type="text/css">
    a.nav-link.active {
        color: green;
    }
</style>
    
      <div class="logo-details">
        <i class='bx bxl-c-plus-plus'></i>
        <span class="logo_name">CodingLab</span>
      </div>
      <ul class="nav-links">
        <li>
          <i class='bx bx-menu'></i>
        </li>
        <li>
          <a href="#">
            <i class='bx bx-grid-alt'></i>
            <span class="link_name">Dashboard</span>
          </a>
          <ul class="sub-menu blank">
            <li><a class="link_name" href="#">Dashboard</a></li>
          </ul>
        </li>
        <li>
          <div class="iocn-link">
            <a href="#">
              <i class='bx bx-collection'></i>
              <span class="link_name">Category</span>
            </a>
            <i class='bx bxs-chevron-down arrow'></i>
          </div>
          <ul class="sub-menu">
            <li><a class="link_name" href="#">Category</a></li>
            <li><a href="#">HTML & CSS</a></li>
            <li><a href="#">JavaScript</a></li>
            <li><a href="#">PHP & MySQL</a></li>
          </ul>
        </li>
        <li>
          <div class="profile-details">
            <div class="profile-content">
              <img src="image/profile.jpg" alt="profileImg">
            </div>
            <div class="name-job">
              <div class="profile_name">Prem Shahi</div>
              <div class="job">Web Desginer</div>
            </div>
            <i class='bx bx-log-out'></i>
          </div>
        </li>
      </ul>