<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SuratKeluar>
 */
class SuratKeluarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 1. Variabel static untuk menjaga urutan di memori selama eksekusi ini
        static $currentNumber = null;

        // 2. Jika ini adalah data pertama dalam antrean, intip DB
        if ($currentNumber === null) {
            $lastDbNumber = \App\Models\SuratKeluar::where('tahun', 2026)->max('nomor_urut') ?? 0;
            $currentNumber = $lastDbNumber + 1;
        } else {
            // 3. Jika bukan data pertama, cukup naikkan angka yang ada di memori
            $currentNumber++;
        }

        return [
            'session_token'     => Str::random(40),
            'status_isi'        => 'pending',
            'whatsapp_number'   => $this->faker->phoneNumber(),
            'nomor_urut'        => $currentNumber,
            'nomor_lengkap'     => sprintf('%03d/DISKOMINFOS/2026', $currentNumber),
            'tahun'             => 2026,
            'kode_surat'        => $this->faker->randomElement(['BA', 'UND', 'S-KET']),
            'tujuan'            => $this->faker->company(),
            'tgl_surat'         => now()->format('Y-m-d'),
            'expired_at'        => now()->addDays(2), 
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }
}

// \App\Models\SuratKeluar::factory(10)->create(); // Contoh penggunaan di seeder atau tinker