<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
  <div class="container-fluid">
    <div class="navbar-wrapper">
      <div class="navbar-minimize">
        <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round" >
          <i class="material-icons text_align-center visible-on-sidebar-regular" title="Collapse sidebar" rel="tooltip">more_vert</i>
          <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini" title="Expand sidebar" rel="tooltip">view_list</i>
        </button>
      </div>
      <!--a class="navbar-brand" href="{{url()->current()}}">{{ucfirst(request()->route()->getName())}}</a-->
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
      <span class="sr-only">Toggle navigation</span>
      <span class="navbar-toggler-icon icon-bar"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link" href="{{url('/dashboard')}}" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="material-icons">notifications</i>
            <span class="notification">{{!$notifications->isEmpty()?$notifications->count():0}}</span>
            <p class="d-lg-none d-md-block">
              Notifications
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right col-xs-12" aria-labelledby="navbarDropdownMenuLink">
            <div>
              <div class="card-header">
                <span class="h5">Notifications</span>
                <a href="{{url('/notifications/read')}}" class="pull-right btn btn-link btn-sm">See read notifications</a>
                <span class="clearfix"></span>
              </div>
              <div class="c-body">
                @if(!$notifications->isEmpty())
                  @foreach($notifications as $notification)
                    <div class="form-check form-check-radio dropdown-item">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="mark_read[]" value="{{$notification->id}}" >
                              {{date('d/m-y' , strtotime($notification->created_at)).' at '.date('H:i' , strtotime($notification->created_at))}} {!!$notification->message!!}
                            <span class="circle">
                                <span class="check"></span>
                            </span>
                        </label>
                    </div>
                  @endforeach
                @else
                  <div class="dropdown-item justify-content-center">
                    <h6>No new notifications</h6>
                  </div>
                @endif
              </div>
              <div class="card-footer">
                <a href="javascript:;" class="pull-right btn btn-link btn-sm mark-notifications-read">Mark all as read</a>
              </div>
            </div>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{__('menuitems.language')}}" rel="tooltip">
            <i class="material-icons">language</i>
            <p class="d-lg-none d-md-block">
              Language
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
            <a class="dropdown-item {{(app()->getLocale() == 'en')?'active':''}}" href="{{url('/locale/en')}}"> English</a>
            <a class="dropdown-item {{(app()->getLocale() == 'da')?'active':''}}" href="{{url('/locale/da')}}"> Dansk</a>
          </div>
        </li>
        @if (\Cookie::has('superAdminId'))
        <li class="nav-item">
          <a class="nav-link" href="{{url('/get-user-auth/'.\Crypt::encryptString(\Config::get('app.name')))}}" title="Switch to admin" rel="tooltip">
            <i class="material-icons">admin_panel_settings</i>
            <p class="d-lg-none d-md-block">
              Switch to admin
            </p>
          </a>
        </li>
        @endif
        <li class="nav-item">
          <a class="nav-link" href="{{url('/logout')}}" title="{{__('login.logout')}}" rel="tooltip">
            <i class="material-icons">exit_to_app</i>
            <p class="d-lg-none d-md-block">
              Logout
            </p>
          </a>
        </li>
        <li class="nav-item">
          <div class="user">
            <div class="photo thumbnail img-raised">
              <img src="{{ (\Auth::user()->image)?asset(\Auth::user()->image):asset('img/faces/new_logo.png')}}" width="38" height="38" title="{{ucfirst(Auth::user()->name)}}" rel="tooltip"/>
            </div>
            <p class="d-lg-none d-md-block text-white">
              {{ucfirst(Auth::user()->name)}}
            </p>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
