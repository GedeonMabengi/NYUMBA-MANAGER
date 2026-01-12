<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Rental;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_bailleurs' => User::query()->bailleurs()->count(),
            'total_avocats' => User::query()->avocats()->count(),
            'total_properties' => Property::count(),
            'total_rentals' => Rental::active()->count(),
            'property_types' => PropertyType::count(),
        ];

        $recentBailleurs = User::query()->bailleurs()->latest()->take(5)->get();
        $recentProperties = Property::with(['owner', 'propertyType'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentBailleurs', 'recentProperties'));
    }
}











// ce code marche quand meme <?php
// app/Http\Controllers\Admin\DashboardController.php - Version simple

// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use App\Models\User;
// use App\Models\Property;
// use App\Models\PropertyType;
// use App\Models\Rental;
// use App\Models\Tenant;

// class DashboardController extends Controller
// {
//     public function index()
//     {
//         // Version ultra simple - sans erreur
//         $stats = [
//             'total_bailleurs' => User::where('role', 'bailleur')->count(),
//             'total_avocats' => User::where('role', 'avocat')->count(),
//             'total_properties' => Property::count(),
//             'total_rentals' => Rental::where('status', 'active')->count(),
//             'total_tenants' => Tenant::count(),
//             'property_types' => PropertyType::count(),
//         ];

//         // Données récentes simples
//         $recentBailleurs = User::where('role', 'bailleur')
//             ->latest()
//             ->take(5)
//             ->get();

//         $recentProperties = Property::with('owner')
//             ->latest()
//             ->take(5)
//             ->get();

//         return view('admin.dashboard', compact(
//             'stats',
//             'recentBailleurs',
//             'recentProperties'
//         ));
//     }
// }














// app/Http/Controllers/Admin/DashboardController.php

// namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
// use App\Models\User;
// use App\Models\Property;
// use App\Models\PropertyType;
// use App\Models\Rental;

// class DashboardController extends Controller
// {
//     public function index()
//     {
//         $stats = [
//             'total_bailleurs' => User::bailleurs()->count(),
//             'total_avocats' => User::avocats()->count(),
//             'total_properties' => Property::count(),
//             'total_rentals' => Rental::active()->count(),
//             'property_types' => PropertyType::count(),
//         ];

//         $recentBailleurs = User::bailleurs()->latest()->take(5)->get();
//         $recentProperties = Property::with(['owner', 'propertyType'])->latest()->take(5)->get();

//         return view('admin.dashboard', compact('stats', 'recentBailleurs', 'recentProperties'));
//     }
// }