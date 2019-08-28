<header class="header half">
    <div class="h_wrap ss_container_fluid">
        <div class="h_logo_wrap">
            <button class="nav_trigger hamburger opener hamburger--elastic" data-open="nav" type="button">
              <span class="hamburger-box">
                <span class="hamburger-inner"></span>
              </span>
            </button>
            <ul class="h_logo tbl">
                <li>
                    <a href="{!!URL::to('/')!!}">
                        Employee Tracker
                    </a>
                </li>
            </ul>
        </div>
        <nav class="nav_wrap half">
            <ul class="nav ul_reset auto_close clearfix">
              <li class="n_toggle">
                <button type="button" class="n_button opener" data-open="notifications">
                  <i class="material-icons md-light">notifications</i>
                  @if($noti_count!=0)
                    <div class="n_table_count ss_danger">{!!$noti_count!!}</div>
                  @endif
                </button>
                @include('admin.includes.notifications')
              </li>
                <li>
                    <button type="button" class="n_button" title="FullScreen" onclick="javascript:toggleFullScreen()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"/>
                        </svg>
                    </button>
                </li>

                <li>
                    <a href="{{URL::route('logout')}}" class="n_button" title="Logout">
                        <svg style="margin-top: -22px" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M21 3.01H3c-1.1 0-2 .9-2 2V9h2V4.99h18v14.03H3V15H1v4.01c0 1.1.9 1.98 2 1.98h18c1.1 0 2-.88 2-1.98v-14c0-1.11-.9-2-2-2zM11 16l4-4-4-4v3H1v2h10v3z"/>
                        </svg>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
