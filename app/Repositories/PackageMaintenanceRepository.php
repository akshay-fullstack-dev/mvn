<?php

namespace App\Repositories;

use App\Models\PackageMaintain;
use App\Repositories\GenericRepository;
use App\Exceptions\RecordNotFoundException;
use App\Repositories\Interfaces\IPackageMaintenanceRepository;

class PackageMaintenanceRepository extends GenericRepository implements IPackageMaintenanceRepository
{
    const paginationCount = 10;
    public function model()
    {
        return PackageMaintain::class;
    }

    public function getPackagemaintenanceData($id)
    {
        $items_per_page = 10;
        $page = 1;

        
            return $this->model()::where(['user_id' => $id])
                    ->with([
                        'packages.package_services.service',
                        'bookings.booking_vehicle',
                        'bookings.booking_payment'
            ])->get();

    }
    public function getpackageservice($package_servicesID){
        // dd($package_servicesID);
     $service_ids = array();
        $packageServices =   $this->model()::where(['package_id'=>$package_servicesID])
        ->with(['packages.package_services.service'])->first();
           
        if(!$packageServices->packages){
            throw new RecordNotFoundException('invalid payment id');
        }

      //  dd($packageServices);
        foreach($packageServices->packages->package_services as $service){


            array_push($service_ids , $service['service_id']);
        }

        return $service_ids;
    }

}
