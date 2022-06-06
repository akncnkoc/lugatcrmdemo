<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
  <div class="menu-item px-3">
    <div class="menu-content d-flex align-items-center px-3">
      <div class="symbol symbol-50px me-5">
        <img alt="Logo" src="{{asset('media/logos/logo.png')}}" />
      </div>
      <div class="d-flex flex-column">
        <div class="fw-bolder d-flex align-items-center fs-5">Max Smith
          <span class="badge badge-light-success fw-bolder fs-8 px-2 py-1 ms-2">Pro</span></div>
        <a href="#" class="fw-bold text-muted text-hover-primary fs-7">max@kt.com</a>
      </div>
    </div>
  </div>
  <div class="separator my-2"></div>
  <div class="menu-item px-5">
    <a href="?page=account/overview" class="menu-link px-5">My Profile</a>
  </div>
  <div class="menu-item px-5">
    <a href="?page=apps/projects/list" class="menu-link px-5">
      <span class="menu-text">My Projects</span>
      <span class="menu-badge">
        <span class="badge badge-light-danger badge-circle fw-bolder fs-7">3</span>
      </span>
    </a>
  </div>
  <div class="menu-item px-5" data-kt-menu-trigger="hover" data-kt-menu-placement="left-start">
    <a href="#" class="menu-link px-5">
      <span class="menu-title">My Subscription</span>
      <span class="menu-arrow"></span>
    </a>
    <div class="menu-sub menu-sub-dropdown w-175px py-4">
      <div class="menu-item px-3">
        <a href="?page=account/referrals" class="menu-link px-5">Referrals</a>
      </div>
      <div class="menu-item px-3">
        <a href="?page=account/billing" class="menu-link px-5">Billing</a>
      </div>
      <div class="menu-item px-3">
        <a href="?page=account/statements" class="menu-link px-5">Payments</a>
      </div>
      <div class="menu-item px-3">
        <a href="?page=account/statements" class="menu-link d-flex flex-stack px-5">Statements
          <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="View your statements"></i></a>
      </div>
      <div class="separator my-2"></div>
      <div class="menu-item px-3">
        <div class="menu-content px-3">
          <label class="form-check form-switch form-check-custom form-check-solid">
            <input class="form-check-input w-30px h-20px" type="checkbox" value="1" checked="checked" name="notifications" />
            <span class="form-check-label text-muted fs-7">Notifications</span>
          </label>
        </div>
      </div>
    </div>
  </div>
  <div class="menu-item px-5">
    <a href="?page=account/statements" class="menu-link px-5">My Statements</a>
  </div>
  <div class="menu-item px-5 my-1">
    <a href="?page=account/settings" class="menu-link px-5">Account Settings</a>
  </div>
  <div class="menu-item px-5">
    <a href="?page=authentication/flows/basic/sign-in" class="menu-link px-5">Sign Out</a>
  </div>
  <div class="separator my-2"></div>
  <div class="menu-item px-5">
    <div class="menu-content px-5">
      <label class="form-check form-switch form-check-custom form-check-solid pulse pulse-success" for="kt_user_menu_dark_mode_toggle">
        <input class="form-check-input w-30px h-20px" type="checkbox" value="1" name="mode" id="kt_user_menu_dark_mode_toggle" data-kt-url="../../demo1/dist/?page=index&amp;mode=dark" />
        <span class="pulse-ring ms-n1"></span>
        <span class="form-check-label text-gray-600 fs-7">Dark Mode</span>
      </label>
    </div>
  </div>
</div>
