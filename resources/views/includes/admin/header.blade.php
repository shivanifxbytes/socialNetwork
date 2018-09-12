    <header class="header dark-bg">
      <div class="toggle-nav">
        <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
      </div>
      <!--logo start-->
      <a href="{{ url('/') }}" class="logo">{{ __('messages.project_name') }}</a>
     
      <div class="top-nav">
        <ul class="nav pull-right top-menu">
          <li>
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
             <span class="profile-ava">
                                
                            </span>
                            <b class="caret"></b>
                        </a>
              <ul class="dropdown-menu extended logout">
              <li>
               <a href="{{ url('/') }}/logout"><i class="icon_key_alt"></i> {{ __('messages.logout') }}</a>
              </li>
            </ul>
          </li>
          <!-- user login dropdown end -->
        </ul>
        <!-- notificatoin dropdown end-->
      </div>
    </header>
    <!--header end-->


 



 