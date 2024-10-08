<?php

use App\Http\Controllers\Aptitude_test\AptitudeController;
use App\Http\Controllers\Aptitude_test\GenerateTestController;
use App\Http\Controllers\Aptitude_test\ResultController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\User\BoardsController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\MediumController;
use App\Http\Controllers\User\SchoolController;
use App\Http\Controllers\User\StandardController;
use App\Http\Controllers\Autocomplete\AutocompleteController;
use App\Http\Controllers\User\ChapterController;
use App\Http\Controllers\User\ProgressController;
use App\Http\Controllers\User\QuestionsController;
use App\Http\Controllers\User\RoleController;
use App\Http\Controllers\User\StudentsController;
use App\Http\Controllers\User\StudentSubjectController;
use App\Http\Controllers\User\SubjectController;
use App\Http\Controllers\User\TeacherController;
use App\Http\Controllers\User\TeacherSubjectController;
use App\Http\Controllers\User\TestController;
use App\Http\Controllers\User\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//apptitude
Route::resource('aptitude', AptitudeController::class);

Route::post('start_test', [AptitudeController::class, 'start_test']);
Route::get('save_test', [AptitudeController::class, 'save_test']);
Route::get('autocomplete_medium', [AutocompleteController::class, 'autocomplete_medium']);
Route::get('autocomplete_school', [AutocompleteController::class, 'autocomplete_school']);
Route::get('autocomplete_teacher', [AutocompleteController::class, 'autocomplete_teacher']);
//login
Route::get('/', [LoginController::class, 'showLoginForm']);
Route::post('/', [LoginController::class, 'login'])->name('login');
Route::middleware(['auth'])->group(
    function () {
        Route::get('/home', [HomeController::class, 'index'])->name('home');
        
        Route::resource('standard', StandardController::class);
        Route::resource('role', RoleController::class);
        Route::resource('user', UserController::class);
        Route::get('user-role', [UserController::class, 'user_role']);
        Route::resource('boards', BoardsController::class);
        Route::resource('medium', MediumController::class);
        //school routes
        Route::resource('school',SchoolController::class);
Route::get('school_medium', [SchoolController::class, 'school_medium']);
Route::get('school_board', [SchoolController::class, 'school_board']);
Route::get('school_standard', [SchoolController::class, 'school_standard']);
// subject routes
Route::resource('subject', SubjectController::class);
Route::get('subject_medium', [SubjectController::class, 'subject_medium']);
Route::get('subject_standard', [SubjectController::class, 'subject_standard']);
Route::get('subject_board', [SubjectController::class, 'subject_board']);
// test routes
Route::resource('test', TestController::class);
Route::get('test_medium', [TestController::class, 'test_medium']);
Route::get('test_standard', [TestController::class, 'test_standard']);
Route::get('test_subject', [TestController::class, 'test_subject']);
Route::get('board_medium', [BoardsController::class, 'board_medium']);
// student routes
Route::resource('student',StudentsController::class);
Route::get('student_board', [StudentsController::class, 'student_board']);
Route::get('student_medium', [StudentsController::class, 'student_medium']);
Route::get('student_standard', [StudentsController::class, 'student_standard']);
Route::resource('teacher', TeacherController::class);

Route::resource('generate_test', GenerateTestController::class);
Route::post('generate_test_status_update', [GenerateTestController::class, 'status_update']);
Route::resource('result', ResultController::class);
                Route::get('result_board', [ResultController::class, 'result_board']);
                Route::get('result_medium', [ResultController::class, 'result_medium']);
                Route::get('result_standard', [ResultController::class, 'result_standard']);
                Route::get('result_subject', [ResultController::class, 'result_subject']);
                Route::get('result_getChapters', [ResultController::class, 'result_getChapters']);
Route::resource('chapters', ChapterController::class);
Route::get('chapter_board', [ChapterController::class, 'chapter_board']);
Route::get('chapter_medium', [ChapterController::class, 'chapter_medium']);
Route::get('chapter_standard', [ChapterController::class, 'chapter_standard']);
Route::get('chapter_subject', [ChapterController::class, 'chapter_subject']);
Route::resource('questions', QuestionsController::class);
Route::get('questions_getChapters', [QuestionsController::class, 'questions_getChapters']);
        Route::get('questions_board', [QuestionsController::class, 'questions_board']);
        Route::get('questions_medium', [QuestionsController::class, 'questions_medium']);
        Route::get('questions_standard', [QuestionsController::class, 'questions_standard']);
        Route::get('questions_subject', [QuestionsController::class, 'questions_subject']);
Route::resource('student_subject', StudentSubjectController::class);
        Route::get('student_all_subject', [StudentSubjectController::class, 'student_all_subject']);
Route::resource('progress', ProgressController::class);
        Route::get('progress_all_subject', [ProgressController::class, 'progress_all_subject']);
Route::resource('teacher_subject', TeacherSubjectController::class);
        Route::get('teacher_subject_board', [TeacherSubjectController::class, 'teacher_subject_board']);
        Route::get('teacher_subject_medium', [TeacherSubjectController::class, 'teacher_subject_medium']);
        Route::get('teacher_subject_subjects', [TeacherSubjectController::class, 'teacher_subject_subjects']);
//autocomplite route

//logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

}
);