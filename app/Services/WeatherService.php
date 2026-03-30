<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Weather Service using Open-Meteo API (no API key required)
 * https://open-meteo.com/
 */
class WeatherService
{
    protected $baseUrl = 'https://api.open-meteo.com/v1/forecast';

    /**
     * Get weather forecast for a specific location and date
     * 
     * @param float $latitude Latitude
     * @param float $longitude Longitude
     * @param string $date Date in Y-m-d format
     * @return array Weather data
     */
    public static function getForecast(float $latitude, float $longitude, string $date = null): array
    {
        try {
            $date = $date ?? now()->toDateString();
            
            $response = Http::get('https://api.open-meteo.com/v1/forecast', [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'current' => 'temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m',
                'daily' => 'weather_code,temperature_2m_max,temperature_2m_min,precipitation_probability_max',
                'timezone' => 'Europe/Madrid',
                'forecast_days' => 7,
            ]);

            if (!$response->successful()) {
                Log::error('Open-Meteo API error: ' . $response->status());
                return self::getDefaultData();
            }

            $data = $response->json();
            
            // Find the day matching the requested date
            $daily = $data['daily'] ?? [];
            $current = $data['current'] ?? [];
            
            $dayIndex = array_search($date, $daily['time'] ?? []);
            
            if ($dayIndex === false || $dayIndex === -1) {
                // If date not found, use current weather
                return self::parseCurrentWeather($current);
            }

            return self::parseDailyWeather($daily, $dayIndex, $current);
            
        } catch (\Exception $e) {
            Log::error('WeatherService error: ' . $e->getMessage());
            return self::getDefaultData();
        }
    }

    /**
     * Get weather for a stadium (using Valencia coordinates as default)
     * You can extend this to store coordinates in the stadium model
     */
    public static function getStadiumWeather($estadi, string $date = null): array
    {
        // Coordinates for stadiums (you can add these to the database)
        $stadiums = [
            'Camp Nou' => ['lat' => 41.3809, 'lon' => 2.1228],
            'Wanda Metropolitano' => ['lat' => 40.4362, 'lon' => -3.5995],
            'Santiago Bernabéu' => ['lat' => 40.4530, 'lon' => -3.6883],
            'Ciutat de València' => ['lat' => 39.4753, 'lon' => -0.3589],
        ];

        $nom = $estadi->nom ?? '';
        $coords = $stadiums[$nom] ?? ['lat' => 39.4699, 'lon' => -0.3763]; // Valencia default

        return self::getForecast($coords['lat'], $coords['lon'], $date);
    }

    /**
     * Parse current weather data
     */
    private static function parseCurrentWeather(array $current): array
    {
        return [
            'temperature' => $current['temperature_2m'] ?? 15,
            'humidity' => $current['relative_humidity_2m'] ?? 60,
            'weather_code' => $current['weather_code'] ?? 0,
            'weather_description' => self::getWeatherDescription($current['weather_code'] ?? 0),
            'wind_speed' => $current['wind_speed_10m'] ?? 10,
            'rain_probability' => 0,
            'is_rainy' => false,
        ];
    }

    /**
     * Parse daily weather data
     */
    private static function parseDailyWeather(array $daily, int $dayIndex, array $current): array
    {
        $weatherCode = $daily['weather_code'][$dayIndex] ?? $current['weather_code'] ?? 0;
        $rainProb = $daily['precipitation_probability_max'][$dayIndex] ?? 0;
        
        return [
            'temperature' => $daily['temperature_2m_max'][$dayIndex] ?? 15,
            'temperature_min' => $daily['temperature_2m_min'][$dayIndex] ?? 10,
            'humidity' => $current['relative_humidity_2m'] ?? 60,
            'weather_code' => $weatherCode,
            'weather_description' => self::getWeatherDescription($weatherCode),
            'wind_speed' => $current['wind_speed_10m'] ?? 10,
            'rain_probability' => $rainProb,
            'is_rainy' => $rainProb > 50,
        ];
    }

    /**
     * Get weather description from WMO code
     * https://open-meteo.com/en/docs
     */
    private static function getWeatherDescription(int $code): string
    {
        $codes = [
            0 => 'Cel clar',
            1, 2, 3 => 'Ennuvolat',
            45, 48 => 'Boira',
            51, 53, 55 => 'Plugim',
            61, 63, 65 => 'Pluja',
            66, 67 => 'Pluja gelada',
            71, 73, 75 => 'Neu',
            77 => 'Grans de neu',
            80, 81, 82 => 'Xàfecs',
            85, 86 => 'Neu amb xàfecs',
            95 => 'Tempesta',
            96, 99 => 'Tempesta amb calamarsa',
        ];

        return $codes[$code] ?? 'Desconegut';
    }

    /**
     * Default data when API fails
     */
    private static function getDefaultData(): array
    {
        return [
            'temperature' => 18,
            'temperature_min' => 12,
            'humidity' => 60,
            'weather_code' => 1,
            'weather_description' => 'Dades no disponibles',
            'wind_speed' => 10,
            'rain_probability' => 0,
            'is_rainy' => false,
        ];
    }
}
