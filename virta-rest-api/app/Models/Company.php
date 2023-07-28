<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'parent_company_id'];

    public function parent()
    {
        return $this->belongsTo(Company::class, 'parent_company_id');
    }

    public function children()
    {
        return $this->hasMany(Company::class, 'parent_company_id');
    }

    public function stations()
    {
        return $this->hasMany(Station::class);
    }

    public function getStationsGroupedByLocation($latitude, $longitude, $radiusInMeters)
    {
        $stations = $this->getStationsRecursive($this, $latitude, $longitude, $radiusInMeters);

        // Group stations by $latitude, $longitude
        // $groupedStations = $stations->groupBy(['latitude', 'longitude'])->values();
        $groupedStations = $stations->mapToGroups(function ($station) {
            return [sprintf('%f,%f', $station->latitude, $station->longitude) => $station];
        });


        // Sort stations by distance
        $groupedStations = $groupedStations->map(function ($group) {
            return $group->sortBy('distance');
        });

        return $groupedStations;
    }

    private function getStationsRecursive($company, $latitude, $longitude, $radiusInMeters)
    {
        // get $stations using SQL ST_DISTANCE_SPHERE geometry function 
        $stations = $company->stations()
        ->whereHas('company', function ($query) use ($latitude, $longitude, $radiusInMeters) {
            $query->whereRaw("ST_DISTANCE_SPHERE(POINT(longitude, latitude), POINT($longitude, $latitude)) <= ?", [$radiusInMeters]);
        })
        ->get();

        $children = $company->children;
        foreach ($children as $child) {
            $childStations = $this->getStationsRecursive($child, $latitude, $longitude, $radiusInMeters);
            $stations = $stations->merge($childStations);
        }

        return $stations;
    }

}