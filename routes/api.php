<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AssignmentDeliveriesController;
use App\Http\Controllers\AssistantChatController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetOTPController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CollegeMajorsController;
use App\Http\Controllers\GroupAppliesController;
use App\Http\Controllers\GroupAssignmentsController;
use App\Http\Controllers\GroupBooksController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMembersController;
use App\Http\Controllers\GroupTeachersController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\UpdatePasswordController;
use App\Http\Controllers\UserController;
use App\Models\Major;
use App\Models\Notification;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use Orion\Facades\Orion;

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:sanctum');

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('verified')->group(function () {

        Route::get('/notifications', function (Request $request) {
            $request->validate([
                'interest' => 'required|string',
            ]);

            return response()->json(['data' => Notification::whereJsonContains('interests', $request->interest)->get()]);
        });

        Route::post('/users/{user}/roles/{role}', PromotionController::class);

        Route::post('/users/update-password', UpdatePasswordController::class);

        Orion::resource('users', UserController::class)->except(UserController::EXCLUDE_METHODS)->withoutBatch();

        Route::get('/users/me', function () {
            return response()->json(Auth::user());
        });

        Route::get('/users/me/groups', function () {
            $query = (Auth::user()->role_id === Role::ACADEMIC || Auth::user()->role_id === Role::MANAGER) ? Auth::user()->teachingGroups()->get() : Auth::user()->groups()->get();

            return response()->json(Auth::user()->groups()->get());
        });

        Route::get('/posts/deleted', [PostController::class, 'deleted']);
        Orion::resource('posts', PostController::class)->except(PostController::EXCLUDE_METHODS)->withoutBatch();

        Orion::resource('colleges', CollegeController::class)->withSoftDeletes()->withoutBatch();
        Orion::hasManyResource('colleges', 'majors', CollegeMajorsController::class)->except(CollegeMajorsController::EXCLUDE_METHODS)->withoutBatch();

        Route::get('majors/groups', function () {
            $eduYear = now()->greaterThan(now()->month(6)->day(1)) ? now()->year : now()->year - 1;

            $majors = Major::with('groups')->get();

            $majors->each(function ($major) use ($eduYear) {
                $major->setRelation(
                    'groups',
                    $major->groups
                        ->sortByDesc('join_year')
                        ->filter(function ($group) use ($major, $eduYear) {
                            return $group->join_year >= $eduYear - $major->years;
                        })->values()
                );
            });

            return response()->json(['data' => $majors]);
        });

        Orion::resource('majors', MajorController::class)->withSoftDeletes()->withoutBatch();

        Orion::resource('subjects', SubjectController::class)->withSoftDeletes()->withoutBatch();

        Orion::resource('groups', GroupController::class)->except(GroupController::EXCLUDE_METHODS);
        Orion::hasManyResource('groups', 'applies', GroupAppliesController::class)->except(GroupAppliesController::EXCLUDE_METHODS)->withoutBatch();
        Route::post('applies/{apply}/accept', [GroupAppliesController::class, 'accept']);
        Route::post('applies/{apply}/reject', [GroupAppliesController::class, 'reject']);

        Route::get('groups/{group}/members/', [GroupMembersController::class, 'index']);
        Route::post('groups/{group}/members/{user}', [GroupMembersController::class, 'attach']);
        Route::delete('groups/{group}/members/{user}', [GroupMembersController::class, 'detach']);
        Route::patch('groups/{group}/members/{user}', [GroupMembersController::class, 'update']);

        Route::get('groups/{group}/teachers/', [GroupTeachersController::class, 'index']);
        Route::post('groups/{group}/teachers/{user}', [GroupTeachersController::class, 'attach']);
        Route::delete('groups/{group}/teachers/{user}', [GroupTeachersController::class, 'detach']);

        Orion::hasManyResource('groups', 'assignments', GroupAssignmentsController::class)->except(GroupAppliesController::EXCLUDE_METHODS)->withoutBatch();
        Orion::hasManyResource('groups', 'books', GroupBooksController::class)->except(GroupBooksController::EXCLUDE_METHODS)->withoutBatch();

        Route::get('/books/deleted', [BookController::class, 'deleted']);
        Route::get('/books/{book}/summary', SummaryController::class);
        Route::get('/books/{book}/quiz', QuizController::class);
        Orion::resource('books', BookController::class)->withoutBatch();

        Route::get('/assignments/deleted', [AssignmentController::class, 'deleted']);
        Orion::resource('assignments', AssignmentController::class)->withoutBatch();
        Orion::hasManyResource('assignments', 'deliveries', AssignmentDeliveriesController::class)->except(AssignmentDeliveriesController::EXCLUDE_METHODS)->withoutBatch();

        Route::post('/chat/create', [AssistantChatController::class, 'store']);

        Route::post('/chat/{chat}', [AssistantChatController::class, 'update']);
    });

    Route::post('verify-email', VerifyEmailController::class)
        ->name('verification.verify');

    Route::post('email/verification-notification', EmailVerificationNotificationController::class)
        ->middleware(['throttle:1,1'])
        ->name('verification.send');
});

Route::post('forgot-password', PasswordResetOTPController::class)
    ->middleware(['throttle:1,1'])
    ->name('password.email');

Route::post('reset-password', NewPasswordController::class)
    ->name('password.store');
