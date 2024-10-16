  <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">

          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('home') ? '' : 'collapsed' }}" href="{{ route('home') }}">
                  <i class="bi bi-grid"></i>
                  <span>Dashboard</span>
              </a>
          </li><!-- End Dashboard Nav -->
          <!-- Components Nav -->
          <!-- End Components Nav -->
          @auth
              @if (auth()->user()->role == 1)
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs(['user.index', 'role.index']) ? '' : 'collapsed' }}"
                          data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                          <i class="bi bi-person"></i>
                          <span>User Management</span>
                          <i class="bi bi-chevron-down ms-auto"></i>
                      </a>
                      <ul id="components-nav"
                          class="nav-content collapse {{ request()->routeIs(['user.index', 'role.index']) ? 'show' : '' }}"
                          data-bs-parent="#sidebar-nav">
                          <li class="nav-item">
                              <a class="nav-link {{ request()->routeIs('user.index') ? '' : 'collapsed' }}"
                                  href="{{ route('user.index') }}">Users</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link {{ request()->routeIs('role.index') ? '' : 'collapsed' }}"
                                  href="{{ route('role.index') }}">Roles</a>
                          </li>
                      </ul>
                  </li>
              @endif
              @if (auth()->user()->role == 1 || auth()->user()->role == 2)
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs(['school.index', 'boards.index', 'medium.index', 'standard.index', 'subject.index', 'student.index', 'teacher.index', 'teacher_subject.index']) ? '' : 'collapsed' }}"
                          data-bs-target="#schools-nav" data-bs-toggle="collapse" href="#">
                          <i class="bi bi-building"></i>
                          <span>School Management</span>
                          <i class="bi bi-chevron-down ms-auto"></i>
                      </a>
                      <ul id="schools-nav"
                          class="nav-content collapse {{ request()->routeIs(['school.index', 'boards.index', 'medium.index', 'standard.index', 'subject.index', 'student.index', 'teacher.index', 'teacher_subject.index']) ? 'show' : '' }}"
                          data-bs-parent="#sidebar-nav">
                          @if (auth()->user()->role == 1)
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('school.index') ? '' : 'collapsed' }}"
                                      href="{{ route('school.index') }}">Schools</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('boards.index') ? '' : 'collapsed' }}"
                                      href="{{ route('boards.index') }}">Boards</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('medium.index') ? '' : 'collapsed' }}"
                                      href="{{ route('medium.index') }}">Mediums</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('standard.index') ? '' : 'collapsed' }}"
                                      href="{{ route('standard.index') }}">Standards</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('subject.index') ? '' : 'collapsed' }}"
                                      href="{{ route('subject.index') }}">Subjects</a>
                              </li>
                          @endif

                          @if (auth()->user()->role == 2)
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('student.index') ? '' : 'collapsed' }}"
                                      href="{{ route('student.index') }}">Students</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('teacher.index') ? '' : 'collapsed' }}"
                                      href="{{ route('teacher.index') }}">Teachers</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link {{ request()->routeIs('teacher_subject.index') ? '' : 'collapsed' }}"
                                      href="{{ route('teacher_subject.index') }}">Teacher Subject</a>
                              </li>
                          @endif
                      </ul>
                  </li>
              @endif
              @if (auth()->user()->role == 3)
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs(['chapters.index', 'questions.index', 'result.index']) ? '' : 'collapsed' }}"
                          data-bs-target="#test-nav" data-bs-toggle="collapse" href="#">
                          <i class="bi bi-file-text"></i>
                          <span>Test Management</span>
                          <i class="bi bi-chevron-down ms-auto"></i>
                      </a>
                      <ul id="test-nav"
                          class="nav-content collapse {{ request()->routeIs(['chapters.index', 'questions.index', 'result.index']) ? 'show' : '' }}"
                          data-bs-parent="#sidebar-nav">
                          {{-- <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('test.generate') }}">Generate Test</a>
        </li> --}}
                          <li class="nav-item">
                              <a class="nav-link {{ request()->routeIs('chapters.index') ? '' : 'collapsed' }}"
                                  href="{{ route('chapters.index') }}">Chapters</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link {{ request()->routeIs('questions.index') ? '' : 'collapsed' }}"
                                  href="{{ route('questions.index') }}">Questions</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link {{ request()->routeIs('result.index') ? '' : 'collapsed' }}"
                                  href="{{ route('result.index') }}">Results</a>
                          </li>
                      </ul>
                  </li>
              @endif
              @if (auth()->user()->role == 4)
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs(['student_subject.index', 'progress.index']) ? '' : 'collapsed' }}"
                          data-bs-target="#student-nav" data-bs-toggle="collapse" href="#">
                          <i class="bi bi-file-text"></i>
                          <span>Syllabus</span>
                          <i class="bi bi-chevron-down ms-auto"></i>
                      </a>
                      <ul id="student-nav"
                          class="nav-content collapse {{ request()->routeIs(['student_subject.index', 'progress.index']) ? 'show' : '' }}"
                          data-bs-parent="#sidebar-nav">
                          <li class="nav-item">
                              <a class="nav-link {{ request()->routeIs('student_subject.index') ? '' : 'collapsed' }}"
                                  href="{{ route('student_subject.index') }}">Subjects</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link {{ request()->routeIs('progress.index') ? '' : 'collapsed' }}"
                                  href="{{ route('progress.index') }}">Progress</a>
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
