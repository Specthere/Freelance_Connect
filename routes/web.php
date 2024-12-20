<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Mailer\Transport\Smtp\Auth\LoginAuthenticator;

//authentication

Route::middleware(['guest'])->group(function () {
    Route::get('/',[SesiController::class,'welcome'])->name('welcome');
    Route::get('/login',[SesiController::class,'index'])->name('login');
    Route::post('/login',[SesiController::class,'login']);
    Route::get('/registerclient',[SesiController::class,'register_client'])->name('register_client');
    Route::post('/registerclient',[SesiController::class,'add_client']);
    Route::get('/registerfreelancer',[SesiController::class,'register_freelancer'])->name('register_freelancer');
    Route::post('/registerfreelancer',[SesiController::class,'add_freelancer']);
});

// Admin routes
Route::middleware(['admin'])->group(function () {
    Route::get('/admin',[AdminController::class,'index']);
    Route::get('/listprojects', [AdminController::class, 'read_project'])->name('listproject');
    Route::get('/listfreelancers', [AdminController::class, 'read_freelancer'])->name('listfreelancer');
    Route::get('/listclients', [AdminController::class, 'read_client'])->name('listclient');
    Route::delete('destroyproject{id}', [AdminController::class, 'destroy_project'])->name('projects.destroy');
    Route::delete('destroyclient{id}', [AdminController::class, 'destroy_client'])->name('clients.destroy');
    Route::delete('destroyfrelancer{id}', [AdminController::class, 'destroy_freelancer'])->name('freelancers.destroy');
});

// Client routes
Route::middleware(['client'])->group(function () {
    Route::get('/client/addproject', [ClientController::class, 'index'])->name('client.addproject');
    Route::post('/client/addproject', [ClientController::class, 'add_project'])->name('client.addproject.post');
    Route::get('/client/readproject', [ClientController::class, 'read_project'])->name('client.project');
    Route::get('/client/readproject/onprogress', [ClientController::class, 'project_on_progress'])->name('client.project.onprogress');
    Route::get('/client/editproject/{id}', [ClientController::class, 'edit_project'])->name('client.editproject');
    Route::put('/client/updateproject/{id}', [ClientController::class, 'update_project'])->name('client.updateproject');
    Route::get('/client/profile', [ClientController::class, 'profile'])->name('client.profile');
    Route::post('/client/profile', [ClientController::class, 'updateProfile'])->name('client.profile.update');
    Route::get('/client/project/{id}/detail', [ClientController::class, 'detail_project'])->name('client.detailproject');
    Route::get('/project/{id}', [ProjectController::class, 'show'])->name('client.project.show');
    Route::get('/download-submission/{project}', [ProjectController::class, 'downloadSubmission'])->name('download.submission');
    Route::get('/client/payment', [ClientController::class, 'payment'])->name('client.payment');
    Route::get('/client/payment/{id}', [ClientController::class, 'detail_payment'])->name('client.detailpayment');
    Route::get('/client/payment/{id}/detail', [ClientController::class, 'detail_payment'])->name('client.detailpayment');
    Route::get('/download-detail/{project}', [ClientController::class, 'download_Detail'])->name('download.detail');
    Route::get('/preview-detail/{project}', [ClientController::class, 'preview_Detail'])->name('preview.detail');
    Route::get('/client/payment/{id}/pembayaran', [ClientController::class, 'bayar'])->name('client.bayar');
    Route::get('/client/submission/{id}/download', [ClientController::class, 'downloadSubmission'])->name('client.download_submission');
    Route::post('/client/konfirmasi-pembayaran/{id}', [ClientController::class, 'konfirmasiPembayaran'])->name('client.konfirmasi-pembayaran');
    Route::put('/client/payment/{id}/update-status', [PaymentController::class, 'updateStatus'])->name('client.update-status-payment');
    Route::post('/project/{id}/cancel', [ProjectController::class, 'cancelProject'])->name('client.project.cancel');
    Route::get('/client/history', [ClientController::class, 'History'])->name('client.history');
    Route::get('/client/history/{id}', [ClientController::class, 'detailHistory'])->name('client.detailhistory'); 
    Route::get('/client/projects/data', [ProjectController::class, 'getData'])->name('client.projects.data');
});

// Freelancer routes
Route::middleware(['freelancer'])->group(function () {
    Route::get('/Freelancer',[FreelancerController::class,'index']);
    Route::get('/freelancer/projects/{id}', [FreelancerController::class, 'show'])->name('freelancer.project');
    Route::get('/freelancer/projects', [FreelancerController::class, 'read_all_project'])->name('freelancer.show');
    Route::get('/freelancer/profile', [FreelancerController::class, 'showProfile'])->name('user.profile');
    Route::get('/profile/edit/{id}', [FreelancerController::class, 'edit'])->name('user.edit');
    Route::get('/download-detail/{project}', [ClientController::class, 'download_Detail'])->name('download.detail');
    Route::get('/preview-detail/{project}', [ClientController::class, 'preview_Detail'])->name('preview.detail');
    Route::put('/profile/update/{id}', [FreelancerController::class, 'update'])->name('user.update');
    Route::post('/freelancer/project/{id}/accept', [FreelancerController::class, 'acceptProject'])->name('freelancer.accept_project');
    Route::get('/freelancer/ongoing-projects', [FreelancerController::class, 'showOngoingProjects'])->name('freelancer.ongoing_projects');
    Route::get('/freelancer/ongoing/{id}', [FreelancerController::class, 'detailOngoing'])->name('freelancer.detail_ongoing');
    Route::post('/freelancer/submit-project/{id}', [FreelancerController::class, 'submitProject'])->name('freelancer.submit_project');
    Route::post('/freelancer/update-status/{id}', [FreelancerController::class, 'updateStatus'])->name('freelancer.update_status');
    Route::get('/freelancer/submission/{id}/download', [FreelancerController::class, 'downloadSubmission'])->name('freelancer.download_submission');
    Route::post('/freelancer/projects/{id}/reopen', [FreelancerController::class, 'reopenProject'])->name('freelancer.reopen_project');
    Route::post('/project/{id}/mark-done', [FreelancerController::class, 'submitAndDOne'])->name('freelancer.submit_done');
    Route::get('/freelancer/waiting-payment', [FreelancerController::class, 'showWaitingPayment'])->name('freelancer.waiting_payment');
    Route::get('/freelancer/payment/{id}/detail', [FreelancerController::class, 'paymentDetail'])->name('freelancer.payment.detail');
    Route::post('/freelancer/payment/confirm/{id}', [FreelancerController::class,'confirmPayment'])->name('freelancer.payment.confirm');
    Route::get('/freelancer/history', [FreelancerController::class, 'History'])->name('freelancer.history');
    Route::get('/freelancer/history/{id}', [FreelancerController::class, 'detailHistory'])->name('freelancer.detail_history');
});

// Route untuk logout (bisa diakses semua user yang sudah login)
Route::middleware(['auth'])->group(function () {
    Route::get('/logout',[SesiController::class,'logout'])->name('logout');
});



