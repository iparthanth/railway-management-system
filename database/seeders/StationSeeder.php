<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    public function run()
    {
        $stations = [
            ['name' => 'Dhaka', 'code' => 'DHA', 'division' => 'Dhaka'],
            ['name' => 'Dhaka_Cantonment', 'code' => 'DHAC', 'division' => 'Dhaka'],
            ['name' => 'Chattogram', 'code' => 'CTG', 'division' => 'Chattogram'],
            ['name' => 'Sylhet', 'code' => 'SYL', 'division' => 'Sylhet'],
            ['name' => 'Rajshahi', 'code' => 'RAJ', 'division' => 'Rajshahi'],
            ['name' => 'Rangpur', 'code' => 'RAN', 'division' => 'Rangpur'],
            ['name' => 'Khulna', 'code' => 'KHU', 'division' => 'Khulna'],
            ['name' => 'Barisal', 'code' => 'BAR', 'division' => 'Barisal'],
            ['name' => 'Mymensingh', 'code' => 'MYM', 'division' => 'Mymensingh'],
            ['name' => 'Noakhali', 'code' => 'NOA', 'division' => 'Chattogram'],
            ['name' => 'Noapara', 'code' => 'NOAP', 'division' => 'Chattogram'],
            ['name' => 'Gachihata', 'code' => 'GAC', 'division' => 'Dhaka'],
            ['name' => 'Gafargaon', 'code' => 'GAF', 'division' => 'Mymensingh'],
            ['name' => 'Gaibandha', 'code' => 'GAI', 'division' => 'Rangpur'],
            ['name' => 'Chakaria', 'code' => 'CHA', 'division' => 'Chattogram'],
            ['name' => 'Chandpur', 'code' => 'CHAN', 'division' => 'Chattogram'],
            ['name' => 'Chandpur_Court', 'code' => 'CHANC', 'division' => 'Chattogram'],
            ['name' => 'Chapainawabganj', 'code' => 'CHAP', 'division' => 'Rajshahi'],
            ['name' => 'Chatmohar', 'code' => 'CHAT', 'division' => 'Rajshahi'],
            ['name' => 'Chilahati', 'code' => 'CHI', 'division' => 'Rangpur'],
            ['name' => 'Chirirbandar', 'code' => 'CHIR', 'division' => 'Rangpur'],
            ['name' => 'Choumuhani', 'code' => 'CHOU', 'division' => 'Chattogram'],
            ['name' => 'Chuadanga', 'code' => 'CHUA', 'division' => 'Khulna'],
            ['name' => 'Dohazari', 'code' => 'DOH', 'division' => 'Chattogram'],
            ['name' => 'Domar', 'code' => 'DOM', 'division' => 'Rangpur'],
            ['name' => 'Hajiganj', 'code' => 'HAJ', 'division' => 'Chattogram'],
            ['name' => 'Harashpur', 'code' => 'HAR', 'division' => 'Dhaka'],
            ['name' => 'Hasanpur', 'code' => 'HAS', 'division' => 'Dhaka'],
            ['name' => 'Hatibandha', 'code' => 'HAT', 'division' => 'Rangpur'],
            ['name' => 'Ishwardi', 'code' => 'ISH', 'division' => 'Rajshahi'],
            ['name' => 'Ishwardi_Bypass', 'code' => 'ISHB', 'division' => 'Rajshahi'],
            ['name' => 'ISLAMABAD', 'code' => 'ISL', 'division' => 'Dhaka'],
            ['name' => 'Islampur_Bazar', 'code' => 'ISLB', 'division' => 'Dhaka'],
            ['name' => 'Bhairab_Bazar', 'code' => 'BHA', 'division' => 'Dhaka'],
            ['name' => 'Bhanga', 'code' => 'BHAN', 'division' => 'Dhaka'],
            ['name' => 'Bhanga_Junction', 'code' => 'BHANJ', 'division' => 'Dhaka'],
            ['name' => 'Bhanugach', 'code' => 'BHANU', 'division' => 'Sylhet'],
            ['name' => 'Bheramara', 'code' => 'BHE', 'division' => 'Khulna'],
            ['name' => 'Bhuapur', 'code' => 'BHU', 'division' => 'Mymensingh'],
            ['name' => 'Faridpur', 'code' => 'FAR', 'division' => 'Dhaka'],
            ['name' => 'Ashuganj', 'code' => 'ASH', 'division' => 'Dhaka'],
            ['name' => 'Dinajpur', 'code' => 'DIN', 'division' => 'Rangpur'],
            ['name' => 'Jamalpur_Town', 'code' => 'JAM', 'division' => 'Mymensingh'],
            ['name' => 'Jamtail', 'code' => 'JAMT', 'division' => 'Mymensingh'],
            ['name' => 'Janali_Hat', 'code' => 'JAN', 'division' => 'Mymensingh'],
            ['name' => 'Jashore', 'code' => 'JAS', 'division' => 'Khulna'],
            ['name' => 'Nachole', 'code' => 'NAC', 'division' => 'Rajshahi'],
            ['name' => 'Nandina', 'code' => 'NAN', 'division' => 'Rajshahi'],
            ['name' => 'Nangolkot', 'code' => 'NANG', 'division' => 'Chattogram'],
            ['name' => 'Narail', 'code' => 'NAR', 'division' => 'Khulna'],
            ['name' => 'Narsingdi', 'code' => 'NARS', 'division' => 'Dhaka'],
            ['name' => 'Narundi', 'code' => 'NARU', 'division' => 'Dhaka'],
            ['name' => 'Natore', 'code' => 'NAT', 'division' => 'Rajshahi'],
            ['name' => 'Nayapara', 'code' => 'NAYA', 'division' => 'Dhaka'],
        ];

        foreach ($stations as $station) {
            Station::create($station);
        }
    }
}
