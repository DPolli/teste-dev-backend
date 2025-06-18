<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\TemperatureData;
use Carbon\Carbon;
use Throwable;

class ImportTemperatureDataCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle(): void
    {
        dd($this);
        if (!Storage::exists($this->filePath)) {
            Log::error("Arquivo CSV não encontrado");
            return;
        }

        $file = Storage::readStream($this->filePath);

        DB::transaction(function () use ($file) {
            $lineNumber = 0;

            while (($row = fgetcsv($file, 1000, ' ')) !== FALSE) {
                $lineNumber++;

                if ($lineNumber === 1) {
                    continue;
                }

                if (is_array($row) && count($row) >= 3 && !empty(array_filter($row))) {
                    $dateTimeString = trim($row[0] . ' ' . $row[1]);
                    $temperatureString = trim($row[2]);

                    try {
                        $timestamp = Carbon::parse($dateTimeString);
                        $temperature = (float) str_replace(',', '.', $temperatureString);

                        TemperatureData::updateOrCreate(
                            ['date' => $timestamp],
                            ['value' => $temperature]
                        );
                    } catch (\Exception $e) {
                        Log::error($e->getMessage());
                    }
                }
            }
        });

        fclose($file);
        Storage::delete($this->filePath);
    }

    public function failed(Throwable $exception): void
    {
        Log::error("A importação falhou: {$exception->getMessage()}");
    }
}
