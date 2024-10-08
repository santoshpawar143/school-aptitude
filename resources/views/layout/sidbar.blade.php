  <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">

          <li class="nav-item">
              <a class="nav-link" href="{{ route('home') }}">
                  <i class="bi bi-grid"></i>
                  <span>Dashboard</span>
              </a>
          </li><!-- End Dashboard Nav -->
          <!-- Components Nav -->
          <!-- End Components Nav -->
          @auth
              @if (auth()->user()->role == 1)
                  <li class="nav-item">
                      <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse"
                          href="#">
                          <i class="bi bi-person"></i><span>User Management</span><i class="bi bi-chevron-down ms-auto"></i>
                      </a>
                      <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                          <li class="nav-item">
                              <a class="nav-link collapsed" href="{{ route('user.index') }}">Users</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link collapsed" href="{{ route('role.index') }}">Roles</a>
                          </li>
                      </ul>
                  </li>
              @endif
              @if (auth()->user()->role == 1 || auth()->user()->role == 2)
                  <li class="nav-item">
                      <a class="nav-link collapsed" data-bs-target="#schools-nav" data-bs-toggle="collapse" href="#">
                          <i class="bi bi-building"></i><span>School Management</span><i
                              class="bi bi-chevron-down ms-auto"></i>
                      </a>
                      <ul id="schools-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                          @if (auth()->user()->role == 1)
                              <li class="nav-item">
                                  <a class="nav-link collapsed" href="school">Schools</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link collapsed" href="{{ route('boards.index') }}">Boards</a>

                              </li>
                              <li class="nav-item">
                                  <a class="nav-link collapsed" href="{{ route('medium.index') }}">Mediums</a>

                              </li>
                              <li class="nav-item">
                                  <a class="nav-link collapsed" href="{{ route('standard.index') }}">Standards</a>

                              </li>
                              <li class="nav-item">
                                  <a class="nav-link collapsed" href="subject">subjects</a>

                              </li>
                          @endif

                          @if (auth()->user()->role == 2)
                              <li class="nav-item">
                                  <a class="nav-link collapsed" href="student">Students</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link collapsed" href="teacher">Teachers</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link collapsed" href="teacher_subject">Teacher Subject</a>
                              </li>
                          @endif
                      </ul>
                  </li>
              @endif
              @if (auth()->user()->role == 3)
                  <li class="nav-item">
                      <a class="nav-link collapsed" data-bs-target="#test-nav" data-bs-toggle="collapse" href="#">
                          <i class="bi bi-file-text"></i><span>Test Management</span><i
                              class="bi bi-chevron-down ms-auto"></i>
                      </a>
                      <ul id="test-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                          {{-- <li class="nav-item">
                              <a class="nav-link collapsed" href="test">Generate Test</a>
                          </li> --}}
                          <li class="nav-item">
                              <a class="nav-link collapsed" href="chapters">Chapters</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link collapsed" href="questions">Questons</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link collapsed" href="result">Results</a>
                          </li>
                      </ul>
                  </li>
              @endif
              @if (auth()->user()->role == 4)
                  <li class="nav-item">
                      <a class="nav-link collapsed" data-bs-target="#student-nav" data-bs-toggle="collapse" href="#">
                          <i class="bi bi-file-text"></i><span>Syllabus</span><i class="bi bi-chevron-down ms-auto"></i>
                      </a>
                      <ul id="student-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                          <li class="nav-item">
                              <a class="nav-link collapsed" href="student_subject">Subjects</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link collapsed" href="progress">Progress</a>
                          </li>

                      </ul>
                  </li>
              @endif

              <li class="nav-item">
                  <a class="nav-link collapsed" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">Logout</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST">
                      @csrf
                  </form>
              </li>
          @endauth


      </ul>

  </aside><!-- End Sidebar-->
