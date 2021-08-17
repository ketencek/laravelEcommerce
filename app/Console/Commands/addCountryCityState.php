<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Console\Command;

class addCountryCityState extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:addCountryCityState';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'add Country City State with json file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $c_s_c_json = file_get_contents(public_path() . '\admins\countries+states+cities.json');

        $c_s_c_array = json_decode($c_s_c_json, true);
        foreach ($c_s_c_array as $country_json) {
            $country = Country::withoutGlobalScope('status')->where('country_code', $country_json['iso2'])->first();
            if (!$country) {
                $country = new Country();
                $country->name = $country_json['name'];
                $country->currency = $country_json['currency'];
                $country->currency_symbol = $country_json['currency_symbol'];
                $country->phone_code = $country_json['phone_code'];
                $country->country_code = $country_json['iso2'];
                $country->latitude = $country_json['latitude'];
                $country->longitude = $country_json['longitude'];
                $country->save();
            }
            $country_id = $country->id;

            foreach ($country_json['states'] as $states) {
                $state = State::withoutGlobalScope('status')->where('country_id', $country_id)->where('state_code', $states['state_code'])->first();
                if (!$state) {
                    $state = new State();
                    $state->name = $states['name'];
                    $state->country_id = $country_id;
                    $state->state_code = $states['state_code'];
                    $state->latitude = $states['latitude'];
                    $state->longitude = $states['longitude'];
                    $state->status =1;
                    $state->save();
                }
                $state_id = $state->id;
                foreach ($states["cities"] as $cities) {
                    $city = City::withoutGlobalScope('status')->where('country_id', $country_id)->where('name', $cities['name'])->where('state_id', $state_id)->first();
                    if (!$city) {
                        $city = new City();
                        $city->country_id = $country_id;
                        $city->state_id = $state_id;
                        $city->name = $cities['name'];
                        $city->latitude = $cities['latitude'];
                        $city->longitude = $cities['longitude'];
                        $city->status =1;
                        $city->save();
                    }
                    echo " Country : ".$country_json['name'] . " State : ".$state['name'] . " City : ".$cities['name'] ;
                    echo "\n";
                }
            }
        }
    }
}
