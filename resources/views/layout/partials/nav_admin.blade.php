<!-- Sidebar -->
<div class="sidebar mt-2" id="sidebar" style="background-color:#e6eaf19e;">
                <div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<li class=" text-mute menu-title"> 
								<span class=" text-mute" >Main</span>
							</li>
							<li class="{{ Request::is('admin/index_admin') ? 'active' : '' }}"> 
								<a href="index_admin"><i class="text-mute fe fe-home"></i> <span class="text-dark" >Dashboard</span></a>
							</li>
							
							
							<li  class="{{ Request::is('admin/users') ? 'active' : '' }}"> 
								<a href="./users"><i class="fe fe-user-plus"></i> <span class="text-dark">Users</span></a>
							</li>
							<li  class="{{ Request::is('admin/plans') ? 'active' : '' }}"> 
								<a href="./plans"><i class="fe fe-user"></i> <span class="text-dark">Plans</span></a>
							</li>


							<li  class="{{ Request::is('admin/setting') ? 'active' : '' }}"> 
								<a href="./setting"><i class="fe fe-user"></i> <span class="text-dark">Setting</span></a>
							</li>

							

							
							

							
						<!--	<li  class="{{ Request::is('admin/reviews') ? 'active' : '' }}"> 
								<a href="reviews"><i class="fe fe-star-o"></i> <span>Reviews</span></a>
							</li> -->

							
						</ul>
					</div>
                </div>
            </div>
			<!-- /Sidebar -->