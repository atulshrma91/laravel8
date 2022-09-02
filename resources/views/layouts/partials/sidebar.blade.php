<div class="sidebar" data-color="{{\Auth::user()->hasRole('member')?"crm-blue":"azure"}}" {{\Auth::user()->hasRole('super-admin')?"data-background-color=black":""}}>
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

    Tip 2: you can also add an image using data-image tag
-->
  <div class="logo"><a href="{{url('/dashboard')}}" class="simple-text logo-mini text-info">
      <strong>CRM</strong>
    </a>
    <a href="{{url('/dashboard')}}" class="simple-text logo-normal">
      <img src="{{asset('img/logo.png')}}" width="110" height="44"/>
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <!--li class="nav-item {{ Request::is('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{url('/dashboard')}}">
          <i class="material-icons">dashboard</i>
          <p> {{__('dashboard.title')}} </p>
        </a>
      </li-->
      <li class="nav-item {{ Request::is('accounts')  || Request::is('accounts/*') ? 'active' : '' }}">
        <a class="nav-link" href="{{url('/accounts')}}">
          <i class="material-icons">contacts</i>
          <p> Accounts </p>
        </a>
      </li>
      @if(\Auth::user()->isExtensionActivated('forms'))
      <li class="nav-item {{ Request::is('forms')  || Request::is('forms/*') ? 'active' : '' }}">
        <a class="nav-link" href="{{url('/forms')}}">
          <i class="material-icons">dynamic_form</i>
          <p> Forms </p>
        </a>
      </li>
      @endif
      @if(\Auth::user()->isExtensionActivated('deals'))
      <li class="nav-item {{ Request::is('deals')  || Request::is('deals/*') ? 'active' : '' }}">
        <a class="nav-link" href="{{url('/deals')}}">
          <i class="material-icons">business_center</i>
          <p> Deals </p>
        </a>
      </li>
      @endif
      @role('super-admin')
        <li class="nav-item {{ Request::is('owners') ? 'active' : '' }}">
          <a class="nav-link" href="{{url('/owners')}}">
            <i class="material-icons">people</i>
            <p> Owners </p>
          </a>
        </li>
        <li class="nav-item {{ Request::is('translations/*')? 'active' : '' }}">
          <a class="nav-link" data-toggle="collapse" href="#translations">
            <i class="material-icons">translate</i>
            <p> Translations
              <b class="caret"></b>
            </p>
          </a>
          <div class="collapse {{ Request::is('translations/*')? 'show' : '' }}" id="translations">
            <ul class="nav">
              <li class="nav-item {{ Request::is('translations/authentication/login') || Request::is('translations/authentication/register') || Request::is('translations/authentication/forgot-password')? 'active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#authenticationCollapse" aria-controls="authenticationCollapse">
                  <span class="sidebar-mini"> <i class="material-icons">fingerprint</i> </span>
                  <span class="sidebar-normal"> Authentication
                    <b class="caret"></b>
                  </span>
                </a>
                <div class="collapse {{ Request::is('translations/authentication/login') || Request::is('translations/authentication/register') || Request::is('translations/authentication/forgot-password')? 'show' : '' }} panel-collapse collapse in" id="authenticationCollapse">
                  <ul class="nav">
                    <li class="nav-item {{ Request::is('translations/authentication/login') ? 'active' : '' }}">
                      <a class="nav-link" href="{{url('translations/authentication/login')}}">
                        <span class="sidebar-mini"> - </span>
                        <span class="sidebar-normal"> Login </span>
                      </a>
                    </li>
                    <li class="nav-item {{ Request::is('translations/authentication/register') ? 'active' : '' }}">
                      <a class="nav-link" href="{{url('translations/authentication/register')}}">
                        <span class="sidebar-mini"> - </span>
                        <span class="sidebar-normal"> Register </span>
                      </a>
                    </li>
                    <li class="nav-item {{ Request::is('translations/authentication/forgot-password') ? 'active' : '' }}">
                      <a class="nav-link" href="{{url('translations/authentication/forgot-password')}}">
                        <span class="sidebar-mini"> - </span>
                        <span class="sidebar-normal"> Forgot Password </span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item {{ Request::is('translations/email/verifyemail') || Request::is('translations/email/forgotpassword')? 'active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#emailsCollapse">
                  <span class="sidebar-mini"> <i class="material-icons">email</i> </span>
                  <span class="sidebar-normal"> Mails
                    <b class="caret"></b>
                  </span>
                </a>
                <div class="collapse {{ Request::is('translations/email/verifyemail') || Request::is('translations/email/forgotpassword')? 'show' : '' }}" id="emailsCollapse">
                  <ul class="nav">
                    <li class="nav-item {{ Request::is('translations/email/verifyemail') ? 'active' : '' }}">
                      <a class="nav-link" href="{{url('translations/email/verifyemail')}}">
                        <span class="sidebar-mini"> - </span>
                        <span class="sidebar-normal"> VerifyEmail </span>
                      </a>
                    </li>
                    <li class="nav-item {{ Request::is('translations/email/forgotpassword') ? 'active' : '' }}">
                      <a class="nav-link" href="{{url('translations/email/forgotpassword')}}">
                        <span class="sidebar-mini"> - </span>
                        <span class="sidebar-normal"> ForgotPassword </span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item {{ Request::is('translations/page/accounts') || Request::is('translations/page/deals') || Request::is('translations/page/terms-conditions') || Request::is('translations/page/menu-items') || Request::is('translations/page/account') || Request::is('translations/page/user') || Request::is('translations/page/dashboard')? 'active' : '' }}">
                <a class="nav-link" data-toggle="collapse" href="#pagesCollapse">
                  <span class="sidebar-mini"> <i class="material-icons">pages</i></span>
                  <span class="sidebar-normal"> Pages
                    <b class="caret"></b>
                  </span>
                </a>
                <div class="collapse {{  Request::is('translations/page/accounts') || Request::is('translations/page/deals') || Request::is('translations/page/terms-conditions') || Request::is('translations/page/menu-items') || Request::is('translations/page/account') || Request::is('translations/page/user') || Request::is('translations/page/dashboard')? 'show' : '' }}" id="pagesCollapse">
                  <ul class="nav">
                    <li class="nav-item {{ Request::is('translations/page/accounts') ? 'active' : '' }}">
                      <a class="nav-link" href="{{url('translations/page/accounts')}}">
                        <span class="sidebar-mini"> - </span>
                        <span class="sidebar-normal"> Accounts </span>
                      </a>
                    </li>
                    <li class="nav-item {{ Request::is('translations/page/deals') ? 'active' : '' }}">
                      <a class="nav-link" href="{{url('translations/page/deals')}}">
                        <span class="sidebar-mini"> - </span>
                        <span class="sidebar-normal"> Deals </span>
                      </a>
                    </li>
                    <li class="nav-item {{ Request::is('translations/page/terms-conditions') ? 'active' : '' }}">
                      <a class="nav-link" href="{{url('translations/page/terms-conditions')}}">
                        <span class="sidebar-mini"> - </span>
                        <span class="sidebar-normal"> Terms & Conditions </span>
                      </a>
                    </li>
                    <li class="nav-item {{ Request::is('translations/page/menu-items') ? 'active' : '' }}">
                      <a class="nav-link" href="{{url('translations/page/menu-items')}}">
                        <span class="sidebar-mini"> - </span>
                        <span class="sidebar-normal"> Menu </span>
                      </a>
                    </li>
                    <li class="nav-item {{ Request::is('translations/page/account') ? 'active' : '' }}">
                      <a class="nav-link" href="{{url('translations/page/account')}}">
                        <span class="sidebar-mini"> - </span>
                        <span class="sidebar-normal"> Account </span>
                      </a>
                    </li>
                    <li class="nav-item {{ Request::is('translations/page/user') ? 'active' : '' }}">
                      <a class="nav-link" href="{{url('translations/page/user')}}">
                        <span class="sidebar-mini">-</span>
                        <span class="sidebar-normal"> User </span>
                      </a>
                    </li>
                    <li class="nav-item {{ Request::is('translations/page/dashboard') ? 'active' : '' }}">
                      <a class="nav-link" href="{{url('translations/page/dashboard')}}">
                        <span class="sidebar-mini">-</span>
                        <span class="sidebar-normal"> Dashboard </span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </li>
      @endrole
      <li class="nav-item {{ Request::is('account') || Request::is('user') || Request::is('extensions') || Request::is('extensions/*')? 'active' : '' }} settings">
        <a class="nav-link" data-toggle="collapse" href="#settingsExamples">
          <i class="material-icons">settings</i>
          <p> {{__('menuitems.settings')}}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ Request::is('account') || Request::is('user') || Request::is('extensions') || Request::is('extensions/*')? 'show' : '' }} panel-collapse in" id="settingsExamples">
          <ul class="nav">
            <li class="nav-item {{ Request::is('account') ? 'active' : '' }}">
              <a class="nav-link" href="{{url('/account')}}">
                <span class="sidebar-mini"> <i class="material-icons">settings_power</i> </span>
                <span class="sidebar-normal"> {{__('menuitems.account')}} </span>
              </a>
            </li>
            <li class="nav-item {{ Request::is('user') ? 'active' : '' }}">
              <a class="nav-link" href="{{url('/user')}}">
                <span class="sidebar-mini"> <i class="material-icons">account_circle</i> </span>
                <span class="sidebar-normal"> {{__('menuitems.user')}} </span>
              </a>
            </li>
            <li class="nav-item {{ Request::is('extensions') || Request::is('extensions/*') ? 'active' : '' }}">
              <a class="nav-link" href="{{url('/extensions')}}">
                <span class="sidebar-mini"> <i class="material-icons">extension</i> </span>
                <span class="sidebar-normal"> Extensions </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>
