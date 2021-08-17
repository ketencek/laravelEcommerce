<?php
// $routes = array();

// function setActiveMenu($route)
// {
//     return (Request::is($route) || Request::is($route . '/*')) ? 'active' : '';
// }

// function setActiveMenuDropdown($children)
// {
//     global $routes;
//     $routes = array();

//     $all_routes = getAllRoutes($children);

//     $class = '';
//     foreach ($all_routes as $r) {
//         if (setActiveMenu($r) == 'active') {
//             $class = 'active';
//             break;
//         }
//     }

//     return $class;
// }

// function getAllRoutes($children)
// {
//     global $routes;

//     foreach ($children as $key => $value) {
//         if (isset($value['route']) && $value['route'] != '') {
//             $routes[] = $value['route'];
//         }
//         if (isset($value['children']) && count($value['children']) > 0) {
//             getAllRoutes($value['children']);
//         }
//     }
//     return $routes;
// }

// function printMenu($menus){
//     // array_multisort(array_column($branch, "display_priority"), SORT_ASC, $branch);
//     if (isset($menus['children']) && count($menus['children']) > 0) 
//     {
//         echo '<li class="'.setActiveMenuDropdown($menus['children']).'">
//             <a href="#"><span class="nav-label">'. __("admin/menu.".$menus['id']) .'</span> <span class="fa arrow"></span> </a>
//             <ul class="nav nav-second-level collapse">';
//                 foreach ($menus['children'] as $submenus)
//                 {   
//                     if (isset($submenus['children']) && count($submenus['children']) > 0) {
//                         printMenu($submenus);
//                     }
//                     if ($submenus["route"] != '') {
//                     echo '<li class="'.setActiveMenu($submenus["route"]).'">
//                         <a href="'. url($submenus["route"]) .'"><span class="nav-label">'. __("admin/menu.".$submenus['id']) .'</span></a>
//                     </li>';
//                     }
//                 }
//         echo '</ul>
//         </li>';
//     }
//     else if($menus["route"] != ''){
//         echo '<li class="'. setActiveMenu($menus["route"]) .'">
//             <a href="'. url($menus["route"]) .'"><span class="nav-label">'. __("admin/menu.".$menus['id']) .'</span></a>
//         </li>';
//     }
// }
?>


@php
    $menus = config('custom.admin_menu');
@endphp
<div class="admin_header">
    <div id="nav">
        <div class="navbar navbar-default">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                </button>
                <a class="toogle_bar" href="javascript:void(0)"><i class="fa fa-bars"></i></a>
                <a class="navbar-brand" href="{{url('admin')}}"><img src="{{asset('images/logo.svg')}}" style="width:130px" alt="Logo" /></a>
            </div>
            <div class="collapse navbar-collapse navbar_menu" id="navbar-collapse">
                <ul class="nav navbar-nav navbar_main">

                    @foreach($menus as $m_name => $m_array)
                        @php
                            if(isset($m_array['submenu'])) {
                                foreach($m_array['submenu'] as $s_name => $s_array) {

                                }
                            } else {

                            }
                        @endphp
                    @endforeach

                    <li class="active">
                        <a class="active" href="{{url('admin')}}">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        </a>
                    </li>
                     <li class="drop ">
                        <a class="" href="javascript:void">
                            <i class="fa fa-list"></i> <span>{{ __('Banner') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="" href="{{ route('admin.banner.index',['type'=>'Banner']) }}">
                                    <i class="fa fa-angle-double-right"></i> Banner </a>
                            </li>
                        </ul>
                    </li>
                    <li class="drop ">
                        <a class="" href="javascript:void">
                            <i class="fa fa-list"></i> <span>{{ __('Discount') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="" href="{{ route('admin.discounts.index', ['type' =>'general']) }}">
                                    <i class="fa fa-angle-double-right"></i> {{ __('Discount') }} </a>
                            </li>
                            <li>
                                <a class="" href="{{ route('admin.discounts.index', ['type' =>'global-user']) }}">
                                    <i class="fa fa-angle-double-right"></i> {{ __('Global/User Discount') }} </a>
                            </li>
                        </ul>
                    </li>
                    <li class="drop ">
                        <a class="" href="javascript:void">
                            <i class="fa fa-list"></i> <span>Page</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="" href="{{ route('admin.static-page.index',['type'=>'AboutUs']) }}">
                                    <i class="fa fa-angle-double-right"></i> AboutUs </a>
                            </li>
                        </ul>
                    </li>
                     <li class="">
                        <a class="" href="{{route('admin.countries.index')}}">
                            <i class="fa fa-angle-double-right"></i> <span>{{ __('Country') }}</span>
                        </a>
                    </li>

                    <li class="">
                        <a class="" href="{{route('admin.category.index')}}">
                            <i class="fa fa-angle-double-right"></i> <span>{{ __('Category') }}</span>
                        </a>
                    </li>

                    <li class="">
                        <a class="" href="{{route('admin.contacts.index')}}">
                            <i class="fa fa-angle-double-right"></i> <span>{{ __('Contact') }}</span>
                        </a>
                    </li>

                    <li class="">
                        <a class="" href="{{route('admin.blog-categories.index')}}">
                            <i class="fa fa-angle-double-right"></i> <span>{{ __('Blog Category') }}</span>
                        </a>
                    </li>

                    <li class="">
                        <a class="" href="{{route('admin.faq-categories.index')}}">
                            <i class="fa fa-angle-double-right"></i> <span>{{ __('Faq Category') }}</span>
                        </a>
                    </li>

                    <li class="">
                        <a class="" href="{{route('admin.logos.index', ['type' => 'Certificate'])}}">
                            <i class="fa fa-angle-double-right"></i> <span>{{ __('Certificate') }}</span>
                        </a>
                    </li>

                    <li class="">
                        <a class="" href="{{route('admin.languages.index')}}">
                            <i class="fa fa-angle-double-right"></i> <span>{{ __('Language') }}</span>
                        </a>
                    </li>

                    <li class="drop ">
                        <a class="" href="javascript:void">
                            <i class="fa fa-list"></i> <span>{{ __('Newsletter') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="" href="{{route('admin.newsletters.index')}}">
                                    <i class="fa fa-angle-double-right"></i> <span>{{ __('Email') }}</span>
                                </a>
                            </li>
                            <li class="">
                                <a class="" href="{{route('admin.newsletter-messages.index')}}">
                                    <i class="fa fa-angle-double-right"></i> <span>{{ __('Message') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="">
                        <a class="" href="{{route('admin.redirections.index')}}">
                            <i class="fa fa-angle-double-right"></i> <span>{{ __('Redirection') }}</span>
                        </a>
                    </li>

                    <li class="">
                        <a class="" href="{{route('admin.order-statuses.index')}}">
                            <i class="fa fa-angle-double-right"></i> <span>{{ __('Order Status') }}</span>
                        </a>
                    </li>

                    <li class="drop ">
                        <a class="" href="javascript:void">
                            <i class="fa fa-list"></i> <span>{{ __('Product') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="" href="{{route('admin.price-type.index')}}">
                                    <i class="fa fa-angle-double-right"></i> <span>{{ __('Price Type') }}</span>
                                </a>
                            </li>
                            <li class="">
                                <a class="" href="{{route('admin.colors.index')}}">
                                    <i class="fa fa-angle-double-right"></i> <span>{{ __('Color') }}</span>
                                </a>
                            </li>
                            <li class="">
                                <a class="" href="{{route('admin.sizes.index')}}">
                                    <i class="fa fa-angle-double-right"></i> <span>{{ __('Size') }}</span>
                                </a>
                            </li>
                            <li class="">
                                <a class="" href="{{route('admin.options.index')}}">
                                    <i class="fa fa-angle-double-right"></i> <span>{{ __('Option') }}</span>
                                </a>
                            </li>
                            <li class="">
                                <a class="" href="{{route('admin.products.index')}}">
                                    <i class="fa fa-angle-double-right"></i> <span>{{ __('Product') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="drop ">
                        <a class="" href="javascript:void">
                            <i class="fa fa-list"></i> <span>{{ __('Users') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="" href="{{route('admin.users.index', array('type'=> 'admin'))}}">
                                    <i class="fa fa-angle-double-right"></i> <span>{{ __('Admin User') }}</span>
                                </a>
                            </li>
                            <li class="">
                                <a class="" href="{{route('admin.users.index',array('type'=> 'client'))}}">
                                    <i class="fa fa-angle-double-right"></i> <span>{{ __('Client User') }}</span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="">
                        <a class="" href="{{route('admin.settingstype.list')}}">
                            <i class="fa fa-angle-double-right"></i> <span>Setting</span>
                        </a>
                    </li>

                    <li class="drop ">
                        <a class="" href="javascript:void">
                            <i class="fa fa-th-largelist"></i> <span>{{ __('Variable') }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="" href="{{ route('admin.variables.index',['type'=>'OTHER']) }}">
                                    <i class="fa fa-angle-double-right"></i> {{ __('Variables') }} </a>
                            </li>
                            <li>
                                <a class="" href="{{ route('admin.variables.index',['type'=>'MAIL']) }}">
                                    <i class="fa fa-angle-double-right"></i> {{ __('Mail Variables') }} </a>
                            </li>
                            <li>
                                <a class="" href="{{ route('admin.variables.index',['type'=>'BASIC']) }}">
                                    <i class="fa fa-angle-double-right"></i> {{ __('Basic Variables') }} </a>
                            </li>
                            <li>
                                <a class="" href="{{ route('admin.variables.index',['type'=>'SEO']) }}">
                                    <i class="fa fa-angle-double-right"></i> {{ __('Seo Variables') }} </a>
                            </li>
                            <li>
                                <a class="" href="{{ route('admin.variables.index',['type'=>'routing']) }}">
                                    <i class="fa fa-angle-double-right"></i> {{ __('Routing') }} </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <ul class="nav navbar-nav navbar-right nav_user">
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-user"></i></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">{{ __('Devloper') }}</li>
                        <li><a href="{{ route('admin.admins.change-password') }}"><span class="fa fa-lock"></span> {{ __('Change password') }}</a></li>
                        <li><a href="/admin.php/cache_clear"><span class="fa fa-refresh"></span> {{ __('Cache Clear') }}</a></li>
                        <li><a href="/admin.php/build-model-forms-sql"><span class="fa fa-building"></span> {{ __('Build All') }}</a></li>
                        <li><a href="{{ route('admin.image-optimizes.index') }}"><span class="fa fa-image"></span> {{ __('Image optimize') }}</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0)" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i>
                    </a>

                    <form id="logout-form" action="{{ url('admin/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="clearfix"></div>