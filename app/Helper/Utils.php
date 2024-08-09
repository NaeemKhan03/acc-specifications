<?php

use Illuminate\Support\Facades\DB;

function copyCoreSpecs()
{
    try {
        $lastRecord = DB::connection('specs')->table('vehicle_specs_values')->orderByDesc('id')->first();
        $last_id = $lastRecord->id ?? 0;
        $specifications =  DB::connection('coincars')->table('vehicle_specs_values')->where('id', '>', $last_id)->limit(5000)->get();
        $get_specifications = array();
        $result = array();
        $get_specifications = json_decode(json_encode($specifications), True);
        foreach ($get_specifications as $specification) {
            $settings =  DB::connection('coincars')->table('general_settings')
                ->where('table_name', 'specifications')->where('name', $specification['spec_category'])->first();
            $specification['spec_category_id'] = $settings->id ?? 0;
            unset($specification['spec_category']);
            $result[] = $specification;
        }
        $lastRecord = DB::connection('specs')->table('vehicle_specs_values')->insert($result);
    } catch (Exception $e) {
        dd($e);
    }
}
