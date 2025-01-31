<?php

use App\Models\Medicine;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DiseasesController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicalTypeController;
use App\Http\Controllers\MedicalTestsController;
use App\Http\Controllers\MedicineTypeController;
use App\Http\Controllers\PrescritionsController;
use App\Http\Controllers\PatientVandorController;
use App\Http\Controllers\MedicineGroupeController;
use App\Http\Controllers\MedicalDocumentController;
use App\Http\Middleware\TokenVerificationMiddleware;
use App\Http\Middleware\ResetPassTokenVerificationMiddleware;

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

Route::get('/', function () {
    return view('welcome');
});
Route::post("upload", [HomeController::class,"upload"])->name("upload");
Route::prefix('/dashboard')
      ->middleware([TokenVerificationMiddleware::class])
    ->group(function () {
     Route::get("/home", [DashboardController::class,"index"]);
    Route::get("/profile", [DashboardController::class,"profilePage"])->name("dashboard.profile");
    Route::get("/profile-edit", [DashboardController::class,"profileEditPage"]);
    Route::get("/user-list", [DashboardController::class,"userListPage"])->name("dashboard.user-list-page");
    Route::get("/get-user-list", [DashboardController::class, "getUserList"])->name('dashboard.user-list');
    Route::get("/create-user", [DashboardController::class,"createUserPage"]);

    // user routes
    Route::get('/logout-user', [UserController::class, 'userLogOut'])->name("logout-user");
    Route::post('/create-user', [UserController::class, 'createUser'])->name('dashboard.create-user');
    Route::post('/check-email', [UserController::class, 'checkEmail'])->name('check.email');
    Route::post('/check-phone', [UserController::class, 'checkPhone'])->name('check.phone');
    Route::post('/update-password', [UserController::class, 'updatePassword'])->name('dashboard.update-password');
    Route::delete("/user-delete/{id}", [UserController::class,"userDelete"])->name("dasboard.user-delete");
    Route::delete("/user-inactive/{id}", [UserController::class,"userInactive"])->name("dasboard.user-inactive");
    Route::get("/user-active/{id}", [UserController::class,"userActive"])->name("dasboard.user-active");
    Route::get("/user-restore/{id}", [UserController::class,"userRestore"])->name("dasboard.user-restore");
    Route::get("/check-password-strength", [UserController::class,"checkPasswordStrength"])->name("dashboard.check-password-strength");
    Route::get("/edit-user/{id}", [UserController::class,"editUser"])->name("dasboard.user-edit");
    Route::post("/edit-user", [UserController::class,"updateUser"])->name("dashboard.edit-user");
    

    // admin routes
    Route::get("/create-admin", [AdminController::class,"createAdminPage"]);
    Route::post("/create-admin", [AdminController::class,"createAdmin"])->name("dashboard.create-admin");
    Route::post("/update-admin", [AdminController::class,"updateAdmin"])->name("dashboard.update-admin");
    Route::get("/admin-list", [AdminController::class,"adminListPage"])->name("dashboard.admin-list-page");
    Route::get("/get-admin-list", [AdminController::class,"getAdminList"])->name("dashboard.get-admin-list");
    Route::get("/active-admin", [AdminController::class,"activeAdmin"]);
    Route::get("/view-admin/{id}", [AdminController::class,"viewAdmin"])->name("dashboard.view-admin");
    Route::get("/admin-edit-profile-page/{id}", [AdminController::class,"editAdminProfile"])->name("dashboard.admin-edit-profile-page");
    Route::get("/active-admin-list", [AdminController::class,"activeAdminList"])->name("dashboard.active-admin-list");
    Route::get("/inactive-admin", [AdminController::class,"inactiveAdmin"]);
    Route::get("/inactive-admin-list", [AdminController::class,"inactiveAdminList"])->name("dashboard.inactive-admin-list");
    Route::get("/edit-admin/{id}", [AdminController::class,"editAdmin"])->name("dashboard.admin-edit");
    Route::get("/deleted-admin", [AdminController::class,"deletedAdmin"]);
    Route::get("/deleted-admin-list", [AdminController::class,"deletedAdminList"])->name("dashboard.deleted-admin-list");
    Route::post("/admin/profile-create", [AdminController::class,"profileCreate"])->name("dashboard.admin.profile.update");
    Route::post("/admin/profile-create-by-admin", [AdminController::class,"profileCreateByAdmin"])->name("dashboard.admin.profile.update.by.admin");
    Route::post("/admin/profile-update", [AdminController::class,"profileUpdate"])->name("dashboard.admin.update.profile");
    Route::get("/admin/profile-read", [AdminController::class,"profileRead"]);
    Route::get("/admin/profile-edit", [AdminController::class,"profileEdit"])->name("dashboard.edit-admin");
    Route::get("/admin/profile-delete/{id}", [AdminController::class,"profileDelete"]);

    // doctor routes
    Route::get("/doctor-list", [DoctorController::class,"doctorListPage"])->name("dashboard.doctor-list");
    Route::get("/get-doctor-list", [DoctorController::class,"getDoctorList"])->name("dashboard.get-doctor-list");
    Route::get("/create-doctor", [DoctorController::class,"createDoctorPage"]);
    Route::post("/create-doctor", [DoctorController::class,"createDoctor"])->name("dashboard.create-doctor");
    Route::get("/active-doctor", [DoctorController::class,"activeDoctor"]);
    Route::get("/active-doctor-list", [DoctorController::class,"activeDoctorList"])->name("dashboard.active-doctor-list");
    Route::get("/inactive-doctor-list", [DoctorController::class,"inactiveDoctorList"])->name("dashboard.inactive-doctor-list");
    Route::get("/view-doctor/{id}", [DoctorController::class,"viewDoctor"])->name("dashboard.view-doctor");
    Route::get("/inactive-doctor", [DoctorController::class,"inactiveDoctor"]);
    Route::get("/deleted-doctor-list", [DoctorController::class,"deletedDoctorList"])->name("dashboard.deleted-doctor-list");
    Route::get("/deleted-doctor", [DoctorController::class,"deletedDoctor"]);
    Route::get("/dashboard/doctor/admin/edit-profile/{id}", [DoctorController::class,"editProfileAdmin"])->name("dashboard.doctor.admin.edit-profile");
    Route::get("/edit-doctor/{id}", [DoctorController::class,"editDoctor"])->name("dashboard.edit-doctor");
    Route::post("/doctor/profile-create", [DoctorController::class,"profileCreate"])->name("dashboard.doctor.profile.update");
    Route::post("dashboard/doctor/admin/update/profile", [DoctorController::class,"profileUpdateAdmin"])->name("dashboard.doctor.admin.update.profile");
    
    Route::get("/doctor/profile-read", [DoctorController::class,"profileRead"]);
    Route::get("/doctor/profile-edit", [DoctorController::class,"profileEdit"])->name("dashboard.doctor.profile.edit");
    Route::get("/doctor/admin/edit-profile/{id}", [DoctorController::class,"editProfileAdmin"])->name("dashboard.doctor.admin.edit-profile");
    Route::post("/doctor/admin/profile-update", [DoctorController::class,"profileUpdateAdmin"])->name("dashboard.doctor.admin.update.profile");
    Route::get("/doctor/profile-delete/{id}", [DoctorController::class,"profileDelete"]);
    Route::post("/edit-doctor", [DoctorController::class,"updateDoctor"])->name("dashboard.update-doctor");

    // company routes
    Route::get("/company-list", [CompanyController::class,"companyListPage"])->name("dashboard.company-list");
    Route::get("/get-company-list", [CompanyController::class,"getCompanyList"])->name("dashboard.get-company-list");
    Route::get("/create-company", [CompanyController::class,"createCompanyPage"]);
    Route::get("/view-company/{id}", [CompanyController::class,"viewCompany"])->name("dasboard.view-company");
    Route::post("/create-company", [CompanyController::class,"createCompany"])->name("dashboard.create-company");
    Route::post("/update-company", [CompanyController::class,"updateCompany"])->name("dashboard.update-company");
    Route::get("/active-company", [CompanyController::class,"activeCompany"]);
    Route::get("/active-company-list", [CompanyController::class,"activeCompanyList"])->name("dashboard.active-company-list");
    Route::get("/inactive-company-list", [CompanyController::class,"inactiveCompanyList"])->name("dashboard.inactive-company-list");
    Route::get("/inactive-company", [CompanyController::class,"inactiveCompany"]);
    Route::get("/deleted-company", [CompanyController::class,"deletedCompany"]);
    Route::get("/deleted-company-list", [CompanyController::class,"deletedCompanyList"])->name("dashboard.deleted-company-list");
    Route::get("/edit-company/{id}", [CompanyController::class,"editCompany"])->name("dashboard.edit-company");
    Route::post("/company/profile-create", [CompanyController::class,"profileCreate"]);
    Route::get("/company/profile-read", [CompanyController::class,"profileRead"]);
    Route::get("/company/profile-edit", [CompanyController::class,"profileEdit"]);
    Route::get("/company/profile-delete/{id}", [CompanyController::class,"profileDelete"]);

    // patient routes
    Route::get("/patient-list", [PatientController::class,"patientListPage"])->name("dashboard.patient-list");
    Route::get("/get-patient-list", [PatientController::class,"getPatientList"])->name("dashboard.get-patient-list");
    Route::get("/create-patient", [PatientController::class,"createPatientPage"]);
    Route::post("/create-patient", [PatientController::class,"createPatient"])->name("dashboard.create-patient");
    Route::post("/update-patient", [PatientController::class,"updatePatient"])->name("dashboard.update-patient");
    Route::get("/active-patient", [PatientController::class,"activePatient"]);
    Route::get("/view-patient/{id}", [PatientController::class,"viewPatient"])->name("dashboard.view-patient");
    Route::get("/active-patient-list", [PatientController::class,"activePatientList"])->name("dashboard.active-patient-list");
    Route::get("/inactive-patient-list", [PatientController::class,"inactivePatientList"])->name("dashboard.inactive-patient-list");
    Route::get("/inactive-patient", [PatientController::class,"inactivePatient"]);
    Route::get("/deleted-patient", [PatientController::class,"deletedPatient"]);
    Route::get("/deleted-patient-list", [PatientController::class,"deletedPatientList"])->name("dashboard.deleted-patient-list");
    Route::get("/edit-patient/{id}", [PatientController::class,"editPatient"])->name("dashboard.edit-patient");
    Route::post("/patient/profile-create", [PatientController::class,"profileCreate"])->name("dashboard.patient.profile.update");
    Route::get("/patient/profile-read/{id}", [PatientController::class,"profileRead"]);
    Route::get("/patient/profile-edit", [PatientController::class,"profileEdit"])->name("dashboard.patient.profile.edit");
    Route::get("/patient/profile-delete/{id}", [PatientController::class,"profileDelete"]);
    Route::get("/patient/admin/profile-edit/{id}", [PatientController::class,"editProfileAdmin"])->name("dashboard.patient.admin.profile.edit");
    Route::post("/patient/profile-create-by-admin", [PatientController::class,"profileCreateByAdmin"])->name("dashboard.patient.profile.update.by.admin");
    Route::post("/patient/add-complain/{id?}", [PatientController::class,"addComplain"])->name("dashboard.patient.add-complain");
    Route::get("/patient/complain-list/{id}", [PatientController::class,"getComplainList"])->name("dashboard.patient.complain-list");
    Route::get("/dashboard/add-patient-ilnase/{id}/{pid}", [PatientController::class,"addPatientIlnase"])->name("dashboard.add-patient-ilnase");
    Route::get("/dashboard/get-ilnase-list/{id}", [PatientController::class,"getIllnessList"])->name("dashboard.get-ilnase-list");
    Route::get("dashboard/remove-patient-ilnase/{id}", [PatientController::class,"deleteIllness"])->name("dashboard.remove-patient-ilnase");
    Route::get("dashboard/restore-patient-ilnase/{id}", [PatientController::class,"restoreIllness"])->name("dashboard.restore-patient-ilnase");
    Route::delete("/patient/complain-delete/{id}", [PatientController::class,"deleteComplain"])->name("dashboard.patient.complain-delete");
    // Medical Document routes
    Route::get('/medical-documents', [MedicalDocumentController::class, 'index'])->name('dashboard.medical-documents-page');
    Route::get('/medical-documents-list', [MedicalDocumentController::class, 'medicalDocumentList'])->name('dashboard.medical-documents-list');
    Route::post('/medical-documents', [MedicalDocumentController::class, 'store'])->name('dashboard.medical-documents');
    Route::delete('/medical-documents-delete/{id}', [MedicalDocumentController::class, 'destroy'])->name('dashboard.medical-documents-delete');
    Route::get('/medical-documents/download/{id}', [MedicalDocumentController::class, 'download'])->name('dashboard.medical-documents-download');
    Route::get('/medical-documents/view/{id}', [MedicalDocumentController::class, 'view'])->name('dashboard.medical-documents-view');
    
    // Medicine Group routes
    Route::get("/medicine-group-list", [MedicineGroupeController::class,"medicineGroupListPage"])->name("dashboard.medicine-group-list");
    Route::get("/get-medicine-group-list", [MedicineGroupeController::class,"getMedicineGroupList"])->name("dashboard.get-medicine-group-list");
    Route::get("/active-medicine-group", [MedicineGroupeController::class,"activeMedicineGroup"]);
    Route::get("/active-medicine-group-list", [MedicineGroupeController::class,"activeMedicineGroupList"])->name("dashboard.active-medicine-group-list");
    Route::get("/inactive-medicine-group", [MedicineGroupeController::class,"inactiveMedicineGroup"]);
    Route::get("/inactive-medicine-group-list", [MedicineGroupeController::class,"inactiveMedicineGroupList"])->name("dashboard.inactive-medicine-group-list");
    Route::get("/deleted-medicine-group", [MedicineGroupeController::class,"deletedMedicineGroup"]);
    Route::get("/deleted-medicine-group-list", [MedicineGroupeController::class,"deletedMedicineGroupList"])->name("dashboard.deleted-medicine-group-list");
    Route::get("/create-medicine-group", [MedicineGroupeController::class,"createMedicineGroupPage"]);
    Route::post("/create-medicine-group", [MedicineGroupeController::class,"createMedicineGroup"])->name("dashboard.create.group");
    Route::get("/edit-medicine-group/{id}", [MedicineGroupeController::class,"editMedicineGroup"])->name("dashboard.edit-medicine-group");
    Route::post("/update-medicine-group", [MedicineGroupeController::class,"updateMedicineGroup"])->name("dashboard.update.group");
    Route::delete("/delete-medicine-group/{id}", [MedicineGroupeController::class,"deleteMedicineGroup"])->name("dashboard.delete.group");
    Route::delete("/group-inactive/{id}", [MedicineGroupeController::class,"groupInactive"])->name("dasboard.group-inactive");
    Route::get("/group-active/{id}", [MedicineGroupeController::class,"groupActive"])->name("dasboard.group-active");
    Route::get("/group-restore/{id}", [MedicineGroupeController::class,"groupRestore"])->name("dasboard.group-restore");
    Route::post("/check-group-name", [MedicineGroupeController::class,"checkGroupName"])->name("dashboard.check.group-name");

    // Medicine routes
    Route::get("/medicine-list", [MedicineController::class,"medicineListPage"])->name("dashboard.medicine-list");
    Route::get("/get-medicine-list", [MedicineController::class,"getMedicineList"])->name("dashboard.get-medicine-list");
    Route::get("/active-medicine", [MedicineController::class,"activeMedicine"]);
    Route::get("/active-medicine-list", [MedicineController::class,"activeMedicineList"])->name("dashboard.active-medicine-list");
    Route::get("/inactive-medicine", [MedicineController::class,"inactiveMedicine"]);
    Route::get("/inactive-medicine-list", [MedicineController::class,"inactiveMedicineList"])->name("dashboard.inactive-medicine-list");
    Route::get("/deleted-medicine", [MedicineController::class,"deletedMedicine"]);
    Route::get("/deleted-medicine-list", [MedicineController::class,"deletedMedicineList"])->name("dashboard.deleted-medicine-list");
    Route::get("/create-medicine", [MedicineController::class,"createMedicinePage"]);
    Route::post("/create-medicine", [MedicineController::class,"createMedicine"])->name("dashboard.create.medicine");
    Route::get("/edit-medicine/{id}", [MedicineController::class,"editMedicine"])->name("dashboard.edit-medicine");
    Route::post("/update-medicine", [MedicineController::class,"updateMedicine"])->name("dashboard.update.medicine");
    Route::delete("/delete-medicine/{id}", [MedicineController::class,"deleteMedicine"])->name("dashboard.delete.medicine");
    Route::delete("/medicine-inactive/{id}", [MedicineController::class,"medicineInactive"])->name("dasboard.medicine-inactive");
    Route::get("/medicine-active/{id}", [MedicineController::class,"medicineActive"])->name("dasboard.medicine-active");
    Route::get("/medicine-restore/{id}", [MedicineController::class,"medicineRestore"])->name("dasboard.medicine-restore");
    Route::get("/check-medicine-name", [MedicineController::class,"checkMedicineName"])->name("dashboard.check.medicine-name");

    // medicine Type routes
    Route::get("/medicine-type-list", [MedicineTypeController::class,"medicineTypeListPage"])->name("dashboard.medicine-type-list");
    Route::get("/get-medicine-type-list", [MedicineTypeController::class,"getMedicineTypeList"])->name("dashboard.get-medicine-type-list");
    Route::get("/active-medicine-type", [MedicineTypeController::class,"activeMedicineType"]);
    Route::get("/active-medicine-type-list", [MedicineTypeController::class,"activeMedicineTypeList"])->name("dashboard.active-medicine-type-list");
    Route::get("/inactive-medicine-type", [MedicineTypeController::class,"inactiveMedicineType"]);
    Route::get("/inactive-medicine-type-list", [MedicineTypeController::class,"inactiveMedicineTypeList"])->name("dashboard.inactive-medicine-type-list");
    Route::get("/deleted-medicine-type", [MedicineTypeController::class,"deletedMedicineType"]);
    Route::get("/deleted-medicine-type-list", [MedicineTypeController::class,"deletedMedicineTypeList"])->name("dashboard.deleted-medicine-type-list");
    Route::get("/create-medicine-type", [MedicineTypeController::class,"createMedicineTypePage"]);
    Route::post("/create-medicine-type", [MedicineTypeController::class,"createMedicineType"])->name("dashboard.create.medicine-type");
    Route::get("/edit-medicine-type/{id}", [MedicineTypeController::class,"editMedicineType"])->name("dashboard.edit-medicine-type");
    Route::post("/update-medicine-type", [MedicineTypeController::class,"updateMedicineType"])->name("dashboard.update.medicine-type");
    Route::delete("/delete-medicine-type/{id}", [MedicineTypeController::class,"deleteMedicineType"])->name("dashboard.delete.medicine-type");
    Route::delete("/medicine-type-inactive/{id}", [MedicineTypeController::class,"medicineTypeInactive"])->name("dasboard.medicine-type-inactive");
    Route::get("/medicine-type-active/{id}", [MedicineTypeController::class,"medicineTypeActive"])->name("dasboard.medicine-type-active");
    Route::get("/medicine-type-restore/{id}", [MedicineTypeController::class,"medicineTypeRestore"])->name("dasboard.medicine-type-restore");
    Route::get("/check-medicine-type-name", [MedicineTypeController::class,"checkMedicineTypeName"])->name("dashboard.check.medicine-type-name");

     // Disease routes
     Route::get("/disease-list", [DiseasesController::class,"diseaseListPage"])->name("dashboard.disease-list");
     Route::get("/get-disease-list", [DiseasesController::class,"getDiseaseList"])->name("dashboard.get-disease-list");
     Route::get("/active-disease", [DiseasesController::class,"activeDisease"])->name("dashboard.active-disease");
     Route::get("/active-disease-list", [DiseasesController::class,"activeDiseaseList"])->name("dashboard.active-disease-list");
     Route::get("/inactive-disease", [DiseasesController::class,"inactiveDisease"]);
     Route::get("/inactive-disease-list", [DiseasesController::class,"inactiveDiseaseList"])->name("dashboard.inactive-disease-list");
     Route::get("/deleted-disease", [DiseasesController::class,"deletedDisease"]);
     Route::get("/deleted-disease-list", [DiseasesController::class,"deletedDiseaseList"])->name("dashboard.deleted-disease-list");
     Route::get("/create-disease", [DiseasesController::class,"createDiseasePage"]);
     Route::post("/create-disease", [DiseasesController::class,"createDisease"])->name("dashboard.create.disease");
     Route::get("/edit-disease/{id}", [DiseasesController::class,"editDisease"])->name("dashboard.edit-disease");
     Route::post("/update-disease", [DiseasesController::class,"updateDisease"])->name("dashboard.update.disease");
     Route::delete("/delete-disease/{id}", [DiseasesController::class,"deleteDisease"])->name("dashboard.delete.disease");
     Route::delete("/disease-inactive/{id}", [DiseasesController::class,"diseaseInactive"])->name("dasboard.disease-inactive");
     Route::get("/disease-active/{id}", [DiseasesController::class,"diseaseActive"])->name("dasboard.disease-active");
     Route::get("/disease-restore/{id}", [DiseasesController::class,"diseaseRestore"])->name("dasboard.disease-restore");
     Route::get("/check-disease-name", [DiseasesController::class,"checkDiseaseName"])->name("dashboard.disease-check-name");

     // Medical Test routes
     Route::get("/medical-test-list", [MedicalTestsController::class,"medicalTestListPage"])->name("dashboard.medical-test-list");
     Route::get("view-medical-test/{id}", [MedicalTestsController::class,"viewMedicalTest"])->name("dashboard.view-medical-test");
     Route::get("/get-medical-test-list", [MedicalTestsController::class,"getMedicalTestList"])->name("dashboard.get-medical-test-list");
     Route::get("/active-medical-test", [MedicalTestsController::class,"activeMedicalTest"]);
     Route::get("/active-medical-test-list", [MedicalTestsController::class,"activeMedicalTestList"])->name("dashboard.active-medical-test-list");
     Route::get("/inactive-medical-test", [MedicalTestsController::class,"inactiveMedicalTest"]);
     Route::get("/inactive-medical-test-list", [MedicalTestsController::class,"inactiveMedicalTestList"])->name("dashboard.inactive-medical-test-list");
     Route::get("/deleted-medical-test", [MedicalTestsController::class,"deletedMedicalTest"]);
     Route::get("/deleted-medical-test-list", [MedicalTestsController::class,"deletedMedicalTestList"])->name("dashboard.deleted-medical-test-list");
     Route::get("/create-medical-test", [MedicalTestsController::class,"createMedicalTestPage"]);
     Route::post("/create-medical-test", [MedicalTestsController::class,"createMedicalTest"])->name("dashboard.create.medical-test");
     Route::get("/edit-medical-test/{id}", [MedicalTestsController::class,"editMedicalTest"])->name("dashboard.edit-medical-test");
     Route::post("/update-medical-test", [MedicalTestsController::class,"updateMedicalTest"])->name("dashboard.update.medical-test");
     Route::delete("/delete-medical-test/{id}", [MedicalTestsController::class,"deleteMedicalTest"])->name("dashboard.delete.medical-test");
     Route::delete("/medical-test-inactive/{id}", [MedicalTestsController::class,"medicalTestInactive"])->name("dasboard.medical-test-inactive");
     Route::get("/medical-test-active/{id}", [MedicalTestsController::class,"medicalTestActive"])->name("dasboard.medical-test-active");
     Route::get("/medical-test-restore/{id}", [MedicalTestsController::class,"medicalTestRestore"])->name("dasboard.medical-test-restore");
     Route::get("/check-medical-test-name", [MedicalTestsController::class,"checkMedicalTestName"])->name("dashboard.medical-test-check-name");

     // patient vandor routes
     Route::get("/patient-vandor-list", [PatientVandorController::class,"patientVandorListPage"])->name("dashboard.patient-vandor-list");
     Route::get("/get-vandor-patients", [PatientVandorController::class,"getPatientVandor"])->name("dashboard.get-vandor-patients");
     Route::get("/patient-vandor-list", [PatientVandorController::class,"patientVandorListPage"])->name("dashboard.patient-vandor-list");
     Route::get("/get-patient-vandor-list", [PatientVandorController::class,"getPatientVandorList"])->name("dashboard.get-patient-vandor-list");
     Route::get("/active-patient-vandor", [PatientVandorController::class,"activePatientVandor"]);
     Route::get("/active-patient-vandor-list", [PatientVandorController::class,"activePatientVandorList"])->name("dashboard.active-patient-vandor-list");
     Route::get("/inactive-patient-vandor", [PatientVandorController::class,"inactivePatientVandor"]);
     Route::get("/inactive-patient-vandor-list", [PatientVandorController::class,"inactivePatientVandorList"])->name("dashboard.inactive-patient-vandor-list");
     Route::get("/deleted-patient-vandor", [PatientVandorController::class,"deletedPatientVandor"]);
     Route::get("/deleted-patient-vandor-list", [PatientVandorController::class,"deletedPatientVandorList"])->name("dashboard.deleted-patient-vandor-list");
     Route::get("/create-patient-vandor", [PatientVandorController::class,"createPatientVandorPage"]);
     Route::post("/create-patient-vandor", [PatientVandorController::class,"createPatientVandor"])->name("dashboard.create-patient-vandor");
     Route::get("/edit-patient-vandor/{id}", [PatientVandorController::class,"editPatientVandor"])->name("dashboard.edit-patient-vandor");
     Route::post("/update-patient-vandor", [PatientVandorController::class,"updatePatientVandor"])->name("dashboard.update-patient-vandor");
     Route::delete("/delete-patient-vandor/{id}", [PatientVandorController::class,"deletePatientVandor"])->name("dashboard.delete-patient-vandor");
     Route::delete("/patient-vandor-inactive/{id}", [PatientVandorController::class,"patientVandorInactive"])->name("dasboard.patient-vandor-inactive");
     Route::get("/patient-vandor-active/{id}", [PatientVandorController::class,"patientVandorActive"])->name("dasboard.patient-vandor-active");
     Route::get("/patient-vandor-restore/{id}", [PatientVandorController::class,"patientVandorRestore"])->name("dasboard.patient-vandor-restore");
     Route::get("/view-patient-vandor/{id}", [PatientVandorController::class,"viewPatientVandor"])->name("dashboard.view-patient-vandor");
     Route::get("/view-patient-vandor/{id}", [PatientVandorController::class,"viewPatientVandor"])->name("dashboard.view-patient-vandor");

     // prescritions routes
     Route::get("/new-prescritions", [PrescritionsController::class,"newPrescritionsPage"])->name("dashboard.new-prescritions");
     Route::get("/doses-by-type/{id}", [PrescritionsController::class,"dosesByType"])->name("dashboard.doses-by-type");
     Route::post("/add-prescritions-medicine", [PrescritionsController::class,"postAddToCart"])->name("dashboard.add-prescritions-medicine");
     Route::post("/display-prescritions-medicine", [PrescritionsController::class,"postDisplayToCart"])->name("dashboard.display-prescritions-medicine");
     Route::post("/remove-prescritions-medicine", [PrescritionsController::class,"postRemoveToCart"])->name("dashboard.remove-prescritions-medicine");
     Route::post("/save-prescription", [PrescritionsController::class,"postSavePrescription"])->name("dashboard.save-prescription");
     Route::get("/prescritions-list", [PrescritionsController::class,"prescritionsListPage"])->name("dashboard.prescritions-list");
     Route::get("/get-prescritions-list", [PrescritionsController::class,"getPrescritionsList"])->name("dashboard.get-prescritions-list");
     Route::get("/view-prescritions/{id}/{data}", [PrescritionsController::class,"viewPrescriptions"])->name("dashboard.view-prescritions");
}); 

// user routes outside the dashboard
Route::get("/login", [UserController::class,"userLoginPage"]);
Route::get("/send-Otp",[UserController::class,"SendOtpPage"]);
Route::post("/send-Otp",[UserController::class,"sendOtp"])->name("send-otp");
Route::get("/verify-otp",[UserController::class,"VerifyOTPPage"])->name("verify-otp");
Route::post("/verify-otp",[UserController::class, "VerifyOTP"])->name("verify-otp");
Route::get("/password-reset",[UserController::class,"ResetPasswordPage"])->middleware([ResetPassTokenVerificationMiddleware::class]);
Route::post("/password-reset",[UserController::class,"ResetPassword"])->name("reset-password")->middleware([ResetPassTokenVerificationMiddleware::class]);
Route::post('/login', [UserController::class, 'userLogin'])->name('login');
Route::get('/user-login', [UserController::class, 'patientLoginPage']);
Route::get('/patient-verify-otp', [UserController::class, 'patientVerifyOtpPage'])->name("patient-verify-otp");
Route::post("/user-login", [UserController::class,"patientLogin"])->name("user-login");
Route::post("/patient-verify-otp", [UserController::class,"patientVerifyOtp"])->name("patient-verify-otp");

### Log Route ###
Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);