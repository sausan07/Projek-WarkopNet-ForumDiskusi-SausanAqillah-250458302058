<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class UserWeeklyChart extends ChartWidget
{
    protected ?string $heading = 'User Mingguan';

    //ambil data
    protected function getData(): array
    {
        $labels = []; //simpan hari
        $data = [];   //simpan jumlah user yg daftar

        Carbon::setLocale('id'); //set ke hari indo

        //loop dari 6 hari lalu sampai hari ini (total 7 hari)
        for ($i = 6; $i >= 0; $i--) {

            //smbil tanggal hari ini dikurangi $i hari
            $date = Carbon::today()->subDays($i);

            $labels[] = $date->locale('id')->translatedFormat('D');

            //hitung jumlah user yang daftar pada tanggal tersebut
            $data[] = User::whereDate('created_at', $date)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'User Register', //label grafik
                    'data' => $data,            //hasil hitungan
                    'backgroundColor' => '#0046FF', 
                    'borderRadius' => 6,      
                ],
            ],
            'labels' => $labels, //label pada sumbu x 
        ];
    }

    //tipe chart = bar chart
    protected function getType(): string
    {
        return 'bar';
    }

    protected function getHeight(): ?int
    {
        return 600; // tinggi
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,            //grafik responsif
            'maintainAspectRatio' => false,  //boleh melebar-tinggi bebas

            'plugins' => [
                'legend' => [
                    'display' => true,       //tampilkan legend
                    'position' => 'bottom',  //letakkan di bawah grafik
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,   // mulai dari angka 0
                    'ticks' => [
                        'precision' => 0,    // angka tanpa koma
                    ],
                ],
            ],
        ];
    }
}
