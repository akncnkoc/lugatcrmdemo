<div class="d-flex flex-column-fluid flex-root">
  <div class="page d-flex flex-row flex-column-fluid">
    @include('layout.aside.base')
    <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
      @include('layout.header.base')
      <div class="content d-flex flex-column flex-column-fluid overflow-hidden" id="kt_content">
        @include('layout.toolbar.toolbar')
        <div class="post d-flex flex-column-fluid" id="kt_post">
          @include('layout._content')
        </div>
      </div>
      @include("layout._footer")
    </div>
  </div>
</div>

