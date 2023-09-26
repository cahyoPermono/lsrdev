<?php
namespace App\Services\MedcoApi;

class PWTIssuerService
{
     private $availableStatus = ['Printed', 'Issued', 'Activated', 'Close', 'On-Hold', 'Waiting Re-Issue'];

     public function findByPid($pid)
     {
          return [
               'pid' => $pid,
               'wp_number' => '10-' . date('Y-M-d'),
               'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
               'job_location' => fake()->address(),
               'status' => $this->availableStatus[rand(0, count($this->availableStatus) - 1)]
          ];
     }

     public function findAllWLByPidAndCode($pid, $code)
     {
          return [
               'date' => date('Y-m-d'),
               'image' => 'https://laz-img-cdn.alicdn.com/images/ims-web/TB1LLFTsljTBKNjSZFuXXb0HFXa.jpg_1200x1200.jpg',
               'items' => $this->findAllWlItem($pid, $code)
          ];
     }

     private function findAllWlItem($pid, $code)
     {
          $items = [];
          for ($i = 0; $i < 5; $i++) {
               $items[] = [
                    'permit_wan' => rand(111, 9999),
                    'status' => $this->availableStatus[rand(0, count($this->availableStatus) - 1)]
               ];
          }
          return $items;
     }
}