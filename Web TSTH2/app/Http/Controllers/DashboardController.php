<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\BarangService;
use App\Services\JenisBarangService;
use App\Services\SatuanService;
// use App\Services\UserService;
use App\Services\GudangService;

class DashboardController extends Controller
{
    protected $barangService;
    protected $jenisBarangService;
    protected $satuanService;
    protected $userService;
    protected $gudangService;

    public function __construct(
        BarangService $barangService,
        JenisBarangService $jenisBarangService,
        SatuanService $satuanService,
        // UserService $userService,
        GudangService $gudangService
    ) {
        $this->barangService = $barangService;
        $this->jenisBarangService = $jenisBarangService;
        $this->satuanService = $satuanService;
        // $this->userService = $userService;
        $this->gudangService = $gudangService;
    }

    public function index()
    {
        $user = Session::get('user');
        $permissions = Session::get('permissions', []);

        if (!in_array('dashboard.view', $permissions)) {
            abort(403, 'Unauthorized access to dashboard');
        }

        // Fetch counts from API services
        $counts = [
            'barangs' => $this->getCountFromApi($this->barangService, 'getAllBarang'),
            'jenisbarangs' => $this->getCountFromApi($this->jenisBarangService, 'get_all_jenis_barang'),
            'satuans' => $this->getCountFromApi($this->satuanService, 'get_all_satuan'),
            'gudangs' => $this->getCountFromApi($this->gudangService, 'get_all_gudang'),
            // We'll skip users count since there's no endpoint for it
            'users' => 0, // Default to 0 since we can't get this count
            'statuses' => 0, // Not in your API routes
            'jenistransaksis' => 0, // Not in your API routes
        ];

        return view('Admin.Dashboard.dashboard', array_merge([
            'user' => $user,
            'permissions' => $permissions
        ], $counts));
    }

    protected function getCountFromApi($service, $method)
    {
        try {
            $data = $service->$method();
            return is_countable($data) ? count($data) : 0;
        } catch (\Exception $e) {
            // Log error or handle it as needed
            return 0; // Return 0 if there's an error
        }
    }
}